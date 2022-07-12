<form method="post" id="New_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Documento</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Área de Identificación</h3>
            </div>
            <div class="card-body row">


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Título:</label>
                        <div class="input-group">
                            <input class="form-control" name="title" value="<?php echo isset($id) ? $id->title : '' ?>" required>
                            <input type="hidden" name="id" value="<?php echo isset($id) ? $id->id : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Autor:</label>
                        <div class="input-group">
                            <input class="form-control" name="author" value="<?php echo isset($id) ? $id->author : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Tipo:</label>
                        <div class="input-group">
                            <input class="form-control" name="type" value="<?php echo isset($id) ? $id->type : '' ?>" required>
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
                <h3 class="card-title">Ubicación</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Código del Centro de Documentación:</label>
                        <div class="input-group">
                            <input class="form-control" name="code" value="<?php echo isset($id) ? $id->code : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Año Inicio:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="start" value="<?php echo isset($id) ? $id->start : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Año Fin:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="end" value="<?php echo isset($id) ? $id->end : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Ubicación:</label>
                        <div class="input-group">
                            <input class="form-control" name="location" value="<?php echo isset($id) ? $id->location : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>* Páginas / Folios:</label>
                        <div class="input-group">
                            <input type="number" step="1" class="form-control" name="pages" value="<?php echo isset($id) ? $id->pages : '' ?>" required>
                        </div>
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
                    <div class="form-group">
                        <label>* Centro de Documentación:</label>
                        <div class="input-group">
                            <input class="form-control" name="centre" value="<?php echo isset($id) ? $id->docCenter : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>* Reseña Institucional:</label>
                        <div class="input-group">
                            <input class="form-control" name="review" value="<?php echo isset($id) ? $id->review : '' ?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Área de Contenido</h3>
            </div>
            <div class="card-body row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Tema:</label>
                        <div class="input-group">
                            <input class="form-control" name="subject" value="<?php echo isset($id) ? $id->subject : '' ?>">
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Descripción / Resumen:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="description"><?php echo isset($id) ? $id->description : '' ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Palabras Clave:</label>
                        <div class="input-group">
                            <select class="form-control select2_tags" style="width:100%" name="keywords[]" multiple="multiple" required>
                            </select>
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

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Idioma / Lengua:</label>
                        <div class="input-group">
                            <select class="form-control" name="lang" required>
                                <option></option>
                                <option <?php echo (isset($id) and $id->type == 'Español') ? 'selected' : ''; ?>>Español</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Condiciones de Acceso:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="access"><?php echo isset($id) ? $id->access : '' ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Condiciones de Reproducción:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="reproduce"><?php echo isset($id) ? $id->reproduce : '' ?></textarea>
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

$(document).on('submit', '#New_Form', function(e) {
    e.preventDefault();
    if (document.getElementById("New_Form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Docs&a=Save", $("#New_Form").serialize()).done(function(res) {
            location.reload();
        });
    }
});
</script>