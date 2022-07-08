<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
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
                <h1 class="m-0 text-dark">Reservations</h1>
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
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Reserve&a=Index">
                    <div class="row">

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Id:</label>
                                <div class="input-group">
                                    <input class="form-control" name="id">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Material Id:</label>
                                <div class="input-group">
                                    <input class="form-control" name="materialId">
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-2">
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

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Status:</label>
                                <div class="input-group">
                                    <select class="form-control" name="status">
                                    <option></option>
                                    <option value="Approving">Approving</option>
                                    <option value="Receiving">Receiving</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Cancelled">Cancelled</option>
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
            <?php require_once 'list.php' ?>        
        </div>
    </div>
</div>
</div>
</div>

<script>
$('.select2').select2();

$(document).ready(function() {
    var table = $('#example').DataTable({
        "search": {
            "smart": false
        },
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "scrollX" : true,
        "autoWidth": false
    });
});

$(".new").on("click", function() {
    id = $(this).data('id');
    $.post( "?c=Reserve&a=New", { id }).done(function( data ) {
        $('#xlModal').modal('toggle');
        $('#xlModal .modal-content').html(data);
    });
});

$(document).on('click', '.reserve', function(e) {
    id = $(this).data('id');
    $("#loading").show();
    $.post( "?c=Reserve&a=Reserve", { id }).done(function( data ) {
        $("#loading").hide();
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});

$(document).on('input', '.reserveQty', function(e) {
    var sum = 0;
    $('.reserveQty').each(function(){
        sum += parseFloat(this.value);
    });
    $('#total').html(sum);
});

$(document).on('click', '#approve', function(e) {
    id = $(this).data('id');
    $('.approve input[name="id"]').val(id);
});

$(document).on('click', '#reject', function(e) {
    id = $(this).data('id');
    $('.reject input[name="id"]').val(id);
});

$(document).on('click', '#receive', function(e) {
    id = $(this).data('id');
    $('.receive input[name="id"]').val(id);
});
</script>