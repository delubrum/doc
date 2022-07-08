<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/docs.php';

class DocsController{
  private $model;
  public function __CONSTRUCT(){
    $this->docs = new Docs();
    $this->init = new Init();
    $this->users = new Users();
  }


  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-DOCS"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-DOCS"])->permissions, true);
    $filters = '';
    if (in_array(3, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/docs/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    require_once 'views/docs/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    foreach($_POST as $k => $val) {
      if($k == 'keywords') {
      $item->{$k} = json_encode($val);
      } else {
      $item->{$k} = $val;
      }
    }
    $id = $this->docs->save($item);
  }

  public function Detail(){
    $id = $this->docs->get($_REQUEST['id']);
    session_start();
    (!empty($_SESSION["id-DOCS"])) 
    ? $permissions = json_decode($this->users->permissionsGet($_SESSION["id-DOCS"])->permissions, true)
    : $permissions = array();
    session_write_close();
    require_once 'views/docs/detail.php';
  }

}