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
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Sigma | Work Order Items</title>
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">


</header>

<style>
    @media print {    
        .noprint {
            display: none !important;
        }
    }

@media print 
{
    .boarding-pass { display: block !important; }
}

small {font-weight:bold}
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
  size: 234px 290px;
}


@media print {
.boarding-pass { 
    page-break-before: avoid;
    page-break-after: avoid;
    page-break-inside: avoid;
  }
}
</style>

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