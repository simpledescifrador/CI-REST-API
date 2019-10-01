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
          <li class="nav-item active">
            <a href="<?php echo site_url('transactions'); ?>">
            <i class="icon-refresh2"></i>
              <span class="menu-title">Transactions</span>
            </a>
          </li>
          <li class="nav-item">
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

    <div class="app-content content container-fluid">
      <div class="content-wrapper">

        <!-- BEGIN Breadcrumbs (Page Navigator) -->
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-xs-12 mb-1">
            <h2 class="content-header-title">Transactions</h2>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
            <div class="breadcrumb-wrapper col-xs-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="blue" href="index.html">Home</a>
                </li>
                <li class="breadcrumb-item grey"><a >Transactions</a>
                </li>
              </ol>
            </div>
          </div>
        </div>
        <!-- END Breadcrumbs (Page Navigator) -->

        <div class="content-body">

          <section>
            <div class="card">
              <div class="card-header">
                <i class="icon-info"></i>
                <i class="grey darken-2">Click the item name to view the details of each transation.</i>
              </div>
              <div class="card-body p-1">
               <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">
                    <b class="grey darken-2">
                      &emsp;
                      <b class="info icon-refresh2"></b>&ensp;
                      On Going 
                      <span class="tag tag-pill tag-danger">5</span>
                      &emsp;
                    </b>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">
                    <b class="grey darken-2">
                      &emsp;
                      <b class="success icon-check"></b>&ensp;
                      Finished
                      &emsp;
                    </b>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">
                    <b class="grey darken-2">
                      &emsp;
                      <b class="danger icon-close2"></b>&ensp;
                      Failed
                      &emsp;
                    </b>
                    </a>
                  </li>
                </ul>
                <div class="tab-content px-1 pt-1">
                  <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                    <table style="width: 100%;border-color:white;" class="table table-hover" id="transaction1">
                      <thead>
                        <tr>
                          <th>Item Names</th>
                         
                        </tr>
                      </thead>
                      <tbody class="bg-grey bg-lighten-4 menu-accordion">
                        <?php $i = 1; ?>
                        <?php foreach($confirmed_transaction as $rows): ?>
                        <?php $i++; ?>
                        <tr>
                          <td  data-toggle="collapse" href="#ongoing<?php echo $i; ?>" role="button" aria-expanded="false" aria-controls="#ongoing<?php echo $i; ?>">
                            
                            <div class="row">
                              <div class="col-xs-8">
                                <b><?php echo $rows['item_title']; ?></b> : Transaction between <?php echo $rows['account1_name'];?> and <?php echo $rows['account2_name']; ?>
                              </div>
                              <div class="col-sm-3 text-xs-right grey darken-4">
                                <i><?php echo $rows['date_confirmed'] ?></i>
                              </div>
                            </div>
                            <div class="collapse " id="ongoing<?php echo $i; ?>" data-parent="on-going">
                              <br>
                              <div class="progressbar-container">
                                <ul class="progressbar">
                                  <li class="<?php echo $rows['processing_status']; ?>">Processing</li>
                                  <li class="<?php echo $rows['meetup_status']; ?>">Meet-up</li>
                                  <li class="">Item Returned</li>
                                </ul>
                              </div>
                              <div class="t-row"><br><br><br><br><br>
                                <div class="col-sm-3">
                                  <img class="img-thumbnail" src="<?php echo base_url(); ?>assets/app-assets/images/elements/02.png">
                                </div>
                                <div class="col-sm-8">
                                  Found by: <b>John</b><br>
                                  Being Claimed by: <b>Jane</b><br>
                                  Location Found: <b>Makati</b><hr>
                                  Item Details: <b>The quick brown fox jumps over the lazy dog</b>
                                </div>
                              </div>
                            </div>
                            
                          </td>
                        </tr>
                        <?php endforeach;?>   
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                    <table style="width: 100%;border-color:white;" class="table table-hover" id="transaction2">
                      <thead>
                        <tr>
                          <th>Item Names</th>
                        </tr>
                      </thead>
                      <tbody class="bg-grey bg-lighten-4 menu-accordion">
                        <tr>
                          <td  data-toggle="collapse" href="#finished1" role="button" aria-expanded="false" aria-controls="finished1">
                            <div class="row">
                              <div class="col-xs-8">
                                <b>Office Documents</b> : Transaction between John and Jane
                              </div>
                              <div class="col-sm-3 text-xs-right grey darken-4">
                                <i>Aug. 29</i>
                              </div>
                            </div>
                            <div class="collapse " id="finished1" data-parent="finished">
                              <br>
                              <div class="progressbar-container">
                                <ul class="progressbar">
                                  <li class="active">Processing</li>
                                  <li class="active">Meet-up</li>
                                  <li class="active">Item Returned</li>
                                </ul>
                              </div>
                              <div class="t-row"><br><br><br><br><br>
                                <div class="col-sm-3">
                                  <img class="img-thumbnail" src="<?php echo base_url(); ?>assets/app-assets/images/elements/02.png">
                                </div>
                                <div class="col-sm-8">
                                  Returned by: <b>John</b><br>
                                  Returned to: <b>Jane</b><br>
                                  Location Found: <b>Makati</b><hr>
                                  Item Details: <b>The quick brown fox jumps over the lazy dog</b>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                    <table style="width: 100%;border-color:white;" class="table table-hover" id="transaction3">
                      <thead>
                        <tr>
                          <th>Item Names</th>
                        </tr>
                      </thead>
                      <tbody class="bg-grey bg-lighten-4 menu-accordion">
                        <tr>
                          <td  data-toggle="collapse" href="#failed1" role="button" aria-expanded="false" aria-controls="failed1">
                            <div class="row">
                              <div class="col-xs-8">
                                <b>Office Documents</b> : Transaction between John and Jane
                              </div>
                              <div class="col-sm-3 text-xs-right grey darken-4">
                                <i>Aug. 29</i>
                              </div>
                            </div>
                            <div class="collapse " id="failed1" data-parent="finished">
                              <br>
                              <div class="progressbar-container">
                                <ul class="progressbar">
                                  <li class="active">Processing</li>
                                  <li class="failed">Meet-up</li>
                                  <li class="failed">Transaction Failed</li>
                                </ul>
                              </div>
                              <div class="t-row"><br><br><br><br><br>
                                <div class="col-sm-3">
                                  <img class="img-thumbnail" src="<?php echo base_url(); ?>assets/app-assets/images/elements/02.png">
                                </div>
                                <div class="col-sm-8">
                                  Returned by: <b>John</b><br>
                                  Returned to: <b>Jane</b><br>
                                  Location Found: <b>Makati</b><hr>
                                  Item Details: <b>The quick brown fox jumps over the lazy dog</b>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- END SECTION -->
        </div>
        <!-- END CONTENT BODY -->
      </div>
    </div>


    