<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Productos</th>
            <th>Precio Total</th>
            <th>Pago</th>
            <th>Cambio</th>
            <th>Observaciones</th>
            <th>Medio de Pago</th>
            <th>Usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->sales->list() as $r) { ?>
        <tr>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->created_at ?></td>
            <td>
                <?php foreach($this->sales->listDetail($r->id) as $b) {
                    echo $b->description . " x " . $b->qty . "<br>";
                } 
                ?>
            </td>
            <td>$ <?php echo number_format($r->price,1) ?></td>
            <td>$ <?php echo number_format($r->price+$r->returned,1) ?></td>
            <td>$ <?php echo number_format($r->returned,1) ?></td>
            <td><?php echo $r->obs ?></td>
            <td><?php echo $r->type ?></td>
            <td><?php echo $r->username ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>