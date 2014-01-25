<?php echo $header; ?>
	<div class="container container_top" id="profile">
		<div class="row title-area">
			<div class="col-md-4" id="logo_area">
				<h1 id="logo">
					<span class="violet">Party</span><span class="orange">quire</span>
				</h1>
				<h4 id="motto">
					Your first Party Venue Partner in UAE
				</h4>
			</div>
			<div class="col-md-4">
			
			</div>
			<div class="col-md-4">
			
			</div>
		</div>
		<div class="row" id="nav">
			<div class="col-md-12 clearfix">
				<ul>
				<?php foreach($nav_menu as $key=>$menu) : ?>
					<li><a href="<?php echo $menu; ?>"><?php echo $key; ?></a></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>PROFILE</h3>
			</div>
		</div>
		<div class="row" id="profile_info">
			<div class="col-md-3">
				<img src="<?php echo $ProfileImage; ?>" />
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-12" id="name">
						<?php echo $Name; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						From: <?php echo $Address; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						Speaks: <?php echo $Languages; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<a href="<?php echo $base_url; ?>user/messageme/<?php echo $UserID; ?>">Message Me</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="statistics">
			<div class="col-md-4">
				<h3><?php echo $QuotesCount; ?></h3>
				<span>QUOTE REQUESTED</span>
			</div>
			<div class="col-md-4">
				<h3><?php echo $ViewedCount; ?></h3>
				<span>VENUES REQUESTED</span>
			</div>
			<div class="col-md-4">
				<h3><?php echo $BookedCount; ?></h3>
				<span>VENUES BOOKED</span>
			</div>
		</div>
		<div class="row" id="viewed_venues">
			<div class="col-md-12">
				<h3>Recently Viewed Venues</h3>
			</div>
			<div class="col-md-12">
				<?php foreach($VenuesViewed as $idx=>$venue): ?>
					<div class="col-md-2 <?php echo $idx==0?'col-md-offset-3':''; ?> venues">
						<div class="col-md-12 image">
						</div>
						<div class="col-md-6">
							<?php echo $venue['VenueName']; ?>
						</div>
						<div class="col-md-6">
							<?php echo ($venue['MinimumPackageRate'] + $venue['MaximumPackageRate']) / 2; ?>
						</div>
						<div class="col-md-12">
							<a href="#HotelController/Method/ID">Read More</a>
						</div>
					</div>
				<?php endforeach; ?>
				<?php if(count($VenuesViewed) == 0) : ?>
					<div class="col-md-12 text-center">
						No Viewed Venues yet
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php echo $footer; ?>