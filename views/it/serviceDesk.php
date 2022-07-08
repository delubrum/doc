
<header>
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
</header>

<form method="post" id="<?php echo $status ?>_form">
  <div class="modal-header">
  <h5 class="modal-title"><?php echo $title ?> : <b><?php echo $id->id ?></b></h5>
  <input type="hidden" name="id" value="<?php echo $id->id ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">

  <?php if ($status == 'view') { ?>

    <table style='text-align:center;width:100%;padding:0' class="mb-4">
        <tr>
            <td style='width:33%'><img style='width:100px' src='assets/img/logo.png'></td>
            <td style='width:33%'><h1>IT SERVICE DESK</h1></td>
            <td style='width:33%;font-size:18px'>
                <b>Code:</b> F01-PRTI-01
                <br>
                <b>Date:</b> 2021-11-24
                <br>
                <b>Version:</b> 01
            </td>
        </tr>
    </table>
<?php } ?>


    <div class="row">
        <div class="col-sm-3">
            <dl>
                <dt><i class="fas fa-info-circle"></i> ID:</dt>
                <dd><?php echo $id->id ?></dd>
            </dl>
        </div>
        <div class="col-sm-3">
            <dl>
                <dt><i class="fas fa-clipboard-list"></i> USER:</dt>
                <dd><?php echo $id->username ?></dd>
            </dl>
        </div>
        <div class="col-sm-3">
            <dl>
                <dt><i class="fas fa-calendar"></i> DATE:</dt>
                <dd><?php echo $id->createdAt ?></dd>
            </dl>
        </div>
        <div class="col-sm-3">
            <dl>
                <dt><i class="fas fa-clipboard-list"></i> TYPE:</dt>
                <dd><?php echo $id->type ?></dd>
            </dl>
        </div>
        <div class="col-sm-12">
            <dl>
                <dt><i class="fas fa-info text-center"></i> DESCRIPTION:</dt>
                <dd><?php echo $id->description ?></dd>
            </dl>
        </div>
    </div>

        <div class="row">
            <div class="col-sm-<?php echo ($id->start) ? '2' : '3' ?>">
                <div class="form-group">
                    <label>* Priority</label>
                    <div class="input-group">
                        <select class="form-control" name="priority" style="width: 100%;" required <?php echo ($status != 'process') ? 'disabled' : '' ?>>
                            <option value=''></option>
                            <option value='High' <?php echo (isset($id) and $id->priority == 'High') ? 'selected' : ''; ?>>High</option>
                            <option value='Medium' <?php echo (isset($id) and $id->priority == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value='Low' <?php echo (isset($id) and $id->priority == 'Low') ? 'selected' : ''; ?>>Low</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-<?php echo ($id->start) ? '2' : '3' ?>">
                <div class="form-group">
                    <label>* Complexity</label>
                    <div class="input-group">
                        <select class="form-control" name="complexity" style="width: 100%;" required <?php echo ($status != 'process') ? 'disabled' : '' ?>>
                            <option value=''></option>
                            <option value='High' <?php echo (isset($id) and $id->complexity == 'High') ? 'selected' : ''; ?>>High</option>
                            <option value='Medium' <?php echo (isset($id) and $id->complexity == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value='Low' <?php echo (isset($id) and $id->complexity == 'Low') ? 'selected' : ''; ?>>Low</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group">
                    <label>* Start Date</label>
                    <input type="date" class="form-control" name="startDate" value="<?php echo (isset($id->start)) ? date("Y-m-d",strtotime($id->start)) : ''; ?>" required <?php echo ($status != 'process' or $id->start) ? 'disabled' : '' ?>>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group">
                    <label>* Start Time:</label>
                    <input type="time" class="form-control" name="startTime" value="<?php echo (isset($id->start)) ? date("H:i:s",strtotime($id->start)) : ''; ?>" required <?php echo ($status != 'process' or $id->start) ? 'disabled' : '' ?>>
                </div>
            </div>

            <?php if ($id->start) { ?>

            <div class="col-sm-2">
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" class="form-control" name="endDate" value="<?php echo (isset($id->end)) ? date("Y-m-d",strtotime($id->end)) : ''; ?>" <?php echo ($status != 'process') ? 'disabled' : '' ?>>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group">
                    <label>End Time:</label>
                    <input type="time" class="form-control" name="endTime" value="<?php echo (isset($id->end)) ? date("H:i:s",strtotime($id->end)) : ''; ?>" <?php echo ($status != 'process') ? 'disabled' : '' ?>>
                </div>
            </div>

            <?php } ?>


            <div class="col-sm-2">
                <div class="form-group">
                    <label>* Attends:</label>
                    <div class="input-group">
                        <select class="form-control <?php echo ($id->start) ? 'form-control-sm' : '' ?>" name="attends" style="width: 100%;" required <?php echo ($status != 'process') ? 'disabled' : '' ?>>
                            <option value=''></option>
                            <option value='Internal' <?php echo (isset($id) and $id->attends == 'Internal') ? 'selected' : ''; ?>>Internal</option>
                            <option value='External' <?php echo (isset($id) and $id->attends == 'External') ? 'selected' : ''; ?>>External</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-<?php echo ($id->start) ? '10' : '12' ?>">
                <div class="form-group">
                    <label>* IT Agent:</label>
                    <div class="input-group">
                        <select name='users[]' style="width:100%;height:50px !important" class="select2" id="select2" multiple="multiple" required <?php echo ($status != 'process') ? 'disabled' : '' ?>>
                        <option>SEINER</option>
                        <option>DCARO</option>
                        <option>INCREASE</option>
                        <option>WS TECNOLOGIA</option>
                        <option>David Fragozo</option>
                        <option>Bryan Viloria</option>


                        </select>
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="form-group">
                    <label>* Answer Description:</label>
                    <div class="input-group">
                    <textarea class="form-control" name="answer" style="height:100px" required <?php echo ($status != 'process') ? 'disabled' : '' ?>><?php echo (isset($id->answer)) ? $id->answer : ''; ?></textarea>
                    </div>
                </div>
            </div>


        </div>

    <?php if ($id->end and ($status == 'rate' or $status == 'view')) { ?>
        <div class="row mt-3">
            <div class="col-md-4 offset-md-4 text-center">
                <h2>Service Rate:</h2>
                <?php if ($status == 'rate') { ?>
                <label class="radio-inline h1 m-2">
                <input type="radio" name="rating" required value="1" style="zoom:2">1
                </label>
                <label class="radio-inline h1 m-2">
                <input type="radio" name="rating" value="2" style="zoom:2">2
                </label>
                <label class="radio-inline h1 m-2">
                <input type="radio" name="rating" value="3" style="zoom:2">3
                </label>
                <label class="radio-inline h1 m-2">
                <input type="radio" name="rating" value="4" style="zoom:2">4
                </label>
                <label class="radio-inline h1 m-2">
                <input type="radio" name="rating" value="5" style="zoom:2">5
                </label>
                <?php } else { ?>
                    <h2><?php echo $id->rating?></h2>
                <?php } ?>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>Notes:</label>
                    <div class="input-group">
                    <textarea class="form-control" name="notes" style="height:100px" <?php echo ($status != 'rate') ? 'disabled' : '' ?>><?php echo (isset($id->notes)) ? $id->notes : ''; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

  </div>

  <?php if ($status != 'view') { ?>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
  <?php } ?>

</form>

<script>

<?php if (isset($id->users)) { ?>
$('.select2').append(`
    <?php foreach (json_decode($id->users) as $u) { ?>
    <option selected><?php echo $u ?></option>
    <?php } ?>
`).change();
<?php } ?>


$(document).on('submit', '#<?php echo $status ?>_form', function(e) {
    e.preventDefault();
    if (document.getElementById("<?php echo $status ?>_form").checkValidity()) {
      $("#loading").show();
      var formData = new FormData(this);
      formData.append('status', '<?php echo $status ?>');
      $.ajax({
        url: "?c=IT&a=Update",
        type: 'POST',
        data: formData,
        success: function (data) {
          location.reload();
        },
        cache: false,
        contentType: false,
        processData: false
      });
    }
});

</script>