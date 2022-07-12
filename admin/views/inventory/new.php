<form method="post" id="New_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Documento</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Autor(es):</label>
                        <div class="input-group">
                            <input class="form-control" name="author" value="<?php echo isset($id) ? $id->author : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Título:</label>
                        <div class="input-group">
                            <input class="form-control" name="author" value="<?php echo isset($id) ? $id->author : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Nombre Publicación Seriada:</label>
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
        $.post( "?c=Invetory&a=Save", $("#New_Form").serialize()).done(function(res) {
            location.reload();
        });
    }
});
</script>