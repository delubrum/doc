<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<script src="assets/plugins/select2/js/select2.full.min.js"></script>

<form method="post" id="purchase_form" data-status="<?php echo $status ?>">
  <div class="modal-header">
  <h5 class="modal-title"><?php echo $title ?>: <b><?php echo $purchase->id . " / " . $purchase->projectName ?></b></h5>
  <input type="hidden" name="id" value="<?php echo $purchase->id ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <?php require_once "info.php" ?>

    <?php if($status == 'process') { ?> 
    <button type="button" class="btn btn-primary float-right newItem mb-4" data-purchase="<?php echo $purchase->id ?>">
      <i class="fas fa-plus"></i> Add Item
    </button>
    <?php } ?> 


    <div class="card-body table-responsive p-0" style="height: 300px;">
      <?php $this->PurchaseItemList($purchase->id) ?>
    </div>
    
    <h4 class="text-right" id="purchasePrice">TOTAL :$ <?php echo number_format(ceil($this->purchases->totalPrice($purchase->id)->total),0); ?></h4>

    <?php if($status == 'view') { ?> 

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="bg-secondary">Item Id</th>
            <th class="bg-secondary">Date</th>
            <th class="bg-secondary">Quantity</th>
            <th class="bg-secondary">Notes</th>
            <th class="bg-secondary">Received By</th>
            <th class="bg-secondary text-center">SAP Save</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach($this->purchases->deliverListPurchases($purchase->id) as $r) { ?>
        <tr>
            <td><?php echo $r->itemId ?>
            <td><?php echo $r->createdAt ?>
            <td><?php echo $r->qty ?>
            <td><?php echo $r->notes ?>
            <td><?php echo $r->username ?>
            <td class="text-center"><input type="checkbox" style="zoom:2" name="check" class="check" value="<?php echo $r->id ?>" <?php echo (!in_array(42, $permissions) or $r->SAP) ? 'disabled':''; ?> <?php echo ($r->SAP) ? 'checked':''; ?> > </td>
        </tr>
        <?php $i++; } ?>
        </tbody>
    </table>
    <?php } ?> 

    <?php if($status == 'purchase' or $status == 'pricing') { ?> 
        <div class="row">
          <div class="col-sm-6 files">
          <label class="mt-4"><?php echo ($status == 'purchase') ? 'Purchase Orders:' : 'Quotes'?> </label>
            <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <input type=file name="files[]" multiple required>
                  </div>
              </div>
              <div class="col-sm-6 float-left">
              <button type="button" class="btn btn-primary add" data-toggle="tooltip" data-placement="top" title="Add"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
          <label class="mt-4">Old Files </label>

            <?php 
            ($status == 'purchase') ? $folder = 'orders:' :  $folder =  'quotes';
            $directorio = "uploads/purchases/$folder/$purchase->id/";
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
              <div class="remove">
                <i class='fa fa-file-o'></i> <?php echo $fileName ?> 
                <button class="btn btn-danger m-1" onClick="DeleteFile(this,'<?php echo "$directorio$fileName" ?>');">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
              <?php
              }
              closedir($gestor);
              }
              ?>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
  </div>


  <div class="modal-footer">
    <?php if ($status == 'pricing' or $status == 'process') { ?> <button type="submit" class="btn btn-primary">Send</button> <?php } ?>
    <?php if ($status == 'process') { ?><button type="button" class="btn btn-danger cancel" data-id="<?php echo $purchase->id ?>">Delete</button><?php } ?>
    <?php if ($status == 'pmapprove' or $status == 'approve') { ?> <button type="submit" class="btn btn-primary">Approve</button> <?php } ?>
    <?php if ($status == 'purchase') { ?> <button type="submit" class="btn btn-primary">Purchase</button> <?php } ?>
    <?php if ($status == 'receive') { ?> <button type="submit" class="btn btn-primary">Receive</button> <?php } ?>
    <?php if ($status == 'pmapprove' or $status == 'approve' or $status == 'pricing') { ?> <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".rejectCause"> Reject</button> <?php } ?>
  </div>
</form>


<div class="modal fade rejectCause" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <form method="post" id="preject_form">
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
                              <input type="hidden" name="purchaseId" value="<?php echo $purchase->id ?>">
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
$(document).on('submit', '#preject_form', function(e) {
  e.preventDefault();
  if (document.getElementById("preject_form").checkValidity()) {
      $("#loading").show();
      $.post( "?c=Purchases&a=RejectItem", $( "#preject_form" ).serialize()).done(function(res) {
        location.reload();
      });
  }
});


$(document).on('click', '.quote', function(e) {
  id = $(this).data('id');
  status = $(this).data('status');
  $.post( "?c=Purchases&a=PurchaseQuoteForm", { id,status }).done(function( data ) {
      $('#lgModal').modal('toggle');
      $('#lgModal .modal-content').html(data);
  });
});

$(document).on('click', '.add', function(e) {
  div = `
  <div class="row remove">
    <div class="col-sm-6">
      <div class="form-group">
          <input type=file name="files[]" multiple required>
      </div>
    </div>
    <div class="col-sm-6 float-left">
      <button type="button" class="btn btn-danger removebtn" data-toggle="tooltip" data-placement="top" title="Add"><i class="fas fa-trash"></i></button>
    </div>
    </div>
  </div>
  `,
  $('.files').append(div)
});


$(document).on('click', '.check', function(e) {
    link = $(this);
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
            $.post("?c=Purchases&a=DeliverForm", { id }).done(function( res ) {4
              $("#loading").hide();
              link.prop( "disabled", true );
              link.prop( "checked", true );
            });
        }
    })
});


$(document).on('click', '.removebtn', function(e) {
  $(this).closest('.remove').remove();
});

function DeleteFile(r, que) {
  event.preventDefault();
  Swal.fire({
    title: 'Delete this File?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "?c=Init&a=DeleteFile&file=" + que, true);
    xmlhttp.send();
    r.closest(".remove").remove();
    });
}

$(document).on('click', '.cancel', function(e) {
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Delete this Purchase?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=Purchases&a=PurchaseDelete", { id }).done(function( res ) {
                location.reload();
            });
        }
    })
});

$(document).on('click', '.newItem', function() {
  id = $(this).data('id');
  purchase = $(this).data('purchase');
  $.post( "?c=Purchases&a=PurchaseItemForm", { id,purchase }).done(function( data ) {
      $('#xsModal').modal('toggle');
      $('#xsModal .modal-content').html(data);
      $('.select2').select2();
  });
});
</script>