<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';
require_once 'models/cashbox.php';
require_once 'models/sales.php';
require_once 'models/others.php';



class CashboxController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
    $this->users = new Users();
    $this->cashbox = new CashBox();
    $this->sales = new Sales();
    $this->others = new Others();
  }

  public function Open(){
    require_once 'views/cashbox/open.php';
  }

  public function Close(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-CRB"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-CRB"])->permissions, true);
    if (in_array(9, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/cashbox/close.php';
    } else {
      $this->init->redirect();
    }
  }

  public function OpenSave(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->openedBy = $_SESSION["id-CRB"];
    $item->open = $_REQUEST['amount'];
    $this->cashbox->open($item);
  }

  public function CloseSave(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->closedBy = $_SESSION["id-CRB"];
    $item->close = $_REQUEST['amount'];
    $item->id=$this->init->lastCashbox()->id;
    $this->cashbox->close($item);
    $id=$this->init->lastCashbox()->id;
    $open=$this->cashbox->get($id)->open;
    $close=$this->cashbox->get($id)->close;
    $start=$this->cashbox->get($id)->openedAt;
    $end=$this->cashbox->get($id)->closedAt;
    $cash=$this->sales->get($start,$end)->total;
    $others_income=$this->others->get($start,$end,'IN')->total;
    $others_outcome=$this->others->get($start,$end,'OUT')->total;
    $diference = $close - ($cash+$others_income+$open-$others_outcome);
    if ($diference == 0) {
      $diference = "<div style='color:green'><b>Diferencia:</b>  $$diference</div>";
    } elseif ($diference > 0) {
      $diference = "<div style='color:yellow'><b>Diferencia:</b> $$diference</div>";
    } else {
      $diference = "<div style='color:red'><b>Diferencia:</b> $$diference</div>";
    }
    echo "
    $start - $end
    <br><b>Caja Inicio:</b> $" . number_format($open, 0, '.', ',') . 
    "<br><b>Efectivo:</b> $" . number_format($cash, 0, '.', ',') .
    "<br><b>Otros Ingresos: $</b>" . number_format($others_income, 0, '.', ',') . 
    "<br><b>Efectivo + Otros: $</b>" . number_format(($cash+$others_income), 0, '.', ',').
    "<br><b>Egresos</b>: $" . number_format($others_outcome, 0, '.', ',') .
    "<br><br><b>TOTAL CAJA: $" . number_format(($cash+$others_income+$open-$others_outcome), 0, '.', ',') .
    "<br>Caja Cierre: $</b>" . number_format($close, 0, '.', ',') .
    $diference;
  }

  public function History(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-CRB"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-CRB"])->permissions, true);
    $filters = '';
    $today = date("Y-m-d");
    $firstday = date('Y-m-01', strtotime($today));
    $lastday = date('Y-m-t', strtotime($today));
    (!empty($_REQUEST['from'])) ? $filters .= " and a.openedAt  >='" . $_REQUEST['from']."'": $filters .= " and a.openedAt  >= $firstday";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.closedAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= " ";
    if (in_array(10, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/cashbox/history.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Detail(){
    $id=$_REQUEST['id'];
    $open=$this->cashbox->get($id)->open;
    $close=$this->cashbox->get($id)->close;
    $start=$this->cashbox->get($id)->openedAt;
    $end=$this->cashbox->get($id)->closedAt;
    $cash=$this->sales->get($start,$end)->total;
    $others_income=$this->others->get($start,$end,'IN')->total;
    $others_outcome=$this->others->get($start,$end,'OUT')->total;
    $diference = $close - ($cash+$others_income+$open-$others_outcome);
    echo "
    <div class='modal-header'>
    <h5 class='modal-title'>Detalle</b></h5>
    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button>
    </div>
    <div class='p-4 text-center'>
    ";
    if ($diference == 0) {
      $diference = "<div style='color:green'><b>Diferencia:</b>  $$diference</div>";
    } elseif ($diference > 0) {
      $diference = "<div style='color:yellow'><b>Diferencia:</b> $$diference</div>";
    } else {
      $diference = "<div style='color:red'><b>Diferencia:</b> $$diference</div>";
    }
    echo "
    $start - $end
    <br><b>Caja Inicio:</b> $" . number_format($open, 0, '.', ',') . 
    "<br><b>Efectivo:</b> $" . number_format($cash, 0, '.', ',') .
    "<br><b>Otros Ingresos: $</b>" . number_format($others_income, 0, '.', ',') . 
    "<br><b>Efectivo + Otros: $</b>" . number_format(($cash+$others_income), 0, '.', ',').
    "<br><b>Egresos</b>: $" . number_format($others_outcome, 0, '.', ',') .
    "<br><br><b>TOTAL CAJA: $" . number_format(($cash+$others_income+$open-$others_outcome), 0, '.', ',') .
    "<br>Caja Cierre: $</b>" . number_format($close, 0, '.', ',') .
    $diference .
    "</div>";
  }

  public function Excel(){
    $filters = '';
    (!empty($_REQUEST['from'])) ? $filters .= " and a.createdAt  >='" . $_REQUEST['from']."'": $filters .= " and a.createdAt  >= $firstday";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= " ";
    $this->init->toExcel($this->cashbox->excel($filters),'Historico Caja');
  }

}