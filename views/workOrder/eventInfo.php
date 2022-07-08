
<form method="post" id="eventInfo_form">
  <div class="modal-header">
  <h5 class="modal-title"><b>Schedule: </b><?php echo isset($wo_item->number) ? $wo_item->number  . " / " . $event->process : $event->title;  ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <?php if ($event->partNumberId) { ?>
    <div class="row">
      <div class="col-sm-4">
        <dl>
          <dt><i class="fas fa-industry"></i> WO:</dt>
          <dd><?php echo $wo->designation ?></dd>
          <dt><i class="fas fa-clipboard-list"></i> PROJECT:</dt>
          <dd><?php echo $wo->projectName ?></dd>
          <dt><i class="fas fa-bullseye"></i> SCOPE:</dt>
          <dd><?php echo htmlentities(stripslashes($wo->scope)) ?></dd>
          <dt><i class="fas fa-edit"></i> DESCRIPTION:</dt>
          <dd><?php echo stripslashes($wo_item->name) ?></dd>
        </dl>
      </div>
      <div class="col-sm-4">
        <dl>
          <dt><i class="fas fa-weight-hanging"></i> WEIGHT:</dt>
          <dd><?php echo $wo_item->weight . " " . $wo_item->uom ?></dd>
          <dt><i class="fas fa-paint-brush"></i> PAINTING AREA:</dt>
          <dd><?php echo $wo_item->pa . " " . $wo_item->pauom ?></dd>
          <dt><i class="fas fa-paint-roller"></i> FINISH & UC CODE:</dt>
          <dd><?php echo $wo_item->finish ?></dd>
          <dt><i class="fas fa-hashtag"></i> PIECES OF THIS ITEM: </dt>
          <dd><b>Total:</b> <?php echo $wo_item->qty ?>
          <br>
          <b>Scheduled:</b> <?php echo $event->qty ?>
          <br>
          <b>Finished:</b> <?php echo $event->partial ?>
        </dl>
      </div>
      <div class="col-sm-4">
        <dl>
          <dt><i class="fas fa-file"></i> FILES:</dt>
          <dd>
          <b>DXF:</b>
          <?php
          $directorio = "../sigma/uploads/WO/DXF/$wo_item->wo/";
          if (file_exists($directorio)) {
            if ($gestor = opendir($directorio)) {
              $list=array();
              while (false !== ($arch = readdir($gestor))) { 
                if ($arch != "." && $arch != "..") {
                  $list[]=$arch; 
                } 
              }
              sort($list, SORT_NUMERIC);
              foreach($list as $fileName) {
                if (substr($fileName, 0, -4) == $wo_item->number) {
              echo "<a download target='_blank' href='$directorio$fileName'>$fileName</a>"; 
                }
              }
              closedir($gestor);
            }
          }
          ?>
          <br>
          <b>PDF:</b>
          <?php
          $directorio = "../sigma/uploads/WO/PDF/$wo_item->wo/";
          if (file_exists($directorio)) {
            if ($gestor = opendir($directorio)) {
              $list=array();
              while (false !== ($arch = readdir($gestor))) { 
                if ($arch != "." && $arch != "..") {
                  $list[]=$arch;
                } 
              }
              sort($list, SORT_NUMERIC);
              foreach($list as $fileName){
                $zip = new ZipArchive;
                if ($zip->open("$directorio$fileName") !== TRUE) {
                  exit('failed');
                }
                if ($zip->locateName("$wo_item->number.pdf") !== false) {
                  echo "<a download target='_blank' href='?c=WorkOrders&a=ZipFilePDF&id=$wo_item->wo&zip=$fileName&file=$wo_item->number.pdf&folder=PDF'>$wo_item->number</a>";
                }
                closedir($gestor);
              }
            }
          }
          ?>
          <br>
          <b>STP:</b>
          <?php

          $directorio = "../sigma/uploads/WO/STP/$wo_item->wo/";
          if (file_exists($directorio)) {
            if ($gestor = opendir($directorio)) {
              $list=array();
              while (false !== ($arch = readdir($gestor))) {
                if ($arch != "." && $arch != "..") {
                  $list[]=$arch;
                }
              }
              sort($list, SORT_NUMERIC);
              foreach($list as $fileName){
                $zip = new ZipArchive;
                if ($zip->open("$directorio$fileName") !== TRUE) {
                  exit('failed');
                }
                if ($zip->locateName("$wo_item->number.stp") !== false) {
                  echo "<a download target='_blank' href='?c=WorkOrders&a=ZipFile&id=$wo_item->wo&zip=$fileName&file=$wo_item->number.stp&folder=STP'>$wo_item->number</a>";
                }
                closedir($gestor);
              }
            }
          }
          ?>
          </dd>
          <dt><i class="fas fa-pen"></i> NOTES:</dt>
          <dd><?php echo $wo_item->obs ?></dd>
        </dl>
      </div>
    </div>
    <?php } else { ?>
    <div class="row">
      <div class="col-sm-4">
        <dl>
          <dt><i class="fas fa-hashtag"></i> DESCRIPTION:</dt>
          <dd id="totalQty"><?php echo $event->title ?></dd>
        </dl>
      </div>
    </div>
    <?php } ?>
    <?php if ($this->users->permissionGet($user->id,4)) { ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="form-group">
            <label>Start - End: </label>
            <input type="text" class="form-control form-control-sm reservationtime" name="startEnd" value="<?php echo $event->start . " - " . $event->end; ?>" required>
            <input type="hidden" name="id" value="<?php echo $event->id ?>" >
            <input type="hidden" name="resourceId" value="<?php echo $event->resourceId ?>" >
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="col-12 text-center" id="eventTimer">
      <?php echo ($event->status == 'started') ? gmdate("H:i:s", $event->time + (strtotime(date("Y-m-d H:i:s"))-strtotime($event->statusAt))) : gmdate("H:i:s", $event->time) ?>
    </div>
  </div>
  <div class="modal-footer">
    <?php if ($this->users->permissionGet($user->id,5)) { ?>
      <?php if (!$this->model->eventsList(" and status = 'started'") and $event->userId != $user->id and $event->status != 'stoped' and $event->status != 'closed') { ?>
        <button type="button" class="btn btn-primary" data-id="<?php echo $event->id ?>" id="eventStart">Start</button>
      <?php } ?>
      <?php if ($event->status == 'started' and $event->userId == $user->id) { ?>
        <button type="button" class="btn btn-info" data-id="<?php echo $event->id ?>" id="eventStop">Stop</button>
        <button type="button" class="btn btn-primary" data-id="<?php echo $event->id ?>" id="eventFinish">Finish</button>
      <?php } ?>
      <?php if ($event->status == 'stoped' and !$this->model->eventsList(" and status = 'started'")) { ?>
        <button type="button" class="btn btn-info" data-id="<?php echo $event->id ?>" id="eventStart">Continue</button>
        <button type="button" class="btn btn-primary" data-id="<?php echo $event->id ?>" id="eventFinish">Finish</button>
      <?php } ?>
    <?php } ?>
    <?php if ($this->users->permissionGet($user->id,4)) { ?>
      <?php if ($event->status == 'closed') { ?>
        <button type="button" class="btn btn-info" data-id="<?php echo $event->id ?>" id="eventReactivate">Reactivate</button>
      <?php } ?>
      <?php if (!$event->status) { ?>
        <button type="button" class="btn btn-info" data-id="<?php echo $event->id ?>" id="eventSplit">Split</button>
      <?php } ?>
      <button type="submit" class="btn btn-primary">Update</button>
    <?php } ?>
  </div>
</form>

<script>
$(document).on("click", "#eventSplit", function() {
    id = $(this).data('id');
    $.post( "?c=Events&a=EventSplitForm", { id }).done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});

$(document).on("click", "#eventStop", function() {
    id = $(this).data('id');
    $.post( "?c=Events&a=EventStopForm", { id }).done(function( data ) {
        $('#lgModal').modal('toggle');
        $('#lgModal .modal-content').html(data);
    });
});

var elapsed_seconds = <?php echo ($event->status == 'started') ? $event->time + (strtotime(date("Y-m-d H:i:s"))-strtotime($event->statusAt)) : $event->time ?>;
var status = '<?php echo $event->status ?>';
if (status == 'started') {
  setInterval(function() {
    elapsed_seconds = elapsed_seconds + 1;
    $('#eventTimer').text(get_elapsed_time_string(elapsed_seconds));
  }, 1000);
}

$(document).on('click','#eventReactivate', function(e) {
  e.preventDefault();
  eventId = $(this).data("id");
  Swal.fire({
      title: 'Reactivate?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
  }).then((result) => {
      if (result.isConfirmed) {
          $("#loading").fadeIn();
          $.post("?c=Events&a=EventReactivate", { eventId }).done(function( data ) {
              location.reload();
          });
      }
  })
});

$(document).on('submit','#eventInfo_form', function(e) {
  e.preventDefault();
  if (document.getElementById("eventInfo_form").checkValidity()) {
      $("#loading").show();
      $.post( "?c=Events&a=EventUpdate", $( "#eventInfo_form" ).serialize()).done(function( data ) {
          location.reload();
      });
  }
});

$(document).on('click','.add_split', function() {
  process = $(this).data("process");
  machine = $(this).data("machine");
  div = `
  <div class="row remove">
      <div class="col-sm-4">
          <div class="form-group">
              <label>Qty:</label>
              <div class="input-group">
              <input class="form-control form-control-sm splitQty" type="number" name="qty[]" required>
              <input type="hidden" name="process[]" value="${process}">
              <input type="hidden" name="machine[]" value="${machine}">
              </div>
          </div>
      </div>
      <div class="col-sm-7">
          <div class="form-group">
              <label>Start - End:</label>
              <input type="text" class="form-control form-control-sm reservationtime" name="startEnd[]" required>
          </div>
      </div>
      <div class="col-sm-1">
          <a class="btn bg-danger btnremove" style="margin-top:30px">
              <i class="fas fa-times"></i>
          </a>
      </div>
  </div>
  `;
  $(".eventSplits").append(div);
  Datepicker('down');
});

$(document).on('submit','#eventSplit_form', function(e) {
  e.preventDefault();
  sum= 0;
  totalSplitQty = $('#totalSplitQty').html();
  if (document.getElementById("eventSplit_form").checkValidity()) {
      $(".splitQty").each(function() {
          sum += parseInt($(this).val());
      });
      if(sum != totalSplitQty){
          toastr.error('quantity is wrong');
      } else {
          var prevStart;
          var prevEnd;
          var sumDates = 0;
          $("#eventSplit_form .reservationtime").each(function() {
              date = $(this).val().split(" - ");
              start = new Date(date[0]);
              end = new Date(date[1]);
              if(start < prevEnd) {
                  sumDates++;
              }
              prevStart = new Date(start);
              prevEnd = new Date(end);
          });
          if(sumDates == 0) {
              $("#loading").show();
              $.post( "?c=Events&a=EventSave", $( "#eventSplit_form" ).serialize()).done(function( data ) {
                  location.reload();
              });
          } else {
              toastr.error('Process schedule order is wrong');
          }
      }
  }
});
</script>