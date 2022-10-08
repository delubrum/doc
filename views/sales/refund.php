<form method="post" id="Refund_Form">
    <div class="modal-header">
        <h5 class="modal-title">Devolución</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <?php foreach($this->sales->listDetail($id->id) as $b) {?>
            <div class="col-sm-10">
                <div class="form-group">
                    <label>* Producto</label>
                    <div class="input-group">
                        <?php  echo mb_convert_case($b->description, MB_CASE_TITLE, "UTF-8") . " x " . $b->qty . " [€". $b->price/$b->qty . " ud]" ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group">
                    <label>* Catidad</label>
                    <div class="input-group">
                        <input type="number" class="form-control" max="<?php echo $b->qty?>" min="0" step="1" name="qty[]" required>
                        <input type="hidden" value="<?php echo $b->id ?>" name="productId[]">
                        <input type="hidden" value="<?php echo $b->price/$b->qty ?>" name="price[]">
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Causa</label>
                    <div class="input-group">
                        <textarea name="cause" style="width:100%" required></textarea>
                        <input type="hidden" name="saleId" value="<?php echo $id->id ?>" required>

                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>

</form>