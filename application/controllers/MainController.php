<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 12/16/18
 * Time: 2:13 PM
 */

namespace application\controllers;

use application\core\Controller;
use application\models\Main;
use application\models\User;

require_once ROOT_FOLD . '/application/config/gconf.php';
require_once ROOT_FOLD . '/application/config/fconf.php';

class MainController extends Controller
{
    public function actionIndex()
    {
        $logged['is_logged'] = User::checkCookies($_COOKIE);
        $id = User::getCurrentUser();
        $res = Main::getPhotos($id['id']);
        $this->view->render('Camagru', $logged, $res);
    }
}