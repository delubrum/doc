<div class="row">
    <div class="col-sm-4">
        <dl>
            <dt><i class="fas fa-info-circle"></i> ITEM ID:</dt>
            <dd><?php echo $item->id ?></dd>
            <dt><i class="fas fa-clipboard-list"></i> PROJECT:</dt>
            <dd><?php echo $item->projectname ?></dd>
            <dt><i class="fas fa-clipboard-list"></i> MATERIAL:</dt>
            <dd><?php echo $item->material ?></dd>
        </dl>
    </div>
    <div class="col-sm-4">
        <dl>
            <dt><i class="fas fa-user-circle"></i> USER:</dt>
            <dd><?php echo $item->username ?></dd>
            <dt><i class="fas fa-hashtag"></i> QUANTITY:</dt>
            <dd><?php echo $item->qty ?></dd>
            <dt><i class="far fa-clipboard"></i> NOTES:</dt>
            <dd><?php echo $item->notes ?></dd>
        </dl>
    </div>
    <div class="col-sm-4">
        <dl>
            <dt><i class="fas fa-user-circle"></i> PROJECT MANAGER:</dt>
            <dd><?php echo $item->pmname ?></dd>
            <dt><i class="fas fa-file"></i> FILE:</dt>
            <dd>
            <?php
            $directorio = "uploads/purchases/files/$item->id/";
            if (file_exists($directorio)) {
            if ($gestor = opendir($directorio)) {
            $list=array();
            while (false !== ($arch = readdir($gestor)))
            { if ($arch != "." && $arch != "..")
            { $list[]=$arch; } }
            sort($list, SORT_NUMERIC);
            foreach($list as $fileName)
            {echo "<a target='_blank' href='$directorio$fileName'><i class='fas fa-file'></i></a><br>"; }
            closedir($gestor);
            }
            }
            ?>
            </dd>
        </dl>
    </div>
</div>