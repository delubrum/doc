<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script> -->
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary float-right new">
                    <i class="fas fa-plus"></i> New
                </button>
                <h1 class="m-0 text-dark">Roles</h1>
                
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card p-4 listTable">
            <?php require_once 'roles_row.php' ?>        
        </div>
    </div>
</div>
</div>
</div>

<script>

$(document).on("click", ".new", function() {
    id = $(this).data('id');
    $.post( "?c=Users&a=RolesForm", { id }).done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});

$(document).on('click','.permission', function() {
	id = $(this).data('id');
	div = `<input type='hidden' name='permissions[]' value='${id}'>`;
    $(this).toggleClass('btn-primary btn-secondary active');
	if ($(this).hasClass("btn-secondary")) {
		$(this).find('input').remove();
    } else {
		$(this).append(div).val(id);
    }
});

$(document).ready(function() {
    $('table').DataTable({
        "lengthChange": false,
        "paginate": false,
        // rowReorder: true,
    });
});

$(document).on('submit','#roleNew_form', function(e) {
    e.preventDefault();
    if (document.getElementById("roleNew_form").checkValidity()) {
        if ($(".active").length == 1) {
            toastr.error('Select at least one permission');   
        } else {
            $("#loading").show();
            $.post( "?c=Users&a=RolePermissionsSave", $("#roleNew_form").serialize()).done(function( id ) {
                location.reload();
            });
        }
    }
});
</script>