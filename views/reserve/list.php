<table id="example" class="display table-striped">
    <thead>
    <tr>
        <th class="bg-secondary">Id</th>
        <th class="bg-secondary">Material Id</th>
        <th class="bg-secondary">Date</th>
        <th class="bg-secondary">Description</th>
        <th class="bg-secondary">Old Project</th>
        <th class="bg-secondary">New Project</th>
        <th class="bg-secondary">Qty</th>
        <th class="bg-secondary">Reserve Id</th>
        <th class="bg-secondary">Checked</th>
        <th class="bg-secondary">Price (Unit)</th>
        <th class="bg-secondary">Price (Total)</th>
        <th class="bg-secondary">User</th>
        <th class="bg-secondary">Store</th>
        <th class="bg-secondary">Notes</th>
        <th class="bg-secondary">Status</th>
        <th class="bg-secondary">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($this->reserve->list($filters) as $r) { ?>
    <tr>
        <td><?php echo $r->id ?>
        <td><?php echo $r->materialId ?>
        <td><?php echo $r->createdAt ?>
        <td><?php echo htmlentities(stripslashes($r->description)) ?>
        <td><?php echo $r->project ?>
        <td><?php echo $r->projectname ?>
        <td><?php echo $r->qty ?>
        <td><?php echo $r->reserveId ?>
        <td><?php echo $r->received ?>
        <td><?php echo number_format($r->price,2) ?>
        <td><?php echo number_format($r->price*$r->qty,2) ?>
        <td><?php echo $r->username ?>
        <td><?php echo $r->store ?>
        <td><?php echo $r->notes ?>

        <td>
                <?php
                switch (true) {
                    case ($r->cancelledAt):
                        echo "Cancelled";
                        break;
                    case (!$r->approvedAt):
                        echo "Approving";
                        break;
                    case ($r->approvedAt and !$r->receivedAt):
                        echo "Receiving";
                        break;
                    case ($r->receivedAt):
                        echo "Closed";
                        break;
                }
                ?>
            </td>
            <td class="text-right">
                <?php if (!$r->cancelledAt and !$r->approvedAt and in_array(40, $permissions)) { ?> <button type="button" id="approve" class="btn btn-primary" data-toggle="modal" data-id="<?php echo $r->id; ?>" data-target=".approve"> <i class="fas fa-check"></i></button> <?php } ?>
                <?php if (!$r->cancelledAt and $r->approvedAt and in_array(43, $permissions) and !$r->receivedAt) { ?>  <button type="button" id="receive" class="btn btn-primary" data-toggle="modal" data-id="<?php echo $r->id; ?>" data-target=".receive"> <i class="fas fa-hand-holding"></i></button> <?php } ?>
                <?php if ((!$r->cancelledAt and !$r->approvedAt and in_array(40, $permissions)) or (!$r->cancelledAt and !$r->receivedAt and $r->approvedAt and in_array(43, $permissions))) { ?> <button type="button" id="reject" class="btn btn-danger" data-toggle="modal" data-id="<?php echo $r->id; ?>" data-target=".reject"> <i class="fas fa-trash"></i></button> <?php } ?>
                <?php if($this->init->RejectList('reserve',$r->id)) { ?><button type="button" class="btn btn-warning rejections float-right" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-type='reserve' title="Rejections"><i class="fas fa-exclamation"></i></button><?php } ?>
            </td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<div class="modal fade reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <form method="post" id="reject_form">
              <div class="modal-header">
                  <h5 class="modal-title">Cancel</b></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>* Cause:</label>
                          <div class="input-group">
                              <textarea type="text" class="form-control form-control-sm" name="cause" required></textarea>
                              <input type="hidden" name="id">
                              <input type="hidden" name="type" value="reserve">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Reject</button>
              </div>
          </form>
      </div>
  </div>
</div>

<div class="modal fade receive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <form method="post" class="reserve_form" data-status="receive">
              <div class="modal-header">
                  <h5 class="modal-title">Check</b></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>* Quantity:</label>
                          <div class="input-group">
                              <input type="number" class="form-control form-control-sm" name="qty" required>
                              <input type="hidden" name="id">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Check</button>
              </div>
          </form>
      </div>
  </div>
</div>

<div class="modal fade approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <form method="post" class="reserve_form" data-status="approve">
              <div class="modal-header">
                  <h5 class="modal-title">Approve</b></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>* Reserve Id:</label>
                          <div class="input-group">
                              <input class="form-control form-control-sm" name="reserveId" required>
                              <input type="hidden" name="id">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Approve</button>
              </div>
          </form>
      </div>
  </div>
</div>