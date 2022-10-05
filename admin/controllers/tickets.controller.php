<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/tickets.php';

class TicketsController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
    $this->users = new Users();
    $this->tickets = new Tickets();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-CRB"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-CRB"])->permissions, true);
    $filters = '';
    $today = date("Y-m-d");
    $firstday = date('Y-m-01', strtotime($today));
    $lastday = date('Y-m-t', strtotime($today));
    (!empty($_REQUEST['from'])) ? $filters .= " and a.createdAt  >='" . $_REQUEST['from']."'": $filters .= " and a.createdAt  >= $firstday";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= " ";
    if (in_array(11, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/tickets/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once 'views/tickets/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-CRB"];
    $table = 'tickets';
    foreach($_POST as $k => $val) {
      if (!empty($val)) {
        if($k != 'id') {
          $item->{$k} = $val;
        }
      }
    }
    $this->init->save($table,$item);
  }

  public function Get(){
    $status = 'ok';
    if  ($this->tickets->get($_REQUEST["id"])) {
      $id = $this->tickets->get($_REQUEST["id"])->id;
      $code = $_REQUEST["id"];

      $price = $this->tickets->get($_REQUEST["id"])->price - $this->tickets->sumPrice($_REQUEST["id"])->total;
      if ($price <= 0) {
        $status = 'El cupón no posee fondos';
      }
      echo json_encode(array("id" => $id,"code" => $code,"price" => $price,"status" => $status));
    } else {
      $status = 'El cupón no éxiste';
      echo json_encode(array("status" => $status));
    }
  }


}