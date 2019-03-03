<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/4/19
 * Time: 4:24 PM
 */

namespace application\core;
use application\models\User;

require_once ROOT_FOLD . '/application/config/fconf.php';
require_once ROOT_FOLD . '/application/config/gconf.php';

class View
{
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($title, $logged, $vars = [])
    {
//        $current_id = User::getCurrentUser();
        $file = 'application/views/' . $this->path . '.php';
        if (file_exists($file)) {
            ob_start();
            require $file;
            $content = ob_get_clean();
            require 'application/views/layouts/' . $this->layout . '.php';
        } else {
            echo $file;
            echo "VIEW DON'T FOUND";
        }
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        $file = 'application/views/errors/' . $code . '.php';
        if (file_exists($file)) {
            require $file;
        }
        exit;
    }

    public function redirect($url)
    {
        header("Location: " . $url);
    }
}