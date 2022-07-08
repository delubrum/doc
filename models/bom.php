<?php
class BOM {

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

    public function list($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, c.username, b.projectId, d.name as projectname, e.username as pmname, d.pmId, b.scope,
            concat(d.designation,'-',convert(lpad(b.code,4,0) using utf8),'-',a.code) AS code
            FROM bom a
            LEFT JOIN workOrder b
            ON a.woId = b.id
            LEFT JOIN users c
            ON a.userId = c.id
            LEFT JOIN projects d
            ON b.projectId = d.id
            LEFT JOIN users e
            ON d.pmId = e.id
            WHERE 1=1
            $filters
            ORDER BY createdAt DESC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function code($woId) {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM bom WHERE woId = ? ORDER BY code DESC LIMIT 1");
            $stm->execute(array($woId));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($item) {
        try {
            $sql = "INSERT INTO bom (woId,userId,code) VALUES (
                '$item->woId',
                '$item->userId',
                '$item->code'
            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function get($id){
        try {
            $stm = $this->pdo->prepare("SELECT a.*, c.username, d.name as projectname, e.username as pmname, d.pmId, b.scope,
            concat(d.designation,'-',convert(lpad(b.code,4,0) using utf8),'-',a.code) AS code
            FROM bom a
            LEFT JOIN workOrder b
            ON a.woId = b.id
            LEFT JOIN users c
            ON a.userId = c.id
            LEFT JOIN projects d
            ON b.projectId = d.id
            LEFT JOIN users e
            ON d.pmId = e.id
            WHERE a.id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemSave($item) {
        try {
            $sql = "INSERT INTO bom_items (bomId,description,alloy,size,length,uom,finish,qty,location,destination,requisition,notes) VALUES (
                '$item->bomId',
                '$item->description',
                '$item->alloy',
                '$item->size',
                '$item->length',
                '$item->uom',
                '$item->finish',
                '$item->qty',
                '$item->location',
                '$item->destination',
                '$item->requisition',
                '$item->notes'
            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function itemList($id) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM bom_items
            WHERE bomId = ?
            ORDER BY id ASC
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemGet($id){
        try {
            $stm = $this->pdo->prepare("SELECT * FROM bom_items WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemDelete($id) {
        try {
            $stm = $this->pdo->prepare("DELETE FROM bom_items WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        try {
            $stm = $this->pdo->prepare("DELETE FROM bom_delivers WHERE itemId = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateField($id,$field) {
        try {
            $sql = "UPDATE bom SET $field = now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateDeliverField($id,$field) {
        try {
            $sql = "UPDATE bom_delivers SET $field = now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateSAPCode($code,$id) {
        try {
            $sql = "UPDATE bom_items SET SAPDate = now() , SAPCode = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($code,$id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deliverList($id,$filters) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.username, c.username as signname
            FROM bom_delivers a
            LEFT JOIN users b
            ON a.userId = b.id
            LEFT JOIN users c
            ON a.signId = c.id
            WHERE itemId = ?
            $filters
            ORDER BY id ASC
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deliverListBOM($id) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.username, c.username as signname
            FROM bom_delivers a
            LEFT JOIN users b
            ON a.userId = b.id
            LEFT JOIN users c
            ON a.signId = c.id
            LEFT JOIN bom_items d
            ON a.itemId = d.id
            WHERE d.bomId = ?
            ORDER BY id ASC
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deliverSave($item) {
        try {
            $sql = "INSERT INTO bom_delivers (itemId,notes,qty,userId,signId) VALUES (
                '$item->itemId',
                '$item->notes',
                '$item->qty',
                '$item->userId',
                '$item->signId'
            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function deliverSum($id){
        try {
            $stm = $this->pdo->prepare("SELECT SUM(qty) as total FROM bom_delivers where itemId = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function checkSapItems($id){
        try {
            $stm = $this->pdo->prepare("SELECT id
            FROM bom_items
            WHERE bomId = ?
            and SAPCode is null
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function checkSap($id){
        try {
            $stm = $this->pdo->prepare("SELECT a.id
            FROM bom_delivers a
            LEFT JOIN bom_items b
            ON a.itemId = b.id
            WHERE bomId = ?
            and SAPCode is null
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


}