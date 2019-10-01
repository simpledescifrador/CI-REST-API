<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title; ?></title>

     <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/custom/img/m-circle.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/custom/css/barangay.css">
    <!-- END Page Level CSS-->
    <style>
        .items-card img {
            height: 300px;
            width: 300px;
            overflow: hidden;
        }
    </style>
</head>
<body>
	<nav class="navbar navbar-dark bg-blue white">
        <ul class="nav navbar-nav">
            <li>
            <a class="navbar-brand">
                <img src="<?php echo base_url(); ?>assets/custom/img/m-circle.png" width="40" height="40" class="d-inline-block align-top">
                <span><b class="h1 ">Maka-Hanap</b>&emsp;
                    <!-- <span class="border-left"> &nbsp;
                        <?php foreach ($barangay as $row) :?>
                        <?php echo "Brgy. ". ucwords(strtolower($row['name'])); ?>
                        <?php endforeach; ?>
                    </span> -->
                </span>
            </a>
            </li>
        </ul>
        <ul class="nav navbar-nav float-xs-right">
            <li class="nav-item" style="padding-top: 10px;" >
                <a class="btn btn-danger" data-toggle="modal" data-target="#report_lost"><i class="icon-plus"></i>Report Lost</a>
            </li>
            <li class="nav-item" style="padding-top: 10px;" >
                <a class="btn btn-success " data-toggle="modal" data-target="#report_found"><i class="icon-plus"></i>Report Found</a>
            </li>
            <!-- <li class="nav-item pt-1">
                <span class="h5 grey lighten-4">
                	Hi, <?php echo $username; ?>
                </span>
            </li> -->
        </ul>
	</nav>
    <div class="card">
        <div class="card-body p-1">
            <div class="row">
