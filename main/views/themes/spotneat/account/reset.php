<?php echo get_header(); ?>

<div id="page-content" style="background-color: #fdcec0 !important; padding:81px 0px;">
	<div class="container">		

		<div class="row  col-md-12 col-sm-12 col-xs-12">
		
			
		<div class="col-md-12 col-sm-12 col-xs-12 padd-none text-center top-20">	
			<div class="col-md-4 col-sm-2 col-xs-12 padd-none"></div>
			<div class=" col-md-4 col-sm-8 col-xs-12  content-wrap center-block">
				<div class="content-wrap heading-section">
					<h2 style="color: #f5511e;"><?php echo lang('text_heading'); ?></h3>
					<span class="under-heading"></span>
				</div>
				<?php if ($this->alert->get('', 'alert')) { ?>
					<div id="notification">
						<?php echo $this->alert->display('', 'alert'); ?>
					</div>
				<?php } ?>

				<p class="text-center"><?php echo lang('text_summary'); ?></p>
				<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
					<div class="form-group">
						<input name="email" type="text" id="email" class="form-control input-lg" value="<?php echo set_value('email'); ?>" placeholder="<?php echo lang('label_email'); ?>" />
		    			<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?></td>
					</div>
					<!-- <div class="form-group">
						<select name="security_question" id="security-question" class="class-select2" style="font-size:18px;">
						<option value="">Select Your Secret Question</option>	
						<?php foreach ($questions as $question) { ?>
                                <option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
                            <?php } ?>
						</select>
						<?php echo form_error('security_question', '<span class="text-danger">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label for="security-answer"></label>
						<input type="text" name="security_answer" id="security-answer" class="form-control input-lg" placeholder="<?php echo lang('label_s_answer'); ?>" />
						<?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
					</div> -->
					<br />

					<div class="row text-center">
						<div class="col-xs-12 col-md-12 col-sm-12">
							<button type="submit" class="btn btn-primary btn-md btn-block"><?php echo lang('button_reset'); ?></button>
						</div>
						<div class="col-xs-12 col-md-12 col-sm-12">
							<a href="<?php echo $login_url; ?>" style="text-align: right; color: #f5511e !important;"><?php echo lang('button_login'); ?></a>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-4 col-sm-2 col-xs-12 padd-none"></div>
		</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>