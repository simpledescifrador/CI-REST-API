 main menu-->
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
          
          <li >
            <a href="<?php echo site_url('reported_lost'); ?>" data-i18n="nav.page_layouts.2_columns" class="menu-item">Lost</a>
          </li>
          <li>
            <a href="<?php echo site_url('reported_found'); ?>" data-i18n="nav.page_layouts.boxed_layout" class="menu-item">Found</a>
          </li>
          <li class="active">
            <a href="<?php echo site_url('matched'); ?>" data-i18n="nav.page_layouts.static_layout" class="menu-item">Matched</a>
          </li>
          <li>
            <a href="<?php echo site_url('returned'); ?>" data-i18n="nav.page_layouts.light_layout" class="menu-item">Returned</a>
          </li>
        </ul>
      </li>

      <li class=" nav-item"><a href="#"><i class="icon-compass3"></i><span data-i18n="nav.project.main" class="menu-title">Barangay</span></a>
        <ul class="menu-content">
          <li><a href="<?php echo site_url('barangays'); ?>?d_number=1" data-i18n="nav.invoice.invoice_template" class="menu-item">District I</a>
          </li>
          <li><a href="<?php echo site_url('barangays'); ?>?d_number=2" data-i18n="nav.gallery_pages.gallery_grid" class="menu-item">District II</a>
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


<!--//////////////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content container-fluid">
    <div class="content-wrapper">

      <!-- BEGIN Breadcrumbs (Page Navigator) -->
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-xs-12 mb-1">
          <h2 class="content-header-title">Matched</h2>
        </div>
        <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
          <div class="breadcrumb-wrapper col-xs-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="blue" href="index.html">Home</a>
              </li>
              <li class="breadcrumb-item"><a class="blue" href="#">Items</a>
              </li>
              <li class="breadcrumb-item active">Matched
              </li>
            </ol>
          </div>
        </div>
      </div>
      <!-- END Breadcrumbs (Page Navigator) -->
      <div class="content-body">
      <section>
          <div class="card">
            <div class="card-body card-block">
              <!-- //////////////////// BEGIN Nav Tabs ////////////////////// -->
              <ul class="nav nav-tabs font-weight-bold">
                <li class="nav-item">
                  <a class="nav-link active grey darken-2" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">
                  <b class="icon-briefcase info"></b>&ensp;
                  Personal Items
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link grey darken-2" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">
                  <b class="icon-group info"></b>&ensp;
                  Persons
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link grey darken-2" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">
                  <b class="icon-paw info"></b>&ensp;
                  Pets
                  </a>
                </li>
              </ul>
              <!-- //////////////////// END Nav Tabs ////////////////////// -->

              <!-- //////////////////// BEGIN Nav Content ////////////////////// -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                  <br>
                    <div class="card">
                    <div class="card-body card-block">
                      <table class="table table-hover mb-0 bg-info" id="table1" style="width: 100%;">
                        <thead >
                          <tr>
                            <th>Item Name</th>
                            <th>Date Reported</th>
                            <th>Posted by</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="bg-info bg-lighten-4">
                        
                          <?php foreach($matched_items as $row) : ?>
                          <tr>
                            <td><?php echo $row['item_name']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['first_name']; echo " ".$row['last_name']; ?></td>
                            <td>
                              <center>
                              <a class="btn btn-blue btn-sm" href="">View Details</a>
                              </center>
                            </td>
                          </tr>
                          <?php endforeach; ?>

                        </tbody>
                      </table>
                    </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                  <br>
                    <div class="card">
                    <div class="card-body card-block">
                      <table class="table table-hover mb-0 bg-info" id="table2" style="width: 100%;">
                        <thead >
                          <tr>
                            <th>Person's Name</th>
                            <th>Date Reported</th>
                            <th>Posted by</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="bg-info bg-lighten-4">
                          <?php foreach($matched_persons as $row) : ?>
                          <tr>
                            <td>
                                <?php echo $row['p_name'];
                                  if ($row['p_name'] == null) {
                                     echo "<i class='grey'>Person's Name Undefined</i>";
                                   } 
                                ?>  
                            </td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['first_name']; echo " ".$rows['last_name'];?></td>
                            <td>
                              <center>
                              <a class="btn btn-blue btn-sm" href=""></a>
                              </center>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                  <br>
                    <div class="card">
                    <div class="card-body card-block">
                      <table class="table table-hover mb-0 bg-info" id="table3" style="width: 100%;">
                        <thead >
                          <tr>
                            <th>Pet's Name</th>
                            <th>Pet Type</th>
                            <th>Date Reported</th>
                            <th>Posted by</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="bg-info bg-lighten-4">
                          <?php foreach($matched_pets as $row) : ?>
                          <tr>
                            <td>
                              <?php echo $row['pet_name']; 
                                    if ($row['pet_name'] == null) {
                                      echo "<i class='grey' >Pet Name Undefined</i>";
                                    }
                              ?>  
                            </td>
                            <td><?php echo $row['']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['first_name']; echo " ".$row['last_name']; ?></td>
                            <td><a class="btn btn-sm btn-blue" href=""></a></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    </div>
                </div>
              </div>
              <!-- //////////////////// END Nav Content ////////////////////// -->

            </div>
          </div>
        </section>
        </div>
    </div>
</div>
<!--//////////////////////////////////////////////////////////////////////////////////////