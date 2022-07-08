<?php

class Init {
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

    public function navTitleList() {
        try {
            $stm = $this->pdo->prepare("SELECT DISTINCT id, title, c, icon
            FROM permissions
            WHERE type = 'menu'
            GROUP BY title
            ORDER BY sortm ASC");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function permission($id) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM permissions
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function navSubtitleList($title) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM permissions
            WHERE type = 'menu'
            AND title = ?
            ORDER BY sort ASC");
            $stm->execute(array($title));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function redirect() {
        header("location: 403.php");
        //header('Location: ?c=Login&a=Index');
    }

    public function alert($fields,$table,$filters) {
        try {
            $stm = $this->pdo->prepare("SELECT $fields
            FROM $table
            WHERE 1=1
            $filters
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($table,$item) {
        $keys = '';
        $vals = '';
        foreach ($item as $k => $v) {
            $vals .= "'$v" . "',";
            $keys .= $k .',';
        }
        $keys = rtrim($keys, ",");
        $vals = rtrim($vals, ",");
        try {
            $sql = "INSERT INTO $table ($keys) VALUES ($vals)";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function update($table,$item,$id) {
        $vals = '';
        foreach ($item as $k => $v) {
            $vals .= $k . " = '$v" . "',";
        }
        $vals = rtrim($vals, ",");
        try {
            $sql = "UPDATE $table SET $vals WHERE id = '$id'";
            $this->pdo->prepare($sql)->execute();
            return $sql;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function delete($table,$id) {
        try {
            $stm = $this->pdo->prepare("DELETE FROM $table WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}