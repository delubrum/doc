<div class="row process_<?php echo $p ?>">
    <div class="row col-sm-12">
        <div class="col-sm-2">
            <div class="form-group">
                <label>Process:</label>
                <div class="input-group">
                <input class="form-control form-control-sm processName" value="<?php echo $p ?>" readonly name="process[]">
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label>Machine:</label>
                <div class="input-group">
                <select class="form-control form-control-sm" name="machine[]" required>
                <option value=""></option>
                <?php foreach($this->mahchines->MachinesList() as $r) {
                    if (strpos($r->processes,$p)) { ?>
                        <option value="<?php echo $r->id ?>"><?php echo $r->title ?></option>
                <?php }} ?>
                </select>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label>Qty:</label>
                <div class="input-group">
                <input class="form-control form-control-sm qty_<?php echo $p ?>" type="number" name="qty[]" required>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label>Start - End:</label>
                <input type="text" class="form-control form-control-sm reservationtime" name="startEnd[]" required>
            </div>
        </div>

        <div class="col-sm-1">
            <a class="btn bg-primary add_machine" data-id="<?php echo $p ?>" style="margin-top:30px">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
</div>