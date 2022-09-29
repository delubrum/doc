<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary float-right new">
                    <i class="fas fa-plus"></i> Nuevo
                </button>
                <button type="button" class="btn btn-primary float-right noprint mr-2 tickets">
                    <i class="fas fa-print"></i> Imprimir Selección
                </button>

                <h1 class="m-0 text-dark">Productos</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card p-4 listTable">
            <?php require_once 'list.php' ?>        
        </div>
    </div>
</div>
</div>
</div>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "scrollX" : true,
        "autoWidth": false
    });
});

$(".new").on("click", function() {
    id = $(this).data('id');
    $.post( "?c=Products&a=New", { id }).done(function( data ) {
        $('#xsModal').modal('toggle');
        $('#xsModal .modal-content').html(data);
    });
});

$(document).on('submit', '#Products_Form', function(e) {
    e.preventDefault();
    if (document.getElementById("Products_Form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Products&a=Save", $("#Products_Form").serialize()).done(function(res) {
            location.reload();
        });
    }
});


$('.active').change(function() {
    id = $(this).data("id");
    if (!this.checked) {
        val = 0
    } else {
        val = 1
    }
    $.post("?c=Products&a=Active", {
        id: id,
        val: val
    });
});

$(".tickets").click(function(){
    var array = $("input[name=checkid]").map(function(){return $(this).val()}).get();
    var arrayb = $("input[name=checkid]").map(function(){return $(this).data('id')}).get();
    if(arrayb.length != 0) {
        $("#loading").show();
        $.post('?c=Products&a=Barcodes', {'id[]': arrayb, 'val[]': array }, function (data) {
            var w = window.open('about:blank');
            w.document.open();
            w.document.write(data);
            w.document.close();
            $("#loading").hide();
        });
    }
});
</script>