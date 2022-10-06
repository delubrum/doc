<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Productos</th>
            <th>Precio Total</th>
            <th>Descuento</th>
            <th>Pago</th>
            <th>Total Pagado</th>
            <th>Observaciones</th>
            <th>Usuario</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->sales->list() as $r) { ?>
        <tr>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->createdAt ?></td>
            <td>
                <?php foreach($this->sales->listDetail($r->id) as $b) {
                    echo mb_convert_case($b->description, MB_CASE_TITLE, "UTF-8") . " x " . $b->qty . "<br>";
                } 
                ?>
            </td>
            <td class="text-right"><?php echo number_format($r->cash+$r->card+$r->ticket,2) ?></td>
            <td class="text-center"><?php echo $r->discount ?>%</td>
            <td>
                <?php echo ($r->cash != 0) ? "<b>Efectivo: </b>" . number_format($r->cash,2) . "<br>" : '' ?>
                <?php echo ($r->card != 0) ? "<b>Tarjeta: </b>" . number_format($r->card,2) . "<br>" : '' ?>
                <?php echo ($r->ticket != 0) ? "<b>Tickets: </b>" . number_format($r->ticket,2) : '' ?>
            </td>
            <td class="text-right"><?php echo number_format($r->cash+$r->card+$r->ticket-(($r->cash+$r->card+$r->ticket) * $r->discount/100),2) ?></td>
            <td>
                <?php echo $r->obs ?> 
            </td>
            <td><?php echo $r->username ?></td>
            <td class="text-right">
                <?php if (in_array(12, $permissions)) { ?> <button type="button" class="btn btn-danger refund" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Devolucion"> <i class="fas fa-redo"></i> </button> <?php } ?>
                <a class="btn btn-primary text-white m-1" style="cursor:pointer" data-toggle="tooltip" data-placement="top" href="?c=Sales&a=Detail&id=<?php echo $r->id; ?>" target="_blank" title="Ver"><i class="fas fa-eye"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>