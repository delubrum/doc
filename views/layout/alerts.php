<!-- <div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">
    <div class="media">
    <i class="fas fa-3x fa-industry img-size-50 mr-3 img-circle"></i>
    <div class="media-body">
        Process work order id: <span class="text-info">AMPD-006</span>
        <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i>3 mins</p>
    </div>
    </div>
</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">
    <div class="media">
    <i class="fas fa-3x fa-ticket-alt img-size-50 mr-3 img-circle"></i>
    <div class="media-body">
        Send bill of material id:<span class="text-info"> test-0001-1</span>
        <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i>11 hours</p>
    </div>
    </div>
</a>
-->

<?php if($countalertReserve > 0) { ?>
<div class="dropdown-divider"></div>
<a href="?c=Reserve&a=Index" class="dropdown-item">
    <div class="media">
        <i class="fas fa-3x fa-book img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
        <p>There are: <span class="text-info"> <?php echo count($alertReserve) ?> </span> reservations to approve</p>       
        </div>
    </div>
</a>
<?php } ?>

<?php if($countalertReserveReceive > 0) { ?>
<div class="dropdown-divider"></div>
<a href="?c=Reserve&a=Index" class="dropdown-item">
    <div class="media">
        <i class="fas fa-3x fa-book img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
        <p>There are: <span class="text-info"> <?php echo count($alertReserveReceive) ?> </span> reservations to receive </p>        
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertReserveCancel as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item checkReserveCancel" data-id="<?php echo $r->id ?>">
    <div class="media">
        <i class="fas fa-3x fa-wrench img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            <p>
            Reserve id: <span class="text-info"> <?php echo $r->id ?> </span> was cancelled
            </p>
            <p>Cause: <span class="text-info"><?php echo $r->cause?></span></p>
            
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertReserveApproved as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item checkReserveApproved" data-id="<?php echo $r->id ?>">
    <div class="media">
        <i class="fas fa-3x fa-wrench img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            <p>
            Reserve id: <span class="text-info"> <?php echo $r->id ?> </span> was approved
            </p>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
            
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertPurchaseCode as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseCode" data-id="<?php echo $r->id ?>">
    <div class="media">
        <i class="fas fa-3x fa-hashtag img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            <p>
            Approve purchase code: <span class="text-info"> <?php echo $r->name ?> </span>
            </p>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertPurchaseCodeApprove as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseCodeCheck" data-id="<?php echo $r->id ?>">
    <div class="media">
        <i class="fas fa-3x fa-hashtag img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            <p>
            Purchase Code: <span class="text-info"> <?php echo $r->code ?> - <?php echo $r->description ?> </span> was approved     
            </p>       
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertPurchaseCodeCancel as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseCodeCheck" data-id="<?php echo $r->id ?>">
    <div class="media">
        <i class="fas fa-3x fa-hashtag img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            <p>
            Purchase Code: <span class="text-info"> <?php echo $r->name ?> </span> was cancelled
            </p>
            <p>Cause: <span class="text-info"><?php echo $r->description?></span></p>
            
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertITStart as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item itAction" data-id="<?php echo $r->id ?>" data-status="process" data-title="Process Service">
    <div class="media">
        <i class="fas fa-3x fa-desktop img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Start IT Service id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertITEnd as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item itAction" data-id="<?php echo $r->id ?>" data-status="process" data-title="Process Service">
    <div class="media">
        <i class="fas fa-3x fa-desktop img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Finish IT Service id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertITRate as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item itAction" data-id="<?php echo $r->id ?>" data-status="rate" data-title="Rate Service">
    <div class="media">
        <i class="fas fa-3x fa-desktop img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Rate IT Service id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertITCheck as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item checkService" data-id="<?php echo $r->id ?>" data-status="view" data-title="View Service">
    <div class="media">
        <i class="fas fa-3x fa-desktop img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            IT Service id: <span class="text-info"> <?php echo $r->id ?> </span> was iniciated
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->start))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>


<?php foreach($alertMNTAssign as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item mntAction" data-id="<?php echo $r->id ?>" data-status="assign" data-title="Assign Service">
    <div class="media">
        <i class="fas fa-3x fa-wrench img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Assign MNT Service id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertMNTStart as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item mntAction" data-id="<?php echo $r->id ?>" data-status="process" data-title="Process Service">
    <div class="media">
        <i class="fas fa-3x fa-wrench img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Start MNT Service id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertMNTEnd as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item mntAction" data-id="<?php echo $r->id ?>" data-status="process" data-title="Process Service">
    <div class="media">
        <i class="fas fa-3x fa-wrench img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Finish MNT Service id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertMNTRate as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item mntAction" data-id="<?php echo $r->id ?>" data-status="rate" data-title="Rate Service">
    <div class="media">
        <i class="fas fa-3x fa-wrench img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Rate MNT Service id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertMNTCheck as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item checkmntService" data-id="<?php echo $r->id ?>" data-status="view" data-title="View Service">
    <div class="media">
        <i class="fas fa-3x fa-wrench img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            MNT Service id: <span class="text-info"> <?php echo $r->id ?> </span> was iniciated
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->start))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertPurchaseProcess as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseAction" data-id="<?php echo $r->id ?>" data-status="process" data-title="Process Purchase">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Process purchase id: <span class="text-info"><?php echo $r->id ?></span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertPurchaseAssign as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseAction" data-id="<?php echo $r->id ?>" data-status="assign" data-title="Assign Purchase">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Assign purchase id: <span class="text-info"><?php echo $r->id ?></span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertPurchasePricing as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseAction" data-id="<?php echo $r->id ?>" data-status="pricing" data-title="Pricing Purchase">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Quote purchase id: <span class="text-info"><?php echo $r->id ?></span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertPmApproval as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseAction" data-id="<?php echo $r->id ?>" data-status="pmapprove" data-title="PM Approve Purchase">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            PM Approve Purchase id: <span class="text-info"><?php echo $r->id ?></span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertApproval as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseAction" data-id="<?php echo $r->id ?>" data-status="approve" data-title="CEO Approve Purchase">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            CEO Approve Purchase id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertPurchase as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseAction" data-id="<?php echo $r->id ?>" data-status="purchase" data-title="Purchase Purchase">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Purchase Purchase id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertReceive as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item purchaseAction" data-id="<?php echo $r->id ?>" data-status="receive" data-title="Receive Purchase">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Receive Purchase id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertReceiveCheck as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item alertReceiveCheck" data-id="<?php echo $r->id ?>">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            <p>Purchase id: <span class="text-info"> <?php echo $r->id ?> </span> was fully received</p>
        </div>
    </div>
</a>
<?php } ?>

<!-- <?php foreach($alertReceiveCheckItem as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item alertReceiveCheckItem" data-id="<?php echo $r->id ?>" data-purchase="<?php echo $r->purchaseId ?>">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            <p>Purchase id: <span class="text-info"> <?php echo $r->purchaseId ?> </span> item <span class="text-info"> <?php echo $r->material ?></span> was partially received</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertReceiveCheckItemPM as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item alertReceiveCheckItemPM" data-id="<?php echo $r->id ?>" data-purchase="<?php echo $r->purchaseId ?>">
    <div class="media">
        <i class="fas fa-3x fa-shopping-cart img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            <p>Purchase id: <span class="text-info"> <?php echo $r->purchaseId ?> </span> item <span class="text-info"> <?php echo $r->material ?></span> was partially received</p>
        </div>
    </div>
</a>
<?php } ?> -->

<?php foreach($alertWOProcess as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item woAction" data-id="<?php echo $r->id ?>" data-status="process" data-title="Process Work Order">
    <div class="media">
        <i class="fas fa-3x fa-industry img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Process WO id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>

        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertWOConfirm as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item woAction" data-id="<?php echo $r->id ?>" data-status="confirm" data-title="Confirm Work Order">
    <div class="media">
        <i class="fas fa-3x fa-industry img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Confirm WO id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertWOSend as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item woAction" data-id="<?php echo $r->id ?>" data-status="send" data-title="Send Work Order">
    <div class="media">
        <i class="fas fa-3x fa-industry img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Send WO id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>


<?php foreach($alertBOMProcess as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item bomAction" data-id="<?php echo $r->id ?>" data-status="process" data-title="Process Bill of Material">
    <div class="media">
        <i class="fas fa-3x fa-industry img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Process BOM id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertBOMConfirm as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item bomAction" data-id="<?php echo $r->id ?>" data-status="confirm" data-title="Confirm Bill of Material">
    <div class="media">
        <i class="fas fa-3x fa-industry img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            Deliver BOM id: <span class="text-info"> <?php echo $r->id ?> </span>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>

<?php foreach($alertBOMSAP as $r) { ?>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item bomAction" data-id="<?php echo $r->bomId ?>" data-status="view" data-title="SAP Bill of Material">
    <div class="media">
        <i class="fas fa-3x fa-industry img-size-50 mr-3 img-circle"></i>
        <div class="media-body">
            SAP BOM id: <span class="text-info"> <?php echo $r->bomId ?> </span> item id: <?php echo $r->itemId ?>, qty: <?php echo $r->qty ?>
            <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i><?php echo round((strtotime(date("Y-m-d H:i:s")) - strtotime($r->createdAt))/60/60/24) ?> days</p>
        </div>
    </div>
</a>
<?php } ?>



