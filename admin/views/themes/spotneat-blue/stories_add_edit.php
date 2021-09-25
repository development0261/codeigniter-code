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
				<li class="active"><a href="#story-group" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<!-- <li><a href="#permission-level" data-toggle="tab"><?php echo lang('text_tab_permission'); ?></a></li> -->
				<?php if ($display_story_settings && (($story_added_by && $story_added_by==$this->session->user_info['user_id']) || $story_added_by=='' || $this->session->user_info['staff_group_id']==11 )) {  ?>
				<li><a href="#story_settings" data-toggle="tab"><?php echo lang('text_basic_settings'); ?></a></li>
				<?php } ?>
			</ul>
		</div>
			<?php echo form_open_multipart($_action,'id="edit-form" class="form-horizontal" role="form"')  ?>
			<div class="tab-content">
				<div id="story-group" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_title'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?>
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
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_story_content'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<textarea name="content" id="content" cols="30" rows="10" class="form-control"><?php echo set_value('content', $content); ?></textarea>
							
							<?php echo form_error('content', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<!-- <label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_stories_images'); ?><span style="color:red">*</span></label> -->

						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_stories_images'); ?>
						<span style="color:red">*</span>
							<span class="help-block"><?php echo lang('help_stories_images'); ?></span>
						</label>

						<div class="col-sm-5">
							<input type="file" name="story_image" id="story_image">
							<?php echo form_error('story_image', '<span class="text-danger">', '</span>'); ?>
						</div>
						
					</div>
					<div class="form-group">
					<label for="input-status" class="col-sm-3 control-label"></label>
					<div class="col-sm-5">
							<img src="<?php echo base_url($story_image); ?>" alt="" width="425px" height="300px;">
						</div>
					</div>
					
				</div>
				<div id="story_settings" class="tab-pane row wrap-all">
					<?php if (	$display_story_settings && 
								($this->session->user_info['staff_group_id']==11 || 
								($story_added_by && $story_added_by==$this->session->user_info['user_id']) ||
								$story_added_by=='')) { ?>
						

						<div class="form-group">
							<label for="input-location" class="col-sm-3 control-label"><?php echo lang('label_location'); ?></label>
							<div class="col-sm-5">
							<?php //echo "<pre>";print_r();  
							echo form_dropdown('staff_location_id[]',$locations ,explode(',',$story_location_id),'multiple id="input-location" class="form-control"') ?>
								<!-- <select name="staff_location_id[]" multiple id="input-location" class="form-control">
									<option value="0"><?php echo lang('text_please_select'); ?></option>
									<?php if(count($locations) >0){

										foreach ($locations as $location) { ?>
											<option value="<?php echo $location['location_id']; ?>" 
												<?php if (in_array($location['location_id'],$dat)) { 
													echo set_select('staff_location_id', $location['location_id'], TRUE); ?> >
												<?php  } else { 
													echo set_select('staff_location_id', $location['location_id']); ?> >
											<?php  } echo $location['location_name']; ?></option>
										<?php 
									}  } ?>
								</select> -->
								<?php echo form_error('staff_location_id', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					<?php } ?>
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