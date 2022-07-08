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
$qrcode = (new QRCode($options))->render("http://aei-sigma.com/sigma/?c=BOM&a=BOM&status=view&id=$id->id");
?>

<header>
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Sigma | Bill Of Material</title>
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

    #loading {
    display: none;
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 20000;
    background: url(assets/img/loader.gif) center no-repeat #fff;
    background-size: 10vw;
    opacity: 0.9;
    }
</style>

<div id="loading"></div>


<div class="row p-4">

    <div class="col-12">
        <button type="button" class="btn btn-primary printBtn float-right noprint m-1" onclick="window.print();return false;"><i class="fas fa-print"></i></button>
    </div>

    <table style='text-align:center;width:100%;padding:0' class="mb-4">
        <tr>
            <td><img src='<?= $qrcode ?>' alt='QR Code' width='120' height='120'></td>
            <td style='width:33%'><img style='width:100px' src='assets/img/logo.png'></td>
            <td style='width:33%'><h1>BILL OF MATERIAL</h1></td>
            <td style='width:33%;font-size:18px'>
                <b>Code:</b> F02-PRPS-02
                <br>
                <b>Date:</b> 2021-10-14
                <br>
                <b>Version:</b> 01
            </td>
        </tr>
    </table>

    <table class="table table-striped mb-4">
        <tr>
            <th>Id</th>
            <th>Code</th>
            <th>Project</th>
            <th>Scope</th>
            <th>PM</th>
            <th>Designer</th>
            <th>Date</th>
        </tr>
        <tr>
            <td><?php echo $id->id ?> </td>
            <td><?php echo $id->code ?> </td>
            <td><?php echo $id->projectname ?> </td>
            <td><?php echo htmlentities(stripslashes($id->scope)) ?></td>
            <td><?php echo $id->pmname ?></td>
            <td><?php echo $id->username ?></td>
            <td><?php echo $id->createdAt ?></td>
        </tr>
    </table>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="bg-secondary">Item</th>
            <th class="bg-secondary">Id</th>
            <th class="bg-secondary">Description</th>
            <th class="bg-secondary">Alloy</th>
            <th class="bg-secondary">Size</th>
            <th class="bg-secondary">Length</th>
            <th class="bg-secondary">Finish</th>
            <th class="bg-secondary">Total <br> Qty</th>
            <?php if($status != 'process') { ?> <th class="bg-secondary">Partial <br> Qty</th> <?php } ?>
            <th class="bg-secondary">Location</th>
            <th class="bg-secondary">Destination</th>
            <th class="bg-secondary">Requisition</th>
            <th class="bg-secondary">Notes</th>
            <th class="bg-secondary">SAP CODE</th>
        </tr>
        </thead>
        <tbody>
        <?php $pp=0;$qa=0;$pta=0;$i=1; foreach($this->bom->itemList($id->id) as $r) { 
        $partial = ($this->bom->deliverSum($r->id)->total == '') ? 0 : $this->bom->deliverSum($r->id)->total;
        ?>
        <tr>
            <td><?php echo $i?></td>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->description ?></td>
            <td><?php echo $r->alloy ?></td>
            <td><?php echo stripslashes($r->size) ?>
            <td><?php echo $r->length ?> <?php echo $r->uom ?>
            <td><?php echo $r->finish ?>
            <td class="qty"><?php echo $r->qty ?>
            <?php if($status != 'process') { ?> <td class="partial"> <?php echo $partial ?> </td>
            <?php } ?>
            <td><?php echo $r->location ?>
            <td><?php echo $r->destination ?>
            <td><?php echo $r->requisition ?>
            <td><?php echo $r->notes ?>
            <td><input class="sap" value="<?php echo ($r->SAPCode) ? $r->SAPCode : ''; ?>" data-id="<?php echo $r->id ?>" <?php echo (!in_array(27, $permissions)) ? 'disabled':''; ?>></td>
        </tr>
        <?php $i++; } ?>
        </tbody>
    </table>


    <table class="table table-striped">
        <thead>
        <tr>
            <th class="bg-secondary">Item Id</th>
            <th class="bg-secondary">Date</th>
            <th class="bg-secondary">Quantity</th>
            <th class="bg-secondary">Notes</th>
            <th class="bg-secondary">Delivered By</th>
            <th class="bg-secondary">Received By</th>
            <th class="bg-secondary text-center">SAP Save</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach($this->bom->deliverListBOM($id->id) as $r) { ?>
        <tr>
            <td><?php echo $r->itemId ?>
            <td><?php echo $r->createdAt ?>
            <td><?php echo $r->qty ?>
            <td><?php echo $r->notes ?>
            <td><?php echo $r->username ?>
            <td><?php echo $r->signname ?>
            
            <td class="text-center"><input type="checkbox" style="zoom:2" name="check" class="check" value="<?php echo $r->id ?>" <?php echo (!in_array(27, $permissions) or $r->SAP) ? 'disabled':''; ?> <?php echo ($r->SAP) ? 'checked':''; ?> > </td>
        </tr>
        <?php $i++; } ?>
        </tbody>
    </table>
</div>
<script>
$(".check").on("click", function(e) {
    id = $(this).val();
    e.preventDefault();
    Swal.fire({
        title: 'SAP check this Item?',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=BOM&a=DeliverForm", { id }).done(function( res ) {
               location.reload();
            });
        }
    })
});

$(".sap").on("blur", function(e) {
    id = $(this).data('id');
    code = $(this).val();
    e.preventDefault();
    $("#loading").show();
    $.post("?c=BOM&a=SAPCode", { id,code }).done(function( res ) {
        location.reload();
    });
});
</script>
