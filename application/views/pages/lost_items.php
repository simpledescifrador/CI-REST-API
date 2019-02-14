<div  style="padding-top: 1%;padding-left: 2%;padding-right: 2%;">
    <h4>Items<small> -> Lost Items</small></h4>
</div>

<div style="padding-left: 2%; padding-right: 2%"><!-- main container -->
<div class="card border-secondary mb-3">
  <div class="card-header">Reported Lost</div>
  <div class="card-body">
  <table id="reported_users_table" class="table table-striped table-hover table-bordered table-dark table-sm" style="width:100%">
        <thead>
            <tr>
                <th>Date Lost</th>
                <th>Item Name</th>
                <th>Location</th>
                <th>Reward</th>
                <th>Item Description</th>
                <th>Date Reported</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($lost_item as $rows) :?>
            <tr>
                <td><?php echo $rows['date_lost'];?></td>
                <td><?php echo $rows['item_name'];?></td>
                <td><?php echo $rows['location_lost'];?></td>
                <td><?php echo $rows['reward']; ?></td>
                <td><?php echo $rows['item_description']; ?></td>
                <td><?php echo $rows['date_created']; ?></td>
                <td><button type="button" class="btn btn-sm btn-info" >View Details</button></td>
            </tr>
        <?php endforeach; ?>    
        </tbody>
    </table>
  </div>
</div>



</div><!-- /main container -->