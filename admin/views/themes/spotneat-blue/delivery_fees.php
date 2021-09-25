<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_delivery_fee'); ?></a></li>
			</ul>
		</div>
 
		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					
					<div class="form-group">
						<label for="input-standard-delivery" class="col-sm-3 control-label"><?php echo lang('label_standard_fee'); ?></label>
						<div class="col-sm-5">

							<input type="text" name="standard_fee" id="standard-fee" class="form-control" value="<?php echo set_value('standard_fee', $standard_fee); ?>" />
							<?php echo form_error('standard_fee', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-premium-delivery" class="col-sm-3 control-label"><?php echo lang('label_premium_fee'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="premium_fee" id="premium-fee" class="form-control" value="<?php echo set_value('premium_fee', $premium_fee); ?>" />
							<?php echo form_error('premium_fee', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

			</div>
		</form>
	</div>
</div>

<?php echo get_footer(); ?>