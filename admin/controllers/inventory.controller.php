<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/products.php';
require_once 'models/purchases.php';
require_once 'models/sales.php';

class InventoryController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
    $this->users = new Users();
    $this->products = new Products();
    $this->purchases = new Purchases();
    $this->sales = new Sales();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-CRB"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-CRB"])->permissions, true);
    if (in_array(7, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/inventory/index.php';
    } else {
      $this->init->redirect();
    }
  }

}