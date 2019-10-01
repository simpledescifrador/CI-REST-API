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

<!-- ///////////////////////////////////////////////////////////////////////////////////// -->
<div class="app-content content container-fluid">
  <div class="content-wrapper">
  
  <div class="content-header row">
      <div class="content-header-left col-md-6 col-xs-12 mb-1">
        <h2 class="content-header-title">User Profile</h2>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
        <div class="breadcrumb-wrapper col-xs-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="blue" href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item"><a class="blue" href="#">Users</a>
            </li>
            <li class="breadcrumb-item active">User Profile
            </li>
          </ol>
        </div>
      </div>
    </div>
    <?php $r=0;$r1=0; $counter = 0; foreach ($mUser_rating as $rows) : ?>
    <?php $r = $rows['rating'];
      $r1+=$r;
      $counter++; 
    ?>
    <?php endforeach; ?>
    <?php
      if ($counter != 0) {
        $total_rating = $r1/$counter;
      }else{
        $total_rating = 0;
      }
     ?>

    <div class="card">
      <div class="card-body card-block">
        <div class="row">
              <?php foreach($mUser_details as $row): ?>
          <div class="col-sm-3">
            <img class="img-thumbnail" src="http://makatizen.x10host.com/<?php echo $row['image']; ?>" />
          </div>
          <div class="col-sm-9">
            <div class="pl-2 pr-2 pt-3">
              
              <h2><?php echo $row['first_name']." ";echo $row['middle_name']." ";echo $row['last_name']; ?></h2>
              
              <b class="icon-phone success darken-2"></b> <?php echo $row['contact_number']; ?> <br><br>
              <?php endforeach; ?>
              <h5>Honesty Rating: 
                <?php
                $count_stars = 0;
                for ($i=0; $i < $total_rating; $i++) { 
                  echo "<i class='icon-star yellow darken-2'></i> ";
                  $count_stars++;
                } 
                
                if ($count_stars == 0) {
                  echo "<small class='grey'>No Rating</small>";
                }
                else{
                  echo "<b class='secondary lead'> ".number_format($total_rating,1, '.', '')."</b>";
                }
              ?>
              </h5> 

            </div>
          </div>
        </div>
        <!-- BEGIN User Details -->
        <hr>
        <div class="row p-1">
          <?php foreach($mUser_details as $row): ?>
          <div class="col-sm-8">
            <table style="width: 100%;" class="table-hover" >
              <tr>
                <td class="text-muted">Address: </td>
                <td><?php echo ucwords($row['address']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Email Address: </td>
                <td><?php echo $row['email_address']; ?></td>
              </tr>
              <tr>
                <td class="text-muted">Phone Number: </td>
                <td><?php echo $row['contact_number']; ?></td>
              </tr>
              <tr>
                <td class="text-muted">Sex: </td>
                <td><?php echo ucfirst($row['sex']); ?></td>
              </tr>
              <tr>
                <td class="text-muted">Civil Status: </td>
                <td><?php echo $row['civil_status']; ?></td>
              </tr>
            </table>
          </div>
          <div class="col-sm-4">
            <table style="width: 100%;" class="table-hover">
              <tr>
                <td class="text-muted">Account Status:</td>
                <td>
                  <?php $status=$row['status']; 
                    if ($status == 'New') {
                      echo "New &nbsp;
                      <i class='primary icon-check-square'></i>";
                    }
                    elseif($status == 'Active'){
                      echo "Active &nbsp;
                      <i class='success icon-circle'></i>";
                    }
                    elseif ($status == 'Reported') {
                      echo "Reported &nbsp;
                      <i class='danger icon-exclamation-triangle'></i>";
                    }
                    elseif ($status == 'Banned') {
                      echo "Banned &nbsp;
                      <i class='danger icon-times-circle'></i>";
                    }
                  ?>
                  &emsp;&emsp;&emsp;&nbsp;
                </td>
              </tr>
              <tr>
                <td class="text-muted">Date Joined: </td>
                <td>07/11/2019</td>
              </tr>
            </table>
          </div>
          <?php endforeach; ?>
        </div>
        <?php  
          $lost_report = 0; //initialize lost reports counter
          $found_report = 0;//initialize found reports counter
        ?>
        <?php $posts=0; foreach ($mUser_posts as $row): ?>
        <?php $posts++; ?>
        <?php
          $report_type = $row['type'];
          if ($report_type == 'Lost') { //get rows of reported lost
            $lost_report++;
           }
           elseif ($report_type == 'Found') { //get rows of reported found
              $found_report++;
            } 
        ?>
        <?php endforeach; ?>
        <?php $total_posts = $lost_report+$found_report; ?>
        
        <!-- END User Details -->

      </div>
    </div>
    <section>
        	<div class="card card-body card-block">
        		<ul class="nav nav-tabs">
		            <li class="nav-item">
		              <a class="nav-link active" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="true">&emsp;&emsp; Posts <b class="tag tag-pill bg-red bg-darken-1"><?php echo $total_posts; ?></b>&emsp;&emsp;</a>
		            </li>
		            <li class="nav-item">
		              <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">&emsp;&emsp; Gallery &emsp;&emsp;</a>
		            </li>
		          </ul>
		          <div class="tab-content px-1 pt-2">
		              <div class="tab-pane active" id="tab2" aria-labelledby="base-tab2">
		                <table id="transaction1" class="table table-sm table-hover">
		                  <thead>
		                    <tr>
		                      <th>Title</th>
		                    </tr>
		                  </thead>
		                  <tbody class="bg-grey bg-lighten-3">
		                    <tr>
		                      <td>asdasd</td>
		                    </tr>
		                  </tbody>
		                </table>
		              </div>
		              <div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
		                <p>Biscuit ice cream halvah candy canes bear claw ice cream cake chocolate bar donut. Toffee cotton candy liquorice. Oat cake lemon drops gingerbread dessert caramels. Sweet dessert jujubes powder sweet sesame snaps.</p>
		              </div>
		            </div>
        	</div>
          
        </section>
  </div>
</div>
<!-- ///////////////////////////////////////////////////////////////////////////////////// -->