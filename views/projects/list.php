<style>
    .swal2-title { 
        text-align: left !important;
        font-size: 22px !important;
    }
</style>

<table id="listTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Client</th>
            <th>Account Manager</th>
            <th>PM</th>
            <th>Currency</th>
            <th>Price</th>
            <th>Designation</th>
            <th>Approved By</th>
            <th class="text-right" style="width:120px">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->projects->list() as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->name; ?></td>
            <td><?php echo $r->clientname ?></td>
            <td><?php echo $r->managername; ?></td>
            <td><?php echo $r->pmname ?></td>
            <td><?php echo $r->currency; ?></td>
            <td><?php echo number_format($r->price) ?></td>
            <td><?php echo $r->designation; ?></td>
            <td><?php echo ($r->approvedBy == 1) ? 'CEO' : 'CEO & PM' ?></td>

            <td class="text-right">
                <button type="button" class="btn btn-primary new" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Edit"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-primary users" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Assign Users"><i class="fas fa-users"></i></button>
                <?php if(!$r->closedAt) { ?><button type="button" class="btn btn-danger closep" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Close"><i class="fas fa-check"></i></button> <?php } ?>    
                <?php if($r->closedAt) { ?> <button type="button" class="btn btn-success refresh" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Open"><i class="fas fa-redo"></i></button> <?php } ?>                
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
$(document).on("click", ".users", function() {
    id = $(this).data('id');
    $.post( "?c=Projects&a=Users",{id}).done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});

$(document).on('click', '.closep', function(e) {
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Pasos a verificar para cerrar un proyecto: \n- Está facturado totalmente \n- Tiene inventario de materiales en ceros \n- No tiene compras pendientes por elaborar \n- No tiene compras pendientes por recibir',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=Projects&a=Close", { id }).done(function( res ) {
                location.reload();
            });
        }
    })
});

$(document).on('click', '.refresh', function(e) {
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Open this project?',
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=Projects&a=Refresh", { id }).done(function( res ) {
                location.reload();
            });
        }
    })
});
</script>