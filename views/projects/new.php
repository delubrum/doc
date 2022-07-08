<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="project_form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($id)) ? 'Edit' : 'New'; ?> Project</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Name:</label>
                    <div class="input-group">
                        <input class="form-control" name="name" value="<?php echo isset($id) ? $id->name : '' ?>" required>
                        <input type="hidden" name="projectId" value="<?php echo isset($id) ? $id->id : '' ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Designation:</label>
                    <div class="input-group">
                    <input class="form-control" name="designation" value="<?php echo isset($id) ? $id->designation : '' ?>" required <?php echo isset($id) ? 'readonly' :'' ?>>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Account Manager:</label>
                    <div class="input-group">
                        <select class="form-control select2" name="userId" style="width: 100%;" required>
                            <option value=''></option>
                            <?php
                            foreach($this->users->usersList() as $r) {
                            if ($r->role == 5) { ?>
                                <option value='<?php echo $r->id?>' <?php echo (isset($id) and $r->id == $id->userId) ? 'selected' : ''; ?>><?php echo $r->username?></option>
                            <?php }} ?>
                        </select>                
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Project Manager:</label>
                    <div class="input-group">
                        <select class="form-control select2" name="pmId" style="width: 100%;" required>
                            <option value=''></option>
                            <?php
                            foreach($this->users->usersList() as $r) {
                            if ($r->role == 4) { ?>
                                <option value='<?php echo $r->id?>' <?php echo (isset($id) and $r->id == $id->pmId) ? 'selected' : ''; ?>><?php echo $r->username?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Client:</label>
                    <div class="input-group">
                        <select class="form-control select2" name="clientId" style="width: 100%;" required>
                            <option value=''></option>
                            <?php
                            foreach($this->users->clientsList() as $r) { ?>
		                        <option value="<?php echo $r->id ?>" <?php echo (isset($id) and $r->id == $id->clientId) ? 'selected' : ''; ?>><?php echo $r->name ?>, <?php echo $r->company ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Currency:</label>
                    <div class="input-group">
                    <select class="form-control" name="currency" required>
                        <option></option>
                        <option <?php echo (isset($id) and "USD" == $id->currency) ? 'selected' : ''; ?>>USD</option>
                        <option <?php echo (isset($id) and "COP" == $id->currency) ? 'selected' : ''; ?>>COP</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Approved By:</label>
                    <div class="input-group">
                    <select class="form-control" name="approvedby" required>
                        <option></option>
                        <option value='1' <?php echo (isset($id) and "1" == $id->approvedBy) ? 'selected' : ''; ?>>CEO</option>
                        <option value='2' <?php echo (isset($id) and "2" == $id->approvedBy) ? 'selected' : ''; ?>>CEO AND PM</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>* Price:</label>
                    <div class="input-group">
                    <input id="price" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 0, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" class="form-control" name="price" placeholder="$ 0" value="<?php echo isset($id) ? $id->price : '' ?>" required>
                </div>
            </div>
            

        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?php echo (isset($id)) ? 'Update' : 'Add'; ?></button>
    </div>
</form>

<script>
$('.select2').select2({
    dropdownParent: $('#lgModal')
});

$(document).ready(function() {
    $(":input").inputmask();
});

$('#project_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("project_form").checkValidity()) {
        $("#loading").show();
        var formData = new FormData(this);
        $.ajax({
            url: "?c=Projects&a=Save",
            type: 'POST',
            data: formData,
            success: function (data) {
                $("#loading").hide();
                location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
</script>