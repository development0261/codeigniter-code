<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_heading'); ?>
				<!-- <span><small><a href="<?php //echo site_url().'reservations' ; ?>">Show all</a></small></span>  -->
			</h3>
				<div class="pull-right">
					<button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
				</div>
			</div>
			<?php if ($show_calendar) { ?>
				<div class="panel-footer">
					<div class="legends">
						<span class="no_booking"></span>&nbsp; <?php echo lang('text_no_booking'); ?> &nbsp;&nbsp;
						<span class="half_booked"></span>&nbsp; <?php echo lang('text_half_booking'); ?> &nbsp;&nbsp;
						<span class="booked"></span>&nbsp; <?php echo lang('text_fully_booked'); ?>
					</div>
				</div>
			<?php } ?>
			<div class="panel-body panel-filter">
				<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo $filter_url; ?>">
					
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								
								

								<div class="col-md-9 ">
									<form action="" method="post" enctype="">
									<div class="col-md-12">
										

											<div class="form-group">
											<select name="filter_location" class="form-control input-sm" class="form-control input-sm" onchange="showTables(this.value)">
												<option value=""><?php echo lang('text_filter_location'); ?></option>
												<?php foreach ($locations as $location) { ?>
													<?php if ($location['location_id'] === $filter_location) { ?>
														<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
											</div>

										
											<div class="form-group">
											<select name="filter_table" class="form-control input-sm" class="form-control input-sm"  id="show_tables">
												<option value=""><?php echo lang('text_filter_tables'); ?></option>

											</select>
											</div>
											<?php //$srcdate = '' ? $srcdate : date('m/d/Y'); ?>
											<input type="text" name="srcdate" id="datepicker" class="form-control input-sm" autocomplete="off" value="<?php echo $srcdate; ?>" placeholder="dd/mm/yyyy" >
										
											<input type="submit" name="search_filter" value="Find Table" class="btn btn-primary">
										
									</div>
									</form>
									<br><br>
									<div class="col-md-12">
									<?php if (!$user_strict_location && empty($vendor_id)) { ?>
										<div class="form-group">
											<select name="filter_location" class="form-control input-sm" class="form-control input-sm">
												<option value=""><?php echo lang('text_filter_location'); ?></option>
												<?php foreach ($locations as $location) { ?>
													<?php if ($location['location_id'] === $filter_location) { ?>
														<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>&nbsp;
										</div>
									<?php } ?>
									<div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											<option value="all"><?php echo lang('text_filter_status'); ?></option>
											<?php foreach ($statuses as $status) { ?>
											<?php if ($status['status_code'] === $filter_status) { ?>
												<option value="<?php echo $status['status_code']; ?>" <?php echo set_select('filter_status', $status['status_code'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $status['status_code']; ?>" <?php echo set_select('filter_status', $status['status_code']); ?> ><?php echo $status['status_name']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>&nbsp;
									</div>
									<?php if (!$show_calendar) { ?>
									<div class="form-group">
										<select name="filter_date" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_date'); ?></option>
											<?php foreach ($reserve_dates as $key => $value) { ?>
											<?php if ($key === $filter_date) { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
									<?php } else { ?>
									<div class="form-group">
										<select name="filter_month" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_month'); ?></option>
											<?php foreach ($months as $key => $value) { ?>
											<?php if ($key == $filter_month) { ?>
												<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_year" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_year'); ?></option>
											<?php foreach ($years as $key => $value) { ?>
											<?php if ($value == $filter_year) { ?>
												<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
									<?php } ?>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
									<?php if($show != ""){ ?>
									<a class="btn btn-grey" href="<?php echo page_url()."?show=all"; ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>	
									<?php } else{?>	
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
									<?php }?>	
								</div>
							</div>
								<div class="col-md-3 ">
									<div class="form-group">
										
										<?php if($vendor_id != ""){ ?>
											<input type="hidden" name="id" value="<?php echo $vendor_id; ?>" />
										<?php }  if($show != ""){ ?>
											<input type="hidden" name="show" value="all" />
										<?php } ?> 	
										<input type="hidden" name="show_calendar" value="<?php echo $show_calendar; ?>" />

										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<?php if ($show_calendar) { ?>
					<div class="table-responsive">
						<?php echo $calendar; ?>
					</div>
				<?php } ?>

				<div class="table-responsive">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
								<th class="id"><a class="sort" href="<?php echo $sort_id; ?>"><?php echo lang('column_id'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'reservation_id') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_location; ?>"><?php echo lang('column_location'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_customer; ?>"><?php echo lang('column_customer_name'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'first_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_guest; ?>"><?php echo lang('column_guest'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'guest_num') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_table; ?>"><?php echo lang('column_table'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'table_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_status; ?>"><?php echo lang('column_status'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'status_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><?php echo lang('column_otp'); ?></th>
								<th class="text-center"><a class="sort" href="<?php echo $sort_date; ?>"><?php echo lang('column_time_date'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'reserve_date') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th class="text-center"><a class="sort" href="<?php echo $sort_booking; ?>"><?php echo lang('column_bookingon'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'booking_date') ? $order_by_active : $order_by; ?>"></i></a></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($reservations) { ?>
							<?php foreach ($reservations as $reservation) { ?>
							<tr>
								<td class="action"><input type="checkbox" value="<?php echo $reservation['reservation_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
									<a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $reservation['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
								<td><?php echo $reservation['reservation_id']; ?></td>
								<td><?php echo $reservation['location_name']; ?></td>
								<td><?php echo $reservation['first_name'] .' '. $reservation['last_name']; ?></td>
								<td><?php echo $reservation['guest_num']; ?></td>
								<td><?php echo $reservation['table_name']; ?></td>
                                <td><span class="label label-default" style="background-color: <?php echo $reservation['status_color']; ?>;"><?php echo $reservation['status_name']; ?></span></td>
                                <td><?php echo $reservation['otp']; ?></td>
								<td class="text-center"><?php echo $reservation['reserve_time']; ?> - <?php echo $reservation['reserve_date']; ?></td>
								<td class="text-center"><?php echo $reservation['added_date']; ?></td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td colspan="9"><?php echo lang('text_empty'); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>

			<div class="pagination-bar clearfix">
				<div class="links"><?php echo $pagination['links']; ?></div>
				<div class="info"><?php echo $pagination['info']; ?></div>
			</div>

			
		</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}

function showTables(str)
{
	//console.log(str);
$.ajax({
 type: 'post',
 url: 'tables_report/show_tables',
 data: {
  get_option:str
 },
 success: function (response) {
 //console.log(response);
  document.getElementById("show_tables").innerHTML=response; 
 }
 });
}
$( function() {
	    	$( "#datepicker" ).datepicker({
				autoclose:true,
				format:'dd-mm-yyyy'
				
			});
    
  		});
//--></script>
<?php echo get_footer(); ?>