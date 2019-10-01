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
              <li class="active">
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
          <li class="nav-item">
            <a href="<?php echo site_url('users_controller'); ?>">
            <i class="icon-user4"></i>
              <span class="">Users</span>
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
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-xs-12 mb-1">
            <h2 class="content-header-title">Create Account</h2>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
            <div class="breadcrumb-wrapper col-xs-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="blue" href="index.html">Home</a>
                </li>
                <li class="breadcrumb-item"><a class="blue" href="#">Barangay</a>
                </li>
                <li class="breadcrumb-item active">Create Account
                </li>
              </ol>
            </div>
          </div>
        </div>

        <div class="content-body">
          <div class="card">
            <div class="card-header">
              <b class="icon-user-plus2"></b> Register new account for Barangay
            </div>
            <div class="card-body card-block">
              <?php echo form_open_multipart('dashboard_controller/newbrgyuser'); ?>
                <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="first_name">First Name</label>
                      <input type="text" id="first_name" class="form-control" name="f_name" placeholder="Enter First Name" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="middle_name">Middle Name</label>
                      <input type="text" id="middle_name" class="form-control" name="m_name" placeholder="Enter Middle Name" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="last_name">Last Name</label>
                      <input type="text" id="last_name" class="form-control" name="l_name" placeholder="Enter Last Name" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label for="sex">Sex</label>
                    <select type="text" class="form-control" name="sex">
                      <option value="1">Male</option>
                      <option value="2">Female</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="file_name">Add Profile Picture</label><br>
                    <input style="border: solid gray;width: 100%;" class="bg-grey white" type="file" name="file_name">
                    <small class="text-muted">*File must be on image format.</small>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email Address</label>
                      <input id="email" type="email" name="email" class="form-control" placeholder="example@gmail.com" required="email">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <input name="address" class="form-control" placeholder="House no. Street Brgy, City" required>
                </div>
                <h4 class="form-section"><i class="icon-check-square"></i>User Assignment</h4><br>
                <div class="row">
                  <label for="assign" class="col-sm-2 col-form-label">Assign user to: </label>
                  <div class="col-sm-4">
                    <div class="input-group mb-3">
                      <div class="input-group-addon">
                        <span class="input-group-text" id="">Brgy</span>
                      </div>
                    <select name="assign" class="form-control">
                      <option value="1">Bangkal</option>
                      <option value="2">Bel-Air</option>
                      <option value="3">Carmona</option>
                      <option value="4">Cembo</option>
                      <option value="5">Comembo</option>
                      <option value="6">Dasmarinas</option>
                      <option value="7">East Rembo</option>
                      <option value="8">Forbes Park</option>
                      <option value="9">Guadalupe Nuevo</option>
                      <option value="10">Guadalupe Viejo</option>
                      <option value="11">Kasilawan</option>
                      <option value="12">Magallanes</option>
                      <option value="13">Northside</option>
                      <option value="14">Olympia</option>
                      <option value="15">Palanan</option>
                      <option value="16">Pembo</option>
                      <option value="17">Pinagkaisahan</option>
                      <option value="18">Pio Del Pilar</option>
                      <option value="19">Pitogo</option>
                      <option value="20">Poblacion</option>
                      <option value="21">Rizal</option>
                      <option value="22">San Antonio</option>
                      <option value="23">San Isidro</option>
                      <option value="24">San Lorenzo</option>
                      <option value="25">Singkamas</option>
                      <option value="26">South Cembo</option>
                      <option value="27">Sta. Cruz</option>
                      <option value="28">Tejeros</option>
                      <option value="29">Urdaneta</option>
                      <option value="30">Valenzuela</option>
                      <option value="31">West Rembo</option>
                    </select>
                    </div>
                  </div>
                  <label class="col-sm-2 col-form-label text-xs-right">Job Title:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="job_title" placeholder="Enter Job Title" required >
                  </div>
                </div>


            </div>
            <div class="card-footer text-xs-right">
              <button type="reset" class="btn btn-secondary">Clear Input</button>
              <button type="button" class="btn btn-outline-blue" data-toggle="modal" data-target="#small">Register</button>
              <!-- Modal -->
                  <div class="modal fade text-xs-left" id="small" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h4 class="modal-title" id="myModalLabel19">Confirm Action</h4>
                      </div>
                      <div class="modal-body">
                      <p>Continue with Barangay Account Registration?</p>
                      </div>
                      <div class="modal-footer">
                      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" name="upload" value="Upload" class="btn btn-blue" >Create Account</button>
                      </div>
                    </div>
                    </div>
                  </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>