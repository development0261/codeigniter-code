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
				<li class="active"><a href="#story-group" data-toggle="tab">Trainer Info</a></li>				
			</ul>
		</div>
			<?php echo form_open_multipart($_action,'id="edit-form" class="form-horizontal" role="form"')  ?>
			<div class="tab-content">
				<div id="story-group" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">First Name</label>
						<div class="col-sm-5">
							<?php echo set_value('first_name', $first_name); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-5">
							<?php echo set_value('last_name', $last_name); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-5">
							<?php echo set_value('email', $email); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Telephone</label>
						<div class="col-sm-5">
							<?php echo set_value('telephone', $telephone); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">About Trainer</label>
						<div class="col-sm-5">
							<?php echo set_value('about_trainer', $about_trainer); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Trainer Short Info</label>
						<div class="col-sm-5">
							<?php echo set_value('trainer_short_info', $trainer_short_info); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Trainer Key Points</label>
						<div class="col-sm-5">
							<?php echo set_value('trainer_key_points', $trainer_key_points); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Instagram Link</label>
						<div class="col-sm-5">
							<?php echo set_value('instagram_link', $instagram_link); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Date Added</label>
						<div class="col-sm-5">
							<?php echo set_value('date_added', $date_added); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Status
						<span style="color:red">*</span>
							<span class="help-block"><?php echo lang('help_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
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
});
//--></script>

<?php echo get_footer(); ?>