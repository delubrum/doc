<?php

class Purchases {
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

    public function list($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.description, c.name
            FROM purchases a
            LEFT JOIN products b
            ON a.productId = b.id
            LEFT JOIN products_categories c
            ON b.categoryId = c.id
            WHERE 1=1
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


    public function get($initial,$final){
        try {
            $stm = $this->pdo->prepare("SELECT sum(price*qty) as total
            FROM purchases 
            WHERE createdAt >= ?
            AND createdAt <= ? 
            AND cancelledAt is null
            ");
            $stm->execute(array($initial,$final));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getQty($productId){
        try {
            $stm = $this->pdo->prepare("SELECT sum(qty) as total
            FROM purchases
            WHERE productId = '$productId'
            AND cancelledAt is null
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }


}