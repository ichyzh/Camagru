<?php
 include 'database.php';


    try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
        exit;
    }

    $sql = "CREATE DATABASE IF NOT EXISTS `camagrudb`";
    $dbh->exec($sql);


    $sql = "CREATE TABLE IF NOT EXISTS `users` (
                `id` INT (11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `login` VARCHAR (255) NOT NULL,
                `passwd` VARCHAR (255) NOT NULL,
                `email` VARCHAR (512) NOT NULL,
                `fb_id` VARCHAR(512),
                `google_id` VARCHAR(512),
                `intra_id` VARCHAR(512),
                `usr_img` VARCHAR (512),
                `active_hash` VARCHAR(512) NOT NULL,
                `adm`	INT (1) NOT NULL,
                `notif` INT(1) NOT NULL,
                `activated` INT(1) NOT NULL
        );";

    $dbh->exec($sql);

    $res = $dbh->query('SELECT * FROM `users`');
    $pass = hash('whirlpool', 42424242);
    if ($res->rowCount() <= 0) {
        $query = $dbh->prepare('INSERT INTO `users`(login, passwd, email, usr_img, active_hash, adm, notif, activated)
              VALUES (:login, :pwd, :email, :img, :active_hash, :adm, :notif, :activated)');
        $query->execute([
            'login' => 'admin',
            'pwd' => "$pass",
            'email' => 'ichyzh@ukr.net',
            'img' => 'https://wallpapers.wallhaven.cc/wallpapers/full/wallhaven-721562.jpg',
            'active_hash' => '11111',
            'adm' => '1',
            'notif' => '1',
            'activated' => '1'
        ]);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `photos` (
                `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `user_id` INT(11) NOT NULL,
                `src` VARCHAR(512) NOT NULL 
        );";
    $dbh->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `comments` (
                `photo_id` INT(11) NOT NULL,
                `user_id` INT(11) NOT NULL,
                `message` VARCHAR(1024) NOT NULL
        );";
    $dbh->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS `likes` (
                `photo_id` INT(11) NOT NULL,
                `user_id` INT(11) NOT NULL
        );";
    $dbh->exec($sql);



