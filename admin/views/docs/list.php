<table id="example" class="display table-striped">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Fecha</th>
            <th>Título</th>
            <th>Ubicación</th>
            <th>Páginas</th>
            <th>Idioma</th>
            <th>Palabras Clave</th>
            <th class="text-right">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->docs->list($filters) as $r) { ?>
        <tr>
            <td><?php echo $r->code; ?></td>
            <td><?php echo $r->title; ?></td>
            <td><?php echo $r->date; ?></td>
            <td><?php echo $r->location; ?></td>
            <td><?php echo $r->pages; ?></td>
            <td><?php echo $r->lang; ?></td>
            <td><?php foreach(json_decode($r->keywords) as $p) { echo $p . ", "; } ?></td>
            </td>
            <td class="text-right">
                <a class="btn btn-primary text-white" style="cursor:pointer" data-toggle="tooltip" data-placement="top" href="?c=Docs&a=Detail&id=<?php echo $r->id; ?>" target="_blank" data-status="view" data-title="Ver Documento" title="Ver"><i class="fas fa-eye"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>