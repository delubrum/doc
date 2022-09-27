<?php

class Sales {
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
            $stm = $this->pdo->prepare("SELECT a.*, b.username
            FROM sales a
            LEFT JOIN users b
            ON a.userId = b.id
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

    public function listDetail($id) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.description
            FROM sales_detail a
            LEFT JOIN products b
            ON a.productId = b.id
            WHERE saleId = $id
            ORDER BY b.id ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getId($id){
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM sales 
            WHERE id = $id
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getRefund($id){
        try {
            $stm = $this->pdo->prepare("SELECT *, b.username
            FROM refunds a
            LEFT JOIN users b
            ON a.userId = b.id
            WHERE saleId = $id
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($initial,$final){
        try {
            $stm = $this->pdo->prepare("SELECT sum(cash) as total
            FROM sales 
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

    public function InventoryGet($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM inventory WHERE productId = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function InventoryUpdate($qty,$productId) {
        try {
            $sql = "UPDATE inventory set qty = ? WHERE productId = ?";
            $this->pdo->prepare($sql)->execute(array($qty,$productId));
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($productId,$qty,$total_price,$price,$obs,$userId,$returned) {
        try {
            $sql = "INSERT INTO sales (cash,obs,userId,returned) VALUES (
                '$total_price',
                '$obs',
                '$userId',
                '$returned'
                )";
            $this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }

        $lastId = $this->pdo->lastInsertId();

        try {
            $sql = "INSERT INTO sales_detail (saleId,productId,qty,price) VALUES";
			foreach($productId as $k => $r){
				$sql.="('$lastId','$r','$qty[$k]','$price[$k]'),";
			}
			$sql=rtrim($sql,',');
			$this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
        foreach($productId as $k => $r){
            $inventory_qty = $qty[$k] - $this->InventoryGet($r)->qty;
            $this->InventoryUpdate($inventory_qty,$r);
        }
          
    }

    public function refund($saleId) {
        try {
            $sql = "UPDATE sales SET 
            cancelledAt = now()
            WHERE id = '$saleId'
            ";
            $this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

}