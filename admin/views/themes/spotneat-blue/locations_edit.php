<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#data" data-toggle="tab"><?php echo lang('text_tab_data'); ?></a></li>
				<li><a href="#opening-hours" data-toggle="tab"><?php echo lang('text_tab_opening_hours'); ?></a></li>
				<li><a href="#order" data-toggle="tab"><?php echo lang('text_tab_order'); ?></a></li>
				<li><a href="#reservation" data-toggle="tab"><?php echo lang('text_tab_reservation'); ?></a></li>
				<!--<li><a id="open-map" href="#delivery" data-toggle="tab"><?php echo lang('text_tab_delivery'); ?></a></li>-->
				<li><a href="#gallery" data-toggle="tab"><?php echo lang('text_tab_gallery'); ?></a></li>
				<!--<li><a href="#reward" data-toggle="tab"><?php //echo lang('text_tab_reward'); ?></a></li>
				<li><a href="#cancel_refund" data-toggle="tab"><?php //echo lang('text_tab_cancel_refund'); ?></a></li>-->
				<li><a href="#tax_settings" data-toggle="tab"><?php echo lang('text_tab_tax_settings'); ?></a></li>
				<!-- <li><a href="#options" data-toggle="tab"><?php //echo lang('text_tab_options'); ?></a></li> 
				<li><a href="#table_settings" data-toggle="tab"><?php echo lang('text_tab_table_settings'); ?></a></li> -->
				
			</ul>
		</div>

		<form role="form" id="edit-form" name="edit_form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_basic'); ?></h4>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="location_name" id="input-name" class="form-control" value="<?php echo set_value('location_name', $location_name); ?>" required="" />
							<input type="hidden" name="added_by" id="added_by" class="form-control" value="<?php echo set_value('added_by', $added_by); ?>" />
							<?php echo form_error('location_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!-- <div class="form-group">
					<label for="input-name" class="col-sm-3 control-label"><?php //echo lang('label_name_ar'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="arabic_location_name" id="input-arabic-name" class="form-control" value="<?php //echo set_value('arabic_location_name', $location_name_ar); ?>" />
							<?php //echo form_error('location_name_ar', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>	 
					<div class="form-group">
						<label for="input-location-type" class="col-sm-3 control-label"><?php echo lang('label_type'); ?></label>
						<div class="col-sm-5">
							<select name="location_type" id="location_type" class="form-control">
								
								<option value="both" <?php if($location_type == "both"){ echo "selected"; } ?> >Both</option>
								<option value="restaurant" <?php if($location_type == "restaurant"){ echo "selected"; } ?> >Restaurant</option>
								<option value="cafe" <?php if($location_type == "cafe"){ echo "selected"; } ?> >Cafe</option>
								
							</select>
							<?php echo form_error('location_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>-->

					<div class="form-group">
						<label for="input-veg-type" class="col-sm-3 control-label">Type [Veg / Non-Veg]</label>
						<div class="col-sm-5">
							<select name="veg_type" id="veg_type" class="form-control">
								
								<option value="both" <?php if($veg_type == "both"){ echo "selected"; } ?> >Both</option>
								<option value="veg" <?php if($veg_type == "veg"){ echo "selected"; } ?> >Vegeterian</option>
								<option value="nonveg" <?php if($veg_type == "nonveg"){ echo "selected"; } ?> >Non-Vegeterian</option>
								
							</select>
							<?php echo form_error('veg_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
						<div class="form-group">
						<label for="input-location-type" class="col-sm-3 control-label"><?php echo lang('label_type'); ?></label>
						<div class="col-sm-5">
							<select name="location_type" id="location_type" class="form-control">
								
								<option value="both" <?php if($location_type == "both"){ echo "selected"; } ?> >Both</option>
								<option value="restaurant" <?php if($location_type == "restaurant"){ echo "selected"; } ?> >Restaurant</option>
								<option value="cafe" <?php if($location_type == "cafe"){ echo "selected"; } ?> >Cafe</option>
								
							</select>
							<?php echo form_error('location_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-3 control-label"><?php echo lang('label_email'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="email" id="input-email" class="form-control" value="<?php echo set_value('email', $location_email); ?>" />
							<?php 	echo form_error('email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-telephone" class="col-sm-3 control-label"><?php echo lang('label_telephone'); ?><span style="color:red">*</span></label>
						<div class="col-sm-2">
						<select class="form-control" name="country_code">
							<?php foreach($phone_code as $pcode){?>
                                <option data-countryCode="<?php echo $pcode->code;?>" value="<?php echo $pcode->dial_code;?>"<?php if($location_telephone[0] == $pcode->dial_code) {echo ' selected';} else if($pcode->code == $default_country_code && $location_telephone[0] == '') {echo ' selected';}?>><?php echo $pcode->code.' ('.$pcode->dial_code.')';?></option>
                            <?php }?>
							</select>
							</div>
						<div class="col-sm-3">
							<input type="text" name="telephone" id="input-telephone" class="form-control" value="<?php echo set_value('telephone', $location_telephone[1]); ?>" maxlength="20<?php //echo //$this->config->item('digits_mobile');?>" />
							<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<h4 class="tab-pane-title"><?php echo lang('text_tab_title_address'); ?></h4>
					<div class="form-group">
						<label for="input-address-1" class="col-sm-3 control-label"><?php echo lang('label_address_1'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="address[address_1]" id="street_number" class="form-control" value="<?php echo set_value('address[address_1]', $location_address_1); ?>" onFocus="geolocate()"  />
							<?php echo form_error('address[address_1]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="input-address-1-arabic" class="col-sm-3 control-label"><?php //echo lang('label_address_1_ar'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="arabic_address[address_1_ar]" id="input-address-1-arabic" class="form-control" value="<?php //echo set_value('address[address_1_ar]', $location_address_1_ar); ?>" />
							<?php //echo form_error('arabic_address[address_1_ar]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> -->
					<div class="form-group">
						<label for="input-address-2" class="col-sm-3 control-label"><?php echo lang('label_address_2'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="address[address_2]" id="route" class="form-control" value="<?php echo set_value('address[address_2]', $location_address_2); ?>" />
							<?php echo form_error('address[address_2]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="input-address-2-arabic" class="col-sm-3 control-label"><?php //echo lang('label_address_2_ar'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="arabic_address[address_2_ar]" id="input-address-2-arabic" class="form-control" value="<?php //echo set_value('arabic_address[address_2_ar]', $location_address_2_ar); ?>" />
							<?php //echo form_error('arabic_address[address_2_ar]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> -->
					<div class="form-group">
						<label for="input-city" class="col-sm-3 control-label"><?php echo lang('label_city'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="address[city]" id="locality" class="form-control" value="<?php echo set_value('address[city]', $location_city); ?>" readonly />
							<?php echo form_error('address[city]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="input-city-arabic" class="col-sm-3 control-label"><?php //echo lang('label_city_ar'); ?></label>
						<div class="col-sm-5">

							<input type="text" name="arabic_address[city_ar]" id="input-city-arabic" class="form-control" value="<?php //echo set_value('arabic_address[city_ar]', $location_city_ar); ?>" />
							<?php //echo form_error('arabic_address[city_ar]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> -->
					<div class="form-group">
						<label for="input-state" class="col-sm-3 control-label"><?php echo lang('label_state'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="address[state]" id="administrative_area_level_1" class="form-control" value="<?php echo set_value('address[state]', $location_state); ?>" readonly />
							<?php echo form_error('address[state]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="input-state-arabic" class="col-sm-3 control-label"><?php //echo lang('label_state_ar'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="arabic_address[state_ar]" id="input-state-arabic" class="form-control" value="<?php //echo set_value('arabic_address[state_ar]', $location_state_ar); ?>" />
							<?php //echo form_error('arabic_address[state_ar]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> -->
					<div class="form-group">
						<label for="input-postcode" class="col-sm-3 control-label"><?php echo lang('label_postcode'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="address[postcode]" id="postal_code" class="form-control" value="<?php echo set_value('address[postcode]', $location_postcode); ?>" readonly  />
							<?php echo form_error('address[postcode]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-country" class="col-sm-3 control-label"><?php echo lang('label_country'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							
							<input type="text" name="address[country]" id="country" class="form-control" value="<?php echo set_value('address[country]', $country_name); ?>" readonly  />
							<?php echo form_error('address[country]', '<span class="text-danger">', '</span>'); ?>
							
						</div>
					</div>
					<div class="form-group" >
						<label for="" class="col-sm-3 control-label"><?php echo lang('label_auto_lat_lng'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons" >
								<?php if ($auto_lat_lng == '1') { ?>
									<label class="btn btn-default active"><input type="radio" name="auto_lat_lng" value="1" <?php echo set_radio('auto_lat_lng', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
									<label class="btn btn-default"><input type="radio" name="auto_lat_lng" value="0" <?php echo set_radio('auto_lat_lng', '0'); ?>><?php echo lang('text_no'); ?></label>
								<?php } else { ?>
									 <label class="btn btn-default"><input type="radio" name="auto_lat_lng" value="1" <?php echo set_radio('auto_lat_lng', '1'); ?>><?php echo lang('text_yes'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="auto_lat_lng" value="0" <?php echo set_radio('auto_lat_lng', '0', TRUE); ?>><?php echo lang('text_no'); ?></label> 
								<?php } ?>
							</div>
							<?php echo form_error('auto_lat_lng', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<br />

					<div id="lat-lng" style="display: block !important;">
						<div class="form-group" >
							<label for="input-address-latitude" class="col-sm-3 control-label"><?php echo lang('label_latitude'); ?></label>
							<div class="col-sm-5">
								<input type="text" name="address[location_lat]" id="inputaddresslatitude" class="form-control" value="<?php echo set_value('address[location_lat]', $location_lat); ?>"  />
								<?php echo form_error('address[location_lat]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						 <div class="form-group">
							<label for="input-address-longitude" class="col-sm-3 control-label"><?php echo lang('label_longitude'); ?></label>
							<div class="col-sm-5">
								<input type="text" name="address[location_lng]" id="inputaddresslongitude" class="form-control" value="<?php echo set_value('address[location_lng]', $location_lng); ?>"  />
								<?php echo form_error('address[location_lng]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>

				<div id="data" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-description" class="col-sm-3 control-label"><?php echo lang('label_description'); ?></label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="5"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="input-description-arabic" class="col-sm-3 control-label"><?php //echo lang('label_description_ar'); ?></label>
						<div class="col-sm-5">
							<textarea name="arabic_description" id="input-description-arabic" class="form-control" rows="5"><?php //echo set_value('arabic_description', $description_ar); ?></textarea>
							<?php //echo form_error('arabic_description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> -->
					<div class="form-group">
						<label for="input-slug" class="col-sm-3 control-label"><?php echo lang('label_permalink_slug'); ?><span style="color:red">*</span>
							<span class="help-block"><?php echo lang('help_permalink'); ?></span>
						</label>
						<div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon text-sm"><?php echo $permalink['url']; ?></span>
                                <input type="hidden" name="permalink[permalink_id]" value="<?php echo set_value('permalink[permalink_id]', $permalink['permalink_id']); ?>"/>
                                <input type="text" name="permalink[slug]" id="input-slug" class="form-control" value="<?php echo set_value('permalink[slug]', $permalink['slug']); ?>"/>
                            </div>
                            <?php echo form_error('permalink[permalink_id]', '<span class="text-danger">', '</span>'); ?>
                            <?php echo form_error('permalink[slug]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo lang('label_image'); ?>
                            <span class="help-block"><?php echo lang('help_image'); ?></span>
                        </label>
                        <div class="col-sm-5">
                            <div class="thumbnail imagebox" id="selectImage">
                                <div class="preview">
                                    <img src="<?php echo $location_image_url; ?>" class="thumb img-responsive" id="thumb">
                                </div>
                                <div class="caption">
                                    <span class="name text-center"><?php echo $location_image_name; ?></span>
                                    <input type="hidden" name="location_image" value="<?php echo set_value('location_image', $location_image); ?>" id="field" />
                                    <p>
                                        <a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo lang('text_select'); ?></a>
                                        <a class="btn btn-danger" onclick="$('#thumb').attr('src', '<?php echo $no_location_image; ?>'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;<?php echo lang('text_remove'); ?> </a>
                                    </p>
                                </div>
                            </div>
                            <?php echo form_error('location_image', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($location_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="location_status" value="0" <?php echo set_radio('location_status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="location_status" value="1" <?php echo set_radio('location_status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="location_status" value="0" <?php echo set_radio('location_status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="location_status" value="1" <?php echo set_radio('location_status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('location_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="opening-hours" class="tab-pane row wrap-all">
					<div id="opening-type" class="form-group">
						<label for="" class="col-sm-3 control-label"><?php echo lang('label_opening_type'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
								<?php if ($opening_type == '24_7') { ?>
									<label class="btn btn-success active"><input type="radio" name="opening_type" value="24_7" <?php echo set_radio('opening_type', '24_7', TRUE); ?>><?php echo lang('text_24_7'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="opening_type" value="24_7" <?php echo set_radio('opening_type', '24_7'); ?>><?php echo lang('text_24_7'); ?></label>
								<?php } ?>
								<?php if ($opening_type == 'daily') { ?>
									<label class="btn btn-success active"><input type="radio" name="opening_type" value="daily" <?php echo set_radio('opening_type', 'daily', TRUE); ?>><?php echo lang('text_daily'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="opening_type" value="daily" <?php echo set_radio('opening_type', 'daily'); ?>><?php echo lang('text_daily'); ?></label>
								<?php } ?>
								<?php if ($opening_type == 'flexible') { ?>
									<label class="btn btn-success active"><input type="radio" name="opening_type" value="flexible" <?php echo set_radio('opening_type', 'flexible', TRUE); ?>><?php echo lang('text_flexible'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="opening_type" value="flexible" <?php echo set_radio('opening_type', 'flexible'); ?>><?php echo lang('text_flexible'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('opening_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<div id="opening-daily">
						<div class="form-group">
							<label for="input-opening-days" class="col-sm-3 control-label"><?php echo lang('label_opening_days'); ?></label>
							<div class="col-sm-5">
								<div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
									<?php foreach ($weekdays_abbr as $key => $value) { ?>
										<?php if (in_array($key, $daily_days)) { ?>
											<label class="btn btn-default active"><input type="checkbox" name="daily_days[]" value="<?php echo $key; ?>" <?php echo set_checkbox('daily_days[]', $key, TRUE); ?>><?php echo $value; ?></label>
										<?php } else { ?>
											<label class="btn btn-default"><input type="checkbox" name="daily_days[]" value="<?php echo $key; ?>" <?php echo set_checkbox('daily_days[]', $key); ?>><?php echo $value; ?></label>
										<?php } ?>
									<?php } ?>
								</div>
								<?php echo form_error('daily_days[]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-opening-hours" class="col-sm-3 control-label"><?php echo lang('label_opening_hour'); ?></label>
							<div class="col-sm-5">
								<div class="control-group control-group-2">
									<div class="input-group">
										<input type="text" name="daily_hours[open]" class="form-control timepicker" value="<?php echo set_value('daily_hours[open]', $daily_hours['open']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="input-group">
										<input type="text" name="daily_hours[close]" class="form-control timepicker" value="<?php echo set_value('daily_hours[close]', $daily_hours['close']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
								</div>
								<?php echo form_error('daily_hours[open]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('daily_hours[close]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div id="opening-flexible">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-5">
								<div class="control-group control-group-2">
									<div class="input-group">
										<b><?php echo lang('label_open_hour'); ?></b>
									</div>
									<div class="input-group">
										<b><?php echo lang('label_close_hour'); ?></b>
									</div>
								</div>
							</div>
						</div>
						<?php foreach ($flexible_hours as $hour) { ?>
						<div class="form-group">
							<label for="input-status" class="col-sm-3 control-label ">
								<span class=""><?php echo (isset($weekdays[$hour['day']])) ? $weekdays[$hour['day']] : $hour['day']; ?></span>
								<input type="hidden" name="flexible_hours[<?php echo $hour['day']; ?>][day]" value="<?php echo set_value('flexible_hours['.$hour['day'].'][day]', $hour['day']); ?>" />
							</label>
							<div class="col-sm-7">
								<div class="control-group control-group-3">
									<div class="input-group">
										<input type="text" name="flexible_hours[<?php echo $hour['day']; ?>][open]" class="form-control timepicker" value="<?php echo set_value('flexible_hours['.$hour['day'].'][open]', $hour['open']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="input-group">
										<input type="text" name="flexible_hours[<?php echo $hour['day']; ?>][close]" class="form-control timepicker" value="<?php echo set_value('flexible_hours['.$hour['day'].'][close]', $hour['close']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="btn-group btn-group-switch" data-toggle="buttons">
										<?php if ($hour['status'] == '1') { ?>
											<label class="btn btn-success active"><input type="radio" name="flexible_hours[<?php echo $hour['day']; ?>][status]" value="1" <?php echo set_radio('flexible_hours['.$hour['day'].'][status]', '1', TRUE); ?>><?php echo lang('text_open'); ?></label>
											<label class="btn btn-danger"><input type="radio" name="flexible_hours[<?php echo $hour['day']; ?>][status]" value="0" <?php echo set_radio('flexible_hours['.$hour['day'].'][status]', '0'); ?>><?php echo lang('text_closed'); ?></label>
										<?php } else { ?>
											<label class="btn btn-success"><input type="radio" name="flexible_hours[<?php echo $hour['day']; ?>][status]" value="1" <?php echo set_radio('flexible_hours['.$hour['day'].'][status]', '1'); ?>><?php echo lang('text_open'); ?></label>
											<label class="btn btn-danger active"><input type="radio" name="flexible_hours[<?php echo $hour['day']; ?>][status]" value="0" <?php echo set_radio('flexible_hours['.$hour['day'].'][status]', '0', TRUE); ?>><?php echo lang('text_closed'); ?></label>
										<?php } ?>
									</div>
								</div>
								<?php echo form_error('flexible_hours['.$hour['day'].'][open]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('flexible_hours['.$hour['day'].'][close]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('flexible_hours['.$hour['day'].'][status]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<?php } ?>
					</div>

					<hr>

					<div id="delivery-type" class="form-group">
						<label for="" class="col-sm-3 control-label"><?php echo lang('label_delivery_type'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($delivery_type === '1') { ?>
									<label class="btn btn-default"><input type="radio" name="delivery_type" value="0" <?php echo set_radio('delivery_type', '0'); ?>><?php echo lang('text_same_as_opening_hours'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="delivery_type" value="1" <?php echo set_radio('delivery_type', '1', TRUE); ?>><?php echo lang('text_custom'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="delivery_type" value="0" <?php echo set_radio('delivery_type', '0', TRUE); ?>><?php echo lang('text_same_as_opening_hours'); ?></label>
									<label class="btn btn-default"><input type="radio" name="delivery_type" value="1" <?php echo set_radio('delivery_type', '1'); ?>><?php echo lang('text_custom'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('delivery_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<div id="delivery-hours-daily">
						<div class="form-group">
							<label for="input-delivery-days" class="col-sm-3 control-label"><?php echo lang('label_opening_days'); ?></label>
							<div class="col-sm-5">
								<div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
									<?php foreach ($weekdays_abbr as $key => $value) { ?>
										<?php if (in_array($key, $delivery_days)) { ?>
											<label class="btn btn-default active"><input type="checkbox" name="delivery_days[]" value="<?php echo $key; ?>" <?php echo set_checkbox('delivery_days[]', $key, TRUE); ?>><?php echo $value; ?></label>
										<?php } else { ?>
											<label class="btn btn-default"><input type="checkbox" name="delivery_days[]" value="<?php echo $key; ?>" <?php echo set_checkbox('delivery_days[]', $key); ?>><?php echo $value; ?></label>
										<?php } ?>
									<?php } ?>
								</div>
								<?php echo form_error('delivery_days[]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-delivery-hours" class="col-sm-3 control-label"><?php echo lang('label_opening_hour'); ?></label>
							<div class="col-sm-5">
								<div class="control-group control-group-2">
									<div class="input-group">
										<input type="text" name="delivery_hours[open]" class="form-control timepicker" value="<?php echo set_value('delivery_hours[open]', $delivery_hours['open']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="input-group">
										<input type="text" name="delivery_hours[close]" class="form-control timepicker" value="<?php echo set_value('delivery_hours[close]', $delivery_hours['close']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
								</div>
								<?php echo form_error('delivery_hours[open]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('delivery_hours[close]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>

					<hr>

					 <div id="collection-type" class="form-group">
						<label for="" class="col-sm-3 control-label"><?php echo lang('label_collection_type'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($collection_type === '1') { ?>
									<label class="btn btn-default"><input type="radio" name="collection_type" value="0" <?php echo set_radio('collection_type', '0'); ?>><?php echo lang('text_same_as_opening_hours'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="collection_type" value="1" <?php echo set_radio('collection_type', '1', TRUE); ?>><?php echo lang('text_custom'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="collection_type" value="0" <?php echo set_radio('collection_type', '0', TRUE); ?>><?php echo lang('text_same_as_opening_hours'); ?></label>
									<label class="btn btn-default"><input type="radio" name="collection_type" value="1" <?php echo set_radio('collection_type', '1'); ?>><?php echo lang('text_custom'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('collection_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> 

					 <div id="collection-hours-daily">
						<div class="form-group">
							<label for="input-collection-days" class="col-sm-3 control-label"><?php echo lang('label_opening_days'); ?></label>
							<div class="col-sm-5">
								<div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
									<?php foreach ($weekdays_abbr as $key => $value) { ?>
										<?php if (in_array($key, $collection_days)) { ?>
											<label class="btn btn-default active"><input type="checkbox" name="collection_days[]" value="<?php echo $key; ?>" <?php echo set_checkbox('collection_days[]', $key, TRUE); ?>><?php echo $value; ?></label>
										<?php } else { ?>
											<label class="btn btn-default"><input type="checkbox" name="collection_days[]" value="<?php echo $key; ?>" <?php echo set_checkbox('collection_days[]', $key); ?>><?php echo $value; ?></label>
										<?php } ?>
									<?php } ?>
								</div>
								<?php echo form_error('collection_days[]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-collection-hours" class="col-sm-3 control-label"><?php echo lang('label_opening_hour'); ?></label>
							<div class="col-sm-5">
								<div class="control-group control-group-2">
									<div class="input-group">
										<input type="text" name="collection_hours[open]" class="form-control timepicker" value="<?php echo set_value('collection_hours[open]', $collection_hours['open']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="input-group">
										<input type="text" name="collection_hours[close]" class="form-control timepicker" value="<?php echo set_value('collection_hours[close]', $collection_hours['close']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
								</div>
								<?php echo form_error('collection_hours[open]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('collection_hours[close]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div> 
					<hr>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_open_and_close'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($open_close_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="open_close_status" value="0" <?php echo set_radio('open_close_status', '0'); ?>><?php echo lang('text_closed'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="open_close_status" value="1" <?php echo set_radio('open_close_status', '1', TRUE); ?>><?php echo lang('text_open'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="open_close_status" value="0" <?php echo set_radio('open_close_status', '0', TRUE); ?>><?php echo lang('text_closed'); ?></label>
									<label class="btn btn-success"><input type="radio" name="open_close_status" value="1" <?php echo set_radio('open_close_status', '1'); ?>><?php echo lang('text_open'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('open_close_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

				</div>
				
				<div id="order" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-offer-delivery" class="col-sm-3 control-label"><?php echo lang('label_offer_delivery'); ?></label>
						<div class="col-sm-5">
							<div id="input-offer-delivery" class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($offer_delivery == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="offer_delivery" value="0" <?php echo set_radio('offer_delivery', '0'); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="offer_delivery" value="1" <?php echo set_radio('offer_delivery', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="offer_delivery" value="0" <?php echo set_radio('offer_delivery', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-success"><input type="radio" name="offer_delivery" value="1" <?php echo set_radio('offer_delivery', '1'); ?>><?php echo lang('text_yes'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('offer_delivery', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div id="delivery_fee">
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_delivery_fee'); ?>
						<span class="help-block"><?php echo lang('help_delivery_fee'); ?></span>
						</label>

						<div class="col-sm-5">
							<input type="text" name="delivery_fee" id="input-rewards-value" class="form-control" value="<?php echo set_value('delivery_fee', $delivery_fee); ?>" size="5" />
							<?php echo form_error('delivery_fee', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					</div>
					<input type="hidden" name="offer_collection" value="0">
					 <div class="form-group">
						<label for="input-offer-collection" class="col-sm-3 control-label"><?php echo lang('label_offer_collection'); ?></label>
						<div class="col-sm-5">
							<div id="input-offer-collection" class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($offer_collection == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="offer_collection" value="0" <?php echo set_radio('offer_collection', '0'); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="offer_collection" value="1" <?php echo set_radio('offer_collection', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="offer_collection" value="0" <?php echo set_radio('offer_collection', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-success"><input type="radio" name="offer_collection" value="1" <?php echo set_radio('offer_collection', '1'); ?>><?php echo lang('text_yes'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('offer_collection', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> 
					<div class="form-group">
						<label for="input-delivery-boy-commission" class="col-sm-3 control-label"><?php echo lang('label_delivery_boy_commission'); ?>
							<span class="help-block"><?php echo lang('help_delivery_boy_commission'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="delivery_boy_commission" id="input-delivery-boy-commission" class="form-control" value="<?php echo set_value('delivery_boy_commission', $delivery_boy_commission); ?>" />
								
							</div>
							<?php echo form_error('delivery_boy_commission', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group hidden">
						<label for="input-delivery-time" class="col-sm-3 control-label"><?php echo lang('label_delivery_time'); ?>
							<span class="help-block"><?php echo lang('help_delivery_time'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="delivery_time" id="input-delivery-time" class="form-control" value="<?php echo set_value('delivery_time', $delivery_time); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('delivery_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="input-collection-time" class="col-sm-3 control-label"><?php echo lang('label_collection_time'); ?>
							<span class="help-block"><?php echo lang('help_collection_time'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="collection_time" id="input-collection-time" class="form-control" value="<?php echo set_value('collection_time', $collection_time); ?>" />
								<span class="input-group-addon">minutes</span>
							</div>
							<?php echo form_error('collection_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> -->
					<div class="form-group hidden">
						<label for="input-last-order-time" class="col-sm-3 control-label"><?php echo lang('label_last_order_time'); ?>
							<span class="help-block"><?php echo lang('help_last_order_time'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="last_order_time" id="input-last-order-time" class="form-control" value="<?php echo set_value('last_order_time', $last_order_time); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('last_order_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group hidden">
						<label for="input-future-orders" class="col-sm-3 control-label"><?php echo lang('label_future_order'); ?>
							<span class="help-block"><?php echo lang('help_future_order'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($future_orders === '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="future_orders" value="0" <?php echo set_radio('future_orders', '0'); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="future_orders" value="1" <?php echo set_radio('future_orders', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="future_orders" value="0" <?php echo set_radio('future_orders', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-success"><input type="radio" name="future_orders" value="1" <?php echo set_radio('future_orders', '1'); ?>><?php echo lang('text_yes'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('future_orders', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div id="future-orders-days">
						<div class="form-group">
							<label for="input-delivery-days" class="col-sm-3 control-label"><?php echo lang('label_future_order_days'); ?>
								<span class="help-block"><?php echo lang('help_future_order_days') ?></span>
							</label>
							<div class="col-sm-5">
								<div class="control-group control-group-2">
									<div class="input-group">
										<span class="input-group-addon"><b><?php echo lang('text_delivery') ?>:</b></span>
										<input type="text" name="future_order_days[delivery]" class="form-control" value="<?php echo set_value('future_order_days[delivery]', $future_order_days['delivery']); ?>" />
										<span class="input-group-addon"><?php echo lang('text_days') ?></span>
									</div>
									<div class="input-group">
										<span class="input-group-addon"><b><?php echo lang('text_collection') ?>:</b></span>
										<input type="text" name="future_order_days[collection]" class="form-control" value="<?php echo set_value('future_order_days[collection]', $future_order_days['collection']); ?>" />
										<span class="input-group-addon"><?php echo lang('text_days') ?></span>
									</div>
								</div>
								<?php echo form_error('future_order_days[delivery]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('future_order_days[collection]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="input-payments" class="col-sm-3 control-label"><?php echo lang('label_payments'); ?>
							<span class="help-block"><?php echo lang('help_payments'); ?></span>
						</label>
						<div class="col-sm-7">
							<?php foreach ($payment_list as $payment) { ?>
								<div class="col-xs-12 col-sm-5 wrap-none wrap-horizontal">
									<div class="input-group button-checkbox">
								        <button type="button" class="btn" data-color="default">&nbsp;&nbsp;&nbsp;<?php echo $payment['name']; ?></button>
										<?php if (in_array($payment['code'], $payments)) { ?>
											<input name="payments[]" type="checkbox" class="hidden" value="<?php echo $payment['code']; ?>" checked />
										<?php } else { ?>
											<input name="payments[]" type="checkbox" class="hidden" value="<?php echo $payment['code']; ?>" />
										<?php } ?>
										<!-- <a href="<?php echo $payment['edit']; ?>" class="btn btn-default"><i class="fa fa-cog"></i></a> -->
									</div>
								</div>
							<?php } ?>
							<?php echo form_error('payments[]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="reservation" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-reserve-interval" class="col-sm-3 control-label"><?php echo lang('label_reservation_time_interval'); ?>
							<span class="help-block"><?php echo lang('help_reservation_time_interval'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="reservation_time_interval" id="input-reserve-interval" class="form-control" value="<?php echo set_value('reservation_time_interval', $reservation_time_interval); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('reservation_time_interval', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-reserve-turn" class="col-sm-3 control-label"><?php echo lang('label_reservation_stay_time'); ?>
							<span class="help-block"><?php echo lang('help_reservation_stay_time'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="reservation_stay_time" id="input-reserve-turn" class="form-control" value="<?php echo set_value('reservation_stay_time', $reservation_stay_time); ?>" />
								<span class="input-group-addon"><?php echo lang('text_minutes'); ?></span>
							</div>
							<?php echo form_error('reservation_stay_time', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-table" class="col-sm-3 control-label"><?php echo lang('label_tables'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="table" value="" id="input-table" class="form-control" />
							<?php echo form_error('table', '<span class="text-danger">', '</span>'); ?>
						</div>
						<?php if($location_id!=''){ ?>
						<div class="col-sm-3">
							<a href="<?php echo site_url().'tables/edit?vendor_id='.$added_by.'&loc_id='.$location_id; ?>" class="btn btn-primary">Add New Table</a>
						</div>
					<?php } ?>
					</div>
					<div class="row">
						<div id="table-box" class="col-sm-12 wrap-top">
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th width="40%"><?php echo lang('column_table_name'); ?></th>
											<th><?php echo lang('column_table_minimum'); ?></th>
											<th><?php echo lang('column_table_capacity'); ?></th>
											<th><?php echo lang('column_table_remove'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($tables as $table) { ?>
										<?php if (in_array($table['table_id'], $location_tables)) {?>
										<tr id="table-box<?php echo $table['table_id']; ?>">
											<td><?php echo $table['table_name']; ?></td>
											<td><?php echo $table['min_capacity']; ?></td>
											<td><?php echo $table['max_capacity']; ?></td>
											<td class="img">
												<!--<a class="btn btn-danger btn-xs" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>-->
												<a class="btn btn-danger btn-xs" onclick="delete_tables('<?php echo $location_id; ?>','<?php echo $table['table_id']; ?>','<?php echo lang('alert_warning_confirm'); ?>');"><i class="fa fa-times-circle remove"></i></a>
												<input type="hidden" name="tables[]" value="<?php echo $table['table_id']; ?>" /></td>
										</tr>
										<?php } ?>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div id="delivery" class="tab-pane row wrap-none">
					<?php if ($has_lat_lng) { ?>
						<div class="col-md-7 wrap-none">
							<div id="map-holder" style="height:550px;"></div>
						</div>
						<div class="col-md-5 wrap-none">
							<div class="panel panel-default panel-delivery-areas border-left-3">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_delivery_area'); ?></h3></div>
								<div id="delivery-areas" class="panel-body">
									<?php $panel_row = 1; ?>
									<?php foreach ($delivery_areas as $area) { ?>
										<div id="delivery-area<?php echo $panel_row; ?>" class="panel panel-default">
											<input type="hidden" name="delivery_areas[<?php echo $panel_row; ?>][shape]" value="<?php echo $area['shape']; ?>" />
											<input type="hidden" name="delivery_areas[<?php echo $panel_row; ?>][vertices]" value="<?php echo $area['vertices']; ?>" />
											<input type="hidden" name="delivery_areas[<?php echo $panel_row; ?>][circle]" value="<?php echo $area['circle']; ?>" />
											<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#delivery-areas" href="#delivery-area<?php echo $panel_row; ?> .collapse">
												<div class="area-toggle"><i class="fa fa-angle-double-down up"></i><i class="fa fa-angle-double-up down"></i></div>
												<div class="area-name">&nbsp;&nbsp;<?php echo lang('text_area'); ?> <?php echo $panel_row; ?></div>
												<?php if ($area['type'] == 'circle') { ?>
													<div class="area-color"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x fa-inverse"></i><i class="fa fa-circle fa-stack-1x" style="color:<?php echo $area['color']; ?>"></i></span></div>
												<?php } else { ?>
													<div class="area-color"><span class="fa-stack"><i class="fa fa-stop fa-stack-2x fa-inverse"></i><i class="fa fa-stop fa-stack-1x" style="color:<?php echo $area['color']; ?>"></i></span></div>
												<?php } ?>
												<div class="area-buttons pull-right hide"><a title="<?php echo lang('text_edit'); ?>"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp; <a class="btn-times area-remove" title="Remove" onClick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></div>
											</div>
											<div class="collapse">
												<div class="panel-body">
													<div class="form-group">
														<div class="btn-group btn-group-switch area-types wrap-vertical" data-toggle="buttons">
															<?php if ($area['type'] == 'circle') { ?>
																<label class="btn btn-default active area-type-circle"><input type="radio" name="delivery_areas[<?php echo $panel_row; ?>][type]" value="circle" checked="checked"><?php echo lang('text_circle'); ?></label>
																<label class="btn btn-default area-type-shape"><input type="radio" name="delivery_areas[<?php echo $panel_row; ?>][type]" value="shape"><?php echo lang('text_shape'); ?></label>
															<?php } else { ?>
																<label class="btn btn-default area-type-circle"><input type="radio" name="delivery_areas[<?php echo $panel_row; ?>][type]" value="circle"><?php echo lang('text_circle'); ?></label>
																<label class="btn btn-default active area-type-shape"><input type="radio" name="delivery_areas[<?php echo $panel_row; ?>][type]" value="shape" checked="checked"><?php echo lang('text_shape'); ?></label>
															<?php } ?>
														</div>
														<?php echo form_error('delivery_areas['.$panel_row.'][type]', '<span class="text-danger">', '</span>'); ?>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label"><?php echo lang('label_area_name'); ?></label>
														<div class="col-sm-8">
															<input type="text" name="delivery_areas[<?php echo $panel_row; ?>][name]" id="" class="form-control" value="<?php echo $area['name']; ?>" />
															<?php echo form_error('delivery_areas['.$panel_row.'][name]', '<span class="text-danger">', '</span>'); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-12 control-label"><?php echo lang('label_delivery_condition'); ?>
															<span class="help-block"><?php echo lang('help_delivery_condition'); ?></span>
														</label>
														<div class="col-sm-12">
															<div class="table-responsive wrap-none">
																<table class="table table-striped table-border table-sortable">
																	<thead>
																	<tr>
																		<th class="action action-one"></th>
																		<th><?php echo lang('label_area_charge'); ?></th>
																		<th><?php echo lang('label_charge_condition'); ?></th>
																		<th><?php echo lang('label_area_min_amount'); ?></th>
																	</tr>
																	</thead>
																	<tbody>
																	<?php $table_row = 1; ?>
																	<?php if (is_array($area['charge'])) foreach ($area['charge'] as $key => $value) { ?>
																		<tr id="panel-row-<?php echo $panel_row; ?>-table-row-<?php echo $table_row; ?>">
																			<td class="action action-one handle">
																				<a class="btn btn-danger btn-xs" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;">
																					<i class="fa fa-times-circle"></i>
																				</a>
																			</td>
																			<td><input type="text" name="delivery_areas[<?php echo $panel_row; ?>][charge][<?php echo $table_row; ?>][amount]" class="form-control input-sm charge" value="<?php echo isset($value['amount']) ? $value['amount'] : ''; ?>" /></td>
																			<td><select name="delivery_areas[<?php echo $panel_row; ?>][charge][<?php echo $table_row; ?>][condition]" class="form-control input-sm">
																					<?php foreach ($delivery_charge_conditions as $condition => $condition_text) { ?>
																						<?php if ($condition == $value['condition']) { ?>
																							<option value="<?php echo $condition; ?>" selected="selected"><?php echo $condition_text; ?></option>
																						<?php } else { ?>
																							<option value="<?php echo $condition; ?>"><?php echo $condition_text; ?></option>
																						<?php } ?>
																					<?php } ?>
																				</select>
																			</td>
																			<td><input type="text" name="delivery_areas[<?php echo $panel_row; ?>][charge][<?php echo $table_row; ?>][total]" class="form-control input-sm total" value="<?php echo isset($value['total']) ? $value['total'] : ''; ?>" /></td>
																		</tr>
																		<?php if (form_error('delivery_areas['.$panel_row.'][charge]['.$table_row.'][amount]')
																			OR form_error('delivery_areas['.$panel_row.'][charge]['.$table_row.'][condition]')
																			OR form_error('delivery_areas['.$panel_row.'][charge]['.$table_row.'][total]')) { ?>
																			<tr>
																				<td colspan="4">
																					<?php echo form_error('delivery_areas['.$panel_row.'][charge]['.$table_row.'][amount]', '<span class="text-danger">', '</span>'); ?>
																					<?php echo form_error('delivery_areas['.$panel_row.'][charge]['.$table_row.'][condition]', '<span class="text-danger">', '</span>'); ?>
																					<?php echo form_error('delivery_areas['.$panel_row.'][charge]['.$table_row.'][total]', '<span class="text-danger">', '</span>'); ?>
																				</td>
																			</tr>
																		<?php } ?>
																		<?php $table_row++; ?>
																	<?php } ?>
																	</tbody>
																	<tfoot>
																	<tr id="tfoot">
																		<td class="action action-one text-center"><a class="btn btn-primary btn-xs btn-add-condition" data-panel-row="<?php echo $panel_row; ?>" data-table-row="<?php echo $table_row; ?>"><i class="fa fa-plus"></i></a></td>
																		<td></td>
																		<td></td>
																		<td></td>
																	</tr>
																	</tfoot>
																</table>
															</div>
														</div>
													</div>
												</div>
												<div class="panel-footer hide">
													<div class="clearfix text-center">
														<button type="button" class="btn btn-default pull-left area-cancel" onClick="$('#delivery-area<?php echo $panel_row; ?> .panel-heading').trigger('click');"><?php echo lang('button_close'); ?></button>
														<button type="button" class="btn btn-success pull-right area-save"><?php echo lang('button_save'); ?></button>
													</div>
												</div>
											</div>
										</div>
										<?php $panel_row++; ?>
									<?php } ?>
								</div>
								<div class="panel-footer">
									<div class="clearfix text-center">
										<button type="button" class="btn btn-default area-new" onClick="addDeliveryArea();"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo lang('text_add_new_area'); ?></button>
									</div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<p class="alert text-danger"><?php echo lang('alert_delivery_area'); ?></p>
					<?php } ?>
				</div>

				<div id="gallery" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-gallery-title" class="col-sm-3 control-label"><?php echo lang('label_gallery_title'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="gallery[title]" id="input-gallery-title" class="form-control" value="<?php echo set_value('gallery[title]', $gallery['title']); ?>" />
							<?php echo form_error('gallery[title]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-gallery-description" class="col-sm-3 control-label"><?php echo lang('label_gallery_description'); ?></label>
						<div class="col-sm-5">
							<textarea name="gallery[description]" id="input-gallery-description" class="form-control" rows="5"><?php echo set_value('gallery[description]', $gallery['description']); ?></textarea>
							<?php echo form_error('gallery[description]', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<br />

					<div id="gallery-images" class="row">
						<?php $gallery_image_row = 1; ?>
						<div class="panel panel-default panel-table">
							<div class="table-responsive">
								<table class="table table-striped table-border table-sortable">
									<thead>
										<tr>
											<th class="action"></th>
											<th><?php echo lang('column_gallery_image_thumbnail'); ?></th>
											<th class="col-sm-3"><?php echo lang('column_gallery_image_name'); ?></th>
											<th class="col-sm-4"><?php echo lang('column_gallery_image_alt'); ?></th>
											<th class="col-sm-4 text-center"><?php echo lang('column_gallery_image_status'); ?></th>
										</tr>
									</thead>
									<tbody>
									<?php if (!empty($gallery['images'])) { ?>
										<?php foreach ($gallery['images'] as $image) { ?>
											<tr id="gallery-image<?php echo $gallery_image_row; ?>">
												<td class="action">
													<i class="fa fa-sort handle"></i>&nbsp;&nbsp;&nbsp;
													<a class="btn btn-danger" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>
												</td>
												<td>
													<img src="<?php echo $image['thumb']; ?>" class="image-thumb img-responsive">
													<input type="hidden" id="image-thumb<?php echo $gallery_image_row; ?>" name="gallery[images][<?php echo $gallery_image_row; ?>][path]" value="<?php echo set_value("gallery[images][{$gallery_image_row}][path]", $image['path']); ?>">
												</td>
												<td>
													<span class="name"><?php echo $image['name']; ?></span>
													<input type="hidden" id="image-name<?php echo $gallery_image_row; ?>" class="image-name" name="gallery[images][<?php echo $gallery_image_row; ?>][name]" value="<?php echo set_value("gallery[images][{$gallery_image_row}][name]", $image['name']); ?>">
												</td>
												<td>
													<input type="text" name="gallery[images][<?php echo $gallery_image_row; ?>][alt_text]" class="form-control" value="<?php echo set_value("gallery[images][{$gallery_image_row}][alt_text]", $image['alt_text']); ?>" />
													<?php echo form_error('gallery[images]['.$gallery_image_row.'][alt_text]', '<span class="text-danger">', '</span>'); ?>
												</td>
												<td class="text-center">
													<div class="btn-group btn-group-switch" data-toggle="buttons">
														<?php if ($image['status'] === '1') { ?>
															<label class="btn btn-default"><input type="radio" name="gallery[images][<?php echo $gallery_image_row; ?>][status]" value="0"><?php echo lang('text_included'); ?></label>
															<label class="btn btn-danger active"><input type="radio" name="gallery[images][<?php echo $gallery_image_row; ?>][status]" value="1" checked="checked"><?php echo lang('text_excluded'); ?></label>
														<?php } else { ?>
															<label class="btn btn-default active"><input type="radio" name="gallery[images][<?php echo $gallery_image_row; ?>][status]" value="0" checked="checked"><?php echo lang('text_included'); ?></label>
															<label class="btn btn-danger"><input type="radio" name="gallery[images][<?php echo $gallery_image_row; ?>][status]" value="1"><?php echo lang('text_excluded'); ?></label>
														<?php } ?>
													</div>
													<?php echo form_error('gallery[images]['.$gallery_image_row.'][status]', '<span class="text-danger">', '</span>'); ?>
												</td>
											</tr>
											<?php $gallery_image_row++; ?>
										<?php } ?>
									<?php } ?>
									</tbody>
									<tfoot>
										<tr id="tfoot">
											<td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addImageToGallery();"><i class="fa fa-plus"></i></a></td>
											<td colspan="4"></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			
				<div id="reward" class="tab-pane row wrap-all">
				<h4 class="tab-pane-title"><?php echo lang('text_tab_reward'); ?></h4>
					<div class="form-group">
						<label for="input-offer-delivery" class="col-sm-3 control-label"><?php echo lang('label_reward_status'); ?></label>
						<div class="col-sm-5">
							<div id="input-reward_status" class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($reward_status == '1' || $this->input->post('reward_status') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="reward_status" value="0" <?php echo set_radio('reward_status', '0'); ?>><?php echo lang('text_inactive'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="reward_status" value="1" <?php echo set_radio('reward_status', '1', TRUE); ?>><?php echo lang('text_active'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="reward_status" value="0" <?php echo set_radio('reward_status', '0', TRUE); ?>><?php echo lang('text_inactive'); ?></label>
									<label class="btn btn-success"><input type="radio" name="reward_status" value="1" <?php echo set_radio('reward_status', '1'); ?>><?php echo lang('text_active'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('reward_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div id="reward-cancel">
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_rewards_points'); ?>
							<span class="help-block"><?php echo lang('help_rewards_points'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="rewards_value" id="input-rewards-value" class="form-control" value="<?php echo set_value('rewards_value', $rewards_value); ?>" size="5" />
							<?php echo form_error('rewards_value', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					</div>



					<h4 class="tab-pane-title"><?php echo lang('text_tab_reward_for_table_food'); ?></h4>
					
					<div id="reward-cancel">
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_enable_rewards_points'); ?>
							<span class="help-block"><?php echo lang('label_enable_rewards_points_text'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="rewards_enable" id="rewards_enable"  class="form-control">>
								<!-- <option value="1"  <?php if($rewards_enable == "1"){ echo "selected"; } ?> >Both</option> -->
								<option value="2" <?php if($rewards_enable == "2"){ echo "selected"; } ?> >Food order</option>
								<!-- <option value="3" <?php if($rewards_enable == "3"){ echo "selected"; } ?> >Reservation</option> -->
							</select>
							<?php echo form_error('rewards_enable', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					</div>





				<h4 class="tab-pane-title"><?php echo lang('text_point_system'); ?></h4>	
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_point_system'); ?>
							<span class="help-block"><?php echo lang('help_point_system'); ?></span>
						</label>
						<div class="col-sm-1" style="padding-right:0px;">
							<input type="text" name="point_value" id="input-point-value" class="form-control" value="<?php echo set_value('point_value', $point_value); ?>" size="3" />
							<?php echo form_error('point_value', '<span class="text-danger">', '</span>'); ?>
						</div>
						<label for="input-max-size" class="col-sm-1 control-label">
							<?php echo lang('label_points'); ?>
						</label>
						<div class="col-sm-1" style="padding:0px;">
							<input type="text" name="point_price" id="input-point-price" class="form-control" value="<?php echo set_value('point_price', $point_price); ?>" size="3" />
							<?php echo form_error('point_price', '<span class="text-danger">', '</span>'); ?>
						</div>
						<label for="input-max-size" class="col-sm-1 control-label">
							<!-- <?php echo lang('label_money'); ?> -->
							<?php echo $this->currency->getCurrencyCode(); ?>
						</label>
					</div>
					<div class="form-group">
					<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_minimum_price'); ?>
							<span class="help-block"><?php echo lang('help_minimum_price');?></span>
						</label>
						<div class="col-sm-3">
							<input type="text" name="minimum_price" id="input-minimum-price" class="form-control" value="<?php echo set_value('minimum_price', $minimum_price); ?>" size="3" />
							<?php echo form_error('minimum_price', '<span class="text-danger">', '</span>'); ?>
						</div>
						<label for="input-max-size" class="col-sm-1 control-label">
							<!-- <?php echo lang('label_money'); ?> -->
							<?php echo $this->currency->getCurrencyCode(); ?>
						</label>
					</div>
					<div class="form-group">
					<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_using_type'); ?>
							<span class="help-block"><?php echo lang('help_using_type');?></span>
						</label>
						<div class="col-sm-5">
							<div id="input-rewards-method" class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($rewards_method == 'custom' || $this->input->post('rewards_method') == 'custom') { ?>
									<label class="btn btn-danger"><input type="radio" name="rewards_method" value="full" <?php echo set_radio('rewards_method', 'full'); ?>><?php echo lang('text_full'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="rewards_method" value="custom" <?php echo set_radio('rewards_method', 'custom', TRUE); ?>><?php echo lang('text_custom'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="rewards_method" value="full" <?php echo set_radio('rewards_method', 'full', TRUE); ?>><?php echo lang('text_full'); ?></label>
									<label class="btn btn-success"><input type="radio" name="rewards_method" value="custom" <?php echo set_radio('rewards_method', 'custom'); ?>><?php echo lang('text_custom'); ?></label>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="form-group" id="rewards_using_amount">
					<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_maximum_amount'); ?>
							<span class="help-block"><?php echo lang('help_maximum_amount');?></span>
						</label>
						<div class="col-sm-3">
							<input type="text" name="maximum_amount" id="input-maximum_amount" class="form-control" value="<?php echo set_value('maximum_amount', $maximum_amount); ?>" size="3" />
							<?php echo form_error('maximum_amount', '<span class="text-danger">', '</span>'); ?>
						</div>
						<label for="input-max-size" class="col-sm-1 control-label">
							<!-- <?php echo lang('label_money'); ?> -->
							<?php echo $this->currency->getCurrencyCode(); ?>
						</label>
					</div>
				</div>
				<!-- Refund Cancellation --> 
				<div id="cancel_refund" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-offer-delivery" class="col-sm-3 control-label"><?php echo lang('label_refund_status'); ?></label>
						<div class="col-sm-5">
							<div id="input-refund-status" class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($refund_status == '1' || $this->input->post('refund_status') == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="refund_status" value="0" <?php echo set_radio('refund_status', '0'); ?>><?php echo lang('text_inactive'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="refund_status" value="1" <?php echo set_radio('refund_status', '1', TRUE); ?>><?php echo lang('text_active'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="refund_status" value="0" <?php echo set_radio('refund_status', '0', TRUE); ?>><?php echo lang('text_inactive'); ?></label>
									<label class="btn btn-success"><input type="radio" name="refund_status" value="1" <?php echo set_radio('refund_status', '1'); ?>><?php echo lang('text_active'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('refund_status', '<span class="text-danger">', '</span>'); ?>
						</div>
						<right class="col-sm-1" onclick="append_row();"><i class="fa fa-plus" aria-hidden="true"></i></right>
					</div>
					<div id="refund-cancel">
					<?php foreach($cancellation_type as $key => $value){ ?>
						<hr>
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_refund_deduct_period'); ?>
							<span class="help-block"><?php echo lang('help_refund_deduct_period'); ?></span>
						</label>
						<div class="col-sm-2">

							<select name="cancellation_type[]" id="input-cancellation-type-<?php echo $key; ?>" class="form-control" onchange="cancellation_type_onchange(this.value,this.id);">
								<option value="day" <?php if($cancellation_type[$key] == 'day') echo "selected";?>>Days</option>
								<option value="hour" <?php if($cancellation_type[$key] == 'hour') echo "selected";?>>Hours</option>
							</select>
							</div>
							<?php if($cancellation_period[$key]) 
							{
								($cancellation_type[$key] == 'day') ? $val = '31' : $val = '23';
							?>
							<div class="col-sm-3">
								<select name="cancellation_period[]" id="input-cancellation-period-<?php echo $key; ?>" class="form-control">
								<option value=''>Select Value</option>
								<?php 
								for($i=1;$i<=$val;$i++)
								{?>
								<option value='<?php echo $i;?>' <?php if($cancellation_period[$key] == $i) echo "selected";?> > <?php echo $i .' '. $cancellation_type[$key];?> </option>
								<?php	} ?>
								</select>
								<?php echo form_error('cancellation_period', '<span class="text-danger">', '</span>'); ?>
								</div>
							<?php } else { ?>
							<div class="col-sm-3">
							<select name="cancellation_period[]" id="input-cancellation-period-<?php echo $key; ?>" class="form-control">
								<option value=''>Select Value</option>
								<?php 
								for($i=1;$i<=31;$i++)
								{
								echo "<option value='".$i."'>".$i." Days</option>";
								} ?>
							</select>
							<?php echo form_error('cancellation_period', '<span class="text-danger">', '</span>'); ?>
						</div>
						<?php  } ?>
					</div>
					
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> <?php echo lang('label_cancellation_charge'); ?>
							<span class="help-block"><?php echo lang('help_cancellation_charge'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="cancellation_charge[]" id="input-cancellation-charge-<?php echo $key; ?>" class="form-control" value="<?php echo set_value('cancellation_charge', $cancellation_charge[$key]); ?>" size="5" />
							<?php echo form_error('cancellation_charge', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				<?php } ?>
					<input type="hidden" name="rows" id="rows" value="<?php echo count($cancellation_period)-1; ?>" >
					</div>
				</div>
				<!-- Tax Settings --> 
				<div id="tax_settings" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-offer-delivery" class="col-sm-3 control-label"><?php echo lang('label_add_tax'); ?></label>
						<div class="col-sm-5">
							<div id="input-tax-settings" class="btn-group btn-group-switch" data-toggle="buttons">
								
							</div>
							<?php echo form_error('tax_settings', '<span class="text-danger">', '</span>'); ?>
						</div>
						<right class="col-sm-1" onclick="append_row1();"><i class="fa fa-plus" aria-hidden="true"></i></right>
					</div>
					<div id="tax-settings">
					<?php foreach($tax_type as $key => $value){ ?>
						<hr>
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"> <?php echo lang('label_tax_name'); ?>
							<span class="help-block"><?php echo lang('help_tax_settings'); ?></span>
						</label>
						<div class="col-sm-5">

							<input type="text" name="tax_type[]" id="input-tax-type-<?php echo $key; ?>" class="form-control" size="5" value="<?php echo set_value('tax_type', $tax_type[$key]); ?>"  />
								
							</div>
							
					</div>
					
					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"><?php echo lang('label_tax_perc').' (%)'; ?>
							<span class="help-block"><?php echo lang('help_tax_perc'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="tax_perc[]" id="input-tax-perc-<?php echo $key; ?>" class="form-control" value="<?php echo set_value('tax_perc', $tax_perc[$key]); ?>" size="5" onkeypress="return isNumber(event)" />
							<?php echo form_error('tax_perc', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<div class="form-group">
						<label for="input-max-size" class="col-sm-3 control-label"> <?php echo lang('label_tax_status'); ?>
							<span class="help-block"><?php echo lang('help_tax_status'); ?></span>
						</label>
						<div class="col-sm-5">

							<div id="input-tax-status-<?php echo $key; ?>" class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($tax_status[$key] == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="tax_status[<?php echo $key;?>]" value="0" <?php echo set_radio('tax_status', '0'); ?>><?php echo lang('text_inactive'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="tax_status[<?php echo $key;?>]" value="1" <?php echo set_radio('tax_status','1', TRUE); ?>><?php echo lang('text_active'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="tax_status[<?php echo $key;?>]" value="0" <?php echo set_radio('tax_status', '0', TRUE); ?>><?php echo lang('text_inactive'); ?></label>
									<label class="btn btn-success"><input type="radio" name="tax_status[<?php echo $key;?>]" value="1" <?php echo set_radio('tax_status', '1'); ?>><?php echo lang('text_active'); ?></label>
								<?php } ?>
							</div>
							
							<?php echo form_error('tax_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

				<?php } ?>
					<input type="hidden" name="rows1" id="rows1" value="<?php echo count($tax_type)-1; ?>" >
					</div>
				</div>
				<!--Table Settings-->
				<div id="table_settings" class="tab-pane row wrap-all">
					
					<div class="form-group">
						<label for="input-first-table-price" class="col-sm-3 control-label"><?php echo lang('label_first_table_price'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="first_table_price" id="input-first-table-price" class="form-control" value="<?php echo set_value('first_table_price', $first_table_price); ?>" />
							<?php echo form_error('first_table_price', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-additional-table-price" class="col-sm-3 control-label"><?php echo lang('label_additional_table_price'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="additional_table_price" id="input-additional-table-price" class="form-control" value="<?php echo set_value('additional_table_price', $additional_table_price); ?>" />
							<?php echo form_error('additional_table_price', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {

	initAutocomplete();
	$('#delivery-areas select.form-control').select2({
		minimumResultsForSearch: Infinity
	});

	$('.timepicker').timepicker({
		defaultTime: '11:45 AM'
	});

	$('input[name="auto_lat_lng"]').on('change', function() {
		//$('#lat-lng').slideDown('fast');

		if (this.value == '1') {
			//$('#lat-lng').slideUp('fast');
		}
	});

	$('input[name="opening_type"]').on('change', function() {
		if (this.value == '24_7') {
			$('#opening-daily').slideUp('fast');
			$('#opening-flexible').slideUp('fast');
		}

		if (this.value == 'daily') {
			$('#opening-flexible').slideUp('fast');
			$('#opening-daily').slideDown('fast');
		}

		if (this.value == 'flexible') {
			$('#opening-daily').slideUp('fast');
			$('#opening-flexible').slideDown('fast');
		}
	});

	$('input[name="delivery_type"]').on('change', function() {
		if (this.value == '0') {
			$('#delivery-hours-daily').slideUp('fast');
		}

		if (this.value == '1') {
			$('#delivery-hours-daily').slideDown('fast');
		}
	});

	$('input[name="collection_type"]').on('change', function() {
		if (this.value == '0') {
			$('#collection-hours-daily').slideUp('fast');
		}

		if (this.value == '1') {
			$('#collection-hours-daily').slideDown('fast');
		}
	});

	$('input[name="future_orders"]').on('change', function() {
		$('#future-orders-days').slideUp('fast');

		if (this.value == '1') {
			$('#future-orders-days').slideDown('fast');
		}
	});

	/*$('select[name="cancellation_type"]').on('change', function() {
		if (this.value == 'hour') {
			$('select[name="cancellation_period"]').val(null);
			var hours_div = "<option value='1'>1 hour</option>";
			for(var i=2;i<=23;i++)
			{
				hours_div += "<option value='"+i+"'>"+i+" hours</option>";
			}
			$("#input-cancellation-period").html(hours_div);
		}
		else
		{
			var days_div = "<option value='1'>1 day</option>";
			for(var i=2;i<=23;i++)
			{
				days_div += "<option value='"+i+"'>"+i+" days</option>";
			}
			$("#input-cancellation-period").html(days_div);
		}

		if (this.value == '1') {
			$('#collection-hours-daily').slideDown('fast');
		}
	});*/


	$(document).on('click', '.btn-add-condition', function() {
		var panelRow = $(this).attr('data-panel-row');
		var tableRow = $(this).attr('data-table-row');

		tableRow++;
		addDeliveryCondition(panelRow, tableRow);

		$(this).attr('data-table-row', tableRow);
	});

	$(document).on('change', '#delivery-areas select.form-control', function() {
		$(this).parent().parent().find('input.total').attr('disabled', false);

		if (this.value == 'all') {
			$(this).parent().parent().find('input.total').val('0');
			$(this).parent().parent().find('input.total').attr('disabled', true);
		}
	});

	$('#delivery-areas select.form-control').trigger('change');
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'table\']').select2({
	placeholder: 'Start typing...',
	minimumInputLength: 0,
	ajax: {
		url: '<?php echo site_url("/tables/autocomplete"); ?>',
		dataType: 'json',
		quietMillis: 100,
		data: function (term, page, loc_id) {
			return {
				term: term, //search term
				loc_id: <?php echo $location_id;?>,
				page_limit: 10 // page size
			};
		},
		results: function (data, page, query) {
			return { results: data.results };
		}
	}
});

$('input[name=\'table\']').on('select2-selecting', function(e) {
	$('#table-box' + e.choice.id).remove();
	$('#table-box table tbody').append('<tr id="table-box' + e.choice.id + '"><td class="name">' + e.choice.text + '</td><td>' + e.choice.min + '</td><td>' + e.choice.max + '</td><td class="img">' + '<a class="btn btn-danger btn-xs" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>' + '<input type="hidden" name="tables[]" value="' + e.choice.id + '" /></td></tr>');
});
//--></script>
<?php if ($has_lat_lng) { ?>
<script type="text/javascript"><!--
$(document).on('change', '.area-types input[type="radio"]', function () {
	var color_icon = $(this).parent().parent().parent().parent().parent().parent().find('.panel-heading .area-color .fa');
	if (this.value == 'shape') {
		color_icon.removeClass('fa-circle').addClass('fa-stop');
	} else {
		color_icon.removeClass('fa-stop').addClass('fa-circle');
	}
});

//--></script>
<script type="text/javascript">//<![CDATA[
var map = null,
panel_row = <?php echo $panel_row; ?>,
colors = <?php echo $area_colors; ?>,
deliveryAreas = [],
centerLatLng = new google.maps.LatLng(
	parseFloat(<?php echo json_encode($location_lat); ?>),
	parseFloat(<?php echo json_encode($location_lng); ?>)
);

jQuery('#open-map').click(function() {
    if (map === null) {
	    initializeMap();
    }
});

if (!google.maps.Polygon.prototype.getBounds) {
	google.maps.Polygon.prototype.getBounds = function() {
		var bounds = new google.maps.LatLngBounds();
		var paths = this.getPaths();
		var path;
		for (var i = 0; i < paths.getLength(); i++) {
			path = paths.getAt(i);
			for (var ii = 0; ii < path.getLength(); ii++) {
				bounds.extend(path.getAt(ii));
			}
		}
		return bounds;
	}
}

function initializeMap() {
	var mapOptions = {
		zoom: 14,
		center: centerLatLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(
		document.getElementById('map-holder'), mapOptions);

	var marker = new google.maps.Marker({
		position: centerLatLng,
		map: map
	});

	$('#edit-form').on('submit', saveDeliveryAreas);

	clearMapAreas();
	createSavedArea(panel_row);
}

function defaultAreaOptions() {
	return {
		visible: false,
		draggable: true,
		strokeOpacity: 0.8,
		strokeWeight: 3,
		fillOpacity: 0.15
	};
}

function saveDeliveryAreas() {
	try {
		serializeAreas();
	} catch (ex) {
		console.log(ex);
		alert(ex);
		ex.preventDefault();
		return false;
	}
}

function addMapArea(deliveryArea) {
	deliveryArea.setMap(map);
	deliveryAreas.push(deliveryArea);
	setMapAreaEvents(deliveryArea);
}

function deleteMapArea(deliveryArea) {
	for (var i = deliveryAreas.length -1; i >= 0 ; i--) {
		if (deliveryAreas[i].row == deliveryArea.row) {
			toggleVisibleMapArea(deliveryArea);
			deliveryAreas.splice(i, 1);
		}
	}
}

function clearMapAreas() {
	deliveryAreas.forEach(function(area) {
		area.setMap(null);
		deleteMapArea(area);
	});
}

function toggleMapArea(deliveryArea, type) {
	deliveryAreas.forEach(function(area) {
		area.setOptions({ strokeWeight: 3, zIndex: 2, editable: false });
		if (area.row == deliveryArea.row) {
			if (type != undefined && area.type == type) {
				area.setOptions({ strokeWeight: 6, zIndex: 200, fillOpacity: 0.35, editable: true, visible: true });
			}
		}
	});
}

function toggleMapAreaType(deliveryArea, type) {
	deliveryAreas.forEach(function(area) {
		area.setOptions({ strokeWeight: 3, zIndex: 2, editable: false });
		if (area.row == deliveryArea.row) {
			area.setOptions({ visible: false });
			if (type != undefined && area.type == type) {
				area.setOptions({ strokeWeight: 6, zIndex: 200, fillOpacity: 0.15, editable: true, visible: true });
			}
		}
	});
}

function toggleVisibleMapArea(deliveryArea, type) {
	deliveryAreas.forEach(function(area) {
		if (area.row == deliveryArea.row) {
			area.setOptions({ visible: false });
			if (type != undefined && area.type == type) {
				area.setOptions({ visible: true });
			}
		}
	});
}

function toggleHoverMapArea(deliveryArea, type, event) {
	deliveryAreas.forEach(function(area) {
		if (area.row == deliveryArea.row) {
			area.setOptions({ fillOpacity: 0.15 });
			if (type != undefined && area.type == type && event == 'mouseover') {
				area.setOptions({ fillOpacity: 0.35 });
			}
		}
	});
}

function setMapAreaEvents(deliveryArea) {
	google.maps.event.addDomListener(deliveryArea, 'click', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
		$(deliveryArea.div + ' .panel-heading').trigger('click');
		if (!$(deliveryArea.div + ' .panel-heading').hasClass('collapsed')) {
   			toggleMapArea(deliveryArea, type);
		} else {
	   		toggleMapArea(deliveryArea);
		}
	});

	google.maps.event.addDomListener(deliveryArea, 'mouseover', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
   		toggleHoverMapArea(deliveryArea, type, 'mouseover');
	});

	google.maps.event.addDomListener(deliveryArea, 'mouseout', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
   		toggleHoverMapArea(deliveryArea, type, 'mouseout');
	});
}

function setDeliveryAreaEvents(deliveryArea) {
	google.maps.event.addDomListener($(deliveryArea.div + ' .panel-heading')[0], 'click', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
		if ($(deliveryArea.div + ' .panel-heading').hasClass('collapsed')) {
   			toggleMapArea(deliveryArea, type);
		} else {
	   		toggleMapArea(deliveryArea);
		}
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .area-type-shape')[0], 'click', function(event) {
   		toggleMapAreaType(deliveryArea, 'shape');
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .area-type-circle')[0], 'click', function(event) {
   		toggleMapAreaType(deliveryArea, 'circle');
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .panel-heading .area-remove')[0], 'click', function(event) {
   		deleteMapArea(deliveryArea);
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .panel-heading')[0], 'mouseover', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
   		toggleHoverMapArea(deliveryArea, type, 'mouseover');
	});

	google.maps.event.addDomListener($(deliveryArea.div + ' .panel-heading')[0], 'mouseout', function(event) {
		type = $(deliveryArea.div + ' .area-types input[type="radio"]:checked').val();
   		toggleHoverMapArea(deliveryArea, type, 'mouseout');
	});
}

function resizeMap() {
	var allAreasBounds;

	if (!deliveryAreas.length){
		return;
	}

	allAreasBounds = deliveryAreas[0].getBounds();
	deliveryAreas.forEach(function(area) {
		var bounds = area.getBounds();
		allAreasBounds.union(bounds);
	});

	map.fitBounds(allAreasBounds);
}

function drawShapeArea(row, shape) {
	var options, shapeArea,
	color = (colors[row-1] == undefined) ? '#F16745' : colors[row-1];

	options = defaultAreaOptions();
	options.paths = shape;
	options.strokeColor = color;
	options.fillColor = color;
	shapeArea = new google.maps.Polygon(options);
	addMapArea(shapeArea);

    shapeArea.div = '#delivery-area' + row;
    shapeArea.row = row;
    shapeArea.name = 'Area ' + row;
    shapeArea.color = color;
    shapeArea.type = 'shape';

	return shapeArea;
}

function drawCircleArea(row, center, radius) {
	var options, circleArea,
	color = (colors[row-1] == undefined) ? '#F16745' : colors[row-1];

	options = defaultAreaOptions();
	options.strokeColor = color;
	options.fillColor = color;
	options.center = center;
	options.radius = radius;
	circleArea = new google.maps.Circle(options);
	addMapArea(circleArea);

    circleArea.div = '#delivery-area' + row;
    circleArea.row = row;
    circleArea.name = 'Area ' + row;
    circleArea.color = color;
    circleArea.type = 'circle';

	return circleArea;
}

function serializeAreas() {
	deliveryAreas.forEach(function(area) {
		var outputPath = [],
		outputVertices = [],
		outputCircle = [],
		shape, encodedPath;

		if (area.type == 'shape') {
			var vertices = area.getPath();
			shape = google.maps.geometry.encoding.encodePath(vertices);
			encodedPath = shape.replace(/\\/g,',').replace(/\//g,'-');
			outputPath.push({shape: encodedPath});

			for (var i = 0; i < vertices.getLength(); i++) {
				var xy = vertices.getAt(i);
				outputVertices.push({
					lat: xy.lat(),
					lng: xy.lng()
				});
			}

			outputPath = JSON.stringify(outputPath);
			outputVertices = JSON.stringify(outputVertices);
			$('input[name="delivery_areas[' + area.row + '][shape]"]').val(outputPath);
			$('input[name="delivery_areas[' + area.row + '][vertices]"]').val(outputVertices);
		}

		if (area.type == 'circle') {
			outputCircle.push({center: {lat: area.getCenter().lat(), lng: area.getCenter().lng()}});
			outputCircle.push({radius: area.getRadius()});

			outputCircle = JSON.stringify(outputCircle);
			$('input[name="delivery_areas[' + area.row + '][circle]"]').val(outputCircle);
		}
	});
}

function unserializedAreas(row) {
	var savedAreas = [];

	for (i = 1; i < row; i++) {
		var shape = $('input[name="delivery_areas[' + i + '][shape]"]').val();
		var circle = $('input[name="delivery_areas[' + i + '][circle]"]').val();
		var type = $('input[name="delivery_areas[' + i + '][type]"]:checked').val();

		try {
			shape = JSON.parse(shape);
			circle = JSON.parse(circle);
		} catch (e){
			console.log(e);
		}

		savedAreas.push({
			shape: shape[0].shape,
			center: circle[0].center,
			radius: circle[1].radius,
			type: type,
			row: i
		});
	}

	return savedAreas;
}

function createSavedArea(row) {
	var savedAreas = unserializedAreas(row);

	savedAreas.forEach(function(area) {
		var shapeArea, circleArea,
		shape, decodedPath;

		if (area.center != undefined && area.radius != undefined) {
			center = new google.maps.LatLng(area.center.lat, area.center.lng);
			circleArea = drawCircleArea(area.row, center, area.radius);
		}

		if (area.shape != undefined) {
			shape = area.shape.replace(/,/g,'\\').replace(/-/g,'\/');
			decodedPath = google.maps.geometry.encoding.decodePath(shape);

			shapeArea = drawShapeArea(area.row, decodedPath);
		}

		if (area.type == 'circle') {
	   		toggleVisibleMapArea(circleArea, 'circle');
			setDeliveryAreaEvents(circleArea);
		} else {
	   		toggleVisibleMapArea(shapeArea, 'shape');
			setDeliveryAreaEvents(shapeArea);
		}
	});

    resizeMap();
}

function createDeliveryArea(row) {
	var circleArea, shapeArea, radius = 1000 * (row / 2), ne, sw, scale = 0.15, windowWidth, windowHeight,
	widthMargin, heightMargin, top, bottom, left, right;

	circleArea = drawCircleArea(row, centerLatLng, radius);
	ne = circleArea.getBounds().getNorthEast();
	sw = circleArea.getBounds().getSouthWest();
	scale = 0.15;
	windowWidth = ne.lng() - sw.lng();
	windowHeight = ne.lat() - sw.lat();
	widthMargin = windowWidth * scale;
	heightMargin = windowHeight * scale;
	top = ne.lat() - heightMargin;
	bottom = sw.lat() + heightMargin;
	left = sw.lng() + widthMargin;
	right = ne.lng() - widthMargin;
	shape = [
		new google.maps.LatLng(top, right),
		new google.maps.LatLng(bottom, right),
		new google.maps.LatLng(bottom, left),
		new google.maps.LatLng(top, left)
	];

	shapeArea = drawShapeArea(row, shape);
	toggleVisibleMapArea(shapeArea, 'shape');

    resizeMap();
	return shapeArea
}

function addDeliveryArea() {
	deliveryArea = createDeliveryArea(panel_row);
	var table_row = '1';

	html  = '<div id="delivery-area' + panel_row + '" class="panel panel-default">';
	html += '	<input type="hidden" name="delivery_areas[' + panel_row + '][shape]" value="" />';
	html += '	<input type="hidden" name="delivery_areas[' + panel_row + '][vertices]" value="" />';
	html += '	<input type="hidden" name="delivery_areas[' + panel_row + '][circle]" value="" />';
	html += '	<div class="panel-heading collapsed" data-toggle="collapse" data-target="#delivery-area' + panel_row + ' .collapse">';
	html += '		<div class="area-toggle"><i class="fa fa-angle-double-down up"></i><i class="fa fa-angle-double-up down"></i></div>';
	html += '		<div class="area-name">&nbsp;&nbsp; <?php echo lang('text_area'); ?> ' + panel_row + '</div>';
	html += '		<div class="area-color"><span class="fa-stack"><i class="fa fa-stop fa-stack-2x fa-inverse"></i><i class="fa fa-stop fa-stack-1x" style="color:' + deliveryArea.color + ';"></i></span></div>';
	html += '		<div class="area-buttons pull-right hide"><a title="<?php echo lang('text_edit'); ?>"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp; <a class="btn-times area-remove" title="<?php echo lang('text_remove'); ?>" onClick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></div>';
	html += '	</div>';
	html += '	<div class="collapse">';
	html += '	<div class="panel-body">';
	html += '		<div class="form-group">';
	html += '			<div class="btn-group btn-group-switch area-types wrap-vertical" data-toggle="buttons">';
	html += '				<label class="btn btn-success area-type-circle"><input type="radio" name="delivery_areas[' + panel_row + '][type]" value="circle"><?php echo lang('text_circle'); ?></label>';
	html += '				<label class="btn btn-success active btn-success area-type-shape"><input type="radio" name="delivery_areas[' + panel_row + '][type]" value="shape" checked="checked"><?php echo lang('text_shape'); ?></label>';
	html += '			</div>';
	html += '		</div>';
	html += '		<div class="form-group">';
	html += '			<label for="" class="col-sm-5 control-label"><?php echo lang('label_area_name'); ?></label>';
	html += '			<div class="col-sm-7 wrap-none wrap-right">';
	html += '				<input type="text" name="delivery_areas[' + panel_row + '][name]" id="" class="form-control" value="Area ' + panel_row + '" />';
	html += '			</div>';
	html += '		</div>';
	html += '		<div class="form-group">';
	html += '			<label for="" class="col-sm-12 control-label"><?php echo lang('label_delivery_condition'); ?>';
	html += '				<span class="help-block"><?php echo lang('help_delivery_condition'); ?></span>';
	html += '			</label>';
	html += '			<div class="col-sm-12">';
	html += '				<div class="table-responsive wrap-none">';
	html += '					<table class="table table-striped table-border table-sortable">';
	html += '						<thead>';
	html += '						<tr>';
	html += '							<th class="action action-one"></th>';
	html += '							<th><?php echo lang('label_area_charge'); ?></th>';
	html += '							<th><?php echo lang('label_charge_condition'); ?></th>';
	html += '							<th><?php echo lang('label_area_min_amount'); ?></th>';
	html += '						</tr>';
	html += '						</thead>';
	html += '						<tbody>';
	html += '						<tr id="panel-row-' + panel_row + '-table-row-' + table_row + '">';
	html += '							<td class="action action-one handle">';
	html += '								<a class="btn btn-danger btn-xs" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;">';
	html += '									<i class="fa fa-times-circle"></i>';
	html += '								</a>';
	html += '							</td>';
	html += '							<td>';
	html += '								<input type="text" name="delivery_areas[' + panel_row + '][charge][' + table_row + '][amount]" class="form-control input-sm charge" value="0" />';
	html += '							</td>';
	html += '							<td>';
	html += '								<select name="delivery_areas[' + panel_row + '][charge][' + table_row + '][condition]" class="form-control input-sm">';
												<?php foreach ($delivery_charge_conditions as $condition => $condition_text) { ?>
	html += '										<option value="<?php echo $condition; ?>"><?php echo $condition_text; ?></option>';
												<?php } ?>
	html += '								</select>';
	html += '							</td>';
	html += '							<td>';
	html += '								<input type="text" name="delivery_areas[' + panel_row + '][charge][' + table_row + '][total]" class="form-control input-sm total" value="0" />';
	html += '							</td>';
	html += '						</tr>';
	html += '						</tbody>';
	html += '						<tfoot>';
	html += '						<tr id="tfoot">';
	html += '							<td class="action action-one text-center"><a class="btn btn-primary btn-xs btn-add-condition" data-panel-row="' + panel_row + '" data-table-row="' + table_row + '"><i class="fa fa-plus"></i></a></td>';
	html += '							<td></td>';
	html += '							<td></td>';
	html += '							<td></td>';
	html += '						</tr>';
	html += '						</tfoot>';
	html += '					</table>';
	html += '				</div>';
	html += '			</div>';
	html += '		</div>';
	html += '	</div>';
	html += '	<div class="panel-footer hide">';
	html += '		<div class="clearfix text-center">';
	html += '			<button type="button" class="btn btn-default pull-left area-cancel" onClick="$(\'#delivery-area' + panel_row + ' .panel-heading\').trigger(\'click\');"><?php echo lang('button_close'); ?></button>';
	html += '			<button type="button" class="btn btn-success pull-right area-save"><?php echo lang('button_save'); ?></button>';
	html += '		</div>';
	html += '	</div>';
	html += '	</div>';
	html += '</div>';

	$('#delivery-areas').append(html);

	$('#panel-row-' + panel_row + '-table-row-' + table_row + ' select.form-control').select2({
		minimumResultsForSearch: Infinity
	});

	panel_row++;
	setDeliveryAreaEvents(deliveryArea);
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function addDeliveryCondition(panelRow, tableRow) {
	html = '<tr id="panel-row-' + panelRow + '-table-row-' + tableRow + '">';
	html += '	<td class="action action-one handle">';
	html += '		<a class="btn btn-danger btn-xs" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;">';
	html += '			<i class="fa fa-times-circle"></i>';
	html += '		</a>';
	html += '	</td>';
	html += '	<td>';
	html += '		<input type="text" name="delivery_areas[' + panelRow + '][charge][' + tableRow + '][amount]" class="form-control input-sm charge" value="0" />';
	html += '	</td>';
	html += '	<td>';
	html += '		<select name="delivery_areas[' + panelRow + '][charge][' + tableRow + '][condition]" class="form-control input-sm">';
	<?php foreach ($delivery_charge_conditions as $condition => $condition_text) { ?>
	html += '				<option value="<?php echo $condition; ?>"><?php echo $condition_text; ?></option>';
	<?php } ?>
	html += '		</select>';
	html += '	</td>';
	html += '	<td>';
	html += '		<input type="text" name="delivery_areas[' + panelRow + '][charge][' + tableRow + '][total]" class="form-control input-sm total" disabled="disabled" value="0" />';
	html += '	</td>';
	html += '</tr>';

	$('#delivery-area' + panelRow + ' .table-sortable tbody').append(html);

	$('#panel-row-' + panelRow + '-table-row-' + tableRow + ' select.form-control').select2({
		minimumResultsForSearch: Infinity
	});
}
//]]></script>
<?php } ?>
<script type="text/javascript"><!--
	$(function () {
		$('.table-sortable').sortable({
			containerSelector: 'table',
			itemPath: '> tbody',
			itemSelector: 'tr',
			placeholder: '<tr class="placeholder"><td colspan="5"></td></tr>',
			handle: '.handle'
		})
	});

	var gallery_image_row = <?php echo (int)$gallery_image_row; ?>;

	function addImageToGallery(image_row = null) {
		var height = (this.window.innerHeight > 0) ? this.window.innerHeight-100 : this.screen.height-100;
		$(window).bind("load resize", function() {
			var height = (this.window.innerHeight > 0) ? this.window.innerHeight-100 : this.screen.height-100;
			$('#media-manager > iframe').css("height", (height) + "px");
		});

		if (null == image_row) {
			image_row = gallery_image_row;

			html = '<tr id="gallery-image' + image_row + '">';
			html += '	<td class="action action-one"><i class="fa fa-sort handle"></i>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>';
			html += '	<td><img src="" class="image-thumb img-responsive" />'
				+ '<input type="hidden" id="image-thumb' + image_row + '" name="gallery[images][' + image_row + '][path]" value=""></td>';
			html += '	<td><span class="name"></span><input type="hidden" class="image-name" id="image-name' + image_row + '" name="gallery[images][' + image_row + '][name]" value=""></td>';
			html += '	<td><input type="text" name="gallery[images][' + image_row + '][alt_text]" class="form-control" value="" /></td>';
			html += '	<td class="text-center"><div class="btn-group btn-group-switch" data-toggle="buttons">';
			html += '		<label class="btn btn-default active"><input type="radio" name="gallery[images][' + image_row + '][status]" checked="checked"value="0"><?php echo lang('text_included'); ?></label>';
			html += '		<label class="btn btn-danger"><input type="radio" name="gallery[images][' + image_row + '][status]" value="1"><?php echo lang('text_excluded'); ?></label>';
			html += '	</div></td>';
			html += '</tr>';

			$('#gallery-images .table-sortable tbody').append(html);
			$('#gallery-image' + image_row + ' select.form-control').select2();

			gallery_image_row++;
		}

		var field = 'image-thumb' + image_row;
		$('#media-manager').remove();
		var iframe_url = js_site_url('image_manager?popup=iframe&field_id=' + field);

        $('body').append('<div id="media-manager" class="modal" tabindex="-1" data-parent="note-editor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'
            + '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">'
            + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
            + '<h4 class="modal-title">Image Manager</h4>'
            + '</div><div class="modal-body wrap-none">'
            + '<iframe name="media_manager" src="'+ iframe_url +'" width="100%" height="' + height + 'px" frameborder="0"></iframe>'
            + '</div></div></div></div>');

        $('#media-manager').modal('show');

		$('#media-manager').on('hide.bs.modal', function (e) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url('image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')) + '&width=120&height=120',
					dataType: 'json',
					success: function(json) {
						var parent = $('#' + field).parent().parent();
						parent.find('.image-thumb').attr('src', json);
						parent.find('.image-name').attr('value', parent.find('.name').html());
					}
				});
			}
		});
	}

	function delete_tables(restaurant_id,table_id,msg){
		var x = confirm(msg);
		if(x){
			
			$.post("delete_table",{table_id : table_id,restaurant_id : restaurant_id}, function(data){
				if(data == 1){
					$(".remove").closest("tr").hide();
				}else{
					alert(data);
				}
				
			});
			
		}
		
	}
	$('input[name="refund_status"]').on('change', function() {
		$('#refund-cancel').slideDown('fast');

		if (this.value == '0') {
			$('#refund-cancel').slideUp('fast');
		}
	});
	$('input[name="reward_status"]').on('change', function() {
		$('#reward-cancel').slideDown('fast');

		if (this.value == '0') {
			$('#reward-cancel').slideUp('fast');
		}
	});
	$('input[name="offer_delivery"]').on('change', function() {
		$('#delivery_fee').slideDown('fast');

		if (this.value == '0') {
			$('#delivery_fee').slideUp('fast');
		}
	});
	$('input[name="rewards_method"]').on('change', function() {
		$('#rewards_using_amount').slideDown('fast');

		if (this.value == 'full') {
			$('#rewards_using_amount').slideUp('fast');
		}
	});

	function append_row(){
		row = parseInt($("#rows").val()) + 1;
		
		html = '<hr>';
		html +=  '<div class="form-group">';
		html += '<label for="input-max-size" class="col-sm-3 control-label">';
		html +=	'<span class="red">*</span> Cancellation Charge Period<span class="help-block">Select Certain Period for cancellation Charge</span>';
		html +=	'</label><div class="col-sm-2">';
		html +=	'<select name="cancellation_type[]" id="input-cancellation-type-'+row+'" onchange="cancellation_type_onchange(this.value,this.id);" class="form-control " tabindex="-1" title="">'; 
		html +=	'<option value="day">Days</option><option value="hour">Hours</option></select></div>';
		html += '<div class="col-sm-3"><select name="cancellation_period[]" id="input-cancellation-period-'+row+'" class="form-control" tabindex="-1" title="">';
		html += '<option value="">Select Value</option><option value="1">1 Days</option><option value="2">2 Days</option><option value="3">3 Days</option><option value="4">4 Days</option><option value="5">5 Days</option><option value="6">6 Days</option><option value="7">7 Days</option><option value="8">8 Days</option><option value="9">9 Days</option><option value="10">10 Days</option><option value="11">11 Days</option><option value="12">12 Days</option><option value="13">13 Days</option><option value="14">14 Days</option><option value="15">15 Days</option><option value="16">16 Days</option><option value="17">17 Days</option><option value="18">18 Days</option><option value="19">19 Days</option><option value="20">20 Days</option><option value="21">21 Days</option><option value="22">22 Days</option><option value="23">23 Days</option><option value="24">24 Days</option><option value="25">25 Days</option><option value="26">26 Days</option><option value="27">27 Days</option><option value="28">28 Days</option><option value="29">29 Days</option><option value="30">30 Days</option><option value="31">31 Days</option></select>';
		html +=	'</div></div><div class="form-group">';
		html += '<label for="input-max-size" class="col-sm-3 control-label"><span class="red">*</span> Cancellation Charge in (%)<span class="help-block"></span></label>';
		html += '<div class="col-sm-5"><input type="text" name="cancellation_charge[]" id="input-cancellation-charge-'+row+'" class="form-control" value="0" size="5"></div></div>';
		$("#refund-cancel").append(html);
		$("#rows").val(row);
	}
	function append_row1(){
		row = parseInt($("#rows").val()) + 1;
		
		html = '<hr>';
		html +=  '<div class="form-group">';
		html += '<label for="input-max-size" class="col-sm-3 control-label">';
		html +=	' Tax Name';
		html +=	'</label><div class="col-sm-5">';
		html +=	'<input type="text" name="tax_type[]" id="input-tax-type-'+row+'"  class="form-control " tabindex="-1" title="">'; 
		html +=	'</div>';
		
		html +=	'</div></div><div class="form-group">';
		html += '<label for="input-max-size" class="col-sm-3 control-label"> Tax Percentage(%)<span class="help-block"></span></label>';
		html += '<div class="col-sm-5"><input type="text" name="tax_perc[]" id="input-tax-perc-'+row+'" class="form-control" value=" " size="5"></div></div>';


		html += '<div class="form-group">';
		html += '<label for="input-max-size" class="col-sm-3 control-label"> Tax Status</label>';
		html += '<div class="col-sm-5">';
		html += '<div id="input-tax-status-'+row+'" class="btn-group btn-group-switch" data-toggle="buttons">';
		html += '<label class="btn btn-danger"><input type="radio" id="input-tax-status-'+row+'"  name="tax_status[]" value="0" >Inactive </label>';
		html += '<label class="btn btn-success active"><input type="radio" id="input-tax-status-'+row+'"  name="tax_status[]" value="1" checked="checked" >Active</label>';		
		html +=	'</div></div></div>';

		$("#tax-settings").append(html);
		$("#rows1").val(row);
	}
	//--></script>
	<script>
		function cancellation_type_onchange(val,id){
			split_value = id.split("-");
			key = split_value[split_value.length-1];

			if (val == 'hour') {
				
				$('select[name="cancellation_period"]').val(null);
				var hours_div = "<option value='1'>1 hour</option>";
				for(var i=2;i<=23;i++)
				{
					hours_div += "<option value='"+i+"'>"+i+" hours</option>";
				}
				$("#input-cancellation-period-"+key).html(hours_div);
			}
			else
			{
				
				var days_div = "<option value='1'>1 day</option>";
				for(var i=2;i<=23;i++)
				{
					days_div += "<option value='"+i+"'>"+i+" days</option>";
				}
				$("#input-cancellation-period-"+key).html(days_div);
			}

			if (val == '1') {
				$('#collection-hours-daily').slideDown('fast');
			}
		}

	</script>
	 <script>     

      var street_number;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {       
        street_number = new google.maps.places.Autocomplete(
         (document.getElementById('street_number')),
            {types: ['geocode']});

        street_number.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {       
        var place = street_number.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
            
          }
        }
        //console.log(place.geometry);
        
        document.getElementById('street_number').value  = place.address_components[0].long_name;        
        document.getElementById('inputaddresslatitude').value  = place.geometry.location.lat();
        document.getElementById('inputaddresslongitude').value = place.geometry.location.lng();
      }

      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
          	
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            
            	document.getElementById('inputaddresslatitude').value = position.coords.latitude;
            	document.getElementById('inputaddresslongitude').value = position.coords.longitude;
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            street_number.setBounds(circle.getBounds());
          });
        }
      }
    </script>
  
<?php echo get_footer(); ?>