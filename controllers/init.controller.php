<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';

class InitController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
    $this->users = new Users();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    require_once 'views/layout/header.php';
    require_once 'views/layout/page.php';
  }

  public function SessionRefresh(){
    session_start();
    if (isset($_SESSION['id-SIGMA'])) {
      $_SESSION['id-SIGMA'] = $_SESSION['id-SIGMA'];
    }
  }

  public function Alerts(){
    require_once "middlewares/check.php";
    if (isset($_SESSION["id-SIGMA"])){
      $user = $this->users->UserGet($_SESSION["id-SIGMA"]); 
      $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
      $alertPurchaseProcess = $this->init->alert("*", "purchases","and userId = $user->id and sentAt is null and cancelledAt is null");
      if (in_array(12, $permissions)) {
      $alertPurchaseAssign = $this->init->alert("*", "purchases","and sentAt is not null and quoterId is null and cancelledAt is null");
      } else {
      $alertPurchaseAssign = array();
      }
      $alertPurchasePricing = $this->init->alert("*", "purchases","and quoterId = $user->id and sentAt is not null and quotedAt is null and cancelledAt is null");
      if (in_array(14, $permissions)) {
        $alertPmApproval = $this->init->alert("a.*", "purchases a LEFT JOIN projects b on a.projectId = b.id","and b.pmId = $user->id and a.quotedAt is not null and a.approvedPMAt is null and a.cancelledAt is null");
      } else {
          $alertPmApproval = array();
      }
      if (in_array(15, $permissions)) {
          $alertApproval = $this->init->alert("*", "purchases","and approvedPMAt is not null and approvedAt is null and cancelledAt is null");
      } else {
          $alertApproval = array();
      }
      
      if (in_array(13, $permissions)) {
          $alertPurchase = $this->init->alert("*", "purchases","and quoterId = $user->id and approvedAt is not null and purchasedAt is null and cancelledAt is null");
      } else {
          $alertPurchase = array();
      }
      if (in_array(16, $permissions)) {
        $alertReceive = $this->init->alert("*", "purchases","and purchasedAt is not null and receivedAt is null and cancelledAt is null and type = 'Material' or (purchasedAt is not null and receivedAt is null and type = 'Service' and userId = $user->id)");
      } else {
        $alertReceive = $this->init->alert("*", "purchases","and purchasedAt is not null and receivedAt is null and cancelledAt is null and type = 'Service' and userId = $user->id");
      }
      $alertReceiveCheck = $this->init->alert("*", "purchases","and receivedAt is not null and alertCheck = 0 and userId = $user->id");
      // $alertReceiveCheckItem = $this->init->alert("a.*,b.userId", "purchase_items a LEFT JOIN purchases b ON a.purchaseId = b.id","and partial <> 0 and a.alertCheck = 0 and userId = $user->id");
      // $alertReceiveCheckItemPM = $this->init->alert("a.*,c.pmId", "purchase_items a LEFT JOIN purchases b ON a.purchaseId = b.id LEFT JOIN projects c ON b.projectId = c.id","and partial <> 0 and a.alertCheckPM = 0 and pmId = $user->id");


      $alertWOProcess = $this->init->alert("*", "workOrder"," and processedAt is null and userId = $user->id  and cancelledAt is null");
      $alertWOConfirm = $this->init->alert("*", "workOrder"," and processedAt is not null and confirmedAt is null and userId = $user->id  and cancelledAt is null");
      $alertWOSend = $this->init->alert("a.*", "workOrder a LEFT JOIN projects b ON a.projectId = b.id","  and confirmedAt is not null  and sentAt is null and b.pmId = $user->id  and a.cancelledAt is null");

      $alertBOMProcess = $this->init->alert("*", "bom"," and sentAt is null and userId = $user->id and cancelledAt is null");
      if (in_array(25, $permissions)) {
          $alertBOMConfirm = $this->init->alert("*", "bom"," and sentAt is not null and storedAt is null and cancelledAt is null");
      } else {
          $alertBOMConfirm = array();
      }
      if (in_array(27, $permissions)) {
        $alertBOMSAP = $this->init->alert("a.*, b.bomId", "bom_delivers a LEFT JOIN bom_items b ON a.itemId = b.Id"," and SAP is null");
      } else {
          $alertBOMSAP = array();
      }

      if (in_array(30, $permissions)) {
          $alertITStart = $this->init->alert("*", "serviceDesk"," and start is null and end is null");
      } else {
          $alertITStart = array();
      }
      if (in_array(30, $permissions)) {
          $alertITEnd = $this->init->alert("*", "serviceDesk"," and start is not null and end is null");
      } else {
          $alertITEnd = array();
      }
      $alertITRate = $this->init->alert("*", "serviceDesk"," and end is not null and closedAt is null and userId = $user->id");
      $alertITCheck = $this->init->alert("*", "serviceDesk"," and start is not null and end is null and checkedAt is null and userId = $user->id");

      if (in_array(44, $permissions)) {
        $alertMNTAssign = $this->init->alert("*", "mntDesk"," and fillBy is null");
      } else {
        $alertMNTAssign = array();
      }


      if (in_array(35, $permissions)) {
        $alertMNTStart = $this->init->alert("*", "mntDesk"," and start is null and end is null and fillBy = $user->id");
      } else {
        $alertMNTStart = array();
      }
    
      if (in_array(35, $permissions)) {
        $alertMNTEnd = $this->init->alert("*", "mntDesk"," and start is not null and end is null and fillBy = $user->id");
      } else {
        $alertMNTEnd = array();
      }
      
      $alertMNTRate = $this->init->alert("*", "mntDesk"," and end is not null and closedAt is null and userId = $user->id");
      $alertMNTCheck = $this->init->alert("*", "mntDesk"," and start is not null and end is null and checkedAt is null and userId = $user->id");
      

      if (in_array(40, $permissions)) {
        $alertReserve = $this->init->alert("*", "reservations"," and approvedAt is null and cancelledAt is null");
      } else {
        $alertReserve = array();
      }

      if (in_array(43, $permissions)) {
        $alertReserveReceive = $this->init->alert("*", "reservations","and approvedAt is not null and receivedAt is null and cancelledAt is null");
      } else {
        $alertReserveReceive = array();
      }

      (count($alertReserve) > 0) ? $countalertReserve = 1 : $countalertReserve = 0;
      (count($alertReserveReceive) > 0) ? $countalertReserveReceive = 1 : $countalertReserveReceive = 0;

      $alertReserveCancel = $this->init->alert("a.id as id, cause, a.alert, b.userId", "rejectCauses a LEFT JOIN reservations b ON a.itemId = b.id"," and a.alert = 0 and b.userId = $user->id and type = 'reserve'");
      $alertReserveApproved = $this->init->alert("*", "reservations"," and alert = 0 and userId = $user->id and approvedAt is not null");

      if (in_array(46, $permissions)) {
      $alertPurchaseCode = $this->init->alert("*", "purchases_codes"," and updatedAt is null");
      } else {
        $alertPurchaseCode = array();
      }
      $alertPurchaseCodeApprove = $this->init->alert("a.id,a.code,a.description", "purchases_codes a LEFT JOIN purchases_data b on a.code = b.id"," and b.id <> 0 and code <> 0 and userId = $user->id and alert = 0");
      $alertPurchaseCodeCancel = $this->init->alert("*", "purchases_codes"," and code = 0 and userId = $user->id and alert = 0");


      if (isset($_REQUEST['id'])) {
        $count = count($alertPurchaseProcess) + count($alertPurchaseAssign) 
        + count($alertPurchasePricing) + count($alertPmApproval) + count($alertApproval)
        + count($alertPurchase) + count($alertReceive) + count($alertReceiveCheck)
        // + count($alertReceiveCheckItem) + count($alertReceiveCheckItemPM) 
        + count($alertWOProcess) + count($alertWOConfirm)
        + count($alertWOSend) + count($alertBOMProcess) + count($alertBOMConfirm) + count($alertBOMSAP)
        + count($alertITStart) + count($alertITEnd) + count($alertITRate) + count($alertITCheck)
        + count($alertMNTStart) + count($alertMNTEnd) + count($alertMNTRate) + count($alertMNTCheck)
        + $countalertReserve + $countalertReserveReceive + count($alertReserveCancel) + count($alertReserveApproved)
        + count($alertPurchaseCode) + count($alertPurchaseCodeApprove) + count($alertPurchaseCodeCancel)
        ;

        echo $count;
      } else {
        require_once 'views/layout/alerts.php';
      }
    }
  }

  public function DeleteFile() {
    unlink($_REQUEST["file"]);
  }

  public function DeleteFolder() {
    $dir = $_REQUEST["folder"];
    if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
          if (filetype($dir."/".$object) == "dir") 
             rrmdir($dir."/".$object); 
          else unlink   ($dir."/".$object);
        }
      }
      reset($objects);
      rmdir($dir);
    }
   }

  public function Reject(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->itemId = $_REQUEST['id'];
    $item->cause= $_REQUEST['cause'];
    $item->type= $_REQUEST['type'];
    $this->init->rejectCause($item);
    switch ($item->type) {
      case "bom":
        $table = "bom";
        $query = "sentAt = null WHERE id = $item->itemId";
        break;
      case "wo":
        $table = "workOrder";
        $query = "confirmedAt = null, processedAt = null, sentAt = null WHERE id = $item->itemId";
        break;
      case "reserve":
        $table = "reservations";
        $query = "cancelledAt = now() WHERE id = $item->itemId";
        break;
    }
    $this->init->reject($table,$query);
  }

  public function Rejections(){
    $id = $_REQUEST['id'];
    $type = $_REQUEST['type'];
    require_once 'views/layout/rejections.php';
  }

  public function Indicator(){
    echo '<div class="modal-header">
    <h5 class="modal-title">Indicator Description</b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';
    echo $this->init->indicator($_REQUEST['id'])->html;
  }

}