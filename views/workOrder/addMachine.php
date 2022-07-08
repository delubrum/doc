<div class="remove row col-sm-12 machines_<?php echo $p ?>">
    <div class="col-sm-2">
        <div class="form-group">
            <div class="input-group">
            <input class="form-control form-control-sm" name="process[]" value="<?php echo $p ?>" readonly>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <div class="input-group">
            <select class="form-control form-control-sm" name="machine[]" required>
            <option value=""></option>
            <?php foreach($this->machines->MachinesList() as $r) {
                if (strpos($r->processes,$p)) { ?>
                    <option value="<?php echo $r->id ?>"><?php echo $r->title ?></option>
            <?php }} ?>
            </select>
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
            <div class="input-group">
            <input class="form-control form-control-sm qty_<?php echo $p ?>" type="number" name="qty[]" required>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" class="form-control form-control-sm reservationtime" name="startEnd[]" required>
        </div>
    </div>

    <div class="col-sm-1">
        <div class="form-group">
            <div class="input-group">
                <a class="btn bg-danger btnremove float-right" data-id="<?php echo $p ?>" style="margin-top:2px">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>
    </div>
</div>