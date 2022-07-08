
<form method="post" id="close_form">
  <input type="hidden" name="itemId" value="<?php echo $item->id ?>">
  <input type="hidden" name="purchaseId" value="<?php echo $item->purchaseId ?>">
  <div class="modal-header">
  <h5 class="modal-title"> <?php echo ($status == 'pricing') ? 'Quote' : 'Approve' ?> Item: <b><?php echo $item->id . " / " . $item->material ?></b></h5>

  <?php if ($status == 'pricing') { ?>
    <button type="submit" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  <?php } else { ?>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  <?php } ?>

  </div>
  <div class="modal-body">
  <?php require_once "info_item.php" ?>

    <?php if ($status == 'pricing') { ?>
    <button type="button" class="btn btn-primary float-right newVendor mb-4" data-item="<?php echo $item->id ?>">
      <i class="fas fa-user-plus"></i> Add Vendor
    </button>
    <?php } ?>
    <div class="card-body table-responsive p-0" style="height: 400px;">
      <?php $this->ItemVendorsList($item->id) ?>
    </div>
  </div>
</form>

<div class="modal fade rejectCause" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <form method="post" id="reject_form">
              <div class="modal-header">
                  <h5 class="modal-title">Reject Cause</b></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>* Reject Cause:</label>
                          <div class="input-group">
                              <textarea type="text" class="form-control form-control-sm" name="cause"></textarea>
                              <input type="hidden" name="itemId" value="<?php echo $item->id ?>">
                              <input type="hidden" name="purchaseId" value="<?php echo $item->purchaseId ?>">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Reject</button>
              </div>
          </form>
      </div>
  </div>
</div>
<script>

 
$(document).on('click', '.newVendor', function(e) {
  item = $(this).data('item');
  $.post( "?c=Purchases&a=ItemVendorForm", { item }).done(function( data ) {
    $('#xsModal').modal('toggle');
    $('#xsModal .modal-content').html(data);
  });
});

$('#close_form').on('submit', function(e) {
  e.preventDefault();
  $('#lgModal').modal('toggle');
});
</script>