<?php echo get_header();
/*print_r($staff_location_id[0]->location_id);
print_r($locations);exit*/;

$dat=array();	
$i=0;
foreach($staff_location_id as $locs){
$dat[$i]=$locs->location_id;
$i++;
}
//print_r($dat);


 ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<?php if($vendor != "yes"){ ?>
				<li class="active"><a href="#staff-details" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#basic-settings" data-toggle="tab"><?php echo lang('text_tab_setting'); ?></a></li>
				
				
			<?php } ?>

				<li <?php if($vendor == "yes"){ ?> class="active" <?php } ?> ><a href="#permission-level"  data-toggle="tab"><?php echo lang('text_tab_permission'); ?></a></li>
				<!-- <li><a href="#payment_settings" data-toggle="tab"><?php echo lang('text_tab_payment_settings'); ?></a></li> -->
				<li><a href="#theme-settings" data-toggle="tab"><?php echo lang('text_theme_settings'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="staff-details" class="tab-pane row wrap-all <?php if($vendor == ""){ ?> active <?php } ?>">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="staff_name" id="input-name" class="form-control" value="<?php echo set_value('staff_name', $staff_name); ?>" />
							<?php echo form_error('staff_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-3 control-label"><?php echo lang('label_email'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="staff_email" id="input-email" class="form-control" value="<?php echo set_value('staff_email', $staff_email); ?>" />
							<?php echo form_error('staff_email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-telephone" class="col-sm-3 control-label"><?php echo lang('label_telephone'); ?><span style="color:red">*</span></label>
						<div class="col-sm-2">
						<select class="form-control" name="country_code">
							<?php foreach($phone_code as $pcode){?>
                                <option data-countryCode="<?php echo $pcode->code;?>" value="<?php echo $pcode->dial_code;?>"<?php if($staff_telephone[0] == $pcode->dial_code) {echo ' selected';} else if($pcode->code == $default_country_code && $staff_telephone[0] == '') {echo ' selected';}?>><?php echo $pcode->code.' ('.$pcode->dial_code.')';?></option>
                            <?php }?>
							</select>
							</div>
							<div class="col-sm-3">
							<input type="text" name="telephone" id="input-telephone" class="form-control" value="<?php echo set_value('telephone', $staff_telephone[1]); ?>" maxlength="20<?php // echo $this->config->item('digits_mobile');?>" />
							<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-username" class="col-sm-3 control-label"><?php echo lang('label_username'); ?><span style="color:red">*</span>
							<span class="help-block"><?php echo lang('help_username'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="username" id="input-username" class="form-control" value="<?php echo set_value('username', $username); ?>" />
							<?php echo form_error('username', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password" class="col-sm-3 control-label"><?php echo lang('label_password'); ?><span style="color:red">*</span>
							<span class="help-block"><?php echo lang('help_password'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="password" name="password" id="input-password" class="form-control" id="password" autocomplete="off"  value="<?php echo set_value('password', $password); ?>"  />
							<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_confirm_password'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="password" name="password_confirm" id="" class="form-control" id="password_confirm" autocomplete="off"  value="<?php echo set_value('password_confirm', $password_confirm
							); ?>"  />
							<?php echo form_error('password_confirm', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_commission'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="commission" id="" class="form-control" id="commission" autocomplete="off" value="<?php echo set_value('commission', $commission); ?>" />
							<?php echo form_error('commission', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php //echo lang('label_delivery_commission'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="delivery_commission" id="" class="form-control" id="delivery_commission" autocomplete="off" value="<?php //echo set_value('delivery_commission', $delivery_commission); ?>" />
							<?php //echo form_error('delivery_commission', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div> -->

					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($staff_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="staff_status" value="0" <?php echo set_radio('staff_status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="staff_status" value="1" <?php echo set_radio('staff_status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="staff_status" value="0" <?php echo set_radio('staff_status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="staff_status" value="1" <?php echo set_radio('staff_status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('staff_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>					

				</div>



				<div id="basic-settings" class="tab-pane row wrap-all">
					<?php if ($display_staff_group) { ?>
						<?php if($this->input->get('id') != 11)
						{?>
						<div class="form-group">
							<label for="input-group" class="col-sm-3 control-label"><?php echo lang('label_group'); ?></label>
							<div class="col-sm-5">
							
								<select name="staff_group_id" id="input-group" class="form-control">
								<option value=""><?php echo lang('text_please_select'); ?></option>
								<?php foreach ($staff_groups as $staff_group) { ?>
									<?php 
										if ($staff_group['staff_group_id'] != 11) { ?>
										<option value="<?php echo $staff_group['staff_group_id']; ?>" 
											<?php if($staff_group['staff_group_id'] == $staff_group_id) echo "selected";?>>
											<!-- <?php echo set_select('staff_group_id', $staff_group['staff_group_id'],TRUE); ?>  -->
										
											<?php echo $staff_group['staff_group_name']; ?>
										</option>
									<?php } ?>
								<?php } ?>
								</select>
								<?php echo form_error('staff_group_id', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<?php } else{?>
						<input type="hidden" name="staff_group_id" value="11" >
						<?php }?>	

						<div class="form-group">
							<label for="input-location" class="col-sm-3 control-label"><?php echo lang('label_location'); ?></label>
							<div class="col-sm-5">
								<select name="staff_location_id[]" multiple id="input-location" class="form-control">
									<option value="0"><?php echo lang('text_use_default'); ?></option>
									
									<?php foreach ($locations as $location) {  ?>
										<option value="<?php echo $location['location_id']; ?>" 
											<?php if (in_array($location['location_id'],$dat)) { ?>
											<?php echo set_select('staff_location_id', $location['location_id'], TRUE); ?> >
											<?php  } else { ?>
										 	<?php echo set_select('staff_location_id', $location['location_id']); ?> >
									 		<?php  } echo $location['location_name']; ?>
									   </option>
									<?php } ?>
								</select>
								<?php echo form_error('staff_location_id', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					<?php } ?>
				</div>

				<div id="permission-level" class="tab-pane row wrap-all <?php if($vendor == "yes"){ ?> active <?php } ?>">
					<div class="panel panel-default panel-table">
						<div class="table-responsive">
							<table class="table table-striped table-border" style="width:50%;">
								<thead>
                                    <tr>
                                        <th><b>S.No</b></th>
                                        <th>Name</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <?php 
                                 $j=1;
                                 foreach ($permissions as $key => $permission) { 
                                 	if($default_permission == ""){
                                 ?>
                                 <tr>
                                 	<?php
                                 		//$name = explode('.',$permission['name']);
                                 		$name = $key;
                                 		//echo $permission;
                                 		if($permission == "on"){
                                 			$checked = "checked";
                                 		}else{
                                 			$checked = "";
                                 		}
                                 	?>
                                 	<th><?php echo $j; ?></th>
                                 	<td><?php echo $name; ?>
                                    </td>
                                    <td class="action text-center success">
                                    	<input type="hidden" name="permission_name[]" value="<?php echo $name; ?>" >
                                    	<input type="checkbox" name="<?php echo $name; ?>_view" <?php echo $checked; ?>	 />
                                    </td>
                                 </tr>

                                <?php $j++; }else{ ?>

                                	<tr>
                                 	<?php
                                 		$name = explode('.',$permission['name']);
                                 		$name = $name[1];
                                 	?>
                                 	<th><?php echo $j; ?></th>
                                 	<td><?php echo $name; ?>
                                    </td>
                                    <td class="action text-center success">
                                    	<input type="hidden" name="permission_name[]" value="<?php echo $name; ?>" >
                                    	<input type="hidden" name="permission_id[]" value="<?php echo $permission['permission_id']; ?>" >
                                    	<input type="checkbox" name="<?php echo $name; ?>_view" checked	 />
                                    </td>
                                 </tr>

                            	<?php $j++;} }?>
                            </table>
						</div>
					</div>
				</div>

				<div id="payment_settings" class="tab-pane row wrap-all">
					<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
					<div class="form-group">
						<label for="input-group" class="col-sm-3 control-label"><?php echo lang('label_payment_type'); ?></label>
						<div class="col-sm-5">
							<select name="payment_type" id="input-group" class="form-control">
							<?php if ($payment_details['payment_type'] == 1) { ?>
								<option value="1" <?php echo set_select('payment_type', 1 ,true); ?> >Sandbox</option>
								<option value="2" <?php echo set_select('payment_type', 2 ); ?> >Production</option>
							<?php } else if ($payment_details['payment_type'] == 2) { ?>
								<option value="1" <?php echo set_select('payment_type', 1 ); ?> >Sandbox</option>
								<option value="2" <?php echo set_select('payment_type', 2 ,true); ?> >Production</option>
							<?php } else { ?>	
								<option value="1" <?php echo set_select('payment_type', 1 ); ?> >Sandbox</option>
								<option value="2" <?php echo set_select('payment_type', 2 ); ?> >Production</option>
							<?php } ?>
							</select>
							<?php echo form_error('payment_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
									

					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_payment_username'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text"  name="payment_username" id="first-name" class="form-control" value="<?php echo set_value('payment_username', $payment_details['payment_username']); ?>" />
							<?php echo form_error('payment_username', '<span class="text-danger">', '</span>'); ?>
							
						</div>
					</div>

					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_payment_password'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="password" name="payment_password" id="last-name" class="form-control" value="<?php echo set_value('payment_password', $payment_details['payment_password']); ?>" />
							<?php echo form_error('payment_password', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_merchant_id'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="merchant_id" id="business-url" class="form-control" value="<?php echo set_value('merchant_id', $payment_details['merchant_id']); ?>" />
							<?php echo form_error('merchant_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_payment_key'); ?><span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="payment_key" id="payment_key" class="form-control" value="<?php echo set_value('payment_key', $payment_details['payment_key']); ?>" />
							<?php echo form_error('payment_key', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					
					

                    <!-- <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo lang('label_back_doc'); ?>
                        </label>
                        <div class="col-sm-5">
                            <div class="thumbnail imagebox" id="selectImage1">
                                <div class="preview">
                                    <img src="<?php echo $menu_image_url; ?>" class="thumb img-responsive" id="thumb1">
                                </div>
                                <div class="caption">
                                    <span class="name1 text-center"><?php echo $back_doc; ?></span>
                                    <input type="hidden" name="back_doc" value="<?php echo set_value('back_doc', $back_doc); ?>" id="field1" />
                                    <p>
                                        <a id="select-image1" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo lang('text_select'); ?></a>
                                        <a class="btn btn-danger" onclick="$('#thumb1').attr('src', '<?php echo $no_photo; ?>'); $('#field1').attr('value', ''); $(this).parent().parent().find('.name1').html('');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;<?php echo lang('text_remove'); ?> </a>
                                    </p>
                                </div>
                            </div>
                            <?php echo form_error('back_doc', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div> -->
					
					</form>	
				</div>

				<div id="theme-settings" class="tab-pane row wrap-all">
					<?php if ($display_staff_group) { ?>
							

						<div class="form-group">
							<label for="input-location" class="col-sm-3 control-label"><?php echo lang('label_site_color'); ?></label>
							<div class="col-sm-5">
								<input type="color" name="site_color" id="site_color" value="<?php echo $site_color;  ?>">
								<?php echo form_error('label_site_color', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-location" class="col-sm-3 control-label"><?php echo lang('label_logo'); ?></label>
							<div class="col-sm-5">
								<input type="file" name="logo" id="logo">
								<?php echo form_error('logo', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
						<label for="img-logo" class="col-sm-3 control-label"></label>
							<div class="col-sm-5">
								<img src="<?php echo base_url().$logo;  ?>" alt="" height="400px;" width="350px;">
							</div>
						</div>
					<?php } ?>
				</div>

			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>