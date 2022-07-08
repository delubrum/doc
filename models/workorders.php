<?php

class WorkOrders {


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

    public function code($projectId) {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM workOrder WHERE projectId = ? ORDER BY code DESC LIMIT 1");
            $stm->execute(array($projectId));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($item) {
        try {
            $sql = "INSERT INTO workOrder (projectId,scope,userId,code) VALUES (
                '$item->projectId',
                '$item->scope',
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

    public function list($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT a.*,b.username,c.name as projectname,
            concat(c.designation,'-',convert(lpad(a.code,4,0) using utf8)) AS designation,
            d.username as pmname, c.pmId, c.users
            FROM workOrder a
            LEFT JOIN users b
            ON a.userId = b.id
            LEFT JOIN projects c
            ON projectId = c.id
            LEFT JOIN users d
            on c.pmId = d.id
            WHERE 1=1
            $filters
            ORDER BY id DESC
            ");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id){
        try {
            $stm = $this->pdo->prepare("SELECT a.*,b.id as projectname,b.name as projectname, c.username, d.username as pmname, d.email as pmemail,
            concat(b.designation,'-',convert(lpad(a.code,4,0) using utf8)) AS designation
            FROM workOrder a
            LEFT JOIN projects b
            on a.projectId = b.id
            LEFT JOIN users c
            on a.userId = c.id
            LEFT JOIN users d
            on b.pmId = d.id
            WHERE a.id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemList($id) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM workOrder_items
            WHERE woId = ?
            AND cancelledAt is null
            ORDER BY number ASC
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
            $stm = $this->pdo->prepare("SELECT * FROM workOrder_items WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateField($id,$field) {
        try {
            $sql = "UPDATE workOrder SET $field = now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateItemField($id,$field) {
        try {
            $sql = "UPDATE workOrder_items SET $field = now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function modify($id) {
        try {
            $sql = "UPDATE workOrder SET confirmedAt = NULL, processedAt = NULL WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function checkPartNumberName($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM partNumbers WHERE name = ? LIMIT 1");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function checkDuplicatedPartNumber($number,$woId) {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM workOrder_items WHERE number = ? and woId = ?LIMIT 1");
            $stm->execute(array($number,$woId));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemSave($item) {
        try {
            $sql = "INSERT INTO workOrder_items (woId,number,name,weight,uom,pa,pauom,finish,qty,notes,processes) VALUES (
                '$item->woId',
                '$item->number',
                '$item->name',
                '$item->weight',
                '$item->uom',
                '$item->pa',
                '$item->pauom',
                '$item->finish',
                '$item->qty',
                '$item->notes',
                '$item->processes'
            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function processesList($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM processes
            WHERE 1=1
            $filters
            ORDER BY id ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function processGet($id){
        try {
            $stm = $this->pdo->prepare("SELECT * FROM processes WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemDelete($id) {
        try {
            $stm = $this->pdo->prepare("DELETE FROM workOrder_items WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function bomList($id){
        try {
            $stm = $this->pdo->prepare("SELECT a.*,
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
            WHERE woId = ?
            and a.cancelledAt is null
            ORDER BY a.id
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function infoUpdate($item) {
        try {
            $sql = "UPDATE workOrder SET
            scope = '$item->scope'
            WHERE id = '$item->id'
            ";
            $this->pdo->prepare($sql)->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function daily($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT DATE(sentAt) as date, COUNT(*) as total
            FROM workOrder
            WHERE 1=1
            $filters
            GROUP BY DATE(Date)
            ORDER BY sentAt
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function dailyWeight($date) {
        try {
            $stm = $this->pdo->prepare("SELECT (SUM(weight*qty)) as total
            FROM workOrder_items a
            LEFT JOIN workOrder b
            ON a.woId = b.id
            WHERE date(sentAt) = '$date'
            AND number NOT LIKE '%-AS-%'
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemDaily($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT DATE(b.sentAt) as date, COUNT(*) as total
            FROM workOrder_items a
            LEFT JOIN workOrder b
            ON a.woId = b.id
            WHERE 1=1
            $filters
            GROUP BY DATE(date)
            ORDER BY date
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function monthly($year) {
        try {
            $stm = $this->pdo->prepare("SELECT count(*) as total, DATE_FORMAT(sentAt, '%b') as date
            FROM workOrder
            WHERE year(sentAt) = ?
            GROUP BY DATE_FORMAT(sentAt, '%b')
            ORDER BY sentAt
            ");
            $stm->execute(array($year));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemMonthly($year) {
        try {
            $stm = $this->pdo->prepare("SELECT count(*) as total, DATE_FORMAT(b.sentAt, '%b') as date
            FROM workOrder_items a
            LEFT JOIN workOrder b
            ON a.woId = b.id
            WHERE year(b.sentAt) = ?
            GROUP BY DATE_FORMAT(b.sentAt, '%b')
            ORDER BY sentAt
            ");
            $stm->execute(array($year));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function monthlyWeight($year) {
        try {
            $stm = $this->pdo->prepare("SELECT sum(weight*qty) as total, DATE_FORMAT(b.sentAt, '%b') as date
            FROM workOrder_items a
            LEFT JOIN workOrder b
            ON a.woId = b.id
            WHERE year(b.sentAt) = ?
            AND number NOT LIKE '%-AS-%'
            GROUP BY DATE_FORMAT(b.sentAt, '%b')
            ORDER BY sentAt
            ");
            $stm->execute(array($year));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function total() {
        try {
            $stm = $this->pdo->prepare("SELECT count(*) as total
            FROM workOrder
            WHERE sentAt is not null
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function totalWeight() {
        try {
            $stm = $this->pdo->prepare("SELECT sum(weight*qty) as total
            FROM workOrder_items b
            LEFT JOIN workOrder a
            ON a.id = b.woId
            WHERE sentAt is not null
            AND number NOT LIKE '%-AS-%'
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function weight($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT sum(weight*qty) as total
            FROM workOrder_items b
            LEFT JOIN workOrder a
            ON b.woId = a.id
            WHERE sentAt is not null
            AND number NOT LIKE '%-AS-%'
            $filters
            ");
            $stm->execute(array());
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }


    






















    

    public function workOrdersList($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM workOrders
            WHERE sentAt is not null
            AND cancelledAt is null
            $filters
            ORDER BY ID
            ");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function workOrdersItemsList($wo_id) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM sigma.elementi_WO_items
            WHERE wo = ?
            AND scheduledAt is null
            ORDER BY number ASC
            ");
            $stm->execute(array($wo_id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function WorkOrderGet($id){
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM workOrders
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function WorkOrderItemsList($id){
        try {
            $stm = $this->pdo->prepare("SELECT * FROM sigma.elementi_WO_items WHERE wo = ?");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function WorkOrderItemGet($id){
        try {
            $stm = $this->pdo->prepare("SELECT * FROM sigma.elementi_WO_items WHERE ID = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}