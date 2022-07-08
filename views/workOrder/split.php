<form id="eventSplit_form">
    <div class="modal-header">
        <h5 class="modal-title"><b>Split:</b> <?php echo $wo_item->number . " / " . $event->process . " / (QTY: <span id='totalSplitQty'>" . $event->qty . "</span>)" ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body eventSplits">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Qty:</label>
                    <div class="input-group">
                    <input class="form-control form-control-sm splitQty" type="number" name="qty[]" required>
                    <input type="hidden" name="process[]" value="<?php echo $event->process ?>">
                    <input type="hidden" name="machine[]" value="<?php echo $event->resourceId ?>">
                    <input type="hidden" name="splitId" value="<?php echo $event->id ?>">
                    <input type="hidden" name="id" value="<?php echo $event->partNumberId ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label>Start - End:</label>
                    <input type="text" class="form-control form-control-sm reservationtime" name="startEnd[]" required>
                </div>
            </div>
            <div class="col-sm-1">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Qty:</label>
                    <div class="input-group">
                    <input class="form-control form-control-sm splitQty" type="number" name="qty[]" required>
                    <input type="hidden" name="process[]" value="<?php echo $event->process ?>">
                    <input type="hidden" name="machine[]" value="<?php echo $event->resourceId ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label>Start - End:</label>
                    <input type="text" class="form-control form-control-sm reservationtime" name="startEnd[]" required>
                </div>
            </div>
            <div class="col-sm-1">
                <a class="btn bg-primary add_split" data-process="<?php echo $event->process ?>" data-machine="<?php echo $event->resourceId ?>" style="margin-top:30px">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Split</button>
    </div>
</form>