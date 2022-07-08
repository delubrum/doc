<form method="post" id="purchaseNew_form">
    <div class="modal-header">
        <h5 class="modal-title">New Purchase</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Type:</label>
                <div class="input-group">
                    <select class="form-control form-control-sm" name="type" required>
                        <option value=''></option>
                        <option value='Service'>Service</option>
                        <option value='Material'>Material</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Project:</label>
                <div class="input-group">
                    <select class="form-control select2" name="projectId" style="width: 100%;" required>
                        <option value=''></option>
                        <?php foreach($this->projects->List() as $r) { ?>
                            <option value='<?php echo $r->id?>'><?php echo $r->name?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Delivery Place:</label>
                <div class="input-group">
                <input class="form-control" name="deliveryPlace" required>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Material Arrival Date:</label>
                <input type="date" class="form-control form-control-sm" name="requestDate" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Next</button>
    </div>
</form>

<script>
$('.select2').select2()
</script>