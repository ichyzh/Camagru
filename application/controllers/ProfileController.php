<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/27/19
 * Time: 1:55 PM
 */

namespace application\controllers;


use application\core\Controller;
use application\core\View;
use application\lib\Db;
use application\models\Profile;
use application\models\User;

class ProfileController extends Controller
{
    public function actionProfile() {
        $logged['this_user'] = false;
        $user = User::getCurrentUser();
        $logged['is_logged'] = User::checkCookies($_COOKIE);
        $notif = User::checkNotif($user['id']);
        $logged['checked'] = $notif;
        $login = $this->route['profile'];
        $id = User::getUser($login);
        if (!$id) {
            View::errorCode(404);
        }
        if (isset($user['id']) && strcmp($user['id'], $id) === 0) {
            $logged['this_user'] = true;
        }
        if (isset($user['id']) && isset($user['adm'])) {
            $logged['del_id'] = $id;
            $logged['adm'] = $user['adm'];
            $res = Profile::getUserPhotos($id);
            $this->view->render("Profile",$logged, $res);
        } else {
            View::errorCode(404);
        }
    }
}