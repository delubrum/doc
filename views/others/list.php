<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->others->list($filters,$type) as $r) { ?>
        <tr>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->createdAt ?></td>
            <td><?php echo number_format($r->price,1) ?></td>
            <td><?php echo $r->obs ?></td>
            <td><?php echo $r->username ?></td>
        </tr>
        <?php } ?>

    </tbody>
</table>