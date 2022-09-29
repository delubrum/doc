<?php
class Database
{
    public static function Conectar()
    {
        $timezone = "America/Bogota";
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=dbname;charset=utf8', 'user', 'pass');
        $pdo->exec("SET time_zone = '{$timezone}'");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}