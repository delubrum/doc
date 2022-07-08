<?php

include 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;


$options = new QROptions(
    [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
    ]
    );
$qrcode = (new QRCode($options))->render("http://aei-sigma.com/sigma/?c=WorkOrders&a=Item&id=$id->id");
?>

<header>
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Sigma | Work Order Item</title>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <script src="assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <script src="assets/plugins/toastr/toastr.min.js"></script>
</header>

<style>
    @media print {    
        .noprint {
            display: none !important;
        }
    }

    .boarding-pass { display: none; }    
@media print 
{
    .boarding-pass { display: block !important; }
}

/*--------------------
Boarding Pass
--------------------*/
.boarding-pass {
  position: relative;
  width: 350px;
  height: auto;
  background: #fff;
  box-shadow: 0 5px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  text-transform: uppercase;
  /*--------------------
  Header
  --------------------*/
  /*--------------------
  Infos
  --------------------*/
  /*--------------------
  Strap
  --------------------*/
}
.boarding-pass small {
  display: block;
  font-size: 11px;
  color: #000;
  margin-bottom: 2px;
}
.boarding-pass strong {
  font-size: 15px;
  display: block;
}
.boarding-pass header {
  background: #FFF;
  padding: 12px 20px;
  height: 53px;
}
.boarding-pass header .logo {
  float: left;
  width: 104px;
  height: 31px;
}
.boarding-pass header .flight {
  float: right;
  color: #000;
  text-align: right;
}
.boarding-pass header .flight small {
  font-size: 8px;
  margin-bottom: 2px;
}
.boarding-pass header .flight strong {
  font-size: 18px;
}
.boarding-pass .infos {
  display: flex;
  border-top: 1px solid #000;
}
.boarding-pass .infos .places,
.boarding-pass .infos .times {
  width: 50%;
  padding: 10px 0;
}
.boarding-pass .infos .places::after,
.boarding-pass .infos .times::after {
  content: "";
  display: table;
}

.boarding-pass .infos .places {
  border-right: 1px solid #000;
}
.boarding-pass .infos .places small {
  color: #000;
}
.boarding-pass .infos .places strong {
  color: #000;
}
.boarding-pass .infos .box {
  padding: 10px 20px 10px;
  width: 47%;
  float: left;
}
.boarding-pass .infos .box small {
  font-size: 10px;
}
.boarding-pass .strap {
  position: relative;
  border-top: 1px solid #000;
}
.boarding-pass .strap::after {
  content: "";
  display: table;
}
.boarding-pass .strap .box {
  padding: 23px 0 20px 20px;
}
.boarding-pass .strap .box div {
  margin-bottom: 15px;
}
.boarding-pass .strap .box div small {
  font-size: 10px;
}
.boarding-pass .strap .box div strong {
  font-size: 13px;
}
.boarding-pass .strap .box sup {
  font-size: 8px;
  position: relative;
  top: -5px;
}
.boarding-pass .strap .qrcode {
  position: absolute;
  top: 20px;
  right: 20px;
  width: 80px;
  height: 80px;
}


@page {
  size: 234px 280px;
}

</style>

<div id="loading"></div>



<div class="row p-4 noprint">

    <div class="col-12">
        <button type="button" class="btn btn-primary printBtn float-right noprint m-1" onclick="window.print();return false;"><i class="fas fa-print"></i></button>
    </div>
    
    <table style='text-align:center;width:100%;padding:0' class="mb-4">
        <tr>
            <td><img src='<?= $qrcode ?>' alt='QR Code' width='120' height='120'></td>
            <td style='width:33%'><img style='width:100px' src='assets/img/logo.png'></td>
            <td style='width:33%'><h1>PART NUMBER</h1></td>
            <td style='width:33%;font-size:18px'>
                <b>Code:</b> 
                <br>
                <b>Date:</b> 
                <br>
                <b>Version:</b> 
            </td>
        </tr>
    </table>
    <table class="table table-striped mb-4">
        <tr>
            <th>Wo id</th>
            <th>Project</th>
            <th>Scope</th>
            <th>Order</th>
            <th>PM</th>
            <th>User</th>
            <th>Date</th>
        </tr>
        <tr>
            <td><?php echo $wo->id ?> </td>
            <td><?php echo $wo->projectname ?> </td>
            <td><?php echo htmlentities(stripslashes($wo->scope)) ?></td>
            <td><?php echo $wo->designation ?></td>
            <td><?php echo $wo->pmname ?></td>
            <td><?php echo $wo->username ?></td>
            <td><?php echo $wo->createdAt ?></td>
        </tr>
    </table>

    <table class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Part Number</th>
            <th>Description</th>
            <th>Mass</th>
            <th>Painting<br>Area</th>
            <th>Finish &<br>UC Code</th>
            <th>Qty</th>
            <th>Notes</th>
            <th>Processes</th>
            <th class="noprint">Files</th>
        </tr>
        <tr>
            <td class="text-justify"><?php echo $id->id ?>
            <td class="text-justify"><?php echo $id->number ?>
            <td class="text-justify"><?php echo stripslashes($id->name) ?>
            <td class="text-justify">
                <?php 
                ($id->pa <> 0) ? $paa = $id->pa : $paa=0; 
                echo number_format($id->weight,2) 
                ?>
                <?php echo $id->uom ?>
            <td class="text-justify">
                <?php echo number_format($paa,2) ?> <?php echo $id->pauom ?>
            <td class="text-justify">
                <?php echo $id->finish ?>
            <td class="text-justify">
                <?php echo $id->qty ?>
            <td class="text-justify"><?php echo $id->notes ?>
            <td class="text-justify">
            <?php if(!empty($id->processes)) {foreach(json_decode($id->processes) as $p) { echo $this->wo->processGet($p)->name . "<br>"; }} ?></td>
            <td class="text-left noprint pr-4">
            <label>DXF:</label><br>
            <?php
            $directorio = "uploads/workOrders/DXF/$wo->id/";
            if (file_exists($directorio)) {
                if ($gestor = opendir($directorio)) {
                $list=array();
                while (false !== ($arch = readdir($gestor))) {
                    if ($arch != "." && $arch != "..") {
                    $list[]=$arch;
                    } 
                }
                sort($list, SORT_NUMERIC);
                foreach($list as $fileName) {
                    if (substr($fileName, 0, -4) == $id->number) {
                        echo "<a download target='_blank' href='$directorio$fileName'><i class='fas fa-file'></i> $fileName</a>"; 
                    }
                }
                closedir($gestor);
                }
            }
            ?>
            <br>
            <label>PDF:</label><br>
            <?php
            $directorio = "uploads/workOrders/PDF/$wo->id/";
            if (file_exists($directorio)) {
                if ($gestor = opendir($directorio)) {
                $list=array();
                while (false !== ($arch = readdir($gestor))) {
                    if ($arch != "." && $arch != "..") {
                    $list[]=$arch;
                    } 
                }
                sort($list, SORT_NUMERIC);
                foreach($list as $fileName){
                    $zip = new ZipArchive;
                    if ($zip->open("$directorio$fileName") !== TRUE) {
                        exit('failed');
                    }
                    if ($zip->locateName("$id->number.pdf") !== false) {
                        echo "<a target='_blank' href='?c=WorkOrders&a=ZipFilePDF&id=$wo->id&zip=$fileName&file=$id->number.pdf&folder=PDF'><i class='fas fa-file'></i> $id->number</a>";
                    }
                    closedir($gestor);
                }
                }
            }
            ?>
            <br>
            <label>STP:</label><br>
            <?php
            $directorio = "uploads/workOrders/STP/$wo->id/";
            if (file_exists($directorio)) {
                if ($gestor = opendir($directorio)) {
                $list=array();
                while (false !== ($arch = readdir($gestor))) {
                    if ($arch != "." && $arch != "..") {
                    $list[]=$arch;
                    } 
                }
                sort($list, SORT_NUMERIC);
                foreach($list as $fileName){
                    $zip = new ZipArchive;
                    if ($zip->open("$directorio$fileName") !== TRUE) {
                        exit('failed');
                    }
                    if ($zip->locateName("$id->number.stp") !== false) {
                        echo "<a download target='_blank' href='?c=WorkOrders&a=ZipFile&id=$wo->id&zip=$fileName&file=$id->number.stp&folder=STP'><i class='fas fa-file'></i> $id->number</a>";
                    }
                    closedir($gestor);
                }
                }
            }
            ?>
            </td> 




    </table>
</div>




<div class="boarding-pass">
  <header>
    <div class="logo">
    <img style='width:35px' src='assets/img/logobw.png'>
        </div>
    <div class="flight">
      <small>Part Number</small>
      <strong><?php echo $id->number ?></strong>
    </div>
  </header>

  <section class="infos">
    <div class="places">
      <div class="box" style="width:100%">
        <small>Project</small>
        <strong><em><?php echo $wo->projectname ?></em></strong>
      </div>

      <div class="box" style="width:100%">
        <small>Order</small>
        <strong><?php echo $wo->designation ?></strong>
      </div>
    </div>
    <div class="times">
      <div class="box" style="width:100%">
        <small>Description</small>
        <strong><em><?php echo $id->name ?></em></strong>
      </div>
      <div class="box" style="width:100%">
        <small>Finish & UC</small>
        <strong><em><?php echo $id->finish ?></em></strong>
      </div>
    </div>
  </section>
  <section class="strap">
    <div class="box">
      <div class="passenger">
        <small>INSPECTOR</small>
        <strong>__________________________</strong>
      </div>
      <div class="date">
        <small>Date</small>
        <strong><?php echo date("Y-m-d") ?></strong>
      </div>
    </div>
    <div class="qrcode">
    <img src='<?= $qrcode ?>' alt='QR Code' width='100' height='100'>
        </div>
  </section>
</div>