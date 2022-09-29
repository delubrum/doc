<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Categoria</th>
            <th>Descripción</th>
            <th>Precio de Venta</th>
            <th>Código de Barras</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->products->list() as $r) { ?>
        <tr>
            <th><input style="width:50px" type="number" name="checkid" class="printqty" value="0" data-id="<?php echo $r->id ?>"></th>
            <td><?php echo $r->id ?></td>
            <td><?php echo $r->categoryname ?></td>
            <td><?php echo  mb_convert_case($r->description, MB_CASE_TITLE, "UTF-8"); ?></td>
            <td>$ <?php echo number_format($r->price,1) ?></td>
            <td><img src="middlewares/barcode.php?text='<?php echo $r->code ?>'&size=50&codetype=Code39&print=true" onclick="newWindow = window.open('middlewares/barcode.php?text=<?php echo $r->code ?>&size=50&codetype=Code39&print=true'); newWindow.print();"> </td>
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
