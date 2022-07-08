<header>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Pending Work Orders
                <b class="float-right ml-4">TOTAL WEIGHT: <?php $wtotal = round($this->wo->totalWeight()->total/2.20462); echo $wtotal ?> kg</b>
                <b class="float-right">TOTAL QUANTITY: <?php $ptotal = $this->wo->total()->total; echo $ptotal ?></b>
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
                        <th style="width:120px"></th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Weight (kg)</th>
                        <th class="text-center">Quantity (%)</th>
                        <th class="text-center">Weight (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totals=0; $weights=0; foreach ($array as $r) { ?>
                        <tr class="detail" style="cursor:pointer" data-id="<?php echo $r ?>">
                            <th><?php echo $r; ?></th>
                            <td class="text-center"><?php $total = count($this->wo->list(${$r})); echo $total ?></td>
                            <td class="text-center"><?php $weight = round($this->wo->weight(${$r})->total/2.20462); echo $weight ?></td>

                            <th class="text-center"><?php echo number_format((($total) / $ptotal)*100,1) ?> %</td>
                            <th class="text-center"><?php echo number_format((($weight) / $wtotal)*100,1) ?> %</td>


                        </tr>
                    <?php $totals+=$total; $weights+=$weight; } ?>
                    <tr class="bg-secondary">
                        <th>Total</th>
                        <th class="text-center"><?php echo $totals ?></td>
                        <th class="text-center"><?php echo $weights ?></td>

                        <th class="text-center"><?php echo number_format((($totals) / $ptotal)*100,1) ?> %</td>
                        <th class="text-center"><?php echo number_format((($weights) / $wtotal)*100,1) ?> %</td>


                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
$(".detail").on("click", function() {
    id = $(this).data('id');
    $.post( "?c=WorkOrders&a=PendingDetails", {id}).done(function( data ) {
        $('#xlModal').modal('toggle');
        $('#xlModal .modal-content').html(data);
    });
});
</script>