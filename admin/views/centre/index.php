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
                <h1 class="m-0 text-dark">Centros de Documentación</h1>
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

                    <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Centre&a=Index">
                        <button type="submit" class="btn btn-danger float-right"><i class="fas fa-eraser"></i></button>
                    </form>
          

                </div>
            </div>
            <div class="card-body" style="display: block;">
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Centre&a=Index" id="Filters_Form">
                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <div class="input-group">
                                    <input class="form-control" name="name" value="<?php echo !empty($_POST) ? $_POST['name'] : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Dirección:</label>
                                <div class="input-group">
                                    <input class="form-control" name="address" value="<?php echo !empty($_POST) ? $_POST['address'] : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Teléfono:</label>
                                <div class="input-group">
                                    <input class="form-control" name="phone" value="<?php echo !empty($_POST) ? $_POST['phone'] : '' ?>">
                                </div>
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
        "autoWidth": false,
        "columns": [
            null,
            null,
            null,
            { "width": "12%" },
        ]
    });

    $('.select2_Indextags').select2({tags:true,<?php echo !empty($_POST['keywords']) ? "data: " . json_encode($_POST['keywords']) : '' ?>});
    <?php if(!empty($_POST['keywords'])) { ?>
    $('.select2_Indextags').val(<?php echo json_encode($_POST['keywords']) ?>).trigger('change')
    <?php } ?>
});

$(".new").on("click", function() {
    id = $(this).data('id');
    $.post( "?c=Centre&a=New", { id }).done(function( data ) {
        $('#xlModal').modal('toggle');
        $('#xlModal .modal-content').html(data);
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

$(document).on('submit', '#Centre_Form', function(e) {
    e.preventDefault();
    if (document.getElementById("Centre_Form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Centre&a=Save", $("#Centre_Form").serialize()).done(function(res) {
            location.reload();
        });
    }
});
</script>