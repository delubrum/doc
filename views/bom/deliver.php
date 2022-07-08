
<form method="post">
  <div class="modal-header">
  <h5 class="modal-title"> Deliver Item: <b><?php echo $id->id . " / " . $id->description ?></b></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <?php if ($status == 'confirm') { ?>
    <button type="button" class="btn btn-primary float-right newDeliver mb-4" data-id="<?php echo $id->id ?>" data-bom="<?php echo $id->bomId ?>">
      <i class="fas fa-plus"></i> Deliver
    </button>
    <?php } ?>
    <div class="card-body table-responsive p-0" style="height: 400px;">
      <?php $this->DeliverList($id->id) ?>
    </div>
  </div>
</form>

<script>
$(document).on("click", ".newDeliver", function() {
  id = $(this).data('id');
  bom = $(this).data('bom');
  $.post( "?c=BOM&a=NewDeliver", { id,bom }).done(function( data ) {
    $('#xsModal').modal('toggle');
    $('#xsModal .modal-content').html(data);
  });
});
</script>