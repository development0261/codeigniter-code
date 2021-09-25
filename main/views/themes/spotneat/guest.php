<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="col-md-12 padd-none">
								<?php if ($this->alert->get()) { ?>
							    <div id="notification">
							        <div class="container">
							            <div class="row">
							                <div class="col-md-12">
							                    <?php echo $this->alert->display(); ?>
							                </div>
							            </div>
							        </div>
							    </div>
							<?php } ?>
							</div>
<div id="page-content" style="background-color: #fdcec0 !important;">
	<div class="container ">
		

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12  top-20 padd-none">
			
			
				<div id="login-form" class="content-wrap col-md-12 col-sm-12 col-xs-12 ">
					
						<div class="heading-section top-20" >
							
							<h2 style="color: #f5511e;" class="text-center"><?php echo lang('text_heading'); ?></h2>
							<p class="text-center"><?php echo lang('thank_you_reservation'); ?></p>
							<span class="under-heading"></span>

							<div class="col-md-12 col-sm-12 col-xs-12 top-20">
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('name'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo $first_name; ?></b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('email'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo $email; ?></b>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('phone'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo $telephone; ?></b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('reservation_id'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo $reservation_id; ?></b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('reservation_date'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo $reserve_date; ?></b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('reservaion_time'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo $reserve_time; ?></b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('guests'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo $guest_num; ?></b>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('booking_price'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo  $this->currency->format($booking_price); ?></b>
								</div>
								<?php if($booking_tax_amount > 0) { ?>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('table_booking_tax'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo  $this->currency->format($booking_tax_amount); ?></b>
								</div>
								<?php } ?>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('order_price'); ?> : </b>
								</div>
									<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo  $this->currency->format($order_price); ?></b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b style="float: right;"> <?php echo lang('total_amount'); ?> : </b>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">
									<b><?php echo  $this->currency->format($total_amount); ?></b>
								</div>
							
								<?php 
									if($status!='17'){ ?>
								<div class="col-md-12 col-sm-12 col-xs-12 top-20 text-center">
									
									<a href="#" data-toggle="modal" data-target="#myModal"> <?php echo lang('cancel_reservation'); ?></a>
								
								</div>
								<?php } else { ?>
								<div class="col-md-6 col-sm-6 col-xs-3">
									
									<b style="float: right;"><?php echo lang('status'); ?> : </b>
								
								</div>
								<div class="col-md-6 col-sm-6 col-xs-3">									
									<b><?php echo lang('canceled'); ?>								</b>
								</div>
							<?php } ?>

								<div id="myModal" class="modal fade" role="dialog">
								  <div class="modal-dialog">

								    <!-- Modal content-->
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title"><?php echo lang('cancel_reservation'); ?></h4>
								     </div>
								      <div class="modal-body">

									        <?php 
									        $date1 = date("Y-m-d H:i:s");
											$date2 = strtotime($reserve_date.' '.$reserve_time);
    										$date2 = date("Y-m-d H:i:s" , $date2);

											$seconds = strtotime($date2) - strtotime($date1);
											$datetime1 = new DateTime($date1);
											$datetime2 = new DateTime($date2);
											$interval = $datetime1->diff($datetime2);											
											$cancel_hours = round($seconds / 60 / 60,2);
											 if($cancel_hours >= 24){
											 $cancel_days = round($cancel_hours/24,2);
											}else{
												$cancel_days = 0;
											 // echo $date1.'<br>';
											}
											$count = count(json_decode($cancellation_charge));
											$cancellation_charge=json_decode($cancellation_charge);
											$cancellation_period = explode('-', $cancellation_period);
											$cancellation_time=json_decode($cancellation_period[0]);
											$cancellation_period=json_decode($cancellation_period[1]);



											
												if($cancel_days!=0){
													for ($i=0; $i <= $count ; $i++) {

														$time[$i] = $cancellation_time[$i];
														$charge[$i] = $cancellation_charge[$i];
														$period[$i] = $cancellation_period[$i];
														if(($time[$i]=='day') && ($period[$i]>$cancel_days)){
															echo '<b>'.lang('reservaion_time').' </b>: '. $date2.'<br>';
															echo '<b>'.lang('current_time').' </b>: ' .$date1. '<br>';
															
															if($period[$i-1]==''){
																$period[$i-1] = 0;
																$charge[$i-1] = $charge[$i];
															}
															echo '<b>'.lang('cancel_charge').' </b>: '. $charge[$i-1].' %<br>';
															echo '<b>'.lang('cancel_period').' </b>: '. $period[$i-1].' '.$time[$i-1].' - '. $period[$i].' '.$time[$i].'   <br>';
															echo '<b>'.lang('amount_paid').' </b>: '. $this->currency->format(round($total_amount,2)).'<br>';
															$ref = $total_amount - ($total_amount * $charge[$i-1] / 100);
															$refund_amount = $this->currency->format(round( $ref, 2));
															echo '<b>'.lang('amount_to_refund').' </b>: '.$refund_amount;
															$i = $count+1;
														}
													}
												}else{
														$cnt = 0;
														for ($i=0; $i <= $count ; $i++) {
															$time[$i] = $cancellation_time[$i];
															$charge[$i] = $cancellation_charge[$i];
															$period[$i] = $cancellation_period[$i];
															if($time[$i]=='hour'){
																$cnt++;
															}
															if(($time[$i]=='hour') && ($period[$i]>=$cancel_hours)){
																echo '<b>'.lang('reservaion_time').' </b>: '. $date2.'<br>';
																echo '<b>'.lang('current_time').'  </b>: ' .$date1. '<br>';
																
																if($period[$i-1]==''){
																	$period[$i-1] = 0;
																	$charge[$i-1] = $charge[$i];
																}
																echo '<b>'.lang('cancel_charge').' </b>: '. $charge[$i-1].' %<br>';
																echo '<b>'.lang('cancel_period').' </b>: '. $period[$i-1].' '.$cancellation_time[$i-1].' - '.$period[$i].' '.$cancellation_time[$i].' <br>';
																echo '<b>'.lang('amount_paid').' </b>: '. $this->currency->format(round($total_amount,2)).'<br>';
																$ref = $total_amount - ($total_amount * $charge[$i-1] / 100);
																$refund_amount = $this->currency->format(round( $ref, 2));
																echo '<b>'.lang('amount_to_refund').' </b>: '.$refund_amount;
																$i = $count+1;
															}
															else{
																if($i==$cnt){
																	echo '<b>'.lang('reservaion_time').'</b>: '. $date2.'<br>';
																echo '<b>'.lang('current_time').' </b>: ' .$date1. '<br>';
																
																if($period[$i-1]==''){
																	$period[$i-1] = 0;
																	$charge[$i-1] = $charge[$i];
																}
																echo '<b>'.lang('cancel_charge').' </b>: '. $charge[$i-1].' %<br>';
																echo '<b>'.lang('cancel_period').'  </b>: '. $period[$i-1].' '.$cancellation_time[$i-1].' - '.$period[$i].' '.$cancellation_time[$i].' <br>';
																echo '<b>'.lang('amount_paid').' </b>: '. $this->currency->format(round($total_amount,2)).'<br>';
																$ref = $total_amount - ($total_amount * $charge[$i-1] / 100);
																$refund_amount = $this->currency->format(round( $ref, 2));
																echo '<b>'.lang('amount_to_refund').'</b>: '.$refund_amount;
																$i = $count+1;
																}
															}
														}
											
											}
											
											
									        ?>
									        <br />
								        <form action="" method="post" class="text-center" >
								        	<div><b>Enter Unique code(Sent in Email / SMS)</b></div><br />
								        	<input type="hidden" name="refund_amount" value="<?php echo $refund_amount;?>">
								        	<div><input type="text" name="uniqueid" value="" class="form-control"></div><br />
								        	<div><input type="submit" name="confirm" class="btn btn-primary" value="Confirm Cancellation"></div>
								        </form>
								      </div>
								      <div class="modal-footer">
								      	<span><?php echo lang('kindly_check'); ?> <a href="<?php echo site_url().'account/cancel_policy?loc_id='.$location_id; ?>"><?php echo lang('cancel_policy'); ?></a> <?php echo lang('for_detail'); ?>
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      </div>
								    </div>

								  </div>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
 <script>

$('.alert-danger').delay(3000).fadeOut();
$('.alert-success').delay(3000).fadeOut();
 </script>
<?php echo get_footer(); ?>