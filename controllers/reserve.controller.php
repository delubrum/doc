<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'models/reserve.php';
require_once 'models/users.php';
require_once 'models/init.php';
require_once 'models/projects.php';


include 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReserveController {
  private $model;
  public function __CONSTRUCT(){
    $this->users = new Users();
    $this->init = new Init();
    $this->projects = new Projects();
    $this->reserve = new Reserve();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    isset($_REQUEST['status']) ? $filters = "" : $filters = "and cancelledAt is null";
    if (in_array(40, $permissions)) {
      $filters .= "";
    } elseif (in_array(43, $permissions)) {
        $filters .= "";
    } else {
      $projects = '';
      foreach($this->projects->list() as $r) { 
        $users = json_decode($r->users, true);
        if ($r->users and in_array($user->id, $users)) {
      $projects .= $r->id . ',';
      }
    }
      $projects = rtrim($projects, ',');
      $filters .= " and projectId IN ($projects)";
    }
    (!empty($_REQUEST['id'])) ? $filters .= " and a.id =" . $_REQUEST['id']: $filters .= "";
    (!empty($_REQUEST['materialId'])) ? $filters .= " and materialId =" . $_REQUEST['materialId']: $filters .= "";
    (!empty($_REQUEST['projectId'])) ? $filters .= " and projectId = '" . $_REQUEST['projectId']."'": $filters .= "";
    (!empty($_REQUEST['userId'])) ? $filters .= " and a.userId ='" . $_REQUEST['userId']."'": $filters .= "";
    (!empty($_REQUEST['from'])) ? $filters .= " and a.createdAt  >='" . $_REQUEST['from']."'": $filters .= "";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= "";

    if ((!empty($_REQUEST['status']))) {
      switch (true) {
          case ($_REQUEST['status'] == "Cancelled"):
              $filters .= " and cancelledAt is not null";
              break;
          case ($_REQUEST['status'] == "Approving"):
              $filters .= " and approvedAt is null and cancelledAt is null";
              break;
          case ($_REQUEST['status'] == "Receiving"):
              $filters .= " and approvedAt is not null and receivedAt is null";
              break;
          case ($_REQUEST['status'] == "Closed"):
            $filters .= " and receivedAt is not null";
            break;
      }
    }

    if (in_array(39, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/reserve/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Available(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(41, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/reserve/available.php';
    } else {
      $this->init->redirect();
    }
  }

  public function ImportExcel() {
    $item = new stdClass();
    $error=false;
    $message = '';
    if($_FILES["excel_file"]["name"] != '') {
      $allowed_extension = array('xls', 'xlsx');
      $file_array = explode(".", $_FILES['excel_file']['name']);
      $file_extension = end($file_array);
      if(in_array($file_extension, $allowed_extension)) {
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        $spreadsheet = $reader->load($_FILES['excel_file']['tmp_name']);
        // $message = $writer->save('php://output');
        $excelSheet = $spreadsheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry);

        if ($error) {
            echo $message;
        } else {
          $this->reserve->deleteData();
          for ($i = 1; $i <= $sheetCount; $i ++) {
            $item->id = "";
            if (!empty($spreadSheetAry[$i][0])) {
              $item->id = trim($spreadSheetAry[$i][0]);
            }
            $item->description = "";
            if (!empty($spreadSheetAry[$i][1])) {
              $item->description = addslashes(trim($spreadSheetAry[$i][1]));
            }
            $item->store = "";
            if (!empty($spreadSheetAry[$i][2])) {
              $item->store = trim($spreadSheetAry[$i][2]);
            }
            $item->project = "";
            if (!empty($spreadSheetAry[$i][3])) {
              $item->project = trim($spreadSheetAry[$i][3]);
            } else {
              $item->project = 'Free';
            }
            $item->qty = "";
            if (!empty($spreadSheetAry[$i][4])) {
              $item->qty = trim($spreadSheetAry[$i][4]);
            }
            $item->price = "";
            if (!empty($spreadSheetAry[$i][5]) and preg_replace('/[^0-9]+/', '', trim($spreadSheetAry[$i][4])) != 0) {
              $item->price = preg_replace('/[^0-9]+/', '', trim($spreadSheetAry[$i][5])) / preg_replace('/[^0-9]+/', '', trim($spreadSheetAry[$i][4]));
            } else {
              $item->price = 0;
            }
            if (!empty($item->id) ) {
              $id = $this->reserve->saveData($item);
            }
          }
        }
      }
    }
  }

  public function SaveData(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->id=$_REQUEST['id'];
    $item->description = $_REQUEST['description'];
    $item->project = $_REQUEST['project'];
    $item->qty = $_REQUEST['qty'];
    $item->price = $_REQUEST['price'];
    $id = $this->reserve->saveData($item);
    echo $id; 
  }
  

  public function New(){
    require_once "middlewares/check.php";
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    require_once 'views/reserve/new.php';
  }

  public function Reserve(){
    $title = $_REQUEST['title'] ?? 'Material';
    $status = $_REQUEST['status'] ?? false;
    $id = $this->reserve->get($_REQUEST['id']);
    require_once 'views/reserve/reserve.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->materialId=$_REQUEST['id'];
    $item->description=$_REQUEST['description'];
    $item->store=$_REQUEST['store'];
    $item->projectId=$_REQUEST['projectId'];
    $item->project = $_REQUEST['project'];
    $item->qty = $_REQUEST['qty'];
    $item->price = $_REQUEST['price'];
    $item->notes = $_REQUEST['notes'];
    $project = $item->project;
    $id = $this->reserve->save($item);
    echo $id;
  }

  public function Update(){
    require_once "middlewares/check.php";
    $id = $_REQUEST['id'];
    if ($_REQUEST['status'] == 'approve') {
      $field = 'approvedAt';
      $this->reserve->update($_REQUEST['id'],'reserveId',$_REQUEST['reserveId']);
    }
    if ($_REQUEST['status'] == 'receive') {
      $field = 'receivedAt';
      $this->reserve->update($_REQUEST['id'],'received',$_REQUEST['qty']);
    }
    $this->reserve->updateField($_REQUEST['id'],$field);
    echo $id;
  }

  public function CheckCancel(){
    $id = $this->reserve->checkCancel($_REQUEST['id']);
    echo $id;
  }

  public function Check(){
    $id = $this->reserve->check($_REQUEST['id']);
    echo $id;
  }

}