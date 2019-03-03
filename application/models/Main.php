<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/23/19
 * Time: 4:46 PM
 */

namespace application\models;
use application\lib\Db;


class Main
{
    public static function getPhotos($id) {
        if (!$id)
            $id = 0;
        $dbh = new Db;
        $sql = "SELECT users.id AS `uid`, photos.id AS `phid`, photos.src, users.login, users.usr_img, users.adm
                FROM `photos`
                INNER JOIN users ON users.id = photos.user_id
                ORDER BY photos.id ASC";
        $res = $dbh->all($sql);
        foreach ($res as $k => $v) {
            $sql = "SELECT * FROM `likes` WHERE `user_id` = $id AND `photo_id` =" . $v['phid'];
            $result = $dbh->dbQuery($sql);
            if ($result->rowCount() > 0) {
                $res[$k]['liked'] = true;
            } else {
                $res[$k]['liked'] = false;
            }
            $res[$k] = Main::addLikesAndComments($res[$k], $v['phid'], "likes", "likes_count");
            $res[$k] = Main::addLikesAndComments($res[$k], $v['phid'], "comments", "comments_count");
        }
        $res = Main::concatComments($res);
        return $res;
    }

    public static function concatComments($res) {
        foreach ($res as $k => $v) {
            $dbh = new Db();
            $sql = "SELECT `message`, `user_id` FROM `comments` WHERE `photo_id` =" . $v['phid'];
            $query = $dbh->dbQuery($sql);
            if ($query->rowCount() > 0) {
                $i = 0;
                $arr = [];
                while ($result = $query->fetch(\PDO::FETCH_ASSOC)) {
                    if ($result['user_id']) {
                        $sql_user_data = "SELECT `login`, `usr_img` FROM `users` WHERE `id`=" . $result['user_id'];
                        $result_user_data = $dbh->row($sql_user_data);
                        $arr[$i] = [
                            "usr_login" => $result_user_data['login'],
                            "usr_img" => $result_user_data['usr_img'],
                            "text" => $result['message']
                        ];
                        $res[$k]['comments'] = $arr;
                    }
                    $i++;
                }
            }
        }
        return $res;
    }

    public static function addLikesAndComments($res, $photo_id, $table, $todo) {
        $dbh = new Db();
        $sql = "SELECT * FROM `{$table}` WHERE `photo_id` = '{$photo_id}'";
        $query = $dbh->dbQuery($sql);
        if ($query->rowCount() > 0) {
            $res[$todo] = $query->rowCount();
        } else {
            $res[$todo] = "";
        }
        return $res;
    }
}