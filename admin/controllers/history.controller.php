<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/history.php';

class HistoryController{
  private $model;
  public function __CONSTRUCT(){
    $this->history = new History();
    $this->init = new Init();
    $this->users = new Users();
  }


  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-DOCS"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-DOCS"])->permissions, true);
    $filters = '';
    (!empty($_REQUEST['subject'])) ? $filters .= " and subject LIKE '%" . $_REQUEST['subject']."%'": $filters .= "";
    (!empty($_REQUEST['abstract'])) ? $filters .= " and abstract LIKE '%" . $_REQUEST['abstract']."%'": $filters .= "";
    (!empty($_REQUEST['source'])) ? $filters .= " and source LIKE '%" . $_REQUEST['source']."%'": $filters .= "";
    if (in_array(6, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/history/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Public(){
    $filters = '';
    (!empty($_REQUEST['subject'])) ? $filters .= " and subject LIKE '%" . $_REQUEST['subject']."%'": $filters .= "";
    (!empty($_REQUEST['abstract'])) ? $filters .= " and abstract LIKE '%" . $_REQUEST['abstract']."%'": $filters .= "";
    (!empty($_REQUEST['source'])) ? $filters .= " and source LIKE '%" . $_REQUEST['source']."%'": $filters .= "";
    require_once 'views/history/public.php';
  }

  public function New(){
    isset($_REQUEST['id']) ? $id = $this->history->get($_REQUEST['id']) : '';
    require_once 'views/history/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $table = 'history';
    foreach($_POST as $k => $val) {
      if (!empty($val)) {
        if($k != 'id') {
          if($k == 'keywords') {
          $item->{$k} = json_encode($val);
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
    $id = $this->history->get($_REQUEST['id']);
    session_start();
    (!empty($_SESSION["id-DOCS"])) 
    ? $permissions = json_decode($this->users->permissionsGet($_SESSION["id-DOCS"])->permissions, true)
    : $permissions = array();
    session_write_close();
    require_once 'views/history/detail.php';
  }

  public function Delete(){
    $table = 'history';
    $this->init->delete($table,$_REQUEST['id']);
  }

}