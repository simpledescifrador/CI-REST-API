<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>MakaHanap Login</title>

    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>assets/custom/img/m-circle.png">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/css/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/css/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/app-assets/css/pages/login-register.css">
    <!-- END Page Level CSS-->
    <!-- Custom CSS Design -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/custom/css/custom.css">
    <!-- END Custom CSS Design -->

  </head>
  <body data-open="click" data-menu="vertical-menu" data-col="1-column" class="vertical-layout vertical-menu 1-column  blank-page blank-page login-bg">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content content container-fluid login-bg-blur">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><section class="flexbox-container">
    <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 m-0">
            <div class="card-header no-border">
                <div class="card-title text-xs-center">
                    <div class="p-3"><img src="<?php echo base_url(); ?>assets/custom/img/nav-logo.png" class="img-fluid" alt="branding logo"></div>
                </div>
                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 "><span>App Administrator</span></h6>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <?php echo form_open('login/login_validation'); ?>
                        <fieldset class="form-group position-relative mb-0">
                            <input type="text" name="username" class="form-control form-control-lg input-lg" id="user-name" placeholder="Your Username">
                        </fieldset>
                        <br>
                        <fieldset class="form-group position-relative has-icon-right">

                            <input type="password" name="password" class="form-control  input-lg" id="user-password" placeholder="Enter Password" >
                            <div class="form-control-position">
                                <a class="icon-eye3" onclick="myFunction()" data-toggle="tooltip" title="Show Password" id="pw-icon" data-placement="top" >
                                </a>
                            </div>
                        </fieldset>
                        
                        <!--test if the user info does not meet the login requirements-->
                                    <?php if($this->session->flashdata('validate_msg') != null): ?>
                                    <div class="alert alert-dismissible alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <span><?php echo $this->session->flashdata('validate_msg'); ?>
                                    </div>
                                    <?php endif; ?>

                                    <!--test if the user is not on the database table (user)-->
                                    <?php if($this->session->flashdata('error_msg') != null): ?>
                                    <div class="alert alert-dismissible alert-danger">
                                    <button type="submit" class="close" data-dismiss="alert">&times;</button>
                                      <?php echo $this->session->flashdata('error_msg'); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <br>
                        <button type="submit" class="btn bg-blue bg-darken-1 btn-lg btn-block text-white"><i class="icon-unlock2"></i> Login</button>
                    <?php form_close(); ?>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</section>

        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url();?>assets/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="<?php echo base_url();?>assets/app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/app-assets/js/core/app.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script type="text/javascript">
        function myFunction() {
              var x = document.getElementById("user-password");
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

    <script type="text/javascript">
        window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 3000);
    </script>
    <!-- END PAGE LEVEL JS-->
  </body>
</html>
