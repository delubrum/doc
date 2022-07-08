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
$qrcode = (new QRCode($options))->render("http://aei-sigma.com/sigma/?c=WorkOrders&a=WorkOrder&status=view&id=$id->id");
?>

<header>
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Sigma | Work Order</title>
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
        <?php if(!$id->closedAt and !$id->cancelledAt) { ?>
            <?php if (in_array(26, $permissions)) { ?>
                <button type="button" class="btn btn-danger cancelWO float-right noprint m-1" data-id="<?php echo $id->id?>"><i class="fas fa-trash"></i></button>
            <?php } ?>
        <?php } ?>
        <button type="button" class="btn btn-primary printBtn float-right noprint m-1" onclick="window.print();return false;"><i class="fas fa-print"></i></button>
        <a type="button" href="?c=WorkOrders&a=Excel&id=<?php echo $id->id?>" class="btn btn-success float-right noprint m-1"><i class="fas fa-file-excel"></i></i></a>


        <?php $directorio = "uploads/workOrders/PDF/$id->id/";
                      if ((count(glob("$directorio/*")) != 0)) { ?>
                      <?php
                      if ($gestor = opendir($directorio)) {
                        $list=array();
                        while (false !== ($arch = readdir($gestor))) { if ($arch != "." && $arch != "..") {
                          $list[]=$arch; } 
                        }
                      sort($list);
                      foreach($list as $fileName)
                      { ?>
        <a type="button" href="<?php echo "$directorio$fileName" ?>" class="btn btn-danger float-right noprint m-1"><i class="fas fa-file-pdf"></i></i></a>



                      <?php
                      }
                      closedir($gestor);
                      }
                      ?>
                    <?php } ?>


        <?php if (in_array(26, $permissions)) { ?>
            <?php if(!$id->closedAt and !$id->cancelledAt) { ?>
                <button type="button" class="btn btn-info closeWO  noprint m-1 float-right" data-id="<?php echo $id->id?>"><i class="fas fa-check"></i></button>
            <?php } ?>
        <?php } ?>
        <?php if($id->closedAt) { ?> <span class="h2 text-info float-right mr-4">CLOSED</span>     <?php } ?>
        <?php if($id->cancelledAt) { ?> <span class="h2 text-danger float-right mr-4">CANCELLED</span>     <?php } ?>
    </div>
    
    <table style='text-align:center;width:100%;padding:0' class="mb-4">
        <tr>
            <td><img src='<?= $qrcode ?>' alt='QR Code' width='120' height='120'></td>
            <td style='width:33%'><img style='width:100px' src='assets/img/logo.png'></td>
            <td style='width:33%'><h1>WORK ORDER</h1></td>
            <td style='width:33%;font-size:18px'>
                <b>Code:</b> F04-PRED-01
                <br>
                <b>Date:</b> 2021-10-22
                <br>
                <b>Version:</b> 01
            </td>
        </tr>
    </table>
    <table class="table table-striped mb-4">
        <tr>
            <th>Id</th>
            <th>Project</th>
            <th>Scope</th>
            <th>Order</th>
            <th>PM</th>
            <th>User</th>
            <th>Date</th>
        </tr>
        <tr>
            <td><?php echo $id->id ?> </td>
            <td><?php echo $id->projectname ?> </td>
            <td><?php echo htmlentities(stripslashes($id->scope)) ?></td>
            <td><?php echo $id->designation ?></td>
            <td><?php echo $id->pmname ?></td>
            <td><?php echo $id->username ?></td>
            <td><?php echo $id->sentAt ?></td>
        </tr>
    </table>
    <table class="table mt-3 noprint">
        <tr>
            <td>
            <b>Other Files:</b>
                <ul>
                <?php
                $directorio = "uploads/workOrders/other/$id->id/";
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
                            echo "<li><a download target='_blank' href='$directorio$fileName'>$fileName</a></li>"; 
                        }
                        closedir($gestor);
                    }
                }                    
                ?>
            
            </ul>
            </td>
        <td>
           
            <b>BOM:</b>
            <ul>
                <?php $i=1;foreach($this->wo->bomList($id->id) as $r){ 
                echo "<li><a href='?c=BOM&a=BOM&status=view&id=$r->id' target='_blank'>" . $r->code . "</a></li>";
                } ?>
            </ul>
            </td>
        </tr>
    </table>

    <button type="button" class="btn btn-primary float-right noprint m-2 tickets"><i class="fas fa-print"></i> Print Selected Tickets</button>


    <table class="table table-striped">
        <tr>
            <th class="noprint"><input type="checkbox" class="checkall"></th>
            <th>Item</th>
            <th>Part Number</th>
            <th>Description</th>
            <th>Mass</th>
            <th>Painting<br>Area</th>
            <th>Finish &<br>UC Code</th>
            <th>Qty</th>
            <th>Notes</th>
            <th>Processes</th>
            <th class="noprint">Files</th>
            <th>Actions</th>
        </tr>
        <?php 
        $pp=0;$qa=0;$pta=0;$i=1;
        foreach($this->wo->itemList($id->id) as $r) { ?>
        <tr>
            <th class="noprint"><input style="width:50px" type="number" name="checkid" class="printqty" value="0" data-id="<?php echo $r->id ?>"></th>
            <td class="text-center"><?php echo $i ?>
            <td class="text-justify"><?php echo $r->number ?>
            <td class="text-justify"><?php echo stripslashes($r->name) ?>
            <td class="text-justify">
                <?php 
                ($r->pa <> 0) ? $paa = $r->pa : $paa=0; 
                (!strpos($r->number,'AS')) ? $pp+=($r->weight*$r->qty) : ''; 
                echo number_format($r->weight,2) 
                ?>
                <?php echo $r->uom ?>
            <td class="text-justify">
                <?php $pta+=($paa*$r->qty); echo number_format($paa/1000000,2) ?> m2
            <td class="text-justify">
                <?php echo $r->finish ?>
            <td class="text-justify">
                <?php $qa+=$r->qty; echo $r->qty ?>
            <td class="text-justify"><?php echo $r->notes ?>
            <td class="text-justify">
            <?php if(!empty($r->processes)) {foreach(json_decode($r->processes) as $p) { echo $this->wo->processGet($p)->name . "<br>"; }} ?></td>
            <td class="text-left noprint pr-4">
            <label>DXF:</label><br>
            <?php
            $directorio = "uploads/workOrders/DXF/$id->id/";
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
                    if (substr($fileName, 0, -4) == $r->number) {
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
            $directorio = "uploads/workOrders/PDF/$id->id/";
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
                    if ($zip->locateName("$r->number.pdf") !== false) {
                        echo "<a target='_blank' href='?c=WorkOrders&a=ZipFilePDF&id=$id->id&zip=$fileName&file=$r->number.pdf&folder=PDF'><i class='fas fa-file'></i> $r->number</a>";
                    }
                    closedir($gestor);
                }
                }
            }
            ?>
            <br>
            <label>STP:</label><br>
            <?php
            $directorio = "uploads/workOrders/STP/$id->id/";
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
                    if ($zip->locateName("$r->number.stp") !== false) {
                        echo "<a download target='_blank' href='?c=WorkOrders&a=ZipFile&id=$id->id&zip=$fileName&file=$r->number.stp&folder=STP'><i class='fas fa-file'></i> $r->number</a>";
                    }
                    closedir($gestor);
                }
                }
            }
            ?>
            </td> 


            <td class="text-center">


            <?php if (in_array(26, $permissions)) { ?>

                <?php if(!$id->closedAt and !$id->cancelledAt) { ?>


                
<span>
            <input type="checkbox" style="zoom:2" name="check" class="form-check-input check " value="<?php echo $r->id ?>" 
            <?php echo ($r->closedAt) ? 'checked disabled' : '' ?>></span>

            
            <?php if (!$r->closedAt) { ?> <button type="button" class="btn btn-danger cancel float-right noprint m-2" data-id="<?php echo $r->id ?>"><i class="fas fa-trash"></i></button>  <?php } ?>

            

            <?php } ?>

            <?php } ?>


            <a href="?c=WorkOrders&a=Item&id=<?php echo $r->id ?>" target="_blank" class="btn btn-primary float-right noprint m-2"><i class="fas fa-print"></i></a>

            </td>

            <?php $i++; } ?>
        </tr>
        <tr>
            <th></th>
            <th class="text-center"><?php echo $i-1 ?></th>
            <th></th>
            <th>
            <th><?php echo number_format($pp,2) ?> lbmass</th>
            <th><?php echo number_format($pta/1000000,2) ?> m2</th>
            <th>
            <th><?php echo number_format($qa,2) ?> U</th>
            <th>
            <th>
            <th>
        </tr>
    </table>
</div>

<script>
$(".check").on("click", function(e) {
    id = $(this).val();
    status = 'close';
    e.preventDefault();
    Swal.fire({
        title: 'Close this Item?',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=WorkOrders&a=ItemForm", { id,status }).done(function( res ) {
                location.reload();
            });
        }
    })
});

$(".cancel").on("click", function(e) {
    id = $(this).data("id");
    status = 'cancel';
    e.preventDefault();
    Swal.fire({
        title: 'Cancel this Item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=WorkOrders&a=ItemForm", { id,status }).done(function( res ) {
                location.reload();
            });
        }
    })
});

$(".cancelWO").on("click", function(e) {
    id = $(this).data("id");
    status = 'email';
    e.preventDefault();
    Swal.fire({
        title: 'Cancel this Item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=WorkOrders&a=Delete", { id,status }).done(function( res ) {
                location.reload();
            });
        }
    })
});

$(".closeWO").on("click", function(e) {
    id = $(this).data("id");
    status = 'close';
    e.preventDefault();
    Swal.fire({
        title: 'Close this Work Order?',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            if ($('.check:checked').length == $('.check').length) {
                $("#loading").show();
                $.post("?c=WorkOrders&a=FormSave", { id,status }).done(function( res ) {
                    location.reload();
                });
            } else {
                toastr.error('Close all items first');
            }
        }
    })
});



$(".checkall").click(function(){
    if(this.checked) {
    $('.printqty').val(1);
    } else {
    $('.printqty').val(0);
    }

});

$(".tickets").click(function(){
    var array = $("input[name=checkid]").map(function(){return $(this).val()}).get();
    var arrayb = $("input[name=checkid]").map(function(){return $(this).data('id')}).get();
    if(arrayb.length != 0) {
        $("#loading").show();
        $.post('?c=WorkOrders&a=Tickets', {'id[]': arrayb, 'val[]': array }, function (data) {
            var w = window.open('about:blank');
            w.document.open();
            w.document.write(data);
            w.document.close();
            $("#loading").hide();
        });
    }
});
</script>