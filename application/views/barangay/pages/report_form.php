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

    <!-- """"""""""""""""""BEGIN Form for LOST REPORTS""""""""""""""""""""""" -->
		<?php switch ($token) :
           case 'Lost': ?>
               <?php switch ($report_type) :
               case 'Person' ?>
               	<!-- Form for person -->
               	<div class="card">
                  <div class="card-header">
                    <h2 class="card-title">Report a <span class="warning">Lost</span> Person</h2>
                  </div>
                  <div class="card-body card-block">
                  <form id="lost-pt-form" enctype="multipart/form-data">
                      <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                      <div class="row form-group">
                        <div class="col-sm-4">
                          <label>First Name</label>
                          <input type="text" name="person_fname" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="col-sm-4">
                          <label>Middle Name</label>
                          <input type="text" name="person_mname" class="form-control" placeholder="Middle Name" required>
                        </div>
                        <div class="col-sm-4">
                          <label>Last Name</label>
                          <input type="text" name="person_lname" class="form-control" placeholder="Last Name" required>
                        </div>
                      </div>
                      <div class="row form-group">
                      <div class="col-sm-4" >
                        <label>Upload Images</label>
                          <input type="file" name="person_images[]" id="upload_file" class="form-control"  onchange="preview_image();" multiple required>
                          <br>
                          <div id="image_preview"></div>
                        </div>
                        <div class="col-sm-4">
                          <label>Sex</label>
                          <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio">
                              <input type="radio" name="sex" checked class="custom-control-input">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description ml-0">Male</span>
                            </label>
                            <label class="display-inline-block custom-control custom-radio">
                              <input type="radio" name="sex" class="custom-control-input">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description ml-0">Female</span>
                            </label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <label>Age Range</label>
                          <select class="form-control" name="age_group">
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
                            <input id="location" type="text" class="form-control" placeholder="Enter a location" required>
                          </div>
                          <div class="add-location input-group">
                          <br>
                            <label>Additional Location Information</label>
                            <input name="additional_location_info" placeholder="Optional" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label>Last Time Seen</label>
                          <div class="position-relative has-icon-left">
                            <input type="date" class="form-control" name="date" style="height: 34px;" required>
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
                          <textarea name=person_description" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-sm-6">
                          <label>Are you willing to give a reward?</label><br>
                          <div class="onoffswitch">
                              <input type="checkbox" name="is_rewarded" class="onoffswitch-checkbox" id="myonoffswitch">
                              <label class="onoffswitch-label" for="myonoffswitch">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                          </div>
                          <div class="reward mt-1 input-group">
                          <label>Reward Amount</label><br />
                          <input type="number" name="reward" class="form-control" placeholder="Enter the amount" value="0"/>
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
                   <h2 class="card-title">Report a <span class="warning">Lost</span> Pet</h2>
                 </div>
                 <div class="card-body card-block">
                 <form id="lost-pet-form" enctype="multipart/form-data">
                    <h4 class="form-section"><i class="icon-paw"></i> Pet Info</h4>
                    <div class="row">
                      <div class="col-sm-5 ">
                        <label>Select Pet Type</label>
                        <div id="pet_type" class="input-group form-control text-xs-center">
                          <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="pet_type" value="Dog" class="custom-control-input" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0">Dog</span>
                          </label>&emsp;
                          <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="pet_type" value="Cat" class="custom-control-input" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0">Cat</span>
                          </label>&emsp;
                          <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="pet_type" value="Bird" class="custom-control-input" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0">Bird</span>
                          </label>&emsp;
                          <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="pet_type" value="Other" class="custom-control-input" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0">Other</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-7 form-group pet-breed-div">
                        <label>Breed</label>
                        <select id="pet-breed" name='pet_breed' class="form-control" style="height: 40px;">
                          <option value="">Select Breed</option>
                        </select>
                      </div>
                      <div class="col-sm-7 form-group pet-other-type-div">
                        <label>Other Pet Type</label>
                        <input type="text"  class="form-control" name='pet_type' style="height: 40px;" placeholder="Enter the other pet type"/>
                      </div>
                    </div>
                    <div class="row form-group">
                      <div class="col-sm-5">
                        <label>Pet Name</label>
                        <input type="text" name="pet_name" class="form-control" required>
                      </div>
                      <div class="col-sm-7">
                        <label>Pet Condition</label>
                        <div class="input-group">
                        <label class="display-inline-block custom-control custom-radio">
                          <input type="radio" name="pet_condition" value="Healthy" checked class="custom-control-input">
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description ml-0">Healthy</span>
                        </label>&emsp;
                        <label class="display-inline-block custom-control custom-radio">
                          <input type="radio" name="pet_condition" value="Injured" class="custom-control-input">
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description ml-0">Injured</span>
                        </label>
                        </div>
                      </div>
                    </div>
                    <div class="row form-group">
                    <div class="col-sm-5" >
                        <label>Upload Images</label>
                          <input type="file" name="pet_images[]" id="upload_file" class="form-control"  onchange="preview_image();" multiple required>
                          <br>
                          <div id="image_preview"></div>
                        </div>
                    </div>
                    <h4 class="form-section"><i class="icon-map6"></i> Location</h4>
                    <div class="row form-group">
                      <div class="col-sm-6">
                        <label>Last Location Seen</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="icon-map-marker"></i></span>
                            <input id="location" type="text" class="form-control" placeholder="Enter a location" required>
                          </div>
                          <div class="add-location input-group">
                          <br>
                            <label>Additional Location Information</label>
                            <input name="additional_location_info" placeholder="Optional" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <label>Last Time Seen</label>
                          <div class="position-relative has-icon-left">
                            <input type="date" class="form-control" name="date" style="height: 34px;" required>
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
                          <textarea name="pet_description" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-sm-6">
                          <label>Are you willing to give a reward?</label><br>
                          <div class="onoffswitch">
                              <input type="checkbox" name="is_rewarded" class="onoffswitch-checkbox" id="myonoffswitch">
                              <label class="onoffswitch-label" for="myonoffswitch">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                          </div>
                          <div class="reward mt-1 input-group">
                          <label>Reward Amount</label><br />
                          <input type="number" name="reward" class="form-control" placeholder="Enter the amount" value="0"/>
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
               <?php case 'Personal_Thing' ?>
               <!-- Form for Personal Thing -->
               <div class="card">
                 <div class="card-header">
                   <h2 class="card-title">Report a <span class="warning">Lost</span> Item</h2>
                 </div>
                 <div class="card-body card-block">
                 <form id="lost-pt-form" enctype="multipart/form-data">
                   <h4 class="form-section"><i class="icon-briefcase"></i> Item Info</h4>
                   <div class="row form-group">
                     <div class="col-sm-6">
                       <label>Item Name</label>
                       <input type="text" name="item_name" class="form-control" required>
                     </div>
                     <div class="col-sm-6">
                       <label>Brand</label>
                       <input type="text" name="brand" class="form-control">
                     </div>
                   </div>
                   <div class="row form-group">
                     <div class="col-sm-6">
                       <label>Item Category</label>
                       <select class="form-control" name="item_category" style="height: 34px;">
                         <option value="">Select Category</option>
                         <option>Mobile Phone</option>
                         <option>Laptop</option>
                         <option>School Supplies</option>
                         <option>ID</option>
                         <option>Wallet</option>
                         <option>Umbrella</option>
                         <option>Bag</option>
                         <option>Keys</option>
                         <option>Art</option>
                         <option>Beauty Accessories</option>
                         <option>Books</option>
                         <option>Clothes</option>
                         <option>Paperworks</option>
                         <option>Bank Cards</option>
                         <option>Jewelry</option>
                         <option>eReaders</option>
                         <option>PC Accessories</option>
                         <option>Photography Equipment</option>
                         <option>Mobile Phone Accesories</option>
                         <option>Sports Equipment</option>
                         <option>Others</option>
                       </select>
                     </div>
                     <div class="col-sm-6">
                       <label>Color</label>
                       <input type="text" name="item_color" class="form-control" required>
                     </div>
                   </div>
                   <div class="row form-group">
                    <div class="col-sm-5" >
                        <label>Upload Images</label>
                          <input type="file" name="item_images[]" id="upload_file" class="form-control"  onchange="preview_image();" multiple required>
                          <br>
                          <div id="image_preview"></div>
                        </div>
                    </div>
                   <h4 class="form-section"><i class="icon-map6"></i> Location</h4>
                   <div class="row form-group">
                     <div class="col-sm-6">
                       <label>Last Location Seen</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon-map-marker"></i></span>
                          <input id="location" type="text" class="form-control" placeholder="Enter a location" required>

                        </div>
                        <div class="add-location input-group">
                          <br>
                            <label>Additional Location Information</label>
                            <input name="additional_location_info" placeholder="Optional" class="form-control">
                          </div>
                     </div>
                     <div class="col-sm-6">
                       <label>Last Time Seen</label>
                          <div class="position-relative has-icon-left">
                            <input type="date" class="form-control" name="date_lost" style="height: 34px;" required>
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
                          <textarea name="item_description" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-sm-6">
                          <label>Are you willing to give a reward?</label><br>
                          <div class="onoffswitch">
                              <input type="checkbox" name="is_rewarded" class="onoffswitch-checkbox" id="myonoffswitch">
                              <label class="onoffswitch-label" for="myonoffswitch">
                                  <span class="onoffswitch-inner"></span>
                                  <span class="onoffswitch-switch"></span>
                              </label>
                          </div>
                          <div class="reward mt-1 input-group">
                          <label>Reward Amount</label><br />
                          <input type="number" name="reward" class="form-control" placeholder="Enter the amount" value="0"/>
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
               <?php endswitch; ?>
           <?php break; ?>
           <!-- """""""""""""""""""END Form for LOST REPORTS"""""""""""""""""""""""" -->
           <!-- """"""""""""""""""BEGIN Form for FOUND REPORTS""""""""""""""""""""""" -->
           <?php case 'Found': ?>
           		<?php switch ($report_type) :
               case 'Person' ?>
               	<!-- Form for Found person -->
                <div class="card">
                  <div class="card-header">
                    <h2 class="card-title">Report a <span class="success">Found</span> Person</h2>
                  </div>
                  <div class="card-body card-block">
                  <form id="found-person-form" enctype="multipart/form-data">
                      <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                      <div class="row form-group">
                        <div class="col-sm-4">
                          <label>First Name</label>
                          <input type="text" name="person_fname" class="form-control" placeholder="First Name(Optional)">
                        </div>
                        <div class="col-sm-4">
                          <label>Middle Name</label>
                          <input type="text" name="person_mname" class="form-control" placeholder="Middle Name (Optional)">
                        </div>
                        <div class="col-sm-4">
                          <label>Last Name</label>
                          <input type="text" name="person_lname" class="form-control" placeholder="Last Name (Optional)">
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-sm-4" >
                          <label>Upload Images</label>
                            <input type="file" name="person_images[]" id="upload_file" class="form-control"  onchange="preview_image();" multiple required>
                            <br>
                            <div id="image_preview"></div>
                          </div>
                          <div class="col-sm-4">
                          <label>Sex</label>
                          <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio">
                              <input type="radio" name="sex" checked class="custom-control-input">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description ml-0">Male</span>
                            </label>
                            <label class="display-inline-block custom-control custom-radio">
                              <input type="radio" name="sex" class="custom-control-input">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description ml-0">Female</span>
                            </label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <label>Age Range</label>
                          <select class="form-control" name="age_group">
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
                          <label>Location Found</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="icon-map-marker"></i></span>
                            <input id="location" type="text" class="form-control" placeholder="Enter a location" required>

                          </div>
                          <div class="add-location input-group">
                          <br>
                            <label>Additional Location Information</label>
                            <input name="additional_location_info" placeholder="Optional" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label>Date Found</label>
                          <div class="position-relative has-icon-left">
                            <input type="date" class="form-control" name="date" style="height: 34px;" required>
                            <div class="form-control-position">
                              <i class="icon-calendar5"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <h4 class="form-section"><i class="icon-info"></i> Other Information</h4>
                      <div class="form-group">

                          <label>Other Description</label>
                          <textarea name="description" class="form-control" rows="2"></textarea>


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
               <!-- Form for FOUND pet -->
               <label class="card">
                 <div class="card-header">
                   <h2 class="card-title">Report a <span class="success">Found</span> Pet</h2>
                 </div>
                 <label class="card-body card-block">
                 <form id="found-pet-form" enctype="multipart/form-data">
                    <h4 class="form-section"><i class="icon-paw"></i> Pet Info</h4>
                    <div class="row">
                      <div class="col-sm-5 ">
                        <label>Select Pet Type</label>
                        <div class="input-group form-control text-xs-center">
                          <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="pet_type" value="Dog" class="custom-control-input" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0">Dog</span>
                          </label>&emsp;
                          <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="pet_type" value="Cat" class="custom-control-input" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0">Cat</span>
                          </label>&emsp;
                          <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="pet_type" value="Bird" class="custom-control-input" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0">Bird</span>
                          </label>&emsp;
                          <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="pet_type" value="Other" class="custom-control-input pet-type" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0">Other</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-7 form-group pet-breed-div">
                        <label>Breed</label>
                        <select id="pet-breed" name='pet_breed' class="form-control" style="height: 40px;">
                          <option value="">Select Breed</option>
                        </select>
                      </div>
                      <div class="col-sm-7 form-group pet-other-type-div">
                        <label>Other Pet Type</label>
                        <input type="text"  class="form-control" name='pet_type' style="height: 40px;" placeholder="Enter the other pet type"/>
                      </div>
                    </div>
                    <div class="row form-group">
                    <div class="col-sm-5" >
                        <label>Upload Images</label>
                          <input type="file" name="pet_images[]" id="upload_file" class="form-control"  onchange="preview_image();" multiple required>
                          <br>
                          <div id="image_preview"></div>
                        </div>
                    <div class="col-sm-7">
                        <label>Pet Condition</label>
                        <div class="input-group">
                        <div class="display-inline-block custom-control custom-radio">
                          <input type="radio" name="pet_condition" value="Healthy" checked class="custom-control-input">
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description ml-0">Healthy</span>
                        </div>&emsp;
                        <div class="display-inline-block custom-control custom-radio">
                          <input type="radio" name="pet_condition" value="Injured" class="custom-control-input">
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description ml-0">Injured</span>
                        </div>
                        </div>
                      </div>
                    </div>
                    <h4 class="form-section"><i class="icon-map6"></i> Location</h4>
                    <div class="row form-group">
                      <div class="col-sm-6">
                        <label>Location Found</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="icon-map-marker"></i></span>
                            <input id="location" type="text" class="form-control" placeholder="Enter a location" required>

                          </div>
                          <div class="add-location input-group">
                          <br>
                            <label>Additional Location Information</label>
                            <input name="additional_location_info" placeholder="Optional" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <label>Date Found</label>
                          <div class="position-relative has-icon-left">
                            <input type="date" class="form-control" name="date" style="height: 34px;" required>
                            <div class="form-control-position">
                              <i class="icon-calendar5"></i>
                            </div>
                          </div>
                      </div>
                    </div>
                    <h4 class="form-section"><i class="icon-info"></i> Other Information</h4>
                      <div class="form-group">

                          <label>Other Description</label>
                          <textarea name="pet_description" class="form-control" rows="2"></textarea>


                      </div>
                      <div class="form-group text-xs-right">
                        <button type="reset" class="btn btn-outline-secondary">Clear Input</button>
                        <button type="submit" class="btn btn-blue ">Submit</button>
                      </div>
                  </form>
                 </label>
               </label>
               <?php break; ?>
               <?php case 'Personal_Item' ?>
               <!-- Form for FOUND Personal Thing -->
               <div class="card">
                 <div class="card-header">
                   <h2 class="card-title">Report a <span class="success">Found</span> Item</h2>
                 </div>
                 <div class="card-body card-block">
                  <form id="found-pt-form" enctype="multipart/form-data">
                   <h4 class="form-section"><i class="icon-briefcase"></i> Item Info</h4>
                   <div class="row form-group">
                     <div class="col-sm-6">
                       <label>Item Name</label>
                       <input type="text" name="item_name" class="form-control" required>
                     </div>
                     <div class="col-sm-6">
                       <label>Brand</label>
                       <input type="text" name="brand" class="form-control">
                     </div>
                   </div>
                   <div class="row form-group">
                     <div class="col-sm-6">
                       <label>Item Category</label>
                       <select class="form-control" name="item_category" style="height: 34px;">
                         <option value="">Select Category</option>
                         <option>Mobile Phone</option>
                         <option>Laptop</option>
                         <option>School Supplies</option>
                         <option>ID</option>
                         <option>Wallet</option>
                         <option>Umbrella</option>
                         <option>Bag</option>
                         <option>Keys</option>
                         <option>Art</option>
                         <option>Beauty Accessories</option>
                         <option>Books</option>
                         <option>Clothes</option>
                         <option>Paperworks</option>
                         <option>Bank Cards</option>
                         <option>Jewelry</option>
                         <option>eReaders</option>
                         <option>PC Accessories</option>
                         <option>Photography Equipment</option>
                         <option>Mobile Phone Accesories</option>
                         <option>Sports Equipment</option>
                         <option>Others</option>
                       </select>
                     </div>
                     <div class="col-sm-6">
                       <label>Color</label>
                       <input type="text" name="item_color" class="form-control" required>
                     </div>
                   </div>
                   <div class="row form-group">
                    <div class="col-sm-5" >
                        <label>Upload Images</label>
                          <input type="file" name="item_images[]" id="upload_file" class="form-control" onchange="preview_image();" multiple required>
                          <br>
                          <div id="image_preview"></div>
                        </div>
                    </div>
                   <h4 class="form-section"><i class="icon-map6"></i> Location</h4>
                   <div class="row form-group">
                     <div class="col-sm-6">
                       <label>Location Found</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon-map-marker"></i></span>
                          <input id="location" type="text" class="form-control" placeholder="Enter a location" required>
                        </div>
                        <div class="add-location input-group">
                          <br>
                            <label>Additional Location Information</label>
                            <input name="additional_location_info" placeholder="Optional" class="form-control">
                          </div>
                     </div>
                     <div class="col-sm-6">
                       <label>Date Found</label>
                          <div class="position-relative has-icon-left">
                            <input type="date" class="form-control" name="date_found" style="height: 34px;" required>
                            <div class="form-control-position">
                              <i class="icon-calendar5"></i>
                            </div>
                          </div>
                     </div>
                   </div>
                   <h4 class="form-section"><i class="icon-info"></i> Other Information</h4>
                      <div class="form-group">

                          <label>Other Description</label>
                          <textarea name="item_description" class="form-control" rows="4"></textarea>


                      </div>
                      <div class="form-group text-xs-right">
                        <button type="reset" class="btn btn-outline-secondary">Clear Input</button>
                        <button type="submit" class="btn btn-blue ">Submit</button>
                      </div>
                  </form>
                 </div>
               </div>
               <?php break; ?>
               <?php endswitch; ?>
           <?php break; ?>
	    <?php endswitch; ?>
	</label>
</div>
<script>
  function preview_image()
  {
  var total_file=document.getElementById("upload_file").files.length;
  for(var i=0;i<total_file;i++)
  {
    $('#image_preview').append("<img class='img-thumbnail' width='150px' height='150px' src='"+URL.createObjectURL(event.target.files[i])+"'>&nbsp;");
  }
  }
</script>

<script>
    $('.pet-other-type-div').hide();
    $('.reward').hide();
    $('input:checkbox[name=is_rewarded]').change(function() {
            if($(this).is(":checked")){
              $('.reward').show();
            }
            else if($(this).is(":not(:checked)")){
              $('.reward').hide();
            }
    });

    $('input:radio[name=pet_type]').change(function() {
      var selectedVal = this.value;
      var selectId = $('#pet-breed');
      selectId.empty();
      selectId.append("<option>Select Breed</option>");
      $('.pet-breed-div').show();
      if (selectedVal == 'Dog') {
        $('.pet-other-type-div').hide();
        var options = "<option value='Askal'>Askal</option>" +
                      "<option value='Beagle'>Beagle</option>" +
                      "<option value='Poodle'>Poodle</option>" +
                      "<option value='Pug'>Pug</option>" +
                      "<option value='Golden Dalmatian'>Golden Dalmatian</option>" +
                      "<option value='Shih Tzu'>Shih Tze</option>" +
                      "<option value='Chihuahua'>Chihuahua</option>" +
                      "<option value='German Shepherd'>German Shepherd</option>" +
                      "<option value='Doberman'>Doberman</option>" +
                      "<option value='Labrador Retriever'>Labrador Retriver</option>" +
                      "<option value='Bulldog'>Bulldog</option>" +
                      "<option value='Siberian Husky'>Siberian Husky</option>" +
                      "<option value='Chow Chow'>Chow Chow</option>" +
                      "<option value='Grey Hound'>Grey Hound</option>" +
                      "<option value='Hound'>Hound</option>" +
                      "<option value='Others'>Others</option>";
        selectId.append(options);
      } else if (selectedVal == 'Cat') {
        $('.pet-other-type-div').hide();
        var options = "<option value='Persian'>Persian</option>" +
                      "<option value='Siamese'>Siamese</option>" +
                      "<option value='Maine Coon'>Maine Coon</option>" +
                      "<option value='Abyssinian'>Abyssinian</option>" +
                      "<option value='Ragdoll'>Ragdoll</option>" +
                      "<option value='Burmese'>Burmese</option>" +
                      "<option value='Bengal'>Bengal</option>" +
                      "<option value='Sphynx'>Sphynx</option>" +
                      "<option value='Siberian'>Siberian</option>" +
                      "<option value='Others'>Others</option>";
        selectId.append(options);
      } else if (selectedVal == 'Bird') {
        $('.pet-other-type-div').hide();
        var options = "<option value='Parrot'>Parrot</option>" +
                      "<option value='Cockatiels'>Cockatiels</option>" +
                      "<option value='Budgerigars'>Budgerigars</option>" +
                      "<option value='Cockatoos'>Cockatoos</option>" +
                      "<option value='Conures'>Conures</option>" +
                      "<option value='Macaws'>Macaws</option>" +
                      "<option value='Poicephalus'>Poicephalusl</option>" +
                      "<option value='Amazon Parrots'>Amazon Parrots</option>" +
                      "<option value='Quaker Parrots'>Quaker Parrots</option>" +
                      "<option value='Others'>Others</option>";
        selectId.append(options);
      } else {
        $('.pet-breed-div').hide();
        $('.pet-other-type-div').show();
      }
    });
</script>

<script>
        var locationData = {};
        $('.add-location').hide();
        function initMap() {
          var defaultBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(14.530872, 121.022232),
            new google.maps.LatLng(14.568527, 121.045865));
            var options = {
              bounds: defaultBounds
            };
          var input = document.getElementById('location');
          var autocomplete = new google.maps.places.Autocomplete(input, options);

          autocomplete.addListener('place_changed', function() {
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }
          locationData['place_id'] = place.place_id;
          locationData['place_name'] = place.name;
          locationData['place_address'] = place.formatted_address;
          locationData['place_lat'] = place.geometry.location.lat();
          locationData['place_lng'] = place.geometry.location.lng();

          $('.add-location').show();
        });
        }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLvj1qEc2MIZgzjrd6P6MRTeQNDEXfwnU&libraries=places&callback=initMap"></script>

<!-- Report Request -->
<script>
  $('#lost-person-form').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);

    var ageGroup = data.get('age_group');
    var ageRange;
    switch (ageGroup) {
      case "Child":
        ageRange = "1 to 12";
        break;
      case "Teen":
        ageRange = "13 to 21";
        break;
      case "Adult":
        ageRange = "22 to 59";
        break;
      case "Senior":
        ageRange = "60 to 120";
        break;
    }

    var name = data.get('person_fname') + ' ' + data.get('person_mname') + ' ' + data.get('person_lname');

    data.append("location_address", locationData['place_address']);
    data.append("location_name", locationData['place_name']);
    data.append("location_id", locationData['place_id']);
    data.append("location_latitude", locationData['place_lat']);
    data.append("location_longitude", locationData['place_lng']);
    data.append("type", "Lost");
    data.append("brgy_user_id", "<?php echo $brgy_user_id; ?>");
    data.append("name", name);
    data.append("age_range", ageRange);


    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === 4) {
        alert("Reported Successfully");
        window.location.href = "<?php echo base_url(); ?>b_reports";
      }
    });
    xhr.open("POST", "<?php echo base_url(); ?> api/v1/report/person", true);
    xhr.setRequestHeader("X-API-KEY", "makahanap@key2018");
    xhr.setRequestHeader("Authorization", "Basic YWRtaW46MTIzNA==");
    xhr.upload.onprogress = function(e)
    {
      var percentComplete = Math.ceil((e.loaded / e.total) * 100);
    };

    xhr.send(data);
  });
  $('#lost-pet-form').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);

    data.append("location_address", locationData['place_address']);
    data.append("location_name", locationData['place_name']);
    data.append("location_id", locationData['place_id']);
    data.append("location_latitude", locationData['place_lat']);
    data.append("location_longitude", locationData['place_lng']);
    data.append("type", "Lost");
    data.append("brgy_user_id", "<?php echo $brgy_user_id; ?>");

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === 4) {
        alert("Reported Successfully");
        window.location.href = "<?php echo base_url(); ?>b_reports";
      }
    });
    xhr.open("POST", "<?php echo base_url(); ?>api/v1/report/pet", true);
    xhr.setRequestHeader("X-API-KEY", "makahanap@key2018");
    xhr.setRequestHeader("Authorization", "Basic YWRtaW46MTIzNA==");
    xhr.upload.onprogress = function(e)
    {
      var percentComplete = Math.ceil((e.loaded / e.total) * 100);
    };

    xhr.send(data);
  });
  $('#lost-pt-form').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    data.append("location_address", locationData['place_address']);
    data.append("location_name", locationData['place_name']);
    data.append("location_id", locationData['place_id']);
    data.append("location_latitude", locationData['place_lat']);
    data.append("location_longitude", locationData['place_lng']);
    data.append("type", "Lost");
    data.append("brgy_user_id", "<?php echo $brgy_user_id; ?>");

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === 4) {
        alert("Reported Successfully");
        window.location.href = "<?php echo base_url(); ?>b_reports";
      }
    });
    xhr.open("POST", "<?php echo base_url(); ?>api/v1/report/pt", true);
    xhr.setRequestHeader("X-API-KEY", "makahanap@key2018");
    xhr.setRequestHeader("Authorization", "Basic YWRtaW46MTIzNA==");
    xhr.upload.onprogress = function(e)
    {
      var percentComplete = Math.ceil((e.loaded / e.total) * 100);
    };

    xhr.send(data);
  });

  $('#found-person-form').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);

    var ageGroup = data.get('age_group');
    var ageRange;
    switch (ageGroup) {
      case "Child":
        ageRange = "1 to 12";
        break;
      case "Teen":
        ageRange = "13 to 21";
        break;
      case "Adult":
        ageRange = "22 to 59";
        break;
      case "Senior":
        ageRange = "60 to 120";
        break;
    }

    var name = data.get('person_fname') + ' ' + data.get('person_mname') + ' ' + data.get('person_lname');

    data.append("location_address", locationData['place_address']);
    data.append("location_name", locationData['place_name']);
    data.append("location_id", locationData['place_id']);
    data.append("location_latitude", locationData['place_lat']);
    data.append("location_longitude", locationData['place_lng']);
    data.append("type", "Found");
    data.append("brgy_user_id", "<?php echo $brgy_user_id; ?>");
    data.append("name", name);
    data.append("age_range", ageRange);

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === 4) {
        alert("Reported Successfully");
        window.location.href = "<?php echo base_url(); ?>b_reports";
      }
    });
    xhr.open("POST", "<?php echo base_url(); ?>api/v1/report/person", true);
    xhr.setRequestHeader("X-API-KEY", "makahanap@key2018");
    xhr.setRequestHeader("Authorization", "Basic YWRtaW46MTIzNA==");
    xhr.upload.onprogress = function(e)
    {
      var percentComplete = Math.ceil((e.loaded / e.total) * 100);
    };

    xhr.send(data);
  });
  $('#found-pet-form').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);

    data.append("location_address", locationData['place_address']);
    data.append("location_name", locationData['place_name']);
    data.append("location_id", locationData['place_id']);
    data.append("location_latitude", locationData['place_lat']);
    data.append("location_longitude", locationData['place_lng']);
    data.append("type", "Found");
    data.append("brgy_user_id", "<?php echo $brgy_user_id; ?>");

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === 4) {
        alert("Reported Successfully");
        window.location.href = "<?php echo base_url(); ?>b_reports";
      }
    });
    xhr.open("POST", "<?php echo base_url(); ?>api/v1/report/pet", true);
    xhr.setRequestHeader("X-API-KEY", "makahanap@key2018");
    xhr.setRequestHeader("Authorization", "Basic YWRtaW46MTIzNA==");
    xhr.upload.onprogress = function(e)
    {
      var percentComplete = Math.ceil((e.loaded / e.total) * 100);
    };

    xhr.send(data);
  });
  $('#found-pt-form').submit(function(e) {
    e.preventDefault();
    var data = new FormData(this);
    data.append("location_address", locationData['place_address']);
    data.append("location_name", locationData['place_name']);
    data.append("location_id", locationData['place_id']);
    data.append("location_latitude", locationData['place_lat']);
    data.append("location_longitude", locationData['place_lng']);
    data.append("type", "Found");
    data.append("brgy_user_id", "<?php echo $brgy_user_id; ?>");

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === 4) {
        alert("Reported Successfully");
        window.location.href = "<?php echo base_url(); ?>b_reports";
      }
    });
    xhr.open("POST", "<?php echo base_url(); ?>api/v1/report/pt", true);
    xhr.setRequestHeader("X-API-KEY", "makahanap@key2018");
    xhr.setRequestHeader("Authorization", "Basic YWRtaW46MTIzNA==");
    xhr.upload.onprogress = function(e)
    {
      var percentComplete = Math.ceil((e.loaded / e.total) * 100);
    };

    xhr.send(data);
  });

</script>
