<?php
class Events {
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

    public function eventsList($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM events
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

    public function eventCausesList() {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM eventCauses
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function eventGet($id){
        try {
            $stm = $this->pdo->prepare("SELECT * FROM events WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function eventSave($id,$partNumber,$process,$machine,$qty,$startEnd) {
        try {
            $sql = "INSERT INTO events (partNumberId,resourceId,title,start,end,process,qty) VALUES";
            foreach($process as $k => $r){
                $date = explode(" - ", $startEnd[$k]);
                $start = $date[0];
                $end = $date[1];
                $title = $partNumber . " / " . $r . " / (QTY:" . $qty[$k] . ")";
                $sql.="('$id','$machine[$k]','$title','$start','$end','$r','$qty[$k]'),";
             }
            $sql=rtrim($sql,',');
			$this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
        try {
            $sql = "UPDATE sigma.elementi_WO_items set scheduledAt = now() WHERE ID = ?";
            $this->pdo->prepare($sql)->execute(array($id));
            return true;
        }
            catch (Exception $e) {
            die($e->getMessage());
        }       
    }

    public function eventUpdate($start,$end,$resourceId,$id) {
        try {
            $sql = "UPDATE events set start = ?, end = ?, resourceId = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($start,$end,$resourceId,$id));
            return true;
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function eventDelete($id) {
        try {
            $stm = $this->pdo->prepare("DELETE FROM events WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function eventStart($eventId,$userId) {
        try {
            $sql = "UPDATE events SET status = 'started', statusAt = now(), color = 'yellow' , userId = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($userId,$eventId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        try {
            $sql = "INSERT INTO event_details (eventId,start,userId) VALUES (?,now(),?)";
            $this->pdo->prepare($sql)->execute(array($eventId,$userId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function eventStop($time,$eventId,$userId,$cause,$partial) {
        try {
            $sql = "UPDATE events SET status = 'stoped', color = 'orange', time = ?, partial = ?, userId = ?, statusAt=now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($time, $partial,$userId, $eventId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        try {
            $sql = "UPDATE event_details SET end=now() WHERE eventId = ? and userId = ? ORDER BY id DESC LIMIT 1";
            $this->pdo->prepare($sql)->execute(array($eventId, $userId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        try {
            $sql = "INSERT INTO event_causes (eventId,cause,userId) VALUES (?,?,?)";
            $this->pdo->prepare($sql)->execute(array($eventId,$cause,$userId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function eventFinish($time,$eventId,$userId,$partial) {
        try {
            $sql = "UPDATE events SET status = 'closed', color = 'green', time = ?, partial = ?, userId = ?, statusAt=now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($time, $partial, $userId, $eventId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        try {
            $sql = "UPDATE event_details SET end=now() WHERE eventId = ? and userId = ? ORDER BY id DESC LIMIT 1";
            $this->pdo->prepare($sql)->execute(array($eventId, $userId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function eventReactivate($eventId) {
        try {
            $sql = "UPDATE events SET status = 'stoped', color = 'orange', statusAt=now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($eventId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}