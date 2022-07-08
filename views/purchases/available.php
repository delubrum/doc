<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
            <?php if (in_array(46, $permissions)) { ?>
            <label for="excel_file" class="btn btn-success float-right ml-2" style="cursor:pointer">
                <i class="fas fa-upload"></i> Update Data
            </label>
            <input id="excel_file" name="file" type="file" style="display:none">
            <?php } ?>
                <h1 class="m-0 text-dark">Code List

                <button type="button" class="btn btn-primary float-right new">
                    <i class="fas fa-plus"></i> New
                </button>
                </h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card p-4 listTable">
        <table class="table table-head-fixed table-striped table-hover" id="example" style="width:100%">
            <thead>
            <tr>
                <th class="bg-secondary">Id</th>
                <th class="bg-secondary">Last Update</th>
                <th class="bg-secondary">Description</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($this->purchases->getAvailable() as $r) { ?>
            <tr>
                <td><?php echo $r->id ?>
                <td><?php echo $r->createdAt ?>
                <td><?php echo $r->description ?>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>
</div>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        "search": {
            "smart": false
        },
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "scrollX" : true,
        "autoWidth": false,
    });
});

$(document).on('input', '#excel_file', function(e) {
  var file_data = $('#excel_file').prop('files')[0];   
  var formData = new FormData();
  formData.append('excel_file', file_data);
  $("#loading").show();
  $.ajax({
    url: '?c=Purchases&a=ImportExcel',
    type: 'POST',
    data: formData,
    success: function (data) {
      $('#excel_file').val(''); 
      if (isNaN(data.trim())) {
      toastr.error(data.trim());
      $("#loading").hide();
      } else {
       location.reload();
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
})

$(".new").on("click", function() {
    id = $(this).data('id');
    $.post( "?c=Purchases&a=NewCode", { id }).done(function( data ) {
        $('#xsModal').modal('toggle');
        $('#xsModal .modal-content').html(data);
    });
});

$(document).on('submit', '#purchaseNewCode_form', function(e) {
    e.preventDefault();
    if (document.getElementById("purchaseNewCode_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Purchases&a=CodeSave", $( "#purchaseNewCode_form" ).serialize()).done(function() {
            location.reload();
        });
    }
});
</script>