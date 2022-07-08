<table id="example" class="table-striped" style="width:100%;<?php echo ($_REQUEST['a'] != 'Index') ? 'font-size:13px' : '';?>">
    <thead>
        <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Users</th>
            <th>Date</th>
            <th>Project</th>
            <th>Delivery <br> Place</th>
            <th>Material <br> Arrival Date</th>
            <th>Materials</th>
            <th>Total <br> Price</th>
            <th>Status</th>
            <!-- <th>CEO Approved</th> -->

            <th class="text-right" style="<?php echo ($_REQUEST['a'] == 'Index') ? 'min-width:150px' : '';?>">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->purchases->purchasesList($filters) as $r) { ?>
        <tr>
            <td><?php echo $r->id; ?></td>
            <td><?php echo $r->type; ?></td>
            <td style="font-size:14px;min-width:150px;">
                <div title="User">
                    <?php echo $r->username; ?>
                </div>
                <?php if (isset($r->quoter)) { ?>
                <div title="Quoter">
                    <?php echo $r->quoter; ?>
                </div>
                <?php } ?>
                <div title="PM">
                    <?php echo $r->pmName; ?>
                </div>
            </td>
            <td><?php echo $r->sentAt; ?></td>
            <td><?php echo $r->projectName; ?></td>
            <td><?php echo $r->deliveryPlace; ?></td>
            <td><?php echo $r->requestDate ?></td>
            <td style="font-size:14px;">
            <?php foreach($this->purchases->purchasesItemsList($r->id) as $m) { ?>
                <li
                <?php 
                $prev = ($this->purchases->deliverSum($m->id)->total == '') ? 0 : $this->purchases->deliverSum($m->id)->total;
                if ($m->partial != 0) {
                  $partial = $m->partial + $prev;
                } else {
                  $partial = $prev;
                }
                if  ($partial >= $m->qty) {
                    echo "class='text-success'";
                }
                if  ($partial > 0 and  $partial < $m->qty) {
                    echo "class='text-warning'";
                }
                ?>
                
                ><?php echo htmlentities(stripslashes($m->material)) ?> <?php echo isset($m->purchaseOrder) ? " || <b>$m->purchaseOrder</b>" : ""  ?>
                <?php $date = date('Y-m-d', strtotime($r->purchasedAt. " + $m->days days"));
                $earlier = new DateTime();
                $later = new DateTime($date);
                $diff = $earlier->diff($later)->format("%r%a");
                $color =  ($diff >= 0) ? 'text-success' : 'text-danger';
                echo (isset($r->purchasedAt) and isset($m->days)) ? " || <b class='$color'> $diff days</b>" : ""  ?>
            </li>
            <?php } ?>
            </td>
            <td>$ <?php echo number_format(ceil($this->purchases->TotalPrice($r->id)->total),0); ?></td>
            <td>
                <?php
                switch (true) {
                    case ($r->cancelledAt):
                        echo "Cancelled";
                        break;
                    case ($r->approvedAt and !$r->purchasedAt):
                        echo "Purchasing";
                        break;
                    case ($r->purchasedAt and !$r->receivedAt):
                        echo "Receiving";
                        break;
                    case ($r->receivedAt):
                        echo "Closed";
                        break;
                    case ($r->sentAt and $r->quoterId and !$r->quotedAt):
                        echo "Pricing";
                        break;
                    case ($r->quotedAt and !$r->approvedPMAt):
                        echo "PM Approval";
                        break;
                    case ($r->approvedPMAt and !$r->approvedAt):
                        echo "CEO Approval";
                        break;
                    default:
                        echo "Processing";
                        break;
                }
                ?>
            </td>
            <!-- <td><?php echo ($r->approvedAt) ? 'YES' : 'NO' ?></td> -->
            
                <td class="text-right">
                <?php if (empty($status))  { ?> 
                    <!-- <?php if($this->init->RejectList('purchase',$r->id)) { ?><button type="button" class="btn btn-warning itemRejections" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="Rejections"><i class="fas fa-exclamation"></i></button><?php } ?> -->
                    <?php if(!$r->cancelledAt and !$r->receivedAt) { ?>
                        <?php if(!$r->sentAt and $user->id == $r->userId) { ?> <button type="button" class="btn btn-primary purchaseAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="process" data-title="Process Purchase" title="Process"><i class="fas fa-edit"></i></button><?php } ?>
                        <?php if($r->sentAt and !$r->quotedAt and $r->quoterId == $user->id and in_array(13, $permissions)) { ?> <button type="button" class="btn btn-primary purchaseAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="pricing" data-title="Pricing Purchase" title="Pricing"><i class="fas fa-file-invoice-dollar"></i></button><?php } ?>
                        <?php if($r->pmId == $user->id and $r->quotedAt and !$r->approvedPMAt and in_array(14, $permissions)) { ?> <button type="button" class="btn btn-primary purchaseAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="pmapprove" data-title="PM Approve Purchase" title="PM Approval"><i class="fas fa-check"></i></button><?php } ?>
                        <?php if($r->approvedPMAt and !$r->approvedAt and in_array(15, $permissions)) { ?> <button type="button" class="btn btn-primary purchaseAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="approve" data-title="CEO Approve Purchase" title="CEO Approval"><i class="far fa-calendar-check"></i></button><?php } ?>
                        <?php if($r->approvedAt and !$r->purchasedAt and $r->quoterId == $user->id and in_array(12, $permissions)) { ?><button type="button" class="btn btn-primary purchaseAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="purchase" data-title="Purchase Purchase" title="Purchase"><i class="fas fa-cart-arrow-down"></i></button><?php } ?>
                        <?php if(($r->purchasedAt and !$r->receivedAt and $r->type == 'Material' and in_array(16, $permissions)) or ($r->purchasedAt and !$r->receivedAt and $r->type == 'Service' and $r->userId == $user->id)) { ?>
                            <button type="button" class="btn btn-primary purchaseAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" data-status="receive" data-title="Receive Purchase" title="Receive"><i class="fas fa-hand-holding"></i></button><?php } ?>
                    <?php } ?>
                    <?php } ?>
                    <button type="button" class="btn btn-primary purchaseAction" data-toggle="tooltip" data-placement="top" data-id="<?php echo $r->id; ?>" title="View" data-status="view" data-title="View Purchase"><i class="fas fa-eye"></i></button>
                </td>
            
        </tr>
        <?php } ?>
    </tbody>
</table>

