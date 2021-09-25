<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
				<div class="pull-right">
					<button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
				</div>
			</div>
			<div class="panel-body panel-filter">
				<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								<!--<div class="col-md-3 pull-right text-right">
									<div class="form-group">
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
								</div>-->

								<div class="col-md-8 pull-left">
									<div class="form-group">
										<select name="filter_type" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_type'); ?></option>
										<?php if ($filter_type === 'complaint') { ?>
											<option value="complaint" <?php echo set_select('filter_type', 'complaint', TRUE); ?> ><?php echo lang('text_fixed_amount'); ?></option>
											<option value="suggestion" <?php echo set_select('filter_type', 'suggestion'); ?> ><?php echo lang('text_percentage'); ?></option>
											<option value="feedback" <?php echo set_select('filter_type', 'feedback'); ?> >Feedback</option>
										<?php } else if ($filter_type === 'suggestion') { ?>
											<option value="complaint" <?php echo set_select('filter_type', 'complaint'); ?> ><?php echo lang('text_fixed_amount'); ?></option>
											<option value="suggestion" <?php echo set_select('filter_type', 'suggestion', TRUE); ?> ><?php echo lang('text_percentage'); ?></option>
											<option value="feedback" <?php echo set_select('filter_type', 'feedback'); ?> >Feedback</option>
										<?php } else if ($filter_type === 'feedback') { ?>
											<option value="complaint" <?php echo set_select('filter_type', 'complaint'); ?> ><?php echo lang('text_fixed_amount'); ?></option>
											<option value="suggestion" <?php echo set_select('filter_type', 'suggestion'); ?> ><?php echo lang('text_percentage'); ?></option>
											<option value="feedback" <?php echo set_select('filter_type', 'feedback', TRUE); ?> >Feedback</option>
										<?php }  else { ?>
											<option value="complaint" <?php echo set_select('filter_type', 'complaint'); ?> ><?php echo lang('text_fixed_amount'); ?></option>
											<option value="suggestion" <?php echo set_select('filter_type', 'suggestion'); ?> ><?php echo lang('text_percentage'); ?></option>
											<option value="feedback" <?php echo set_select('filter_type', 'feedback'); ?> >Feedback</option>
										<?php } ?>
										</select>&nbsp;
									</div>
									<?php if($user_type == 11){ ?>
									<div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_status'); ?></option>
											<?php 
												foreach($restaurants_list as $avalue){

												if($filter_status === $avalue['location_id']){
											?>
												<option value="<?php echo $avalue['location_id']; ?>" selected><?php echo $avalue['location_name']; ?></option>
											<?php
												}else{
											?>

												<option value="<?php echo $avalue['location_id']; ?>"><?php echo $avalue['location_name']; ?></option>
											<?php
												}}
											?>
										<!--<?php if ($filter_status === '1') { ?>
											<option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> ><?php echo lang('text_enabled'); ?></option>
											<option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_disabled'); ?></option>
										<?php } else if ($filter_status === '0') { ?>
											<option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_enabled'); ?></option>
											<option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> ><?php echo lang('text_disabled'); ?></option>
										<?php } else { ?>
											<option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_enabled'); ?></option>
											<option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_disabled'); ?></option>
										<?php } ?>-->
										</select>
									</div>
									<?php } ?>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
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
							<!-- <th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th> -->
							<th><a class="sort" href="<?php echo $sort_name; ?>"><?php echo lang('column_username'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'name') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_location; ?>"><?php echo lang('column_restaurant'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'code') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_type; ?>"><?php echo lang('column_feedback_type'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'type') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th width="50%"><a class="sort" href="<?php echo $sort_message; ?>"><?php echo lang('column_feedback_message'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'discount') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($feedback) {?>
						<?php foreach ($feedback as $feed) { ?>
						<tr>
							<!-- <td class="action"><input type="checkbox" value="<?php //echo $coupon['coupon_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
								<a class="btn btn-edit" title="<?php //echo lang('text_edit'); ?>" href="<?php //echo $coupon['edit']; ?>"><i class="fa fa-pencil"></i></a></td> -->
							<td><?php echo $feed['username']; ?></td>
							<td><?php echo $feed['location_name']; ?></td>
							<td><?php echo ucfirst($feed['feedback_type']); ?></td>
							<td><?php echo $feed['feedback_message']; ?></td>
							<td><input type="button" name="view" Value="View More" class="view btn btn-primary" id="view<?php echo $feed['id']; ?>">
								<div class="modal fade" tabindex="-1" role="dialog" id="myModal<?php echo $feed['id']; ?>">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title">Feedback - <?php echo $feed['username'].' '; ?>(<?php echo $feed['location_name']; ?>)</h4>
									      </div>
									      <div class="modal-body">
									        <h4>Type - <?php echo ucfirst($feed['feedback_type']); ?></h4>
									        <p><?php echo $feed['feedback_message']; ?></p>
									      </div>
									      
									      </div>
									    </div><!-- /.modal-content -->
									  </div><!-- /.modal-dialog -->
									</div><!-- /.modal -->
									<script type="text/javascript">
									$('#view<?php echo $feed['id']; ?>').click(function(e){   
										$('#myModal<?php echo $feed['id']; ?>').modal('show');   									     
									});	

									</script>

							</td>

						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="6"><?php echo lang('text_empty'); ?></td>
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