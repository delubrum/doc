<div class="modal-header">
  <h5 class="modal-title">New Reserve</b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table id="list" class="display table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Description</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($this->reserve->data() as $r) { ?>
            <tr>
                <td><?php echo $r->id; ?></td>
                <td><?php echo $r->description; ?></td>
                <td class="text-right">
                    <button type="button" class="btn btn-primary reserve" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Reserve"><i class="fas fa-hand-point-up"></i></button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    var table = $('#list').DataTable({
        "search": {
            "smart": false
        },
        "order": [],
        "lengthChange": false,
        "paginate": false,
        "scrollX" : true,
        "autoWidth": false
    });
    setTimeout( function(){ 
        table.draw()
    }  , 200 );
});
</script>