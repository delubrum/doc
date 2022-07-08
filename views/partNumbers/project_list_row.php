<table id="listTable" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Account Manager</th>
            <th>Client</th>
            <th>PM</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->projects->list('and closedAt is null') as $r) { 
            $users = json_decode($r->users, true);
            if ($r->users and in_array($user->id, $users)) {
        ?>        
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->name; ?></td>
            <td><?php echo $r->designation; ?></td>
            <td><?php echo $r->managername; ?></td>
            <td><?php echo $r->clientname ?></td>
            <td><?php echo $r->pmname ?></td>
            <td class="text-right">
                <button type="button" class="btn btn-primary edit" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Edit"><i class="fas fa-edit"></i></button>
            </td>
        </tr>
        <?php }} ?>
    </tbody>
</table>