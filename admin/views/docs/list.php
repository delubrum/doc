<table id="example" class="display table-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Fecha</th>
            <th>Título</th>
            <th>Ubicación</th>
            <th>Páginas</th>
            <th>Idioma</th>
            <th>Palabras Clave</th>
            <th class="text-center"><?php if(isset($permissions)) { ?>Acción<?php } ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->docs->list($filters) as $r) { ?>
        <tr>
            <td><?php echo $r->code; ?></td>
            <td><?php echo $r->date; ?></td>
            <td><?php echo $r->title; ?></td>
            <td><?php echo $r->location; ?></td>
            <td><?php echo $r->pages; ?></td>
            <td><?php echo $r->lang; ?></td>
            <td><?php foreach(json_decode($r->keywords) as $p) { echo $p . ", "; } ?></td>
            <td class="text-right">
                <a class="btn btn-primary text-white m-1" style="cursor:pointer" data-toggle="tooltip" data-placement="top" href="?c=Docs&a=Detail&id=<?php echo $r->id; ?>" target="_blank" data-status="view" data-title="Ver Documento" title="Ver"><i class="fas fa-eye"></i></a>
                <?php if(isset($permissions)) { ?>
                <button type="button" class="btn btn-warning new m-1" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Editar"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger delete" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Delete"><i class="fas fa-trash"></i></button>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
$(".delete").on("click", function(e) {
    id = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Eliminar éste registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No',
        confirmButtonText: 'Sí',
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=Docs&a=Delete", { id }).done(function( res ) {
                location.reload();
            });
        }
    })
});

<?php if(!$this->docs->list($filters)) { ?>
    Swal.fire({
        title: 'No se encontraron Registros',
        icon: 'error',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No',
        confirmButtonText: 'Continuar',
        focusCancel: true
    })
<?php } ?>
</script>