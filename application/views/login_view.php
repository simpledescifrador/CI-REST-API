<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MakaHanap | Admin Login</title>
    <link href="assets/css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
    <link href="assets/css/login.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="container-fluid">
    <div class="login-spacer">
        <div class="login-container row">
            <div class="col-md-5 section-image bg-primary">
                <h3>
                    <b>MakaHanap<br> Admin</b>
                </h3>
                <br>
                <br>
                <em>Lost & Found </em><br>
                <em>Applicaton</em><br>
                <em>For Makatizen.</em>

            </div>
            <div class="col-md-7 section-login"><p class="title"><b>Sign In</b></p>
                <center><img src="assets/images/ImgResponsive_Placeholder.png" class="rounded-circle img-fluid"
                             alt="Placeholder image"></center>
                <br>
                <br>
                <?php echo form_open('/login/validation'); ?>

                <div class="form-group">
                    <input class="form-control" name="username" type="text" placeholder="Username"/>
                    <span class="text-danger"><?php form_error('username'); ?></span>

                </div>
                <div class="form-group">
                    <input class="form-control" name="password" type="password" placeholder="Password"/>
                    <span class="text-danger"><?php form_error('password'); ?></span>
                </div>
                <br>
                <div class="form-group">
                    <input class="form-control btn-outline-info" type="submit" name="insert" value="Sign In"/>
                    <?php
                    echo '<label class="text-danger">' . $this->session->flashdata("validation_msg") . "</label>";
                    ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
