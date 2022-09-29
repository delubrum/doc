<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Apertura</th>
            <th>Valor Apertura</th>
            <th>Usuario</th>
            <th>Cierre</th>
            <th>Valor Cierre</th>
            <th>Usuario</th>
            <th class="text-right">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->cashbox->list($filters) as $r) { ?>
        <tr>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->openedAt ?></td>
            <td>$ <?php echo number_format($r->open,1) ?></td>
            <td><?php echo $r->openuser ?></td>
            <td><?php echo $r->closedAt ?></td>
            <td>$ <?php echo number_format($r->close,1) ?></td>
            <td><?php echo $r->closeuser ?></td>
            <td class="text-right"><button type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Detalle"><i class="fas fa-eye"></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
