<?php foreach ($brgy_details as $row) :?>
<?php $d_number = $row['district_no'];
	  $brgy_name = $row['name']; 
?>
<?php endforeach; ?>
 <!-- ////////////////////////////////////////////////////////////////////////////-->
    <!-- main menu-->
    <div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
      <!-- main menu header-->
      <form class="main-menu-header input-group">
        <input type="text" placeholder="Person, Pets or Items" class="menu-search form-control round"/>
        <a class="input-group-addon round nav-search" ><b class="icon-search"></b></a>
      </form>
      <!-- / main menu header-->
      <!-- main menu content-->
      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
          <li class="nav-item">
            <a href="<?php echo site_url('dashboard'); ?>"><i class="icon-home3"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-stack-2"></i><span data-i18n="nav.page_layouts.main" class="menu-title">Items</span></a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo site_url('reported_lost'); ?>" data-i18n="nav.page_layouts.2_columns" class="menu-item">Lost</a>
              </li>
              <li>
                <a href="<?php echo site_url('reported_found'); ?>" data-i18n="nav.page_layouts.boxed_layout" class="menu-item">Found</a>
              </li>
              <li><a href="<?php echo site_url('matched'); ?>" data-i18n="nav.page_layouts.static_layout" class="menu-item">Matched</a>
              </li>
              <li><a href="<?php echo site_url('returned'); ?>" data-i18n="nav.page_layouts.light_layout" class="menu-item">Returned</a>
              </li>
            </ul>
          </li>

          <li class=" nav-item"><a href="#"><i class="icon-compass3"></i><span data-i18n="nav.project.main" class="menu-title">Barangay</span></a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo site_url('barangays'); ?>?d_number=1" data-i18n="nav.invoice.invoice_template" class="menu-item">District I
                </a>
              </li>
              <li>
                <a href="<?php echo site_url('barangays'); ?>?d_number=2" class="menu-item">District II</a>
              </li>
              <li>
                <a href="<?php echo site_url('brgy_account'); ?>">Create Account</a>
              </li>
            </ul>
          </li>
          <li class=" nav-item">
            <a href="<?php echo site_url('transactions'); ?>">
            <i class="icon-refresh2"></i>
              <span class="menu-title">Transactions</span>
            </a>
          </li>
          <li class=" nav-item">
            <a href="<?php echo site_url('users_controller'); ?>">
            <i class="icon-user4"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class=" nav-item">
        <a href="reports">
        <i class="icon-whatshot"></i>
          <span class="menu-title">Reports</span>
        </a>
      </li>

          <li class=" nav-item">
            <a href="#">
              <i class="icon-compass3"></i>
              <span data-i18n="nav.content.main" class="menu-title">Feedbacks</span>
            </a>
          </li>

          <li class=" nav-item">
            <a href="#">
              <i class="icon-cog"></i>
              <span data-i18n="nav.content.main" class="menu-title">Settings</span>
            </a>
          </li>
        </ul>
      </div>
      <!-- /main menu content-->
      <!-- main menu footer-->
      <!-- include includes/menu-footer-->
      <!-- main menu footer-->
    </div>
    <!-- / main menu-->
<br>
<div class="app-content content container-fluid">
      <div class="content-wrapper	">
<div class="row">
	<div class="col-md-7">
		<div class="row" style="padding-left: 1em;padding-right: 1em;">
			<div class="col-md-6" style="padding-right: 1.7em;">
				<div class="row" title="Turnovered Items In <?php echo $brgy_name; ?>">
					<div class="col-sm-5 text-center bg-info">
						<br/><br>
						<i class=" icon-3x icon-hands-helping"></i>
						<br/><br/><br>
					</div>
					<div class="col-sm-7 text-center text-info bg-white">
						<br>
						<b>Turnovered Items</b>
						<hr>
						<?php $turnover=0; foreach ($brgy_turnovers as $row) :?>
						<?php $turnover+=1; ?>
						<?php endforeach; ?>
						<p><?php echo $turnover;?></p>
					</div>
				</div>
				<br>
				<div class="row" title="Claimed Items In <?php echo $brgy_name; ?>">
					<div class="col-sm-5 text-center bg-success">
						<br/><br>
						<i class="icon-gift"></i>
						<br/><br/><br>
					</div>
					<div class="col-sm-7 text-center text-success bg-white">
						<br>
						<b>Claimed Items</b>
						<hr>
						<p>0</p>
					</div>
				</div>
			</div>
			<div class="col-md-6" style="padding-left: 1.7em;">
				
				<div class="row" title="Pending Items <?php echo $brgy_name; ?>">
					<div class="col-sm-5 text-center bg-warning">
						<br/><br>
						<i class="fa fa-3x fa-clock"></i>
						<br/><br/><br>
					</div>
					<div class="col-sm-7 text-center text-warning bg-white">
						<br>
						<b>Pending Items</b>
						<hr>
						<?php $pending=0; foreach ($brgy_pending_items as $row) :?>
						<?php $pending+=1; ?>
						<?php endforeach; ?>
						<p><?php echo $pending; ?></p>
					</div>
				</div>
				
				<br>
				<div class="row" title="Total Posts of <?php echo $brgy_name; ?>">
					<div class="col-sm-5 text-center bg-primary">
						<br/><br>
						<i class="fa fa-3x fa-thumbtack"></i>
						<br/><br/><br>
					</div>
					<div class="col-sm-7 text-center text-primary bg-white">
						<br>
						<b>Posted Items</b>
						<hr>
						<p>0</p>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="card">
			<div class="card-header">
				<h6><b class="fa fa-users"></b>&nbsp;&nbsp;&nbsp;Registered Accounts</h6>
				
			</div>
			<div class="card-body">
				<div class="list-group">
				  <?php foreach ($users as $rows) : ?>
				  <a href="#" class="list-group-item list-group-item-action">
				    <?php $users = $rows['name'];
				    	echo $users;
				    ?>

				  </a> 
				  <?php endforeach; ?>
				  <?php
				  if ($users == null) {
				   	echo "<div class='text-muted'>No Data Available</div>";
				   } 
				  ?>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-md-5">
		<div class="card bg-white text-primary">
			<div class="card-body">
				<?php foreach ($brgy_details as $row) :?>
				<h4 class="card-title">Brgy. <?php echo $row['name']; ?></h4>
				<h6 class="card-subtitle mb-2 text-muted"><?php echo ucfirst($row['address']); ?></h6>
				<hr>
				<div style="width: 100%;">
					<div id="Location" style="width: 100%; height: 400px;"></div>
				</div>
				
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script type="text/javascript">

            // position we will use later
            var lat = '<?php echo $row['latitude']; ?>';
            var lon = '<?php echo $row['longitude']; ?>';
            // initialize map
            map = L.map('Location').setView([lat, lon], 17);
            // set map tiles source
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                maxZoom: 17,
                minZoom: 17,
            }).addTo(map);
            // add marker to the map
            marker = L.marker([lat, lon]).addTo(map);
            // add popup to the marker
            marker.bindPopup("<b><?php echo $row['name']; ?></b>").openPopup();
 </script>
			<?php endforeach;?>

						