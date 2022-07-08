<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Pending Purchases
                <b class="float-right">TOTAL : <?php $ptotal = $this->purchases->total()->total; echo $ptotal ?></b>
                </h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="card">
            <table id="example" class="table table-hover" style="width:100%">
                <thead>
                    <tr class="bg-primary">
                        <th style="width:120px">USERS</th>
                        <th class="text-center">Services</th>
                        <th class="text-center">Materials</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($arrayp as $r) { ?>
                        <tr class="detail" style="cursor:pointer" data-id="<?php echo $r ?>">
                            <th><?php echo $r; ?></th>
                            <td class="text-center"><?php $service = count($this->purchases->purchasesList(${$r} . "'Service'")); echo $service ?></td>
                            <td class="text-center"><?php $material = count($this->purchases->purchasesList(${$r} . "'Material'")); echo $material?></td>
                            <th class="text-center"><?php echo $material + $service ?></td>
                            <th class="text-center"><?php echo number_format((($material + $service) / $ptotal)*100,1) ?> %</td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <table id="example" class="table table-hover" style="width:100%">
                <thead>
                    <tr class="bg-primary">
                        <th style="width:120px">PURCHASES</th>
                        <th class="text-center">Services</th>
                        <th class="text-center">Materials</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $services = 0; $materials = 0; foreach ($array as $r) { ?>
                        <tr class="detail" style="cursor:pointer" data-id="<?php echo $r ?>">
                            <th><?php echo $r; ?></th>
                            <td class="text-center"><?php $service = count($this->purchases->purchasesList(${$r} . "'Service'")); echo $service ?></td>
                            <td class="text-center"><?php $material = count($this->purchases->purchasesList(${$r} . "'Material'")); echo $material?></td>
                            <th class="text-center"><?php echo $material + $service ?></td>
                            <th class="text-center"><?php echo number_format((($material + $service) / $ptotal)*100,1) ?> %</td>

                        </tr>
                    <?php $services+=$service; $materials+=$material; } ?>
                    <tr class="bg-secondary">
                        <th>Total</th>
                        <th class="text-center"><?php echo $services ?></td>
                        <th class="text-center"><?php echo $materials ?></td>
                        <th class="text-center"><?php echo $materials + $services ?></td>
                        <th class="text-center"><?php echo number_format((($materials + $services) / $ptotal)*100,1) ?> %</td>

                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <table id="example" class="table table-hover" style="width:100%">
                <thead>
                    <tr class="bg-primary">
                        <th style="width:120px">STOCK</th>
                        <th class="text-center">Services</th>
                        <th class="text-center">Materials</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($arrayb as $r) { ?>
                        <tr class="detail" style="cursor:pointer" data-id="<?php echo $r ?>">
                            <th><?php echo $r; ?></th>
                            <td class="text-center"><?php $service = count($this->purchases->purchasesList(${$r} . "'Service'")); echo $service ?></th>
                            <td class="text-center"><?php $material = count($this->purchases->purchasesList(${$r} . "'Material'")); echo $material?></th>
                            <th class="text-center"><?php echo $material + $service ?></td>
                            <th class="text-center"><?php echo number_format((($material + $service) / $ptotal)*100,1) ?> %</th>
                        </tr>
                        <?php } ?>
                        <?php $itemsservice = 0;  $itemsmaterial = 0; foreach ($arrayd as $r) { ?>
                        <tr data-id="<?php echo $r ?>">
                            <th><?php echo $r; ?></th>
                            <td class="text-center"><?php $service = count($this->purchases->ItemsList(${$r} . "'Service'")); echo $service ?></td>
                            <td class="text-center"><?php $material = count($this->purchases->ItemsList(${$r} . "'Material'")); echo $material?></td>
                            <th class="text-center"><?php echo $material + $service ?></th>
                            <th></th>
                        </tr>
                        
                        <?php foreach($this->purchases->ItemsList(${$r} . "'Service'") as $a) {
                                $prev = ($this->purchases->deliverSum($a->id)->total == '') ? 0 : $this->purchases->deliverSum($a->id)->total;
                            if ($a->partial != 0) {
                              $partial = $a->partial + $prev;
                            } else {
                              $partial = $prev;
                            }
                            if  ($partial < $a->qty) {
                                $itemsservice ++;
                            }
                        }
                        ?>

                        <?php foreach($this->purchases->ItemsList(${$r} . "'Material'") as $b) {
                            $prev = ($this->purchases->deliverSum($b->id)->total == '') ? 0 : $this->purchases->deliverSum($b->id)->total;
                            if ($b->partial != 0) {
                              $partial = $b->partial + $prev;
                            } else {
                              $partial = $prev;
                            }
                            if  ($partial >= $b->qty) {
                                

                                $itemsmaterial ++;
                            }
                        }
                        ?>
                        <?php } ?>
                        </tr>
                        <tr>
                            <th>ReceivingItems</th>
                            <td class="text-center"><?php echo $itemsservice ?></td>
                            <td class="text-center"><?php echo $itemsmaterial?></td>
                            <th class="text-center"><?php echo $itemsmaterial + $itemsservice ?></td>
                            <th></th>
                        </tr>

                </tbody>
            </table> 
        </div>
  

        <div class="card">
            <table id="example" class="table table-hover" style="width:100%">
                    <thead>
                        <tr class="bg-primary">
                            <th style="width:120px"></th>
                            <th class="text-center">Services</th>
                            <th class="text-center">Materials</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($arrayc as $r) { ?>
                            <tr class="detail" style="cursor:pointer" data-id="<?php echo $r ?>">
                                <th><?php echo $r; ?></th>
                                <td class="text-center"><?php $service = count($this->purchases->purchasesList(${$r} . "'Service'")); echo $service ?></td>
                                <td class="text-center"><?php $material = count($this->purchases->purchasesList(${$r} . "'Material'")); echo $material?></td>
                                <th class="text-center"><?php echo $material + $service ?></td>
                                <th class="text-center"><?php echo number_format((($material + $service) / $ptotal)*100,1) ?> %</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>

<script>
$(".detail").on("click", function() {
    id = $(this).data('id');
    $("#loading").show();
    $.post( "?c=Purchases&a=PendingDetails", {id}).done(function( data ) {
        $("#loading").hide();
        $('#xlModal').modal('show');
        $('#xlModal .modal-content').html(data);
    });
});
</script>