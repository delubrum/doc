<table id="vendorsTable" class="table table-head-fixed table-striped table-hover" style="width:100%">
    <thead>
    <tr>
        <?php if ($status != 'purchase' and $status != 'receive' and $status != 'view' ) { ?> <th class="bg-secondary"><i class="fa fa-arrow-down"></th> <?php } ?>
        <th class="bg-secondary">Vendor</th>
        <th class="bg-secondary">Days</th>
        <th class="bg-secondary">Price</th>
        <th class="bg-secondary">Total Price</th>
        <th class="bg-secondary">Notes</th>
        <?php if ($status != 'purchase' and $status != 'receive' and $status != 'view' and $status != 'pmapprove' and $status != 'approve') { ?> <th class="bg-secondary text-right">Actions</th> <?php } ?>


    </tr>
    </thead>
    <tbody>
    <?php ($status != 'purchase' and $status != 'receive' and $status != 'view') ? $filters = '' : $filters = 'and suggestedAt is not null';
    $i=1; foreach($this->purchases->itemVendorsList($item->id,$filters) as $r) { ?>
    <tr>
        <?php if ($status != 'purchase' and $status != 'receive' and $status != 'view') { ?> <td class="text-center"><input type="radio" name="check" class="form-check-input purchaseVendorCheck" value="<?php echo $r->id ?>" data-id='<?php echo $r->itemId ?>' data-purchase='<?php echo $r->purchaseId ?>' <?php echo ($r->suggestedAt) ? 'checked' : ''; ?> <?php echo ($i==1) ? 'required' : ''; ?>></td> <?php } ?>
        <td class="vendorcheck"><?php echo $r->vendor ?>
        <td><?php echo $r->date ?>
        <td><?php echo number_format($r->price,2); ?>
        <td><?php echo number_format($r->price * $r->qty,2); ?>
        <td><?php echo $r->notes ?>
        <?php if ($status != 'purchase' and $status != 'receive' and $status != 'view' and $status != 'pmapprove' and $status != 'approve') { ?>
          <td class="text-right">
            <button type="button" class="btn btn-primary copyVendor" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-item="<?php echo $r->itemId; ?>" title="Copy"><i class="fas fa-copy"></i></button>
            <button type="button" class="btn btn-primary deleteVendor" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-item="<?php echo $r->itemId; ?>" data-purchase='<?php echo $r->purchaseId ?>' title="Delete"><i class="fas fa-trash"></i></button>
          </td>
        <?php } ?>

    </tr>
    <?php $i++; } ?>
    </tbody>
</table>

<script>

$(document).on('click', '.purchaseVendorCheck', function(e) {
  itemId = $(this).data('id');
  vendorId = $(this).val();
  purchaseId = $(this).data('purchase');
  $("#loading").show();
  $.post( "?c=Purchases&a=VendorCheck", { itemId, vendorId }).done(function( data ) {
    $("#loading").hide();
    $("#purchasePrice").load("?c=Purchases&a=PurchasePrice&id=" + purchaseId);
    $("#itemsTable").load("?c=Purchases&a=PurchaseItemList&status=<?php echo $status ?>&id=" + purchaseId);
  });
});

$(document).on('click', '.deleteVendor', function(e) {
    id = $(this).data("id");
    item = $(this).data("item");
    purchaseId = $(this).data("purchase");
    e.preventDefault();
    Swal.fire({
        title: 'Delete this Vendor?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=Purchases&a=VendorDelete", { id,item }).done(function( res ) {
                $("#vendorsTable").load("?c=Purchases&status=pricing&a=itemVendorsList&id=" + res.trim());
                $("#purchasePrice").load("?c=Purchases&a=PurchasePrice&id=" + purchaseId);
                $("#itemsTable").load("?c=Purchases&a=PurchaseItemList&status=<?php echo $status ?>&id=" + purchaseId);
                $("#loading").hide();
            });
        }
    })
});

$(document).on('click', '.copyVendor', function(e) {
  id = $(this).data('id');
  item = $(this).data('item');
  $.post( "?c=Purchases&a=ItemVendorForm", { id,item }).done(function( data ) {
    $('#xsModal').modal('toggle');
    $('#xsModal .modal-content').html(data);
  });
});
</script>