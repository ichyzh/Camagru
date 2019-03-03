<?php

namespace application\lib;

use PDO;

class Db
{
    protected $dbh;

    public function __construct()
    {
        require ROOT_FOLD .'/application/config/database.php';
        try {
            $this->dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (\PDOException $e) {
            $this->err = 1;
        }
    }
//    public function getDbConnection() {
//
//        include ROOT.'/config/database.php';
//
//        $this->dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//
////        return $dbh;
//    }

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