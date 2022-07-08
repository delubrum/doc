<style>
    .hidetext{
        color: transparent;
    }
</style>
<table id="example" class="display table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Users</th>
            <th>Type</th>
            <th>Location</th>
            <th>Priority</th>
            <th>Complexity</th>
            <th>Attends</th>
            <th>Status</th>
            <th>Rating</th>
            <th class="text-right">Actions</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach($this->mnt->list($filters) as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->createdAt; ?></td>
            <td>
                <div title="User">
                    <?php echo $r->username; ?>
                </div>
                <div title="Fill Out By">
                    <?php echo $r->fillname; ?>
                </div>
            </td>
            <td><?php echo $r->type; ?></td>
            <td><?php echo $r->locationname; ?></td>
            <td>
                <?php switch ($r->priority) {
                    case "Low":
                        echo "<span class='hidetext'>0</span>" . $r->priority;
                        break;
                    case "Medium":
                        echo "<span class='hidetext'>1</span>" . $r->priority;
                        break;
                    case "High":
                        echo "<span class='hidetext'>2</span>" . $r->priority;
                        break;
                }
                ?>
            </td>
            <td>
                <?php switch ($r->complexity) {
                    case "Low":
                        echo "<span class='hidetext'>0</span>" . $r->complexity;
                        break;
                    case "Medium":
                        echo "<span class='hidetext'>1</span>" . $r->complexity;
                        break;
                    case "High":
                        echo "<span class='hidetext'>2</span>" . $r->complexity;
                        break;
                }
                ?>
            </td>
            <td><?php echo $r->attends ?></td>
            <td><?php switch (true) {
                case ($r->end and !$r->closedAt):
                    echo "Attended";
                    break;
                case (!$r->fillBy):
                    echo "Assign";
                    break;
                case (!$r->start and $r->fillBy):
                    echo "Open";
                    break;
                case ($r->start and !$r->end):
                    echo "Started";
                    break;
                case ($r->closedAt):
                    echo "Closed";
                    break;
                } ?>
            </td>
            <td><?php echo ($r->rating == 0) ? '' : $r->rating; ?></td>
            <?php if (empty($status))  { ?> 
                <td class="text-right">
                    <?php if(!$r->closedAt) { ?>
                        <?php if(!$r->fillBy and in_array(44, $permissions)) { ?> <button type="button" class="btn btn-primary mntAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="assign" data-title="Assign Service" title="Assign"><i class="fas fa-user-check"></i></button><?php } ?>
                        <?php if($r->fillBy and !$r->end and in_array(35, $permissions) and $r->fillBy == $user->id) { ?> <button type="button" class="btn btn-primary mntAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="process" data-title="Process Service" title="Process"><i class="fas fa-edit"></i></button><?php } ?>
                        <?php if($r->end and $user->id == $r->userId) { ?> <button type="button" class="btn btn-primary mntAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="rate" data-title="Rate Service" title="Rate"><i class="fas fa-check"></i></button><?php } ?>
                    <?php } ?>
                    <button type="button" class="btn btn-primary mntAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="view" data-title="View Service" title="View"><i class="fas fa-eye"></i></button>
                </td>
            <?php } ?>
        </tr>
        <?php } ?>
    </tbody>
</table>