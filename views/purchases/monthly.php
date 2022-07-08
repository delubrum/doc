<header>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">
                    Monthly Purchases
                    <a href="?c=Purchases&a=Monthly" class="btn btn-primary float-right ml-2">Monthly</a>
                    <a href="?c=Purchases&a=Daily" class="btn btn-primary float-right">Daily</a>
                </h1> 
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
                <form method="post" autocomplete="off" enctype="multipart/form-data" action="?c=Purchases&a=Monthly">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Year:</label>
                                <input class="form-control" name="year" value="<?php echo isset($_REQUEST['year']) ? $_REQUEST['year'] : "$year" ?>" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
        </div>

        <div class=row>
     
        <div class="col-lg-2 col-6 offset-xl-1">
                <div class="small-box bg-primary">
                    <div class="inner">
                    <h3><?php echo $total ?></h3>
                    <p>Period Total</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>    
            </div> 
            <div class="col-lg-2 col-6">
                <div class="small-box" style="background:#64acf9;color:white">
                    <div class="inner">
                    <h3><?php echo $average ?></h3>
                    <p>Period Average</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>    
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-gray-dark">
                    <div class="inner">
                    <h3><?php echo $itemTotal ?></h3>
                    <p>Period Item Total</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>    
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-gray">
                    <div class="inner">
                    <h3><?php echo $itemAverage ?></h3>
                    <p>Period Item Average</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>    
            </div> 
            <div class="col-lg-2 col-6">
                <div class="small-box bg-olive">
                    <div class="inner">
                    <h3><?php echo $totalAverage ?></h3>
                    <p>Period Item Av. / Purchase</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
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
    colors: ['#007bff', '#007bff9c'],

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
        name: 'Purchases',
        data: <?php echo $totals; ?> 
    },
    {
        name: 'Items',
        data: <?php echo $itemTotals; ?> 
    },
    ]
});
</script>