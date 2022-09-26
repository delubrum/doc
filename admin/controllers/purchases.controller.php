<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/purchases.php';
require_once 'models/products.php';
require_once 'models/inventory.php';


class PurchasesController{
  private $model;
  public function __CONSTRUCT(){
    $this->purchases = new Purchases();
    $this->products = new Products();
    $this->inventory = new Inventory();
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
    if (in_array(4, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/purchases/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once 'views/purchases/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $inv = new stdClass();
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
    if ($this->inventory->get($_REQUEST['productId'])) {
      $this->init->save('purchases',$item);
      $inv->iqty = $_REQUEST['qty'] + $this->inventory->get($_REQUEST['productId'])->qty;
      $this->init->update('inventory',$inv,$_REQUEST['productId']);
    } else {
      $inv->productId = $_REQUEST['productId'];
      $inv->qty = $_REQUEST['qty'];
      $this->init->save('purchases',$item);
      $this->init->save('inventory',$inv);
    }
  }

}