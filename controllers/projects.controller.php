<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/projects.php';
require_once 'models/users.php';
require_once 'models/init.php';


class ProjectsController{
  private $model;
  public function __CONSTRUCT(){
    $this->projects = new Projects();
    $this->users = new Users();
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(18, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/projects/index.php';
    } else {
      $this->init->redirect();
    }
  }
  
  public function New(){
    isset($_REQUEST['id']) ? $id = $this->projects->get($_REQUEST['id']) : '';
    require_once 'views/projects/new.php';
  }

  public function Save(){
    $item = new stdClass();
    $item->name=$_REQUEST['name'];
    $item->designation=$_REQUEST['designation'];
    $item->userId=$_REQUEST['userId'];
    $item->pmId=$_REQUEST['pmId'];
    $item->clientId=$_REQUEST['clientId'];
    $item->currency=$_REQUEST['currency'];
    $item->approvedby=$_REQUEST['approvedby'];
    $item->price = preg_replace('/[^0-9]+/', '', $_REQUEST['price']);
    if (!empty($_REQUEST['projectId'])) {
      $item->projectId = $_REQUEST['projectId'];
      $this->projects->update($item);
    } else {
      $this->projects->save($item);
    }
    echo $item->approvedby;
    echo $_REQUEST['projectId'];
  }

  public function Users(){
    isset($_REQUEST['id']) ? $id = $this->projects->get($_REQUEST['id']) : '';
    require_once 'views/projects/users.php';
  }

  public function UserList($id = null){
    (!$id) ? $id = $this->projects->get($_REQUEST['id']) : $id = $this->projects->get($id);
    (isset($_REQUEST['status'])) ? $status = $_REQUEST['status'] : $status = '';
    require_once 'views/projects/users_list.php';
  }

  public function UserAdd(){
    if ($this->projects->get($_REQUEST['project'])->users) {
    $users = json_decode($this->projects->get($_REQUEST['project'])->users,true);
    } else {
      $users = array();
    }
    array_push($users, $_REQUEST['userId']);
    $users = json_encode($users);
    $this->projects->usersUpdate($users,$_REQUEST['project']);
    echo $_REQUEST['project'];
  }

  public function UserDelete(){
    $users = json_decode($this->projects->get($_REQUEST['project'])->users,true);
    if (($key = array_search($_REQUEST['id'], $users)) !== false) {
      unset($users[$key]);
    }
    $users = json_encode($users);
    $this->projects->usersUpdate($users,$_REQUEST['project']);
    echo $_REQUEST['project'];
  }

  public function Close(){
    $this->projects->close($_REQUEST['id']);
  }

  public function Refresh(){
    $this->projects->refresh($_REQUEST['id']);
  }

}