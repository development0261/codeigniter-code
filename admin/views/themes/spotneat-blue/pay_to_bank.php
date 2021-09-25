<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_payout'); ?></a></li>
				
			</ul>
		</div>
 
		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-first-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>
						<div class="col-sm-5">
							<input type="text" disabled name="name" id="input-first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
							<input type="hidden" name="delivery_id" class="form-control" value="<?php echo set_value('delivery_id', $delivery_id); ?>" />
							<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-3 control-label"><?php echo lang('label_amount'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="wallet" id="input-wallet" class="form-control" value="<?php echo set_value('wallet', $wallet); ?>" />
							<?php echo form_error('wallet', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>	
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>