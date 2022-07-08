<form method="post" id="bomItem_form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($id->id)) ? 'Copy' : 'New'; ?> Item</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
        <input type="hidden" name="id" value="<?php echo $bomId ?>">
        <div class="col-sm-4">
            <div class="form-group">
                <label>* Description:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="description" value="<?php echo (isset($id)) ? $id->description : ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>* Alloy:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="alloy" value="<?php echo (isset($id)) ? $id->alloy : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Size:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="size" value="<?php echo (isset($id)) ? $id->size : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Length:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="length" value="<?php echo (isset($id)) ? $id->length : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* UOM:</label>
                <div class="input-group">
                    <select class="form-control form-control-sm" name="uom" style="width: 100%;" required>
                        <option></option>
                        <option <?php echo (isset($id) and $id->uom == 'ft') ? 'selected' : ''; ?>>ft</option>
                        <option <?php echo (isset($id) and $id->uom == 'in') ? 'selected' : ''; ?>>in</option>
                        <option <?php echo (isset($id) and $id->uom == 'mm') ? 'selected' : ''; ?>>mm</option>
                        <option <?php echo (isset($id) and $id->uom == 'cm') ? 'selected' : ''; ?>>cm</option>
                        <option <?php echo (isset($id) and $id->uom == 'm') ? 'selected' : ''; ?>>m</option>
                        <option <?php echo (isset($id) and $id->uom == 'ml') ? 'selected' : ''; ?>>ml</option>
                        <option <?php echo (isset($id) and $id->uom == 'und') ? 'selected' : ''; ?>>und</option>
                        <option <?php echo (isset($id) and $id->uom == 'gl') ? 'selected' : ''; ?>>gl</option>
                        <option <?php echo (isset($id) and $id->uom == 'lb') ? 'selected' : ''; ?>>lb</option>
                        <option <?php echo (isset($id) and $id->uom == 'kg') ? 'selected' : ''; ?>>kg</option>
                        <option <?php echo (isset($id) and $id->uom == 'gr') ? 'selected' : ''; ?>>gr</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Finish:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="finish" value="<?php echo (isset($id)) ? $id->finish : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Quantity:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" type="number" name="qty" value="<?php echo (isset($id)) ? $id->qty : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Location:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="location" value="<?php echo (isset($id)) ? $id->location : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Destination:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="destination" value="<?php echo (isset($id)) ? $id->destination : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>* Requisition:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="requisition" value="<?php echo (isset($id)) ? $id->requisition : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>Notes:</label>
                <div class="input-group">
                <textarea style="width:100%" class="form-control form-control-sm" type="number" name="notes"><?php echo (isset($id)) ? $id->notes : ''; ?></textarea>
                </div>
            </div>
        </div>

        </div>  
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>

<script>
$('#bomItem_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("bomItem_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=BOM&a=ItemSave", $( "#bomItem_form" ).serialize()).done(function(res) {
            if (isNaN(res.trim())) {
                toastr.error(res.trim());
                $("#loading").hide();
            } else {
                $("#loading").hide();
                $("#itemsTable").load("?c=BOM&a=ItemList&status=process&id=" + res.trim());
                $('#bomItem_form').trigger("reset");
            }
        });
    }
});
</script>