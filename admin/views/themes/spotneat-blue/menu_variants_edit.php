<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Variant Name</a></li>
				<li><a href="#values" data-toggle="tab">Variant Values</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Variant Name<span style="color:red">*</span> </label>
						<div class="col-sm-5">
							<input type="text" name="variant_name" id="input-name" class="form-control" value="<?php echo set_value('variant_name', $variant_name); ?>" placeholder="Enter variant name" />
							<input type="hidden" name="added_by" id="added_by" class="form-control" value="<?php echo set_value('added_by', $added_by); ?>" />
							<?php echo form_error('variant_name', '<span class="text-danger">', '</span>'); ?>

							<input type="hidden" name="method" id="method"  value="<?php echo $method; ?>" />
							<input type="hidden" name="menu_id" id="menu_id"  value="<?php echo $menu_id; ?>" />
							<input type="hidden" name="vendor_id" id="vendor_id"  value="<?php echo $vendor_id; ?>" />
							<input type="hidden" name="location_id" id="location_id"  value="<?php echo $location_id; ?>" />
							<input type="hidden" name="variant_type_id" id="variant_type_id"  value="<?php echo $variant_type_id; ?>" />
							<input type="hidden" name="variant_type_value_id" id="variant_type_value_id"  value="<?php echo $variant_type_value_id; ?>" />
						</div>
					</div>
				</div>

				<div id="values" class="tab-pane row wrap-all">
					<div class="panel panel-default panel-table">
						<div class="table-responsive">
							<table class="table table-striped table-border table-sortable">
								<thead>
									<tr>
										<th>Variant Value</th>
										<th>Price</th>										
										<th>Is Default?</th>
										<th>Enable[1]/Disable[0]</th>
									</tr>
								</thead>
								<tbody>
									<?php $table_row = 1; ?>
									<?php foreach ($values as $value) { ?>
										<tr id="table-row<?php echo $table_row; ?>">

											<?php if($method == 'Add') { ?>
											<td class="action action-one"><a class="btn btn-danger" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>
											<?php } ?>

											<td>
												<input type="text" name="variant_values[<?php echo $table_row; ?>][value]" class="form-control" value="<?php echo set_value('variant_values[$table_row][value]', $value['value']); ?>" placeholder="Enter variant value" />
												<?php echo form_error('variant_values['.$table_row.'][value]', '<span class="text-danger">', '</span>'); ?>
											</td>
											<td>
												<input type="text" name="variant_values[<?php echo $table_row; ?>][price]" class="form-control" value="<?php echo set_value('variant_values[$table_row][price]', $value['price']); ?>" placeholder="Enter variant price" />
												<?php echo form_error('variant_values['.$table_row.'][price]', '<span class="text-danger">', '</span>'); ?>	
											</td>											
											<td>
												<input type="text" name="variant_values[<?php echo $table_row; ?>][is_default]" class="form-control" value="<?php echo set_value('variant_values[$table_row][is_default]', $value['is_default']); ?>" placeholder="Is default? [0/1]" />
												<?php echo form_error('variant_values['.$table_row.'][is_default]', '<span class="text-danger">', '</span>'); ?>	
											</td>
											<td>
												<input type="text" name="variant_values[<?php echo $table_row; ?>][status]" class="form-control" value="<?php echo set_value('variant_values[$table_row][status]', $value['status']); ?>" placeholder="Enter variant Enable/Disable[1/0]" />
												<?php echo form_error('variant_values['.$table_row.'][status]', '<span class="text-danger">', '</span>'); ?>	
											</td>
										</tr>
									<?php $table_row++; ?>
									<?php } ?>
								</tbody>
								<?php if($method == 'Add') { ?>
								<tfoot>
									<tr id="tfoot">
										<td class="action action-one" colspan="5"><a class="btn btn-primary btn-lg" onclick="addValue();"><i class="fa fa-plus"></i></a></td>
									</tr>
								</tfoot>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addValue() {
	html  = '<tr id="table-row' + table_row + '">';    
	html += '	<td>';
	html += '		<input type="text" name="variant_values[' + table_row + '][value]" class="form-control" value="<?php echo set_value("variant_values[' + table_row + '][value]"); ?>" placeholder="Enter variant value" />';
	html += '	</td>';
	html += '	<td><input type="text" name="variant_values[' + table_row + '][price]" class="form-control" value="<?php echo set_value("variant_values[' + table_row + '][price]"); ?>" placeholder="Enter variant price" /></td>';
	html += '	<td>';
	html += '		<input type="text" name="variant_values[' + table_row + '][is_default]" class="form-control" value="<?php echo set_value("variant_values[' + table_row + '][is_default]"); ?>" placeholder="Is default? [0/1]" />';
	html += '	</td>';
	html += '	<td>';
	html += '		<input type="text" name="variant_values[' + table_row + '][status]" class="form-control" value="<?php echo set_value("variant_values[' + table_row + '][status]"); ?>" placeholder="Enter variant Enable/Disable[1/0]" />';
	html += '	</td>';
	html += '</tr>';

	$('.table-sortable tbody').append(html);

	table_row++;
}
//--></script>
<script type="text/javascript"><!--
$(function () {
	$('.table-sortable').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="3"></td></tr>',
		handle: '.handle'
	})
});
//--></script>
<?php echo get_footer(); ?>