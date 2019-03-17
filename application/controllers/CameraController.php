<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/15/19
 * Time: 3:10 PM
 */

namespace application\controllers;
use application\core\Controller;
use application\models\Camera;
use application\models\User;
use application\core\View;


class CameraController extends Controller
{
    public function actionCamera() {
        $logged['is_logged'] = User::checkCookies($_COOKIE);
        if ($logged['is_logged']) {
            $this->view->render('Camera', $logged);
        } else {
            View::errorCode(404);
        }
    }
    public function actionWatermark() {
        $photo = null;
        if (isset($_POST)) {
            $data = json_decode($_POST['data']);
            $main_photo = substr($data->main_photo, strpos($data->main_photo, ",") + 1);
            $main_photo = str_replace(" ", "+", $main_photo);
            $main_photo = base64_decode($main_photo);
            $watermark = $data->watermark;
            $photo = Camera::addMask($main_photo, $watermark);
        }
        echo json_encode($photo);
    }
}