<?php

class Tickets {
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
            $stm = $this->pdo->prepare("SELECT a.*
            FROM tickets a
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

    public function get($id){
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM tickets
            WHERE LPAD(id,7,'0') = '$id'           
            AND expiresAt >= CURDATE()
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function sumPrice($id){
        try {
            $stm = $this->pdo->prepare("SELECT sum(price) as total
            FROM tickets_detail 
            WHERE ticketId = $id
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

}