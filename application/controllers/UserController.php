<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 12/14/18
 * Time: 1:16 PM
 */

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\models\User;


class UserController extends Controller
{
    public function actionRegister() {
        if (isset($_POST['submit'])) {
            $login = htmlspecialchars($_POST['login']);
            $pwd = htmlspecialchars($_POST['pwd']);
            $pwd2 = htmlspecialchars($_POST['pwd2']);
            $email = htmlspecialchars($_POST['email']);

            $errors = false;

            $errors = User::checkLoginRegister($login, $errors);
            $errors = User::checkLoginExists($login, $errors);
            $errors = User::checkEmail($email, $errors);
            $errors = User::checkPasswordRegister($pwd, $pwd2, $errors);
            $errors = User::checkEmailExists($email, $errors);
            if ($errors)
                echo json_encode($errors);
            else {
                User::register($login, $pwd, $email);
                User::sendVerifMail($email);
            }
        } else
            echo "ti sho";
    }

    public function actionVerify() {
        User::verifyEmail($_GET);
    }

    public function actionLogin() {
        if (isset($_POST['submit'])) {
            $login = htmlspecialchars($_POST['login']);
            $pwd = htmlspecialchars($_POST['pwd']);

            $errors = false;

            $errors = User::checkUserLogining($login, $pwd, $errors);

            echo json_encode($errors);
        }
    }

    public function actionLogout() {
        User::logout();
    }

    public function actionSendReset() {
        if (isset($_POST['submit'])) {
            $email = htmlspecialchars($_POST['email']);

            $errors = false;

            $errors = User::sendResetLink($email, $errors);

            echo json_encode($errors);
        }

        elseif (!empty($_GET)) {
            if (User::checkEmailForPassword($_GET)) {
                $this->view->render('Reset Page', false);
            }
            else
                View::errorCode(404);
        }
        else
            View::errorCode(404);
    }

    public function actionResetPwd() {
        $errors = false;

        if (isset($_POST['submit'])) {
            $pwd = htmlspecialchars($_POST['pwd']);
            $pwd2 = htmlspecialchars($_POST['pwd2']);
            $email = htmlspecialchars($_POST['email']);
            $errors = User::resetPassword($email, $pwd, $pwd2, $errors);
        }
        echo json_encode($errors);
    }

    public function actionFacebookOauth() {
        if (!empty($_GET['code'])) {
            User::facebookOauth();
        }
        echo json_encode("ok");
    }

    public function actionGoogleOauth() {
        if (!empty($_GET['code'])){
            User::googleOauth();
            echo "ok";
        }
    }

    public function actionChangeLogin() {
        if (isset($_POST['new_login']) && $_POST['new_login'] != "") {
            if (User::changeLogin($_POST['new_login'])) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }

    public function actionChangePassword() {
        if (isset($_POST['old_pw']) && isset($_POST['new_pw']) && isset($_POST['rep_pw']) && isset($_POST['submit'])) {
            if (User::changePassword($_POST['old_pw'], $_POST['new_pw'], $_POST['rep_pw'])) {
                echo 1;
            } else {
                echo 2;
            }
        } else
            View::errorCode(403);
    }

    public function actionChangeEmail() {
        if (!isset($_POST['submit'])) {
            View::errorCode(403);
        }
        if (isset($_POST['new_email'])) {
            if (User::changeEmail($_POST['new_email'])) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }

    public function actionNotification() {
        if (!isset($_POST['submit'])) {
            View::errorCode(403);
        } else {
            User::notifications();
        }
    }

    public function actionDeleteAcc() {
        if (!isset($_POST['submit']) || !isset($_POST['id'])) {
            View::errorCode(403);
        } else {
            User::deleteAccount($_POST['id']);
        }
    }

    public function actionDeletePhoto() {
        if (!isset($_POST['submit']) || !isset($_POST['phid'])) {
            View::errorCode(403);
        } else {
            User::deletePhoto($_POST['phid']);
            echo json_encode("ok");
        }
    }

    public function actionChangePicture() {
        if (!isset($_POST['submit']) || !isset($_POST['phid'])) {
            View::errorCode(403);
        } else {
            User::changePicture($_POST['phid']);
        }
    }
}