<?php

class CashBox {
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

    public function last($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM cashbox
            WHERE 1=1
            $filters
            ORDER BY id DESC 
            LIMIT 1 ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM cashbox 
            WHERE id = $id");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

}