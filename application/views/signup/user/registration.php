<?php echo $header; ?>	
	<script type="text/javascript" src="<?php echo base_url("scripts/custom_scripts/form_validator.js"); ?>"></script>
	<script>
		$(window).load(function() {
			$('#registration_form').submit(function(e){
				error = form_validator(this);
				if(error)
				{
					e.preventDefault();
					return false;
				}
			});
		});
	</script>
	<div class="container container_top" id="user_registration">
		<div class="row title-area">
			<div class="col-md-4" id="logo_area">
				<h1 id="logo">
					<a href="<?php echo $base_url; ?>"><span class="violet">Party</span><span class="orange">quire</span></a>
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
		<div class="row" sectionFor="form">
			<div class="col-md-6">
				<h3>User Registration</h3>
				<form id="registration_form" action="<?php $base_url; ?>signup?t=user" method="post">
					<p><input type="text" name="firstname" required-type="text" class="form-control required" placeholder="First Name"/></p>
					<p><input type="text" name="middlename" required-type="text" class="form-control required" placeholder="Middle Name"/></p>
					<p><input type="text" name="lastname" required-type="text" class="form-control required" placeholder="Last Name"/></p>
					<p><input type="text" name="email" required-type="email" class="form-control required" placeholder="Email" /></p>
					<p><input type="password" name="password" required-type="text" class="form-control required" placeholder="Password" /></p>
					<p><input type="password" name="confirm_password" required-type="text" class="form-control required" placeholder="Re-enter Password" /></p>
					<p><input type="text" name="address" required-type="text" class="form-control required" placeholder="Address" /></p>
					<p><input type="text" name="nationality" required-type="text" class="form-control required" placeholder="Nationality" /></p>
					<p><button type="submit" class="btn btn-default">Register</button> <label style="font-size: 8px;"><input type="checkbox"> I accept the Terms & Conditions</input></label></p>
				</form>
			</div>
		</div>
	</div>
<?php echo $footer; ?>