<table id="itemsTable" class="table table-head-fixed table-striped table-hover" style="width:100%">
    <thead>
        <tr>
            <th style="width:5% !important">Item</th>
            <th>Date</th>
            <th>Part Number</th>
            <th>Part</th>
            <th>Material</th>
            <th>Description</th>
            <th>User</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($this->pn->List($id->id) as $r) { ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $r->createdAt ?></td>
            <td><?php echo $r->name ?></td>
            <td><?php echo $r->partname ?></td>
            <td>
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control material" <?php echo ($r->userId != $user->id) ? 'disabled' : '' ?> data-id="<?php echo $r->id; ?>">
                            <option value=''></option>
                            <?php foreach($this->pn->materialList() as $m) { ?>
                                <option value='<?php echo $m->id?>' <?php echo ($r->material == $m->id) ? 'selected' : '' ;?>><?php echo $m->name?></option>
                            <?php } ?>
                        </select>                
                    </div>
                </div>    
            </td>
            <td><textarea style="width:100%" class="description" data-id="<?php echo $r->id; ?>"  <?php echo ($r->userId != $user->id) ? 'disabled' : '' ?>><?php echo htmlentities(stripslashes($r->description)) ?></textarea></td>
            <td><?php echo $r->username ?></td>
            <td class="text-right">
                <button type="button" class="btn btn-primary copy" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" data-project="<?php echo $r->projectId; ?>" title="Copy"><i class="fas fa-copy"></i></button>
                <?php if($r->userId == $user->id) { ?> <button type="button" class="btn btn-primary delete" data-toggle="tooltip" data-placement="top" data-status='process' data-id="<?php echo $r->id; ?>" data-project="<?php echo $r->projectId; ?>" title="Delete"><i class="fas fa-trash"></i></button> <?php } ?>
            </td>
        </tr>
    <?php $i++; } ?>
    </tbody>
</table>
<script>
$(document).on("click", ".delete", function(e) {
    id = $(this).data("id");
    project = $(this).data("project");
    e.preventDefault();
    Swal.fire({
        title: 'Delete this item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").show();
            $.post("?c=PartNumbers&a=Delete", { id,project }).done(function( res ) {
                $("#itemsTable").load("?c=PartNumbers&a=List&id=" + res.trim());
                $("#loading").hide();
            });
        }
    })
});

$(document).on("click", ".copy", function(e) {
  id = $(this).data('id');
  project = $(this).data('project');
  $.post( "?c=PartNumbers&a=Add", { id,project }).done(function( data ) {
      $('#xsModal').modal('toggle');
      $('#xsModal .modal-content').html(data);
  });
});

$(document).on("change", ".material", function(e) {
    id = $(this).data('id');
    material = $(this).val();
    $("#loading").show();
    $.post( "?c=PartNumbers&a=Update", { id,material }).done(function( data ) {
        $("#loading").hide();
    });
});

$(document).on("blur", ".description", function(e) {
    id = $(this).data('id');
    description = $(this).val();
    $("#loading").show();
    $.post( "?c=PartNumbers&a=Update", { id,description }).done(function( data ) {
        $("#loading").hide();
    });
});
</script>