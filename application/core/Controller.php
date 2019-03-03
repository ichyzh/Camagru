<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/4/19
 * Time: 4:08 PM
 */

namespace application\core;

use application\core\View;


abstract class Controller
{

    public $route;
    public $view;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
    }

}