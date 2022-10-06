<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Valor</th>
            <th>Vencimiento</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->tickets->list() as $r) { ?>
        <tr>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->createdAt ?></td>
            <td>$ <?php echo number_format($r->price,1) ?></td>
            <td><?php echo $r->expiresAt ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
