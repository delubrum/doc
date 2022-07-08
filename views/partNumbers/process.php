
<form method="post">
  <div class="modal-header">
  <h5 class="modal-title">Process Project: <b><?php echo $item->id . " / " . $item->name ?></b></h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
  <a type="button" href="?c=PartNumbers&a=Excel&id=<?php echo $item->id?>" class="btn btn-success float-right mb-4 ml-1"><i class="fas fa-file-excel p-1"></i></i></a>


    <button type="button" class="btn btn-primary float-right add mb-4" data-id="<?php echo $item->id ?>">
      <i class="fas fa-plus"></i> Add Part Number
    </button>

    <div class="card-body table-responsive p-0" style="height: 400px;">
      <?php $this->List($item->id) ?>
    </div>
  </div>
</form>

<script>
$(document).on("click", ".add", function() {
    projectId = $(this).data('id');
    $.post( "?c=PartNumbers&a=Add", {projectId}).done(function( data ) {
        $('#xsModal').modal('toggle');
        $('#xsModal .modal-content').html(data);
    });
});
</script>