<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/workorders.php';
require_once 'models/bom.php';
require_once 'models/users.php';
require_once 'models/projects.php';
require_once 'models/login.php';


include 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class BOMController{
  private $model;
  public function __CONSTRUCT(){
    $this->wo = new WorkOrders();
    $this->init = new Init();
    $this->bom = new BOM();
    $this->users = new Users();
    $this->projects = new Projects();
    $this->login = new Login();


  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    isset($_REQUEST['id']) ? $filters = "" : $filters = " and a.cancelledAt is null";
    if (in_array(25, $permissions)) {
      $filters .= "";
    } elseif (in_array(27, $permissions)) {
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
    (!empty($_REQUEST['projectId'])) ? $filters .= " and projectId = '" . $_REQUEST['projectId']."'": $filters .= "";
    (!empty($_REQUEST['userId'])) ? $filters .= " and a.userId ='" . $_REQUEST['userId']."'": $filters .= "";
    (!empty($_REQUEST['from'])) ? $filters .= " and a.createdAt  >='" . $_REQUEST['from']."'": $filters .= "";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= "";

    if ((!empty($_REQUEST['status']))) {
      switch (true) {
          case ($_REQUEST['status'] == "Cancelled"):
              $filters .= " and a.cancelledAt is not null";
              break;
          case ($_REQUEST['status'] == "Delivering"):
              $filters .= " and a.sentAt is not null and storedAt is null";
              break;
          case ($_REQUEST['status'] == "Processing"):
              $filters .= " and a.sentAt is null and a.cancelledAt is null";
              break;
          case ($_REQUEST['status'] == "SAP Saving"):
              $filters .= " and a.storedAt is not null";
              break;
          case ($_REQUEST['status'] == "Closed"):
            $filters .= " and a.storedAt is not null";
            break;
      }
    }
    if (in_array(23, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/bom/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    require_once 'views/bom/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->woId=$_REQUEST['woId'];
    !empty($this->bom->code($_REQUEST['woId'])->code)
    ? $item->code = $this->bom->code($_REQUEST['woId'])->code + 1
    : $item->code = 1;
    $id = $this->bom->save($item);
    echo json_encode(array("id" => $id, "title" => "Process Bill Of Materials", "status" => "process"));
  }

  public function BOM(){
    require_once "middlewares/check.php";
    $id = $this->bom->get($_REQUEST['id']);
    $title = $_REQUEST['title'] ?? '';
    $status = $_REQUEST['status'];
    (!empty($_SESSION["id-SIGMA"])) ?
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true)
    : $permissions = array();
    if ($status == 'view') {
      require_once 'views/bom/detail.php';
    } else {
    require_once 'views/bom/bom.php';
    }
  }

  public function ItemList($id = null){
    require_once "middlewares/check.php";
    $status = $_REQUEST['status'];
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    (!$id) ? $id = $this->bom->get($_REQUEST['id']) : $id = $this->bom->get($id);
    require_once 'views/bom/list_items.php';
  }

  public function NewItem(){
    $bomId = $_REQUEST['bom'];
    isset($_REQUEST['id']) ? $id = $this->bom->itemGet($_REQUEST['id']) : '';
    require_once 'views/bom/new_item.php';
  }

  public function Deliver(){
    $id = $this->bom->itemGet($_REQUEST['id']);
    $status = $_REQUEST['status'];
    require_once 'views/bom/deliver.php';
  }

  public function DeliverList($id = null){
    require_once "middlewares/check.php";
    $status = $_REQUEST['status'];
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $filters = " and itemId = " . $_REQUEST['id'];
    (!$id) ? $id = $this->bom->itemGet($_REQUEST['id']) : $id = $this->bom->itemGet($id);
    require_once 'views/bom/list_delivers.php';
  }

  public function NewDeliver(){
    $itemId = $_REQUEST['id'];
    $bomId = $_REQUEST['bom'];
    require_once 'views/bom/new_deliver.php';
  }

  public function ItemSave(){
    $item = new stdClass();
    $item->bomId = $_REQUEST['id'];
    $item->description = $_REQUEST['description'];
    $item->alloy = $_REQUEST['alloy'];
    $item->size = addslashes($_REQUEST['size']);
    $item->length = $_REQUEST['length'];
    $item->uom = $_REQUEST['uom'];
    $item->finish = $_REQUEST['finish'];
    $item->qty = $_REQUEST['qty'];
    $item->location = $_REQUEST['location'];
    $item->destination = $_REQUEST['destination'];
    $item->requisition = $_REQUEST['requisition'];
    $item->notes = $_REQUEST['notes'];
    $id = $this->bom->itemSave($item);
    echo $_REQUEST['id'];
  }

  public function ImportExcel() {
    $item = new stdClass();
    $item->bomId = $_REQUEST['id'];
    $error=false;
    $message = '';
    $number = '';
    $number_array = array();
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
          for ($i = 1; $i <= $sheetCount; $i ++) {
            $item->description = "";
            if (isset($spreadSheetAry[$i][0])) {
              $item->description = $spreadSheetAry[$i][0];
            }
            $item->alloy = "";
            if (isset($spreadSheetAry[$i][1])) {
              $item->alloy = $spreadSheetAry[$i][1];
            }
            $item->size = "";
            if (isset($spreadSheetAry[$i][2])) {
                $item->size = addslashes($spreadSheetAry[$i][2]);
            }
            $item->length = "";
            if (isset($spreadSheetAry[$i][3])) {
                $item->length = addslashes($spreadSheetAry[$i][3]);
            }
            $item->uom = "";
            if (isset($spreadSheetAry[$i][4])) {
                $item->uom = $spreadSheetAry[$i][4];
            }
            $item->finish = "";
            if (isset($spreadSheetAry[$i][5])) {
                $item->finish = $spreadSheetAry[$i][5];
            }
            $item->qty = "";
            if (isset($spreadSheetAry[$i][6])) {
                $item->qty = $spreadSheetAry[$i][6];
            }
            $item->location = "";
            if (isset($spreadSheetAry[$i][7])) {
                $item->location = $spreadSheetAry[$i][7];
            }
            $item->destination = "";
            if (isset($spreadSheetAry[$i][8])) {
                $item->destination = $spreadSheetAry[$i][8];
            }
            $item->requisition = "";
            if (isset($spreadSheetAry[$i][9])) {
                $item->requisition = $spreadSheetAry[$i][9];
            }
            $item->notes = "";
            if (isset($spreadSheetAry[$i][10])) {
                $item->notes = $spreadSheetAry[$i][10];
            }
            if (! empty($item->description) ) {
              $id = $this->bom->itemSave($item);
            }
          }
        }
      }
    }
    echo $_REQUEST['id'];
  }

  public function FormSave(){
    $id = $_REQUEST['id'];
    if ($_REQUEST['status'] == 'process') {
      $field = 'sentAt';
    }

    if ($_REQUEST['status'] == 'confirm') {
      $field = 'storedAt';
    }

    $this->bom->updateField($_REQUEST['id'],$field);
    echo $_REQUEST['id'];
  }

  public function Delete(){
    $this->bom->updateField($_REQUEST['id'],'cancelledAt');
  }

  public function ItemDelete(){
    $this->bom->itemDelete($_REQUEST['id']);
    echo $_REQUEST['bom'];
  }

  public function ItemDeleteAll(){
    foreach($this->bom->itemList($_REQUEST['bom']) as $r) {
    $this->bom->itemDelete($r->id);
    }
    echo $_REQUEST['bom'];
  }

  public function DeliverSave(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->itemId=$_REQUEST['itemId'];
    $item->bomId=$_REQUEST['bomId'];
    $item->qty=$_REQUEST['qty'];
    $item->notes=$_REQUEST['notes'];
    $password=strip_tags($_REQUEST['pass']);
    $email=strip_tags($_REQUEST['email']);
    if ($this->login->getUserByEmail($email)) {
      $user = $this->login->getUserByEmail($email);
      if (password_verify($password, $user->password)) {
        $item->signId = $user->id;
        $id = $this->bom->deliverSave($item);
      }
    }
    !empty($id) ? $id = $id : $id = 'error';
    echo json_encode(array("id" => $id, "itemId" => "$item->itemId", "bomId" => "$item->bomId"));
  }

  public function DeliverForm(){
    $this->bom->updateDeliverField($_REQUEST['id'],'SAP');
    echo $_REQUEST['id'];
  }

  public function SAPCode(){
    $this->bom->updateSapCode($_REQUEST['code'],$_REQUEST['id']);
    echo $_REQUEST['id'];
  }

}