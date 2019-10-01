
<div class="col-sm-2">
	<ul class="nav nav-pills nav-stacked h5">
		<li class="nav-item ">
			<a class="nav-link nav-link-color active" data-toggle="pill" href="#pill1" aria-expanded="true">Home </a>
		</li>
		<li class="nav-item">
			<a class="nav-link nav-link-color" href="b_reports" aria-expanded="false">Lost & Found</a>
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
		<!-- <li class="nav-item">
			<a class="nav-link nav-link-color " href="b_logout" aria-expanded="false">Logout</a>
		</li> -->
	</ul>
</div>

<div class="col-sm-10 bg-grey bg-lighten-4">
	<div class="tab-content">
		<div class="row mt-1">
			<div class="col-md-6">
				<div class="card px-1 py-1">
					<div class="card-body">
						<div class="row">
							<div class="col-md-3">
								<img class="img-fluid" src="<?php echo base_url() . $brgy_logo;?>" alt="brgy logo" width="100px" height="100px">
							</div>
							<div class="col-md-9">
								<div class="row">
									<h3 class="text-info"><?php echo $brgy_name; ?></h3>
									<small class="text-muted"><?php echo $brgy_address; ?></small>
									<br>
									<p>Currently login as: <b><?php echo $username; ?></b></p>
									<button data-target="#change-password-modal" data-toggle="modal" class="btn btn-secondary btn-sm">Change Password</button>
									<button data-target="#logout-modal" data-toggle="modal" class="btn btn-outline-danger btn-sm">Logout</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row mt-1">
					<div class="col-md-3">
						<div class="card border-danger mb-3" style="max-width: 18rem;">
							<div class="card-header text-md-center bg-danger text-white"><b>Reported Lost</b></div>
								<div class="card-body">
									<h5 align="center" class="card-title mt-1"><?php echo $total_lost_count; ?></h5>
								</div>
							</div>
						</div>
						<div class="col-md-3">
						<div class="card border-success mb-3" style="max-width: 18rem;">
							<div class="card-header text-md-center bg-success text-white"><b>Reported Found</b></div>
							<div class="card-body">
								<h5 align="center" class="card-title mt-1"><?php echo $total_found_count; ?></h5>
							</div>
						</div>
					</div>
					<div class="col-md-3">
					<div class="card border-warning mb-3" style="max-width: 18rem;">
						<div class="card-header text-md-center bg-warning text-white"><b>Turnover Request</b></div>
						<div class="card-body">
							<h5 align="center" class="card-title mt-1"><?php echo $total_turnover_count; ?></h5>
						</div>
					</div>
					</div>
					<div class="col-md-3">
					<div class="card border-primary mb-3" style="max-width: 18rem;">
						<div class="card-header text-md-center  bg-primary text-white"><b>Received Items</b></div>
						<div class="card-body">
							<h5 align="center" class="card-title mt-1"><?php echo $total_received_count; ?></h5>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="row mt-1">
			<div class="col-md-3">
			<div class="card border-danger mb-3" style="max-width: 18rem;">
				<div class="card-header text-md-center bg-danger text-white"><b>Total Reported Lost</b></div>
					<div class="card-body">
						<h2 align="center" class="card-title mt-1"><?php echo $total_lost_count; ?></h2>
					</div>
					<div class="card-footer text-md-center">
					<a href="" class="text-info"><u>View Logs</u></a>
					</div>
				</div>
			</div>
			<div class="col-md-3">
			<div class="card border-success mb-3" style="max-width: 18rem;">
				<div class="card-header text-md-center bg-success text-white"><b>Total Reported Found</b></div>
				<div class="card-body">
					<h2 align="center" class="card-title mt-1"><?php echo $total_found_count; ?></h2>
				</div>
				<div class="card-footer text-md-center">
					<a href="" class="text-info"><u>View Logs</u></a>
				</div>
			</div>
			</div>
			<div class="col-md-3">
			<div class="card border-warning mb-3" style="max-width: 18rem;">
				<div class="card-header text-md-center bg-warning text-white"><b>Total Turnover Request</b></div>
				<div class="card-body">
					<h2 align="center" class="card-title mt-1"><?php echo $total_turnover_count; ?></h2>
				</div>
				<div class="card-footer text-md-center">
				<a href="" class="text-info"><u>View Logs</u></a>
				</div>
			</div>
			</div>
			<div class="col-md-3">
			<div class="card border-primary mb-3" style="max-width: 18rem;">
				<div class="card-header text-md-center  bg-primary text-white"><b>Total Received Items</b></div>
				<div class="card-body">
					<h2 align="center" class="card-title mt-1"><?php echo $total_received_count; ?></h2>
				</div>
				<div class="card-footer text-md-center">
				<a href="" class="text-info"><u>View Logs</u></a>
				</div>
			</div>
			</div>
		</div> -->
		<div class="row">
			<h3>&nbsp;&nbsp;&nbsp;<span><img src="<?php echo base_url(); ?>assets/custom/img/graph_icon.png" width="24px" height="24px" /></span>
			Analytics <small>(Overview)</small></h3>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-md-9">
							Lost & Found Reports
							</div>
							<div class="col-md-3">
							<div class="input-group">
									<select class="custom-select" id="lfchart-filter">
										<option value="Daily">Daily</option>
										<option value="Weekly">Weekly</option>
										<option value="Monthly">Monthly</option>
										<option value="Yearly">Yearly</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<canvas id="lost-found-chart" height="250"></canvas>
					</div>
					<div class="card-footer">
						<small class="text-muted" id="lf-timeago">Last updated on <?php echo date('h:i A'); ?></small>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-md-9">
							Turnover Request & Received Items
							</div>
							<div class="col-md-3">
							<div class="input-group">
									<select class="custom-select" id="trchart-filter">
										<option value="Daily">Daily</option>
										<option value="Weekly">Weekly</option>
										<option value="Monthly">Monthly</option>
										<option value="Yearly">Yearly</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<canvas id="turnover-request-chart" height="250"></canvas>
					</div>
					<div class="card-footer">
					<small class="text-muted" id="tr-timeago">Last updated on <?php echo date('h:i A'); ?></small>
					</div>
				</div>
			</div>
		</div>
		<div class="row">

			<div class="col-md-12">
				<div class="card">
					<div class="card-header ">
						<span class="tag tag-warning">Turnover Requests</span>
					</div>
					<div class="card-body p-1">
						<table class="table table-hover table-striped " id="turnover-request-table" style="width: 100%;">
							<thead>
								<tr>
									<th>ID</th>
									<th>Item Title</th>
									<th>Posted By</th>
									<th>Date Posted</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($turnover_items as $row): ?>
								<tr>
									<td><?php echo $row['repo_id']; ?></td>
									<td><?php echo $row['item_name']; ?></td>
									<td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
									<td><?php echo substr($row['date_created'], 0,10); ?></td>
									<td>
									<a href="<?php echo base_url() . "items/" . $row['item_id']; ?>" class="btn btn-sm btn-info">View Details</a>
										<button id="turnover-receive-btn" class="btn btn-sm btn-success" data-toggle="modal" data-target="#confirm-receive-modal">Receive</button>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<span class="tag tag-primary">Received Items</span>
					</div>
					<div class="card-body p-1">
						<table class="table table-hover table-striped " id="received-items-table" style="width: 100%;">
							<thead>
								<tr>
									<th>Item Title</th>
									<th>Surrendered By</th>
									<th>Date Surrendered</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($received_items as $row): ?>
								<tr>
									<td><?php echo $row['item_name']; ?></td>
									<td><?php echo $row['first_name']." ";echo $row['last_name']; ?></td>
									<td><?php echo substr($row['date_received'], 0,10); ?></td>
									<td>
									<a href="<?php echo base_url() . "items/" . $row['item_id']; ?>" class="btn btn-sm btn-info">View Details</a>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
