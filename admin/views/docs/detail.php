<header>
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Doc</title>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
</header>

<style>

    @media print {    
        .noprint {
            display: none !important;
        }
        * {
        font-size:12px;
        }
    }
</style>

<div class="row p-4">

    <div class="col-12">
        <button type="button" class="btn btn-primary printBtn float-right noprint m-1" onclick="window.print();return false;"><i class="fas fa-print"></i></button>

    <table style='text-align:center;width:100%;padding:0' class="mb-4">
        <tr>
            <td style='width:33%'><img style='width:100px' src='assets/img/logo.png'></td>
            <td style='width:33%'><h3>ENCABEZADO</h></td>
            <td style='width:33%'><img style='width:100px' src='assets/img/logo.png'></td>
        </tr>
    </table>

    <div class="content">
    <div class="container-fluid">

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Área de Identificación</h3>
    </div>
    <div class="card-body row">
        <div class="col-sm-6">
                <label>Título:</label>
                <div class="input-group">
                    <?php echo $id->title ?>
                </div>
        </div>
        <div class="col-sm-6">
                <label>Tipo:</label>
                <div class="input-group">
                    <?php echo $id->type ?>
                </div>
        </div>
    </div>
</div>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Ubicación</h3>
    </div>
    <div class="card-body row">

        <div class="col-sm-3">
                <label>Código de referencia:</label>
                <div class="input-group">
                    <?php echo $id->code ?>
                </div>
        </div>

        <div class="col-sm-3">
            <label>Fecha:</label>
            <div class="input-group">
                <?php echo $id->date ?>
            </div>
        </div>

        <div class="col-sm-3">
            <label>Ubicación:</label>
            <div class="input-group">
                <?php echo $id->location ?>
            </div>
        </div>

        <div class="col-sm-3">
            <label>Páginas / Folios:</label>
            <div class="input-group">
                <?php echo $id->pages ?>
            </div>
        </div>

    </div>
</div>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Área de Contexto</h3>
    </div>
    <div class="card-body row">

        <div class="col-sm-6">
            <label>Centro de Documentación:</label>
            <div class="input-group">
            <?php echo $id->docCenter ?>
            </div>
        </div>

        <div class="col-sm-6">
            <label>Reseña Institucional:</label>
            <div class="input-group">
                <?php echo $id->review ?>
            </div>
        </div>

    </div>
</div>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Área de Contenido</h3>
    </div>
    <div class="card-body row">

        <div class="col-sm-4">
            <div class="form-group">
                <label>Tema:</label>
                <div class="input-group">
                <?php echo $id->subject ?>
                </div>
            </div>
        </div>


        <div class="col-sm-4">
            <div class="form-group">
                <label>Descripción / Resumen:</label>
                <div class="input-group">
                <?php echo $id->description ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>Palabras Clave:</label>
                <div class="input-group">
                <?php foreach(json_decode($id->keywords) as $p) { echo $p . ", "; } ?>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Área de Condiciones de Acceso y Utilización</h3>
    </div>
    <div class="card-body row">

        <div class="col-sm-4">
            <div class="form-group">
                <label>Idioma / Lengua:</label>
                <div class="input-group">
                    <?php echo $id->lang ?>
                </div>
            </div>
        </div>


        <div class="col-sm-4">
            <div class="form-group">
                <label>Condiciones de Acceso:</label>
                <div class="input-group">
                <?php echo $id->access ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>Condiciones de Reproducción:</label>
                <div class="input-group">
                <?php echo $id->reproduce ?>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Observaciones</h3>
    </div>
    <div class="card-body row">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="input-group">
            <?php echo $id->notes ?>
            </div>
        </div>
    </div>
</div>





</div>