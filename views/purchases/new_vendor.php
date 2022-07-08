<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
</header>

<form method="post" id="itemVendor_form" autocomplete = "on">
    <div class="modal-header">
        <h5 class="modal-title">Add Item Vendor</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Vendor:</label>
                <div class="input-group">
                    <input class="form-control form-control-sm" name="vendor" value="<?php echo isset($id) ? $id->vendor : '' ?>" required>
                    <input type="hidden" name="itemId" value="<?php echo $item->id ?>">
                    <input type="hidden" name="qty" value="<?php echo $item->qty ?>">
                    <input type="hidden" name="purchaseId" value="<?php echo $item->purchaseId ?>">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Vendor Days:</label>
                <input type="number" class="form-control form-control-sm" name="date" value="<?php echo isset($id) ? $id->date : '' ?>" required>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Price:</label>
                <div class="input-group">
                <input id="price" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 0, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" class="form-control form-control-sm" name="price" placeholder="$ 0" value="<?php echo isset($id) ? $id->price : '' ?>" required>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Notes:</label>
                <textarea type="text" class="form-control form-control-sm" name="notes" required><?php echo isset($id) ? $id->notes : '' ?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>

<script>
$(document).ready(function() {
    $(":input").inputmask();
});

$('#itemVendor_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("itemVendor_form").checkValidity()) {
        $("#loading").show();
        var formData = new FormData(this);
        $.ajax({
            url: "?c=Purchases&a=ItemVendorSave",
            type: 'POST',
            data: formData,
            success: function (data) {
                var data = $.parseJSON(data);
                $("#loading").hide();
                $("#vendorsTable").load("?c=Purchases&status=pricing&a=itemVendorsList&id=" + data.itemId);
                $("#itemsTable").load("?c=Purchases&a=PurchaseItemList&status=pricing&id=" + data.purchaseId);
                $('#itemVendor_form').trigger("reset");    
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
</script>