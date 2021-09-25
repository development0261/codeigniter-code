<div class="col-xs-12 wrap-none wrap-bottom padd-none">
	<div class="col-xs-12 col-sm-6 padd-none">
		<?php if ($working_hours) { ?>
			<div class="panel-default panel-nav-tabs">
						<h1 class="about-heading"><?php echo lang('text_opening_hours'); ?></h1>
						<?php /* if ($has_delivery) { ?>
							<li><a href="#delivery-hours" data-toggle="tab"><?php echo lang('text_delivery_hours'); ?></a></li>
						<?php } ?>
						<?php if ($has_collection) { ?>
							<li><a href="#collection-hours" data-toggle="tab"><?php echo lang('text_collection_hours'); ?></a></li>
						<?php } */ ?>

					
				
				
					<div class="padd-none">
						<?php foreach (array('opening') as $type) { ?>
							<div id="<?php echo $type ?>-hours" class="tab-pane fade <?php echo ($type === 'opening') ? 'in active': ''; ?>">
								<div class="list-group">
									<?php if (!empty($working_hours[$type])) { ?>
										<?php foreach ($working_hours[$type] as $hour) { ?>
											<div class="list-group-item">
												<div class="row">
													<div class="col-xs-12 col-sm-4 col-md-4 "><?php echo $hour['day']; ?>:</div>
													<div class="col-xs-12 col-sm-8 col-md-8">
														<?php if (!empty($hour['status'])) echo sprintf(lang('text_working_hour'), $hour['open'], $hour['close']); ?>
														<br ><span class="small text-muted"><?php if (isset($hour['info']) AND $hour['info'] === 'closed') { echo lang('text_closed'); } else if (isset($hour['info']) AND $hour['info'] === '24_hours') { echo lang('text_24h'); }; ?></span>
													</div>
												</div>
											</div>
										<?php } ?>
									<?php } else if (empty($working_hours[$type])) { ?>
										<div class="list-group-item">
											<?php echo lang('text_same_as_opening_hours'); ?>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				
			</div>
		<?php } ?>
	</div>

	<div class="col-xs-12 col-sm-6 padd-none">
		<div class=" ">
			<div class="panel-body padd-none">
			<h1 class="about-heading">&nbsp;</h1>
				<div class="list-group">
					<?php if (!empty($working_type['opening']) AND $working_type['opening'] == '24_7' AND $opening_status != 'closed') { ?>
						<div class="list-group-item"><?php echo lang('text_opens_24_7'); ?></div>
					<?php } ?>
					<?php if ($has_delivery) { ?>
						<div class="list-group-item"><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_delivery_time'); ?></b><br />
							<?php if ($delivery_status === 'open') { ?>
								<?php echo sprintf(lang('text_in_minutes'), $delivery_time); ?>
							<?php } else if ($delivery_status === 'opening') { ?>
								<?php echo sprintf(lang('text_starts'), $delivery_time); ?>
							<?php } else { ?>
								<?php echo lang('text_closed'); ?>
							<?php } ?>
						</div>
					<?php } ?>
					<?php if ($has_collection) { ?>
						<div class="list-group-item"><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_collection_time'); ?></b><br />
							<?php if ($collection_status === 'open') { ?>
								<?php echo sprintf(lang('text_in_minutes'), $collection_time); ?>
							<?php } else if ($collection_status === 'opening') { ?>
								<?php echo sprintf(lang('text_starts'), $collection_time); ?>
							<?php } else { ?>
								<?php echo lang('text_closed'); ?>
							<?php } ?>
						</div>
					<?php } ?>
					<?php if ($has_delivery) { ?>
						<div class="list-group-item"><i class="fa fa-clock-o fa-fw"></i>&nbsp;<b><?php echo lang('text_last_order_time'); ?></b><br />
							<?php echo $last_order_time; ?>
						</div>
					<?php } ?>
					<?php if ($payments) { ?>
						<div class="list-group-item"><i class="fa fa-money fa-fw"></i>&nbsp;<b><?php echo lang('text_payments'); ?></b><br />
							<?php echo $payments; ?>.
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	
</div>

