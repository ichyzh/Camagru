<?php

namespace application\lib;

use PDO;

class Db
{
    protected $dbh;

    public function __construct()
    {
        $conf = require ROOT_FOLD .'/application/config/database.php';
        try {
            $this->dbh = new PDO($conf['db_dsn'] . $conf['db_name'], $conf['db_user'], $conf['db_password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (\PDOException $e) {
            if ($e->getCode() === 1049) {
                require ROOT_FOLD . '/application/config/setup.php';
                header("Location: /" . ROOT);
            }
        }
    }

    public function dbQuery($sql, $params = [])
    {
        $stmt = $this->dbh->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = []) {
        $result = $this->dbquery($sql, $params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function all($sql, $params = []) {
        $result = $this->dbquery($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($from, $where, $id) {
        $sql = "DELETE FROM `$from` WHERE `$where`= '{$id}'";
        $this->dbQuery($sql);
    }
}
