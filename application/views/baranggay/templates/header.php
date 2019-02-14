<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap-4.0.0.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/Sidebar-Menu.css">
	 <link rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.css">
	 <link href="assets/css/dashboard.css" rel="stylesheet" type="text/css">

	 <!-- Morris Charts CSS -->
    <link href="assets/morrisjs/morris.css" rel="stylesheet">
    <!-- /Morris Charts CSS -->

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css"/>
    <!-- /DataTables CSS -->




  </head>
  <body>
 
<div id="wrapper">
        <div id="sidebar-wrapper" class="bg-light">
            <ul class="sidebar-nav">
                <li class="sidebar-brand"> <a href="#"><b>MakaHanap</b> </a></li>
                <li> <a href="#"><em class="fa fa-home"></em> &nbsp;Home </a></li>
                <li class="active">
               	 <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><em class="fa fa-file"></em> &nbsp;Reported Items &emsp;</a>
               	 <ul class="collapse list-unstyled bg-secondary" id="reportSubmenu">
                	 <li>
                	     <a href="#">&emsp;&emsp;&emsp;Reported Lost</a>
                	 </li>
               	     <li>
               	         <a href="#">&emsp;&emsp;&emsp;Reported Found</a>
               	     </li>
                     <li>
                         <a href="#">&emsp;&emsp;&emsp;Returned</a>
                     </li>
               	 </ul>
            	</li>
                <li> <a href="#"><em class="fa fa-envelope"></em> &nbsp;Messages </a></li>
                <li> <a href="#"><em class="fa fa-envelope"></em> &nbsp;Reports </a></li>
                <li> <a href="#"><em class="fa fa-gears"></em> &nbsp;Settings </a></li>
				<li> <a href="<?php echo site_url('b_logout'); ?>"><em class="fa fa-sign-out"></em> &nbsp;Logout </a></li>
            </ul>
        </div>

        <!-- This container emulates the body -->
        <div class="page-content-wrapper">
		  <nav class="navbar navbar-expand-md navbar-dark bg-primary">
	 <a class="navbar-brand" role="button" href="#menu-toggle" id="menu-toggle" ><i class="fa fa-bars"></i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search Items">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
    <ul class="navbar-nav mr-auto">
    </ul>
	  <ul class="navbar-nav ">
        <li class="navbar-brand"> Barangay East Rembo</li>
    </ul>
  </div>
</nav>