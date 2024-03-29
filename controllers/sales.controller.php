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

  public function Save(){
    require_once "middlewares/check.php";
    $userId = $_SESSION["id-CRB"];
    $productId=$_REQUEST['productId'];
    $qty=$_REQUEST['qty'];
    $obs=$_REQUEST['obs'];
    $price=$_REQUEST['price'];
    $returned=$_REQUEST['returned'];
    $discount=$_REQUEST['discount'];
    $cupons=explode(",",$_REQUEST['cupons']);
    $cuponsPrice=explode(",",$_REQUEST['cuponPrice']);;
    $card=$_REQUEST['card'];
    $total_price=$_REQUEST['cash'];
    $cashReal=$_REQUEST['cashReal'];
    $payTotal=$_REQUEST['payTotal'];
    $total_cupons=array_sum($cuponsPrice);
    $id = $this->sales->save($productId,$qty,$total_price,$price,$obs,$userId,$returned,$discount,$card,$total_cupons,$cupons,$cuponsPrice,$cashReal,$payTotal);
    echo $id;

  }

  public function Refund(){
    $id = $this->sales->getId($_REQUEST['id']);
    require_once 'views/sales/refund.php';
  }

  public function RefundSave(){
    require_once "middlewares/check.php";
    $userId = $_SESSION["id-CRB"];
    $saleId = $_REQUEST['saleId'];
    $cause = $_REQUEST['cause'];
    $qty = $_REQUEST['qty'];
    $productId = $_REQUEST['productId'];
    $price = $_REQUEST['price'];
    $total = array_sum($price);
    $this->sales->refundSave($saleId,$cause,$userId,$total,$productId,$price,$qty);
  }

  public function Detail(){
    $id = $this->sales->getId($_REQUEST['id']);
      require_once 'views/sales/detail.php';
  }

}