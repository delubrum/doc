<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Inventario</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card p-4">


            <table id="example" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoria</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($this->inventory->list() as $r) { ?>
                    <tr>
                        <td><?php echo $r->description ?></td>
                        <td><?php echo $r->name ?></td>
                        <td><?php echo $r->qty ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
</div>

<!-- ./wrapper -->
</div>
</body>

</html>

<script>
$(document).ready(function() {
    $('table').DataTable({
        "order": [],
        "scrollX": true,
        "lengthChange": false,
        "paginate": false

    });
});
</script>