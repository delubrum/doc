<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/centre.php';

class CentreController{
  private $model;
  public function __CONSTRUCT(){
    $this->centre = new Centre();
    $this->init = new Init();
    $this->users = new Users();
  }


  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-DOCS"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-DOCS"])->permissions, true);
    $filters = '';
    (!empty($_REQUEST['name'])) ? $filters .= " and code LIKE '%" . $_REQUEST['name']."%'": $filters .= "";
    (!empty($_REQUEST['address'])) ? $filters .= " and title LIKE '%" . $_REQUEST['address']."%'": $filters .= "";
    (!empty($_REQUEST['phone'])) ? $filters .= " and title LIKE '%" . $_REQUEST['phone']."%'": $filters .= "";
    if (in_array(5, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/centre/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Public(){
    (!empty($_REQUEST)) ? $filters = '': $filters = '  ORDER BY id DESC LIMIT 10';
    (!empty($_REQUEST['title'])) ? $filters .= " and title LIKE '%" . $_REQUEST['title']."%'": $filters .= "";
    (!empty($_REQUEST['location'])) ? $filters .= " and location ='" . $_REQUEST['location']."'": $filters .= "";
    (!empty($_REQUEST['from'])) ? $filters .= " and date  >='" . $_REQUEST['from']."'": $filters .= "";
    (!empty($_REQUEST['to'])) ? $filters .= " and date <='" . $_REQUEST['to']." 23:59:59'": $filters .= "";
    if((!empty($_REQUEST['keywords']))) {
      $ids = '';
      foreach($_REQUEST['keywords'] as $p) {
        foreach($this->centre->list(" and keywords LIKE '%$p%' ") as $r) { 
          $ids .= $r->id . ',';
        }
      }
      $ids = rtrim($ids, ',');
      ($ids != '') ? $filters .= " and id IN ($ids)" : $filters .= ' and id = 0';
      
    }
      require_once 'views/centre/public.php';
  }

  public function New(){
    isset($_REQUEST['id']) ? $id = $this->centre->get($_REQUEST['id']) : '';
    require_once 'views/centre/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $table = 'centre';
    foreach($_POST as $k => $val) {
      if (!empty($val)) {
        if($k != 'id') {
          $item->{$k} = $val;
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
    (!empty($_SESSION["id-DOCS"])) 
    ? $permissions = json_decode($this->users->permissionsGet($_SESSION["id-DOCS"])->permissions, true)
    : $permissions = array();
    session_write_close();
    require_once 'views/centre/detail.php';
  }

  public function Delete(){
    $table = 'centre';
    $this->init->delete($table,$_REQUEST['id']);
  }

}