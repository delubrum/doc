
<header>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="BOM_form" data-status="<?php echo $status ?>">
  <div class="modal-header">
  <h5 class="modal-title"><?php echo $title ?> : <b><?php echo $id->code . " / " . $id->projectname ?></b></h5>
  <input type="hidden" name="id" value="<?php echo $id->id ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">

    <?php require_once "info.php" ?>

    <?php if ($status == 'process') { ?>

      <button type="button" class="btn btn-danger float-right deleteAll mb-4 ml-2" data-bom="<?php echo $id->id ?>">
        <i class="fas fa-trash"></i> Delete All Items
      </button>

    <label for="excel_file" class="btn btn-success float-right ml-2" style="cursor:pointer">
      <i class="fas fa-upload"></i> Import Excel
    </label>
    <input id="excel_file" name="file" type="file" style="display:none">
    <button type="button" class="btn btn-primary float-right newItem mb-4" data-bom="<?php echo $id->id ?>">
      <i class="fas fa-plus"></i> Add Item
    </button>

    <?php } ?>

    <div class="card-body table-responsive p-0" style="height: 300px;">
      <?php $this->ItemList($id->id) ?>
    </div>

  </div>
  <div class="modal-footer">
  <?php if ($status == 'process') { ?> <button type="submit" class="btn btn-primary">Send</button> <?php } ?>
  <?php if ($status == 'process') { ?> <button type="button" class="btn btn-danger cancel" data-id="<?php echo $id->id ?>">Delete</button> <?php } ?>

  <?php if ($status == 'confirm') { ?> <button type="submit" class="btn btn-primary">Store</button> <?php } ?>
  <?php if ($status == 'send') { ?> <button type="submit" class="btn btn-primary">Send</button> <?php } ?>
  <?php if ($status == 'confirm') { ?> <button type="button" class="btn btn-danger rejectBtn"> Reject</button> <?php } ?>
  </div>
</form>


<div class="modal fade rejectCause" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <form method="post" id="reject_form">
              <div class="modal-header">
                  <h5 class="modal-title">Reject Cause</b></h5>
                  <button type="button" class="close modal2" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>* Reject Cause:</label>
                          <div class="input-group">
                              <textarea type="text" class="form-control form-control-sm" name="cause"></textarea>
                              <input type="hidden" name="id" value="<?php echo $id->id ?>">
                              <input type="hidden" name="type" value="bom">
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
$(".modal2").click(function(){
    $('.rejectCause').modal('hide');
});

$(document).on('input', '#excel_file', function() {
  var file_data = $('#excel_file').prop('files')[0];   
  var formData = new FormData();
  formData.append('excel_file', file_data);
  formData.append('id', '<?php echo $id->id ?>');
  $("#loading").show();
  $.ajax({
    url: '?c=BOM&a=ImportExcel',
    type: 'POST',
    data: formData,
    success: function (data) {
      $('#excel_file').val(''); 
      if (isNaN(data.trim())) {
      toastr.error(data.trim());
      $("#loading").hide();
      } else {
        $("#loading").hide();
        $("#itemsTable").load("?c=BOM&a=ItemList&status=process&id=" + data.trim());
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
})


$(document).on('click', '.rejectBtn', function() {
  var partial = 0;
      $('.partial').each(function() {
        partial += parseFloat($(this).html());
      });
      if (partial > 0) {
        toastr.error('Items delivered');
      } else {
        $('.rejectCause').modal('show')
      }
});

<?php if ($status == 'process') {  ?>
$(document).on('click', '.newItem', function() {
  id = $(this).data('id');
  bom = $(this).data('bom');
  $.post( "?c=BOM&a=NewItem", { id,bom }).done(function( data ) {
      $('#lgModal').modal('toggle');
      $('#lgModal .modal-content').html(data);
  });
});
<?php } ?>


$(document).on('click', '.cancel', function(e) {
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Delete this Bill of Material?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=BOM&a=Delete", { id }).done(function( res ) {
                location.reload();
            });
        }
    })
});


$(document).on("click", ".deleteAll", function(e) {
    bom = $(this).data("bom");
    e.preventDefault();
    Swal.fire({
        title: 'Delete All items?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=BOM&a=ItemDeleteAll",{bom}).done(function(res) {
                $("#itemsTable").load("?c=BOM&a=ItemList&status=process&id=" + res.trim());
                $("#loading").hide();
            });
        }
    })
});
</script>