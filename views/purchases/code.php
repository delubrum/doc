<form method="post" id="purchaseCode_form">
    <div class="modal-header">
        <h5 class="modal-title">Approve Purchase Code</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

    <input type="hidden" name="id" value="<?php echo $id->id ?>">

    <div class="col-sm-12">
            <div class="form-group">
                <label><?php echo $id->name ?></label>
                <div class="input-group">
                    <select class="form-control form-control-sm" name="status" id="status" required>
                        <option value=""></option>
                        <option value="1">Approve</option>
                        <option value="0">Reject</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-12 approve" style="display:none">
            <div class="form-group">
                <label>* Description:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="description" id="description" required>
                </div>
            </div>
        </div>

        <div class="col-sm-12 approve" style="display:none">
            <div class="form-group">
                <label>* Code:</label>
                <div class="input-group">
                <input type="number" class="form-control form-control-sm" name="code" id="code" required>
                </div>
            </div>
        </div>

        <div class="col-sm-12 cause" style="display:none">
            <div class="form-group">
                <label>Cause:</label>
                <textarea type="text" class="form-control form-control-sm" name="cause" id="cause" required></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

<script>

$('#purchaseCode_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("purchaseCode_form").checkValidity()) {
        $("#loading").show();
        var formData = new FormData(this);
        $.ajax({
            url: "?c=Purchases&a=CodeUpdate",
            type: 'POST',
            data: formData,
            success: function (data) {
                location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});

$('#status').on('change', function(e) {
    if($(this).val() == 1) {
        $('.approve').show();
        $('.cause').hide();
        $("#description").prop('required',true);
        $("#code").prop('required',true);
        $("#cause").prop('required',false);

    } else {
        $('.approve').hide();
        $('.cause').show();
        $("#description").prop('required',false);
        $("#code").prop('required',false);
        $("#cause").prop('required',true);
    }
});
</script>