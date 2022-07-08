<form method="post" id="workOrderNew_form">
    <div class="modal-header">
        <h5 class="modal-title">New Work Order</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Project:</label>
                <div class="input-group">
                    <select class="form-control select2" name="projectId" style="width: 100%;" required>
                        <option value=''></option>
                        <?php foreach($this->projects->list('and closedAt is null') as $r) { 
                            $users = json_decode($r->users, true);
                            if ($r->users and in_array($user->id, $users)) {
                        ?>     
                            <option value='<?php echo $r->id?>'><?php echo $r->name?></option>
                        <?php }} ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Scope:</label>
                <div class="input-group">
                <input class="form-control" name="scope" required>
                </div>
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