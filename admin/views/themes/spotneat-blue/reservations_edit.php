<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<!-- <li><a href="#menus" data-toggle="tab"><?php echo sprintf(lang('text_tab_menu'), $total_items); ?></span></a></li> -->
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">


						<div class="row">
						<div class="col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_status'); ?></h3></div>
								<div class="panel-body">
									<div class="col-xs-12 col-sm-0">
										<input type="hidden" name="old_assignee_id" value="<?php echo $assignee_id; ?>" />

										<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />

										<input type="hidden" name="old_status_id" value="<?php echo $status_id; ?>" />
										<!--<label for="input-assign-staff" class="control-label"><?php echo lang('label_assign_staff'); ?></label>
										<div class="inlblk">
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
										</div>-->
										<input type="hidden" name="assignee_id" value="<?php echo $assignee_id; ?>" />
									</div>
									<div class="col-xs-12 col-sm-3">
										<label for="input-status" class="control-label"><?php echo lang('label_status'); ?></label>
										<div class="">
											<?php if($status_id!='17'){ ?>

											<select name="status" class="form-control" onChange="getStatusComment();">
												<?php foreach ($statuses as $status) { ?>
													<?php if ($status['status_code'] === $status_id) { ?>
														<option value="<?php echo $status['status_code']; ?>" <?php echo set_select('status', $status['status_code'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $status['status_code']; ?>" <?php echo set_select('status', $status['status_code']); ?> ><?php echo $status['status_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
											<?php } else{ ?>

												
												<div class="row">
												<div class="col-sm-12">
												<div class="tooltips col-sm-12">
												  <span class="tooltiptext col-xs-12">
												  	
												  		
												  	<?php 

												  	echo '<table width="600" class="col-xs-12 col-sm-12 col-md-12"><tr><td class="policy_label">'.lang('total_amount').' : </td><td class="policy_content"> '.  $this->currency->format($total_amount).'</tr>';
												  	echo '<tr><td colspan="2"><hr></td></tr>';
												  	echo '<tr><td class="policy_label">'.lang('reservation_time').' :  </td><td class="policy_content"> '.$reserve_time.' '. $reserve_date.'</td></tr>';
												  	echo '<tr><td colspan="2"><hr></td></tr>';
												  	echo '<tr><td class="policy_label">'.lang('cancellation_time').' :  </td><td class="policy_content">'. $cancellation_time.'</td></tr>';
												  	echo '<tr><td colspan="2"><hr></td></tr>';
												  	echo '<tr><td class="policy_label">'.lang('cancel_percent').' : </td><td class="policy_content">'. $cancel_percent.'%</td></tr>';
												  	echo '<tr><td colspan="2"><hr></td></tr>';
												  	echo '<tr><td class="policy_label">'.lang('refund_amount').' : </td><td class="policy_content">'.  $this->currency->format($refund_amount).'</td></tr></table>';
												  	
												  	?>
												  	
												  </span>
												  <b><?php echo 'Canceled'; ?></b>
												  <i class="fa fa-info-circle padd-left" aria-hidden="true"></i>
												</div>
												</div>
												  	</div>
											<?php } ?>

											<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
										</div><br />
										<div id="refund_show" style="display: none;">
											<p><a href="<?php echo site_url().'../account/cancel_policy?loc_id='.$location_id; ?>" target="_blank">&nbsp;<?php echo lang('cancel_policy'); ?></a></p>
											<input type="radio" name="refund" value="full"><?php echo lang('full_refund').'&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
											<input type="radio" name="refund" value="policy" checked>&nbsp;<?php echo lang('apply_policy'); ?>
											<input type="hidden" name="tot_amount" value="<?php echo $total_amount; ?>">

										</div>
									</div>
									<div class="col-xs-12 col-sm-5">
										<label for="input-comment" class="control-label"><?php echo lang('label_comment'); ?></label>
										<div class="">
											<textarea name="status_comment" rows="3" class="form-control"><?php echo set_value('status_comment'); ?></textarea>
											<?php echo form_error('status_comment', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-2">
										<label for="input-notify" class="control-label"><?php echo lang('label_notify'); ?></label>
										<div class="">
											<div id="input-notify" class="btn-group btn-group-switch" data-toggle="buttons">
												<?php //if ($notify == '1') { ?>
													<label class="btn btn-danger"><input type="radio" name="notify" value="0" <?php echo set_radio('notify', '0'); ?>><?php echo lang('text_no'); ?></label>
													<label class="btn btn-success active"><input type="radio" name="notify" value="1" <?php echo set_radio('notify', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
												<?php //} else { ?>
													<!--<label class="btn btn-danger active"><input type="radio" name="notify" value="0" <?php echo set_radio('notify', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
													<label class="btn btn-success"><input type="radio" name="notify" value="1" <?php echo set_radio('notify', '1'); ?>><?php echo lang('text_yes'); ?></label>-->
												<?php //} ?>
											</div>
											<?php echo form_error('notify', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div class="row">
						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_general'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_reservation_id'); ?></label>
										<div class="inlblk">
											#<?php echo $reservation_id; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_unique_code'); ?></label>
										<div class="inlblk">
											<?php echo $otp; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_guest'); ?></label>
										<div class="inlblk">
											<?php echo $guest_num; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_reservation_date'); ?></label>
										<div class="inlblk">
											<?php echo $reserve_date; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_reservation_time'); ?></label>
										<div class="inlblk">
											<?php echo $reserve_time; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_occasion'); ?></label>
										<div class="inlblk">
											<?php echo $occasions[$occasion]; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						 <div class="col-xs-12 col-sm-4">

							<?php /*<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_delivery_boy'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										
										<div class="inlblk">
											<?php 
											
											if ($delivery_id){
												foreach ($delivery_boy as $delivery) { 
													if ($delivery['delivery_id'] === $delivery_id) {
												echo 'Assigned to : ';
														 		echo $delivery['first_name'].' '.$delivery['last_name'];
														 		echo  '<br>'.$delivery['email'] ; 
														 		echo '<br>'.$delivery['telephone'];
														 	}
														 }
											} ?>
											<select name="delivery_id" class="form-control" >
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
							</div>*/ ?>

							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_customer'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_customer_name'); ?> : </label>
										<div class="inlblk">
											<?php echo $first_name; ?> <?php echo $last_name; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_customer_email'); ?> : </label>
										<div class="inlblk">
											<?php echo $email; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_customer_telephone'); ?> : </label>
										<div class="inlblk">
											<?php echo $telephone; ?>
										</div>
									</div>
								</div>
							</div>

						</div> 
						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_date_added'); ?></label>
										<div class="inlblk">
											<?php echo $date_added; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_date_modified'); ?></label>
										<div class="inlblk">
											<?php echo $date_modified; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('column_notify'); ?></label>
										<div class="inlblk">
											<?php if ($notify === '1') { ?>
												<?php echo lang('text_email_sent'); ?>
											<?php } else { ?>
												<?php echo lang('text_email_not_sent'); ?>
											<?php } ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_ip_address'); ?></label>
										<div class="inlblk">
											<?php echo $ip_address; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_user_agent'); ?></label>
										<div class="inlblk">
											<?php echo $user_agent; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"> <span class="text-muted"><?php echo $location_name; ?></span></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<div class="inlblk">
											<span>
												<?php echo $location_address_1; ?>,<br />
												<?php echo $location_city; ?>,
												<?php echo $location_postcode; ?>,
												<?php echo $location_country; ?>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_table'); ?></h3></div>
								<div class="panel-body">
									<table height="auto" class="table table-striped table-border table-no-spacing" id="tables_list">
										<thead>
												<tr>
													<th><?php echo lang('label_table_name'); ?></th>
													<th><?php echo lang('label_table_min_capacity'); ?></th>
													<th><?php echo lang('label_table_capacity'); ?></th>
												</tr>
										</thead>
										<tbody>
										<?php foreach($tables_list as $key => $value){ ?>
											<tr>
												<td><?php echo $value['table_name']; ?></td>
												<td><?php echo $value['min_capacity']; ?></td>
												<td><?php echo $value['max_capacity']; ?></td>
											</tr>
										<?php } ?>
										</tbody>
									</table>

									<!--<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_table_name'); ?></label>
										<div class="inlblk">
											<?php echo $table_name; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_table_min_capacity'); ?></label>
										<div class="inlblk">
											<?php echo $min_capacity; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_table_capacity'); ?></label>
										<div class="inlblk">
											<?php echo $max_capacity; ?>
										</div>
									</div>-->
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('label_comment'); ?> - <span class="text-muted"><?php echo $location_name; ?></span></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<div class="inlblk">
											<?php echo $comment; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					

					</div>

					<?php  if($order_id != 0) { ?>
					<div class="col-md-12">
						<h5><i class="fa fa-cutlery" aria-hidden="true" style="margin-right:10px;"></i>Food is order for this reservation refer <a href="../orders/edit?id=<?php echo $order_id; ?>" target="_blank">here</a></h5>
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
												<!--<th><?php echo lang('column_staff'); ?></th>
												<th><?php echo lang('column_assignee'); ?></th>-->
												<th><?php echo lang('column_status'); ?></th>
												<th class="left" width="35%"><?php echo lang('column_comment'); ?></th>
												<th class="text-center"><?php echo lang('column_notify'); ?></th>
											</tr>
											</thead>
											<tbody>
											<?php if ($status_history) { ?>
												<?php foreach ($status_history as $history) { ?>
													<tr>
														<td><?php echo $history['date_time']; ?></td>
														<!--<td><?php echo $history['staff_name']; ?></td>
														<td>
															<?php foreach ($staffs as $staff) { ?>
																<?php if ($staff['staff_id'] === $history['assignee_id']) { ?>
																	<?php echo $staff['staff_name']; ?>
																<?php } ?>
															<?php } ?>
														</td>-->
														<td><span class="label label-default" style="background-color: <?php echo $history['status_color']; ?>;"><?php echo $history['status_name']; ?></span></td>
														<td class="left"><?php echo $history['comment']; ?></td>
														<td class="text-center"><?php echo ($history['notify'] === '1') ? $this->lang->line('text_yes') : $this->lang->line('text_no'); ?></td>
													</tr>
												<?php } ?>
											<?php } else { ?>
												<tr>
													<td colspan="6"><?php echo lang('text_no_status_history'); ?></td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					
				</div>

				<div id="menus" class="tab-pane row wrap-all">
					<?php if($order_id != 0){ ?> 
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


									<tr>
										<td class="thick-line" width="1"></td>
										<td class="thick-line"></td>
										<td class="thick-line text-left">
										<h4><?php echo lang('label_booking_price'); ?></h4>
										</td>
										<td class="thick-line text-left">
										<h4><?php echo $this->currency->format($booking_price); ?></h4>
										</td>
									</tr>	
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
				<?php }else{ ?>
					<h4><center><?php echo lang('no_orders'); ?></center></h4>
				<?php } ?>
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
});
</script>

<?php 

if($order_id!=0){ ?>
<script type="text/javascript"><!--
function getStatusComment() {
	if ($('select[name="status"]').val()) {
		$.ajax({
			url: js_site_url('statuses/comment_notify?status_id=') + encodeURIComponent($('select[name="status"]').val()),
			dataType: 'json',
			success: function(json) {
				$('textarea[name="status_comment"]').html(json['comment']);
				
				if($('select[name="status"]').val() == '17'){
					//console.log($('select[name="status"]').val());
					alert('Kindly check Refund Policy');
					$("#refund_show").css("display", "block");
				}
				else{
					$("#refund_show").css("display", "none");
				}
			}
		});
	}
};

$('select[name="status"]').trigger('change');
//--></script>

<?php }else{ ?>

<script type="text/javascript"><!--
function getStatusComment() {
	if ($('select[name="status"]').val()) {
		$.ajax({
			url: js_site_url('statuses/comment_notify?status_id=') + encodeURIComponent($('select[name="status"]').val()),
			dataType: 'json',
			success: function(json) {
				$('textarea[name="status_comment"]').html(json['comment']);
				
				/*if($('select[name="status"]').val() == '17'){
					//console.log($('select[name="status"]').val());
					alert('Kindly check Refund Policy');
					$("#refund_show").css("display", "block");
				}
				else{
					$("#refund_show").css("display", "none");
				}*/
			}
		});
	}
};

$('select[name="status"]').trigger('change');
//--></script>

<?php } ?>

<style>
.inlblk{
	display: inline-block;
}
</style>
<?php echo get_footer(); ?>