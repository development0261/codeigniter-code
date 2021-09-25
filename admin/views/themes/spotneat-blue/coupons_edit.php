<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#coupon-history" data-toggle="tab"><?php echo lang('text_tab_history'); ?></a></li>
			</ul>
		</div>
		
		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Choose Location<span style="color:red">*</span></label>
						<div class="col-sm-5">
							<select name="location_id" id="location_id" class="form-control" <?php echo !empty($session_location_id)?'disabled':''; ?>>
                                <?php foreach ($locations as $location) { 
									?>
                                    <?php if ($location_id === $location['location_id']) { ?>
                                        <option value="<?php echo $location['location_id']; ?>" <?php echo set_select('location_id', $location_id, TRUE); ?> ><?php echo $location['location_name']; ?></option>
                                    <?php } else if ($session_location_id === $location['location_id']) { ?>
                                        <option value="<?php echo $location['location_id']; ?>" <?php echo set_select('location_id', $session_location_id, TRUE); ?> ><?php echo $location['location_name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $location['location_id']; ?>" <?php echo set_select('location_id', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>

							<?php
							if(!empty($session_location_id)){
							?>			
							<input type="hidden" name="location_id_staff" value="<?php echo set_value('location_id_staff', $session_location_id); ?>" />
							<?php
							}
							?>

						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
							<input type="hidden" name="added_by" id="added_by" class="form-control" value="<?php echo set_value('added_by', $added_by); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label"><?php echo lang('label_code'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="code" id="input-code" class="form-control" value="<?php echo set_value('code', $code); ?>" />
							<?php echo form_error('code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-type" class="col-sm-3 control-label"><?php echo lang('label_type'); ?>
							<span class="help-block"><?php echo lang('help_type'); ?></span>
						</label>
						<div class="col-sm-5">
								<select name="type" id="type" class="form-control">
									<option value="P" <?php echo $type == 'P' ? 'selected':''; ?>>Percentage</option>
									<option value="F" <?php echo $type == 'F' ? 'selected':''; ?>>Fixed</option>
									<option value="FD" <?php echo $type == 'FD' ? 'selected':''; ?>>Only first Order Discount</option>
								</select>
							<?php echo form_error('type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group" id="first_order_discount_type" <?php echo $type == 'FD' ? '':'style="display:none;"'; ?> >
						<label for="input-type" class="col-sm-3 control-label">First order Discount Type(FD Type)
						</label>
						<div class="col-sm-5">
								<select name="is_fd_type_percent" id="is_fd_type_percent" class="form-control">
									<option value="1" <?php echo $is_fd_type_percent == '1' ? 'selected':''; ?>>FD Type: Percentage</option>
									<option value="0" <?php echo $is_fd_type_percent == '0' ? 'selected':''; ?>>FD Type: Fixed</option>
								</select>
							<?php echo form_error('type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-discount" class="col-sm-3 control-label"><?php echo lang('label_discount'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="discount" id="input-discount" class="form-control" value="<?php echo set_value('discount', $discount); ?>" />
								<span id="discount-addon" class="input-group-addon"><?php echo lang('text_leading_zeros'); ?></span>
							</div>
							<?php echo form_error('discount', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-min-total" class="col-sm-3 control-label"><?php echo lang('label_min_total'); ?></label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="min_total" id="input-min-total" class="form-control" value="<?php echo set_value('min_total', $min_total); ?>" />
								<span class="input-group-addon"><?php echo lang('text_leading_zeros'); ?></span>
							</div>
							<?php echo form_error('min_total', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-min-total" class="col-sm-3 control-label"><?php echo lang('label_date'); ?></label>
						<div class="col-sm-5">
								<div class="">
									<div class="input-group date wrap-bottom">
										<span class="input-group-addon"><b><?php echo lang('label_period_start_date'); ?></b></span>
										<input type="text" name="period_start_date" id="period-start-date" class="form-control" value="<?php echo set_value('period_start_date', $period_start_date); ?>" />
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
									<div class="input-group date wrap-bottom">
										<span class="input-group-addon"><b><?php echo lang('label_period_end_date'); ?></b></span>
										<input type="text" name="period_end_date" id="period-end-date" class="form-control" value="<?php echo set_value('period_end_date', $period_end_date); ?>" />
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
								<?php echo form_error('validity_times[period_start_date]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('validity_times[period_end_date]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-type" class="col-sm-3 control-label">Coupon Access Level</label>
						<div class="col-sm-5">
								<select name="is_public_access" id="is_public_access" class="form-control">
									<option value="1" <?php echo $is_public_access == '1' ? 'selected':''; ?>>Public</option>
									<option value="0" <?php echo $is_public_access == '0' ? 'selected':''; ?>>Private</option>
								</select>
							<?php echo form_error('is_public_access', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
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

				<div id="coupon-history" class="tab-pane row wrap-left wrap-right">
                    <div class="table-responsive">
                        <table height="auto" class="table table-striped table-border" id="history">
                            <thead>
                                <tr>
                                    <th class=""><?php echo lang('column_order_id'); ?></th>
                                    <th width="55%"><?php echo lang('column_customer'); ?></th>
                                    <th class="text-center"><?php echo lang('column_amount'); ?></th>
                                    <th class="text-center"><?php echo lang('column_date_used'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($coupon_histories) { ?>
                                <?php foreach ($coupon_histories as $history) { ?>
                                <tr>
                                    <td class=""><a href="<?php echo $history['view']; ?>"><?php echo $history['order_id']; ?></a></td>
                                    <td><?php echo $history['customer_name']; ?></td>
                                    <td class="text-center"><?php echo $history['amount']; ?></td>
                                    <td class="text-center"><?php echo $history['date_used']; ?></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td colspan="6"><?php echo lang('text_no_history'); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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

	$('#type').on('change', function() {
		if(this.value == 'FD'){
			$('#first_order_discount_type').css('display', 'block');
		} else {
			$('#first_order_discount_type').css('display', 'none');
		}
	});
});
//--></script>
<?php echo get_footer(); ?>