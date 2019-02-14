<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title; ?></title>
<link href="assets/css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
<link href="assets/css/login.css" rel="stylesheet" type="text/css">
</head>

<body>
	
<div class="container-fluid">
	<div class="login-spacer">
		<div class="login-container row">
			<div class="col-md-5 section-image bg-primary">
				<h3>
					<b>MakaHanap</b>
				</h3>
				<br>
				<br>
				<em>Lost & Found </em><br>
				<em>Applicaton</em><br>
				<em>For Makatizen.</em>
				
			</div>
			<div class="col-md-7 section-login"><p  class="title"><b>Sign In</b></p>
			  <center><img src="assets/images/ImgResponsive_Placeholder.png" class="rounded-circle img-fluid" alt="Placeholder image"></center>
				<br>
				
						
			  <?php echo form_open('login/login_validation'); ?>
					<div class="form-group">
							<input class="form-control" name="username" type="text" placeholder="Username" />
							
		  			</div>
					<div class="form-group">
						<input class="form-control" name="password" type="password" placeholder="Password"/>
						<br>
						
					</div>
						<!--test if the user info does not meet the login requirements-->
						<?php if($this->session->flashdata('validate_msg') != null): ?>
						<div class="alert alert-dismissible alert-danger">
  						<button type="button" class="close" data-dismiss="alert">&times;</button>
						  <small><?php echo $this->session->flashdata('validate_msg'); ?>
						  </div>
						<?php endif; ?>

						<!--test if the user is not on the database table (user)-->
						<?php if($this->session->flashdata('error_msg') != null): ?>
						<div class="alert alert-dismissible alert-danger">
  						<button type="submit" class="close" data-dismiss="alert">&times;</button>
						  <?php echo $this->session->flashdata('error_msg'); ?></small>
						  </div>
						<?php endif; ?>
				  <br>
				  <div class="form-group">
					  <input class="form-control btn-outline-info" type="submit" value="Sign In" />
				  </div>
			  <?php form_close(); ?>
			  
		  </div>
		</div>
	</div>
</div>
<script src="assets/js/jquery-3.2.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap-4.0.0.js"></script>
</body>
</html>
