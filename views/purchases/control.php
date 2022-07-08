<style>
    body {
        width:2000px;
        padding:10px;
    }
    .placeholder {
    border: 1px dotted gray;
    height: 25px;
    margin:5px;
  }
</style>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

<div class="row">
    <div class="btn btn-primary m-1">
        Material
    </div>
    <div class="btn btn-info m-1">
        Service
    </div>
</div>

<?php
$items=""; foreach($this->users->usersList() as $r) {
    $userPermissions = json_decode($this->users->permissionsGet($r->id)->permissions); 
    if (in_array(13, $userPermissions)) {
    $items = $items . "#items" . $r->id . ",";
?>

<div class="row">
<div class="items float-left bg-white card m-2 p-2">
    <div class="h5 text-center p-1">
        <?php echo $r->username;?>
    </div>
    <p>
        <span class="float-left">Pricing Purchases : <?php echo count($this->purchases->purchasesList(" and purchasedAt is null and quoterId = $r->id and cancelledAt is null and sentAt is not null and quotedAt is null")) ?></span>
        <br>
        <span class="float-left"></span>Pricing Items : <?php echo count($this->purchases->ItemsList(" and purchasedAt is null and quoterId = $r->id and cancelledAt is null and sentAt is not null and quotedAt is null")) ?></span>
    </p>

    <div id="items<?php echo $r->id;?>" data-id="<?php echo $r->id;?>" class="connectedSortable">
        <?php foreach($this->purchases->purchasesList(" and purchasedAt is null and quoterId = $r->id and cancelledAt is null and sentAt is not null and quotedAt is null") as $p) { ?>
        <div id="<?php echo $p->id; ?>" class="card bg-<?php echo ($p->type == 'Material') ? 'primary' : 'info' ?> p-1 m-1 purchaseAction" data-status="view" data-title="View Purchase" data-id="<?php echo $p->id; ?>" style="cursor:pointer">
            <?php echo $p->id; ?> - <?php echo $p->projectName ?>
        </div>
        <?php } ?>
        <?php foreach($this->purchases->purchasesList(" and purchasedAt is null and quoterId = $r->id and cancelledAt is null and sentAt is not null and approvedAt is not null") as $p) { ?>
        <div id="<?php echo $p->id; ?>" class="card bg-<?php echo ($p->type == 'Material') ? 'primary' : 'info' ?> p-1 m-1 purchaseAction" data-status="view" data-title="View Purchase" data-id="<?php echo $p->id; ?>" style="cursor:pointer">
            <?php echo $p->id; ?> - <?php echo $p->projectName ?> <?php echo ($p->quotedAt) ? "<b class='text-dark'>(PURCHASING)</b>" : "" ?>
        </div>
        <?php } ?>
    </div>
</div>
<?php }} 
$items=substr($items, 0, -1);
?>

<script>
$(function() {
    $("<?php echo $items;?>").sortable({
        connectWith: ".connectedSortable",
        placeholder: "placeholder",
        update: function( event, ui ) {
            purchase = ui.item.attr("id");
            user =  ui.item.parent().data("id");
            $("#loading").show();
            $.post( "?c=Purchases&a=ControlUpdate", { purchase,user }).done(function( data ) {
                location.reload();
            });
        }

    }).disableSelection();
});
</script>