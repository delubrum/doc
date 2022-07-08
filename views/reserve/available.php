<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
            <?php if (in_array(40, $permissions)) { ?>
            <label for="excel_file" class="btn btn-success float-right ml-2" style="cursor:pointer">
                <i class="fas fa-upload"></i> Update Data
            </label>
            <input id="excel_file" name="file" type="file" style="display:none">
            <?php } ?>
                <h1 class="m-0 text-dark">Available</h1>
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
                <th class="bg-secondary">Project</th>
                <th class="bg-secondary">Store</th>
                <th class="bg-secondary">Qty</th>
                <th class="bg-secondary">Price (Unit)</th>
                <th class="bg-secondary">Price (Total)</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($this->reserve->getAvailable() as $r) { 
                $partial = $this->reserve->getQty($r->id,$r->createdAt,$r->project,$r->store)->total;
                $op = $r->qty - $partial;
                if ($op != 0) {
                ?>
            <tr>
                <td><?php echo $r->id ?>
                <td><?php echo $r->createdAt ?>
                <td><?php echo $r->description ?>
                <td><?php echo $r->project ?>
                <td><?php echo $r->store ?>
                <td><?php echo $r->qty - $partial ?>
                <td><?php echo number_format($r->price,2) ?>
                <td><?php echo number_format($r->price*$r->qty,2) ?>

            </tr>
            <?php }} ?>
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
    url: '?c=Reserve&a=ImportExcel',
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
</script>