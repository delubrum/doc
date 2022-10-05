<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
</header>

<form method="post" id="Products_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Producto</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
            <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Categoría</label>
                                <div class="input-group">
                                    <select class="form-control" name="categoryId" required>
                                        <option value=''></option>
                                        <?php foreach($this->products->listCategory() as $r) { ?>
                                        <option value='<?php echo $r->id ?>'><?php echo $r->name ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Descripción</label>
                                <div class="input-group">
                                    <input class="form-control" name="description" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Talla</label>
                                <div class="input-group">
                                    <input class="form-control" name="size" required style="text-transform:uppercase">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Color</label>
                                <div class="input-group">
                                    <input class="form-control" name="color" required  style="text-transform:uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Precio de Venta</label>
                                <div class="input-group">
                                    <input id="price"
                                        data-inputmask="'alias': 'numeric', 'groupSeparator': '.', 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                                        class="form-control" name="price" placeholder="0" required>
                                </div>
                            </div>
                        </div>

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
});
</script>