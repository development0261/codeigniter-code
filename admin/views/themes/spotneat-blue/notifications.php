<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Push Notifications</h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border">
						<thead>
							<tr>								
								<th>Title</th>
								<th>Message</th>
								<th>Send To</th>	
								<th>Schedule Type</th>								
								<th>Schedule Date</th>
								<th>Recurring Cron Start</th>
								<th>Recurring Cron End</th>
								<th>Recurring Type</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							// echo "<pre>";print_r($notificationSql->result());
						
							if (!empty($notificationsSql)) {
								 foreach ($notificationsSql as $notification) { ?>
							<tr>								
								<td><?php echo $notification['title']; ?></td>
								<td><?php echo $notification['message']; ?></td>	
								<td><?php echo str_replace('_', ' ', $notification['sent_to']); ?></td>							
								<td><?php echo $notification['schedule_type']; ?></td>
								<td><?php echo $notification['schedule_date'] != '0000-00-00 00:00:00'?$notification['schedule_date']:''; ?></td>
								<td><?php echo $notification['recurring_start_date']  != '0000-00-00 00:00:00'?$notification['recurring_start_date']:''; ?></td>
								<td><?php echo $notification['recurring_end_date']  != '0000-00-00 00:00:00'?$notification['recurring_end_date']:''; ?></td>
								<td><?php echo $notification['recurring_type']; ?></td>
								<td><?php echo $notification['sent']; ?></td>
							</tr>
							<?php } 
						     } else {?>
							<tr>
								<td colspan="3"><?php echo lang('text_empty'); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>