<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/others.php';


class OthersController{
  private $model;
  public function __CONSTRUCT(){
    $this->others = new Others();
    $this->init = new Init();
    $this->users = new Users();
  }


  public function In(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-CRB"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-CRB"])->permissions, true);
    $filters = '';
    $today = date("Y-m-d");
    $firstday = date('Y-m-01', strtotime($today));
    $lastday = date('Y-m-t', strtotime($today));
    (!empty($_REQUEST['from'])) ? $filters .= " and a.createdAt  >='" . $_REQUEST['from']."'": $filters .= " and a.createdAt  >= $firstday";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= " ";
    if (in_array(5, $permissions)) {
        $type = 'IN';
        require_once 'views/layout/header.php';
        require_once 'views/others/index.php';
    } else {
        $this->init->redirect();
    }
  }

  public function Out(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-CRB"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-CRB"])->permissions, true);
    $filters = '';
    $today = date("Y-m-d");
    $firstday = date('Y-m-01', strtotime($today));
    $lastday = date('Y-m-t', strtotime($today));
    (!empty($_REQUEST['from'])) ? $filters .= " and a.createdAt  >='" . $_REQUEST['from']."'": $filters .= " and a.createdAt  >= $firstday";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= " ";
    if (in_array(6, $permissions)) {
        $type = 'OUT';
        require_once 'views/layout/header.php';
        require_once 'views/others/index.php';
    } else {
         $this->init->redirect();
    }
  }

  public function New(){
    $type = $_REQUEST['type'];
    require_once 'views/others/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-CRB"];
    $table = 'others';
    foreach($_POST as $k => $val) {
      if (!empty($val)) {
        if($k != 'id') {
          if($k == 'price') {
          $item->{$k} = substr($val,2);
          } else {
          $item->{$k} = $val;
          }
        }
      }
    }
    $this->init->save($table,$item);
  }

}