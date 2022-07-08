<form method="post" id="machineNew_form">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo (isset($item->id)) ? 'Edit' : 'New'; ?> Machine</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="machineId" value="<?php echo (isset($item->id)) ? $item->id : ''; ?>">
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Name:</label>
                <div class="input-group">
                <input class="form-control form-control-sm" name="title" value="<?php echo (isset($item->title)) ? $item->title : ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Processes:</label>
                <div>
                    <?php foreach ($processes as $p) { ?>
                    <label class="btn <?php echo (isset($item->processes) and strpos($item->processes,$p)) ? 'btn-primary' : 'btn-secondary'; ?> process active">
                        <?php echo $p ?>
                        <input type="hidden" name="processes[]" value="<?php echo $p ?>" <?php echo (isset($item->processes) and strpos($item->processes,$p)) ? '' : 'disabled'; ?>>
                    </label>
                    <?php } ?>                            
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>