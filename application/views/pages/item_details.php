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
          
          <li class="<?php echo $lost_nav; ?>">
            <a href="<?php echo site_url('reported_lost'); ?>" data-i18n="nav.page_layouts.2_columns" class="menu-item">Lost</a>
          </li>
          <li class="<?php echo $found_nav; ?>">
            <a href="<?php echo site_url('reported_found'); ?>" data-i18n="nav.page_layouts.boxed_layout" class="menu-item">Found</a>
          </li>
          <li class="<?php echo $matched_nav; ?>">
            <a href="<?php echo site_url('matched'); ?>" data-i18n="nav.page_layouts.static_layout" class="menu-item">Matched</a>
          </li>
          <li class="<?php echo $returned_nav; ?>">
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
      <li class="nav-item">
        <a href="reports">
          <i class="icon-whatshot"></i>
          <span class="menu-title">Reports</span>
        </a>
      </li>
      <li class=" nav-item">
        <a href="<?php echo site_url('users_controller'); ?>">
        <i class="icon-user4"></i>
          <span class="menu-title">Users</span>
        </a>
      </li>

      <li class=" nav-item">
        <a href="#"Posted>
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
          <h2 class="content-header-title">
            <?php foreach($report_type as $rows) : ?>
            <?php echo $rows['report_type']; ?>
            <?php endforeach; ?>
          </h2>
        </div>
        <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
          <div class="breadcrumb-wrapper col-xs-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="blue" href="<?php echo base_url(); ?>dashboard">Home</a>
              </li>
              <li class="breadcrumb-item">
                <?php echo $recent_page; ?>
              </li>
              <li class="breadcrumb-item active">
                <?php foreach($report_type as $rows) : ?>
                <?php echo $rows['report_type']; ?>
                <?php endforeach; ?>

              </li>
            </ol>
          </div>
        </div>
      </div>
      <!-- END Breadcrumbs (Page Navigator) -->

    <div class="content-body">

      <div class="card">
      <div class="card-body card-block">
        
        <div class="card">
          <div class="row">
            <div class="col-sm-5">
              <div id="carousel-pause" class="carousel slide" data-ride="carousel" data-pause="hover">
                <ol class="carousel-indicators">
                  <?php $slide_counter = 0;
                        $active_slide = '';
                  ?>
                  <?php foreach($item_image as $rows) : ?>
                  <?php
                    
                    if ($slide_counter == 0) {
                      $active_slide = 'active';
                    }
                  ?>
                  <li data-target="#carousel-pause" data-slide-to="<?php echo $slide_counter; ?>" class="<?php echo $active_slide; ?>"></li>
                  <?php 
                      $active_slide = '';
                      $slide_counter++;
                  ?>
                  <?php endforeach; ?>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <?php $slide_counter = 0; ?>
                  <?php foreach($item_image as $rows) : ?>
                  <?php
                    if ($slide_counter == 0) {
                       $active_slide = 'active';
                     }
                     else{
                        $active_slide = '';
                     } 
                  ?>
                  <div class="carousel-item item_detail_slide <?php echo $active_slide; ?>">
                    <center>
                    <a href="<?php echo base_url().$rows['file_path']; ?>" data-lightbox="post_image">
                    <img style="width:250px;height:250px;" src="<?php echo base_url().$rows['file_path']; ?>" alt="">
                    </a>
                    </center>
                  </div>
                  <?php $slide_counter++; ?>
                  <?php endforeach; ?>
                </div>
                <a class="left carousel-control" href="#carousel-pause" role="button" data-slide="prev">
                  <span class="icon-prev" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-pause" role="button" data-slide="next">
                  <span class="icon-next" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
            <div class="col-sm-7 ">
              <div class="pr-2 pl-2">
                <?php switch ($item_type) :
                   case 'Lost': ?>
                    <?php foreach($lost_item_details as $rows) : ?>
            
                    
                    <br>
                    <h1><?php echo $rows['item_name']; ?></h1>
                    <hr>
                    Posted By: 
                      <a class="text-bold-700" href="#">
                      <?php echo $rows['first_name']." ";echo $rows['last_name']; ?>  
                      </a>
                    <br><br><br>
                    <span class="text-muted">Item Description: </span>
                    <p><?php echo $rows['item_description']; ?></p>
                    <br><br>
                  </div>
                </div>
              </div>
            </div>
            <h4>Item Details</h4>
            
            <div class="row">
              <div class="col-xs-6">
                <table style="width: 100%">
                  <tr>
                    <td><span class="text-muted">Date Lost: </span> <?php echo $rows['date_lost']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Status: </span>
                      <span class="tag tag-pill tag-info"><?php echo $rows['post_status']; ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Location Lost: </span> <?php echo $rows['l_locationName']; ?></td>
                  </tr>
                </table>
              </div>
              <div class="col-xs-6">
                <table style="width: 100%">
                  <tr>
                    <td><span class="text-muted">Category: </span> <?php echo $rows['item_category']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Brand: </span> <?php echo $rows['brand']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Color: </span> <?php echo $rows['item_color']; ?> 
                    <i class="<?php echo strtolower(str_replace(' ', '', $rows['item_color'])); ?> icon-circle"></i>
                  </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer text-sm-right">
            <i class="text-muted">Posted:
            <?php echo $rows['date_created']; ?>
            </i> 
            
            </div>
        </div>
          <?php endforeach; ?>
          <?php foreach($lost_pet_details as $rows) : ?>
            
                    
                    <br>
                    <h1>
                      <?php  if ($rows['pet_name'] == null) {
                        echo "<i class='grey'>Pet Name Undefined</i>";
                      }
                      else{
                        echo $rows['pet_name'];
                      } 
                      ?>
                    </h1>
                    <hr>
                    Posted By: 
                      <a class="text-bold-700" href="#">
                      <?php echo $rows['first_name']." ";echo $rows['last_name']; ?>  
                      </a>
                    <br><br><br>
                    <span class="text-muted">Pet Description: </span>
                    <p><?php echo $rows['description']; ?></p>
                    <br><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Date Lost: </span> <?php echo substr($rows['date'], 0,10); ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Status: </span>
                      <span class="tag tag-pill tag-info"><?php echo $rows['post_status']; ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="text-muted">Location Lost: </span> <?php echo $rows['location_address']; ?>
                    </td>
                  </tr>
        
                </table>
              </div>
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Pet Type: </span> <?php echo $rows['pet_type']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Breed: </span> <?php echo $rows['breed']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Pet Condition: </span> <?php echo $rows['pet_condition']; ?> 
                  </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="text-sm-right">
            <i class="text-muted">Posted <?php echo substr($rows['date_reported'], 11,8) ?> 
            <?php echo substr($rows['date_reported'], 0,10); ?>
            </i>  
            
            </div>
          </div>
        </div>
          <?php endforeach; ?>
          
          <?php foreach($lost_person_details as $rows) : ?>
            
                    
                    <br>
                    <h1>
                      <?php  if ($rows['p_name'] == null) {
                        echo "<i class='grey'>Person's Name Undefined</i>";
                      }
                      else{
                        echo $rows['p_name'];
                      } 
                      ?>
                    </h1>
                    <hr>
                    Posted By: 
                      <a class="text-bold-700" href="#">
                      <?php echo $rows['first_name']." ";echo $rows['last_name']; ?>  
                      </a>
                    <br><br><br>
                    <span class="text-muted">Person's Description: </span>
                    <p><?php echo $rows['description']; ?></p>
                    <br><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Date Lost: </span> <?php echo substr($rows['date'], 0,10); ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Status: </span>
                      <span class="tag tag-pill tag-info"><?php echo $rows['item_status']; ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="text-muted">Location Lost: </span> <?php echo $rows['p_location_add']; ?>
                    </td>
                  </tr>
        
                </table>
              </div>
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Age Group: </span> <?php echo $rows['age_group']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Age Range: </span> <?php echo $rows['age_range']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Sex: </span> <?php echo $rows['p_sex']; ?> 
                  </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="text-sm-right">
            <i class="text-muted">Posted <?php echo substr($rows['published_at'], 11,8) ?> 
            <?php echo substr($rows['published_at'], 0,10); ?>
            </i>  
            
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php break; ?>
        <?php case 'Found': ?>
        <?php foreach($found_item_details as $rows) : ?>
            
                    
                    <br>
                    <h1><?php echo $rows['item_name']; ?></h1>
                    <hr>
                    Posted By: 
                      <a class="text-bold-700" href="#">
                      <?php echo $rows['first_name']." ";echo $rows['last_name']; ?>  
                      </a>
                    <br><br><br>
                    <span class="text-muted">Item Description: </span>
                    <p><?php echo $rows['item_description']; ?></p>
                    <br><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Date Found: </span> <?php echo $rows['date_found']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Status: </span>
                      <span class="tag tag-pill tag-info"><?php echo $rows['post_status']; ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Location Found: </span> <?php echo $rows['f_locationName']; ?></td>
                  </tr>
                </table>
              </div>
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Category: </span> <?php echo $rows['item_category']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Brand: </span> <?php echo $rows['brand']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Color: </span> <?php echo $rows['item_color']; ?> 
                    <i class="<?php echo $rows['item_color']; ?> icon-circle"></i>
                  </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="text-sm-right">
            <i class="text-muted">Posted <?php echo $rows['date_created']; ?></i>  
            
            </div>
          </div>
        </div>
          <?php endforeach; ?>
          <?php foreach($found_person_details as $rows) : ?>
            
                    
                    <br>
                    <h1><?php echo $rows['p_name']; ?></h1>
                    <hr>
                    Posted By: 
                      <a class="text-bold-700" href="#">
                      <?php echo $rows['first_name']." ";echo $rows['last_name']; ?>  
                      </a>
                    <br><br><br>
                    <span class="text-muted">Person's Description: </span>
                    <p><?php echo $rows['description']; ?></p>
                    <br><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Date Found: </span> <?php echo $rows['date']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Status: </span>
                      <span class="tag tag-pill tag-info"><?php echo $rows['item_status']; ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Location Found: </span> <?php echo $rows['p_location_add']; ?></td>
                  </tr>
                </table>
              </div>
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Age Group: </span> <?php echo $rows['age_group']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Age Range: </span> <?php echo $rows['age_range']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Sex: </span> <?php echo $rows['p_sex']; ?> 
                    <i class="<?php
                      if($rows["p_sex"] == "Male"){
                        echo "icon-male2";
                      }
                      else{
                        echo "female2";
                      } 
                     ?>"></i>
                  </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="text-sm-right">
            <i class="text-muted">Posted <?php echo $rows['published_at']; ?></i>  
            
            </div>
          </div>
        </div>
          <?php endforeach; ?>
          <?php foreach($found_pet_details as $rows) : ?>
            
                    
                    <br>
                    <h1>
                      <?php  if ($rows['pet_name'] == null) {
                        echo "<i class='grey'>Pet Name Undefined</i>";
                      }
                      else{
                        echo $rows['pet_name'];
                      } 
                      ?>
                    </h1>
                    <hr>
                    Posted By: 
                      <a class="text-bold-700" href="#">
                      <?php echo $rows['first_name']." ";echo $rows['last_name']; ?>  
                      </a>
                    <br><br><br>
                    <span class="text-muted">Pet Description: </span>
                    <p><?php echo $rows['description']; ?></p>
                    <br><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Date Found: </span> <?php echo substr($rows['date'], 0,10); ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Status: </span>
                      <span class="tag tag-pill tag-info"><?php echo $rows['post_status']; ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="text-muted">Location Found: </span> <?php echo $rows['location_address']; ?>
                    </td>
                  </tr>
        
                </table>
              </div>
              <div class="col-xs-6">
                <table style="width: 100%" class="table">
                  <tr>
                    <td><span class="text-muted">Pet Type: </span> <?php echo $rows['pet_type']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Breed: </span> <?php echo $rows['breed']; ?></td>
                  </tr>
                  <tr>
                    <td><span class="text-muted">Pet Condition: </span> <?php echo $rows['pet_condition']; ?> 
                  </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="text-sm-right">
            <i class="text-muted">Posted <?php echo substr($rows['date_reported'], 11,8) ?> 
            <?php echo substr($rows['date_reported'], 0,10); ?>
            </i>  
            
            </div>
          </div>
        </div>
          <?php endforeach; ?>
        <?php break; ?>
        <?php endswitch; ?>
                
    </div>
  </div>
</div>


