<?php
class Reserve {

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

    public function data() {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM reserve_data
            GROUP BY id
            ORDER BY id ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function saveData($item) {
        try {
            $sql = "INSERT INTO reserve_data (id,description,project,qty,price,store) VALUES (
                '$item->id',
                '$item->description',
                '$item->project',
                '$item->qty',
                '$item->price',
                '$item->store'

            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function deleteData(){
        try {
            $stm = $this->pdo->prepare("TRUNCATE reserve_data");
            $stm->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id){
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM reserve_data 
            WHERE id = ? 
            LIMIT 1");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getQty($id,$date,$project,$store){
        try {
            $stm = $this->pdo->prepare("SELECT sum(qty) as total
            FROM reservations 
            WHERE materialId = ?
            AND createdAt >= ?
            AND project = ?
            AND store = ?
            AND cancelledAt is null
            ");
            $stm->execute(array($id,$date,$project,$store));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getAll($id){
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM reserve_data 
            WHERE id = ? 
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getAvailable(){
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM reserve_data 
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($item){
        try {
            $sql = "INSERT INTO reservations (materialId,userId,projectId,project,qty,price,notes,description,store) VALUES";
            $project = $item->project;
            $price = $item->price;
            $qty = $item->qty;
            $description = $item->description;
            $store = $item->store;
            $notes = $item->notes;

            for ($i = 0; $i < count($qty); $i++) {
                if ($qty[$i] != 0) {
                $sql .= "(
                    '$item->materialId',
                    '$item->userId',
                    '$item->projectId',
                    '$project[$i]',
                    '$qty[$i]',
                    '$price[$i]',
                    '$notes[$i]',
                    '$description[$i]',
                    '$store[$i]'
                    ),";
                }
            }
            $sql = rtrim($sql, ',');
            $this->pdo->prepare($sql)->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function list($filters){
        try {
            $stm = $this->pdo->prepare("SELECT a.*,b.name as projectname, c.username as username
            FROM reservations a
            LEFT JOIN projects b
            ON a.projectId = b.id
            LEFT JOIN users c
            ON a.userId = c.id
            WHERE 1=1
            $filters
            ORDER BY id DESC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateField($id,$field) {
        try {
            $sql = "UPDATE reservations SET $field = now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($id,$field,$value) {
        try {
            $sql = "UPDATE reservations SET $field = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($value,$id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function check($id) {
        try {
            $sql = "UPDATE reservations SET alert = 1 WHERE id = '$id'";
            $this->pdo->prepare($sql)->execute();
            return $sql;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function checkCancel($id) {
        try {
            $sql = "UPDATE rejectCauses SET alert = 1 WHERE id = '$id'";
            $this->pdo->prepare($sql)->execute();
            return $sql;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}