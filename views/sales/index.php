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
                    <i class="fas fa-plus"></i> Nueva
                </button>
                <h1 class="m-0 text-dark">Ventas</h1>
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

                    <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Sales&a=Index">
                        <button type="submit" class="btn btn-danger float-right"><i class="fas fa-eraser"></i></button>
                    </form>
          

                </div>
            </div>
            <div class="card-body" style="display: block;">
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Sales&a=Index" id="Filters_Form">
                    <div class="row">

                    <div class="col-sm-6">
                            <div class="form-group">
                                <label>Desde:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="from" value="<?php echo !empty($_POST) ? $_POST['from'] : $firstday ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Hasta:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="to" value="<?php echo !empty($_POST) ? $_POST['to'] : $lastday ?>">
                                </div>
                            </div>
                        </div>


                    </div>
                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
        </div>

        <h3>TOTAL: <span class="text-primary">$ <?php $suma = 0; foreach($this->sales->list($filters) as $r) { 
            $suma += $r->cash;
        }
        echo $suma;
        ?></span></h3>   



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
$(document).on('click', '.new', function(e) {
    e.stopImmediatePropagation();
    id = $(this).data('id');
    $.post( "?c=Sales&a=New", { id }).done(function( data ) {
        $('#xlModal').modal('toggle');
        $('#xlModal .modal-content').html(data);
        setTimeout(function() { $('#product_search').focus() }, 200);
    });
});

$(document).on('click', '.refund', function(e) {
    e.stopImmediatePropagation();
    id = $(this).data('id');
    $.post( "?c=Sales&a=Refund", { id }).done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});

$(document).ready(function() {
    var table = $('#example').DataTable({
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "scrollX" : true,
        "autoWidth": false
    });
});


$(document).on('submit', '#Filters_Form', function(e) {
    var isValid = 0;
    $("input").each(function() {
    if ($(this).val()) {
        isValid++;
    }
    });
    $("select").each(function() {
    if ($.trim($(this).val()) != '') {
        isValid++;
    }
    });
    if(isValid == 0){
        toastr.error("No ingresaste filtros");
        e.preventDefault();
        return true;
    }
    $("#loading").show();
});

$(document).on('submit', '#Sales_Form', function(e) {
    e.preventDefault();
    if (document.getElementById("Sales_Form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Sales&a=Save", $("#Sales_Form").serialize()).done(function(res) {
            location.reload();
        });
    }
});

$(document).on('submit', '#Refund_Form', function(e) {
    e.preventDefault();
    if (document.getElementById("Refund_Form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Sales&a=RefundSave", $("#Refund_Form").serialize()).done(function(res) {
            location.reload();
        });
    }
});

</script>