<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/purchases.php';
require_once 'models/projects.php';

include 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PurchasesController{
  private $model;
  public function __CONSTRUCT(){
    $this->purchases = new Purchases();
    $this->projects = new Projects();
    $this->init = new Init();
    $this->users = new Users();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->userGet($_SESSION["id-SIGMA"]);
    $userId = $_SESSION['id-SIGMA'];
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    $all = '';
    if (in_array(17, $permissions)) {
      $all .= "";
    } else {
      $all .= "and a.userId = " . $_SESSION["id-SIGMA"];
    }
    (in_array(14, $permissions)) ? $pm = " or (pmId = $userId and cancelledAt is null and receivedAt is null $all)" : $pm = "";
    (!empty($_REQUEST['filters'])) ? $filters = "$all" : $filters = "$all and cancelledAt is null and receivedAt is null $pm";
    (!empty($_REQUEST['id'])) ? $filters .= " and a.id =" . $_REQUEST['id']: $filters .= "";
    (!empty($_REQUEST['projectId'])) ? $filters .= " and projectId = '" . $_REQUEST['projectId']."'": $filters .= "";
    (!empty($_REQUEST['userId'])) ? $filters .= " and a.userId ='" . $_REQUEST['userId']."'": $filters .= "";
    (!empty($_REQUEST['from'])) ? $filters .= " and createdAt  >='" . $_REQUEST['from']."'": $filters .= "";
    (!empty($_REQUEST['to'])) ? $filters .= " and createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= "";

    if ((!empty($_REQUEST['status']))) {
      switch (true) {
          case ($_REQUEST['status'] == "Cancelled"):
              $filters .= " and sentAt is not null and cancelledAt is not null";
              break;
          case ($_REQUEST['status'] == "Purchasing"):
              $filters .= " and approvedAt is not null and purchasedAt is null";
              break;
          case ($_REQUEST['status'] == "Receiving"):
              $filters .= " and purchasedAt is not null and receivedAt is null";
              break;
          case ($_REQUEST['status'] == "Closed"):
              $filters .= " and receivedAt is not null ";
              break;
          case ($_REQUEST['status'] == "Pricing"):
            $filters .= "and sentAt is not null and quoterId is not null and quotedAt is null ";
            break;
          case ($_REQUEST['status'] == "PM Approval"):
            $filters .= " and quotedAt is not null and approvedPMAt is null ";
            break;
          case ($_REQUEST['status'] == "CEO Approval"):
            $filters .= " and approvedPMAt is not null and approvedAt is null ";
            break;
          case ($_REQUEST['status'] == "Processing"):
              $filters .= " and sentAt is null and quotedAt is not null";
              break;
      }
    }
    if (in_array(10, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/purchases/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    require_once 'views/purchases/new.php';
  }

  public function PurchaseSave(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->projectId=$_REQUEST['projectId'];
    $item->deliveryPlace = $_REQUEST['deliveryPlace'];
    $item->requestDate = $_REQUEST['requestDate'];
    $item->type = $_REQUEST['type'];
    $id = $this->purchases->purchaseSave($item);
    echo json_encode(array("id" => $id, "title" => "Process Purchase", "status" => "process"));
  }

  public function Purchase(){
    require_once "middlewares/check.php";
    $purchase = $this->purchases->get($_REQUEST['id']);
    $title = $_REQUEST['title'] ?? '';
    $status = $_REQUEST['status'];
    (!empty($_SESSION["id-SIGMA"])) 
    ? $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true)
    : $permissions = array();
    require_once 'views/purchases/purchase.php';
  }

  public function test(){
    $item = new stdClass();
    $item->purchaseId = 1146;
    $user = '';
    $array = array();
    foreach($this->purchases->getQuoterId() as $r) {
      $userPermissions = json_decode($this->users->permissionsGet($r->quoterId)->permissions); 
      if (in_array(13, $userPermissions)) {
      $array[] += $r->quoterId;
      }
    }
    foreach($this->users->usersList() as $r) {
      $userPermissions = json_decode($this->users->permissionsGet($r->id)->permissions); 
      if (in_array(13, $userPermissions)) {
        if (!in_array($r->id,  $array)) {
          $user = $r->id;
        }
      }
    }
    if($this->purchases->get($item->purchaseId)->quoterId){
      $item->userId = $this->purchases->get($item->purchaseId)->quoterId;
    } else {
    ($user != '') ? $item->userId = $user : $item->userId = $array[0];
    }
    echo $item->userId;
  }

  public function Update(){
    $id = $_REQUEST['id'];
    if ($_REQUEST['status'] == 'process') {
      $field = 'sentAt';
      $item = new stdClass();
      $item->purchaseId = $_REQUEST['id'];
      if ($this->purchases->get($_REQUEST['id'])->type == 'Service') {
        $item->userId = 7;
      } else {
        $user = '';
        $array = array();
        foreach($this->purchases->getQuoterId() as $r) {
          $userPermissions = json_decode($this->users->permissionsGet($r->quoterId)->permissions); 
          if (in_array(13, $userPermissions)) {
          $array[] += $r->quoterId;
          }
        }
        foreach($this->users->usersList() as $r) {
          $userPermissions = json_decode($this->users->permissionsGet($r->id)->permissions); 
          if (in_array(13, $userPermissions)) {
            if (!in_array($r->id,  $array)) {
              $user = $r->id;
            }
          }
        }
        if($this->purchases->get($item->purchaseId)->quoterId){
          $item->userId = $this->purchases->get($item->purchaseId)->quoterId;
        } else {
        ($user != '') ? $item->userId = $user : $item->userId = $array[0];
        }
      }
      $this->purchases->purchaseAssignUser($item);
      $field = 'sentAt';
      echo $item->userId;
    }
    if ($_REQUEST['status'] == 'pricing') {
      if ($this->purchases->get($_REQUEST['id'])->approvedBy == 1) {
        $this->purchases->updateField($_REQUEST['id'],'approvedPMAt');
      }
      $carpeta = "uploads/purchases/quotes/$id";
      if (!file_exists($carpeta)) {
          mkdir($carpeta, 0777, true);
      }
      $total = count($_FILES['files']['name']);
      for ($i = 0; $i < $total; $i++) {
          $tmpFilePath = $_FILES['files']['tmp_name'][$i];
          if ($tmpFilePath != "") {
              $newFilePath = "uploads/purchases/quotes/$id/" . $_FILES['files']['name'][$i];
              if (move_uploaded_file($tmpFilePath, $newFilePath)) {
              }
          }
      }
      $field = 'quotedAt';
    }
    if ($_REQUEST['status'] == 'pmapprove') {
      $field = 'approvedPMAt';
    }
    if ($_REQUEST['status'] == 'approve') {
      $field = 'approvedAt';
    }
    if ($_REQUEST['status'] == 'purchase') {
      $carpeta = "uploads/purchases/orders/$id";
      if (!file_exists($carpeta)) {
          mkdir($carpeta, 0777, true);
      }
      $total = count($_FILES['files']['name']);
      for ($i = 0; $i < $total; $i++) {
          $tmpFilePath = $_FILES['files']['tmp_name'][$i];
          if ($tmpFilePath != "") {
              $newFilePath = "uploads/purchases/orders/$id/" . $_FILES['files']['name'][$i];
              if (move_uploaded_file($tmpFilePath, $newFilePath)) {
              }
          }
      }
      $field = 'purchasedAt';
    }
    if ($_REQUEST['status'] == 'receive') {
      require_once "middlewares/check.php";
      $item->userId = $_SESSION["id-SIGMA"];
      $this->purchases->purchaseReceivedBy($_REQUEST['purchaseId'], $item->userId);
      $field = 'receivedAt';
    }
    $this->purchases->updateField($_REQUEST['id'],$field);
    echo $_REQUEST['id'];
  }

  public function PurchaseItemForm(){
    $purchase = $_REQUEST['purchase'];
    isset($_REQUEST['id']) ? $id = $this->purchases->itemGet($_REQUEST['id']) : '';
    $purchase = $this->purchases->get($_REQUEST['purchase']);
    require_once 'views/purchases/new_item.php';
  }

  public function ItemVendorForm(){
    $item = $this->purchases->itemGet($_REQUEST['item']);
    isset($_REQUEST['id']) ? $id = $this->purchases->vendorGet($_REQUEST['id']) : '';
    require_once 'views/purchases/new_vendor.php';
  }

  public function PurchaseQuoteForm(){
    $item = $this->purchases->itemGet($_REQUEST['id']);
    $status = $_REQUEST['status'];
    require_once 'views/purchases/quote.php';
  }

  public function PurchaseItemList($id = null){
    require_once "middlewares/check.php";
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    (!$id) ? $purchase = $this->purchases->get($_REQUEST['id']) : $purchase = $this->purchases->get($id);
    (isset($_REQUEST['status'])) ? $status = $_REQUEST['status'] : $status = '';
    require_once 'views/purchases/item_list_row.php';
  }

  public function PurchaseItemSave(){
    $item = new stdClass();
    $item->purchaseId=$_REQUEST['purchaseId'];
    $item->name = addslashes(trim($_REQUEST['name']));
    $item->qty = $_REQUEST['qty'];
    $item->notes = $_REQUEST['notes'];
    $id = $this->purchases->purchaseItemSave($item);
    $carpeta = "uploads/purchases/files/$id";
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }
    $total = count($_FILES['files']['name']);
    for ($i = 0; $i < $total; $i++) {
        $tmpFilePath = $_FILES['files']['tmp_name'][$i];
        if ($tmpFilePath != "") {
            $newFilePath = "uploads/purchases/files/$id/" . $_FILES['files']['name'][$i];
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            }
        }
    }
    echo $item->purchaseId;
  }

  public function itemVendorsList($id = null){
    (!$id) ? $item = $this->purchases->itemGet($_REQUEST['id']) : $item = $this->purchases->itemGet($id);
    (isset($_REQUEST['status'])) ? $status = $_REQUEST['status'] : $status = '';
    require_once 'views/purchases/vendor_list_row.php';
  }

  public function ItemVendorSave(){
    $item = new stdClass();
    $item->vendor=$_REQUEST['vendor'];
    $item->date=$_REQUEST['date'];
    $item->itemId = $_REQUEST['itemId'];
    $item->purchaseId = $_REQUEST['purchaseId'];
    $item->qty = $_REQUEST['qty'];
    $item->price = preg_replace('/[^0-9]+/', '', $_REQUEST['price']);
    $item->notes = $_REQUEST['notes'];
    $id = $this->purchases->itemVendorSave($item);
    echo json_encode(array("itemId" => $item->itemId, "purchaseId" => $item->purchaseId));
  }

  public function VendorCheck(){
    $item = new stdClass();
    $item->itemId=$_REQUEST['itemId'];
    $item->vendorId = $_REQUEST['vendorId'];
    $this->purchases->vendorCheck($item);
  }

  public function RejectItem(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->itemId = $_REQUEST['purchaseId'];
    $item->cause=$_REQUEST['cause'];
    $item->type='purchase';
    $this->init->rejectCause($item);
    $purchase = $this->purchases->get($_REQUEST['purchaseId']);
    if (!$purchase->quotedAt) {
      $this->purchases->rejectPurchaseQuote($item->itemId);
    } else {
      $this->purchases->rejectPurchaseApproval($item->itemId);
    }
  }

  public function ItemOrderSave(){
    $item = new stdClass();
    $item->id = $_REQUEST['id'];
    $item->order=$_REQUEST['order'];
    $this->purchases->itemOrderSave($item);
  }

  public function ItemDaysSave(){
    $item = new stdClass();
    $item->id = $_REQUEST['id'];
    $item->days=$_REQUEST['days'];
    $this->purchases->itemDaysSave($item);
  }

  public function ItemNotesSave(){
    $item = new stdClass();
    $item->id = $_REQUEST['id'];
    $item->notes=$_REQUEST['notes'];
    $this->purchases->itemNotesSave($item);
  }

  public function PurchaseInfoSave(){
    $item = new stdClass();
    $item->id = $_REQUEST['id'];
    $item->delivery=$_REQUEST['delivery'];
    $item->date=$_REQUEST['date'];
    $this->purchases->purchaseInfoSave($item);
  }

  public function ItemDelete(){
    $this->purchases->itemDelete($_REQUEST['id']);
    echo $_REQUEST['purchase'];
  }

  public function VendorDelete(){
    $this->purchases->vendorDelete($_REQUEST['id']);
    echo $_REQUEST['item'];
  }

  public function AlertCheck(){
    $this->purchases->alertCheck($_REQUEST['id']);
  }

  public function AlertCheckItem(){
    $this->purchases->alertCheckItem($_REQUEST['id']);
  }

  public function AlertCheckItemPM(){
    $this->purchases->AlertCheckItemPM($_REQUEST['id']);
  }

  public function PurchasePrice(){
    echo "TOTAL :$" . number_format(ceil($this->purchases->totalPrice($_REQUEST['id'])->total),0);
  }

  public function Pending(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(20, $permissions)) {
      $Processing = 'and sentAt is null and cancelledAt is null and receivedAt is null and type = ';
      $Pricing = 'and sentAt is not null and quoterId is not null and quotedAt is null and cancelledAt is null and receivedAt is null and type = ';
      $PMApproval = 'and quotedAt is not null and approvedPMAt is null and cancelledAt is null and receivedAt is null and type = ';
      $CEOApproval = 'and approvedPMAt is not null and approvedAt is null and cancelledAt is null and receivedAt is null and type = ';
      $Purchasing = 'and approvedAt is not null and purchasedAt is null and cancelledAt is null and receivedAt is null and type = ';
      $PurchasedItems = 'and b.purchasedAt is not null and b.receivedAt is null and b.cancelledAt is null and b.type = ';
      $Receiving = 'and purchasedAt is not null and receivedAt is null and cancelledAt is null and type = ';
      $Closed = 'and receivedAt is not null and cancelledAt is null and type = ';
      $Cancelled = 'and receivedAt is null and cancelledAt is not null and type = ';

      $arrayp = array('Processing');
      $array = array('Pricing','PMApproval','CEOApproval','Purchasing');
      $arrayb = array('Receiving');
      $arrayc = array('Closed','Cancelled');
      $arrayd = array('PurchasedItems');


      require_once 'views/layout/header.php';
      require_once 'views/purchases/pending.php';
    } else {
      $this->init->redirect();
    }
  }

  public function PendingDetails(){
    $Processing = 'and sentAt is null and cancelledAt is null and receivedAt is null';
    $Pricing = 'and sentAt is not null and quoterId is not null and quotedAt is null and cancelledAt is null and receivedAt is null';
    $PMApproval = 'and quotedAt is not null and approvedPMAt is null and cancelledAt is null and receivedAt is null';
    $CEOApproval = 'and approvedPMAt is not null and approvedAt is null and cancelledAt is null and receivedAt is null';
    $Purchasing = 'and approvedAt is not null and purchasedAt is null and cancelledAt is null and receivedAt is null';
    $Receiving = 'and purchasedAt is not null and receivedAt is null and cancelledAt is null';
    $Closed = 'and receivedAt is not null and cancelledAt is null';
    $Cancelled = 'and receivedAt is null and cancelledAt is not null';
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
    require_once 'views/purchases/list_row.php';
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

  public function Report(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(21, $permissions)) {
      $this->init->toExcel($this->purchases->reportList(),'PurchasesReport');
    } else {
      $this->init->redirect();
    }
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
    if (in_array(24, $permissions)) {
      $dates = array();
      $totals = array();
      foreach($this->purchases->daily($filters) as $r) {
        $dates[] = $r->date;
        $totals[] = $r->total;
      }
      $total = array_sum($totals);
      $average = ceil($total/count($totals));
      $axis = json_encode($dates);
      $totals = json_encode($totals, JSON_NUMERIC_CHECK);

      $itemates = array();
      $itemTotals = array();
      foreach($this->purchases->itemDaily($filters) as $r) {
        $itemDates[] = $r->date;
        $itemTotals[] = $r->total;
      }
      $itemTotal = array_sum($itemTotals);
      (count($itemTotals) != 0) ? $itemAverage = ceil($itemTotal/count($itemTotals)) : $itemAverage = 0;
      (isset($itemDates)) ? $itemDates = json_encode($itemDates) : $itemDates = '';
      $itemTotals = json_encode($itemTotals, JSON_NUMERIC_CHECK);

      $totalAverage = ceil($itemAverage / $average);

      $pendingtotals = array();
        foreach($dates as $d) {
          $pendingtotals[] = $this->purchases->pendingDaily($d)->total;       
      }
      $pendinglast = end($pendingtotals);
      $pendingtotals = json_encode($pendingtotals, JSON_NUMERIC_CHECK);

      require_once 'views/layout/header.php';
      require_once 'views/purchases/daily.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Monthly(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    (!empty($_REQUEST['year'])) ? $year = $_REQUEST['year'] : $year = date('Y');
    if (in_array(24, $permissions)) {
      $dates = array();
      $totals = array();
      foreach($this->purchases->monthly($year) as $r) {
        $dates[] = $r->date;
        $totals[] = $r->total;
      }
      $total = array_sum($totals);
      $average = ceil($total/count($totals));
      $axis = json_encode($dates);
      $totals = json_encode($totals, JSON_NUMERIC_CHECK);

      $itemTotals = array();
      foreach($this->purchases->itemMonthly($year) as $r) {
        $itemTotals[] = $r->total;
      }
      $itemTotal = array_sum($itemTotals);
      (count($itemTotals) != 0) ? $itemAverage = ceil($itemTotal/count($itemTotals)) : $itemAverage = 0;
      $itemTotals = json_encode($itemTotals, JSON_NUMERIC_CHECK);

      $totalAverage = ceil($itemAverage / $average);

      require_once 'views/layout/header.php';
      require_once 'views/purchases/monthly.php';
    } else {
      $this->init->redirect();
    }
  }

  public function PurchaseDelete(){
    $this->purchases->updateField($_REQUEST['id'],'cancelledAt');
  }

  public function PendingSave(){
    $Processing = 'and sentAt is null and cancelledAt is null and receivedAt is null and type = ';
    $Pricing = 'and sentAt is not null and quoterId is not null and quotedAt is null and cancelledAt is null and receivedAt is null and type = ';
    $PMApproval = 'and quotedAt is not null and approvedPMAt is null and cancelledAt is null and receivedAt is null and type = ';
    $CEOApproval = 'and approvedPMAt is not null and approvedAt is null and cancelledAt is null and receivedAt is null and type = ';
    $Purchasing = 'and approvedAt is not null and purchasedAt is null and cancelledAt is null and receivedAt is null and type = ';
    $Receiving = 'and purchasedAt is not null and receivedAt is null and cancelledAt is null and type = ';
    $Closed = 'and receivedAt is not null and cancelledAt is null and type = ';
    $Cancelled = 'and receivedAt is null and cancelledAt is not null and type = ';

    $array = array('Pricing','PMApproval','CEOApproval','Purchasing');
    foreach ($array as $r) {
      $this->purchases->pendingSave($r,count($this->purchases->purchasesList(${$r} . "'Service'")),count($this->purchases->purchasesList(${$r} . "'Material'")));
    }
  }

  public function Deliver(){
    $id = $this->purchases->itemGet($_REQUEST['id']);
    $status = $_REQUEST['status'];
    require_once 'views/purchases/deliver.php';
  }

  public function DeliverList($id = null){
    require_once "middlewares/check.php";
    $status = $_REQUEST['status'];
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $filters = " and itemId = " . $_REQUEST['id'];
    (!$id) ? $id = $this->purchases->itemGet($_REQUEST['id']) : $id = $this->purchases->itemGet($id);
    require_once 'views/purchases/list_delivers.php';
  }

  public function NewDeliver(){
    $itemId = $_REQUEST['id'];
    $purchaseId = $_REQUEST['purchase'];
    require_once 'views/purchases/new_deliver.php';
  }

  public function DeliverSave(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->itemId=$_REQUEST['itemId'];
    $item->purchaseId=$_REQUEST['purchaseId'];
    $item->qty=$_REQUEST['qty'];
    $item->notes=$_REQUEST['notes'];
    $id = $this->purchases->deliverSave($item);
    !empty($id) ? $id = $id : $id = 'error';
    echo json_encode(array("id" => $id, "itemId" => "$item->itemId", "purchaseId" => "$item->purchaseId"));
  }

  public function DeliverForm(){
    $this->purchases->updateDeliverField($_REQUEST['id'],'SAP');
    echo $_REQUEST['id'];
  }

  public function Available(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(45, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/purchases/available.php';
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
          $this->purchases->deleteData();
          for ($i = 1; $i <= $sheetCount; $i ++) {
            $item->id = "";
            if (!empty($spreadSheetAry[$i][0])) {
              $item->id = trim($spreadSheetAry[$i][0]);
            }
            $item->description = "";
            if (!empty($spreadSheetAry[$i][1])) {
              $item->description = addslashes(trim($spreadSheetAry[$i][1]));
            }
            if (!empty($item->id) ) {
              $id = $this->purchases->saveData($item);
            }
          }
        }
      }
    }
  }

  public function Control(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(12, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/purchases/control.php';
    } else {
      $this->init->redirect();
    }
  }

  public function ControlUpdate() {
    $item = new stdClass();
    $item->purchase=$_REQUEST['purchase'];
    $item->user=$_REQUEST['user'];
    $id = $this->purchases->controlUpdate($item);
  }

  public function NewCode(){
    require_once 'views/purchases/new_code.php';
  }

  public function CodeSave(){
    require_once "middlewares/check.php";
    $user = $_SESSION["id-SIGMA"];
    $name = addslashes(trim($_REQUEST['name']));
    $id = $this->purchases->codeSave($name,$user);
  }

  public function CodeUpdate() {
    $item = new stdClass();
    $item->id=$_REQUEST['id'];
    if($_REQUEST['status'] == 1) {
      $item->code=$_REQUEST['code'];
      $item->description=addslashes(trim($_REQUEST['description']));
    } else {
      $item->code = 0;
      $item->description=$_REQUEST['cause'];
    }
    $id = $this->purchases->codeUpdate($item);
  }

  public function Code(){
    $id = $this->purchases->codeGet($_REQUEST['id']);
    require_once 'views/purchases/code.php';
  }

  public function CodeCheck(){
    $id = $this->purchases->codeCheck($_REQUEST['id']);
    echo $id;
  }
  

}