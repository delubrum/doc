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
            ORDER BY a.id DESC
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
            ORDER BY name ASC
            ");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function search($id) {
        try {
        $stm = $this->pdo->prepare("SELECT a.*, LPAD(a.id,7,'0') as code
        FROM products a
        WHERE LPAD(a.id,7,'0') = ?
        and active = 1
        ORDER BY id ASC");
        $stm->execute(array($id));
        return $stm->fetch(PDO::FETCH_OBJ);
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