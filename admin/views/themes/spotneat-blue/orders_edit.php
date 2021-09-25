<?php echo get_header(); ?>
<?php
// print_r( $location_id);
// exit;
$locations = explode(",",$location_id);

        // foreach ($locations as $key => $loc_id) {
        //   $location = $this->Reservations_model->getLocation($loc_id);
        //   if(isset($location)) {
        //   	// echo $loc_id;
          	
        //    // $order_id = $reserve['order']['order_id'];
        //     $firebase1['shop'][$loc_id]['restaurant_lat'] = $location['location_lat'];
        //     $firebase1['shop'][$loc_id]['restaurant_lng'] = $location['location_lng'];
        //     $firebase1['shop'][$loc_id]['restaurant_name'] = $location['location_name'];
        //     $firebase1['shop'][$loc_id]['restaurant_phone'] = $location['location_telephone'];
        //     $firebase1['shop'][$loc_id]['restaurant_address'] = $location['location_lng'];
        //     $firebase1['shop'][$loc_id]['res_img'] = $location['location_image'];
        //     $menu_order = $this->Reservations_model->getOrderMenu($this->input->get('id'),$loc_id);
        //     foreach ($menu_order as $key => $menu) {
        //       $menu_id = $menu['menu_id'];
        //       $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['name'] = $menu['name'];
        //       $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['quantity'] = $menu['quantity'];
        //       $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['subtotal'] = $menu['subtotal'];
        //     }
            
        //   }
        // }
                // echo '<pre>';
                // print_r($firebase1);
                // exit;
?>
<div class="row content">

	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#menus" data-toggle="tab"><?php echo sprintf(lang('text_tab_menu'), $total_items); ?></span></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<input type="hidden" name="location_id" value="<?php echo $location_id; ?>" />
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="row">
						<div class="col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_status'); ?></h3></div>
								<div class="panel-body">
									<div class="col-xs-12 col-sm-3" style="display: none;">
										<label for="input-assign-staff" class="control-label"><?php echo lang('label_assign_staff'); ?></label>
										<div class="">
											<input type="hidden" name="old_assignee_id" value="<?php echo $assignee_id; ?>" />
											<input type="hidden" name="old_status_id" value="<?php echo $status_id; ?>" />
											<input type="hidden" name="order_type" value="<?php echo $order_type; ?>" />
											
											<select name="assignee_id" class="form-control">
												<option value=""><?php echo lang('text_please_select'); ?></option>
												<?php foreach ($staffs as $staff) { ?>
													<?php if ($staff['staff_id'] === $assignee_id) { ?>
														<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assignee_id', $staff['staff_id'], TRUE); ?> ><?php echo $staff['staff_name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assignee_id', $staff['staff_id']); ?> ><?php echo $staff['staff_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
											<?php echo form_error('assignee_id', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-3">
										<label for="input-name" class="control-label"><?php echo lang('label_status'); ?></label>
										<div class="">
											<select name="order_status" id="" class="form-control" >
												<?php foreach ($statuses as $status) { ?>
													<?php if ($status['status_id'] === $status_id) { ?>
														<option value="<?php echo $status['status_code']; ?>" <?php echo set_select('order_status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $status['status_code']; ?>" <?php echo set_select('order_status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
											<?php echo form_error('order_status', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-5">
										<label for="input-name" class="control-label"><?php echo lang('label_comment'); ?></label>
										<div class="">
											<textarea name="status_comment" id="" class="form-control" rows="3"><?php echo $statuses[$status_id-1]['status_comment']; ?></textarea>
											<?php echo form_error('status_comment', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-2 wrap-none">
										<label class="control-label"><?php echo lang('label_notify'); ?></label>
										<div class="">
											<div id="input-notify" class="btn-group btn-group-switch" data-toggle="buttons">
												<label class="btn btn-danger">
												<input type="radio" name="status_notify" value="0" <?php echo set_radio('status_notify', '0'); ?>><?php echo lang('text_no'); ?></label>
												<label class="btn btn-success active"><input type="radio" name="status_notify" value="1" <?php echo set_radio('status_notify', '1',TRUE); ?>><?php echo lang('text_yes'); ?></label>
											</div>
											<?php echo form_error('status_notify', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-4">
						<?php if($order_type === 'Delivery' && $staffsPermission['Delivery'])
						{ ?>
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title">Assign Delivery Boy</h3></div>
									<div class="panel-body">
										<div class="form-group col-xs-12">
											
											<div class="inlblk">
												<input type="hidden" name="prev_del_id" value="<?php echo $delivery_id; ?>">
												<?php 
												
												if ($delivery_id){
													
													foreach ($delivery_boy as $delivery1) { 
														
														if ($delivery1['delivery_id'] === $delivery_id) {
																	echo 'Assigned to : ';
															 		echo $delivery1['first_name'].' '.$delivery1['last_name'];
															 		echo  '<br>'.$delivery1['email'] ; 
															 		echo '<br>'.$delivery1['telephone'];
															 	}
															 	
															 }
												} ?>
												<select name="delivery_id" id="delivery_id" class="form-control" style="display: none;" required="required">
													<option value="">===Select Delivery boy===</option>
													<?php foreach ($delivery_boy as $delivery) { ?>
														<?php if ($delivery['delivery_id'] === $delivery_id) { ?>
															<option value="<?php echo $delivery['delivery_id']; ?>" <?php echo set_select('status', $delivery['delivery_id'], TRUE); ?> ><?php echo $delivery['first_name'].' '.$delivery['last_name'].' ('.$delivery['email'] .')'; ?></option>
														<?php } else { ?>
															<option value="<?php echo $delivery['delivery_id']; ?>" <?php echo set_select('status', $delivery['delivery_id']); ?> ><?php echo $delivery['first_name'].' '.$delivery['last_name'].' ('.$delivery['email'] .')'; ?></option>
														<?php } ?>
													<?php } ?>
												</select>

											</div>
										</div>									
									</div>
							</div>
							<?php } ?>
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_order_details'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_order_id'); ?></label>
										<div class="">
											#<?php echo $order_id; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_order_type'); ?></label>
										<div class="">
											<?php echo $order_type; ?>
										</div>
									</div>
									<!--<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_order_time'); ?></label>
										<div class="">
											<?php echo $order_time; ?>
										</div>
									</div>-->
									<div class="form-group col-xs-12">
										<label for="input-status" class="control-label"><?php echo lang('label_status'); ?></label>
										<div class="">
											<?php echo $status_name; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_payment_method'); ?></label>
										<div class="">
											<?php echo $payment; ?>
											
											<?php if ($paypal_details) { ?>
												<a class="view_details"><?php echo lang('text_transaction_detail'); ?></a><br />
											<?php } ?>
										</div>
									</div>
									<div class="paypal_details" style="display:none">
										<ul>
											<?php foreach ($paypal_details as $key => $value) { ?>
												<li>
													<span><?php echo $key; ?></span> <?php echo $value; ?>
												</li>
											<?php } ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_customer_details'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_customer_name'); ?></label>
										<div class="">
											<?php if (!empty($customer_id)) { ?>
											<?php echo $first_name; ?> <?php echo $last_name; ?>
												<!--<a href="<?php echo $customer_edit; ?>"><?php echo $first_name; ?> <?php echo $last_name; ?></a>-->
											<?php } else { ?>
												<?php echo $first_name; ?> <?php echo $last_name; ?> <span class="badge">Guest Order</span>
											<?php } ?>
										</div>
									</div>
									<!--<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_email'); ?></label>
										<div class="">
											<?php echo $email; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_telephone'); ?></label>
										<div class="">
											<?php echo $telephone; ?>
										</div>
									</div>-->
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_ip_address'); ?></label>
										<div class="">
											<?php echo $ip_address; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_user_agent'); ?></label>
										<div class="">
											<?php echo $user_agent; ?>
										</div>
									</div>
									<?php if ($id_proof == null) { ?>
											
											<?php } else { ?>
												
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_id_proof'); ?></label>
										<div class="">
											 <img src="<?php echo '../../assets/images/'.$id_proof; ?>" class="thumb img-responsive" id="thumb"
											 height="50" width="50">
										</div>
									</div>
									 <?php } ?>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4">

							<div class="panel panel-default">
								<div class="panel-body">
									<!--<div class="form-group">
										<label for="input-name" class="control-label col-xs-12"><?php echo lang('label_invoice'); ?></label>
										<div class="col-xs-12">
											<?php if (!empty($invoice_no)) { ?>
												<div class="pull-left">
													<?php echo $invoice_no; ?>
												</div>
												<div class="pull-right">
													<a href="<?php echo site_url("orders/invoice/view/{$order_id}"); ?>" class="btn btn-success btn-xs view-invoice" title="<?php echo lang('button_view_invoice'); ?>" target="_blank"><i class="fa fa-eye"></i></a>
												</div>
											<?php } else { ?>
												<button type="button" class="btn btn-info btn-xs create-invoice"><i class="fa fa-cog"></i> <?php echo lang('button_create_invoice'); ?></button>
											<?php } ?>
										</div>
									</div>-->
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_order_total'); ?></label>
										<div class="">
											<?php echo $order_total; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_order_date'); ?></label>
										<div class="">
											<?php echo $date_added; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('label_date_modified'); ?></label>
										<div class="">
											<?php echo $date_modified; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="input-name" class="control-label"><?php echo lang('column_notify'); ?></label>
										<div class="">
											<?php if ($notify === '1') { ?>
												<?php echo lang('text_email_sent'); ?>
											<?php } else { ?>
												<?php echo lang('text_email_not_sent'); ?>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_restaurant'); ?></h3></div>
								<div class="panel-body">
									<?php $locations = explode(",",$location_id);
			                			foreach ($locations as $key => $loc_id) { 
			                				 $location = $this->Reservations_model->getLocation($loc_id);
			                				 ?>
										<div class="form-group col-xs-12">
											<span><?php echo $location['location_name'].' - '.$location['location_telephone'] ?></span>
										</div>
										<div class="form-group col-xs-12">
											<span><?php echo $location['location_city'].', '.$location['location_state'] ?></span>
										</div>
									<?php } ?>
									
								</div>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('label_comment'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<div class="">
											<?php if(!empty($comment)) { ?>
												<?php echo $comment; ?>
											<?php } else { ?>
												<?php echo lang('text_no_order_comment'); ?>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--<div class="col-xs-12 col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_delivery_address'); ?></h3></div>
								<div class="panel-body">
									<?php if ($check_order_type === '1') { ?>
									<div class="form-group col-xs-12">
										<div class="">
											<span><?php echo $customer_address; ?></span>
										</div>
									</div>
									<?php } else { ?>
										<p><?php echo lang('text_no_delivery_address'); ?></p>
									<?php } ?>
								</div>
							</div>
						</div>-->
					</div>

					<!--<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('label_comment'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<div class="">
											<?php if(!empty($comment)) { ?>
												<?php echo $comment; ?>
											<?php } else { ?>
												<?php echo lang('text_no_order_comment'); ?>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>-->
					<?php  if($reser_id != 0) { ?>
					<div class="col-md-12">
						<h5><i class="fa fa-cutlery" aria-hidden="true" style="margin-right:10px;"></i>Corresponding reservation details is <a href="../reservations/edit?id=<?php echo $reser_id; ?>" target="_blank">here</a></h5>
					</div>
					<?php } ?>
					<div class="row">
						<div class="col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_status_history'); ?></h3></div>
								<div class="panel-body">
									<div class="table-responsive">
										<table height="auto" class="table table-striped table-border table-no-spacing" id="history">
											<thead>
											<tr>
												<th><?php echo lang('column_time_date'); ?></th>
												<th><?php echo lang('column_staff'); ?></th>
												<!-- <th><?php //echo lang('column_assignee'); ?></th> -->
												<th><?php echo lang('column_status'); ?></th>
												<th class="left" width="35%"><?php echo lang('column_comment'); ?></th>
												<th class="text-center"><?php echo lang('column_notify'); ?></th>
											</tr>
											</thead>
											<tbody>
											<div id="his_id">
												<?php if ($status_history) { ?>
													<input type="hidden" id="history_count" name="history_count" value="<?= count($status_history) ?>">
													<?php foreach ($status_history as $history) { ?>
														<tr>
															<td><?php echo $history['date_time']; ?></td>
															<td><?php echo $history['staff_name']; ?></td>
															<!-- <td>
																<?php foreach ($staffs as $staff) { ?>
																	<?php if ($staff['staff_id'] === $history['assignee_id']) { ?>
																		<?php echo $staff['staff_name']; ?>
																	<?php } ?>
																<?php } ?>
															</td> -->
															<td><span class="label label-default" style="background-color: <?php echo $history['status_color']; ?>;"><?php echo $history['status_name']; ?></span></td>
															<td class="text-left"><?php echo $history['comment']; ?></td>
															<td class="text-center"><?php echo ($history['notify'] === '1') ? $this->lang->line('text_yes') : $this->lang->line('text_no'); ?></td>
														</tr>
													<?php } ?>
												<?php } else { ?>
													<tr>
														<td colspan="5"><?php echo lang('text_no_status_history'); ?></td>
													</tr>
												<?php } ?>
											</div>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					
				</div>

				<div id="menus" class="tab-pane row wrap-all">
					<div class="panel panel-default panel-table">
						<div class="table-responsive">
							<table height="auto" class="table table-condensed table-border">
								<thead>
									<tr>
										<th>Qty</th>
										<th width="65%"><?php echo lang('column_name_option'); ?></th>
										<th class="text-left"><?php echo lang('column_price'); ?></th>
										<th class="text-left"><?php echo lang('column_total'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($cart_items as $cart_item) { ?>
									<tr id="<?php echo $cart_item['id']; ?>">
										<td><?php echo $cart_item['qty']; ?>x</td>
										<td><?php echo $cart_item['name']; ?><br />
										<?php if (!empty($cart_item['options'])) { ?>
											<div><small><?php echo $cart_item['options']; ?></small></div>
										<?php } ?>
										<?php if (!empty($cart_item['comment'])) { ?>
											<div><small><b><?php echo $cart_item['comment']; ?></b></small></div>
										<?php } ?>
										</td>
										<td class="text-left"><?php echo $cart_item['price']; ?></td>
										<td class="text-left"><?php echo $cart_item['subtotal']; ?></td>
									</tr>
									<?php } ?>

												
									 <?php if($reward_amount!=0){ ?>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                            <td>Reward Amount</td>
                                            <td><?php echo '(-) '.$this->currency->format($reward_amount); ?></td>
                                        </tr>
                                    <?php } ?>								
									<?php $total_count = 1; ?>
									<?php foreach ($totals as $total) { ?>
										<tr>
											<td class="<?php echo ($total_count === 1) ? 'no' : 'no'; ?>-line" width="1"></td>
											<td class="<?php echo ($total_count === 1) ? 'no' : 'no'; ?>-line"></td>
											<?php if ($total['code'] === 'order_total') { ?>
												<td class="thick-line text-left"><b><?php echo $total['title']; ?></b></td>
												<td class="thick-line text-left"><b><?php echo $total['value']; ?></b></td>
											<?php } else { ?>
												<td class="<?php echo ($total_count === 1) ? 'no' : 'no'; ?>-line text-left"><?php echo $total['title']; ?></td>
												<td class="<?php echo ($total_count === 1) ? 'no' : 'no'; ?>-line text-left"><?php echo $total['value']; ?></td>
											<?php } ?>
										</tr>
										<?php $total_count++; ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  	$('.view_details').on('click', function(){
  		if($('.paypal_details').is(':visible')){
     		$('.paypal_details').fadeOut();
   			$('.view_details').attr('class', '');
		} else {
   			$('.paypal_details').fadeIn();
   			$('.view_details').attr('class', 'active');
		}
	});

  	$('.create-invoice').on('click', function(){
	    $.ajax({
		    url: js_site_url('orders/create_invoice'),
		    type: 'POST',
		    dataType: 'json',
		    data: 'order_id=<?php echo $order_id; ?>',
		    success: function(json) {
			    window.location.href = json['redirect'];
		    }
	    });
	});
});
</script>
<script type="text/javascript"><!--
	$( document ).ready(function() {
	//$('select[name="order_status"]').trigger('change');
});
function getStatusComment() {
	if ($('select[name="order_status"]').val()) {
		$.ajax({
			url: js_site_url('statuses/comment_notify?status_id=') + encodeURIComponent($('select[name="order_status"]').val()),
			dataType: 'json',
			success: function(json) {
				$('textarea[name="status_comment"]').html(json['comment']);

				if (json['notify'] === '1') {
					$('input[name="notify"][value="1"]').parent().click();
				} else {
					$('input[name="notify"][value="0"]').parent().click();
				}
			}
		});
	}
}
	
	$('select[name="order_status"]').change(function() {
		var order_status = $('select[name="order_status"]').val();
		// alert(order_status);
		if(order_status >=3 ){
			$('#delivery_id').css('display', 'block');
			$('#s2id_delivery_id').css('display', 'block');
		}else{
			$('#delivery_id').css('display', 'none');
			$('#s2id_delivery_id').css('display', 'none');
		}
		var pre_status = <?php echo $status_id; ?>;
		//console.log(pre_status);
		if((order_status!=0) && (order_status!=20) && (order_status < pre_status)){
			alert('Status changed down the order, status wont be changed and remains in the same status!');
			$('select[name="order_status"]').val( $('select[name="order_status"]').find("option[selected]").val() );
			return false;
		}else{
			getStatusComment();
		}
	});
order_id = '<?php echo $order_id; ?>';
history_count = $('#history_count').val();
setInterval(function(){ 		
     $.ajax({
		    url: js_site_url('orders/check_or_status'),
		    type: 'POST',
		    dataType: 'json',
		    data: { order_id: order_id,
		    	history_count: history_count},
		   	// data: 'order_id=<?php echo $order_id; ?>',
		    success: function(data) {
		    	if(data.status == 1){
		    		location.reload();
		    	}
			    // window.location.href = json['redirect'];
		    }
	    });
}, 3000);
//--></script>
<?php echo get_footer(); ?>