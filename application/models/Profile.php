<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/27/19
 * Time: 1:55 PM
 */

namespace application\models;


use application\lib\Db;

class Profile
{
    public static function getUserPhotos($id, $pag) {
        $dbh = new Db();
        $sql = "SELECT `login`, `usr_img` FROM `users` WHERE `id`= '{$id}'";
        $res = $dbh->row($sql);
        $login = $res['login'];
        $usr_img = $res['usr_img'];
        $sql = "SELECT * FROM `photos` WHERE `user_id`='{$id}' LIMIT {$pag['this_page_result']}, {$pag['number_of_posts']}";
        $res = $dbh->all($sql);
        $current_user_id = User::getCurrentUser();
        if (empty($res)) {
            $res['empty'] = true;
            $res[0]['login'] = $login;
            $res[0]['usr_img'] = $usr_img;
        } else {
            foreach ($res as $k => $v) {
                $res[$k]['login'] = $login;
                $res[$k]['usr_img'] = $usr_img;
                $sql = "SELECT * FROM `likes` WHERE `user_id` = '{$current_user_id['id']}' AND `photo_id` = '{$v['id']}'";
                $result = $dbh->dbQuery($sql);
                if ($result->rowCount() > 0) {
                    $res[$k]['liked'] = true;
                } else {
                    $res[$k]['liked'] = false;
                }
                $res[$k] = Profile::addLikesAndComments($res[$k], $v['id'], "likes", "likes_count");
                $res[$k] = Profile::addLikesAndComments($res[$k], $v['id'], "comments", "comments_count");
            }
            $res = Profile::concatComments($res);
        }
        return $res;
    }

    public static function concatComments($res) {
        foreach ($res as $k => $v) {
            $dbh = new Db();
            $sql = "SELECT `message`, `user_id` FROM `comments` WHERE `photo_id` =" . $v['id'];
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

    public static function pagination($id) {
        $pagination = [];
        $number_of_posts = 6;
        $dbh = new Db();
        $sql = "SELECT * FROM `photos` WHERE `user_id`='{$id}'";
        $res = $dbh->dbQuery($sql);
        $number_of_photos = $res->rowCount();
        $number_of_pages = ceil($number_of_photos/$number_of_posts);
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $this_page_result = ($page - 1)*$number_of_posts;
        $pagination = [
            'number_of_pages' => $number_of_pages,
            'number_of_posts' => $number_of_posts,
            'this_page_result' => $this_page_result
        ];
        return $pagination;
    }
}