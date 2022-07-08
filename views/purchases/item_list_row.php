<table id="itemsTable" class="table table-head-fixed table-striped table-hover" style="width:100%">
    <thead>
    <tr>
        <th class="bg-secondary">Item</th>
        <th class="bg-secondary">Id</th>
        <th class="bg-secondary">Material</th>
        <th class="bg-secondary text-center">Quantity</th>
        <?php if($status == 'receive' or $status == 'view') { ?> <th class="bg-secondary" style="width:15%">Received</th> <?php } ?>
        <th class="bg-secondary">Notes</th>
        <th class="bg-secondary">Vendors</th>
        <th class="bg-secondary">Price</th>
        <?php if($status == 'purchase' or $status == 'receive' or $status == 'view') { ?> <th class="bg-secondary" style="width:15%">Order #</th> <?php } ?>
        <?php if($status == 'purchase' or $status == 'receive' or $status == 'view') { ?> <th class="bg-secondary" style="width:7%">Days</th> <?php } ?>
        <th class="bg-secondary text-center">Files</th>
        <th class="bg-secondary text-right" style="width:15%">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($this->purchases->purchasesItemsList($purchase->id) as $r) {
          $prev = ($this->purchases->deliverSum($r->id)->total == '') ? 0 : $this->purchases->deliverSum($r->id)->total;
          if ($r->partial != 0) {
            $partial = $r->partial + $prev;
          } else {
            $partial = $prev;
          }
          ?>
    <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $r->id ?></td>
        <td><?php echo htmlentities(stripslashes($r->material)) ?></td>
        <td class="text-center itemQty"><?php echo $r->qty ?>
        <?php if($status == 'receive' or $status == 'view') { ?><td class="partial"><?php echo $partial ?></td><?php } ?>
        <?php if($status == 'pricing') { ?><td><textarea class="notes" data-id="<?php echo $r->id ?>"><?php echo $r->notes ?></textarea></td><?php } ?>
        <?php if($status != 'pricing') { ?> <td class="text-justify"><?php echo $r->notes ?></td><?php } ?>
        <td class="vendorcheck"><?php echo count($this->purchases->itemVendorsList($r->id,'')) ?>
        <td><?php echo number_format(ceil($this->purchases->itemPrice($r->id)->total),0); ?></td>
        <?php if($status == 'purchase') { ?><td><input value="<?php echo $r->purchaseOrder ?>" class="order" data-id="<?php echo $r->id ?>" required> </td><?php } ?>
        <?php if($status == 'purchase') { ?><td><input type="number" style="width:100%" value="<?php echo $r->days ?>" class="days" data-id="<?php echo $r->id ?>" required> </td><?php } ?>
        <?php if($status == 'receive' or $status == 'view') { ?> <td class="text-center"><?php echo $r->purchaseOrder ?></td><?php } ?>
        <?php if($status == 'receive' or $status == 'view') { ?> <td class="text-center"><?php echo $r->days ?></td><?php } ?>
        <td class="text-center">
        <?php
        $directorio = "uploads/purchases/files/$r->id/";
        if (file_exists($directorio)) {
        if ($gestor = opendir($directorio)) {
        $list=array();
        while (false !== ($arch = readdir($gestor)))
        { if ($arch != "." && $arch != "..")
        { $list[]=$arch; } }
        sort($list, SORT_NUMERIC);
        foreach($list as $fileName)
        {echo "<a target='_blank' href='$directorio$fileName'><i class='fas fa-file'></i></a><br>"; }
        closedir($gestor);
        }
        }
        ?>
        </td>
        <td class="text-right">
                <?php if($status == 'process') { ?>  <button type="button" class="btn btn-primary copy" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" data-purchase="<?php echo $r->purchaseId; ?>" title="Copy"><i class="fas fa-copy"></i></button> <?php } ?>
                <?php if($status == 'process') { ?>  <button type="button" class="btn btn-primary delete" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" data-purchase="<?php echo $r->purchaseId; ?>" title="Delete"><i class="fas fa-trash"></i></button> <?php } ?>
                <?php if($status == 'pricing') { ?>  <button type="button" class="btn btn-primary quote" data-toggle="tooltip" data-placement="top" data-status='pricing' data-id="<?php echo $r->id; ?>" title="Quote"><i class="fas fa-file-invoice-dollar"></i></button> <?php } ?>
                <?php if($status == 'pmapprove' or $status == 'approve' or $status == 'purchase' or $status == 'receive' or $status == 'view') { ?> <button type="button" class="btn btn-primary quote" data-status="<?php echo $status ?>" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Check"><i class="fas fa-eye"></i></button><?php } ?>
                <?php if($status == 'receive' and ($r->qty != $partial)) { ?>  <button type="button" class="btn btn-primary deliver" data-toggle="tooltip" data-placement="top" data-status='receive' data-id="<?php echo $r->id; ?>" data-purchase="<?php echo $r->purchaseId; ?>" title="Deliver"><i class="fas fa-file-invoice"></i></button> <?php } ?>
        </td>
    </tr>
    <?php $i++; } ?>
    </tbody>
</table>

<script>
$(document).on("click", ".deliver", function(e) {
  id = $(this).data('id');
  status = $(this).data('status');
  $.post( "?c=purchases&a=Deliver", { id,status }).done(function( data ) {
      $('#lgModal').modal('toggle');
      $('#lgModal .modal-content').html(data);
  });
});


$(document).on('click', '.delete', function(e) {
    id = $(this).data("id");
    purchase = $(this).data("purchase");
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
            $.post("?c=Purchases&a=ItemDelete", { id,purchase }).done(function( res ) {
                $("#itemsTable").load("?c=Purchases&a=PurchaseItemList&status=process&id=" + res.trim());
                $("#purchasePrice").load("?c=Purchases&a=PurchasePrice&id=" + purchase);
                $("#loading").hide();
            });
        }
    })
});

$(document).on('click', '.copy', function(e) {
  id = $(this).data('id');
  purchase = $(this).data('purchase');
  $.post( "?c=Purchases&a=PurchaseItemForm", { id,purchase }).done(function( data ) {
      $('#xsModal').modal('toggle');
      $('#xsModal .modal-content').html(data);
  });
});

$(document).on('blur', '.order', function(e) {
  id = $(this).data('id');
  order = $(this).val();
  $("#loading").show();
  $.post( "?c=Purchases&a=ItemOrderSave", { id,order }).done(function( data ) {
    $("#loading").hide();
  });
});

$(document).on('blur', '.days', function(e) {
  id = $(this).data('id');
  days = $(this).val();
  $("#loading").show();
  $.post( "?c=Purchases&a=ItemDaysSave", { id,days }).done(function( data ) {
    $("#loading").hide();
  });
});

$(document).on('blur', '.notes', function(e) {
  id = $(this).data('id');
  notes = $(this).val();
  $("#loading").show();
  $.post( "?c=Purchases&a=ItemNotesSave", { id,notes }).done(function( data ) {
    $("#loading").hide();s
  });
});
</script>