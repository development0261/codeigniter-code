<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#table-details" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="table-details" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?> <span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="table_name" id="input-name" class="form-control" value="<?php echo set_value('table_name', $table_name); ?>" />
							<input type="hidden" name="added_by" id="added_by" class="form-control" value="<?php echo set_value('added_by', $added_by); ?>" />
							<?php echo form_error('table_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-min-capacity" class="col-sm-3 control-label"><?php echo lang('label_min_capacity'); ?> <span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="min_capacity" id="input-min-capacity" class="form-control" value="<?php echo set_value('min_capacity', $min_capacity); ?>" />
							<?php echo form_error('min_capacity', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-max-capacity" class="col-sm-3 control-label"><?php echo lang('label_capacity'); ?> <span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="max_capacity" id="input-max-capacity" class="form-control" value="<?php echo set_value('max_capacity', $max_capacity); ?>" />
							<?php echo form_error('max_capacity', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!--<div class="form-group">
						<label for="input-additional-charge" class="col-sm-3 control-label"><?php echo lang('label_additional_charge'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="additional_charge" id="input-additional-charge" class="form-control" value="<?php echo set_value('additional_charge', $additional_charge); ?>" />
							<?php echo form_error('additional_charge', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-total-price" class="col-sm-3 control-label"><?php echo lang('label_total_price'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="total_price" id="input-total-price" class="form-control" value="<?php echo set_value('total_price', $total_price); ?>" />
							<?php echo form_error('total_price', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>-->
					<div class="form-group">
                        <label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_location'); ?></label>
                        <div class="col-sm-5">
                            <select name="location_id" id="location_id" class="form-control">
                               <!--  <option value=""><?php echo lang('text_select_restaurant'); ?></option> -->
                                <?php foreach ($locations as $location) { ?>
                                    <?php if ($location_id === $location['location_id']) { ?>
                                        <option value="<?php echo $location['location_id']; ?>" <?php echo set_select('location_id', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $location['location_id']; ?>" <?php echo set_select('location_id', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('location_id', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($table_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="table_status" value="0" <?php echo set_radio('table_status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="table_status" value="1" <?php echo set_radio('table_status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="table_status" value="0" <?php echo set_radio('table_status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="table_status" value="1" <?php echo set_radio('table_status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('table_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>