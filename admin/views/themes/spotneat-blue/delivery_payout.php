<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_title') ?></h3>
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
                                            <input type="hidden" name="id" value="<?php echo set_value('id', $filter_search); ?>" />
                                        <?php } ?>

										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo set_value('filter_search', $filter_search); ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
								</div>
								<!-- <div class="col-md-8 pull-left">
									<div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_status'); ?></option>
											<?php if ($filter_status === '1') { ?>
												<option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> ><?php echo lang('text_enabled'); ?></option>
												<option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_disabled'); ?></option>
											<?php } else if ($filter_status === '0') { ?>
												<option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_enabled'); ?></option>
												<option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> ><?php echo lang('text_disabled'); ?></option>
											<?php } else { ?>
												<option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_enabled'); ?></option>
												<option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_disabled'); ?></option>
											<?php } ?>
										</select>
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
								</div> -->
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
							<th class="name sorter"><a class="sort" href="<?php echo $sort_name; ?>"><?php echo lang('partner_name'); ?> <i class="fa fa-sort-<?php echo ($sort_by === 'category_name') ? $order_by_active : $order_by; ?>"></i></a></th>
                            <th width="40%"><?php echo lang('partner_email'); ?> </th>
							
							<th class="text-center"><?php echo lang('wallet'); ?></th>
							<th class="text-center"><?php echo lang('request'); ?></th>
							<!-- <th class="text-center"><?php echo lang('debit'); ?></th> -->
							<!-- <th class="text-center"><?php echo lang('column_status'); ?></th> -->
							<th class="text-center"><?php echo lang('actions'); ?></th>

						</tr>
					</thead>
					<tbody>
						<?php if ($payout) { ?>
						<?php foreach ($payout as $pay) { ?>
						<tr>
							<td><?php echo $pay['first_name']; ?></td>
                            <td><?php echo $pay['email']; ?></td>
                            <td class="text-center"><?php echo $pay['wallet'] > 0 ? number_format($pay['wallet'],2): '-'; ?></td>
                            <td class="text-center"><?php echo $pay['pending_amount'] > 0 ? number_format($pay['pending_amount'],2): '-'; ?></td>
                            <!-- <td class="text-center"><?php echo $pay['wallet'] < 0 ? $pay['wallet'] : '-'; ?></td> -->
							<!-- <td class="text-center"><?php echo $pay['status'] == '1' ? 'Active' : 'Inactive'; ?></td> -->
							<td class="text-center">
								
								<?php if ($pay['pending_amount'] > 0 && $pay['bank_name'] != '' && $pay['account_number'] != ''  && $pay['routing_number'] != '' ) { ?>
									<!-- <a href="delivery_payout/pay_to_bank?id=<?php echo $pay['delivery_id']; ?>" class="btn btn-info" title="Pay to bank"><i class="fa fa-money"></i></a> -->
									
									<a href="delivery_payout/pending?id=<?php echo $pay['delivery_id']; ?>" class="btn btn-info" title="Pending"><i class="fa fa-money"></i></a>

								<?php } ?>
								<a href="delivery_payout/completed?id=<?php echo $pay['delivery_id']; ?>" class="btn btn-info" title="Completed"><i class="fa fa-history"></i></a>
								
							</td>
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