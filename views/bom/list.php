<table id="example" class="display table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Code</th>
            <th>Users</th>
            <th>Project</th>
            <th>Date</th>
            <th>Scope</th>
            <th>Status</th>
            <th class="text-right">Actions</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach($this->bom->list($filters) as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->code; ?></td>
            <td>
                <div title="User">
                    <?php echo $r->username; ?>
                </div>
                <div title="PM">
                    <?php echo $r->pmname; ?>
                </div>
            </td>
            <td><?php echo $r->projectname; ?></td>
            <td><?php echo $r->createdAt ?></td>
            <td><?php echo htmlentities(stripslashes($r->scope)); ?></td>
            <td><?php switch (true) {
                case ($r->storedAt and $this->bom->checkSapItems($r->id) and $this->bom->checkSap($r->id)):
                    echo "SAP Saving";
                    break;
                case ($r->cancelledAt):
                    echo "Cancelled";
                    break;
                case (!$r->sentAt):
                    echo "Processing";
                    break;
                case (!$r->storedAt and $r->sentAt):
                    echo "Delivering";
                    break;


                case (!$this->bom->checkSapItems($r->id) and !$this->bom->checkSap($r->id)):
                    echo "Closed";
                    break;
                } ?>
            </td>
            <?php if (empty($status))  { ?> 
                <td class="text-right">
                    <?php if(!$r->cancelledAt and !$r->storedAt) { ?>
                        <?php if(!$r->sentAt and $user->id == $r->userId) { ?> <button type="button" class="btn btn-primary bomAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="process" data-title="Process Bill of Material" title="Process"><i class="fas fa-edit"></i></button><?php } ?>
                        <?php if($r->sentAt and !$r->storedAt and in_array(25, $permissions)) { ?> <button type="button" class="btn btn-primary bomAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="confirm" data-title="Confirm Bill of Material" title="Confirm"><i class="fas fa-check"></i></button><?php } ?>                        
                    <?php } ?>
                    <button type="button" class="btn btn-primary bomAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="view" data-title="View Work Order" title="View"><i class="fas fa-eye"></i></button>
                </td>
            <?php } ?>
        </tr>
        <?php } ?>
    </tbody>
</table>