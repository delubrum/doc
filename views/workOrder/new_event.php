<form method="post" id="newEvent_form">
    <div class="modal-header">
        <h5 class="modal-title">New Event</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Type:</label>
                <div class="input-group">
                <select class="form-control form-control-sm" name="type" id="eventType">
                <option value='1'>Event</option>
                <option value='2'>Part Number</option>
                </select>
                </div>
            </div>
        </div>
        <div id="newEvent">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Description:</label>
                    <div class="input-group">
                    <input class="form-control form-control-sm" name="description" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Start - End:</label>
                    <input type="text" class="form-control form-control-sm" name="dateRange" required>
                </div>
            </div>
        </div>
        <div id="newpartNumber" style="display:none">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Type:</label>
                    <div class="input-group">
                    <select class="form-control form-control-sm" name="type" required>
                    <option value='1'>Event</option>
                    <option value='2'>Part Number</option>
                    </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>