<?php echo $header; ?>
	<script type="text/javascript" src="<?php echo base_url("scripts/custom_scripts/form_validator.js"); ?>"></script>
	<script>
		$(window).load(function() {
			$('#venue_details_form').submit(function(e){
				error = form_validator(this);
				if(error)
				{
					e.preventDefault();
					return false;
				}
			});
		});
	</script>
	<div class="container container_top">
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
		<div class="row">
			<div class="col-md-12">
				<img src="<?php echo base_url('images/listing_prices.gif'); ?>" width="100%">
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<form id="venue_details_form" method="POST" class="form-horizontal">
					<h4 class="orange">Payment</h4>
					<div class="form-group">
						<div id="first_name"><?php echo form_error('first_name'); ?></div>
						<label class="control-label col-sm-4" for="first_name">First Name:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control required" required-type="text" name="first_name" value="<?php echo set_value('first_name'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div id="last_name"><?php echo form_error('last_name'); ?></div>
						<label class="control-label col-sm-4" for="last_name">Last Name:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control required" required-type="text" name="last_name" value="<?php echo set_value('last_name'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div id="personal_email"><?php echo form_error('personal_email'); ?></div>
						<label class="control-label col-sm-4" for="personal_email">Email:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control required" required-type="email" name="personal_email" value="<?php echo set_value('personal_email'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<p style="text-align: right;"><button type="submit" style="background: #3FA9F5;color:#fff;border:0;padding:10px;">Submit</button></p>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<h4 class="orange">Plan Details</h4>
				<dl class="dl-horizontal">
					<dt>Product</dt>
					<dd><?php echo $listing_plan_details['Name']; ?></dd>
					<dt>Price</dt>
					<dd><?php echo $listing_plan_details['Currency'].' '.number_format($listing_plan_details['Price'],2); ?></dd>
					<dt>Duration</dt>
					<dd><?php echo $listing_plan_details['Length'].' '.$listing_plan_details['Frequency']; ?></dd>
					<dt>Inclusion</dt>
					<dd><?php echo $listing_plan_details['Inclusion'] ?></dd>
				</dl>
				<div class="text-center">
					<?php echo $listing_plan_details['PaypalButton']; ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $footer; ?>