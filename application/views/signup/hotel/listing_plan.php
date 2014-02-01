<?php echo $header; ?>
	<script type="text/javascript" src="<?php echo base_url("scripts/custom_scripts/form_validator.js"); ?>"></script>
	<script>
		$(window).load(function() {
			$('#listing_plan_form').submit(function(e){
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
		<form id="listing_plan_form" method="POST">
			<div class="row">
				<?php foreach($plans as $indx => $plan){ ?>
					<div class="col-md-2 col-md-offset-<?php echo (12-(count($plans)*2))/2; ?>" style="padding:1px">
						<div style="border: 1px solid #ababab;background: #F2F2F2;text-align:center;padding: 0px 14px; height: 500px;">
							
							<h3 style="color:#7AC943"><?php echo $plan['Name']; ?></h3>
							<p><?php echo $plan['Description']; ?></p>
							<p style="background: #6B2499;border-radius: 7px;color: #FFF;font-size:20px;">
								<?php echo ($plan['Price']>0?$plan['Currency'].' '.$plan['Price']:'Free trial').'<br/>'.($plan['Length']>0?'for '.$plan['Length'].' '.$plan['Frequency']:$plan['Frequency']); ?>
							</p>
							<p><?php echo $plan['Inclusion']; ?></p>
							<div style="position:absolute;bottom:20px;left:0px;width:100%;"><input type="radio" <?php echo ($indx==0?'checked="checked"':''); ?> name="plan" value="<?php echo $plan['PlanID']; ?>"/></div>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="row" style="margin-top:30px;">
				<div class="col-md-12">
					<p>*After 30 day trial you must upgrade your plan to continue to be listed.</p>
					<p>Gold and Platinum Plan coming soon.</p>
				</div>
			</div>
			<div class="row" style="margin-bottom:130px;">
				<div class="col-md-6">
				</div>
				<div class="col-md-6">
					<p style="text-align: right;"><button type="submit" style="background: #3FA9F5;color:#fff;border:0;padding:10px;">Almost there: Venue Details</button></p>
				</div>
			</div>
		</form>
	</div>
<?php echo $footer; ?>