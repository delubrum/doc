<form id="eventStop_form">
    <div class="modal-header">
    <h5 class="modal-title"><b>Stop:</b> <?php echo $wo_item->number . " / " . $event->process . " / (QTY: " . $event->partial . " / " . $event->qty . " )" ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
        <div class="form-group">
            <label>Cause:</label>
            <div class="input-group">
            <select class="form-control form-control-sm" type="number" name="cause" required>
                <option></option>
                <?php foreach($this->model->eventCausesList() as $r) { ?>
                <option><?php echo $r->name ?></option>
                <?php } ?>                    
            </select>
            <input type="hidden" name="eventId" value="<?php echo $event->id ?>">
            </div>
        </div>
        </div>
        <div class="col-sm-12">
        <div class="form-group">
            <label>Finished Qty:</label>
            <div class="input-group">
            <input type="number" max="<?php echo $event->qty - $event->partial ?>" class="form-control form-control-sm" type="number" name="qty" value="<?php echo ($event->qty <= $event->partial) ? '0' : '' ?>" required <?php echo ($event->qty <= $event->partial) ? 'readonly' : '' ?>>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Stop</button>
    </div>
</form>