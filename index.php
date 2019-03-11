<?php

    session_start();

    use application\core\Router;

    define('ROOT_FOLD', dirname(__FILE__));

    spl_autoload_register(function($class){
        $path = str_replace('\\', '/', $class . '.php');
        if (file_exists($path))
            require $path;
    });
    $router = new Router();
    $router->run();