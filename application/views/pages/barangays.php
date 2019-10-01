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
	<div class="app-content content container-fluid">
      <div class="content-wrapper	">

      	<!-- BEGIN Breadcrumbs (Page Navigator) -->
	      <div class="content-header row">
	        <div class="content-header-left col-md-6 col-xs-12 mb-1">
	          <h2 class="content-header-title">District
              <?php
                if ($d_number == 1) {
                  echo "I";
                }
                else{
                  echo "II";
                }
              ?>
            </h2>
	        </div>
	        <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
	          <div class="breadcrumb-wrapper col-xs-12">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a class="blue" href="index.html">Home</a>
	              </li>
	              <li class="breadcrumb-item"><a class="blue" href="#">Items</a>
	              </li>
	              <li class="breadcrumb-item active">Found
	              </li>
	            </ol>
	          </div>
	        </div>
	      </div>
	      <!-- END Breadcrumbs (Page Navigator) -->
    <div class="content-body">
		<div class="card">
		<div class="card-header">
			<i class="fa fa-list-ul"></i>&nbsp; Barangays in District <?php echo $d_number; ?>
		</div>
		<div class="card-body card-block">
		<div class="row">
			
			<div class="col-md-6">
				<ul class="list-group">
				  <?php $count = 0;?>
				  <?php foreach($barangay as $row) :?>
				  <a href="<?php echo site_url('brgy_details'); echo "?brgy_id=".$row['id']; ?>" class="list-group-item list-group-item-info list-group-item-action"><?php echo $row['name']; ?></a>
				  	<?php 
				  		$count++;
			            if ($count == 10) {
			              echo "</ul></div><div class='col-md-6'>";
			              $count = 0;
			            }
			        ?>
				  <?php endforeach; ?>
				
			</div>
		</div>	
		</div>
		<div class="card-footer" style="font-size: .9em;">
			<i>*Select a row to view the baragay details</i>
		</div>
		</div>
  </div>

	</div>
</div>