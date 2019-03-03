<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 12/14/18
 * Time: 12:39 PM
 */

namespace application\core;


class Router
{
    protected $routes = [];
    protected $params = [];
    protected $root;

    public function __construct()
    {
        $site = explode("/", $_SERVER['REQUEST_URI']);
        define('ROOT', $site[1]);
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params)
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = substr($_SERVER['REQUEST_URI'], strlen('/' . ROOT . '/'));
        if (($cutoff = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $cutoff);
        }
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (strlen($match) != 0) {
                        if (is_numeric($key)) {
                            $str = explode("/", $match);
                            if ($str[0] == "profile") {
                                $params[$str[0]] = $str[1];
                            }
                        }
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if (!$this->match()) {
            View::errorCode(404);
        }
        $classpath = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
        if (class_exists($classpath)) {
            $action = 'action' . ucfirst($this->params['action']);
            if (!method_exists($classpath, $action)) {
                View::errorCode(404);
            } else {
                $controller = new $classpath($this->params);
                $controller->$action();
            }
        }
        else
            View::errorCode(404);

    }
}