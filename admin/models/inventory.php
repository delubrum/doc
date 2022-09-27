<?php

class Inventory {
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
            $stm = $this->pdo->prepare("SELECT *
            FROM inventory a
            LEFT JOIN products b
            ON a.productId = b.id
            LEFT JOIN products_categories c
            ON b.categoryId = c.id
            WHERE 1=1
            $filters
            ORDER BY c.id,b.description ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM inventory 
            WHERE productId = $id");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

}