<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>

</header>



<form method="post" id="Others_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo <?php echo ($type=='IN') ? 'Ingreso' : 'Egreso' ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
            <div class="row">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Descripción</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="obs" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Precio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                class="nav-icon fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input id="price"
                                        data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 1, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                                        class="form-control" name="price" placeholder="0" required>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="type" value="<?php echo $type ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(":input").inputmask();
    $('.select2').select2()
});
</script>