<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Part Numbers</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card p-4 listTable">
            <?php require_once 'project_list_row.php' ?>        
        </div>
    </div>
</div>
</div>
</div>

<script>
$(document).ready(function() {
    $('#listTable').DataTable({
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "responsive" : true
    });
});

$(document).on("click", ".edit", function() {
    id = $(this).data('id');
    $.post( "?c=PartNumbers&a=Edit", {id}).done(function( data ) {
        $('#xlModal').modal('toggle');
        $('#xlModal .modal-content').html(data);
        $('#xlModal #itemsTable').DataTable({
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "responsive" : true
    });
    });
});

$(document).on('submit', '#partNumber_form', function(e) {
    e.preventDefault();
    if (document.getElementById("partNumber_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=PartNumbers&a=Save", $( "#partNumber_form" ).serialize()).done(function(res) {
            $("#loading").hide();
            $("#itemsTable").load("?c=PartNumbers&a=List&id=" + res.trim());        
        });
    }
});
</script>