<?php echo get_header(); 
$dat=array();	
$i=0;
foreach($story_location_id as $locs){
$dat[$i]=$locs->location_id;
$i++;
}
// echo "<pre>";print_r($dat);exit();
?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#story-group" data-toggle="tab">Notifications</a></li>
			</ul>
		</div>
			<?php echo form_open_multipart($_action,'id="edit-form" class="form-horizontal" role="form"')  ?>
			<div class="tab-content">
				<div id="story-group" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Users<span style="color:red">*</span></label>
						<div class="col-sm-5">
						<select name="sent_to" id="sent_to" class="form-control"  >
                                <option value="ALL_USER" selected>All User</option>
								<option value="LEE_PRIEST_USER">Lee Priest User</option>
								<!-- <option value="LEE_PRIEST_USER_14_DAYS_AGO">Lee Priest Subscription(14 days ago)</option> -->
                            </select>
							<?php echo form_error('sent_to', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>


					<div class="form-group" id='location_div'>
						<label for="input-name" class="col-sm-3 control-label">Locations<span style="color:red">*</span></label>
						<div class="col-sm-5">
							<?php
								if(!empty($locationList))
								{
									foreach($locationList as $location){
								?>
                               
                                <input type="checkbox" name="locationIds[]" value="<?php echo $location['location_id'];?>" checked="checked"> <?php echo $location['location_name']; ?> &nbsp; &nbsp; &nbsp; <?php }
								}
								?>						 
						 
						</div>
					</div>


					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Title
						<span style="color:red">*</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="title" id="title" class="form-control" value="" maxlength="50"/>
							<br/>
							Max. 50 characters
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Write Message<span style="color:red">*</span></label>
						<div class="col-sm-5">
							<textarea name="message" id="message" cols="30" rows="10" class="form-control" maxlength="150"></textarea>							
							<br/>
							Max. 150 characters
							<?php echo form_error('message', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<input type="hidden" name="page_url" id="page_url" value="" />
					<!-- <div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Page URL
						</label>
						<div class="col-sm-5">
							<select name="page_url" id="page_url" class="form-control">
                                <option value="Home">Dashboard</option>
								<option value="Favourites">Recent Order</option>
								<option value="WorkoutDetail">Lee prist</option>
								<option value="SubscriptionPlan">Subscription</option>
                            </select>
							<?php //echo form_error('web_url', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> -->
					<input type="hidden" name="web_url" id="web_url" value="" />
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">URL
						</label>
						<div class="col-sm-5">
							<input type="text" name="web_url" id="web_url" class="form-control" value="" />
							<?php echo form_error('web_url', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Schedule Type
						<span style="color:red">*</span>
						</label>

						<div class="col-sm-5">
						<select name="schedule_type" id="schedule_type" class="form-control">
                                <option value="NOW">NOW</option>
								<option value="LATER">LATER</option>
								<option value="RECURRING">RECURRING</option>
                            </select>
						</div>
						
					</div>		
					<div class="form-group show_hide_time_zone" style="display:none;">
						<label for="input-status" class="col-sm-3 control-label">Time Zone
						<span style="color:red">*</span>
						</label>
						<div class="col-sm-5">
						<select name="time_zone" id="time_zone" class="form-control">
								<?php
								if(!empty($timeZoneList))
								{
									foreach($timeZoneList as $zone_value){
								?>
                                <option value="<?php echo $zone_value['time_zone_name']; ?>"><?php echo $zone_value['time_zone_name']; ?></option>
								<?php
									}
								}
								?>
                            </select>
						</div>
						
					</div>					
					<div class="form-group" id="show_hide_schedule_date" style="display:none;">
						<label for="input-status" class="col-sm-3 control-label">Schedule Date						
						</label>

						<div class="col-sm-5">
							<input type="datetime-local" name="schedule_date" id="schedule_date" class="form-control" value="" />
						</div>
						
					</div>		
					<div class="form-group show_hide_recurring_date" style="display:none;">
						<label for="input-status" class="col-sm-3 control-label">Recurring start Date						
						</label>

						<div class="col-sm-5">
							<input type="datetime-local" name="recurring_start_date" id="recurring_start_date" class="form-control" value="" />
						</div>
						
					</div>
					<div class="form-group show_hide_recurring_date" style="display:none;">
						<label for="input-status" class="col-sm-3 control-label">Recurring End Date						
						</label>

						<div class="col-sm-5">
							<input type="datetime-local" name="recurring_end_date" id="recurring_end_date" class="form-control" value="" />
						</div>
						
					</div>
					<div class="form-group show_hide_recurring_date" style="display:none;">
						<label for="input-status" class="col-sm-3 control-label">Recurring Type
						<span style="color:red">*</span>
						</label>

						<div class="col-sm-5">
						<select name="recurring_type" id="recurring_type" class="form-control">
                                <option value="DAILY">DAILY</option>
								<option value="MONTHLY">MONTHLY</option>
								<option value="YEARLY">YEARLY</option>
                            </select>
						</div>
						
					</div>		
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    $(".checkbox-toggle").on("click", function () {});

	$('#schedule_type').on('change', function() {
		if(this.value == 'LATER'){
			$('#show_hide_schedule_date').css('display','block');
			$('.show_hide_time_zone').css('display','block');
		} else{
			$('#show_hide_schedule_date').css('display','none');
		}

		if(this.value == 'RECURRING'){
			$('.show_hide_recurring_date').css('display','block');
			$('.show_hide_time_zone').css('display','block');
		} else{
			$('.show_hide_recurring_date').css('display','none');
		}

		if(this.value == 'NOW'){
			$('.show_hide_time_zone').css('display','none');
		}
	});


 


	$('#sent_to').on('change', function() {
		if(this.value == 'ALL_USER'){
			$('#location_div').show();
			
		} else{
			$('#location_div').hide();
		}
 
	});







});
//--></script>

<?php echo get_footer(); ?>