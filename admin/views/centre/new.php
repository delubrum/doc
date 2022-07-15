<form method="post" id="Centre_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Documento</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Identificación de la Entidad</h3>
            </div>
            <div class="card-body row">


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Nombre:</label>
                        <div class="input-group">
                            <input class="form-control" name="name" value="<?php echo isset($id) ? $id->name : '' ?>" required>
                            <input type="hidden" name="id" value="<?php echo isset($id) ? $id->id : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Sector:</label>
                        <div class="input-group">
                            <input class="form-control" name="sector" value="<?php echo isset($id) ? $id->sector : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Organismo al que pertenece:</label>
                        <div class="input-group">
                            <input class="form-control" name="organization" value="<?php echo isset($id) ? $id->organization : '' ?>" required>
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
                <h3 class="card-title">Ubicación de la Entidad</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Dirección:</label>
                        <div class="input-group">
                            <input class="form-control" name="address" value="<?php echo isset($id) ? $id->address : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Teléfono:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="phone" value="<?php echo isset($id) ? $id->phone : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Email:</label>
                        <div class="input-group">
                            <input class="form-control" name="email" value="<?php echo isset($id) ? $id->email : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>* Web:</label>
                        <div class="input-group">
                            <input class="form-control" name="web" value="<?php echo isset($id) ? $id->web : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>* Ubicación (Municipio, Departamento):</label>
                        <div class="input-group">
                            <input class="form-control" name="location" value="<?php echo isset($id) ? $id->location : '' ?>" required>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Carácter de la Entidad</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Tipo:</label>
                        <div class="input-group">
                            <select class="form-control" name="type">
                                <option></option>
                                <option <?php echo (isset($id) and $id->type == 'Pública') ? 'selected' : ''; ?>>Pública</option>
                                <option <?php echo (isset($id) and $id->type == 'Privada') ? 'selected' : ''; ?>>Privada</option>
                                <option <?php echo (isset($id) and $id->type == 'Mixta') ? 'selected' : ''; ?>>Mixta</option>
                                <option <?php echo (isset($id) and $id->type == 'Privada / Funciones Públicas') ? 'selected' : ''; ?>>Privada / Funciones Públicas</option>
                                <option <?php echo (isset($id) and $id->type == 'Privada Interés Cultural') ? 'selected' : ''; ?>>Privada Interés Cultural</option>
                                <option <?php echo (isset($id) and $id->type == 'Familiar') ? 'selected' : ''; ?>>Familiar</option>
                                <option <?php echo (isset($id) and $id->type == 'Personal') ? 'selected' : ''; ?>>Personal</option>
                                <option <?php echo (isset($id) and $id->type == 'Otra') ? 'selected' : ''; ?>>Otra</option>
                            </select>
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
                        <label>* Fecha de Creación:</label>
                        <div class="input-group">
                            <input class="form-control" name="date" value="<?php echo isset($id) ? $id->date : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Acto Legal:</label>
                        <div class="input-group">
                            <input class="form-control" name="legal" value="<?php echo isset($id) ? $id->legal : '' ?>">
                        </div>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Reseña:</label>
                        <div class="input-group">
                            <input class="form-control" name="review" value="<?php echo isset($id) ? $id->review : '' ?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Representación Legal de la Entidad</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Nombre del Representante Legal:</label>
                        <div class="input-group">
                            <input class="form-control" name="username" value="<?php echo isset($id) ? $id->username : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Profesión:</label>
                        <div class="input-group">
                            <input class="form-control" name="profession" value="<?php echo isset($id) ? $id->profession : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Cargo:</label>
                        <div class="input-group">
                            <input class="form-control" name="position" value="<?php echo isset($id) ? $id->position : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Tiempo en el Cargo:</label>
                        <div class="input-group">
                            <input class="form-control" name="time" value="<?php echo isset($id) ? $id->time : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Fecha en la que asumió:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="positionDate" value="<?php echo isset($id) ? $id->positionDate : '' ?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Centro de Documentación</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Tipo de documentación que posee:</label>
                        <div class="input-group">
                            <input class="form-control" name="docType" value="<?php echo isset($id) ? $id->docType : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Condiciones de la Documentación:</label>
                        <div class="input-group">
                            <input class="form-control" name="docStatus" value="<?php echo isset($id) ? $id->docStatus : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Condiciones de Consulta:</label>
                        <div class="input-group">
                            <input class="form-control" name="docQuery" value="<?php echo isset($id) ? $id->docQuery : '' ?>">
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
                        <textarea class="form-control" name="notes"><?php echo isset($id) ? $id->notes : '' ?></textarea>
                    </div>
                </div>
            </div>
        </div>





    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>

<script>
$('.select2_tags').select2({tags:true,<?php echo isset($id) ? "data: " . $id->keywords : '' ?>});
<?php if(isset($id)) { ?>
$('.select2_tags').val(<?php echo $id->keywords ?>).trigger('change')
<?php } ?>
</script>