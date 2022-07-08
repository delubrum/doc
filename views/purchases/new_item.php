<form method="post" id="purchaseItem_form">
    <div class="modal-header">
        <h5 class="modal-title">Add Purchase Item</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

    <input type="hidden" name="purchaseId" value="<?php echo $purchase->id ?>">

        <?php if ($purchase->type == 'Service') { ?>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Description:</label>
                <div class="input-group">
                    <input class="form-control form-control-sm" name="name" value="<?php echo isset($id) ? $id->material : '' ?>" required>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Description:</label>
                <div class="input-group">
                    <select class="form-control select2" name="name" style="width: 100%;" required>
                        <option value=''></option>
                        <?php foreach($this->purchases->getAvailable() as $r) { 
                        $name = "$r->id" . " || " . htmlentities(stripslashes($r->description)); ?>
                            <option value='<?php echo $name ?>' <?php echo (isset($id) and $name == htmlentities(stripslashes($id->material))) ? 'selected' : ''; ?>><?php echo $name ?></option>
                        <?php } ?>
                    </select>  
                </div>
            </div>
        </div>
        <?php }  ?>


        <div class="col-sm-12">
            <div class="form-group">
                <label>* Quantity:</label>
                <div class="input-group">
                <input type="number" class="form-control form-control-sm" name="qty" value="<?php echo isset($id) ? $id->qty : '' ?>" required>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Notes:</label>
                <textarea type="text" class="form-control form-control-sm" name="notes"><?php echo isset($id) ? $id->notes : '' ?></textarea>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Files:</label>
                <input type=file name="files[]" multiple>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>

<script>
$('.select2').select2({
    dropdownParent: $('#xsModal')
});

$('#purchaseItem_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("purchaseItem_form").checkValidity()) {
        $("#loading").show();
        var formData = new FormData(this);
        $.ajax({
            url: "?c=Purchases&a=PurchaseItemSave",
            type: 'POST',
            data: formData,
            success: function (data) {
                $("#loading").hide();
                $("#itemsTable").load("?c=Purchases&a=PurchaseItemList&status=process&id=" + data.trim());
                $('#purchaseItem_form').trigger("reset");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
</script>