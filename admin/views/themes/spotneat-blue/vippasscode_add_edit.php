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
				<li class="active"><a href="#story-group" data-toggle="tab">VIP Pass code</a></li>
			</ul>
		</div>
			<?php echo form_open_multipart($_action,'id="edit-form" class="form-horizontal" role="form"')  ?>
			<div class="tab-content">
				<div id="story-group" class="tab-pane row wrap-all active">					
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Code<span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="passcode" id="passcode" class="form-control" maxlength="100" required value="<?php if(!empty($default_code)){ echo $default_code->code; } ?>" />
							<?php echo form_error('passcode', '<span class="text-danger">', '</span>'); ?>
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
});
//--></script>

<?php echo get_footer(); ?>