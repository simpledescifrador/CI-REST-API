    
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
          <li class="nav-item active">
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
      <div class="content-wrapper">
        

        <!-- BEGIN Alerts -->
        <?php if($alert_type != null ):  ?>
        <div class="alert alert-dismissible fade in <?php echo $alert_type; ?> mb-2">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <span><b><?php echo $alert_message; ?></b></span>
        </div>
        <?php endif; ?>
        <!-- BEGIN Alerts -->
        
        <div class="content-body">
        <!--BEGIN minimal statistics card -->
        <section id="minimal-statistics-bg">
          <div class="row">
            <div class="col-xl-3 col-lg-6 col-xs-12">
                <div class="card bg-warning">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <i class="icon-emoticon6 white font-large-2 float-xs-left"></i>
                                </div>
                                <div class="media-body white text-xs-right">
                                    <h3 id="total_lost">0</h3>
                                    <span>Lost</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-xs-12">
                <div class="card bg-success">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <i class="icon-emoticon1 white font-large-2 float-xs-left"></i>
                                </div>
                                <div class="media-body white text-xs-right">
                                    <h3 id="total_found">0</h3>
                                    <span>Found </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-xs-12">
                <div class="card bg-info">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <i class="icon-checkmark22 white font-large-2 float-xs-left"></i>
                                </div>
                                <div class="media-body white text-xs-right">
                                    <h3 id="total_matched">0</h3>
                                    <span>Matched </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-xs-12">
                <div class="card bg-cyan">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <i class="icon-gift white font-large-2 float-xs-left"></i>
                                </div>
                                <div class="media-body white text-xs-right">
                                    <h3 id="total_returned">0</h3>
                                    <span>Returned</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </section>
        <!--END minimal statistics card -->
        <!--BEGIN Charts -->
        <section>
          <div class="row match-height">
            <div class="col-sm-8 ">
              <div class="card">
                <div class="card-body card-block">
                        <canvas id="area-chart" height="400"></canvas>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <div class="card-body card-block">
                   <canvas id="simple-doughnut-chart" height="400"></canvas>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--END Charts -->

        <section>
          <div class="row">
            <div class="col-sm-4">
              <div class="card">
                <div class="card-body">
                  <div class="media">
                    <div class="p-2 text-xs-center bg-blue media-left media-middle">
                        <i class="icon-users font-large-2 white"></i>
                    </div>
                    <div class="p-2 media-body">
                        <h5 class="blue">Active Users</h5>
                        <h5 class="text-bold-400">
                          <?php $actv_users=0; ?>
                          <?php foreach($active_users as $row) : ?>
                          <?php $actv_users++; ?>
                          <?php endforeach; ?>
                          <?php echo $actv_users; ?>
                        </h5>
                        <progress class="progress progress-sm progress-blue mt-1 mb-0" value="<?php echo $actv_users; ?>" max="<?php echo $actv_users; ?>0">
                        </progress>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="media">
                    <div class="p-2 text-xs-center bg-warning media-left media-middle">
                        <i class="icon-warning font-large-2 white"></i>
                    </div>
                    <div class="p-2 media-body">
                        <h5 class="warning">Reported Users</h5>
                        <h5 class="text-bold-400">
                        <?php $rprted_users=0; ?>
                        <?php foreach($reported_users as $row) : ?>
                        <?php $rprted_users++; ?>
                        <?php endforeach; ?>
                        <?php echo $rprted_users; ?>
                        </h5>
                        <progress class="progress progress-sm progress-warning mt-1 mb-0" value="<?php echo $rprted_users; ?>" max="<?php $rprted_users; ?>0">
                        </progress>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="media">
                    <div class="p-2 text-xs-center bg-red media-left media-middle">
                        <i class="icon-user3 font-large-2 white"></i>
                    </div>
                    <div class="p-2 media-body">
                        <h5 class="red darken-2">Blocked Users</h5>
                        <h5 class="text-bold-400">
                        <?php $blckd_users=0; ?>
                        <?php foreach($blocked_users as $row) : ?>
                        <?php $blckd_users++; ?>
                        <?php endforeach; ?>
                        <?php echo $blckd_users; ?>
                        </h5>
                        <progress class="progress progress-sm progress-red mt-1 mb-0" value="<?php echo $blckd_users; ?>" max="<?php echo $blckd_users; ?>0">
                        </progress>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title"><i class="icon-undo3 blue"></i> Recent Transactions</h5>
                  <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
                </div>
                <div class="card-body" style="">
                  <table class="table table-sm table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Date Started</th>
                        <th>Posted By</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($recent_transactions_items as $row) : ?>
                      <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['transaction_confirmed']; ?></td>
                        <td><?php echo $row['first_name']; echo " ". $row['last_name']; ?></td>
                        <td><button class="btn btn-info btn-sm">View</button></td>
                      </tr>
                      <?php endforeach; ?>
                      <?php foreach($recent_transactions_pets as $row) : ?>
                      <tr>
                        <td><?php echo $row['pet_name']; ?></td>
                        <td><?php echo $row['transaction_confirmed']; ?></td>
                        <td><?php echo $row['first_name']; echo " ". $row['last_name']; ?></td>
                        <td><button class="btn btn-info btn-sm">View</button></td>
                      </tr>
                      <?php endforeach; ?>
                      <?php foreach($recent_transactions_persons as $row) : ?>
                      <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['transaction_confirmed']; ?></td>
                        <td><?php echo $row['first_name']; echo " ". $row['last_name']; ?></td>
                        <td><button class="btn btn-info btn-sm">View</button></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              
            </div>
          </div>
        </section>
        </div>
        <!--END Graphs and statistics-->
        <script type="text/javascript">
          $(document).ready(function (){
            setInterval(function(){
              $.ajax({
                url: "<?php echo site_url('dashboard_controller/dashboard_data'); ?>",
                method: 'GET',
                dataType: 'json', 
                success: function (json){
                    var result = [];

                    for(var i in json) {
                      result.push([i, json[i]]);
                    }
                    var lost_count = result[0][1];
                    var found_count = result[1][1];
                    var returned_count = result[2][1];
                    var matched_count = result[3][1];
                    console.log(result);
                    $("#total_lost").text(lost_count);
                    $("#total_found").text(found_count);
                    $("#total_returned").text(returned_count);
                    $("#total_matched").text(matched_count);
                }

              });
            }, 1000);
          });
        </script>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    
    