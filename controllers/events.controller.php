<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/events.php';
require_once 'models/workorders.php';
require_once 'models/machines.php';

class EventsController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Events();
    $this->init = new Init();
    $this->users = new Users();
    $this->wo = new WorkOrders();
    $this->machines = new Machines();
  }

  public function EventSplitForm(){
    $id=$_REQUEST['id'];
    $event = $this->model->eventGet($id);
    $wo_item = $this->wo->WorkOrderItemGet($event->partNumberId);
    require_once 'views/workOrder/split.php';
  }

  public function EventStopForm(){
    $id=$_REQUEST['id'];
    $event = $this->model->eventGet($id);
    $wo_item = $this->wo->WorkOrderItemGet($event->partNumberId);
    require_once 'views/workOrder/stop.php';
  }

  public function EventSave(){
    $id=$_REQUEST['id'];
    $partNumber= $this->wo->WorkOrderItemGet($id)->number;
    $process = $_REQUEST['process'];
    $machine = $_REQUEST['machine'];
    $qty = $_REQUEST['qty'];
    $startEnd = $_REQUEST['startEnd'];
    (isset($_REQUEST['splitId'])) ? $this->model->eventDelete($_REQUEST['splitId']) : '';
    $this->model->eventSave($id,$partNumber,$process,$machine,$qty,$startEnd);
  }

  public function EventsList(){
    isset($_REQUEST['id']) ? $filters = ' and resourceId = ' . $_REQUEST['id'] : $filters = '';
    header('Content-Type: application/json');
    echo json_encode($this->model->eventsList($filters));
  }

  public function EventGet(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $id=$_REQUEST['id'];
    $event = $this->model->eventGet($id);
    isset($event->partNumberId) ? $wo_item = $this->wo->WorkOrderItemGet($event->partNumberId) : '';
    isset($event->partNumberId) ? $wo = $this->wo->WorkOrderGet($wo_item->wo) : '' ;
    require_once 'views/workOrder/eventInfo.php';
  }

  public function EventUpdate(){
    $id=$_REQUEST['id'];
    if (isset($_REQUEST['startEnd'])) {
      $startEnd = explode(" - ", $_REQUEST['startEnd']);
      $start = $startEnd[0];
      $end = $startEnd[1];
    } else {
    $start = date("Y-m-d H:i:s" , strtotime ( '-5 hour' , strtotime ($_REQUEST['start']) )) ; 
    $end = date("Y-m-d H:i:s" , strtotime ( '-5 hour' , strtotime ($_REQUEST['end']) )) ; 
    }
    $resourceId=$_REQUEST['resourceId'];
    $process = $this->model->eventGet($id)->process;
    $machineProcess = $this->machines->MachineGet($resourceId)->processes;
    if (strpos($machineProcess,$process)) {
      echo ($this->model->eventUpdate($start,$end,$resourceId,$id)) ? "ok" : "error";
    } else {
      echo "machine_error";
    }
  }

  public function EventStart(){
    require_once "middlewares/check.php";
    $eventId=$_REQUEST['eventId'];
    $userId = $_SESSION["id-SIGMA"];
    $this->model->eventStart($eventId,$userId);
    echo $this->model->eventGet($eventId)->time;
  }

  public function EventStop(){
    require_once "middlewares/check.php";
    $eventId = $_REQUEST['eventId'];
    $cause = $_REQUEST['cause'];
    $partial = $this->model->eventGet($eventId)->partial + $_REQUEST['qty'];
    $userId = $_SESSION["id-SIGMA"];
    $time = strtotime(date("Y-m-d H:i:s")) - strtotime($this->model->eventGet($eventId)->statusAt) + $this->model->eventGet($eventId)->time;
    $this->model->eventStop($time,$eventId,$userId,$cause,$partial);
  }

  public function EventFinish(){
    require_once "middlewares/check.php";
    $eventId = $_REQUEST['eventId'];
    $userId = $_SESSION["id-SIGMA"];
    $time = strtotime(date("Y-m-d H:i:s")) - strtotime($this->model->eventGet($eventId)->statusAt) + $this->model->eventGet($eventId)->time;
    $partial = $this->model->eventGet($eventId)->qty;
    $this->model->eventFinish($time,$eventId,$userId,$partial);
  }

  public function EventReactivate(){
    $eventId = $_REQUEST['eventId'];
    $this->model->eventReactivate($eventId);
  }

}