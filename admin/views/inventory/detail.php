<head>
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Doc</title>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
</head>

<style>

    @media print {    
        .noprint {
            display: none !important;
        }
        {
        font-size:12px;
        }
    }
</style>

<div class="row p-4">

    <div class="col-12">
        <button type="button" class="btn btn-primary printBtn float-right noprint m-1" onclick="window.print();return false;"><i class="fas fa-print"></i></button>

        <table style='text-align:center;width:100%;padding:0' class="mb-4">
        <tr>
            <td style='width:33%'><img style='width:200px' src='assets/img/cultura.png'></td>
            <td style='width:33%'><h3></h></td>
            <td style='width:33%'><img style='width:100px' src='assets/img/cultura2.png'></td>
        </tr>
    </table>

    <div class="content">
        <div class="container-fluid row">

            <div class="col-sm-4">
                <label>Autor(es):</label>
                <div class="input-group">
                    <?php echo isset($id) ? $id->author : '' ?>
                </div>
            </div>

            <div class="col-sm-4">
                <label>Título:</label>
                <div class="input-group">
                    <?php echo isset($id) ? $id->title : '' ?>
                </div>
            </div>

            <div class="col-sm-4">
                <label>Nombre Publicación Seriada:</label>
                <div class="input-group">
                    <?php echo isset($id) ? $id->name : '' ?>
                </div>
            </div>

                <div class="col-sm-4">
                        <label>Editores o compiladores:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->publisher : '' ?>
                        </div>
                </div>

                <div class="col-sm-4">
                        <label>Ciudad: Editorial:</label>
                        <div class="input-group">
                          <?php echo isset($id) ? $id->city : '' ?>
                        </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Número Publicación Seriada:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->num : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Año de Publicación:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->year : '' ?>
                        </div>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Páginas:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->pages : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Formato:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->format : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Cantidad:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->qty : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Localización:</label>
                        <div class="input-group">
                        <?php echo isset($id) ? $id->location : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Tema:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->subject : '' ?>
                        </div>
                    </div>
                </div>

                <div class="card card-info col-12">
                    <div class="card-header">
                        <h3 class="card-title">Ubicación 1</h3>
                    </div>
                    <div class="card-body row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Sede:</label>
                                <div class="input-group">
                                   <?php echo isset($id) ? $id->site1 : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Signatura:</label>
                                <div class="input-group">
                                    <?php echo isset($id) ? $id->signature1 : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-info col-12">
                    <div class="card-header">
                        <h3 class="card-title">Ubicación 2</h3>
                    </div>
                    <div class="card-body row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Sede:</label>
                                <div class="input-group">
                                    <?php echo isset($id) ? $id->site2 : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Signatura:</label>
                                <div class="input-group">
                                    <?php echo isset($id) ? $id->signature2 : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-info col-12">
                    <div class="card-header">
                        <h3 class="card-title">Ubicación 3</h3>
                    </div>
                    <div class="card-body row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Sede:</label>
                                <div class="input-group">
                                   <?php echo isset($id) ? $id->site3 : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Signatura:</label>
                                <div class="input-group">
                                    <?php echo isset($id) ? $id->signature3 : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
            <div class="form-group">
                <label>Palabras Clave:</label>
                <div class="input-group">
                <?php if (!empty($id->keywords)) { foreach(json_decode($id->keywords) as $p) { echo $p . ", "; } } ?>
                </div>
            </div>
        </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Fondo:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->fondo : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Rollo:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->roll : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Folios:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->foil : '' ?>
                        </div>
                    </div>
                </div>

                <div class="card card-info col-12">
    <div class="card-header">
        <h3 class="card-title">Observaciones</h3>
    </div>
    <div class="card-body row">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="input-group text-justify">
            <?php echo $id->notes ?>
            </div>
        </div>
    </div>
</div>

        </div>



</div>


<table style='text-align:center;width:90%;padding:30px 0; margin:0 5%' class="mt-4">
<br>
        <tr>
            <td class="text-left" style='width:20%;font-size:12px'>Proyecto ejecutado con recursos del Programa de Planeación del Desarrollo Local y Presupuesto Participativo del corregimiento de San Antonio de Prado.</td>
            <td style='width:47%'><h3></h></td>
            <td class="text-right" style='width:33%'><img style='width:150px' src='assets/img/alcaldia.png'></td>
        </tr>
    </table>