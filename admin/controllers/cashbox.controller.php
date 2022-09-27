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

  public function Index(){
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

  public function Open(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-CRB"];
    $item->type = 1;
    $item->amount = substr($_REQUEST['amount'],2);
    $table = 'cashbox';
    $this->init->save($table,$item);
  }

  public function Close(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-CRB"];
    $item->type = 2;
    $item->amount = substr($_REQUEST['amount'],2);
    $table = 'cashbox';
    $this->init->save($table,$item);

    $initial_id=$this->cashbox->last('and type = 1')->id;
    $final_id=$this->cashbox->last('and type = 2')->id;
    $initial=$this->cashbox->get($initial_id)->amount;
    $final=$this->cashbox->get($final_id)->amount;
    $start=$this->cashbox->get($initial_id)->createdAt;
    $end=$this->cashbox->get($final_id)->createdAt;
    $cash=$this->sales->get($start,$end,'$')->total;
    $qr=$this->sales->get($start,$end,'QR')->total;
    $others_income=$this->others->get($start,$end,'IN')->total;
    $others_outcome=$this->others->get($start,$end,'OUT')->total;
    $diference = $final - ($cash+$others_income+$initial-$others_outcome);
    if ($diference == 0) {
      $diference = "<div style='color:green'><b>Diferencia:</b>  $$diference</div>";
    } elseif ($diference > 0) {
      $diference = "<div style='color:yellow'><b>Diferencia:</b> $$diference</div>";
    } else {
      $diference = "<div style='color:red'><b>Diferencia:</b> $$diference</div>";
    }
    echo "
    $start - $end
    <br><b>Caja Inicio:</b> $" . number_format($initial, 0, '.', ',') . 
    "<br><b>Efectivo:</b> $" . number_format($cash, 0, '.', ',') .
    "<br><b>Otros Ingresos: $</b>" . number_format($others_income, 0, '.', ',') . 
    "<br><b>QR:</b> $" . number_format($qr, 0, '.', ',') .
    "<br><b>Efectivo + Otros: $</b>" . number_format(($cash+$others_income), 0, '.', ',').
    "<br><b>Egresos</b>: $" . number_format($others_outcome, 0, '.', ',') .
    "<br><br><b>TOTAL CAJA: $" . number_format(($cash+$others_income+$initial-$others_outcome), 0, '.', ',') .
    "<br>Caja Cierre: $</b>" . number_format($final, 0, '.', ',') .
    $diference;
  }

}