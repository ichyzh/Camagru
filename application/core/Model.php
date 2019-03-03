<?php
/**
 * Created by PhpStorm.
 * User: ichyzh
 * Date: 2/26/19
 * Time: 2:46 PM
 */

namespace application\core;
use application\lib\Db;

abstract class Model
{
    public $dbh;

    public function __construct()
    {
        $this->dbh = new Db();
    }
}