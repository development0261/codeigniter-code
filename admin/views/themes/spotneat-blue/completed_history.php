<?php echo get_header();
 ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('completed_history').' - '.$username?></h3>
				<div class="pull-right">
					<button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
				</div>
			</div>
			<div class="panel-body panel-filter">
				<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								<div class="col-md-3 pull-right text-right">
									<div class="form-group">
										<?php if($deliver_id != ""){ ?>
                                            <input type="hidden" name="id" value="<?php echo set_value('id', $deliver_id); ?>" />
                                        <?php } ?>
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo set_value('filter_search', $filter_search); ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
								</div>
								<div class="col-md-8 pull-left">
									<div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											
											<?php if ($filter_status == '') { ?>
												<option value="view_all" <?php echo set_select('filter_status', 'View All',TRUE); ?> ><?php echo lang('view_all'); ?></option>
												<option value="rejected" <?php echo set_select('filter_status', 'rejected'); ?> ><?php echo lang('rejected'); ?></option>
												<option value="completed" <?php echo set_select('filter_status', 'completed'); ?> ><?php echo lang('completed'); ?></option>
												
											<?php }?>
											<?php if ($filter_status == 'rejected') { ?>
												<option value="view_all" <?php echo set_select('filter_status', 'View All'); ?> ><?php echo lang('view_all'); ?></option>
												<option value="rejected" <?php echo set_select('filter_status', 'rejected',TRUE); ?> ><?php echo lang('rejected'); ?></option>
												<option value="completed" <?php echo set_select('filter_status', 'completed'); ?> ><?php echo lang('completed'); ?></option>
												
											<?php }?>
											<?php if ($filter_status == 'completed') { ?>
												<option value="view_all" <?php echo set_select('filter_status', 'View All'); ?> ><?php echo lang('view_all'); ?></option>
												<option value="rejected" <?php echo set_select('filter_status', 'rejected'); ?> ><?php echo lang('rejected'); ?></option>
												<option value="completed" <?php echo set_select('filter_status', 'completed',TRUE); ?> ><?php echo lang('completed'); ?></option>
												
											<?php }?>
										</select>
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url().'?id='.$deliver_id?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
				<table class="table table-striped table-border">
					<thead>
						<tr>
							<th class="name sorter"><a class="sort" href="<?php echo $sort_name; ?>"><?php echo lang('invoice_no'); ?> <i class="fa fa-sort-<?php echo ($sort_by === 'category_name') ? $order_by_active : $order_by; ?>"></i></a></th>
                            
							<th class="text-center"><?php echo lang('request_amount'); ?></th>
							<th class="text-center"><?php echo lang('request_date'); ?></th>
							<th class="text-center"><?php echo lang('status'); ?></th>

						</tr>
					</thead>
					<tbody>
						<?php if ($payout) { ?>
						<?php foreach ($payout as $pay) { ?>
						<tr>
							<td><?php echo $pay['invoice_id']; ?></td>
                            <td class="text-center"><?php echo $pay['amount'] > 0 ? number_format($pay['amount'],2) : '-'; ?></td>
                            <td class="text-center"><?php echo $pay['date'] > 0 ? $pay['date'] : '-'; ?></td>
                            <td class="text-center"><?php
                             echo $pay['status'] == 'rejected' ? 'Rejected' : 'Completed'; ?></td>							
						</tr>

						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="7"><?php echo lang('text_payout'); ?></td>
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
//--></script>
<?php echo get_footer(); ?>