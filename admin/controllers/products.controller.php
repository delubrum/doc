<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/products.php';

class ProductsController{
  private $model;
  public function __CONSTRUCT(){
    $this->products = new Products();
    $this->init = new Init();
    $this->users = new Users();
  }


  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-CRB"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-CRB"])->permissions, true);
    if (in_array(3, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/products/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Active(){
    $id=$_REQUEST['id'];
    $val=$_REQUEST['val'];
    $this->products->active($val,$id);
  }

  public function New(){
    isset($_REQUEST['id']) ? $id = $this->products->get($_REQUEST['id']) : '';
    require_once 'views/products/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $table = 'products';
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


  public function ByCategory(){
    if  (!empty($_REQUEST["id"])) {
    foreach($this->products->getByCategory($_REQUEST["id"]) as $r) {
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
  
  public function Search(){
    if  (!empty($_POST["description"])) {
    foreach($this->products->search($_POST["description"]) as $r) {
      $description = mb_convert_case($r->description, MB_CASE_TITLE, "UTF-8");
      $price = $r->price;
      if ($r->iqty > 0) {
      echo "<button id='product' data-id='$r->id' data-price='$r->price' type='button' class='btn btn-block bg-gradient-info' data-toggle='modal' data-target='#qty_price'>$description ($$price K)</button>";
      } else {
        echo "<button type='button' class='btn btn-block bg-danger'>$description ($$price)</button>"; 
      }  
    }
    }
  }

}