<table id="example" class="display nowrap">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Processes</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->machines->MachinesList() as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->title; ?></td>
            <td><?php foreach(json_decode($r->processes) as $p) { echo $p . "<br>"; } ?></td>
            <td>
                <div class="dropdown-menu" style="">
                    <a class="dropdown-item new" href="#" data-id="<?php echo $r->id; ?>" > <i class="fas fa-edit"></i> Edit</a>
                </div>
                <i class="fas fa-ellipsis-v float-right" style="cursor:pointer" data-toggle="dropdown" aria-expanded="false"></i>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>