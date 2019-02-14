<!-- Dashboard content-->
			
<div  style="padding-top: 1%;padding-left: 2%;padding-right: 2%;">
				<h4>Dashboard</h4>
			</div>
			
		  <!-- Dasboard Cards -->
		  <div class="row" style="padding-left: 2%; padding-right: 2%">
			  <!--Reported Lost Card -->
			  <div class="col dash-cards">
			    <div class="card text-white bg-warning" style="max-width: 20rem;">
				  <div class="card-body">
				    <div class="custom-card-title"><b>Reported Lost <em class="fa fa-3x fa-tag"></em></b></div>
					  	<center>
					  	  <h3><strong>
									<?php echo $total_lost; ?>
								</strong></h3>
				  	</center>
					  </div>
						<a href="#" style="color:white;"><div class="card-footer text-center"><small>Show all items &nbsp; <em class="fa fa-arrow-right"></em></small></div></a>
				  </div>
			  </div>
			  <!-- /Reported Lost Card End-->
			  
			  <!--Items FOund Card -->
			  <div class="col dash-cards">
			    <div class="card text-white bg-dark" style="max-width: 20rem;">
				  <div class="card-body">
				    <div class="custom-card-title" style="text-align: center;"><strong>Items Found <em class="fa fa-3x fa-tag"></em></strong></div>
					  	<center>
					  	  <h3><strong><?php echo $total_found; ?></strong></h3>
				  	</center>
					  </div>
						<a href="#" style="color:white;"><div class="card-footer text-center"><small>Show all items &nbsp; <em class="fa fa-arrow-right"></em></small></div></a>
				  </div>
			  </div>
			  <!-- /Items Found Card End-->
			  
			  <!--Items Matched Card -->
			  <div class="col dash-cards">
			    <div class="card text-white bg-info" style="max-width: 20rem;">
				  <div class="card-body">
				    <div class="custom-card-title" style="text-align: center;"><strong>Matched <em class="fa fa-3x fa-check"></em></strong></div>
					  	<center>
					  	  <h3><strong>20</strong></h3>
				  	</center>
					  </div>
						<a href="#" style="color:white;"><div class="card-footer text-center"><small> Show all items &nbsp; <em class="fa fa-arrow-right"></em></small></div></a>
				  </div>
			  </div>
			  <!-- /Items Matched Card End-->
			  
			  <!--Returned Card -->
			  <div class="col dash-cards">
			    <div class="card text-white bg-primary" style="max-width: 20rem;">
				  <div class="card-body">
				    <div class="custom-card-title" style="text-align: center;"><strong>Returned <em class="fa fa-3x fa-exchange"></em></strong></div>
					  	<center>
					  	  <h3><strong>20</strong></h3>
				  	</center>
					  </div>
						<a href="#" style="color:white;"><div class="card-footer text-center"><small> Show all items &nbsp; <em class="fa fa-arrow-right"></em></small></div></a>
				  </div>
			  </div>
			  <!-- /Returned Card End-->
			  
			  <!--Disposed Card -->
			  <div class="col dash-cards">
			    <div class="card text-white bg-danger" style="max-width: 20rem;">
				  <div class="card-body">
				    <div class="custom-card-title" style="text-align: center;"><strong>(Disposed?) <em class="fa fa-3x fa-trash"></em></strong></div>
					  	<center>
					  	  <h3><strong>20</strong></h3>
				  	</center>
				  </div>
					<a href="#" style="color:white;"><div class="card-footer text-center"><small> Show all items &nbsp; <em class="fa fa-arrow-right"></em></small></div></a>
			    </div>
			  </div>
			  <!--/Disposed Card End-->
		  </div>
		   <!--/ Dasboard Cards End-->
			
			<br>

			<!-- Lost and Found Items tables container-->
      <div class="row" style="padding:2%;">
			<div class="col-lg-6"><!--Lost items table container-->
				<div class="card bg-white">
                        <div class="card-header">
                            <b><i class="fa fa-bar-chart-o fa-fw"></i> Lost Items Reported</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="card-body">
                            <div id="morris-area-chart-date"></div>
                        </div>
                        <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
			</div>
			<div class="col-lg-6"><!--Lost items table container-->
				<div class="card bg-white">
                        <div class="card-header">
                            <b><i class="fa fa-bar-chart-o fa-fw"></i> Reported Found Items</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="card-body">
                            <div id="returned-area-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
			</div>
		  </div>
			<!--0/ Lost and Found Items tables container-->

      
<div class="row" style="padding: 2%"><!-- row container -->
	
	<div class="col-sm-7">
	<div class="card mb-3">
            <div class="card-header">Active Registered Users</div>
                <div class="card-body">
                    <table id="reported_users_table" class="table table-striped table-hover table-bordered table-dark table-sm" style="width:100%">
                        <thead>
                            <tr>
                            <th>Date Received</th>
                            <th>Barangay</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>09/12/2018</td>
                            <td>East Rembo</td>
                            <td>F1123322</td>
                            <td>Samsung Galaxy S8 Edge</td>
                            <td><button type="button" class="btn btn-sm btn-info" >View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
	</div>
	<div class="col-sm-5"><!-- column size 4 -->
	<div class="card card-default"><!-- Reported Users Card -->
                        <div class="card-header">
                            <i class="fa fa-bell fa-fw"></i> Reported Users
                        </div>
                        <!-- /.panel-heading -->
                        <div class="card-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Juan Dela Cruz
                                    <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Anne Marie
                                    <span class="pull-right text-muted small"><em>12 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Rolando Verges
                                    <span class="pull-right text-muted small"><em>27 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Dorathy Vanorden
                                    <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Markus Decastro
                                    <span class="pull-right text-muted small"><em>11:32 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Deedee Veit
                                    <span class="pull-right text-muted small"><em>11:13 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Betsy Hudon
                                    <span class="pull-right text-muted small"><em>10:57 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Lashay Siers
                                    <span class="pull-right text-muted small"><em>9:49 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> Kylee Giddings
                                    <span class="pull-right text-muted small"><em>Yesterday</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <button href="#" class="btn btn-secondary btn-block">View All</button>
                        </div>
                        <!-- /.panel-body -->
    </div>
	</div><!-- column  size 4-->
</div><!--/ row container -->



<!-- / dashboard content -->