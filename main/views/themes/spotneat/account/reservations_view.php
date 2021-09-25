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
		<div class="col-md-12 col-sm-12 col-xs-12 content_bacg after-log-top-space" >

		<div class="row top-spacing">
			<?php echo get_partial('content_left'); ?>
			<?php
if (partial_exists('content_left') AND partial_exists('content_right')) {
	$class = "col-sm-6 col-md-6 col-xs-12";
} else if (partial_exists('content_left') OR partial_exists('content_right')) {
	$class = "col-sm-12 col-md-12 col-xs-12";
} else {
	$class = "col-md-12 col-xs-3 col-sm-12";
}
?>
			<div class="col-md-9 col-sm-9 col-xs-12 ">
			<div class="<?php echo $class; ?> list-group-item" >
				<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>">
					<div class="reservation-lists row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-none">
									<tr>
										<td><b><?php echo lang('column_id'); ?>:</b></td>
										<td><?php echo $reservation_id; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_status'); ?>:</b></td>
										<td><?php echo $status_name; ?></td>
									</tr>
									<?php if ($status_name == 'Canceled' && $order_id != '0') {
	?>
									<tr>
										<td><b><?php echo lang('column_refund_status'); ?>:</b></td>
										<td style="text-transform: capitalize;"><?php echo $refund_status; ?></td>
									</tr>
									<tr>
										<td>
											<div class="row">
												<div class="col-sm-12 ">
												<div class="tooltips col-sm-12 padd-none">
												  <span class="tooltiptext col-xs-12 padd-none">


												  	<?php

	echo '<table width="600" class="col-xs-12 col-sm-12 col-md-12"><tr><td class="policy_label">' . lang('total_amount') . ' : </td><td class="policy_content"> ' . $this->currency->format($total_amount) . '</tr>';
	echo '<tr><td colspan="2"><hr></td></tr>';
	echo '<tr><td class="policy_label">' . lang('reservation_time') . ' :  </td><td class="policy_content"> ' . $reserve_time . ' ' . $reserve_date . '</td></tr>';
	echo '<tr><td colspan="2"><hr></td></tr>';
	echo '<tr><td class="policy_label">' . lang('cancellation_time') . ' :  </td><td class="policy_content">' . $cancellation_time . '</td></tr>';
	echo '<tr><td colspan="2"><hr></td></tr>';
	echo '<tr><td class="policy_label">' . lang('cancel_percent') . ' : </td><td class="policy_content">' . $cancel_percent . '%</td></tr>';
	echo '<tr><td colspan="2"><hr></td></tr>';
	echo '<tr><td class="policy_label">' . lang('column_refund_amount') . ' : </td><td class="policy_content">' . $this->currency->format($refund_amount) . '</td></tr></table>';

	?>

												  </span>
												  <b><?php echo lang('column_refund_amount'); ?>:</b>
												  <i class="fa fa-info-circle padd-left" aria-hidden="true"></i>
												</div>
												</div>
												  	</div>

										</td>
										<td>
											<?php echo $this->currency->format($refund_amount); ?>
										</td>
									</tr>

									<?php }?>
									<tr>
										<td><b><?php echo lang('column_unique'); ?>:</b></td>
										<td><?php echo $otp; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_date'); ?>:</b></td>
										<td><?php echo $reserve_time; ?> - <?php echo $reserve_date; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_table'); ?>:</b></td>
										<td><?php echo $table_name; ?></td>
									</tr>
									<!-- <tr>
										<td><b><?php echo lang('column_table_price'); ?>:</b></td>
										<td><?php echo $this->currency->format($table_price); ?></td>
									</tr> -->
									<tr>
										<td><b><?php echo lang('column_guest'); ?>:</b></td>
										<td><?php echo $guest_num; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_location'); ?>:</b></td>
										<td><?php echo lang_trans($location_name, $location_name_ar); ?><br /><?php echo lang_trans($location_address, $location_address_ar); ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_occasion'); ?>:</b></td>
										<td><?php echo $occasions[$occasion_id]; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_name'); ?>:</b></td>
										<td><?php echo $first_name; ?> <?php echo $last_name; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_email'); ?>:</b></td>
										<td><?php echo $email; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_telephone'); ?>:</b></td>
										<td><?php echo $telephone; ?></td>
									</tr>
									<!-- <tr>
										<td><b><?php //echo lang('column_comment'); ?>:</b></td>
										<td><?php //echo $comment; ?></td>
									</tr> -->
								</table>
							</div>
						</div>
						<?php if ($order_id != 0) {?>
							<div class="col-md-12">
								<h3><i><b><?php echo lang('text_note'); ?> : </b><a href="../../orders/view/<?php echo $order_id . '?reservation_id=' . $reservation_id . '&table_price=' . $table_price; ?>" > <?php echo lang('text_here'); ?></a><?php echo lang('text_food_order'); ?></h3>
							</div>
						<?php }?>


						<div class="col-md-12">
							<div class="buttons">
								<!-- <a  href="<?php //echo site_url().'account/reservations'; ?>"><button class="btn btn-primary btn-sm"> <?php //echo lang('button_back'); ?></button></a> -->
							</div>
						</div>
					</div>
				</form>
			</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>