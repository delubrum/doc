<table id="usersTable" class="table table-head-fixed table-striped table-hover" style="width:100%">
    <thead>
    <tr>
        <th class="bg-secondary">Name</th>
        <th class="bg-secondary text-right" style="width:5%">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if($id->users){	
    foreach(json_decode($id->users, true) as $r) {
    $r = $this->users->userGet($r); ?>
    <tr>
        <td><?php echo $r->username ?></td>
        <td><button type="button" class="btn btn-primary delete" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-project="<?php echo $id->id; ?>" title="Delete"><i class="fas fa-trash"></i></button></td>
    </tr>
    <?php }} ?>
    </tbody>
</table>

<script>


$(document).on("click", ".delete", function(e) {
    id = $(this).data("id");
    project = $(this).data("project");
    e.preventDefault();
    Swal.fire({
        title: 'Delete this user?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=Projects&a=UserDelete", { id,project }).done(function( res ) {
                $("#usersTable").load("?c=Projects&a=UserList&id=" + res.trim());
                $("#loading").hide();
            });
        }
    })
});
</script>