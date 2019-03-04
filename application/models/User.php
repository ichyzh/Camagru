<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 12/14/18
 * Time: 1:17 PM
 */

namespace application\models;

require_once ROOT_FOLD . '/application/config/fconf.php';
require_once ROOT_FOLD . '/application/config/gconf.php';

use application\core\View;
use application\lib\Db;
use PDO;
use Exception;

class User
{
    private static function selectFromDatabaseByCol($col, $elem)
    {
        $dbh = new Db;
        $params = [
            $col => $elem
        ];
        $sql = "SELECT * FROM `users` WHERE $col" . "=" . "'$elem'";
        $query = $dbh->dbQuery($sql, $params);
        return $query;

    }
    public static function register($login, $pwd, $email, $img = null, $active = 0)
    {
        echo $login . " " . $pwd . " " . $email;
        $dbh = new Db;
        if (!$img) {
            $img = "private/images/default.jpg";
        }
        $pas = hash('whirlpool', $pwd);
        $hash = hash('whirlpool', $pwd . rand(10, 10000));
        $params = [
            'login' => "$login",
            'pwd' => "$pas",
            'email' => "$email",
            'img' => "$img",
            'active_hash' => "$hash",
            'adm' => "0",
            'notif' => "1",
            'activated' => "$active"
        ];
        $sql = "INSERT INTO `users`(login, passwd, email, usr_img, active_hash, adm, notif, activated)
              VALUES (:login, :pwd, :email, :img, :active_hash, :adm, :notif, :activated)";
        $dbh->dbQuery($sql, $params);
    }

    public static function sendMail($email, $subject, $message)
    {
        $encoding = "utf-8";
        // Set preferences for Subject field
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );

        $from_mail = "noreply@localhost.com";
        $from_name = "Camagru";
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: ".$from_name." <".$from_mail."> \r\n";
        $header .= "Reply-To: ". $from_mail . "\r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

        mail($email, $subject, $message, $header);
    }

    public static function sendVerifMail($email)
    {
        $query = User::selectFromDatabaseByCol("email", $email);

        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $subject = "Verify your e-mail";
            $message = "Hi,<br> <br>To verify you e-mail address click on this link http://localhost:8100/camaphp/verif?email=".$email."&token=".$result['active_hash']."<br>";
            User::sendMail($email, $subject, $message);
        }
    }

    public static function checkLoginRegister($login, $errors)
    {
        if (strlen($login) >= 2) {
            return $errors;
        }
        $errors["login"] = "Too short login";
        return $errors;
    }

    public static function checkLoginExists($login, $errors = [])
    {
        $res = User::selectFromDatabaseByCol("login", $login);
        if ($res->rowCount() <= 0)
            return $errors;
        $errors["d_login"] = "There are user with this login";
        return $errors;
    }

    public static function checkPasswordRegister($pwd, $pwd2, $errors)
    {
        if (strcmp($pwd, $pwd2) === 0) {
            if (strlen($pwd) >= 6)
                return $errors;
            $errors["pwd"] = "Too short password";
            return $errors;
        }
        $errors["pwd2"] = "Passwords don't match";
        return $errors;
    }

    public static function checkEmail($email, $errors = [])
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $errors;
        }
        $errors["email"] = "Invalid email";
        return $errors;
    }

    public static function checkEmailExists($email, $errors = [])
    {
        $res = User::selectFromDatabaseByCol("email", $email);
        if ($res->rowCount() <= 0)
            return $errors;
        $errors["d_email"] = "There are user with this email";
        return $errors;
    }

    public static function verifyEmail($arr)
    {
        $email = $arr['email'];
        $hash = $arr['token'];

        $active = 1;

        $res = User::selectFromDatabaseByCol("email", $email);

        if ($res->rowCount() >= 1) {
            $result = $res->fetch(PDO::FETCH_ASSOC);
            if ($result['activated'] === "0") {
                if ($result['active_hash'] === $hash) {
                    $dbh = new Db;
                    $params = [
                        'active' => "$active",
                        'email' => "$email"
                    ];
                    $req = "UPDATE `users` SET `activated` = :active WHERE `email` = :email";
                    $dbh->dbQuery($req, $params);
                    header("Location: http://localhost:8100/camaphp/");
                }
            }
        }
    }

    public static function checkUserLogining($login, $pwd, $errors = [])
    {
        $query = User::selectFromDatabaseByCol("login", $login);
        if ($query->rowCount() >= 1)
        {
            $res = $query->fetch(PDO::FETCH_ASSOC);
            if ($res['activated'] === "1") {
                $pass = hash('whirlpool', $pwd);
                if ($res['passwd'] === $pass) {
                    User::setCookies($login);
                    return $errors;
                }
                $errors["pwd"] = "Wrong Password";
                return $errors;
            }
            $errors['active'] = "Please verify your email";
            return $errors;
        }
        $errors["login"] = "User with this login doesn't exist";
        return $errors;
    }

    public static function setCookies($login) {
        $dbh = new Db;
        $sql = "SELECT * FROM `users` WHERE `login` = :login";
        $params = [
            "login" => "$login"
        ];
        $query = $dbh->dbQuery($sql, $params);
        $res = $query->fetch(PDO::FETCH_ASSOC);
        $profile_img = $res['usr_img'];
        $id = $res['id'];
        $hash = User::generateHash();
        $_SESSION['usr_img'] = $profile_img;
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $login;
        setcookie("login", $login, time()+86400);
        setcookie("avatar", $profile_img, time()+86400);
        setcookie("id", $id, time()+86400);
        setcookie("hash", $hash, time()+86400);
        $sql = "UPDATE `users` SET `active_hash` = :hash WHERE `id` = :id";
        $params = [
            "hash" => "$hash",
            "id" => "$id"
        ];
        $dbh->dbQuery($sql, $params);
    }

    public static function logout() {
        setcookie("id", "", time()-3600);
        setcookie("avatar", "", time()-3600);
        setcookie("hash", "", time()-3600);
        setcookie("login", "", time()-3600);
        session_unset();
        header("Location: /camaphp/");
    }

    public static function generateHash($length = 6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        $code = hash('whirlpool', $code);
        return $code;
    }

    public static function sendResetLink($email, $errors)
    {
        $query = User::selectFromDatabaseByCol("email", $email);

        if ($query->rowCount() >= 1)
        {
            $res = $query->fetch(PDO::FETCH_ASSOC);
            if ($res['activated'] === "1") {
                $token = $res['passwd'];
                $message = "Hi,<br> <br>To reset your password click on this link http://localhost:8100/camaphp/reset?email=" . $email . "&token=" . $token . "<br>";
                $subject = "Reset Password";
                User::sendMail($email, $subject, $message);
            }
        }
        else
            $errors["email"] = "Wrong e-mail";
        return $errors;
    }

    public static function checkEmailForPassword($arr)
    {
        $email = $arr['email'];
        $token = $arr['token'];

        $res = User::selectFromDatabaseByCol("email", $email);

        if ($res->rowCount() >= 1) {
            $result = $res->fetch(PDO::FETCH_ASSOC);
            if ($result['passwd'] === $token) {
                return true;
            }
        }
        return false;
    }

    public static function resetPassword($email, $pwd, $pwd2, $errors)
    {
        $query = User::selectFromDatabaseByCol('email', $email);

        if ($query->rowCount() >= 1) {
            if ($pwd === $pwd2) {
                $pass = hash('whirlpool', $pwd);
                $dbh = new Db;
                $params = [
                    'email' => "$email",
                    'pwd' => "$pass"
                ];
                $req = "UPDATE `users` SET `passwd` = :pwd WHERE `email` = :email";
                $dbh->dbQuery($req, $params);
                $errors['ok'] = "1";
            }
            else
                $errors['pwd'] = "Passwords don't match";
        }
        else
            $errors['fg'] = "sdh";
        return $errors;
    }
    public static function facebookOauth()
    {
        if (!$_GET['code']) {
            exit('error code');
        }

        $token = json_decode(file_get_contents('https://graph.facebook.com/v3.2/oauth/access_token?client_id=' . FID . '&redirect_uri=' . FURL . '&client_secret=' . FSECRET . '&code=' . $_GET['code']), true);

        if (!$token)
            exit('error token');

        $data = json_decode(file_get_contents('https://graph.facebook.com/v3.2/me?client_id=' . FID . '&redirect_uri=' . FURL . '&client_secret=' . FSECRET . '&code=' . $_GET['code'] . '&access_token=' . $token['access_token'] . '&fields=id,first_name,last_name,picture,email'), true);

        if (!$data)
            exit('error data');
        $img = false;
        if (!$data['picture']['data']['is_silhouette'])
            $img  = 'https://graph.facebook.com/v3.2/' . $data['id'] . '/picture?width=400&height=400';
        $email = $data['email'];
        $login = $data['first_name'] . "." . $data['last_name'];

        User::socialAuth($login, $email, $img);
    }

    public static function googleOauth()
    {
        if(isset($_GET['code'])) {
            try {
                $data = static::GetGoogleAccessToken(GCLIENT_ID, GCLIENT_REDIRECT_URL, GCLIENT_SECRET, $_GET['code']);
                $user_info = static::GetGoogleUserProfileInfo($data['access_token']);

                $email = $user_info['emails'][0]['value'];
                $login = lcfirst($user_info['name']['familyName']) . "_" . lcfirst($user_info['name']['givenName']);
                if ($user_info['image']['isDefault']) {
                    $img = null;
                } else {
                    $img = $user_info['image']['url'];
                }
                User::socialAuth($login, $email, $img);
            }
            catch(Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }
    }

    public static function GetGoogleAccessToken($client_id, $redirect_uri, $client_secret, $code)
    {
        $url = 'https://accounts.google.com/o/oauth2/token';

        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = json_decode(curl_exec($ch), TRUE);
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        if($http_code != 200)
            throw new Exception('Error : Failed to receieve access token');

        return $data;
    }

    public static function GetGoogleUserProfileInfo($token) {

        $url = 'https://www.googleapis.com/plus/v1/people/me';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $token));
        $data = json_decode(curl_exec($ch), TRUE);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($http_code != 200)
            throw new Exception('Error : Failed to get user information');
        return $data;
    }

    public static function socialAuth($login, $email, $img = NULL)
    {
        $res = User::selectFromDatabaseByCol("email", $email);
        $pwd = User::generateHash();
        if ($res->rowCount() <= 0) {
            User::register($login, $pwd, $email, $img,  1);
            User::setCookies($login);
            echo "fffff";
        } else {
            $dbh = new Db();
            $sql = "SELECT `login` FROM `users` WHERE `email`='{$email}'";
            $res = $dbh->row($sql);
            User::setCookies($res['login']);
            echo 444444;
        }
    }

    public static function getCurrentUser() {
        if (User::checkCookies($_COOKIE)) {
            $user['id'] = $_COOKIE['id'];
            $sql = "SELECT `adm` FROM `users` WHERE `id`='{$_COOKIE['id']}'";
            $dbh = new Db();
            $res = $dbh->row($sql);
            $user['adm'] = $res['adm'];
            return $user;
        }
        return false;
    }

    public static function checkCookies($cookies) {
        if (isset($cookies['id']) && isset($cookies['hash'])) {
            $query = User::selectFromDatabaseByCol("id", $_COOKIE['id']);
            if ($query->rowCount() <= 0) {
                return false;
            }
            $res = $query->fetch(PDO::FETCH_ASSOC);
            if ($res['active_hash'] != $cookies['hash']) {
                return false;
            }
            return true;
        }
        return false;
    }

    public static function sendNotif($message, $subject, $uid) {
        $dbh = new Db();
        $sql = "SELECT `email`, `notif` FROM `users` WHERE `id`=" . $uid;
        $query = $dbh->dbQuery($sql);
        $res = $query->fetch(PDO::FETCH_ASSOC);
        if ($res['notif'] === "1") {
            User::sendMail($res['email'], $subject, $message);
        }
    }

    public static function changeLogin($new_login) {
        $new_login = htmlspecialchars($new_login);
        $id = User::getCurrentUser();
        $errors = User::checkLoginExists($new_login);
        if (!empty($errors)) {
            return false;
        }
        if ($id['id']) {
            $dbh = new Db();
            $params = [
                "id" => $id['id'],
                "new_login" => $new_login
            ];
            $sql = "UPDATE `users` SET `login` = :new_login WHERE `id`= :id";
            $dbh->dbQuery($sql, $params);
            $_COOKIE["login"] = $new_login;
            return true;
        }
        return false;
    }

    public static function changePassword($oldpw, $newpw, $reppw) {
        $id = User::getCurrentUser();
        if (!$id) {
            return false;
        }
        $sql = "SELECT `login` FROM `users` WHERE `id`= '{$id['id']}'";
        $dbh = new Db();
        $res = $dbh->row($sql);
        $login = $res['login'];
        $errors = User::checkUserLogining($login, $oldpw);
        if (!empty($errors)) {
            return false;
        }
        if ($newpw !== $reppw) {
            return false;
        }
        $pas = hash('whirlpool', $newpw);
        $sql = "UPDATE `users` SET `passwd`= :pwd WHERE `id` = :id";
        $params = [
            "pwd" => $pas,
            "id" => $id['id']
        ];
        $dbh->dbQuery($sql, $params);
        return true;
    }

    public static function changeEmail($new_email) {
        $id = User::getCurrentUser();
        if(!$id) {
            return false;
        }
        $errors = User::checkEmail($new_email);
        $errors = User::checkEmailExists($new_email, $errors);
        if (!empty($errors)) {
            return false;
        }
        $dbh = new Db();
        $sql = "UPDATE `users` SET `email` = :new_email WHERE `id`= :id";
        $params = [
            "id" => $id['id'],
            "new_email" => $new_email
        ];
        $dbh->dbQuery($sql, $params);
        return true;
    }

    public static function notifications() {
        $id = User::getCurrentUser();
        $dbh = new Db();
        if(!$id) {
            return false;
        }
        $sql = "SELECT `notif` FROM `users` WHERE `id`='{$id['id']}'";
        $res = $dbh->row($sql);
        if ($res['notif'] === "1") {
            $sql = "UPDATE `users` SET `notif`='0' WHERE `id`='{$id['id']}'";
            $dbh->dbQuery($sql);
        }
        elseif ($res['notif'] === "0") {
            $sql = "UPDATE `users` SET `notif`='1' WHERE `id`='{$id['id']}'";
            $dbh->dbQuery($sql);
        }
    }

    public static function deleteAccount($id) {
        $current_id = User::getCurrentUser();
        if(!$current_id) {
            return false;
        }
        $dbh = new Db();
        $sql = "SELECT `adm` FROM `users` WHERE `id`='{$current_id['id']}'";
        $res = $dbh->row($sql);
        if (strcmp($current_id['id'], $id) || $res['adm'] == 1) {
            $sql = "SELECT * FROM `photos` WHERE `user_id`='{$id}'";
            $res = $dbh->all($sql);
            foreach ($res as $key => $val) {
                $dbh->delete("likes", "photo_id", $val['id']);
                $dbh->delete("comments", "photo_id", $val['id']);
            }
            $dbh->delete("users", "id", $id);
            $dbh->delete("photos", "user_id", $id);
            $dbh->delete("likes", "user_id", $id);
            $dbh->delete("comments", "user_id", $id);
            $url = "http://localhost:8100/" . ROOT;
            echo json_encode(["resp" => $url]);
        }
    }

    public static function deletePhoto($id) {
        $dbh = new Db();
        $sql = "SELECT `src` FROM `photos` WHERE `id`='{$id}'";
        $src = $dbh->row($sql);
        unlink($src['src']);
        $dbh->delete("photos", "id", $id);
        $dbh->delete("likes", "photo_id", $id);
        $dbh->delete("comments", "photo_id", $id);
    }

    public static function getUser($login) {
        $sql = "SELECT `id` FROM `users` WHERE `login`= '{$login}'";
        $dbh = new Db();
        $user = $dbh->row($sql);
        return $user['id'];
    }

    public static function changePicture($phid) {
        $current_id = User::getCurrentUser();
        if(!$current_id) {
            return false;
        }
        $sql = "SELECT `src` FROM `photos` WHERE `id`='{$phid}'";
        $dbh = new Db();
        $src = $dbh->row($sql);
        $sql = "UPDATE `users` SET `usr_img`='{$src['src']}' WHERE `id`='{$current_id['id']}'";
        $dbh->dbQuery($sql);
        setcookie("avatar", "", time()-3600);
        setcookie("avatar", $src['src'], time()+86400);
    }

    public static function checkNotif($id) {
        $dbh = new Db();
        $sql = "SELECT `notif` FROM `users` WHERE `id`='{$id}'";
        $res = $dbh->row($sql);
        if ($res['notif'] == 1) {
            return "checked";
        } else {
            return "";
        }
    }

}