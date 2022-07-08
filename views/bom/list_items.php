<table id="itemsTable" class="table table-head-fixed table-striped table-hover" style="width:100%;font-size:14px">
    <thead>
    <tr>
        <th class="bg-secondary">Item</th>
        <th class="bg-secondary">Description</th>
        <th class="bg-secondary">Alloy</th>
        <th class="bg-secondary">Size</th>
        <th class="bg-secondary">Length</th>
        <th class="bg-secondary">Finish</th>
        <th class="bg-secondary">Total <br> Qty</th>
        <?php if($status != 'process') { ?> <th class="bg-secondary">Partial <br> Qty</th> <?php } ?>
        <?php if($status != 'process') { ?> <th class="bg-secondary">Diference</th> <?php } ?>

        <th class="bg-secondary">Location</th>
        <th class="bg-secondary">Destination</th>
        <th class="bg-secondary">Requisition</th>
        <th class="bg-secondary">Notes</th>
        <th class="bg-secondary text-right" style="width:15%">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php $pp=0;$qa=0;$pta=0;$i=1; foreach($this->bom->itemList($id->id) as $r) { 
    $partial = ($this->bom->deliverSum($r->id)->total == '') ? 0 : $this->bom->deliverSum($r->id)->total;
    ?>
    <tr>
        <td><?php echo $i?></td>
        <td><?php echo $r->description ?></td>
        <td><?php echo $r->alloy ?></td>
        <td><?php echo stripslashes($r->size) ?>
        <td><?php echo $r->length ?> <?php echo $r->uom ?>
        <td><?php echo $r->finish ?>
        <td class="qty"><?php echo $r->qty ?>
        <?php if($status != 'process') { ?> <td class="partial"> <?php echo $partial ?> </td> <?php } ?>
        <?php if($status != 'process') { ?> <td> <?php echo $r->qty - $partial ?> </td> <?php } ?>

        <td><?php echo $r->location ?>
        <td><?php echo $r->destination ?>
        <td><?php echo $r->requisition ?>
        <td><?php echo $r->notes ?>
            <td class="text-right">
                <?php if($status == 'process') { ?>  <button type="button" class="btn btn-primary copy" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" data-bom="<?php echo $r->bomId; ?>" title="Copy"><i class="fas fa-copy"></i></button> <?php } ?>
                <?php if($status == 'process') { ?>  <button type="button" class="btn btn-primary delete" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" data-bom="<?php echo $r->bomId; ?>" title="Delete"><i class="fas fa-trash"></i></button> <?php } ?>
                <?php if($status == 'confirm' and ($r->qty != $partial)) { ?>  <button type="button" class="btn btn-primary deliver" data-toggle="tooltip" data-placement="top" data-status='confirm' data-id="<?php echo $r->id; ?>" data-bom="<?php echo $r->bomId; ?>" title="Deliver"><i class="fas fa-file-invoice"></i></button> <?php } ?>
            </td>

    </tr>
    <?php $i++; } ?>
    </tbody>
</table>

<script>
$(document).on("click", ".deliver", function(e) {
  id = $(this).data('id');
  status = $(this).data('status');
  $.post( "?c=BOM&a=Deliver", { id,status }).done(function( data ) {
      $('#lgModal').modal('toggle');
      $('#lgModal .modal-content').html(data);
  });
});

$(document).on("click", ".delete", function(e) {
    id = $(this).data("id");
    bom = $(this).data("bom");
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
            $.post("?c=BOM&a=ItemDelete",{id,bom}).done(function(res) {
                $("#itemsTable").load("?c=BOM&a=ItemList&status=process&id=" + res.trim());
                $("#loading").hide();
            });
        }
    })
});

$(document).on("click", ".copy", function(e) {
  id = $(this).data('id');
  bom = $(this).data('bom');
  $.post( "?c=BOM&a=NewItem", { id,bom }).done(function( data ) {
      $('#lgModal').modal('toggle');
      $('#lgModal .modal-content').html(data);
  });
});
</script>