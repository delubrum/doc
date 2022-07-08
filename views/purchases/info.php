<?php if($this->init->RejectList('purchase',$purchase->id)) { ?><button type="button" class="btn btn-warning rejections float-right" data-toggle="tooltip" data-placement="top" data-id="<?php echo $purchase->id; ?>" data-type='purchase' title="Rejections"><i class="fas fa-exclamation"></i></button><?php } ?>

<div class="row">
    <div class="col-sm-4">
        <dl>
            <dt><i class="fas fa-info-circle"></i> ID:</dt>
            <dd><?php echo $purchase->id ?></dd>
            <dt><i class="fas fa-clipboard-list"></i> PROJECT:</dt>
            <dd><?php echo $purchase->projectName ?></dd>
            <dt><i class="fas fa-globe"></i> DELIVERY PLACE:</dt>
            <?php if($status == 'process') { ?><dd><input value="<?php echo $purchase->deliveryPlace ?>" id="delivery" required> </dd><?php } ?>
            <?php if($status != 'process') { ?> <dd><?php echo $purchase->deliveryPlace ?></dd><?php } ?>
        </dl>
    </div>
    <div class="col-sm-4">
        <dl>
            <dt><i class="fas fa-calendar"></i> SENT DATE:</dt>
            <dd><?php echo $purchase->sentAt ?></dd>
            <dt><i class="fas fa-calendar"></i> MATERIAL ARRIVAL DATE:</dt>
            <?php if($status == 'process') { ?><dd><input type="date" value="<?php echo $purchase->requestDate ?>" id="arrivaldate" required> </dd><?php } ?>
            <?php if($status != 'process') { ?> <dd><?php echo $purchase->requestDate ?></dd><?php } ?>
            <dt><i class="fas fa-user-circle"></i> USER:</dt>
            <dd><?php echo $purchase->username ?></dd>
        </dl>
    </div>
    <div class="col-sm-4">
        <dl>
            <dt><i class="fas fa-user-circle"></i> PROJECT MANAGER:</dt>
            <dd><?php echo $purchase->pmName ?></dd>
            <dt><i class="fas fa-user-circle"></i> QUOTER:</dt>
            <dd><?php echo $purchase->quotername ?></dd>
            <?php if(isset($status) and $status != 'pricing' and $status != 'process') { ?> 
            <dt><i class="fas fa-clipboard-list"></i> QUOTES:</dt>
            <dd>
            <?php
                $directorio = "uploads/purchases/quotes/$purchase->id/";
                if (file_exists($directorio)) {
                if ($gestor = opendir($directorio)) {
                $list=array();
                while (false !== ($arch = readdir($gestor)))
                { if ($arch != "." && $arch != "..")
                { $list[]=$arch; } }
                sort($list, SORT_NUMERIC);
                foreach($list as $fileName)
                {echo "<a target='_blank' href='$directorio$fileName'><i class='fas fa-file'></i> $fileName</a><br>"; }
                closedir($gestor);
                }
                }
            ?>
            </dd>
            <?php } ?>

            <?php if(isset($status) and ($status == 'view' or $status == 'receive')) { ?> 
            <dt><i class="fas fa-clipboard-list"></i> PURCHASE ORDERS:</dt>
            <dd>
            <?php
                $directorio = "uploads/purchases/orders/$purchase->id/";
                if (file_exists($directorio)) {
                if ($gestor = opendir($directorio)) {
                $list=array();
                while (false !== ($arch = readdir($gestor)))
                { if ($arch != "." && $arch != "..")
                { $list[]=$arch; } }
                sort($list, SORT_NUMERIC);
                foreach($list as $fileName)
                {echo "<a target='_blank' href='$directorio$fileName'><i class='fas fa-file'></i> $fileName</a><br>"; }
                closedir($gestor);
                }
                }
            ?>
            </dd>
            <?php } ?>
        </dl>
    </div>
</div>

<script>
$("#delivery,#arrivaldate").on("blur", function() {
  id = <?php echo $purchase->id ?>;
  delivery = $('#delivery').val();
  date = $('#arrivaldate').val();
  $("#loading").show();
  $.post( "?c=Purchases&a=PurchaseInfoSave", { id,delivery,date }).done(function( data ) {
    $("#loading").hide();
  });
});
</script>