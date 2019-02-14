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

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css"/>
    <!-- /DataTables CSS -->

  </head>
  <body>
 
<div id="wrapper">
        <div id="sidebar-wrapper" class="bg-light">
            <ul class="sidebar-nav">
                <li class="sidebar-brand"> <a href="#"><b>MakaHanap</b> </a></li>
                <li> <a href="<?php echo site_url('dashboard'); ?>"><em class="fa fa-dashboard"></em> &nbsp;Dashboard </a></li>
                <li>
               	 <a href="#itemSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><em class="fa fa-list"></em> &nbsp;Items&ensp;&ensp;&ensp;&emsp;&ensp;&ensp;</a>
               	 <ul class="collapse list-unstyled bg-secondary " id="itemSubmenu" style="font-size: .8rem;">
                	   <li>
                	       <a href="<?php echo site_url('repository'); ?>">&emsp;&emsp;&emsp;Repository</a>
                	   </li>
               	     <li>
               	         <a href="reported_lost">&emsp;&emsp;&emsp;Lost Items</a>
               	     </li>
                    <li>
               	         <a href="reported_found">&emsp;&emsp;&emsp;Found Items</a>
               	     </li>
                      <li>
               	         <a href="#">&emsp;&emsp;&emsp;Matched Items</a>
               	     </li>
                      <li>
               	         <a href="#">&emsp;&emsp;&emsp;Returned Items</a>
               	     </li>
                      <li>
               	         <a href="#">&emsp;&emsp;&emsp;Disposed Items</a>
               	     </li>
               	  </ul>
            	  </li>
                <li>
               	 <a href="#b_submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><em class="fa fa-road"></em> &nbsp;Baranggay &emsp;</a>
               	 <ul class="collapse list-unstyled bg-secondary" id="b_submenu" style="font-size:.8rem">
                	   <li>
                	       <a href="#">&emsp;&emsp;&emsp;District &ensp;I</a>
                	   </li>
               	     <li>
               	         <a href="#">&emsp;&emsp;&emsp;District &ensp;II</a>
               	     </li>
               	  </ul>
            	  </li>
                <li> <a href="<?php echo site_url('users_controller'); ?>"><em class="fa fa-users"></em> &nbsp;Users </a></li>
                <li> <a href="#"><em class="fa fa-file"></em> &nbsp;Reports </a></li>
                <li> <a href="#"><em class="fa fa-comment"></em> &nbsp;Feedbacks </a></li>
				        <li> <a href="#"><em class="fa fa-gears"></em> &nbsp;Settings </a></li>
                
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
      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#lost_item_modal">
        <i class="fa fa-plus" ></i> 
        Lost Item
      </button>&nbsp;&nbsp;&nbsp;&nbsp;
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#found_item_modal">
        <i class="fa fa-plus" ></i> 
        Found Item
      </button>
	    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata['logged_in']['username']; ?></a>
    <div class="dropdown-menu dropdown-menu-right">
      <a class="dropdown-item" href="#">Edit Account Info</a>
      <a class="dropdown-item" href="#">Add New User</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="<?php echo site_url('logout'); ?>">Sign Out</a>
    </div>
  </li>  
     
    </ul>
  </div>
</nav>