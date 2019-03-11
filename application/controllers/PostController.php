<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/25/19
 * Time: 4:42 PM
 */

namespace application\controllers;
use application\core\Controller;
use application\models\Post;
use application\models\User;
use application\core\View;


class PostController extends Controller
{
    public function actionLike() {
        if (isset($_POST['photo_id'])) {
            $check = User::checkCookies($_COOKIE);
            if ($check) {
                if (Post::addLike($_POST['photo_id'])) {
                    echo 1;
                    return ;
                } else {
                    echo 0;
                    return ;
                }
            }
            echo 0;
            return ;
        } else {
            View::errorCode(404);
        }
    }
    public function actionComment() {
        $arr = [];
        if (isset($_POST['photo_id']) && isset($_POST['comment'])) {
            if ($userid = User::getCurrentUser()) {
                $arr = Post::addComment($userid['id'], $_POST['photo_id'], $_POST['comment']);
                echo json_encode($arr);
                return ;
            }
            $arr['error'] = "must login";
            echo json_encode($arr);
            return ;
        } else {
            View::errorCode(404);
        }
    }
}