<form method="post" id="History_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Documento</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body row">

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Fecha:</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="date" value="<?php echo isset($id) ? $id->date : '' ?>" required>
                    <input type="hidden" name="id" value="<?php echo isset($id) ? $id->id : '' ?>">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Tema:</label>
                <div class="input-group">
                    <input class="form-control" name="subject" value="<?php echo isset($id) ? $id->subject : '' ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Subtema:</label>
                <div class="input-group">
                    <input class="form-control" name="subject2" value="<?php echo isset($id) ? $id->subject2 : '' ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>* Documento:</label>
                <div class="input-group">
                    <textarea class="form-control" name="doc" required><?php echo isset($id) ? $id->doc : '' ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>* Resumen:</label>
                <div class="input-group">
                    <textarea class="form-control" name="abstract" required><?php echo isset($id) ? $id->abstract : '' ?></textarea>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="form-group">
                <label>* Fuente:</label>
                <div class="input-group">
                    <textarea class="form-control" name="source" required><?php echo isset($id) ? $id->source : '' ?></textarea>
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