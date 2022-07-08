<table id="example" class="display table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Order</th>
            <th>Users</th>
            <th>Project</th>
            <th>Production Start</th>
            <th>Scope</th>
            <th>Weight</th>
            <th>Status</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->model->list($filters) as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->designation; ?></td>
            <td>
                <div title="User">
                    <?php echo $r->username; ?>
                </div>
                <div title="PM">
                    <?php echo $r->pmname; ?>
                </div>
            </td>
            <td><?php echo $r->projectname; ?></td>
            <td><?php echo $r->sentAt ?></td>
            <td><?php echo htmlentities(stripslashes($r->scope)); ?></td>
            <td><?php echo number_format($this->wo->weight("and woId = $r->id")->total/2.20462,2) ?> kg</td>
            <td><?php switch (true) {
                case ($r->closedAt):
                    echo "Closed";
                    break;
                case (!$r->processedAt):
                    echo "Processing";
                    break;
                case ($r->processedAt and !$r->confirmedAt):
                    echo "Checking";
                    break;
                case ($r->confirmedAt and !$r->sentAt):
                    echo "Approval";
                    break;
                case ($r->sentAt and !$r->closedAt):
                    echo "Production";
                    break;
                case ($r->cancelledAt):
                    echo "Cancelled";
                    break;
                } ?>
            </td>
                <td class="text-right">
                    <?php if(!$r->cancelledAt and !$r->closedAt) { ?>
                        <?php if(!$r->processedAt and $user->id == $r->userId) { ?> <button type="button" class="btn btn-primary woAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="process" data-title="Process Work Order" title="Process"><i class="fas fa-edit"></i></button><?php } ?>
                        <?php if($r->processedAt and !$r->confirmedAt and $user->id == $r->userId) { ?> <button type="button" class="btn btn-primary woAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="confirm" data-title="Confirm Work Order" title="Confirm"><i class="fas fa-check"></i></button><?php } ?>
                        <?php if($r->confirmedAt and !$r->sentAt and $user->id == $r->pmId) { ?> <button type="button" class="btn btn-primary woAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="send" data-title="Approve Work Order" title="Approve"><i class="fas fa-check"></i></button><?php } ?>
                        
                    <?php } ?>
                    <?php if($r->sentAt) { ?> <button type="button" class="btn btn-primary woAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="view" data-title="View Work Order" title="View"><i class="fas fa-eye"></i></button><?php } ?>
                </td>
        </tr>
        <?php } ?>
    </tbody>
</table>