<?php echo $header; ?>
	<script type="text/javascript" src="<?php echo base_url("scripts/custom_scripts/form_validator.js"); ?>"></script>
	<script>
		$(window).load(function() {
			$('#messaging form').submit(function(e){
				error = form_validator(this);
				if(error)
				{
					e.preventDefault();
					return false;
				}
			});
		});
	</script>
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
				<h3>Message <?php echo $RecipientName; ?></h3>
			</div>
		</div>
		<div class="row" id="messaging">
			<div class="col-md-10 col-md-offset-1">
				<form action="<?php echo $base_url; ?>user/message?u=<?php echo $UserID; ?>" method="POST">
					<div class="row" sectionFor="message">
						<textarea class="form-control required" required-type="text" placeholder="Enter your message here"></textarea>
					</div>
					<div class="row text-right">
						<button type="submit" class="btn btn-primary">Send</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php echo $footer; ?>