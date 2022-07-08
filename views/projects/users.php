
<form method="post" id="users_form">
    <div class="modal-header">
    <h5 class="modal-title">Assing Users:</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-sm-1 col-form-label">User:</label>
            <div class="col-sm-9">
                <select class="form-control select2" name="userId" style="width: 100%;" required>
                    <option value=''></option>
                    <?php
                    foreach($this->users->usersList() as $r) { ?>
                        <option value='<?php echo $r->id?>'><?php echo $r->username?></option>
                    <?php } ?>
                </select>
                <input type='hidden' name="project" value='<?php echo $id->id ?>'>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add User
                </button>
            </div>
        </div>
        <div class="card-body table-responsive p-0" style="height: 300px;">
      <?php $this->UserList($id->id) ?>
    </div>
    </div>
</form>

<script>

$('#users_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("users_form").checkValidity()) {
        $("#loading").show();
        var formData = new FormData(this);
        $.ajax({
            url: "?c=Projects&a=UserAdd",
            type: 'POST',
            data: formData,
            success: function (res) {
                $("#loading").hide();
                $("#usersTable").load("?c=Projects&a=UserList&id=" + res.trim());
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
</script>