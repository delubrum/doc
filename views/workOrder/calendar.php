<header>
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Sigma | Machine Calendar</title>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href='assets/plugins/fullcalendar/main.css' rel='stylesheet' />
    <script src='assets/plugins/fullcalendar/main.js'></script>
    <script src="assets/plugins/moment/moment.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
    <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <script src="assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/css/calendar.css">

</header>

<div id="loading"></div>


    <!-- Modals -->
    <div class="modal fade" id="xlModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="lgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="defModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="xsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

<div class="row p-2">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="input-group">
                <select class="col-12 p-2 text-center h5" id="machinesList">
                <?php foreach($this->machines->MachinesList() as $r) { ?>
                <option value="<?php echo $r->id?>" <?php echo ($r->id == $machineId) ? 'selected' : '' ?>><?php echo $r->title?></option>
                <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content" >
    <div class="container-fluid">
        <div class="row">
            <div class="bg-white p-2 col-sm-12" id='calendar' style="max-height:80vh">
            </div>
        </div>
    </div>
</div>

</body>

</html>

<script>
var calendar; //global variable

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        slotDuration: '00:10',
        <?php if ($this->users->permissionGet($user->id,4) or $this->users->permissionGet($user->id,5)) { ?>
        eventClick: function(info) {
            EventClicked(info.event.id);
        },
        <?php } ?>
        <?php if ($this->users->permissionGet($user->id,4)) { ?>
        eventDrop: function(info) {
            start = info.event.start.toISOString().slice(0, 19).replace('T', ' ');
            end = info.event.end.toISOString().slice(0, 19).replace('T', ' ');         
            var resourceId = <?php echo $machineId?>;
            EventUpdate(info.event.id,start,end,resourceId,info);
        },
        eventResize: function(info) {
            start = info.event.start.toISOString().slice(0, 19).replace('T', ' ');
            end = info.event.end.toISOString().slice(0, 19).replace('T', ' ');
            var resourceId = <?php echo $machineId?>;
            EventUpdate(info.event.id,start,end,resourceId,info);
        },
        <?php } ?>
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        initialView: '<?php echo $view ?>',
        initialDate: '<?php echo $date ?>',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: <?php echo ($this->users->permissionGet($user->id,4)) ? 'true' : 'false' ?>,
        events: '?c=Events&a=EventsList&id=<?php echo $machineId?>'
    });
    calendar.render();
});

function EventClicked(id){
    $("#xlModal").modal('show');
    $.post( "?c=Events&a=EventGet", { id }).done(function( data ) {
        $('#xlModal .modal-content').html(data);
        Datepicker();
    });
}

$(document).on('change','#machinesList', function() {
    var machineId = $(this).val();
    var view = calendar.view.type;
    var date = calendar.view.currentStart.toISOString().slice(0, 10);
    location.href='?c=WorkOrders&a=CalendarByMachine&id=' + machineId + '&view=' + view + '&date=' + date;
});

function EventUpdate(id,start,end,resourceId,info){
    $.post( "?c=Events&a=EventUpdate", { id,start,end,resourceId }).done(function( data ) {
        if(data.trim() == 'error') {
            toastr.error('Error'),
            info.revert();
        } else {
            toastr.success('Success')
        }
    });
}

function Datepicker() {
    $('.reservationtime').daterangepicker({
        autoUpdateInput: false,
        timePicker: true,
        timePickerIncrement: 10,
        drops: 'up',
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

setInterval(function() {
    calendar.refetchEvents()
}, 5000);

$(document).on('submit','#eventInfo_form', function(e) {
    e.preventDefault();
    if (document.getElementById("eventInfo_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Events&a=EventUpdate", $( "#eventInfo_form" ).serialize()).done(function( data ) {
            location.reload();
        });
    }
});

$(document).on('click','.btnremove', function() {
    $(this).closest('.remove').remove();
});

function get_elapsed_time_string(total_seconds) {
  function pretty_time_string(num) {
    return ( num < 10 ? "0" : "" ) + num;
  }
  var hours = Math.floor(total_seconds / 3600);
  total_seconds = total_seconds % 3600;
  var minutes = Math.floor(total_seconds / 60);
  total_seconds = total_seconds % 60;
  var seconds = Math.floor(total_seconds);
  hours = pretty_time_string(hours);
  minutes = pretty_time_string(minutes);
  seconds = pretty_time_string(seconds);
  var currentTimeString = hours + ":" + minutes + ":" + seconds;
  return currentTimeString;
}

$(document).on('click','#eventStart', function() {
    link = $(this);
    eventId = $(this).data("id");
    div = `
        <button type="button" class="btn btn-info" data-id="${eventId}" id="eventStop">Stop</button>
        <button type="button" class="btn btn-info" data-id="${eventId}" id="eventFinish">Finish</button>
    `;
    $("#loading").show();
    $.post( "?c=Events&a=EventStart" , { eventId }).done(function( data ) {
        $("#loading").hide();
        link.parent().html(div);
        var elapsed_seconds = parseInt(data.trim());
        setInterval(function() {
            elapsed_seconds = elapsed_seconds + 1;
            $('#eventTimer').text(get_elapsed_time_string(elapsed_seconds));
        }, 1000);
    });
});

$(document).on('submit','#eventStop_form', function(e) {
    e.preventDefault();
    $("#loading").show();
    $.post( "?c=Events&a=EventStop", $( "#eventStop_form" ).serialize()).done(function( data ) {
        location.reload();
    });
});

$(document).on('click','#eventFinish', function(e) {
    eventId = $(this).data("id");
    e.preventDefault();
    Swal.fire({
        title: 'Finish?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").fadeIn();
            $.post("?c=Events&a=EventFinish", { eventId }).done(function( data ) {
                location.reload();
            });
        }
    })
});
</script>