<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/workorders.php';
require_once 'models/projects.php';
require_once 'models/machines.php';

include 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class WorkOrdersController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new WorkOrders();
    $this->wo = new WorkOrders();
    $this->init = new Init();
    $this->users = new Users();
    $this->projects = new Projects();
    $this->machines = new Machines();
  }


  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    $filters = '';
    if (in_array(28, $permissions)) {
      $filters .= "and cancelledAt is null";
    } else {
      $projects = '';
      foreach($this->projects->list('and closedAt is null') as $r) { 
        $users = json_decode($r->users, true);
        if ($r->users and in_array($user->id, $users)) {
      $projects .= $r->id . ',';
      }
    }
      $projects = rtrim($projects, ',');
      $filters .= "and cancelledAt is null and a.projectId IN ($projects)";
    }
    (!empty($_REQUEST['id'])) ? $filters .= " and a.id =" . $_REQUEST['id']: $filters .= "";
    (!empty($_REQUEST['projectId'])) ? $filters .= " and projectId = '" . $_REQUEST['projectId']."'": $filters .= "";
    (!empty($_REQUEST['userId'])) ? $filters .= " and a.userId ='" . $_REQUEST['userId']."'": $filters .= "";
    (!empty($_REQUEST['from'])) ? $filters .= " and a.sentAt  >='" . $_REQUEST['from']."'": $filters .= "";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.sentAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= "";

    if ((!empty($_REQUEST['status']))) {
      switch (true) {
          case ($_REQUEST['status'] == "Cancelled"):
              $filters .= " and a.cancelledAt is not null";
              break;
          case ($_REQUEST['status'] == "Processing"):
              $filters .= " and a.processedAt is null";
              break;
          case ($_REQUEST['status'] == "Checking"):
              $filters .= " and a.processedAt is not null and a.confirmedAt is null";
              break;
          case ($_REQUEST['status'] == "Approval"):
            $filters .= " and a.confirmedAt is not null and a.sentAt is null";
            break;
          case ($_REQUEST['status'] == "Production"):
            $filters .= " and a.sentAt is not null and a.closedAt is null";
            break;
          case ($_REQUEST['status'] == "Closed"):
            $filters .= " and a.closedAt is not null";
            break;
      }
    }
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(3, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/workOrder/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    require_once 'views/workOrder/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->projectId=$_REQUEST['projectId'];
    $item->scope = addslashes($_REQUEST['scope']);
    !empty($this->wo->code($_REQUEST['projectId'])->code)
    ? $item->code = $this->wo->code($_REQUEST['projectId'])->code + 1
    : $item->code = 1;
    $id = $this->wo->save($item);
    echo json_encode(array("id" => $id, "title" => "Process Work Order", "status" => "process"));
  }

  public function WorkOrder(){
    $id = $this->wo->get($_REQUEST['id']);
    $title = $_REQUEST['title'] ?? '';
    $status = $_REQUEST['status'];
    session_start();
    (!empty($_SESSION["id-SIGMA"])) 
    ? $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true)
    : $permissions = array();
    session_write_close();
    if ($status == 'view') {
      require_once 'views/workOrder/detail.php';
    } else {
    require_once "middlewares/check.php";
    require_once 'views/workOrder/workOrder.php';
    }
  }

  public function Item(){
    require_once "middlewares/check.php";
    $id = $this->wo->itemGet($_REQUEST['id']);
    $wo = $this->wo->get($id->woId);
    require_once 'views/workOrder/detail_item.php';
  }

  public function ItemList($id = null){
    require_once "middlewares/check.php";
    $status = $_REQUEST['status'];
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    (!$id) ? $id = $this->wo->get($_REQUEST['id']) : $id = $this->wo->get($id);
    require_once 'views/workOrder/list_items.php';
  }

  public function NewItem(){
    $woId = $_REQUEST['wo'];
    isset($_REQUEST['id']) ? $id = $this->wo->itemGet($_REQUEST['id']) : '';
    require_once 'views/workOrder/new_item.php';
  }

  public function ItemSave(){
    $message = '';
    $error = false;
    $item = new stdClass();
    $item->woId = $_REQUEST['id'];
    $item->number = trim($_REQUEST['number']);
    $item->name = addslashes($_REQUEST['name']);
    $item->weight = $_REQUEST['weight'];
    $item->uom = trim($_REQUEST['uom']);
    $item->pa = $_REQUEST['pa'];
    $item->pauom = $_REQUEST['pauom'];
    $item->finish = $_REQUEST['finish'];
    $item->qty = $_REQUEST['qty'];
    $item->notes = $_REQUEST['notes'];
    isset($_REQUEST['processes']) ? $item->processes=json_encode($_REQUEST['processes']) : $item->processes='';
    if (isset($this->model->checkDuplicatedPartNumber($item->number,$item->woId)->id)) {
      $error=true;
      $message = 'Part Number is duplicated';
    }
    if (!$this->wo->checkPartNumberName($item->number)->id) {
      $error=true;
      $message = 'Part number does not exist';
    }
    if ($error) {
      echo $message;
    } else {
      $id = $this->wo->itemSave($item);
      echo $_REQUEST['id'];
    }




  }

  public function ImportExcel() {
    $item = new stdClass();
    $item->woId = $_REQUEST['id'];
    $error=false;
    $message = '';
    $number = '';
    $uom = '';
    $pauom = '';
    $we = '';
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
        for ($i = 1; $i <= $sheetCount; $i ++) {
          if (isset($spreadSheetAry[$i][0])) {
            $number = trim($spreadSheetAry[$i][0]);
            $number_array[] = $number;
            if(trim($spreadSheetAry[$i][3]) != 'lbmass') {
              $uom = 'error';
            }
            if(trim($spreadSheetAry[$i][5]) != 'mm^2') {
              $pauom = 'error';
            }
            if(trim($spreadSheetAry[$i][2]) == 0 || trim($spreadSheetAry[$i][2]) > 1000 ) {
              $we = 'error';
            }
          }
          if (isset($this->model->checkPartNumberName($number)->id)) {
          } else {
            if (!empty($number) ) {
              $error=true;
              $message = 'Part Number does not exist';
            }
          }
        }
        if (isset($this->model->checkDuplicatedPartNumber($number,$item->woId)->id)) {
          $error=true;
          $message = 'Part Number is duplicated';
        }
        $unique = array_unique($number_array);
        $duplicates = array_diff_assoc($number_array, $unique);
        if ($duplicates) {
          $error=true;
          $message = 'Part Number is duplicated';      
        }
        if ($uom == 'error') {
          $error=true;
          $message = 'Part Number UOM is not lbmass';      
        }
        if ($pauom == 'error') {
          $error=true;
          $message = 'Part Number PA UOM is not mm^2';      
        }
        if ($we == 'error') {
          $error=true;
          $message = 'Mass is 0 or over 1000';      
        }
        if ($error) {
            echo $message;
        } else {
          for ($i = 1; $i <= $sheetCount; $i ++) {
            $item->number = "";
            if (!empty($spreadSheetAry[$i][0])) {
              $item->number = trim($spreadSheetAry[$i][0]);
            }
            $item->name = "";
            if (!empty($spreadSheetAry[$i][1])) {
              $item->name = $spreadSheetAry[$i][1];
            }
            $item->weight = "";
            if (!empty($spreadSheetAry[$i][2])) {
              $item->weight = $spreadSheetAry[$i][2];
            }
            $item->uom = "";
            if (!empty($spreadSheetAry[$i][3])) {
              $item->uom = trim($spreadSheetAry[$i][3]);
            }
            $item->pa = "";
            if (!empty($spreadSheetAry[$i][4])) {
              $item->pa = mb_convert_case($spreadSheetAry[$i][4], MB_CASE_TITLE, "UTF-8");
            }
            $item->pauom = "";
            if (!empty($spreadSheetAry[$i][5])) {
              $item->pauom = $spreadSheetAry[$i][5];
            }
            $item->finish = "";
            if (!empty($spreadSheetAry[$i][6])) {
              $item->finish = mb_convert_case($spreadSheetAry[$i][6], MB_CASE_TITLE, "UTF-8");
            }
            $item->qty = "";
            if (!empty($spreadSheetAry[$i][7])) {
              $item->qty = $spreadSheetAry[$i][7];
            }
            $item->notes = "";
            if (!empty($spreadSheetAry[$i][8])) {
              $item->notes = $spreadSheetAry[$i][8];
            }
            $item->processes = array();
            if (!empty($spreadSheetAry[$i][9])) {
              $val = mb_convert_case($spreadSheetAry[$i][9], MB_CASE_UPPER, "UTF-8");
              if ( $val == 'X') {
                $item->processes[] = '2';
              }
            }
            if (!empty($spreadSheetAry[$i][10])) {
              $val = mb_convert_case($spreadSheetAry[$i][10], MB_CASE_UPPER, "UTF-8");
              if ( $val == 'X') {
                $item->processes[] = '3';
              }
            }
            if (!empty($spreadSheetAry[$i][11])) {

                $val = mb_convert_case($spreadSheetAry[$i][11], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                  $item->processes[] = '5';
                }
            }
            if (!empty($spreadSheetAry[$i][12])) {
                $val = mb_convert_case($spreadSheetAry[$i][12], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                  $item->processes[] = '1';
                }
            }
            if (!empty($spreadSheetAry[$i][13])) {
                $val = mb_convert_case($spreadSheetAry[$i][13], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                    $item->processes[] = '4';
                }
            }
            if (!empty($spreadSheetAry[$i][14])) {
                $val = mb_convert_case($spreadSheetAry[$i][14], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                    $item->processes[] = '6';
                }
            }
            if (!empty($spreadSheetAry[$i][15])) {
                $val = mb_convert_case($spreadSheetAry[$i][15], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                    $item->processes[] = '7';
                }
            }
            if (!empty($spreadSheetAry[$i][16])) {
                $val = mb_convert_case($spreadSheetAry[$i][16], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                    $item->processes[] = '8';
                }
            }
            if (!empty($spreadSheetAry[$i][17])) {
                $val = mb_convert_case($spreadSheetAry[$i][17], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                    $item->processes[] = '10';
                }
            }
            if (!empty($spreadSheetAry[$i][18])) {
                $val = mb_convert_case($spreadSheetAry[$i][18], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                    $item->processes[] = '11';
                }
            }
            if (!empty($spreadSheetAry[$i][19])) {
                $val = mb_convert_case($spreadSheetAry[$i][19], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                    $item->processes[] = '12';
                }
            }
            if (!empty($spreadSheetAry[$i][20])) {
                $val = mb_convert_case($spreadSheetAry[$i][20], MB_CASE_UPPER, "UTF-8");
                if ( $val == 'X') {
                    $item->processes[] = '13';
                }
            }
            if (! empty($item->number) ) {
              $item->processes = json_encode($item->processes);
              $id = $this->model->itemSave($item);
            }
          }
          echo $_REQUEST['id'];
        }
      }
    }
  }

  public function FormSave(){
    $id = $_REQUEST['id'];

    if ($_REQUEST['status'] == 'process') {
      $field = 'processedAt';
      $folder = "uploads/workOrders/other/$id";
      if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
      }
      if (!empty($_FILES['other'])) {
          $newfilename = "OTHER.zip";
          $path = "$folder/";
          $path = $path . $newfilename;
          if (move_uploaded_file($_FILES['other']['tmp_name'], $path)) {
          }
      }

      $folder = "uploads/workOrders/DXF/$id";
      if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
      }
      $total = count($_FILES['DXF']['name']);
      for ($i = 0; $i < $total; $i++) {
          $tmpFilePath = $_FILES['DXF']['tmp_name'][$i];
          if ($tmpFilePath != "") {
              $newFilePath = "$folder/" . $_FILES['DXF']['name'][$i];
              if (move_uploaded_file($tmpFilePath, $newFilePath)) {
              }
          }
      }

      $folder = "uploads/workOrders/PDF/$id";
      if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
      }
      if (!empty($_FILES['PDF'])) {
          $newfilename = "PDF.zip";
          $path = "$folder/";
          $path = $path . $newfilename;
          if (move_uploaded_file($_FILES['PDF']['tmp_name'], $path)) {
          }
      }

      $folder = "uploads/workOrders/STP/$id";
      if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
      }
      if (!empty($_FILES['STP'])) {
        $newfilename = "STP.zip";
          $path = "$folder/";
          $path = $path . $newfilename;
          if (move_uploaded_file($_FILES['STP']['tmp_name'], $path)) {
          }
      }
    }

    if ($_REQUEST['status'] == 'confirm') {
      $field = 'confirmedAt';
    }

    if ($_REQUEST['status'] == 'send') {
      $field = 'sentAt';
      $item = new stdClass();
      $item->id = $_REQUEST['id'];
      $item->to = $_REQUEST['to'];
      require_once "middlewares/check.php";
      $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
      $item->email = $this->users->UserGet($this->wo->get($_REQUEST['id'])->userId)->email;
      //$item->pass = $this->users->UserGet($this->wo->get($_REQUEST['id'])->userId)->emailPassword;
      $item->subject = $_REQUEST['subject'];
      $item->type = 'workOrder';
      $body = "<br><br> Puede consultar la información en el siguiente link:<br>
              <a href='http://aei-sigma.com/sigma/?c=WorkOrders&a=WorkOrder&status=view&id=$item->id'>LINK</a><br>";
      $item->body = nl2br($_REQUEST['body']) . $body;
      $msg = $this->init->sendEmail($item);
      echo json_encode(array("msg" => $msg, "id" => $item->id));
    }

    if ($_REQUEST['status'] == 'close') {
      $field = 'closedAt';
      $item = new stdClass();
      $item->id = $_REQUEST['id'];
      $item->to[] = $this->wo->get($_REQUEST['id'])->pmemail;
      require_once "middlewares/check.php";
      $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
      $item->email = $user->email;
      //$item->pass = $user->emailPassword;
      $item->subject = "WORK ORDER CLOSED / id: $item->id";
      $item->type = 'workOrder_closed';
      $item->body = "<br><br> Puede consultar la información en el siguiente link:<br>
              <a href='http://aei-sigma.com/sigma/?c=WorkOrders&a=WorkOrder&status=view&id=$item->id'>LINK</a><br>";
      $this->init->sendEmail($item);
    }

    $this->wo->updateField($_REQUEST['id'],$field);
    echo $_REQUEST['id'];
  }

  public function Modify(){
    $this->wo->modify($_REQUEST['id']);
  }

  public function Delete(){
    if ($_REQUEST['status'] == 'email') {
      $item = new stdClass();
      $item->id = $_REQUEST['id'];
      $item->to[] = $this->wo->get($_REQUEST['id'])->pmemail;
      require_once "middlewares/check.php";
      $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
      $item->email = $user->email;
      //$item->pass = $user->emailPassword;
      $item->type = 'workOrder_cancelled';
      $item->subject = "WORK ORDER CANCELLED / id: $item->id";
      $item->body = "<br><br> Puede consultar la información en el siguiente link:<br>
              <a href='http://aei-sigma.com/sigma/?c=WorkOrders&a=WorkOrder&status=view&id=$item->id'>LINK</a><br>";
      $this->init->sendEmail($item);
    }
    $this->wo->updateField($_REQUEST['id'],'cancelledAt');
  }

  public function ItemDelete(){
    $this->wo->itemDelete($_REQUEST['id']);
    echo $_REQUEST['wo'];
  }

  public function ItemDeleteAll(){
    foreach($this->wo->itemList($_REQUEST['wo']) as $r) {
    $this->wo->itemDelete($r->id);
    }
    echo $_REQUEST['wo'];
  }

  public function ItemForm(){
    if($_REQUEST['status'] == 'close') {
      $field = 'closedAt';
    }
    if($_REQUEST['status'] == 'cancel') {
      $field = 'sentAt';
      $item = new stdClass();
      $item->id = $_REQUEST['id'];
      $woId = $this->wo->itemGet($_REQUEST['id'])->woId;
      $item->to[] = $this->wo->get($woId)->pmemail;
      require_once "middlewares/check.php";
      $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
      $item->email = $user->email;
      //$item->pass = $user->emailPassword;
      $item->type = 'workOrder_item_cancelled';
      $item->subject = "WORK ORDER CANCELLED ITEM / ITEM id: $item->id";
      $item->body = "<br><br> Puede consultar la información en el siguiente link:<br>
              <a href='http://aei-sigma.com/sigma/?c=WorkOrders&a=WorkOrder&status=view&id=$woId'>LINK</a><br>";
      $msg = $this->init->sendEmail($item);
      echo json_encode(array("msg" => $msg, "id" => $item->id));
      $field = 'cancelledAt';
    }
    $this->wo->updateItemField($_REQUEST['id'],$field);
    echo $_REQUEST['id'];
  }

  public function Tickets(){
    $array = $_REQUEST['id'];
    $val = $_REQUEST['val'];
    echo '<div class="col-12">
    <button type="button" class="btn btn-primary printBtn float-right noprint m-1" onclick="window.print();return false;"><i class="fas fa-print"></i></button>
    </div>';
    for ($i = 0; $i < count($array) ; $i++) {
      $id = $this->wo->itemGet($array[$i]);
      $wo = $this->wo->get($id->woId);
      for ($j = 0; $j < $val[$i]; $j++) {
        require 'views/workOrder/tickets.php';
      }
    }
  }












  

  public function Schedule(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $filters = 'AND scheduledAt is null AND closedAt is null';
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(4, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/workOrder/pn.php';
      require_once 'views/workOrder/new.php';
    } else {
      $this->init->redirect();
    }
  }

  public function CalendarByMachine(){
    require_once "middlewares/check.php";
    isset($_SESSION["id-SIGMA"]) ?  $user = $this->users->UserGet($_SESSION["id-SIGMA"]) : $user = (object)array("id"=>0);
    $machineId = $_REQUEST['id'] ?? 1;
    $view = $_REQUEST['view'] ?? 'timeGridWeek';
    $date = $_REQUEST['date'] ?? date("Y-m-d");
    $filters = 'AND scheduledAt is null AND closedAt is null';
    require_once 'views/workOrder/calendar.php';
  }

  public function WorkOrderItemGet(){
    $id=$_REQUEST['id'];
    $wo_item = $this->model->WorkOrderItemGet($id);
    $wo = $this->model->WorkOrderGet($wo_item->wo);
    $processes = array('cut','laser','punch','router','brake','cnc_profiles','drilling','welding','pretreatment','painting','assembly','packing');
    $processesb = array('cut','laser','punch','router','brake','cnc_profiles','drilling','welding','pretreatment','painting','assembly','packing','other');
    require_once 'views/workOrder/schedule.php';
  }

  public function newEvent(){
    require_once 'views/workOrder/new_event.php';
  }

  public function ZipFile(){
      $id = $_REQUEST['id'];
      $zip = $_REQUEST['zip'];
      $file = $_REQUEST['file'];
      $folder = $_REQUEST['folder'];
      header('Content-Disposition: attachment; filename="'.$file.'"');
      $pdf = file_get_contents("zip://uploads/workOrders/$folder/$id/$zip#$file");
      echo $pdf;
  }

  public function ZipFilePDF(){
    $id = $_REQUEST['id'];
    $zip = $_REQUEST['zip'];
    $file = $_REQUEST['file'];
    $folder = $_REQUEST['folder'];
    header("Content-type: application/pdf");
    header('Content-Disposition: inline; filename="'.$file.'"');
    $pdf = file_get_contents("zip://uploads/workOrders/$folder/$id/$zip#$file");
    echo $pdf;
  }

  public function Excel($id = null){
    header("Content-type: application/vnd.ms-excel; name='excel'");
    header("Content-Disposition: filename=WoExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    (!$id) ? $id = $this->wo->get($_REQUEST['id']) : $id = $this->wo->get($id);
    $status = 'print';
    require_once 'views/workOrder/list_items.php';
  }

  public function InfoUpdate(){
    $item = new stdClass();
    $item->id = $_REQUEST['id'];
    $item->scope=addslashes($_REQUEST['scope']);
    $this->wo->infoUpdate($item);
  }

  public function Daily(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    $filters = '';
    $datenow = date('Y-m-d');// date now
    // First day of the month.
    $mon = date('Y-m-01', strtotime($datenow));
    // Last day of the month.
    $sun = date('Y-m-t', strtotime($datenow));
    (!empty($_REQUEST['from'])) ? $filters .= " and sentAt  >='" . $_REQUEST['from']."'": $filters .= " and sentAt  >= '$mon'";
    (!empty($_REQUEST['to'])) ? $filters .= " and sentAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= " and sentAt  <= '$sun 23:59:59'";
    if (in_array(33, $permissions)) {
      $dates = array();
      $totals = array();
      foreach($this->wo->daily($filters) as $r) {
        $dates[] = $r->date;
        $totals[] = $r->total;
      }
      $total = array_sum($totals);
      $average = ceil($total/count($totals));
      $axis = json_encode($dates);
      $totals = json_encode($totals, JSON_NUMERIC_CHECK);

      $weightTotals = array();
      foreach($dates as $d) {
        $weightTotals[] = round($this->wo->dailyWeight($d)->total/2.20462,2);       
      }

      $weightTotal = array_sum($weightTotals);
      $weightAverage = round($weightTotal/count($weightTotals),2);

      $weightTotals = json_encode($weightTotals, JSON_NUMERIC_CHECK);



      $itemTotals = array();
      foreach($this->wo->itemDaily($filters) as $r) {
        $itemTotals[] = $r->total;
      }
      $itemTotal = array_sum($itemTotals);
      (count($itemTotals) != 0) ? $itemAverage = ceil($itemTotal/count($itemTotals)) : $itemAverage = 0;
      $itemTotals = json_encode($itemTotals, JSON_NUMERIC_CHECK);

      $totalAverage = ceil($itemAverage / $average);



      require_once 'views/layout/header.php';
      require_once 'views/workOrder/daily.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Monthly(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    (!empty($_REQUEST['year'])) ? $year = $_REQUEST['year'] : $year = date('Y');
    if (in_array(33, $permissions)) {
      $dates = array();
      $totals = array();
      foreach($this->wo->monthly($year) as $r) {
        $dates[] = $r->date;
        $totals[] = $r->total;
      }
      $total = array_sum($totals);
      $average = ceil($total/count($totals));
      $axis = json_encode($dates);
      $totals = json_encode($totals, JSON_NUMERIC_CHECK);


      $weightTotals = array();
      foreach($this->wo->monthlyWeight($year) as $r) {
        $weightTotals[] = round($r->total/2.20462,2);
      }
      $weightTotal = array_sum($weightTotals);
      $weightAverage = round($weightTotal/count($weightTotals),2);
      $weightTotals = json_encode($weightTotals, JSON_NUMERIC_CHECK);

      $itemTotals = array();
      foreach($this->wo->itemMonthly($year) as $r) {
        $itemTotals[] = $r->total;
      }
      $itemTotal = array_sum($itemTotals);
      (count($itemTotals) != 0) ? $itemAverage = ceil($itemTotal/count($itemTotals)) : $itemAverage = 0;
      $itemTotals = json_encode($itemTotals, JSON_NUMERIC_CHECK);

      $totalAverage = ceil($itemAverage / $average);
      require_once 'views/layout/header.php';
      require_once 'views/workOrder/monthly.php';
    } else {
      $this->init->redirect();
    }
  }


  public function Pending(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(20, $permissions)) {
      $Production = 'and a.sentAt is not null and a.cancelledAt is null and a.closedAt is null';
      $Closed = 'and a.sentAt is not null and a.closedAt is not null';
      $Cancelled = 'and a.sentAt is not null and a.cancelledAt is not null';
      $array = array('Production','Closed','Cancelled');

      require_once 'views/layout/header.php';
      require_once 'views/workOrder/pending.php';
    } else {
      $this->init->redirect();
    }
  }

  public function PendingDetails(){
    $Production = 'and a.sentAt is not null and a.cancelledAt is null and a.closedAt is null';
    $Closed = 'and a.sentAt is not null and a.closedAt is not null';
    $Cancelled = 'and a.sentAt is not null and a.cancelledAt is not null';
    $filters = ${$_REQUEST['id']};
    $status = 'view';
    echo '
    <div class="modal-header">
      <h5 class="modal-title">' . $_REQUEST['id'] . ' Detail</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
    ';
    require_once 'views/workOrder/list.php';
    echo '
    </div>
    <script>
    
    $(document).ready(function() {
      var table = $("#example").DataTable({
          "order": [],
          "lengthChange": false,
          "paginate": false,
        "scrollX": true,
        "autoWidth": false
      });

      setTimeout( function(){ 
        table.draw()
    }  , 200 );
    });
    </script>
    ';
  }

}