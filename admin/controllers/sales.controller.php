<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/sales.php';
require_once 'models/products.php';

class SalesController{
  private $model;
  public function __CONSTRUCT(){
    $this->sales = new Sales();
    $this->products = new Products();
    $this->init = new Init();
    $this->users = new Users();
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
    if (in_array(8, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/sales/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once 'views/sales/new.php';
  }

  public function ProductByCategory(){
    if  (!empty($_REQUEST["id"])) {
    foreach($this->products->productsByCategory($_REQUEST["id"]) as $r) {
      $description = mb_convert_case($r->description, MB_CASE_TITLE, "UTF-8");
      $price = $r->price;
      if ($r->iqty > 0) {
        echo "<button id='product' data-id='$r->id' data-price='$r->price' type='button' class='btn btn-block bg-gradient-info' data-toggle='modal' data-target='#qty_price'>$description ($$price)</button>";
      } else {
        echo "<button type='button' class='btn btn-block bg-danger'>$description ($$price)</button>"; 
      }
      }
    }
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $table = 'purchases';
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
    empty($_POST['id'])
    ? $this->init->save($table,$item)
    : $this->init->update($table,$item,$_POST['id']);
  }

  public function Detail(){
    $id = $this->centre->get($_REQUEST['id']);
    session_start();
    (!empty($_SESSION["id-CRB"])) 
    ? $permissions = json_decode($this->users->permissionsGet($_SESSION["id-CRB"])->permissions, true)
    : $permissions = array();
    session_write_close();
    require_once 'views/centre/detail.php';
  }

  public function Delete(){
    $table = 'centre';
    $this->init->delete($table,$_REQUEST['id']);
  }

}