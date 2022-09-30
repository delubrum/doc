<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Apertura</th>
            <th>Valor <br> Apertura</th>
            <th>Usuario <br> Apertura</th>
            <th>Cierre</th>
            <th>Valor <br> Cierre</th>
            <th>Usuario <br> Cierre</th>
            <th>Ventas</th>
            <th>Otros <br> Ingresos</th>
            <th>Otros <br> Egresos</th>
            <th>Compras</th>



            <th class="text-right">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->cashbox->list($filters) as $r) { 
            $start=$this->cashbox->get($r->id)->openedAt;
            (isset($this->cashbox->get($r->id)->closedAt)) ? $end = $this->cashbox->get($r->id)->closedAt : $end = date("Y-m-d h:i:s");
            $cash=$this->sales->get($start,$end)->total;
            $purchases=$this->purchases->get($start,$end)->total;
            $others_income=$this->others->get($start,$end,'IN')->total;
            $others_outcome=$this->others->get($start,$end,'OUT')->total;
            ?>
        <tr>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->openedAt ?></td>
            <td><?php echo number_format($r->open,1) ?></td>
            <td><?php echo $r->openuser ?></td>
            <td><?php echo $r->closedAt ?></td>
            <td><?php echo number_format($r->close,1) ?></td>
            <td><?php echo $r->closeuser ?></td>
            <td><?php echo number_format($cash,1) ?></td>
            <td><?php echo number_format($others_income,1) ?></td>
            <td><?php echo number_format($others_outcome,1) ?></td>
            <td><?php echo number_format($purchases,1) ?></td>
            <td class="text-right"><button type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Detalle"><i class="fas fa-eye"></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
