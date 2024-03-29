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
            $stm = $this->pdo->prepare("SELECT a.*, b.description, LPAD(b.id,7,'0') as code
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

    public function getRefunds($id){
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

    public function listRefunds($id) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM refunds_detail
            WHERE productId = $id
            ORDER BY id ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function SumRefunds($saleId,$productId){
        try {
            $stm = $this->pdo->prepare("SELECT sum(qty) as total
            FROM refunds_detail
            WHERE saleId = '$saleId'
            AND productId = '$productId';
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
            FROM sales_detail
            WHERE productId = '$productId'
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($productId,$qty,$total_price,$price,$obs,$userId,$returned,$discount,$card,$total_cupons,$cupons,$cuponsPrice,$cashReal,$payTotal) {
        try {
            $sql = "INSERT INTO sales (total,cash,card,ticket,obs,userId,returned,discount,cashReal) VALUES (
                '$payTotal',
                '$total_price',
                '$card',
                '$total_cupons',
                '$obs',
                '$userId',
                '$returned',
                '$discount',
                '$cashReal'
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

        try {
            $sql = "INSERT INTO tickets_detail (saleId,ticketId,price) VALUES";
			foreach($cupons as $k => $r){
				$sql.="('$lastId','$r','$cuponsPrice[$k]'),";
			}
			$sql=rtrim($sql,',');
			$this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }   
        
        return $lastId;
    }


    public function refundSave($saleId,$cause,$userId,$total,$productId,$price,$qty){
        try {
            $sql = "INSERT INTO refunds (saleId,cause,userId,price) VALUES (
            '$saleId',
            '$cause',
            '$userId',
            '$total'
            )";
			$this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }

        $lastId = $this->pdo->lastInsertId();

        try {
            $sql = "INSERT INTO refunds_detail (refundId,saleId,productId,price,qty) VALUES";
			foreach($productId as $k => $r){
				$sql.="('$lastId','$saleId','$r','$price[$k]','$qty[$k]'),";
			}
			$sql=rtrim($sql,',');
			$this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }


}