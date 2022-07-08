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
                    <input type="hidden" name="bomId" value="<?php echo $bomId ?>">
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>Notes:</label>
                <textarea type="text" class="form-control form-control-sm" name="notes"></textarea>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>* User:</label>
                <div class="input-group">
                <select class="form-control select2" name="email" style="width: 100%;" required>
                    <option value=''></option>
                    <?php
                    foreach($this->users->usersList() as $r) { ?>
                        <option value='<?php echo $r->email?>'><?php echo $r->username?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Password:</label>
                <div class="input-group">
                    <input type="password" class="form-control form-control-sm" name="pass" required>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Deliver</button>
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
            url: "?c=BOM&a=DeliverSave",
            type: 'POST',
            data: formData,
            success: function (data) {
                var data = $.parseJSON(data);
                if (isNaN(data.id)) {
                    toastr.error('Wrong Sing Authentication');
                    $("#loading").hide();
                } else {
                    $("#loading").hide();
                    $("#deliversTable").load("?c=BOM&status=confirm&a=DeliverList&id=" + data.itemId);
                    $("#itemsTable").load("?c=BOM&a=ItemList&status=confirm&id=" + data.bomId);
                    $('#xsModal').modal("hide");    
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
</script>