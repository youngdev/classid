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
		<form id="venue_details_form" method="POST">
			<div class="row">
				<div class="col-xs-4">
					<h4 class="orange">Location</h4>
					<label>Enter the address of your venue</label>
					<div class="form-group">
						<?php echo form_error('street'); ?>
						<input type="text" class="form-control required" required-type="text" name="street" placeholder="Street" value="<?php echo set_value('street'); ?>" />
					</div>
					<div class="form-group">
						<?php echo form_error('city'); ?>
						<select class="form-control required" required-type="text" name="city">
							<option value=""> -- </option>
							<?php foreach($cities as $city){ ?>
								<option value="<?php echo $city['CityID']; ?>" <?php echo set_select("city",$city['CityID']); ?>><?php echo $city['City']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h4 class="orange">Pricing</h4>
					<span class="help-block">
						Prices are displayed either as range (e.g. "AED 1000 to AED 5000") or a single starting prices (e.g. "Starting at AED 1000").<br/>
						Please enter your starting price (required) and a maximum price (optional).<br/><br/>
						Note: The minimum price must be at least AED 250.
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label" for="minimum">Your minimum price per booking: <strong>(required)</strong></label>
						<?php echo form_error('minimum'); ?>
						<input type="text" class="form-control required" required-type="float" name="minimum" value="<?php echo set_value('minimum'); ?>"/>
					</div>
					<div class="form-group">
						<label class="control-label" for="maximum">Your maximum price per booking: <strong>(optional)</strong></label>
						<?php echo form_error('maximum'); ?>
						<input type="text" class="form-control" name="maximum" value="<?php echo set_value('maximum'); ?>"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h4 class="orange">Venue Features</h4>
					<div class="form-group">
						<label class="control-label" for="event">Types of Events</label>
						<?php echo form_error('event'); ?>
						<div class="row">
							<?php foreach($events as $indx => $event){ ?>
								<?php if($indx%4 == 0){ ?>
									<div class="col-md-2">
										<ul class="list-unstyled">
								<?php } ?>
								<li><input type="checkbox" name="event[]" value="<?php echo $event['EventTypeID']; ?>" <?php echo set_checkbox('event[]',$event['EventTypeID']); ?>/> <?php echo $event['EventTypeName']; ?></li>
								<?php if($indx%4 == 3){ ?>	
										</ul>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="amenity">Amenities</label>
						<?php echo form_error('amenities'); ?>
						<div class="row">
							<?php foreach($amenities as $indx => $amenity){ ?>
								<?php if($indx%4 == 0){ ?>
									<div class="col-md-2">
										<ul class="list-unstyled">
								<?php } ?>
								<li><input type="checkbox" name="amenity[]" value="<?php echo $amenity['AmenityID']; ?>" <?php echo set_checkbox('amenity[]',$amenity['AmenityID']); ?>/> <?php echo $amenity['AmenityName']; ?></li>
								<?php if($indx%4 == 3){ ?>	
										</ul>
									</div>
								<?php } ?>
							<?php } ?>
							<?php echo form_error('venue_name'); ?>
							<div><input type="checkbox" name="amenity[]" value="others" <?php echo set_checkbox('amenity[]','others'); ?>/> Others</div>
							<textarea name="amenity_others"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<h4 class="orange">Size</h4>
					<div class="form-group">
						<label class="control-label" for="square_footage">Square Footage</label>
						<?php echo form_error('square_footage'); ?>
						<input type="text" class="form-control checker" checker-type="float" name="square_footage" value="<?php echo set_value('square_footage'); ?>"/>
					</div>
					<div class="form-group">
						<label class="control-label" for="max_occupancy">Max Occupancy</label>
						<?php echo form_error('max_occupancy'); ?>
						<input type="text" class="form-control checker" checker-type="int" name="max_occupancy" value="<?php echo set_value('max_occupancy'); ?>"/>
					</div>
				</div>
			</div>
			<div class="row" style="margin-bottom:130px;">
				<div class="col-md-6">
				</div>
				<div class="col-md-6">
					<p style="text-align: right;"><button type="submit" style="background: #3FA9F5;color:#fff;border:0;padding:10px;">Last Step: Insert Photos</button></p>
				</div>
			</div>
		</form>
	</div>
<?php echo $footer; ?>
