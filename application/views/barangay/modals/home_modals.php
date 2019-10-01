
	<div class="modal fade text-xs-left" id="report_lost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel1">Report a Lost</h4>
		  </div>
		  <div class="modal-body p-2">
			<div class="row">
				<div class="col-sm-4 text-xs-center">
					<a href="<?php echo base_url(); ?>barangay/Barangay_report_item?token=Lost&type=Person" class="btn btn-lg btn-danger btn-block">
						<br/>
						<span class="h1">
							<i class="icon-user4 white" ></i><br>
						</span>
						Person
						<br/><br/>
					</a>
				</div>
				<div class="col-sm-4 text-xs-center">
					<a href="<?php echo base_url(); ?>barangay/Barangay_report_item?token=Lost&type=Pet" class="btn btn-lg btn-danger btn-block">
						<br>
						<span class="h1">
							<i class="icon-paw white " ></i><br>

						</span>
						Pet<br/><br/>
					</a>
				</div>
				<div class="col-sm-4 text-xs-center">
					<a href="<?php echo base_url(); ?>barangay/Barangay_report_item?token=Lost&type=Personal_Thing" class="btn btn-lg btn-danger btn-block">
						<br/>
						<span class="h1">
							<i class="icon-briefcase white " ></i><br>
						</span>
						Personal Thing
						<br/><br/>
					</a>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

	<div class="modal fade text-xs-left" id="report_found" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel1">Report a Lost</h4>
		  </div>
		  <div class="modal-body p-2">
			<div class="row">
				<div class="col-sm-4 text-xs-center">
					<a href="<?php echo base_url(); ?>barangay/Barangay_report_item?token=Found&type=Person" class="btn btn-lg btn-success btn-block">
						<br/>
						<span class="h1">
							<i class="icon-user4 white" ></i><br>
						</span>
						Person
						<br/><br/>
					</a >
				</div>
				<div class="col-sm-4 text-xs-center">
					<a href="<?php echo base_url(); ?>barangay/Barangay_report_item?token=Found&type=Pet" class="btn btn-lg btn-success btn-block">
						<br/>
						<span class="h1">
							<i class="icon-paw white " ></i><br>

						</span>
						Pet
						<br/><br/>
					</a>
				</div>
				<div class="col-sm-4 text-xs-center">
					<a href="<?php echo base_url(); ?>barangay/Barangay_report_item?token=Found&type=Personal_Item" class="btn btn-lg btn-success btn-block">
						<br/>
						<span class="h1">
							<i class="icon-briefcase white " ></i><br>
						</span>
						Personal Thing
						<br/><br/>
					</a>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

	<!-- Logout Modal -->
	<div id="logout-modal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<b>Confirm</b>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to logout?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button id="logout" type="button" class="btn btn-danger">Logout</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Change Password -->
	<div id="change-password-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<b>Change Password</b>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div id="alert-msg"></div>
				<div class="modal-body">
					<div class="form-group">
                        <label for="txt_currentPassword">Current Password</label>
                        <input type="password" class="form-control" id="txt_currentPassword" name="current_password" placeholder="Enter your current password">
					</div>
					<small>
					<b>Password Requirements</b>
					<ul>
						<li>Your Password <b>MUST</b> have at <b>least 8 </b> characters in length.</li>
						<li>Your Password <b>MUST</b> have at <b>least one</b> number.</li>
						<li>Your Password <b>MUST</b> have at <b>least one</b> special character.</li>
						<li>Your Password <b>MUST NOT</b> contain spaces.</li>
					</ul>
					</small>

					<fieldset class="form-group position-relative has-icon-right">
                        <label for="txt_newPassword">New Password</label>
						<input type="password" class="form-control" id="txt_newPassword" name="new_password" placeholder="Enter your new password">
						<div class="form-control-position" style="margin-top: 27px;">
							<a class="icon-eye3" onclick="myFunction()" data-toggle="tooltip" title="Show/Hide Password" id="pw-icon" data-placement="top" >
							</a>
						</div>
					</fieldset>
                    <div class="form-group">
                        <label for="txt_repeatPassword">Repeat Password</label>
                        <input type="password" class="form-control" id="txt_repeatPassword" name="repeat_password" placeholder="Repeat new password">
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button id="change-password" type="button" class="btn btn-success">Apply Changes</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
        function myFunction() {
              var x = document.getElementById("txt_newPassword");
              var y = document.getElementById("pw-icon");

              if (x.type === "password") {
                x.type = "text";
                document.getElementById("pw-icon").className = "icon-eye-blocked";
                y.setAttribute("title", "Hide Password");
                y.setAttribute("data-toggle", "none");
              } else {
                y.setAttribute("title", "Show Password");
                y.setAttribute("data-toggle", "tooltip");
                x.type = "password";
                document.getElementById("pw-icon").className = "icon-eye3";
              }
            }
    </script>