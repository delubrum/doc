<header>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="bom_form">
    <div class="modal-header">
        <h5 class="modal-title">New Bill Of Material</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-sm-12">
            <div class="form-group">
                <label>* Work Order:</label>
                <div class="input-group">
                    <select class="form-control select2" name="woId" style="width: 100%;" required>
                        <option value=''></option>
                        <?php foreach($this->wo->list(' and a.cancelledAt is null') as $r) { 
                            $users = json_decode($r->users, true);
                            if ($r->users and in_array($user->id, $users)) {
                        ?>     
                            <option value='<?php echo $r->id?>'><?php echo $r->designation?></option>
                        <?php }} ?>
                    </select>
                </div>
            </div>
        </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Next</button>
    </div>
</form>

<script>
$('.select2').select2()

$('#bom_form').on('submit', function(e) {
    e.preventDefault();
    if (document.getElementById("bom_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=BOM&a=Save", $( "#bom_form" ).serialize()).done(function(res) {
            var res = $.parseJSON(res);
            id = res.id;
            status = res.status;
            title = res.title;
            $.post( "?c=BOM&a=BOM", {id,status,title}).done(function( data ) {
                $('#xsModal').modal('toggle');
                $("#loading").hide();
                $('#xlModal').modal('toggle');
                $('#xlModal .modal-content').html(data);
                $( "#example" ).load(window.location.href + " #example" );                
            });
        });
    }
});
</script>