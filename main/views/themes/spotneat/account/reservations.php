<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
<?php if ($this->alert->get()) {?>
    <div id="notification">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->alert->display(); ?>
                </div>
            </div>
        </div>
    </div>
<?php }?>
</div>
<div id="page-content" style="background-color: #fdcec0 !important;">
	<div class="container">
		<div class="col-md-12 col-sm-12 col-xs-12 content_bacg after-log-top-space">
			<div class="row top-spacing">
			<?php echo get_partial('content_left'); ?>
			<?php
if (partial_exists('content_left') AND partial_exists('content_right')) {
	$class = "col-sm-6 col-md-6 col-xs-3";
} else if (partial_exists('content_left') OR partial_exists('content_right')) {
	$class = "col-sm-12 col-md-12 col-xs-12";
} else {
	$class = "col-md-12 col-xs-3 col-sm-12";
}
?>
			<div class="col-md-9 col-sm-9 col-xs-12 no-pad">
			<div class="<?php echo $class; ?> content_inn_wrap">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?php echo lang('column_id'); ?></th>
									<th><?php echo lang('column_status'); ?></th>
									<th><?php echo lang('column_location'); ?></th>
									<th><?php echo lang('column_date'); ?></th>
									<th><?php echo lang('column_table'); ?></th>
									<th><?php echo lang('column_guest'); ?></th>
									<th><?php echo lang('column_review'); ?></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php if ($reservations) {
	?>
								<?php foreach ($reservations as $reservation) {?>
								<tr>
									<td><a href="<?php echo $reservation['view']; ?>"><?php echo $reservation['reservation_id']; ?></a></td>
									<td><?php echo $reservation['status_name']; ?></td>
									<td><?php echo lang_trans($reservation['location_name'], $reservation['location_name_ar']); ?></td>
									<td><?php echo $reservation['reserve_time']; ?> - <?php echo $reservation['reserve_date']; ?></td>
									<td><?php echo $reservation['table_name']; ?></td>
									<td><?php echo $reservation['guest_num']; ?></td>
									<td>
										<?php
if ($reservation['status_name'] == 'Completed') {
		if ($reservation['review_status'] == 1) {?>
										<a title="<?php echo lang('text_leave_review'); ?>" href="<?php echo $reservation['leave_review']; ?>"><i class="fa fa-heart"></i></a>
										<?php } else {?>
										<a title="<?php echo lang('text_leave_review'); ?>" href="<?php echo $reservation['leave_review']; ?>"><i class="fa fa-heart-o"></i></a>
										<?php }}?>
									</td>
									<td>
									<?php
$date1 = date("Y-m-d H:i:s");
		$date2 = strtotime($reservation['reserve_date'] . ' ' . $reservation['reserve_time']);
		$date2 = date("Y-m-d H:i:s", $date2);

		$seconds = strtotime($date2) - strtotime($date1);
		$cancel_hours = $seconds / 60 / 60;
		$cancel_days = $cancel_hours / 24;
		if (($reservation['status_name'] != 'Canceled') && ($cancel_hours > 0) && ($cancel_days > 0)) {
			?>

									<input type="button" id="can_res<?php echo $reservation['reservation_id']; ?>" name="can_res<?php echo $reservation['reservation_id']; ?>" class="btn-primary btn-sm" value="<?php echo lang('cancel'); ?>" >

									<div class="modal fade" tabindex="-1" role="dialog" id="myModal<?php echo $reservation['reservation_id']; ?>">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title"><?php echo lang('reserve_cancel_confirm'); ?></h4>
									      </div>
									      <div class="modal-body">
									        <p><?php echo lang('are_you_sure_cancel') . $reservation['reservation_id']; ?> ? <br />
									        	<?php echo lang('cannot_be_undone'); ?>
									        	<br /><br />
									        <?php
$order_price = $reservation['order_price'];
			$count = $reservation['cancel_count'];
			$total_amount = $reservation['total_amount'] - $reservation['reward_used_amount'];

			$date1 = date("Y-m-d H:i:s");
			$date2 = strtotime($reservation['reserve_date'] . ' ' . $reservation['reserve_time']);
			$date2 = date("Y-m-d H:i:s", $date2);

			$seconds = strtotime($date2) - strtotime($date1);
			/*$datetime1 = new DateTime($date1);
											$datetime2 = new DateTime($date2);
											$interval = $datetime1->diff($datetime2);
											print_r($interval);*/
			$cancel_hours = round($seconds / 60 / 60, 2);
			if ($cancel_hours >= 24) {
				$cancel_days = round($cancel_hours / 24, 2);
			} else {
				$cancel_days = 0;
				// echo $date1.'<br>';
			}

			if ($order_price != '0') {
				if ($reservation['refund_status'] == '1') {
					if ($cancel_days != '0') {
						for ($i = 0; $i <= $count; $i++) {

							$time[$i] = $reservation['cancellation_time'][$i];
							$charge[$i] = $reservation['cancellation_charge'][$i];
							$period[$i] = $reservation['cancellation_period'][$i];
							if (($time[$i] == 'day') && ($period[$i] > $cancel_days)) {
								echo '<b>' . lang('reservation_time') . '</b>: ' . $date2 . '<br>';
								echo '<b>' . lang('current_time') . '</b>: ' . $date1 . '<br>';

								if ($period[$i - 1] == '') {
									$period[$i - 1] = 0;
									$charge[$i - 1] = $charge[$i];
								}
								echo '<b>' . lang('cancel_charge') . ' </b>: ' . $charge[$i - 1] . ' %<br>';
								echo '<b>' . lang('cancel_period') . ' </b>: ' . $period[$i - 1] . ' ' . $reservation['cancellation_time'][$i - 1] . ' - ' . $period[$i] . ' ' . $reservation['cancellation_time'][$i] . '   <br>';
								echo '<b>' . lang('amount_paid') . ' </b>: ' . $this->currency->format(round($total_amount, 2)) . '<br>';
								$ref = $total_amount - ($total_amount * $charge[$i - 1] / 100);
								$refund_amount = $this->currency->format(round($ref, 2));
								$cancel_percent = $charge[$i - 1];
								echo '<b>' . lang('amount_to_refund') . '</b>: ' . $refund_amount;
								$i = $count + 1;
							}
						}
					} else {
						$cnt = 0;
						for ($i = 0; $i <= $count; $i++) {
							$time[$i] = $reservation['cancellation_time'][$i];
							$charge[$i] = $reservation['cancellation_charge'][$i];
							$period[$i] = $reservation['cancellation_period'][$i];
							if ($time[$i] == 'hour') {
								$cnt++;
							}
							if (($time[$i] == 'hour') && ($period[$i] >= $cancel_hours)) {
								echo '<b>' . lang('reservation_time') . ' </b>: ' . $date2 . '<br>';
								echo '<b>' . lang('current_time') . '</b>: ' . $date1 . '<br>';

								if ($period[$i - 1] == '') {
									$period[$i - 1] = 0;
									$charge[$i - 1] = $charge[$i];
								}
								echo '<b>' . lang('cancel_charge') . '</b>: ' . $charge[$i - 1] . ' %<br>';
								echo '<b>' . lang('cancel_period') . '</b>: ' . $period[$i - 1] . ' ' . $reservation['cancellation_time'][$i - 1] . ' - ' . $period[$i] . ' ' . $reservation['cancellation_time'][$i] . ' <br>';
								echo '<b>' . lang('amount_paid') . ' </b>: ' . $this->currency->format(round($total_amount, 2)) . '<br>';
								$ref = $total_amount - ($total_amount * $charge[$i - 1] / 100);
								$refund_amount = $this->currency->format(round($ref, 2));
								$cancel_percent = $charge[$i - 1];
								echo '<b>' . lang('amount_to_refund') . ' </b>: ' . $refund_amount;
								$i = $count + 1;
							} else {
								if ($i == $cnt) {
									echo '<b>' . lang('reservation_time') . ' </b>: ' . $date2 . '<br>';
									echo '<b>' . lang('current_time') . '</b>: ' . $date1 . '<br>';

									if ($period[$i - 1] == '') {
										$period[$i - 1] = 0;
										$charge[$i - 1] = $charge[$i];
									}
									echo '<b>' . lang('cancel_charge') . '</b>: ' . $charge[$i - 1] . ' %<br>';
									echo '<b>' . lang('cancel_period') . '</b>: ' . $period[$i - 1] . ' ' . $reservation['cancellation_time'][$i - 1] . ' - ' . $period[$i] . ' ' . $reservation['cancellation_time'][$i] . ' <br>';
									echo '<b>' . lang('amount_paid') . ' </b>: ' . $this->currency->format(round($total_amount, 2)) . '<br>';
									$ref = $total_amount - ($total_amount * $charge[$i - 1] / 100);
									$refund_amount = $this->currency->format(round($ref, 2));
									$cancel_percent = $charge[$i - 1];
									echo '<b>' . lang('amount_to_refund') . ' </b>: ' . $refund_amount;
									$i = $count + 1;
								}
							}
						}
					}?>
													<br><br> <?php echo lang('kindly_check'); ?> <a href="cancel_policy?loc_id=<?php echo $reservation['location_id']; ?>" target="_blank"><?php echo lang('cancel_policy'); ?></a> <?php echo lang('for_detail'); ?>.
												<?php } else {

					echo '<b>' . lang('amount_to_refund') . ' </b>: ' . $this->currency->format($total_amount);
					$cancel_percent = 0;
				}
			} else {

				echo '<b>' . lang('table_book_cancel') . '</b>';

			}

			?>

									        </p>
									      </div>
									      <div class="modal-footer">
									      <form method="post" enctype="multipart/form-data" name="cancel_reservation<?php echo $reservation['reservation_id']; ?>" id="cancel_reservation<?php echo $reservation['reservation_id']; ?>">

									      	<?php
$ref_amount = explode(' ', $refund_amount);
			$refund_amount = $ref_amount[1];
			if ($refund_amount == '' || $refund_amount < 0) {
				$refund_amount = '0';
			}
			?>
											<input type="hidden" name="reservation_id" value="<?php echo $reservation['reservation_id']; ?>">
											<input type="hidden" name="before_status_name" value="<?php echo $reservation['status_name']; ?>">
											<input type="hidden" name="refund_amount" value="<?php echo $refund_amount; ?>">
											<input type="hidden" name="cancel_percent" value="<?php echo $cancel_percent; ?>">
											<input type="hidden" name="curren_status" value="Canceled">
									        <button type="button" class="btn" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
									        <button type="submit" class="btn btn-primary" id="submit<?php echo $reservation['reservation_id']; ?>" name="submit<?php echo $reservation['reservation_id']; ?>" ><?php echo lang('ok'); ?></button>
									        </form>
									      </div>
									    </div><!-- /.modal-content -->
									  </div><!-- /.modal-dialog -->
									</div><!-- /.modal -->
									<script type="text/javascript">


									$('#can_res<?php echo $reservation['reservation_id']; ?>').click(function(e){
										$('#myModal<?php echo $reservation['reservation_id']; ?>').modal('show');
									     e.preventDefault();
									     return false;
									});
									$('#submit<?php echo $reservation['reservation_id']; ?>').click(function(){
										$('#myModal<?php echo $reservation['reservation_id']; ?>').modal('hide');
									    $('#cancel_reservation<?php echo $reservation['reservation_id']; ?>').submit();
									    return true;
									});


									</script>
									<?php }?>
									</td>
								</tr>
								<?php }?>
							<?php } else {?>
								<tr>
									<td colspan="7"><?php echo lang('text_empty'); ?></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						</div>
					</div>

					<div class="col-md-12">
						<div class="buttons col-xs-3 wrap-none">
							<!-- <a class="text-right" href="<?php echo $back_url; ?>"><?php //echo lang('button_back'); ?></a> -->
							<a class="text-center" href="<?php echo site_url() . 'locations'; ?>"><?php echo lang('button_reserve'); ?></a>
						</div>

						<div class="col-sm-6 col-xs-12 col-md-6">
							<div class="pagination-bar text-right">
								<div class="links"><?php echo $pagination['links']; ?></div>
								<div class="info"><?php echo $pagination['info']; ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
		</div>
	</div>
</div>


<?php echo get_footer(); ?>