<div class="col-sm-2">
	<ul class="nav nav-pills nav-stacked h5">
		<li class="nav-item ">
			<a class="nav-link nav-link-color active" data-toggle="pill" href="<?php echo site_url('barangay'); ?>" aria-expanded="true">Home </a>
		</li>
		<li class="nav-item">
			<a class="nav-link nav-link-color" href="<?php echo site_url('b_reports'); ?>" aria-expanded="false">Lost & Found</a>
		</li>
		<!-- <li class="nav-item">
			<a class="nav-link nav-link-color "  data-toggle="pill" href="#pill3" aria-expanded="false">Messages</a>
		</li>
		<li class="nav-item">
			<a class="nav-link nav-link-color "  data-toggle="pill" href="#pill3" aria-expanded="false">Records</a>
		</li>
		<li class="nav-item">
			<a class="nav-link nav-link-color "  data-toggle="pill" href="#pill4" aria-expanded="false">Settings</a>
		</li> -->
		<li class="nav-item">
			<a class="nav-link nav-link-color " href="<?php echo site_url('b_logout'); ?>" aria-expanded="false">Logout</a>
		</li>
	</ul>
</div>
<div class="col-sm-10 bg-grey bg-lighten-4">
	<div class="tab-content px-1">
		<br>
		<?php switch ($token) :
           case 'Lost': ?>
               <?php switch ($report_type) :
               case 'Person' ?>
               	<!-- Form for person -->
               	<div class="card">
                  <div class="card-header">
                    <h2 class="card-title">Report a Lost Person</h2>
                  </div>
                  <div class="card-body card-block">
                    <form method="POST" >
                      <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                      <div class="row form-group">
                        <div class="col-sm-4">
                          <label>First Name</label>
                          <input type="text" name="" class="form-control" placeholder="First Name">
                        </div>
                        <div class="col-sm-4">
                          <label>Middle Name</label>
                          <input type="text" name="" class="form-control" placeholder="Middle Name">
                        </div>
                        <div class="col-sm-4">
                          <label>Last Name</label>
                          <input type="text" name="" class="form-control" placeholder="Last Name">
                        </div>
                      </div>
                      <div class="row form-group">
                      <div class="col-sm-4" >
                          <label>Add the Person's Images</label>
                          <input type="file" name="images[]" id="upload_file" class="form-control"  onchange="preview_image();" multiple>
                          <br>
                          <div id="image_preview"></div>
                        </div>
                        <div class="col-sm-4">
                          <label>Sex</label>
                          <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio">
                              <input type="radio" name="sex" class="custom-control-input">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description ml-0">Male</span>
                            </label>
                            <label class="display-inline-block custom-control custom-radio">
                              <input type="radio" name="sex" checked class="custom-control-input">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description ml-0">Female</span>
                            </label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <label>Age Range</label>
                          <select class="form-control" name="">
                            <option value="Child">Child 1 - 12 Years Old</option>
                            <option value="Teen">Teen 13 - 21 Years Old</option>
                            <option value="Adult">Adult 22 - 59 Years Old</option>
                            <option value="Senior">Senior 60 - 120 Years Old</option>
                          </select>
                        </div>
                      </div>
                      <h4 class="form-section"><i class="icon-map6"></i> Location</h4>
                      <div class="row form-group">
                        <div class="col-sm-6">
                          <label>Last Location Seen</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="icon-map-marker"></i></span>
                            <input id="location" type="text" name="" class="form-control" placeholder="Enter a location">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label>Last Time Seen</label>
                          <div class="position-relative has-icon-left">
                            <input type="date" class="form-control" name="" style="height: 34px;">
                            <div class="form-control-position">
                              <i class="icon-calendar5"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <h4 class="form-section"><i class="icon-info"></i> Other Information</h4>
                      <div class="row form-group">
                        <div class="col-sm-6">
                          <label>Other Description</label>
                          <textarea name="" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-sm-6">
                          <label>Are you willing to give a reward?</label><br>
                          <div class="onoffswitch">
                              <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
                              <label class="onoffswitch-label" for="myonoffswitch">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group text-xs-right">
                        <button type="reset" class="btn btn-outline-secondary">Clear Input</button>
                        <button type="submit" class="btn btn-blue ">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
               <?php break; ?>
               <?php case 'Pet' ?>
               <!-- Form for pet -->
               <div class="card">
                 <div class="card-header">
                   <h2 class="card-title">Report a Lost Pet</h2>
                 </div>
                 <div class="card-body card-block">

                 </div>
               </div>
               <?php break; ?>
               <?php case 'Personal_Thing' ?>
               <!-- Form for Personal Thing -->
               <?php break; ?>
               <?php endswitch; ?>
           <?php break; ?>
           <?php case 'Found': ?>
           		<?php switch ($report_type) :
               case 'Person' ?>
               	<!-- Form for person -->
               <?php break; ?>
               <?php case 'Pet' ?>
               <!-- Form for pet -->
               <?php break; ?>
               <?php case 'Personal_Item' ?>
               <!-- Form for Personal Thing -->
               <?php break; ?>
               <?php endswitch; ?>
           <?php break; ?>
	    <?php endswitch; ?>
  </div>
</div>