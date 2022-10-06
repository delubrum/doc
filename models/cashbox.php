<?php

class CashBox {
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

    public function open($item) {
        try {
            $sql = "INSERT INTO cashbox (openedAt,openedBy,open) VALUES (
                now(),
                '$item->openedBy',
                '$item->open'
            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function close($item) {
        try {
            $sql = "UPDATE cashbox SET 
                closedAt = now(),
                closedBy = '$item->closedBy',
                close = '$item->close'
                WHERE id = '$item->id'
            ";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function list($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.username as openuser, c. username as closeuser
            FROM cashbox a
            LEFT JOIN users b
            ON a.openedBy = b.id
            LEFT JOIN users c
            ON a.closedBy = c.id
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

    public function get($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM cashbox 
            WHERE id = $id");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function excel() {
        try {
            $stm = $this->pdo->prepare("SELECT a.id, b.username as User, c.username as FillOutBy, a.createdAt as Date, a.type as Type, a.priority as Priority,
            a.description as Description, a.complexity as Complexity, a.start as Start, a.end as End, a.attends as Attends,
            a.answer as Answer,a.rating as Rating, a.closedAt as ClosureDate,
            (CASE 
                WHEN a.ClosedAt IS NOT NULL THEN 'Closed'
                WHEN a.start IS NOT NULL and a.end IS  NULL THEN 'Started'
                WHEN a.start IS NOT NULL and a.closedAt IS  NULL THEN 'Attended'
                WHEN a.end IS NOT NULL and a.end IS  NULL THEN 'Started'
                ELSE 'Open'
            END) AS Status
            FROM serviceDesk a
            LEFT JOIN users b
            ON a.userId = b.id
            LEFT JOIN users c
            ON a.fillBy = c.id
            ORDER BY a.id ASC");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}