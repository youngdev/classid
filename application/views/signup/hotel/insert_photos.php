<?php echo $header; ?>
	<script type="text/javascript" src="<?php echo base_url("scripts/custom_scripts/form_validator.js"); ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url("css/fileupload.css"); ?>"/>
	<script type="text/javascript" src="<?php echo base_url("scripts/jquery.ui.widget.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("scripts/jquery.iframe-transport.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("scripts/jquery.fileupload.js"); ?>"></script>
	<script>
		$(window).load(function() {
			$('#insert_photos_form').submit(function(e){
				error = form_validator(this);
				if(error)
				{
					e.preventDefault();
					return false;
				}
			});
		});
		$(function () {
	        'use strict';
	        
	        // Define the url to send the image data to
	        var url = '<?php echo site_url('signup/upload'); ?>';
	        
	        // Call the fileupload widget and set some parameters
	        $('#fileupload').fileupload({
	            url: url,
	            dataType: 'json',
	            done: function (e, data) {
	                // Add each uploaded file name to the #files list
	                $.each(data.result.files, function (index, file) {
	                	if(file.hasOwnProperty('error'))
	                	{
	                		
	                	}
	                	else
	                	{
	                		$('<li/>').append(
	                			$('<img/>').attr('src',file.thumbnailUrl).addClass('img-thumbnail'),
	                			$('<input/>').attr('name','images[]').addClass('hidden').val(file.name)
	                		).appendTo('#files');	
	                	}
	                });
	            },
	            progressall: function (e, data) {
	                // Update the progress bar while files are being uploaded
	                var progress = parseInt(data.loaded / data.total * 100, 10);
	                $('#progress .progress-bar').css(
	                    'width',
	                    progress + '%'
	                );
	            }
	        });
	    });
	</script>
	<style>
		.padding-left-0 li {
			padding-left: 0!important;
		}
	</style>
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
				<img src="<?php echo base_url('images/listing_photo.gif'); ?>" width="100%">
			</div>
		</div>
		<form id="insert_photos_form" method="post">
			<div class="row">
				<div class="col-md-12 text-center">
					<h4 class="red">Insert Photos</h4>
					<p><strong>Step 4 -  Add Your Photos (Optional But Recommended)</strong></p>
					<p style="margin-bottom:30px"><strong>Venues with more than one photo get 300% more searches and leads.</strong></p>
					<p><strong>Upload some great photos of your venue. (<span class="red">Max file size -MB</span>)</strong></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<p>
						<!-- Button to select & upload files -->
						<span class="btn btn-success btn-block fileinput-button">
							<span>Select files...</span>
							<!-- The file input field used as target for the file upload widget -->
							<input id="fileupload" type="file" name="files[]" multiple>
						</span>
					</p>
					<!-- The global progress bar -->
					<!--p>Upload progress</p-->
					<div id="progress" class="progress progress-striped">
						<div class="progress-bar progress-bar-success" role="progressbar"></div>
					</div>
					<!-- The list of files uploaded -->
					<!--p>Files uploaded:</p-->
					<ul id="files" class="list-unstyled list-inline padding-left-0"></ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div id="terms"><?php echo form_error('terms'); ?></div>
					<div class="form-group checkbox">
						<label><input type="checkbox" class="required" required-type="checked" name="terms" value="1" <?php echo set_checkbox('terms','1'); ?>/> I accept the <a href="#">Venue Terms of Use</a> for this Listing</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4" style="text-align:center;margin-top: 40px;margin-bottom: 40px;">
					<button type="submit" style="background: #7AC943;color:#fff;border:0;padding:5px 55px;font-size: 31px;">Confirmation</button>
				</div>
			</div>
		</form>
	</div>
<?php echo $footer; ?>