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
            <td style='width:33%'><img style='width:200px' src='assets/img/cultura.png'></td>
            <td style='width:33%'><h3></h></td>
            <td style='width:33%'><img style='width:100px' src='assets/img/cultura2.png'></td>
        </tr>
    </table>

    <div class="content">
    <div class="container-fluid row">

    <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Nombre:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->name : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Sector:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->sector : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Organismo al que pertenece:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->organization : '' ?>
                        </div>
                    </div>
                </div>

                <!--
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Tipo:</label>
                        <div class="input-group">
                            <select class="form-control" name="type">
                                <option></option>
                                <option <?php echo (isset($id) and $id->type == 'Tipo 1') ? 'selected' : ''; ?>>Tipo 1</option>
                                <option <?php echo (isset($id) and $id->type == 'Tipo 2') ? 'selected' : ''; ?>>Tipo 2</option>
                            </select>
                        </div>
                    </div>
                </div>
                -->

            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Ubicaci??n de la Entidad</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Direcci??n:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->address : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Tel??fono:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->phone : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Email:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->email : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>* Web:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->web : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>* Ubicaci??n (Municipio, Departamento):</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->location : '' ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Car??cter de la Entidad</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Tipo:</label>
                        <div class="input-group">
                        <?php echo isset($id) ? $id->type : '' ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Orien de la Entidad</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Fecha de Creaci??n:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->date : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Acto Legal:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->legal : '' ?>
                        </div>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Rese??a:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->review : '' ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Representaci??n Legal de la Entidad</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Nombre del Representante Legal:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->username : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Profesi??n:</label>
                        <div class="input-group">
                            <?php echo isset($id) ? $id->profession : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Cargo:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->position : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Tiempo en el Cargo:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->time : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Fecha en la que asumi??:</label>
                        <div class="input-group">
                          <?php echo isset($id) ? $id->positionDate : '' ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Centro de Documentaci??n</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Tipo de documentaci??n que posee:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->docType : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Condiciones de la Documentaci??n:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->docStatus : '' ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Condiciones de Consulta:</label>
                        <div class="input-group">
                           <?php echo isset($id) ? $id->docQuery : '' ?>
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
                        <?php echo isset($id) ? $id->notes : '' ?>
                    </div>
                </div>
            </div>
        </div>





</div>


<table style='text-align:center;width:90%;padding:30px 0; margin:0 5%' class="mt-4">
<br>
        <tr>
            <td class="text-left" style='width:20%;font-size:12px'>Proyecto ejecutado con recursos del Programa de Planeaci??n del Desarrollo Local y Presupuesto Participativo del corregimiento de San Antonio de Prado.</td>
            <td style='width:47%'><h3></h></td>
            <td class="text-right" style='width:33%'><img style='width:150px' src='assets/img/alcaldia.png'></td>
        </tr>
    </table>