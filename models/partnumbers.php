<?php
class PartNumbers {

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

    public function list($projectId) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.username, c.name as materialname, d.name as partname
            FROM partNumbers a
            LEFT JOIN users b
            ON a.userId = b.id
            LEFT JOIN materials c
            ON a.material = c.id
            LEFT JOIN parts d
            ON a.part = d.id
            WHERE a.projectId = ?
            ORDER BY createdAt DESC
            ");
            $stm->execute(array($projectId));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function partList($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM parts
            WHERE 1=1
            $filters
            ORDER BY name ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function materialList($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM materials
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

    public function get($id) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.designation
            FROM partNumbers a
            LEFT JOIN projects b
            ON a.projectId = b.id
            WHERE a.id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function lastPN($projectId,$part) {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM partNumbers WHERE projectId = ? and part = ? ORDER BY name DESC LIMIT 1");
            $stm->execute(array($projectId,$part));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($item) {
        try {
            $sql = "INSERT INTO partNumbers (projectId,description,part,material,name,userId) VALUES (?,?,?,?,?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->projectId,
                    $item->description,
                    $item->part,
                    $item->material,
                    $item->name,
                    $item->userId
                )
            );
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function delete($id) {
        try {
            $stm = $this->pdo->prepare("DELETE FROM partNumbers WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($item) {
        try {
            $sql = "UPDATE partNumbers SET 
            material = '$item->material',
            description = '$item->description' 
            WHERE id = '$item->id'";
            $this->pdo->prepare($sql)->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function excel($id) {
        try {
            $stm = $this->pdo->prepare("SELECT a.createdAt as date, a.name as PartNumber, b.name as Part, c.name as Material, 
            a.description as Description, d.username as User
            FROM partNumbers a
            LEFT JOIN parts b
            ON a.part = b.id
            LEFT JOIN materials c
            ON a.material = c.id
            LEFT JOIN users d
            ON a.userId = d.id
            WHERE projectId = ?
            ORDER BY a.name ASC");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}