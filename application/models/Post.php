<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/25/19
 * Time: 4:46 PM
 */

namespace application\models;
use application\core\Model;
use application\lib\Db;


class Post extends Model
{
    public static function addLike($photo_id) {
        $uid = $_COOKIE['id'];
        $params = [
            "uid" => $uid,
            "phid" => $photo_id
        ];

        $sql = "SELECT * FROM `likes` WHERE `photo_id`=" . $photo_id . " AND `user_id`=" . $uid;
        $dbh = new Db();
        $query = $dbh->dbQuery($sql);
        if ($query->rowCount() <= 0) {
            $res = $dbh->dbQuery("INSERT INTO `likes` (`photo_id`, `user_id`) VALUES
                    (:phid, :uid)", $params);
            User::sendNotif("You have new like on your photo", "You have new like", $_COOKIE['id']);
            return 1;
        } else {
            $sql = "DELETE FROM `likes` WHERE `photo_id`= " . $photo_id . " AND `user_id`= " . $uid;
            $dbh->dbQuery($sql, $params);
            return 0;
        }
    }

    public static function addComment($uid, $photo_id, $comment) {
        $res = [];
        if ($comment != ""){
            $comment = htmlspecialchars($comment);
            Post::saveComment($uid, $photo_id, $comment);
            $dbh = new Db();
            $sql = "SELECT `login`, `usr_img` FROM `users` WHERE `id`=" . $uid;
            $query = $dbh->dbQuery($sql);
            $res = $query->fetch(\PDO::FETCH_ASSOC);
            $res['text'] = $comment;
            $res['root'] = ROOT . "/";
            return $res;
        }
        $res['error'] = "empty";
        return $res;
    }

    public static function saveComment($uid, $photo_id, $comment) {
        $params = [
            "uid" => $uid,
            "photo_id" => $photo_id,
            "message" => $comment
        ];
        $sql = "INSERT INTO `comments` (`photo_id`, `user_id`, `message`) VALUES
                (:photo_id, :uid, :message)";
        $dbh = new Db();
        $dbh->dbQuery($sql, $params);
        $sql = "SELECT `user_id` AS `id` FROM `photos` WHERE `id` = $photo_id";
        $query = $dbh->dbQuery($sql);
        $res = $query->fetch(\PDO::FETCH_ASSOC);
        User::sendNotif("You have new comment on your photo", "You have new comment", $res['id']);
    }
}