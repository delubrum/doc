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

                    <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Docs&a=Index">
                        <button type="submit" class="btn btn-danger float-right"><i class="fas fa-eraser"></i></button>
                    </form>
          

                </div>
            </div>
            <div class="card-body" style="display: block;">
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Docs&a=Index" id="Filters_Form">
                    <div class="row">

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Código:</label>
                                <div class="input-group">
                                    <input class="form-control" name="code" value="<?php echo !empty($_POST) ? $_POST['code'] : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Titulo:</label>
                                <div class="input-group">
                                    <input class="form-control" name="title" value="<?php echo !empty($_POST) ? $_POST['title'] : '' ?>" minlength="3">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Ubicación:</label>
                                <div class="input-group">
                                    <input class="form-control" name="location" value="<?php echo !empty($_POST) ? $_POST['location'] : '' ?>" minlength="3">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Páginas:</label>
                                <div class="input-group">
                                    <input type="number" step="1" class="form-control" name="pages" value="<?php echo !empty($_POST) ? $_POST['pages'] : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>* Idioma:</label>
                                <div class="input-group">
                                    <select class="form-control" name="lang" >
                                        <option></option>
                                        <option <?php echo (!empty($_POST) and $_POST['lang'] == 'Español') ? 'selected' : ''; ?>>Español</option>
                                        <option <?php echo (!empty($_POST) and $_POST['lang'] == 'Inglés') ? 'selected' : ''; ?>>Inglés</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Desde:</label>
                                <input type="date" class="form-control date" name="from" value="<?php echo !empty($_POST) ? $_POST['from'] : '' ?>">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Hasta:</label>
                                <input type="date" class="form-control date" name="to" value="<?php echo !empty($_POST) ? $_POST['to'] : '' ?>">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Palabras Clave:</label>
                                <div class="input-group">
                                    <select class="form-control select2_Indextags" style="width:100%" name="keywords[]" multiple="multiple">
                                    <option></option>
                                    </select>
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
            null,
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
    $.post( "?c=Docs&a=New", { id }).done(function( data ) {
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
</script>