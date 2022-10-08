<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Productos</th>
            <th>Precio Total</th>
            <th>Descuento</th>
            <th>Total con descuento</th>
            <th>Forma de Pago</th>
            <th>Observaciones</th>
            <th>Devoluciones</th>
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
                <?php foreach($this->sales->listDetail($r->id) as $b) { ?>
                    <span title="Original: <?php echo $b->qty?>
                    <?php foreach($this->sales->listRefunds($b->productId) as $c) {
                        echo "\nDevolución: $c->qty ($c->createdAt)";
                    }
                    ?>">
                    <?php 
                    
                    ($this->sales->SumRefunds($b->saleId,$b->productId)->total) ? $refunds = $this->sales->SumRefunds($b->saleId,$b->productId)->total : $refunds = 0;
                    echo $b->code . " " . mb_convert_case($b->description, MB_CASE_TITLE, "UTF-8") . " x " . ($b->qty - $refunds) . "</span><br>";?>
                <?php } ?>
            </td>
            <td class="text-right"><?php echo number_format($r->total,2) ?></td>
            <td class="text-center"><?php echo $r->discount ?>%</td>
            <td class="text-right"><?php echo number_format($r->total-($r->total*$r->discount/100),2) ?></td>

            <td>
                <?php echo ($r->cash != 0) ? "<b>Efectivo: </b>" . number_format($r->cash,2) . "<br>" : '' ?>
                <?php echo ($r->card != 0) ? "<b>Tarjeta: </b>" . number_format($r->card,2) . "<br>" : '' ?>
                <?php echo ($r->ticket != 0) ? "<b>Tickets: </b>" . number_format($r->ticket,2) : '' ?>
            </td>
            <td><?php echo $r->obs ?></td>
            <td class="text-right text-red"><?php echo $this->sales->getRefunds($r->id)->price ?></td>
            <td><?php echo $r->username ?></td>
            <td class="text-right">
                <?php if (in_array(12, $permissions)) { ?> <button type="button" class="btn btn-danger refund" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Devolucion"> <i class="fas fa-redo"></i> </button> <?php } ?>
                <a class="btn btn-primary text-white m-1" style="cursor:pointer" data-toggle="tooltip" data-placement="top" href="?c=Sales&a=Detail&id=<?php echo $r->id; ?>" target="_blank" title="Ver"><i class="fas fa-eye"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>