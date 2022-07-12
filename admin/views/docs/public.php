<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Docs</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Docs</title>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

<style>
    body{
        background:#f4f6f9;
    }

     table th, table td{
        padding:10px !important;
     }
</style>

</head>



<body>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.html">Docs<span>.</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt=""></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="../#hero">Inicio</a></li>
          <li><a class="nav-link scrollto" href="../#about">Nosotros</a></li>
          <li><a class="nav-link scrollto" href="../#services">Servicios</a></li>
          <li><a class="nav-link scrollto " href="../#portfolio">Portafolio</a></li>
          <li><a class="nav-link scrollto" href="../#team">Equipo</a></li>
          <li><a class="nav-link scrollto" href="../#contact">Contacto</a></li>
          <li class="dropdown" ><a class="active" href="#"><span>Busquedas</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="?c=Docs&a=Public">Descripción Documental</a></li>
              <li><a href="#">Inventario Documental</a></li>
              <li><a href="#">Centro Documental</a></li>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row m-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Descripción Documental</h1>
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
                <h3 class="card-title"></h3>
                <div class="card-tools">

                    <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Docs&a=Public">
                        <button type="submit" class="btn btn-danger float-right"><i class="fas fa-eraser"></i></button>
                    </form>
          

                </div>
            </div>
            <div class="card-body" style="display: block;">
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Docs&a=Public" id="Filters_Form">
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