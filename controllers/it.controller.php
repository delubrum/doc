<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'models/it.php';
require_once 'models/users.php';
require_once 'models/init.php';

class ITController {
  private $model;
  public function __CONSTRUCT(){
    $this->users = new Users();
    $this->init = new Init();
    $this->it = new IT();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    isset($_REQUEST['id']) ? $filters = '' : $filters = ' and a.closedAt is null';
    (!empty($_REQUEST['id'])) ? $filters .= " and a.id =" . $_REQUEST['id']: $filters .= "";
    (!empty($_REQUEST['userId'])) ? $filters .= " and a.userId ='" . $_REQUEST['userId']."'": $filters .= "";
    (!empty($_REQUEST['type'])) ? $filters .= " and a.type ='" . $_REQUEST['type']."'": $filters .= "";
    (!empty($_REQUEST['priority'])) ? $filters .= " and a.priority ='" . $_REQUEST['priority']."'": $filters .= "";
    (!empty($_REQUEST['complexity'])) ? $filters .= " and a.complexity ='" . $_REQUEST['complexity']."'": $filters .= "";
    (!empty($_REQUEST['attends'])) ? $filters .= " and a.attends ='" . $_REQUEST['attends']."'": $filters .= "";
    (!empty($_REQUEST['from'])) ? $filters .= " and a.createdAt  >='" . $_REQUEST['from']."'": $filters .= "";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= "";
    if ((!empty($_REQUEST['status']))) {
      switch (true) {
          case ($_REQUEST['status'] == "Closed"):
              $filters .= " and a.closedAt is not null";
              break;
          case ($_REQUEST['status'] == "Open"):
              $filters .= " and a.start is null";
              break;
          case ($_REQUEST['status'] == "Started"):
              $filters .= " and a.start is not null and a.end is null";
              break;
          case ($_REQUEST['status'] == "Attended"):
            $filters .= " and a.end is not null and a.closedAt is null";
            break;
      }
    }
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(29, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/it/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    require_once 'views/it/new.php';
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $item->userId = $_SESSION["id-SIGMA"];
    $item->type=$_REQUEST['type'];
    $item->priority = $_REQUEST['priority'];
    $item->description = $_REQUEST['description'];
    $id = $this->it->save($item);
    echo $id; 
  }

  public function ServiceDesk(){
    require_once "middlewares/check.php";
    $id = $this->it->get($_REQUEST['id']);
    $title = $_REQUEST['title'] ?? '';
    $status = $_REQUEST['status'];
    (!empty($_SESSION["id-SIGMA"])) 
    ? $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true)
    : $permissions = array();
    require_once 'views/it/serviceDesk.php';
  }

  public function Update(){
    require_once "middlewares/check.php";
    $id = $_REQUEST['id'];
    $item = new stdClass();
    $item->id = $_REQUEST['id'];
    $item->priority = $_REQUEST['priority'] ?? $this->it->get($_REQUEST['id'])->priority;
    $item->complexity = $_REQUEST['complexity'] ?? $this->it->get($_REQUEST['id'])->complexity;
    (!empty($_REQUEST['startTime'])) ? $startime = date("H:i", strtotime($_REQUEST['startTime'])) : $startime = '';
    $startDate = $_REQUEST['startDate'] ?? '';
    $start = $startDate . " " . $startime;
    (!empty(trim($start))) ? $item->start = $start : $item->start = $this->it->get($_REQUEST['id'])->start;
    (!empty($_REQUEST['endTime'])) ? $endtime = date("H:i", strtotime($_REQUEST['endTime'])) : $endtime = '';
    $endDate = $_REQUEST['endDate'] ?? '';
    $end = $endDate . " " . $endtime;
    (!empty(trim($end))) ? $item->end = $end : $item->end = $this->it->get($_REQUEST['id'])->end;
    $item->attends = $_REQUEST['attends'] ?? $this->it->get($_REQUEST['id'])->attends;
    $item->answer = $_REQUEST['answer'] ?? $this->it->get($_REQUEST['id'])->answer;
    (!empty($_REQUEST['users'])) ? $item->users = json_encode($_REQUEST['users']) : $item->users = $this->it->get($_REQUEST['id'])->users;
    $item->rating = $_REQUEST['rating'] ?? $this->it->get($_REQUEST['id'])->rating;
    $item->notes = $_REQUEST['notes'] ?? $this->it->get($_REQUEST['id'])->notes;
    ($item->rating) ? $item->closedAt = 'now()' : $item->closedAt = 'NULL';
    (!empty($_REQUEST['startDate'])) ? $item->fillBy = $_SESSION["id-SIGMA"] : $item->fillBy = $this->it->get($_REQUEST['id'])->fillBy;
    $id = $this->it->update($item);
    echo $id;
  }

  public function Check(){
    $id = $this->it->check($_REQUEST['id']);
    echo $id;
  }

  public function Excel(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(31, $permissions)) {
      $this->init->toExcel($this->it->excel(),'ITServices');
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
    (!empty($_REQUEST['from'])) ? $filters .= " and createdAt  >='" . $_REQUEST['from']."'": $filters .= " and createdAt  >= '$mon'";
    (!empty($_REQUEST['to'])) ? $filters .= " and createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= " and createdAt  <= '$sun 23:59:59'";
    if (in_array(32, $permissions)) {
      $dates = array();
      $totals = array();
      foreach($this->it->daily($filters) as $r) {
        $dates[] = $r->date;
        $totals[] = $r->total;
        $ratings[] = $r->ratings;
      }
      $total = array_sum($totals);
      $rating = round($this->it->avgRating()->ratings,2);
      $average = ceil($total/count($totals));
      $averageratings = ceil($rating/count($ratings));
      $axis = json_encode($dates);
      $totals = json_encode($totals, JSON_NUMERIC_CHECK);
      $endtotals = array();
        foreach($dates as $d) {
          $endtotals[] = $this->it->dailyAttended($d)->total;
          $externaltotals[] = $this->it->dailyExternal($d)->total;       
 
      }

      $pendingtotals = array();
      foreach($dates as $d) {
        $pendingtotals[] = $this->it->pendingDaily($d)->total;       
      }
      $pendingtotals = json_encode($pendingtotals, JSON_NUMERIC_CHECK);

      $endtotal = array_sum($endtotals);
      $externaltotal = array_sum($externaltotals);
      $endaverage = ceil($endtotal/count($endtotals));
      $endtotals = json_encode($endtotals, JSON_NUMERIC_CHECK);
      $externaltotals = json_encode($externaltotals, JSON_NUMERIC_CHECK);

      require_once 'views/layout/header.php';
      require_once 'views/it/daily.php';
    } else {
      $this->init->redirect();
    }
  }

  public function PendingSave(){
    $query = ' and end is null';
    $this->it->pendingSave(count($this->it->list($query)));
  }
  
}