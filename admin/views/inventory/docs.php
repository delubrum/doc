
<header>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="WO_form" data-status="<?php echo $status ?>">
  <div class="modal-header">
  <h5 class="modal-title"><?php echo $title ?> : <b><?php echo $id->designation . " / " . $id->projectname ?></b></h5>
  <input type="hidden" name="id" value="<?php echo $id->id ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">

    <?php require_once "info.php" ?>

    <?php if ($status == 'process') { ?>

      <button type="button" class="btn btn-danger float-right deleteAll mb-4 ml-2" data-wo="<?php echo $id->id ?>">
        <i class="fas fa-trash"></i> Delete All Items
      </button>

      <label for="excel_file" class="btn btn-success float-right ml-2" style="cursor:pointer">
        <i class="fas fa-upload"></i> Import Excel
      </label>
      <input id="excel_file" name="file" type="file" style="display:none">
      <button type="button" class="btn btn-primary float-right newItem mb-4" data-wo="<?php echo $id->id ?>">
        <i class="fas fa-plus"></i> Add Item
      </button>
    <?php } ?>

    <div class="card-body table-responsive p-0" style="height: 300px;">
      <?php $this->ItemList($id->id) ?>
    </div>

    <br>

  </div>
  <div class="modal-footer">
  <?php if ($status == 'process') { ?> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".processModal"> Upload</button> <?php } ?>
  <?php if ($status == 'process') { ?> <button type="button" class="btn btn-danger cancel" data-id="<?php echo $id->id ?>">Delete</button> <?php } ?>
  <?php if ($status == 'confirm') { ?> <button type="submit" class="btn btn-primary">Send</button> <?php } ?>
  <?php if ($status == 'confirm') { ?> <button type="button" data-id="<?php echo $id->id ?>" class="btn btn-danger modify">Modify</button> <?php } ?>

  <?php if ($status == 'send') { ?> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".emailModal"> Send</button> <?php } ?>
  <?php if ($status == 'send') { ?> <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".rejectCause"> Reject</button> <?php } ?>

  </div>


  <?php if ($status == 'process') { ?> 
<div class="modal fade processModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
            <input type="hidden" name="id" value="<?php echo $id->id ?>">
              <div class="modal-header">
                  <h5 class="modal-title">Upload Work Order Files</b></h5>
                  <button type="button" class="close modal2" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-6">
                    <h4> New Files</h4>
                    <div class="form-group">
                        <label>Other Documents (.zip):</label>
                        <div class="input-group">
                        <input type=file name="other" accept=".zip">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>DXF (.dxf Multiple):</label>
                        <div class="input-group">
                        <input type=file name="DXF[]" multiple accept=".dxf">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>PDF (.zip):</label>
                        <div class="input-group">
                        <input type=file name="PDF" accept=".zip" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>STP (.zip):</label>
                        <div class="input-group">
                        <input type=file name="STP" accept=".zip">
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <h4>Old Files</h4>

                    <?php $directorio = "uploads/workOrders/other/$id->id/";
                      if ((count(glob("$directorio/*")) != 0)) { ?>
                      <b>Other Documents:</b>
                      <br>
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

                    <?php $directorio = "uploads/workOrders/DXF/$id->id/";
                      if ((count(glob("$directorio/*")) != 0)) { ?>
                      <b>DXF:</b>

                      <button class="btn btn-danger m-1" onClick="DeleteFolder('<?php echo $directorio ?>');">Delete All DXF</button>



                      <br>
                      <div id="DXFiles">
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
                      </div>
                    <?php } ?>
                    

                    <?php $directorio = "uploads/workOrders/PDF/$id->id/";
                      if ((count(glob("$directorio/*")) != 0)) { ?>
                      <b>PDF:</b>
                      <br>
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

                    <?php $directorio = "uploads/workOrders/STP/$id->id/";
                      if ((count(glob("$directorio/*")) != 0)) { ?>
                      <b>STP:</b>
                      <br>
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
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Send</button>
              </div>
      </div>
  </div>
</div>
<?php } ?> 


<?php if ($status == 'send') { ?> 
<div class="modal fade emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
            <input type="hidden" name="id" value="<?php echo $id->id ?>">
              <div class="modal-header">
                  <h5 class="modal-title">Email Work Order</b></h5>
                  <button type="button" class="close modal3" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* To:</label>
                        <div class="input-group">
                          <select name='to[]' style="width:100%" class="select2" multiple="multiple" required>
                            <option value=''></option>
                            <?php
                            foreach($this->users->usersList() as $r) { ?>
                              <option value='<?php echo $r->email?>'><?php echo $r->email?></option>
                            <?php } ?>
                          </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Subject:</label>
                        <div class="input-group">
                          <input name='subject' style="width:100%" value="<?php echo $id->designation ." - " . $id->projectname ?>" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Body:</label>
                        <div class="input-group">
                          <textarea name="body" required style="width:100% !important;min-height:200px"></textarea>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Send</button>
              </div>
      </div>
  </div>
</div>
<?php } ?> 


</form>






<div class="modal fade rejectCause" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <form method="post" id="reject_form">
              <div class="modal-header">
                  <h5 class="modal-title">Reject Cause</b></h5>
                  <button type="button" class="close modal4" aria-label="Close">
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
                              <input type="hidden" name="type" value="wo">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">Reject</button>
              </div>
          </form>
      </div>
  </div>
</div>

<script>

$(document).on('click', '.modal2', function() {
    $('.processModal').modal('hide');
});

$(document).on('click', '.modal3', function() {
    $('.emailModal').modal('hide');
});

$(document).on('click', '.modal4', function() {
    $('.rejectCause').modal('hide');
});

$(document).on('input', '#excel_file', function() {
  var file_data = $('#excel_file').prop('files')[0];   
  var formData = new FormData();
  formData.append('excel_file', file_data);
  formData.append('id', '<?php echo $id->id ?>');
  $("#loading").show();
  $.ajax({
    url: '?c=WorkOrders&a=ImportExcel',
    type: 'POST',
    data: formData,
    success: function (data) {
      $('#excel_file').val(''); 
      if (isNaN(data.trim())) {
      toastr.error(data.trim());
      $("#loading").hide();
      } else {
        $("#loading").hide();
        $("#itemsTable").load("?c=WorkOrders&a=ItemList&status=process&id=" + data.trim());
        $('#woItem_form').trigger("reset");
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
})

<?php if ($status == 'process') {  ?>
$(document).on('click', '.newItem', function() {
  id = $(this).data('id');
  wo = $(this).data('wo');
  $.post( "?c=WorkOrders&a=NewItem", { id,wo }).done(function( data ) {
      $('#lgModal').modal('toggle');
      $('#lgModal .modal-content').html(data);
  });
});
<?php } ?>

$(".modify").on("click", function(e) {
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Modify this Work Order?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=WorkOrders&a=Modify", { id }).done(function( res ) {
              location.reload();
            });
        }
    })
});

$(".cancel").on("click", function(e) {
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Delete this Work Order?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=WorkOrders&a=Delete", { id }).done(function( res ) {
                location.reload();
            });
        }
    })
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

function DeleteFolder(que) {
  event.preventDefault();
  Swal.fire({
    title: 'Delete All DXF?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "?c=Init&a=DeleteFolder&folder=" + que, true);
    xmlhttp.send();
    $("#DXFiles").html('');
    });
}


$(document).on("click", ".deleteAll", function(e) {
    wo = $(this).data("wo");
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
            $.post("?c=WorkOrders&a=ItemDeleteAll",{wo}).done(function(res) {
                $("#itemsTable").load("?c=WorkOrders&a=ItemList&status=process&id=" + res.trim());
                $("#loading").hide();
            });
        }
    })
});
</script>