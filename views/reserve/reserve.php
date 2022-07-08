
<header>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" class="reserve_form" data-status="<?php echo $status ?>">
  <div class="modal-header">
  <h5 class="modal-title"><?php echo $title ?> : <b><?php echo $id->id ?></b></h5>
  <input type="hidden" name="id" value="<?php echo $id->id ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">

    <div class="row">
        <div class="col-sm-6">
            <dl>
                <dt><i class="fas fa-info-circle"></i> ID:</dt>
                <dd><?php echo $id->id ?></dd>
            </dl>
        </div>
        <div class="col-sm-6">
            <dl>
                <dt><i class="fas fa-info text-center"></i> DESCRIPTION:</dt>
                <dd><?php echo $id->description ?></dd>
            </dl>
        </div>
        <?php if($status) { ?>
        <div class="col-sm-6">
            <dl>
                <dt><i class="fas fa-info-circle"></i> RESERVATION PROJECT:</dt>
                <dd><?php echo $id->projectname ?></dd>
            </dl>
        </div>
        <div class="col-sm-6">
            <dl>
                <dt><i class="fas fa-info text-center"></i> QUANTITY:</dt>
                <dd id="totalQty"><?php echo $id->qty ?></dd>
            </dl>
        </div>
        <?php } ?>

    </div>

    <div class="row">
        <table class="table table-head-fixed table-striped table-hover" style="width:100%">
            <thead>
            <tr>
                <th class="bg-secondary">Date</th>
                <th class="bg-secondary">Project</th>
                <th class="bg-secondary">Store</th>
                <th class="bg-secondary">Qty</th>
                <th class="bg-secondary">Reserve</th>
                <th class="bg-secondary">Price (Unit)</th>
                <th class="bg-secondary">Notes</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($this->reserve->getAll($id->id) as $r) { 
                $partial = $this->reserve->getQty($r->id,$r->createdAt,$r->project,$r->store)->total;
                $op = $r->qty - $partial;
                if ($op != 0) {
                ?>
            <tr>
                <td><?php echo $r->createdAt ?>
                <td><?php echo $r->project ?>
                <td><?php echo $r->store ?>
                <td><?php echo $r->qty - $partial ?>
                
                    <td>
                        <input type="hidden" name="project[]" value="<?php echo $r->project ?>">
                        <input type="hidden" name="description[]" value="<?php echo $r->description ?>">
                        <input type="hidden" name="store[]" value="<?php echo $r->store ?>">
                        <input type="hidden" name="price[]" value="<?php echo $r->price ?>">
                        <input type="number" style="width:80px" class="reserveQty" name="qty[]" value="0" max="<?php echo $r->qty - $partial ?>" required>
                    </td>
                <td><?php echo number_format($r->price,2) ?>
                <td><textarea class="form-control" name="notes[]" style="width:100%"></textarea></td>
            </tr>
            <?php }} ?>
            </tbody>
        </table>

        <h4 class="col-sm-12 text-right">TOTAL: <span id="total">0</span></h4>


        <div class="col-sm-12 mb-4">
            <div class="form-group">
                <label>* Project:</label>
                <div class="input-group">
                    <select class="form-control select2" name="projectId" style="width: 100%; height:100px" required>
                        <option value=''></option>
                        <?php foreach($this->projects->list('and closedAt is null') as $r) { ?>
                            <option value='<?php echo $r->id?>'><?php echo $r->name?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        
    </div>

    <br><br><br><br>
  </div>

  <div class="modal-footer mt-4">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>

</form>

<script>
$('.select2').select2()
</script>