<form method="post" id="woItem_form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($id->id)) ? 'Copy' : 'New'; ?> Item</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
        <input type="hidden" name="id" value="<?php echo $woId ?>">
        <div class="col-sm-6">
            <div class="form-group">
                <label>* Part Number:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="number" value="<?php echo (isset($id)) ? $id->number : ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>* Description:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="name" value="<?php echo (isset($id)) ? $id->name : ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>* Mass:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" type="number" min="0" step="0.001" name="weight" value="<?php echo (isset($id)) ? $id->weight : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label>* Mass UOM:</label>
                <div class="input-group">
                    <input class="form-control form-control-sm" name="uom" value="lbmass" style="width: 100%;" value="" readonly>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label>* Painting Area:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" type="number" min="0" step="0.001" name="pa" value="<?php echo (isset($id)) ? $id->pa : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label>* PA UOM:</label>
                <div class="input-group">
                    <input class="form-control form-control-sm" name="pauom" value="mm^2" style="width: 100%;" readonly>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="form-group">
                <label>* Finish & UC Code:</label>
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

        <div class="col-sm-12">
            <div class="form-group">
                <label>Notes:</label>
                <div class="input-group">
                <textarea style="width:100%" class="form-control form-control-sm" type="number" name="notes"><?php echo (isset($id)) ? $id->notes : ''; ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>* Processes:</label>
                <div>
                    <?php foreach ($this->wo->processesList() as $p) { ?>
                    <label class="btn <?php echo (isset($id->processes) and strpos($id->processes,$p->id)) ? 'btn-primary' : 'btn-secondary'; ?> process active" style="cursor:pointer">
                        <?php echo $p->name ?>
                        <input type="hidden" name="processes[]" value="<?php echo $p->id ?>" <?php echo (isset($id->processes) and strpos($id->processes,$p->id)) ? '' : 'disabled'; ?>>
                    </label>
                    <?php } ?>                            
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
$('#woItem_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("woItem_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=WorkOrders&a=ItemSave", $( "#woItem_form" ).serialize()).done(function(res) {
            if (isNaN(res.trim())) {
                toastr.error(res.trim());
                $("#loading").hide();
            } else {
                $("#loading").hide();
                $("#itemsTable").load("?c=WorkOrders&a=ItemList&status=process&id=" + res.trim());
                $('#woItem_form').trigger("reset");
            }
        });
    }
});

$('.process').on('click', function() {
    $(this).toggleClass('btn-primary btn-secondary active');
	if ($(this).hasClass("btn-secondary")) {
		$(this).find('input').prop( "disabled", true );
    } else {
		$(this).find('input').prop( "disabled", false );
    }
});
</script>