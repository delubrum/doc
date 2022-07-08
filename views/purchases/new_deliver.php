<header>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="deliver_form" autocomplete = "off">
    <div class="modal-header">
        <h5 class="modal-title">Add Note</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Quantity:</label>
                <div class="input-group">
                    <input class="form-control form-control-sm" name="qty" required>
                    <input type="hidden" name="itemId" value="<?php echo $itemId ?>">
                    <input type="hidden" name="purchaseId" value="<?php echo $purchaseId ?>">
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>Notes:</label>
                <textarea type="text" class="form-control form-control-sm" name="notes"></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Receive</button>
    </div>
</form>

<script>

$('.select2').select2()

$('#deliver_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("deliver_form").checkValidity()) {
        $("#loading").show();
        var formData = new FormData(this);
        $.ajax({
            url: "?c=Purchases&a=DeliverSave",
            type: 'POST',
            data: formData,
            success: function (data) {
                var data = $.parseJSON(data);
                $("#loading").hide();
                $("#deliversTable").load("?c=Purchases&status=receive&a=DeliverList&id=" + data.itemId);
                $("#itemsTable").load("?c=Purchases&a=PurchaseItemList&status=receive&id=" + data.purchaseId);
                $('#xsModal').modal("hide");    
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
</script>