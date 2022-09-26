<?php

class Products {
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
            $stm = $this->pdo->prepare("SELECT a.*, LPAD(a.id,7,'0') as code, b.name as categoryname
            FROM products a
            LEFT JOIN products_categories b
            ON a.categoryId = b.id
            WHERE 1=1
            $filters
            ORDER BY b.id, a.description DESC
            ");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function listCategory($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM products_categories
            WHERE 1=1
            $filters
            ORDER BY name DESC
            ");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function productsByCategory($id) {
        try {
        $stm = $this->pdo->prepare("SELECT *, b.qty as iqty
        FROM products a
        LEFT JOIN inventory b
        ON a.id = b.productId
        WHERE categoryId = $id
        ORDER BY id ASC");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch (Exception $e) {
        die($e->getMessage());
        }
    }

    public function active($val,$id) {
        try {
            $sql = "UPDATE products set active = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($val,$id));
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id){
        try {
            $stm = $this->pdo->prepare("SELECT a.*, LPAD(a.id,7,'0') as code, b.name as categoryname
            FROM products a
            LEFT JOIN products_categories b
            ON a.categoryId = b.id
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}