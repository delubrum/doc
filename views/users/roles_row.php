<table id="example" class="display nowrap">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Permissions</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->users->RolesList() as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->rolename; ?></td>
            <td><?php foreach(json_decode($r->permissions) as $p) { echo $this->users->permissionsGetbyId($p)->name . "<br>"; } ?></td>
            <td class="text-right">
                <button type="button" class="btn btn-primary new" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" title="Edit"><i class="fas fa-edit"></i></button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>