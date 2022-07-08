<form method="post" id="new_form">
    <div class="modal-header">
        <h5 class="modal-title">New Service Desk</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="col-sm-12">
            <div class="form-group">
                <label>* Type:</label>
                <div class="input-group">
                    <select class="form-control select2" name="type" style="width: 100%;" required>
                        <option value=''></option>
                        <option value='Equipment/Accessories'>Equipment/Accessories</option>
                        <option value='Licenses'>Licenses</option>
                        <option value='Permissions'>Permissions</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Priority</label>
                <div class="input-group">
                    <select class="form-control select2" name="priority" style="width: 100%;" required>
                        <option value=''></option>
                        <option value='High'>Right Now. Locked</option>
                        <option value='Medium'>Today. Need Attention</option>
                        <option value='Low'>Tomorrow. I Can Wait</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>* Description:</label>
                <div class="input-group">
                <textarea class="form-control" name="description" required></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>