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
                    <i class="fas fa-plus"></i> Nuevo
                </button>
                <h1 class="m-0 text-dark">Docs</h1>
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
                <h3 class="card-title">Filtros</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" style="margin-top:0px;">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=WorkOrders&a=Index">
                    <div class="row">
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Id:</label>
                                <div class="input-group">
                                    <input class="form-control" name="id">
                                    <input type="hidden" name="filters" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Creador:</label>
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
                                        <option>Processing</option>
                                        <option>Checking</option>
                                        <option>Approval</option>
                                        <option>Production</option>
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

                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
        </div>
        <?php // if($filters) { ?>     
        <div class="card p-4 listTable">
            <?php require_once 'list.php' ?>        
        </div>
        <?php // } ?>   
    </div>
</div>
</div>
</div>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "scrollX" : true,
        "autoWidth": false
    });
});

$(".new").on("click", function() {
    id = $(this).data('id');
    $.post( "?c=Docs&a=New", { id }).done(function( data ) {
        $('#xlModal').modal('toggle');
        $('#xlModal .modal-content').html(data);
    });
});
</script>