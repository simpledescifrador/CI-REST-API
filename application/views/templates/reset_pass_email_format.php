<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/bootstrap.css">
</head>
<body>
    <div class="d-flex justify-content-center">
        <img src="<?php echo base_url(); ?>assets/custom/img/m.png" alt="Makahanap Logo" width="25">
        <img src="<?php echo base_url(); ?>assets/custom/img/makahanap2.png" width="125">
    </div>
    <br>
    <div class="d-flex justify-content-center">
        <h2>You can now change your password</h2>
        <p>Here is your verification code</p>
        <h1><?php echo $code; ?></h1>
    </div>
</body>
</html>