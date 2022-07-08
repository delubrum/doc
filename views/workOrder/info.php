<?php if($this->init->RejectList('wo',$id->id)) { ?><button type="button" class="btn btn-warning rejections float-right" data-toggle="tooltip" data-placement="top" data-id="<?php echo $id->id; ?>" data-type='wo' title="Rejections"><i class="fas fa-exclamation"></i></button><?php } ?>

<div class="row">
    <div class="col-sm-4">
        <dl>
            <dt><i class="fas fa-info-circle"></i> ID:</dt>
            <dd><?php echo $id->id ?></dd>
            <dt><i class="fas fa-info-circle"></i> ORDER:</dt>
            <dd><?php echo $id->designation ?></dd>
            <dt><i class="fas fa-clipboard-list"></i> PROJECT:</dt>
            <dd><?php echo $id->projectname ?></dd>

        </dl>
    </div>
    <div class="col-sm-4">
        <dl>
        <dt><i class="fas fa-user-circle"></i> USER:</dt>
            <dd><?php echo $id->username ?></dd>
            <dt><i class="fas fa-calendar"></i> CREATION DATE:</dt>
            <dd><?php echo $id->createdAt ?></dd>
            <dt><i class="fas fa-search"></i> SCOPE:</dt>
            <?php if($status == 'process') { ?><dd><input value="<?php echo htmlentities(stripslashes($id->scope)) ?>" id="scope" required> </dd><?php } ?>
            <?php if($status != 'process') { ?> <dd><?php echo htmlentities(stripslashes($id->scope)) ?></dd><?php } ?>

        </dl>
    </div>
    <div class="col-sm-4">
            <dt><i class="fas fa-user-circle"></i> PROJECT MANAGER:</dt>
            <dd><?php echo $id->pmname ?></dd>
            <?php if ($status != 'process') { ?> 
            <dt><i class="fas fa-clipboard-list"></i> OTHER FILES:</dt>
            <dd>
            <?php
            $folder = "uploads/workOrders/other/$id->id/";
            if (file_exists($folder)) {
                if ($gestor = opendir($folder)) {
                $list=array();
                while (false !== ($arch = readdir($gestor))) {
                    if ($arch != "." && $arch != "..") {
                    $list[]=$arch;
                    } 
                }
                sort($list, SORT_NUMERIC);
                foreach($list as $fileName) {
                    echo "<a download target='_blank' href='$folder$fileName'><i class='fas fa-file'></i></a><br>"; 
                }
                closedir($gestor);
                }
            }
            ?>
            </dd>

            <dt>BOM:</dt>
            <dd>
                <ul>
                <?php $i=1;foreach($this->wo->bomList($id->id) as $r){ 
                echo "<li><a href='?c=BOM&a=BOM&status=view&id=$r->id' target='_blank'>" . $r->code . "</a></li>";
                } ?>
                </ul>
            </dd>


            <?php } ?>
        </dl>
    </div>
</div>

<script>
$(document).on('blur', '#scope', function() {
  id = <?php echo $id->id ?>;
  scope = $('#scope').val();
  $("#loading").show();
  $.post( "?c=WorkOrders&a=InfoUpdate", { id,scope }).done(function( data ) {
    $("#loading").hide();
  });
});
</script>