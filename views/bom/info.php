<?php if($this->init->RejectList('bom',$id->id)) { ?><button type="button" class="btn btn-warning rejections float-right" data-toggle="tooltip" data-placement="top" data-id="<?php echo $id->id; ?>" data-type='bom' title="Rejections"><i class="fas fa-exclamation"></i></button><?php } ?>

<div class="row">
    <div class="col-sm-4">
        <dl>
            <dt><i class="fas fa-info-circle"></i> ID:</dt>
            <dd><?php echo $id->id ?></dd>
            <dt><i class="fas fa-info-circle"></i> CODE:</dt>
            <dd><?php echo $id->code ?></dd>
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
            <dd><?php echo htmlentities(stripslashes($id->scope)) ?></dd>
        </dl>
    </div>
    <div class="col-sm-4">
            <dt><i class="fas fa-user-circle"></i> PROJECT MANAGER:</dt>
            <dd><?php echo $id->pmname ?></dd>
            
        </dl>
    </div>
</div>