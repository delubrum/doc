<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="assets/plugins/moment/moment.min.js"></script>
    <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary float-right new">
                    <i class="fas fa-plus"></i> New
                </button>
                <h1 class="m-0 text-dark">Purchasing</h1>
                
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Filters</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" style="margin-top:0px;">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Purchases&a=Index">
                    <div class="row">
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Id:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="id">
                                    <input type="hidden" name="filters" value="1">

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Created By:</label>
                                <div class="input-group">
                                <select class="form-control select2" name="userId" style="width: 100%;">
                    <option value=''></option>
                    <?php foreach($this->users->usersList() as $r) { ?>
                        <option value='<?php echo $r->id?>'><?php echo $r->username?></option>
                    <?php } ?>
                </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Project:</label>
                                <div class="input-group">
                                <select class="form-control select2" name="projectId" style="width: 100%;">
                                    <option value=''></option>
                                    <?php foreach($this->projects->list('and closedAt is null') as $r) { ?>
                                        <option value='<?php echo $r->id?>'><?php echo $r->name?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Status:</label>
                                <div class="input-group">
                                    <select class="form-control" name="status">
                                    <option></option>
                                    <option>Processing</option>
                                    <option>Pricing</option>
                                    <option>PM Approval</option>
                                    <option>CEO Approval</option>
                                    <option>Purchasing</option>
                                    <option>Receiving</option>
                                    <option>Closed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>From:</label>
                                <input type="date" class="form-control date" name="from">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>To:</label>
                                <input type="date" class="form-control date" name="to">
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
        </div>
        <div class="card p-4 listTable">
            <?php require_once 'list_row.php' ?>        
        </div>
    </div>
</div>
</div>
</div>

<script>
$('.select2').select2()

$(document).on('submit', '#purchaseNew_form', function(e) {
    e.preventDefault();
    if (document.getElementById("purchaseNew_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Purchases&a=PurchaseSave", $( "#purchaseNew_form" ).serialize()).done(function( res ) {
            var res = $.parseJSON(res);
            id = res.id;
            status = res.status;
            title = res.title;
            $.post( "?c=Purchases&a=Purchase", {id,status,title}).done(function( data ) {
                $('#xsModal').modal('toggle');
                $("#loading").hide();
                $('#xlModal').modal('toggle');
                $('#xlModal .modal-content').html(data);
                $( "#example" ).load(window.location.href + " #example" );                
            });
        });
    }
});

$(document).ready(function() {
    $('#example').DataTable({
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "scrollX": true,
        "autoWidth": false
    });
});

$(".new").on("click", function() {
    id = $(this).data('id');
    $.post( "?c=Purchases&a=New", { id }).done(function( data ) {
        $('#xsModal').modal('toggle');
        $('#xsModal .modal-content').html(data);
    });
});
</script>