<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/machines.php';
require_once 'models/users.php';
require_once 'models/init.php';


class MachinesController{
  private $model;
  public function __CONSTRUCT(){
    $this->machines = new Machines();
    $this->users = new Users();
    $this->init = new Init();
  }

  public function MachinesList(){
    header('Content-Type: application/json');
    echo json_encode($this->machines->MachinesList());
  }

  public function AddProcess(){
    $p = $_REQUEST['process'];
    require_once 'views/workOrder/addProcess.php';
  }

  public function AddMachine(){
    $p = $_REQUEST['process'];
    require_once 'views/workOrder/addMachine.php';
  }

  public function Crud(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $filters = 'AND scheduledAt is null AND closedAt is null';
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(7, $permissions)) {
      if (isset($_REQUEST['machineId'])) {
        $item = $this->machines->MachineGet($_REQUEST['machineId']);
      }
      require_once 'views/layout/header.php';
      require_once 'views/machines/crud/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function MachineForm(){
    (isset($_REQUEST['id'])) ? $item = $this->machines->MachineGet($_REQUEST['id']) : '';
    $processes = array('cut','laser','punch','router','brake','cnc_profiles','drilling','welding','pretreatment','painting','assembly','packing');
    require_once 'views/machines/crud/new.php';
  }

  public function MachineSave(){
    $item = new stdClass();
    $item->title=$_REQUEST['title'];
    $item->processes=json_encode($_REQUEST['processes']);
    if (!empty($_REQUEST['machineId'])) {
      $item->machineId = $_REQUEST['machineId'];
      $this->machines->machineUpdate($item);
    } else {
      $this->machines->machineSave($item);
    }
  }
}