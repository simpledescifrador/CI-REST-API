<div class="col-sm-2">
	<ul class="nav nav-pills nav-stacked h5">
		<li class="nav-item ">
			<a class="nav-link nav-link-color"  href="barangay">Home </a>
		</li>
		<li class="nav-item">
			<a class="nav-link nav-link-color active" href="b_reports" aria-expanded="false">Lost & Found</a>
		</li>
		<!-- <li class="nav-item">
			<a class="nav-link nav-link-color "   href="#pill3" aria-expanded="false">Messages</a>
		</li>
		<li class="nav-item">
			<a class="nav-link nav-link-color " href="#pill3" aria-expanded="false">Records</a>
		</li>
		<li class="nav-item">
			<a class="nav-link nav-link-color "   href="#pill4" aria-expanded="false">Settings</a>
		</li> -->
		<!-- <li class="nav-item">
			<a class="nav-link nav-link-color " href="b_logout" aria-expanded="false">Logout</a>
		</li> -->
	</ul>
</div>
<div class="col-sm-10 bg-grey bg-lighten-4">
	<div class="tab-content px-1">
		<br>
		<div class="form-group">
			<div class="input-group">
				<input id="search_keyword" type="text" class="form-control" placeholder="Search" aria-label="Amount (to the nearest dollar)" name="Search">
				<span class="input-group-addon">
					<a id="search-item"class="icon-search"></a>
				</span>
			</div>
		</div>
		<p id ="loading-display" align="center"></p>
		<p id="search-result" align="center"></p>
		<div class="row">
			<div id="items">
				<?php if (isset($items)): ?>
					<?php foreach($items as $row): ?>
						<?php $type_class = ($row['item_type'] == 'Found')? 'success': 'danger';?>
						<figure class="col-lg-3 col-md-6 col-xs-12" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
						<a href="<?php echo base_url() . "items/" . $row['item_id']; ?>">
						<div class="card items-card" id="posts_hover" title="Click to view details of this post." >
							<div class="card-body">
								<img class="card-img-top img-fluid" src="<?php echo base_url() . $row['item_image_url']; ?>" alt="Card image cap">
								<div class="card-block" style="height: 12em;">
									<div style="height: 3em;" >
										<small class="tag tag-<?php echo $type_class; ?>"><?php echo $row['item_type']; ?></small>
										<small class="text-muted">@<?php echo $row['item_location']; ?></small>
									</div>

									<h4 class="card-title mt-1 grey darken-4"><?php echo $row['item_title']; ?></h4>
									<p class="valign-bottom grey darken-4">

										<b>Posted By: </b><?php echo $row['account_name']; ?>
										<br>

									</p>
								</div>
							</div>
							<div class="card-footer">
								<small class="text-muted">Timestamp: <?php echo $row['item_created_at']; ?></small>
							</div>
						</div>
						</a>
						</figure>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
