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
          <li class=" nav-item">
            <a href="<?php echo site_url('users_controller'); ?>">
            <i class="icon-user4"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item active">
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

        <div class="card" >
          <div class="card-header">

          </div>
          <div class="card-body card-block" id="print_monthly">
            <div class="row">
              <div class="col-sm-7">
                <br>
                <br>
                <h1 class="grey display-4">Monthly Report</h1>
                <h1 class="blue">Maka-Hanap</h1>
                <b>Lost & Found Application</b>
              </div>
              <div class="col-sm-5">
                <center >
                  <img src="<?php echo base_url(); ?>assets/custom/img/m-circle.png" style="opacity: 0.5;" width="240" >
                </center>
              </div>
            </div>
            <b>Month: </b> <?php $dateObj = DateTime::createFromFormat('!m', date('m')); echo $dateObj->format('F');?> <!-- To be Edited -->
            <hr class="blue">
            <h4><b class="icon-file"></b>&nbsp;&nbsp;Number of Posts</h4>
            <i class="grey">Table 1.0: Number of Posts from Android Application Users and Barangay Admin</i>
            <table style="width: 100%;" class="table table-bordered">
              <thead>
                <tr>
                  <th class="bg-warning bg-lighten-2"> </th>
                  <th colspan="2" class="bg-info" >
                    <center>Posts From Android App Users <b class="tag-pill bg-white info"><?php echo $total_mobile_report_count; ?></b></center>
                  </th>
                  <th colspan="2" class="bg-green">
                    <center>Posts From Barangay Admin <b class="tag-pill bg-white green"><?php echo $total_brgy_report_count; ?></b></center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="bg-warning bg-lighten-2"> </td>
                  <td class="bg-info bg-lighten-4">
                    <center>Lost</center>
                  </td>
                  <td class="bg-info bg-lighten-4">
                    <center>Found</center>
                  </td>
                  <td class="bg-green bg-lighten-4">
                    <center>Lost</center>
                  </td>
                  <td class="bg-green bg-lighten-4">
                    <center>Found</center>
                  </td>
                </tr>
              </tbody>
              <tfoot class="bg-white">
                <tr>
                  <td class="bg-warning bg-lighten-2">Pets: </td>
                  <td>
                    <center><?php echo $lost_pet_count; ?></center>
                  </td>
                  <td>
                    <center><?php echo $found_pet_count; ?></center>
                  </td>
                  <td>
                    <center>0</center>
                  </td>
                  <td>
                    <center>0</center>
                  </td>
                </tr>
                <tr>
                  <td class="bg-warning bg-lighten-2">
                    Persons:
                  </td>
                  <td>
                    <center><?php echo $lost_person_count; ?></center>
                  </td>
                  <td>
                    <center><?php echo $found_person_count; ?></center>
                  </td>
                  <td>
                    <center>0</center>
                  </td>
                  <td>
                    <center>0</center>
                  </td>
                </tr>
                <tr>
                  <td class="bg-warning bg-lighten-2">
                    Personal Items:
                  </td>
                  <td>
                    <center><?php echo $lost_pt_count; ?></center>
                  </td>
                  <td>
                    <center><?php echo $found_pt_count; ?></center>
                  </td>
                  <td>
                    <center>0</center>
                  </td>
                  <td>
                    <center>0</center>
                  </td>
                </tr>
                <tr>
                  <td class="bg-warning bg-lighten-2">
                    Total:
                  </td>
                  <td>
                    <center><?php echo ($lost_pet_count + $lost_person_count + $lost_pt_count); ?></center>
                  </td>
                  <td>
                    <center><?php echo ($found_pet_count + $found_person_count + $found_pt_count); ?></center>
                  </td>
                  <td>
                    <center>0</center>
                  </td>
                  <td>
                    <center>0</center>
                  </td>
                </tr>
              </tfoot>
            </table>
            <p style="width: 100%;" class="p-1 bg-grey bg-lighten-4"><b>Table 1.0 Summary: </b></p>
            <div class="row">
              <div class="col-sm-6">
                <ul>
                  <li>Number of Reported Pets: <?php echo ($lost_pet_count + $found_pet_count); ?></li>
                  <li>Number of Reported Persons: <?php echo ($lost_person_count + $found_person_count); ?></li>
                </ul>
              </div>
              <div class="col-sm-6">
                <ul>
                  <li>Number of Reported Personal Thing: <?php echo ($lost_pt_count + $found_pt_count); ?></li>
                  <li>Total Number of Posts: <?php echo ($lost_pet_count + $found_pet_count + $lost_person_count + $found_person_count + $lost_pt_count + $found_pt_count)?></li>
                </ul>
              </div>
            </div>
            <h4><b class="icon-refresh2"></b>&nbsp;&nbsp;Returned Items</h4>
            <i class="grey">Table 2.0:  Number of Returned Items</i>
            <table class="table table-bordered">
                <tr>
                  <td class="bg-warning ">Pets</td>
                  <td style="width: 3em;"><?php echo $return_pet_count; ?></td>
                  <td class="bg-warning ">Persons</td>
                  <td style="width: 3em;"><?php echo $return_person_count; ?></td>
                  <td class="bg-warning ">Personal Items</td>
                  <td style="width: 3em;"><?php echo $return_pt_count; ?></td>
                </tr>
            </table>
            <h4><b class="icon-users3"></b>&nbsp;&nbsp;Users</h4>
            <p style="width: 100%;" class="p-1 bg-grey bg-lighten-4"><b>Number of Users sorted by status.</b></p>
            <div class="row">
              <div class="col-sm-6">
                <ul>
                  <li>Active Users: 0</li>
                  <li>Reported Users: 0</li>
                </ul>
              </div>
              <div class="col-sm-6">
                <ul>
                  <li>Blocked Users: 0</li>
                </ul>
              </div>
            </div>
            <p style="width: 100%;" class="p-1 bg-grey bg-lighten-4"><b>Number of Users sorted by type.</b></p>
            <div class="row">
              <div class="col-sm-6">
                <ul>
                  <li>Barangay Admin: 0</li>
                </ul>
              </div>
              <div class="col-sm-6">
                <ul>
                  <li>Adroid App: 0</li>
                </ul>
              </div>
            </div>
          </div>
        </div>


          <button onclick="printDiv('print_monthly')" class="btn btn-blue" style="position:fixed; right:2px; bottom:0; margin:40px;">
            <b style="font-size: 30px;" class="icon-printer4"></b>
          </button>

      </div>
    </div>

    <script>
    function printDiv(divName){
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  </script>