<table id="deliversTable" class="table table-head-fixed table-striped table-hover" style="width:100%">
    <thead>
    <tr>
        <th class="bg-secondary">Date</th>
        <th class="bg-secondary">Quantity</th>
        <th class="bg-secondary">Notes</th>
        <th class="bg-secondary">Received By</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; foreach($this->purchases->deliverList($id->id,$filters) as $r) { ?>
    <tr>
        <td><?php echo $r->createdAt ?>
        <td><?php echo $r->qty ?>
        <td><?php echo $r->notes ?>
        <td><?php echo $r->username ?>
    </tr>
    <?php $i++; } ?>
    </tbody>
</table>