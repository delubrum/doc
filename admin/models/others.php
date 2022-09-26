<?php

class Others {
    private $pdo;
    public function __CONSTRUCT() {
        try {
            $this->pdo = Database::Conectar();
            $pdo = null;
        }
            catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function list($filters = '', $type) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.username
            FROM others a
            LEFT JOIN users b
            ON a.userId = b.id
            WHERE type = '$type'
            $filters
            ORDER BY a.id DESC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($item) {
        try {
            $stm = $this->pdo->prepare("SELECT sum(price) as total 
            FROM others 
            WHERE created_at >= '$item->initial'
            AND created_at <= '$item->final'
            AND type = $item->type");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

}