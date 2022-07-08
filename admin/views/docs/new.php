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


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>* Título:</label>
                        <div class="input-group">
                            <input class="form-control" name="title" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>* Tipo:</label>
                        <div class="input-group">
                            <select class="form-control" name="type">
                                <option></option>
                                <option>Tipo 1</option>
                                <option>Tipo 2</option>
                            </select>
                        </div>
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
                    <div class="form-group">
                        <label>* Código de referencia:</label>
                        <div class="input-group">
                            <input class="form-control" name="code" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Fecha:</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="date" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Ubicación:</label>
                        <div class="input-group">
                            <input class="form-control" name="location" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>* Páginas / Folios:</label>
                        <div class="input-group">
                            <input type="number" step="1" class="form-control" name="pages" >
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
                            <input class="form-control" name="docCenter" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>* Reseña Institucional:</label>
                        <div class="input-group">
                            <input class="form-control" name="review" >
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
                            <input class="form-control" name="subject" >
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Descripción / Resumen:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="description" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Palabras Clave:</label>
                        <div class="input-group">
                            <select class="form-control select2_tags" style="width:100%" name="keywords[]" multiple="multiple" >
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
                            <select class="form-control" name="lang" >
                                <option></option>
                                <option>Español</option>
                                <option>Inglés</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Condiciones de Acceso:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="access" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Condiciones de Reproducción:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="reproduce" ></textarea>
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
                        <textarea class="form-control" name="notes" ></textarea>
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
$('.select2_tags').select2({tags:true,});

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