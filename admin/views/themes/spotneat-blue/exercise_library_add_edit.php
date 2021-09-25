<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Video Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Title</label>
						<div class="col-sm-5">
							<span><?php echo $video_detail['title']; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Description</label>
						<div class="col-sm-5">
							<span><?php echo $video_detail['description']; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-discount" class="col-sm-3 control-label">Video</label>
						<div class="col-sm-5">
							<div class="input-group">
								<iframe src="<?php echo $video_detail['video_url']; ?>" width="600" height="400" frameborder="0" title="" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Category</label>
						<div class="col-sm-5">
							<span><?php echo $workoutVvideoModules[$video_detail['workout_video_module_id']]; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Schedule</label>
						<div class="col-sm-5">
							<span><?php echo $scheduleList[$video_detail['workout_video_schedule_id']]; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Duration</label>
						<div class="col-sm-5">
							<span><?php echo $video_detail['duration']; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Week</label>
						<div class="col-sm-5">
							<span><?php echo $video_detail['week']; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Day</label>
						<div class="col-sm-5">
							<span><?php echo $video_detail['day']; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Sets</label>
						<div class="col-sm-5">
							<span><?php echo $video_detail['sets']; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Reps</label>
						<div class="col-sm-5">
							<span><?php echo $video_detail['reps']; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label">Filename</label>
						<div class="col-sm-5">
							<span><?php echo $video_detail['filename']; ?></span>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {

	$('.date').datepicker({
		format: 'dd-mm-yyyy'
	});

	$('#fixed-from-time, #fixed-to-time, #recurring-from-time, #recurring-to-time').timepicker({
		defaultTime: ''
	});

	$(document).on('change', '#coupon-type input[type="radio"]', function() {
		if (this.value === 'P') {
			$('#discount-addon').html('%');
		} else {
			$('#discount-addon').html('<?php echo lang('text_leading_zeros'); ?>');
		}
	});

	$(document).on('change', 'input[name="validity"]', function() {
		$('#validity-fixed, #validity-period, #validity-recurring').fadeOut();
		if (this.value == 'fixed' || this.value == 'period' || this.value == 'recurring') {
			$('#validity-' + this.value).fadeIn();
		}
	});

	$(document).on('change', 'input[name="fixed_time"], input[name="recurring_time"]', function() {
		$(this).parent().parent().parent().find('.input-group').fadeOut();
		if (this.value == 'custom') {
			$(this).parent().parent().parent().find('.input-group').fadeIn();
		}
	});
});
//--></script>
<?php echo get_footer(); ?>