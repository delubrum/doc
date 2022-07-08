<form method="post" id="partNumber_forma" autocomplete="off">
  <div class="modal-header">
    <h5 class="modal-title">Schedule: <b><?php echo $wo_item->number . " / " . $wo->designation ?></b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-sm-4">
        <dl>
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
          <dt><i class="fas fa-hashtag"></i> QUIANTITY:</dt>
          <dd id="totalQty"><?php echo $wo_item->qty ?></dd>
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
                  echo "<a target='_blank' href='?c=WorkOrders&a=ZipFilePDF&id=$wo_item->wo&zip=$fileName&file=$wo_item->number.pdf&folder=PDF'>$wo_item->number</a>";
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

      <div class="col-sm-12">
        <dl>
          <dt><i class="fas fa-archive"></i> DESIGNER PROCESSES</dt>
          <dd> <?php foreach($processesb as $p) { echo ($wo_item->$p == 'SI') ? ($p == 'other') ? ' <b class="text-danger">OTHER</b>' : $p . ', ' : ''; } ?> </dd>
        </dl>
      </div>

      <input type="hidden" name="id" value="<?php echo $id ?>">

      <div class="col-sm-12">
        <div class="form-group">
          <div class="input-group">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              <?php foreach($processes as $p) { ?>
              <label class="btn <?php echo ($wo_item->$p == 'SI') ? 'btn-primary' : 'btn-secondary'; ?> process active"><?php echo $p?></label>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-sm-12" id="machines">
          <?php foreach($processes as $p) {
          if ($wo_item->$p == 'SI') { ?>
            <div class="row process_<?php echo $p ?>">
              <div class="row col-sm-12">
                  <div class="col-sm-2">
                      <div class="form-group">
                          <label>Process:</label>
                          <div class="input-group">
                          <input class="form-control form-control-sm processName" value="<?php echo $p ?>" readonly name="process[]">
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-3">
                      <div class="form-group">
                          <label>Machine:</label>
                          <div class="input-group">
                          <select class="form-control form-control-sm" name="machine[]" required>
                          <option value=""></option>
                          <?php foreach($this->machines->MachinesList() as $r) {
                            if (strpos($r->processes,$p)) { ?>
                              <option value="<?php echo $r->id ?>"><?php echo $r->title ?></option>
                          <?php }} ?>
                          </select>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-2">
                      <div class="form-group">
                          <label>Qty:</label>
                          <div class="input-group">
                          <input class="form-control form-control-sm qty_<?php echo $p ?>" type="number" name="qty[]" required>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-4">
                      <div class="form-group">
                          <label>Start - End:</label>
                          <input type="text" class="form-control form-control-sm reservationtime" name="startEnd[]" required>
                      </div>
                  </div>

                  <div class="col-sm-1">
                      <a class="btn bg-primary add_machine" data-id="<?php echo $p ?>" style="margin-top:30px">
                          <i class="fas fa-plus"></i>
                      </a>
                  </div>
              </div>
          </div>
          <?php }} ?>
        </div>
    </div>
  </div>
  <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>