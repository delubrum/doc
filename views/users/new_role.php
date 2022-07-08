<form method="post" id="roleNew_form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($item->id)) ? 'Edit' : 'New'; ?> Role</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="roleId" value="<?php echo (isset($item->id)) ? $item->id : ''; ?>">
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Name:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="rolename" value="<?php echo (isset($item->rolename)) ? $item->rolename : ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Permissions:</label>
                <div>
                    <?php 
                        foreach ($this->users->PermissionsTitleList() as $t) { ?>
                            <div class="mt-3">
                              <h5><?php echo $t->category ?></h5>
                              <hr>
                            </div>
                            <?php 
                            isset($item->permissions) ? $rolePermissions = json_decode($item->permissions) : $rolePermissions = array();
                            foreach ($this->users->PermissionsList($t->category) as $p) { ?>
                              <label class="btn <?php echo (in_array($p->id, $rolePermissions)) ? 'btn-primary active' : 'btn-secondary'; ?> permission" data-id="<?php echo $p->id ?>" style="cursor:pointer">
                                <?php echo $p->name ?>
                                <?php echo (in_array($p->id, $rolePermissions)) ? "<input type='hidden' name='permissions[]' value='$p->id'>" : ""; ?>
                              </label>
                    <?php }} ?>                            
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>