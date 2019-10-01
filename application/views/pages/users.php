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
                <a href="<?php echo site_url('barangays'); ?>?d_number=2" data-i18n="nav.gallery_pages.gallery_grid" class="menu-item">District II</a>
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
          <li class="active nav-item">
            <a href="<?php echo site_url('users_controller'); ?>">
            <i class="icon-user4"></i>
              <span class="">Users</span>
            </a>
          </li>
          <li class="nav-item">
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
      <div class="content-wrapper">

        <!-- BEGIN Breadcrumbs (Page Navigator) -->
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-xs-12 mb-1">
          <h2 class="content-header-title">Users</h2>
        </div>
        <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
          <div class="breadcrumb-wrapper col-xs-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="blue" href="index.html">Home</a>
              </li>
              <li class="breadcrumb-item active">Users
              </li>
            </ol>
          </div>
        </div>
      </div>
      <!-- END Breadcrumbs (Page Navigator) -->

        <div class="content-body">
        <section>
          <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div id="heading1"  class="card-header">
                  <?php
                  $actv_users_count = 0;
                  ?>
                  <?php foreach ($active_users as $rows): ?>
                  <?php $actv_users_count ++; ?>
                  <?php endforeach; ?>
                  <button class="btn btn-info" type="button" data-parent="#accordionWrapa1" data-toggle="collapse" data-target="#accordion1" aria-expanded="true" aria-controls="collapseOne" title="Click to view all active users.">
                    Active Users &nbsp;
                    <b class=" tag tag-pill bg-white blue">
                    <?php echo $actv_users_count ; ?>
                    </b>
                    
                  </button>
                
              </div>
              <div id="accordion1" role="tabpanel" aria-labelledby="heading1" class="card-collapse collapse in" aria-expanded="true">
                <div class="card-body">
                  <div class="card-block">
                    <table id="table1" class="table table-hover bg-grey bg-lighten-3" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Sex</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($active_users as $row) : ?>
                        <tr>
                          <td><?php echo $row['first_name']." ";echo $row['last_name']; ?></td>
                          <td><?php echo $row['sex']; ?></td>
                          <td><?php echo $row['date_created']; ?></td>
                          <td>
                          	<center>
                          		<a class="btn btn-info btn-sm" href="<?php echo base_url() ?>users_controller/userprofile?token=<?php echo $row['id']; ?>">View Details &emsp;<i class="icon-angle-right"></i></a>
                          	</center>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div id="heading2"  class="card-header">
                <?php $rprted_users = 0; ?>
                <?php foreach ($reported_users as $rows): ?>
                <?php $rprted_users++; ?>
                <?php endforeach; ?>
                <button class="btn bg-warning bg-darken-2 white" type="button" data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="card-title lead collapsed" title="Click to view all reported users.">
                  Reported Users &nbsp;
                  <b class=" tag tag-pill bg-white warning darken-2">
                  <?php echo $rprted_users; ?>
                  </b>
                </button>
              </div>
              <div id="accordion2" role="tabpanel" aria-labelledby="heading2" class="card-collapse collapse" aria-expanded="false">
                <div class="card-body bg-grey bg-lighten-4">
                  <div class="card-block">
                    <table id="table2" class="table table-hover table-striped bg-grey bg-lighten-4" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Sex</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($reported_users as $row) : ?>
                        <tr>
                          <td><?php echo $row['first_name']." ";echo $row['last_name']; ?></td>
                          <td><?php echo $row['sex']; ?></td>
                          <td><?php echo $row['date_created']; ?></td>
                          <td>
                            <center>
                            <a class="btn btn-info btn-sm" href="<?php echo base_url() ?>users_controller/userprofile">View Details</a>
                            &emsp;<i class="icon-angle-right"></i>
                            </center>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div id="heading3"  class="card-header">
                <?php $blckd_users = 0; ?>
                <?php foreach ($blocked_users as $rows): ?>
                <?php $blckd_users++; ?>
                <?php endforeach; ?>
                <button class="btn bg-danger bg-darken-1 white" data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="card-title lead collapsed">
                  Blocked Users &nbsp;
                  <b class=" tag tag-pill bg-white danger darken-3">
                  <?php echo $blckd_users; ?>
                  </b>
                </button>
              </div>
              <div id="accordion3" role="tabpanel" aria-labelledby="heading3" class="card-collapse collapse" aria-expanded="false">
                <div class="card-body bg-grey bg-lighten-4">
                  <div class="card-block">
                    <table id="table3" class="table table-hover table-striped bg-grey bg-lighten-4" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Sex</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($blocked_users as $row) : ?>
                        <tr>
                          <td><?php echo $row['first_name']." ";echo $row['last_name']; ?></td>
                          <td><?php echo $row['sex']; ?></td>
                          <td><?php echo $row['date_created']; ?></td>
                          <td>
                            <center>
                            <a class="btn btn-info btn-sm" href="">View Details</a>
                            &emsp;<i class="icon-angle-right"></i>
                            </center>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </section>
        </div>
      </div>
    </div>