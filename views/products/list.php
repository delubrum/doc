<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Categoria</th>
            <th>Descripción</th>
            <th>Talla</th>
            <th>Color</th>
            <th>Temporada</th>
            <th>Año</th>
            <th>Precio de Venta</th>
            <th>Inventario</th>

            <!-- <th>Código de Barras</th> -->
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->products->list() as $r) { 
        $qty = $this->purchases->getQty($r->id)->total - $this->sales->getQty($r->id)->total;
        ?>
        <tr>
            <th><input style="width:50px" type="number" name="checkid" class="printqty" value="0" data-id="<?php echo $r->id ?>"></th>
            <td><?php echo $r->code ?></td>
            <td><?php echo $r->categoryname ?></td>
            <td><?php echo  mb_convert_case($r->description, MB_CASE_TITLE, "UTF-8"); ?></td>
            <td><?php echo  mb_convert_case($r->size, MB_CASE_UPPER, "UTF-8"); ?></td>
            <td><?php echo  mb_convert_case($r->color, MB_CASE_UPPER, "UTF-8"); ?></td>
            <td><?php echo  mb_convert_case($r->season, MB_CASE_TITLE, "UTF-8"); ?></td>
            <td><?php echo $r->year ?></td>
            <td><?php echo number_format($r->price,2) ?></td>
            <td><?php echo $qty ?></td>
            <!-- <td><img src="middlewares/barcode.php?text='<?php echo $r->code ?>'&size=50&codetype=Code39&print=true" onclick="newWindow = window.open('middlewares/barcode.php?text=<?php echo $r->code ?>&size=50&codetype=Code39&print=true'); newWindow.print();"> </td> -->
            <td class="btn-group">
                <div class="custom-control custom-switch pt-2">
                    <input type="checkbox" class="custom-control-input active"
                        id="switch<?php echo $r->id ?>" data-id="<?php echo $r->id ?>"
                        <?php echo ($r->active == 1) ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="switch<?php echo $r->id ?>"></label>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
