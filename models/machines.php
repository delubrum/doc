<?php
class Machines {

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

    public function MachinesList() {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM machines
            ORDER BY sort ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function MachineGet($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM machines 
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function machineSave($item) {
        try {
            $sql = "INSERT INTO machines (title,processes) VALUES (?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->title,
                    $item->processes,
                )
            );
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function machineUpdate($item) {
        try {
            $sql = "UPDATE machines SET title = ?, processes = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(
                array(
                    $item->title,
                    $item->processes,
                    $item->machineId
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}