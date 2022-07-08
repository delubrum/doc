<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/projects.php';
require_once 'models/partnumbers.php';
require_once 'models/users.php';
require_once 'models/init.php';


class PartNumbersController{
  private $model;
  public function __CONSTRUCT(){
    $this->pn = new PartNumbers();
    $this->projects = new Projects();
    $this->users = new Users();
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(22, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/partNumbers/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Edit(){
    $item = $this->projects->get($_REQUEST['id']);
    require_once 'views/partNumbers/process.php';
  }
  
  public function Add(){
    if (isset($_REQUEST['id'])) {
      $item = $this->pn->get($_REQUEST['id']);
      $id = true;
    } else {
      $item = new stdClass();
      $item->projectId = $_REQUEST['projectId'];
      $item->designation = $this->projects->get($_REQUEST['projectId'])->designation;
    }
    require_once 'views/partNumbers/add.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->projectId=$_REQUEST['projectId'];
    $item->description=addslashes($_REQUEST['description']);
    $item->part=$_REQUEST['part'];
    $item->material=$_REQUEST['material'];
    $item->userId = $_SESSION["id-SIGMA"];

    !empty($this->pn->lastPN($_REQUEST['projectId'],$_REQUEST['part'])->name)
    ? $count = substr($this->pn->lastPN($_REQUEST['projectId'],$_REQUEST['part'])->name,-4) + 1
    : $count = + 1;
    
    $id = str_pad($count, 4, '0', STR_PAD_LEFT);
    $item->name = $_REQUEST['designation'] . "-" . $_REQUEST['part'] . "-" . $id;
    $this->pn->save($item);
    echo $_REQUEST['projectId'];
  }

  public function List($id = null){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    (!$id) ? $id = $this->projects->get($_REQUEST['id']) : $id = $this->projects->get($id);
    require_once 'views/partNumbers/item_list_row.php';
  }

  public function Delete(){
    $this->pn->delete($_REQUEST['id']);
    echo $_REQUEST['project'];
  }
  public function Update(){
    $item = new stdClass();
    $item->id=$_REQUEST['id'];
    isset($_REQUEST['material']) ? $item->material=$_REQUEST['material'] : $item->material = $this->pn->get($_REQUEST['id'])->material;
    isset($_REQUEST['description']) ? $item->description=$_REQUEST['description'] : $item->description = $this->pn->get($_REQUEST['id'])->description;
    $this->pn->update($item);
  }

  public function Excel(){
    $id = $_REQUEST['id'];
    $this->init->toExcel($this->pn->excel($id),'PartNumbers');
  }

}