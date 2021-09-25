<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#addresses" data-toggle="tab"><?php echo lang('text_tab_address'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-first-name" class="col-sm-3 control-label"><?php echo lang('label_first_name'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="first_name" id="input-first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
							<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-last-name" class="col-sm-3 control-label"><?php echo lang('label_last_name'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="last_name" id="input-last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
							<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-3 control-label"><?php echo lang('label_email'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="email" id="input-email" class="form-control" value="<?php echo set_value('email', $email); ?>" />
							<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>	

					<!--<div class="form-group">
						<label for="input-currency" class="col-sm-3 control-label"><?php echo lang('label_currency'); ?></label>
						<div class="col-sm-5">
							<select name="currency" id="input-currency" class="form-control">
								<option value="">— Select —</option>
								<?php foreach ($currencies as $currenci) { ?>
									<?php if ($currenci['currency_id'] === $currency) { ?>
										<option value="<?php echo $currenci['currency_id']; ?>" selected="selected"><?php echo $currenci['currency_name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $currenci['currency_id']; ?>"><?php echo $currenci['currency_name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('input-currency', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<div class="form-group">
						<label for="input-language" class="col-sm-3 control-label"><?php echo lang('label_currency'); ?></label>
						<div class="col-sm-5">
							<select name="language" id="input-language" class="form-control">
								<option value="">— Select —</option>
								<?php foreach ($languages as $lang) { ?>
									<?php if ($lang['language_id'] === $lang) { ?>
										<option value="<?php echo $lang['language_id']; ?>" selected="selected"><?php echo $lang['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $currenci['currency_id']; ?>"><?php echo $currenci['currency_name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('input-currency', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>-->

					<div class="form-group">
						<label for="input-telephone" class="col-sm-3 control-label"><?php echo lang('label_telephone'); ?><span style="color:red">*</span></label>
						<div class="col-sm-2">
						<select class="form-control" name="country_code">
							<?php foreach($phone_code as $pcode){?>
                                <option data-countryCode="<?php echo $pcode->code;?>" value="<?php echo $pcode->dial_code;?>"<?php if($telephone[0] == $pcode->dial_code) {echo ' selected';} else if($pcode->code == $default_country_code && $telephone[0] == '') {echo ' selected';}?>><?php echo $pcode->code.' ('.$pcode->dial_code.')';?></option>
                            <?php }?>
							</select>
							</div>
							<div class="col-sm-3">
							<input type="text" name="telephone" id="input-telephone" class="form-control" value="<?php echo set_value('telephone', $telephone[1]); ?>" maxlength="20<?php //echo $this->config->item('digits_mobile');?>" />
							<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password" class="col-sm-3 control-label"><?php echo lang('label_password'); ?><?php if($this->input->get('id') == '') { ?><span style="color:red">*</span><?php } ?>
							<span class="help-block"><?php echo lang('help_password'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="password" name="password" id="input-password" class="form-control" value="<?php echo set_value('password'); ?>" autocomplete="off" />
							<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-confirm-password" class="col-sm-3 control-label"><?php echo lang('label_confirm_password'); ?></label>
						<div class="col-sm-5">
							<input type="password" name="confirm_password" id="input-confirm-password" class="form-control" value="" />
							<?php echo form_error('confirm_password', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-security-question" class="col-sm-3 control-label"><?php echo lang('label_security_question'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<select name="security_question_id" id="input-security-question" class="form-control">
								<option value="" <?php echo set_select('security_question_id', '' ,true); ?>>— Select —</option>
								<?php foreach ($questions as $question) { ?>
									<?php if ($question['id'] === $security_question) { ?>
										<option value="<?php echo $question['id']; ?>" <?php echo set_select('security_question_id', $question['id'] ,true); ?>><?php echo $question['text']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $question['id']; ?>" <?php echo set_select('security_question_id', $question['id']); ?>><?php echo $question['text']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('security_question_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-security-answer" class="col-sm-3 control-label"><?php echo lang('label_security_answer'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="security_answer" id="input-security-answer" class="form-control" value="<?php echo set_value('security_answer', $security_answer); ?>" />
							<?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-customer-group-id" class="col-sm-3 control-label"><?php echo lang('label_customer_group'); ?></label>
						<div class="col-sm-5">
							<select name="customer_group_id" id="input-customer-group-id" class="form-control">
							<?php foreach ($customer_groups as $customer_group) { ?>
								<?php if ($customer_group['customer_group_id'] === $customer_group_id) { ?>
									<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id'], TRUE); ?> ><?php echo $customer_group['group_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id']); ?> ><?php echo $customer_group['group_name']; ?></option>
								<?php } ?>
							<?php } ?>
							</select>
							<?php echo form_error('customer_group_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-newsletter" class="col-sm-3 control-label"><?php echo lang('label_newsletter'); ?></label>
						<div class="col-sm-5">
							<div id="input-newsletter" class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($newsletter == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="newsletter" value="0" <?php echo set_radio('newsletter', '0'); ?>><?php echo lang('text_un_subscribe'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="newsletter" value="1" <?php echo set_radio('newsletter', '1', TRUE); ?>><?php echo lang('text_subscribe'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="newsletter" value="0" <?php echo set_radio('newsletter', '0', TRUE); ?>><?php echo lang('text_un_subscribe'); ?></label>
									<label class="btn btn-success"><input type="radio" name="newsletter" value="1" <?php echo set_radio('newsletter', '1'); ?>><?php echo lang('text_subscribe'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('newsletter', '<span class="text-danger">', '</span>'); ?>
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
					<?php 
					if($first_name)
					{
					?>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_vip'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($vip_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="vip_status" value="0" <?php echo set_radio('vip_status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="vip_status" value="1" <?php echo set_radio('vip_status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="vip_status" value="0" <?php echo set_radio('vip_status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="vip_status" value="1" <?php echo set_radio('vip_status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('vip_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<?php } ?>
				</div>

				<div id="addresses" class="tab-pane row wrap-all">
					<ul id="sub-tabs" class="nav nav-tabs">
						<?php $table_row = 1; ?>
						<?php foreach ($addresses as $address) { ?>
							<li><a href="#address<?php echo $table_row; ?>" data-toggle="tab"><?php echo lang('text_tab_address'); ?> <?php echo $table_row; ?>&nbsp;&nbsp;<i class="fa fa-times-circle" onclick="if (confirm('<?php echo lang('alert_warning_confirm'); ?>')) { $('#sub-tabs a[rel=#address1]').trigger('click'); $('#address<?php echo $table_row; ?>').remove(); $(this).parent().parent().remove(); return false; } else { return false;}"></i></a></li>
							<?php $table_row++; ?>
						<?php } ?>
						<li class="add_address"><a onclick="addAddress();"><i class="fa fa-book"></i>&nbsp;<i class="fa fa-plus"></i></a></li>
					</ul>

					<div id="new-address" class="tab-content">
					<?php $table_row = 1; ?>
					<?php if ($addresses) { ?>
						<?php foreach ($addresses as $address) { 
							?>
						<div id="address<?php echo $table_row; ?>" class="tab-pane row wrap-all">
							<input type="hidden" name="address[<?php echo $table_row; ?>][address_id]" id="address_id_<?php echo $table_row; ?>" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_id]', $address['address_id']); ?>" />
							<div class="form-group">
								<label for="" class="col-sm-3 control-label"><?php echo lang('label_address_1'); ?><span style="color:red">*</span></label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][address_1]" id="address_1_<?php echo $table_row; ?>" class="form-control addresses" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_1]', $address['address_1']); ?>" />
									<?php echo form_error('address['.$table_row.'][address_1]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-3 control-label"><?php echo lang('label_address_2'); ?></label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][address_2]" id="address_2_<?php echo $table_row; ?>" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_2]', $address['address_2']); ?>" />
									<?php echo form_error('address['.$table_row.'][address_2]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-3 control-label"><?php echo lang('label_city'); ?><span style="color:red">*</span></label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][city]" id="city_<?php echo $table_row; ?>" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][city]', $address['city']); ?>" />
									<?php echo form_error('address['.$table_row.'][city]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-3 control-label"><?php echo lang('label_state'); ?></label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][state]" id="state_<?php echo $table_row; ?>" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][state]', $address['state']); ?>" />
									<?php echo form_error('address['.$table_row.'][state]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-3 control-label"><?php echo lang('label_postcode'); ?></label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][postcode]" id="postcode_<?php echo $table_row; ?>" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][postcode]', $address['postcode']); ?>" />
									<?php echo form_error('address['.$table_row.'][postcode]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-3 control-label"><?php echo lang('label_country'); ?></label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][country_id]" id="country_id_<?php echo $table_row; ?>" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][country_id]', $address['country_id']); ?>" />
									
									<?php echo form_error('address['.$table_row.'][country_id]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-3 control-label">Address Specification</label>
								<div class="col-sm-5">
									<select class="form-control" name="address[<?php echo $table_row; ?>][specification]">
										<option value="home" <?php if($address['specification'] == 'home'){ echo "selected='selected'"; } ?> >Home</option>
										<option value="office" <?php if($address['specification'] == 'office'){ echo "selected='selected'"; } ?> >Office</option>
										<option value="others" <?php if($address['specification'] == 'others'){ echo "selected='selected'"; } ?> >Others</option>
									</select>
								</div>
							</div>

							<!--<div class="form-group">
								<label for="" class="col-sm-3 control-label">Default Address</label>
								<div class="col-sm-6">
									<?php if($address['default_address'] == 'on'){ ?>
									This is your Default Address
								<?php }else{ ?>
									<input type="radio" name="address[<?php echo $table_row; ?>][default_address]" >
								<?php } ?>
								</div>
							</div>-->
						</div>

						<?php $table_row++; ?>
						<?php } ?>
					<?php } ?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script src='https://maps.googleapis.com/maps/api/js?key="<?php echo $this->config->item('maps_api_key')?>"&libraries=places&callback=initAutocomplete' async defer></script>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;
function addAddress() {
	html  = '<div id="address' + table_row + '" class="tab-pane row wrap-all">';
	html += '<input type="hidden" name="address[' + table_row + '][address_id]" id="address_id_'+table_row+'" class="form-control" value="<?php echo set_value("address[' + table_row + '][address_id]"); ?>" />';
	html += '<input type="hidden" name="address[' + table_row + '][latitude]" id="latitude_'+table_row+'" class="form-control" value="<?php echo set_value("address[' + table_row + '][latitude]"); ?>" />';
	html += '<input type="hidden" name="address[' + table_row + '][longitude]" id="longitude_'+table_row+'" class="form-control" value="<?php echo set_value("address[' + table_row + '][longitude]"); ?>" />';
	html += '<div class="form-group">';
	html += '	<label for="" class="col-sm-3 control-label"><?php echo lang('label_address_1'); ?><span style="color:red">*</span></label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][address_1]" id="address_1_'+table_row+'" class="form-control addresses" value="<?php echo set_value("address[' + table_row + '][address_1]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="" class="col-sm-3 control-label"><?php echo lang('label_address_2'); ?></label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][address_2]" id="address_2_'+table_row+'" class="form-control" value="<?php echo set_value("address[' + table_row + '][address_2]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="" class="col-sm-3 control-label"><?php echo lang('label_city'); ?><span style="color:red">*</span></label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][city]" id="city_'+table_row+'" class="form-control" value="<?php echo set_value("address[' + table_row + '][city]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="" class="col-sm-3 control-label"><?php echo lang('label_state'); ?></label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][state]" id="state_'+table_row+'" class="form-control" value="<?php echo set_value("address[' + table_row + '][state]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="" class="col-sm-3 control-label"><?php echo lang('label_postcode'); ?></label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][postcode]" id="postcode_'+table_row+'" class="form-control" value="<?php echo set_value("address[' + table_row + '][postcode]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="" class="col-sm-3 control-label"><?php echo lang('label_country'); ?></label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][country_id]" id="country_id_'+table_row+'" class="form-control">';				
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label for="" class="col-sm-3 control-label">Address Specification</label>';
	html += '<div class="col-sm-5">';
	html += '<select class="form-control" name="address[' + table_row + '][specification]" id="specification_'+table_row+'">';
	html += '<option value="home" >Home</option>';
	html += '<option value="office">Office</option>';
	html += '<option value="others">Others</option>';
	html += '</select>';
	html += '</div>';
	html += '</div>';
	html += '</div>';

	$('#new-address').append(html);

	$('.add_address').before('<li><a href="#address' + table_row + '" data-toggle="tab"><?php echo lang('text_tab_address'); ?> ' + table_row + '&nbsp;&nbsp;<i class="fa fa-times-circle" onclick="if (confirm(\'<?php echo lang('alert_warning_confirm'); ?>\')){ $(\'#sub-tabs a[rel=#address1]\').trigger(\'click\'); $(\'#address' + table_row + '\').remove(); $(this).parent().parent().remove(); return false } else { return false;}"></i></a></li>');

	$('#sub-tabs a[href="#address' + table_row + '"]').tab('show');
	$('select.form-control').select2();
	id="address_1_"+table_row;
	initAutocomplete(id,table_row);
	table_row++;
}

$('#sub-tabs a:first').tab('show');

$(document).on('click', '.addresses', function(){
	var id = $(this).attr('id');
	var i = id.slice(-1);
    initAutocomplete(id,i);
});
function initAutocomplete(id,i) {
	var placeSearch, autocomplete;
  	var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
  	};
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    var autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById(id)),
        {types: ['address']}
    );
    autocomplete.addListener('place_changed', function() {

    var place = autocomplete.getPlace();
    document.getElementById('city_'+i).value=place.address_components[1].long_name;
    var postal_code = place.address_components.find(item => item.types.includes('postal_code'));
    var country = place.address_components.find(item => item.types.includes('country'));
    document.getElementById('country_id_'+i).value=  country.long_name;
    document.getElementById('postcode_'+i).value=  postal_code.long_name;
	document.getElementById('state_'+i).value=place.address_components[2].long_name;
	document.getElementById('latitude_'+i).value=place.geometry.location.lat();
	document.getElementById('longitude_'+i).value=place.geometry.location.lng();
	});

}
//--></script>
<?php echo get_footer(); ?>