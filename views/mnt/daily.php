<header>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Daily Services</h1>   
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Filters</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" style="margin-top:0px;">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=MNT&a=Daily">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>From:</label>
                                <input type="date" class="form-control" name="from" value="<?php echo isset($_REQUEST['from']) ? $_REQUEST['from'] : "$mon" ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>To:</label>
                                <input type="date" class="form-control" name="to" value="<?php echo isset($_REQUEST['to']) ? $_REQUEST['to'] : "$sun" ?>" required>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-2 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                    <h3><?php echo $total ?></h3>
                    <p>Total</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div> 
            <div class="col-lg-2 col-6">
                <div class="small-box" style="background:#64acf9;color:white">
                    <div class="inner">
                    <h3><?php echo $average ?></h3>
                    <p>Average</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-gray-dark">
                    <div class="inner">
                    <h3><?php echo $endtotal ?></h3>
                    <p>Attended</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-gray">
                    <div class="inner">
                    <h3><?php echo $externaltotal ?></h3>
                    <p>External</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div> 
            <div class="col-lg-2 col-6">
                <div class="small-box bg-olive">
                    <div class="inner">
                    <h3><?php echo $endaverage ?></h3>
                    <p>Attended Average</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div> 
            
            <div class="col-lg-2 col-6">
                <div class="small-box bg-olive">
                    <div class="inner">
                    <h3><?php echo $rating ?></h3>
                    <p>Rating Average</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div> 

            <div class="col-lg-4 col-6 indicator" data-id="1">
            <?php $value = round($endtotal / $total * 100,2) ?>
                <div class="small-box 
                <?php
                switch (true) {
                    case ($value >= 0 and $value <= 40):
                        echo "bg-danger";
                        break;
                    case ($value > 40 and $value <= 80):
                        echo "bg-warning";
                        break;
                    case ($value > 80 and $value <= 100):
                        echo "bg-success";
                        break;
                }
                ?>
                ">
                    <div class="inner">
                    <h3><?php echo $value ?> %</h3>
                    <p>Attended / Total</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div> 

            <div class="col-lg-4 col-6 indicator" data-id="2">
            <?php $value = round(($total-$endtotal) / $total * 100, 2) ?>
                <div class="small-box 
                <?php
                switch (true) {
                    case ($value > 80 and $value <= 100):
                        echo "bg-danger";
                        break;
                    case ($value > 40 and $value <= 80):
                        echo "bg-warning";
                        break;
                    case ($value >= 0 and $value <= 40):
                        echo "bg-success";
                        break;
                }
                ?>
                ">
                    <div class="inner">
                    <h3><?php echo $value ?> %</h3>
                    <p>Opened / Total</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div> 

            <div class="col-lg-4 col-6 indicator" data-id="3">
            <?php $value = round(($externaltotal) / $total * 100, 2) ?>
                <div class="small-box 
                <?php
                switch (true) {
                    case ($value > 60 and $value <= 100):
                        echo "bg-danger";
                        break;
                    case ($value > 20 and $value <= 60):
                        echo "bg-warning";
                        break;
                    case ($value >= 0 and $value <= 20):
                        echo "bg-success";
                        break;
                }
                ?>
                ">
                    <div class="inner">
                    <h3><?php echo $value ?> %</h3>
                    <p>External / Total</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ticket-alt"></i>
                    </div>
                </div>    
            </div> 

        </div>
        
        <div class="card p-4">
            <div id="chart" style="height:300px"></div>
        </div>
    </div>
</div>
</div>
</div>

<script>
const chart = Highcharts.chart('chart', {

    title: {
        text: ''
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    xAxis: {
        categories: <?php echo $axis ?>             
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    series: [
    {
        name: 'Services',
        data: <?php echo $totals; ?> 
    },
    {
        name: 'Attended',
        data: <?php echo $endtotals; ?> 
    },
    {
        name: 'External',
        data: <?php echo $externaltotals; ?> 
    },
    {
        name: 'Pending',
        data: <?php echo $pendingtotals; ?> 
    },
    ]
});

$(document).on('click', '.indicator', function() {
    id = $(this).data('id');
    $.post( "?c=Init&a=Indicator", { id }).done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});
</script>