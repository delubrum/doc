<form method="post" id="partNumber_form">
    <div class="modal-header">
        <h5 class="modal-title">New Part Number</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Description:</label>
                    <div class="input-group">
                        <input class="form-control" name="description" value="<?php echo (isset($id)) ? htmlentities(stripslashes($item->description)) : '';?>" required>
                        <input type="hidden" name="projectId" value="<?php echo $item->projectId?>">
                        <input type="hidden" name="designation" value="<?php echo $item->designation?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Part:</label>
                    <div class="input-group">
                        <select class="form-control" name="part" required>
                            <option value=''></option>
                            <?php foreach($this->pn->partList() as $r) { ?>
                                <option value='<?php echo $r->id?>' <?php echo (isset($id) and $item->part == $r->id) ? 'selected' : '' ;?>><?php echo $r->name?></option>
                            <?php } ?>
                        </select>                
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Material:</label>
                    <div class="input-group">
                        <select class="form-control" name="material" required>
                            <option value=''></option>
                            <?php foreach($this->pn->materialList() as $r) { ?>
                                <option value='<?php echo $r->id?>' <?php echo (isset($id) and $item->material == $r->id) ? 'selected' : '' ;?>><?php echo $r->name?></option>
                            <?php } ?>
                        </select>                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>