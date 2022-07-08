<?php
class Projects {

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
            $stm = $this->pdo->prepare("SELECT a.*, b.username as managername, c.username as pmname, d.company as clientname, a.closedAt
            FROM projects a
            LEFT JOIN users b
            on a.userId = b.id
            LEFT JOIN users c
            on a.pmId = c.id
            LEFT JOIN clients d
            on a.clientId = d.id
            WHERE 1=1
            $filters
            ORDER BY id, name ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM projects 
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($item) {
        try {
            $sql = "INSERT INTO projects (name,designation,userId,pmId,clientId,currency,approvedBy,price) VALUES (?,?,?,?,?,?,?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->name,
                    $item->designation,
                    $item->userId,
                    $item->pmId,
                    $item->clientId,
                    $item->currency,
                    $item->approvedby,
                    $item->price
                )
            );
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function update($item) {
        try {
            $sql = "UPDATE projects SET name = ?,designation = ?,userId = ?,pmId = ?,clientId = ?,currency = ?, approvedBy = ?, price = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(
                array(
                    $item->name,
                    $item->designation,
                    $item->userId,
                    $item->pmId,
                    $item->clientId,
                    $item->currency,
                    $item->approvedby,
                    $item->price,
                    $item->projectId
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function usersUpdate($users,$id) {
        try {
            $sql = "UPDATE projects SET users = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($users,$id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function close($id) {
        try {
            $sql = "UPDATE projects SET closedAt = now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function refresh($id) {
        try {
            $sql = "UPDATE projects SET closedAt = null WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}