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
                        <div class="col-sm-6">
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

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Descripción</label>
                                <div class="input-group">
                                    <input class="form-control" name="description" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>* Talla</label>
                                <div class="input-group">
                                    <input class="form-control" name="size" required style="text-transform:uppercase">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>* Color</label>
                                <div class="input-group">
                                    <input class="form-control" name="color" required  style="text-transform:uppercase">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>* Año</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" min="1900" max="2099" step="1" name="year">                            
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Temporada</label>
                                <div class="input-group">
                                    <select class="form-control" name="season" required>
                                        <option value=''></option>
                                        <option value='Primavera / Verano'>Primavera / Verano</option>
                                        <option value='Otoño / Invierno'>Otoño / Invierno</option>
                                    </select>                                
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
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