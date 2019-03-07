<?php

namespace application\models;
use application\lib\Db;
use PDO;



class Camera
{
    public static function addMask($main_photo, $watermark = []) {
        $newimage = imagecreatefromstring($main_photo);
        $image = imagescale($newimage, 640, 480);
        foreach ($watermark as $key => $val) {
            $wm = imagecreatefrompng($val->src);
            $wmW=imagesx($wm);
            $wmH=imagesy($wm);
            imagecopy($image, $wm, $val->left, $val->top, 0, 0, $wmW, $wmH);
            imagedestroy($wm);
        }
        $arr = Camera::setPathToPhoto();
        imagepng($image, $arr['path']);
        Camera::saveImageToDb($arr['path'], $_COOKIE['id']);
        imagedestroy($image);
        imagedestroy($newimage);
        return $arr;
    }

    public static function saveImageToDb($path, $uid) {
        $dbh = new Db();
        $params = [
            "path" => "$path",
            "uid" => "$uid"
        ];
        $sql = "INSERT INTO `photos` (user_id, src)
                VALUES (:uid, :path)";
        $dbh->dbQuery($sql, $params);
    }

    public static function setPathToPhoto() {
        $id = [];
        $path = "private/images/";
        $dbh = new Db();
        $sql = "SELECT `id` FROM `photos`";
        $query = $dbh->dbQuery($sql);
        if ($query->rowCount() < 1) {
            $id['id'] = 1;
            $path = $path . '1' . '.png';
        } else {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $id = end($result);
            $id['id']++;
            $path = $path . $id['id'] . '.png';
        }
        $arr = [
            'path' => $path,
            'id' => $id['id']
        ];
        return $arr;
    }
}