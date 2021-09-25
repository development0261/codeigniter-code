<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
<?php if ($this->alert->get()) {?>
    <div id="notification">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->alert->display(); ?>
                </div>
            </div>
        </div>
    </div>
<?php }?>
</div>
<div id="page-content" style="background-color: #fdcec0 !important;">
	<div class="container">
	<div class="col-md-12 col-sm-12 col-xs-12 content_bacg after-log-top-space" >

		<div class="row top-spacing">
			<?php echo get_partial('content_left'); ?>
			<?php
if (partial_exists('content_left') AND partial_exists('content_right')) {
	$class = "col-sm-6 col-md-6 col-xs-12";
} else if (partial_exists('content_left') OR partial_exists('content_right')) {
	$class = "col-sm-12 col-md-12 col-xs-12";
} else {
	$class = "col-md-12 col-xs-3 col-sm-12";
}
?>
			<div class="col-md-9 col-sm-9 col-xs-12 no-pad">
			<div class=" <?php echo $class; ?>" style="border: 1px solid #ddd !important;">
				<div class="row">
				<div class="tab-content col-md-12 col-sm-12 col-xs-12">
				<div class="row top-spacing-20">
                                <div class="col-xs-12 col-md-12 col-sm-12 ">
                                    <h4><?php echo lang('text_my_account'); ?></h4>
                                    <hr><br />
							    </div>
							</div>
					<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" enctype="multipart/form-data" role="form">
						<div class="col-md-12">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" id="first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" name="first_name" placeholder="<?php echo lang('label_first_name'); ?>">
										<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" id="last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" name="last_name" placeholder="<?php echo lang('label_last_name'); ?>">
										<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
							</div>
                            <div class="row">

                                <div class="col-xs-12 col-sm-3 col-md-2">
                                	<div class="form-group">
							<select class="class-select2" name="country_code">
							  <?php foreach ($phone_code as $pcode) {?>
                                <option data-countryCode="<?php echo $pcode->code; ?>" value="<?php echo $pcode->dial_code; ?>"<?php if ($telephone[0] == $pcode->dial_code) {echo ' selected';} else if ($pcode->dial_code == '+91' && $telephone[0] == '') {echo ' selected';}?>><?php echo $pcode->code . ' (' . $pcode->dial_code . ')'; ?></option>
                            <?php }?>
							</select>
							</div>
							</div>
							<div class="col-xs-12 col-sm-3 col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="telephone" class="form-control" value="<?php echo set_value('telephone', $telephone[1]); ?>" name="telephone" placeholder="<?php echo lang('label_telephone'); ?>" minlegth="<?php echo $this->config->item('digits_mobile'); ?>" maxlength="<?php echo $this->config->item('digits_mobile'); ?>">
                                        <?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="email" class="form-control" value="<?php echo set_value('email', $email); ?>" name="email" placeholder="<?php echo lang('label_email'); ?>" disabled>
                                        <?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
							</div>
                            <!-- <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <select name="security_question_id" id="security-question" class="class-select2" placeholder="<?php echo lang('label_s_question'); ?>">
                                            <?php foreach ($questions as $question) {?>
                                                <?php if ($question['question_id'] === $security_question) {?>
                                                    <option value="<?php echo $question['question_id']; ?>" selected="selected"><?php echo lang_trans($question['text'], $question['text_ar']); ?></option>
                                                <?php } else {?>
                                                    <option value="<?php echo $question['question_id']; ?>"><?php echo lang_trans($question['text'], $question['text_ar']); ?></option>
                                                <?php }?>
                                            <?php }?>
                                        </select>
                                        <?php echo form_error('security_question_id', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="security-answer" class="form-control" name="security_answer" value="<?php echo set_value('security_answer', $security_answer); ?>" placeholder="<?php echo lang('label_s_answer'); ?>">
                                        <?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
                                   </div>
                                </div>
                            </div> -->
                           <?php /*  <div class="row">
<div class="col-xs-9 col-sm-10 col-md-10">
<span class="button-checkbox">
<button type="button" class="btn" data-color="info" tabindex="7">&nbsp;&nbsp;<?php echo lang('button_subscribe'); ?></button>
<?php if ($newsletter === '1') { ?>
<input type="checkbox" name="newsletter" id="newsletter" class="hidden" value="1" <?php echo set_checkbox('newsletter', '1', TRUE); ?>>
<?php } else { ?>
<input type="checkbox" name="newsletter" id="newsletter" class="hidden" value="1" <?php echo set_checkbox('newsletter', '1'); ?>>
<?php } ?>
</span>
<label for="newsletter" class="control-label text-muted"><?php echo lang('label_newsletter'); ?></label>
</div>
<?php echo form_error('newsletter', '<span class="text-danger">', '</span>'); ?>
</div> */?>

							<!-- <div class="row top-spacing-20">
                                <div class="col-xs-12">
                                    <h4><?php echo lang('profile_image'); ?></h4>
                                    <hr><br />
							    </div>
							</div>

							 	<div class="col-xs-12 col-sm-6 col-md-6 padd-none">
							 	<div class="form-group">
								<input type="file" name="profile_image" id="profile_image" class="form-control" />								<span><?php echo lang('best_dimension'); ?> 200px * 200px</span>
								</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<div class="profile_image">
									<?php if ($profile_image != '') {
	?> <img src="<?php echo site_url() . 'assets/images/' . $profile_image; ?>" width="190" height="190" ><?php } else {?>
										<img src="<?php echo site_url() . 'assets/images/profile_images/no-pic.png'; ?>" width="190" height="190" >
										<?php }?>

									</div>
								</div>
								</div> -->


							<div class="row top-spacing-20">
                                <div class="col-xs-12">
                                    <h4><?php echo lang('text_password_heading'); ?></h4>
                                    <hr><br />
							    </div>
							</div>

							<div class="form-group">
								<input type="password" name="old_password" id="old-password" class="form-control" value="" placeholder="<?php echo lang('label_old_password'); ?>" />
								<?php echo form_error('old_password', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="password" id="new-password" class="form-control" value="" name="new_password" placeholder="<?php echo lang('label_password'); ?>">
										<?php echo form_error('new_password', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="password" id="cnew-password" class="form-control" name="confirm_new_password" value="" placeholder="<?php echo lang('label_password_confirm'); ?>">
										<?php echo form_error('confirm_new_password', '<span class="text-danger">', '</span>'); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<br />
							<div class="buttons text-center">
								<!-- <a  href="<?php echo $back_url; ?>" style="float: right;"><b><?php //echo lang('button_back'); ?></b></a> -->
								<button type="submit" class="btn btn-primary btn-sm"><?php echo lang('button_save'); ?></button>
							</div>
							<br />
							<br /><br />
						</div>
					</form>
					</div>
				</div>
			</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>