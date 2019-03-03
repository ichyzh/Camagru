<?php

    session_start();

    use application\core\Router;
    ini_set('display_errors', 1);
    error_reporting(E_ALL);


    define('ROOT_FOLD', dirname(__FILE__));

    spl_autoload_register(function($class){
        $path = str_replace('\\', '/', $class . '.php');
        if (file_exists($path))
            require $path;
    });
    $router = new Router();
    $router->run();