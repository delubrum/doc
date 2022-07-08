<?php
class IT {

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
            $stm = $this->pdo->prepare("SELECT a.*, b.username, c.username as fillname
            FROM serviceDesk a
            LEFT JOIN users b
            ON a.userId = b.id
            LEFT JOIN users c
            ON a.fillBy = c.id
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

    public function save($item) {
        try {
            $sql = "INSERT INTO serviceDesk (userId,type,priority,description) VALUES (
                '$item->userId',
                '$item->type',
                '$item->priority',
                '$item->description'
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
            $stm = $this->pdo->prepare("SELECT a.*, b.username
            FROM serviceDesk a
            LEFT JOIN users b
            ON a.userId = b.id
            WHERE a.id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($item) {
        (!empty(trim($item->end))) ? $end = "end = '$item->end'": $end = "end = NULL";
        try {
            $sql = "UPDATE serviceDesk SET 
            priority = '$item->priority',
            complexity = '$item->complexity',
            start = '$item->start',
            $end,
            attends = '$item->attends',
            answer = '$item->answer',
            users = '$item->users',
            rating = '$item->rating',
            notes = '$item->notes',
            fillBy = '$item->fillBy',
            closedAt = $item->closedAt
            WHERE id = '$item->id'
            ";
            $this->pdo->prepare($sql)->execute();
            return $sql;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function check($id) {
        try {
            $sql = "UPDATE serviceDesk SET checkedAt = now() WHERE id = '$id'";
            $this->pdo->prepare($sql)->execute();
            return $sql;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function daily($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT DATE(createdAt) as date, COUNT(*) as total, SUM(rating) as ratings
            FROM serviceDesk
            WHERE 1=1
            $filters
            GROUP BY DATE(Date)
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function avgRating() {
        try {
            $stm = $this->pdo->prepare("SELECT AVG(rating) as ratings
            FROM serviceDesk
            WHERE closedAt is not null
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function dailyAttended($date) {
        try {
            $stm = $this->pdo->prepare("SELECT COUNT(*) as total
            FROM serviceDesk
            WHERE end >= '$date'
            AND end <= '$date 23:59:59'
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function dailyExternal($date) {
        try {
            $stm = $this->pdo->prepare("SELECT COUNT(*) as total
            FROM serviceDesk
            WHERE end >= '$date'
            AND end <= '$date 23:59:59'
            AND attends = 'External'
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
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

    public function pendingSave($total) {
        try {
            $sql = "INSERT INTO serviceDesk_pending (total) VALUES ('$total')";
			$this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function pendingDaily($date) {
        try {
            $stm = $this->pdo->prepare("SELECT sum(total) as total
            FROM serviceDesk_pending
            WHERE createdAt >= '$date'
            AND createdAt <= '$date 23:59:59'
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}