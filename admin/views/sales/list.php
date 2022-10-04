<table id="example" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Productos</th>
            <th>Precio Total</th>
            <th>Descuento</th>
            <th>Total Pagado</th>
            <th>Efectivo</th>
            <th>Cambio</th>
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
                    echo $b->description . " x " . $b->qty . "<br>";
                } 
                ?>
            </td>
            <td>$ <?php echo number_format($r->cash,2) ?></td>
            <td>$ <?php echo number_format($r->discount,2) ?></td>
            <td>$ <?php echo number_format($r->cash-$r->discount,2) ?></td>
            <td>$ <?php echo number_format($r->cash-$r->discount+$r->returned,2) ?></td>
            <td>$ <?php echo number_format($r->returned,2) ?></td>
            <td>
                <?php echo $r->obs ?> 
                <?php if ($r->cancelledAt) {
                    $title = "Causa: " . $this->sales->getRefund($r->id)->cause . "\nUsuario: " . $this->sales->getRefund($r->id)->username;
                    echo " <span class='text-danger' title='$title'><b>Devolución</b></span>";
                } 
                ?>
            </td>
            <td><?php echo $r->username ?></td>
            <td class="text-right">
                <?php if (!$r->cancelledAt) { ?> <button type="button" class="btn btn-danger refund" data-toggle='modal' data-target='#refund' data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Refund"> <i class="fas fa-redo"></i> </button> <?php } ?>
                <a class="btn btn-primary text-white m-1" style="cursor:pointer" data-toggle="tooltip" data-placement="top" href="?c=Sales&a=Detail&id=<?php echo $r->id; ?>" target="_blank" title="Ver"><i class="fas fa-eye"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="modal fade" id="refund" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="post" id="Refund_Form">
                <div class="modal-header">
                    <h5 class="modal-title">Devolución</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Causa</label>
                                <div class="input-group">
                                    <textarea name="cause" style="width:100%"></textarea>
                                    <input type="hidden" id="saleId" name="saleId">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>