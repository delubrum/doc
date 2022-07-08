<table id="itemsTable" class="table table-head-fixed table-striped table-hover" style="width:100%;font-size:14px">
    <thead>
    <tr>
        <th class="bg-secondary">Item</th>
        <th class="bg-secondary">Part Number</th>
        <th class="bg-secondary">Description</th>
        <th class="bg-secondary">Mass</th>
        <th class="bg-secondary">Painting <br> Area</th>
        <th class="bg-secondary">Finish & <br> UC Code</th>
        <th class="bg-secondary">Qty</th>
        <th class="bg-secondary">Notes</th>
        <th class="bg-secondary">Processes</th>
        <?php if($status != 'process' and $status != 'print') { ?> <th class="bg-secondary">Files</th> <?php } ?>
        <?php if($status == 'process') { ?> <th class="bg-secondary text-right" style="width:15%">Actions</th> <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php $pp=0;$qa=0;$pta=0;$i=1; foreach($this->wo->itemList($id->id) as $r) { ?>
    <tr>
        <td><?php echo $i?></td>
        <td><?php echo $r->number ?></td>
        <td><?php echo stripslashes($r->name) ?></td>
        <td>
        <?php 
        ($r->pa <> 0) ? $paa = $r->pa : $paa=0; 
        (!strpos($r->number,'AS')) ? $pp+=($r->weight*$r->qty) : ''; 
        echo number_format($r->weight,2) ?>
        <?php echo $r->uom ?>    
        </td>
        <td><?php $pta+=($paa*$r->qty); echo number_format($paa/1000000,2) ?> m2</td>
        <td><?php echo $r->finish ?></td>
        <td><?php $qa+=$r->qty; echo $r->qty ?></td>
        <td><?php echo $r->notes ?></td>
        <td><?php if(!empty($r->processes)) {foreach(json_decode($r->processes) as $p) { echo $this->wo->processGet($p)->name . ","; }} ?></td>
        <?php if($status != 'process' and $status != 'print') { ?> 
            <td class="text-left">
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
        <?php } ?>

        <?php if($status == 'process') { ?>
            <td class="text-right">
                <?php if($status == 'process') { ?>  <button type="button" class="btn btn-primary copy" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" data-wo="<?php echo $r->woId; ?>" title="Copy"><i class="fas fa-copy"></i></button> <?php } ?>
                <?php if($status == 'process') { ?>  <button type="button" class="btn btn-primary delete" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" data-wo="<?php echo $r->woId; ?>" title="Delete"><i class="fas fa-trash"></i></button> <?php } ?>
            </td>
        <?php } ?>
    </tr>
    <?php $i++; } ?>
    <tr>
        <th><?php echo $i-1 ?></th>
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
    </tbody>
</table>

<script>
$(document).on("click", ".delete", function(e) {
    id = $(this).data("id");
    wo = $(this).data("wo");
    e.preventDefault();
    Swal.fire({
        title: 'Delete this item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=WorkOrders&a=ItemDelete",{id,wo}).done(function(res) {
                $("#itemsTable").load("?c=WorkOrders&a=ItemList&status=process&id=" + res.trim());
                $("#loading").hide();
            });
        }
    })
});

$(document).on("click", ".copy", function(e) {
  id = $(this).data('id');
  wo = $(this).data('wo');
  $.post( "?c=WorkOrders&a=NewItem", { id,wo }).done(function( data ) {
      $('#lgModal').modal('toggle');
      $('#lgModal .modal-content').html(data);
  });
});
</script>