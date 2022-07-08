<header>
    <link href='assets/plugins/fullcalendar/main.css' rel='stylesheet' />
    <script src='assets/plugins/fullcalendar/main.js'></script>
    <script src="assets/plugins/moment/moment.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
    <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
    <style>
        body {overflow:hidden}
        .btn-group .btn {cursor: pointer}
    </style>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
                <input class="form-control" id="search" type="search" placeholder="Search" aria-label="Search">
            </div>

            <div class="col-sm-10">
                <button type="button" class="btn btn-primary float-right new">
                    <i class="fas fa-plus"></i> New
                </button>
            </div>

        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content" >
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 overflow-auto bg-white p-1" style="max-height:80vh">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu">
                    <?php foreach($this->model->workOrdersList($filters) as $r) { 
                        if ($this->model->workOrdersItemsList($r->id)) {?>
                    <li class="nav-item has-treeview link">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-industry"></i> <?php echo $r->designation ?> <i class="right fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                        <?php foreach($this->model->workOrdersItemsList($r->id) as $p) { ?>
                            <li class="nav-item wo" data-id="<?php echo $p->ID ?>">
                                <a href="#" class="nav-link" >
                                    <i class="fas fa-puzzle-piece"></i> <?php echo $p->number ?>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>
                    <?php }} ?>
                </ul>
            </div>

            <div class="bg-white p-2 col-sm-10" id='calendar' style="max-height:80vh">
            </div>
        </div>
    </div>
</div>

</body>

</html>

<script>
$(document).on("click", ".wo", function() {
    id = $(this).data('id');
    $.post( "?c=WorkOrders&a=WorkOrderItemGet", { id }).done(function( data ) {
        $('#xlModal').modal('toggle');
        $('#xlModal .modal-content').html(data);
        Datepicker('up');
    });
});

$(document).on("click", ".new", function() {
    $.post( "?c=WorkOrders&a=newEvent").done(function( data ) {
        $('#xsModal').modal('toggle');
        $('#xsModal .modal-content').html(data);
    });
});

$(document).on("click", ".eventNew", function() {
    Datepicker();
});

var calendar; //global variable

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        slotDuration: '00:10',
        eventClick: function(info) {
            EventClicked(info.event.id);
        },
        eventDrop: function(info) {
            start = info.event.start.toISOString().slice(0, 19).replace('T', ' ');
            end = info.event.end.toISOString().slice(0, 19).replace('T', ' ');
            var infoResources = info.event.getResources();                
            var resourceId = infoResources[0]._resource.id;
            EventUpdate(info.event.id,start,end,resourceId,info);
        },
        eventResize: function(info) {
            start = info.event.start.toISOString().slice(0, 19).replace('T', ' ');
            end = info.event.end.toISOString().slice(0, 19).replace('T', ' ');
            var infoResources = info.event.getResources();                
            var resourceId = infoResources[0]._resource.id;
            EventUpdate(info.event.id,start,end,resourceId,info);
        },
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        initialView: 'resourceTimelineDay',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
        },
        editable: true,
        resourceAreaHeaderContent: 'Machines',
        resourceOrder: 'title',
        resources: '?c=Machines&a=MachinesList',
        events: '?c=Events&a=EventsList'
    });
    calendar.render();
    setInterval(function() {
        calendar.refetchEvents()
    }, 5000);
});



function EventClicked(id){
    $("#xlModal").modal('show');
    $.post( "?c=Events&a=EventGet", { id }).done(function( data ) {
        $('#xlModal .modal-content').html(data);
        Datepicker('down');
    });
}

function EventUpdate(id,start,end,resourceId,info){
    $.post( "?c=Events&a=EventUpdate", { id,start,end,resourceId }).done(function( data ) {
        if(data.trim() == 'error') {
            toastr.error('Error'),
            info.revert();
        } else  if(data.trim() == 'machine_error'){
            toastr.warning('The machine does not allow this process');
            info.revert();
        } else {
            toastr.success('Success')
        }
    });
}

$(document).on("input", "#search", function() {
    var texto = $(this).val();
    var tarjetas = $(".link");
    texto = texto.toLowerCase();
    tarjetas.show();
    for(var i=0; i< tarjetas.length; i++){
        var contenido = tarjetas.eq(i).text();
        contenido = contenido.toLowerCase();
        var index = contenido.indexOf(texto);
        if(index == -1){
            tarjetas.eq(i).hide();
        }
    }
});

function Datepicker(drops) {
    $('.reservationtime').daterangepicker({
        autoUpdateInput: false,
        timePicker: true,
        timePickerIncrement: 10,
        drops: drops,
        opens: 'center',
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
        }      
    })

    $('.reservationtime').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.reservationtime').on('focusout', function () {
        $(this).val('');
    });

    $('.reservationtime').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
}

$(document).on('click','.process', function() {
    process = $(this).html();
    $(this).toggleClass('btn-primary btn-secondary active');
    if ($(this).hasClass("btn-secondary")) {
        $( ".process_"+process ).remove();
    } else {
        $.post( "?c=Machines&a=AddProcess", { process }).done(function( data ) {
            $('#machines').append(data);
            Datepicker('up');
        });
    }
});

$(document).on('click','.add_machine', function() {
    process = $(this).data("id");
    $.post( "?c=Machines&a=AddMachine", { process }).done(function( data ) {
        $(".process_"+process).append(data);
        Datepicker('up');
    });
});

$(document).on('click','.btnremove', function() {
    $(this).closest('.remove').remove();
});

$(document).on('submit','#partNumber_form', function(e) {
    e.preventDefault();
    if (document.getElementById("partNumber_form").checkValidity()) {
        var arr = [];
        $(".processName").each(function() {
            process = $(this).val();
            qty = $("#totalQty").html();
            sum = 0;
            $(".qty_"+process).each(function() {
                sum += parseInt($(this).val());
            });
            if (parseInt(sum) != parseInt(qty)) {
                arr.push(process + " quantity is wrong");
            }
        });
        if(arr.length != 0){
        arr.forEach(function(item){
            toastr.error(item);
        });
        } else {
            if($(".processName").length === 0){
                toastr.error('add at least one process');
            } else {
                // var prevStart;
                // var prevEnd;
                // var sumDates = 0;
                // $(".reservationtime").each(function() {
                //     date = $(this).val().split(" - ");
                //     start = new Date(date[0]);
                //     end = new Date(date[1]);
                //     if(start < prevEnd) {
                //         sumDates++;
                //     }
                //     prevStart = new Date(start);
                //     prevEnd = new Date(end);
                // });
                // if(sumDates == 0) {
                    $("#loading").show();
                    $.post( "?c=Events&a=EventSave", $( "#partNumber_form" ).serialize()).done(function( data ) {
                        location.reload();
                    });
                // } else {
                //     toastr.error('Process schedule order is wrong');
                // }
            }
        }
    }
});

$(document).on("change", "#eventType", function() {
    $('#newEvent').toggle();
    $('#newpartNumber').toggle();
});
</script>

