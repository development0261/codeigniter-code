<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
				<!-- <div class="pull-right">
					<button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
				</div> -->
			</div>
			<div class="panel-body panel-filter">
				<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								<div class="col-md-3 pull-right text-right">
									<!-- <div class="form-group">
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
									</div>
									 --><!-- <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a> -->
								</div>

								<div class="col-md-8 pull-left">
									<!-- <div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_status'); ?></option>
										<?php if ($filter_status === '1') { ?>
											<option value="requested" <?php echo set_select('filter_status', 'requested', TRUE); ?> ><?php echo lang('text_requested'); ?></option>
											<option value="paid" <?php echo set_select('filter_status', 'paid'); ?> ><?php echo lang('text_paid'); ?></option>
										<?php } else if ($filter_status === '0') { ?>
											<option value="requested" <?php echo set_select('filter_status', 'requested'); ?> ><?php echo lang('text_requested'); ?></option>
											<option value="paid" <?php echo set_select('filter_status', 'paid', TRUE); ?> ><?php echo lang('text_paid'); ?></option>
										<?php } else { ?>
											<option value="requested" <?php echo set_select('filter_status', 'requested'); ?> ><?php echo lang('text_requested'); ?></option>
											<option value="paid" <?php echo set_select('filter_status', 'paid'); ?> ><?php echo lang('text_paid'); ?></option>
										<?php } ?>
										</select>
									</div> -->
									<!-- <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a> -->
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
							<th class="sorter"><a class="sort" href="<?php echo $sort_reservation_id; ?>"><?php echo lang('column_reservation'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'reservation_id') ? $order_by_active : $order_by; ?>"></i></a></th>

							<th class="sorter"><a class="sort" href="<?php echo $sort_cust_fname; ?>"><?php echo lang('column_cust_fname'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'cust_fname') ? $order_by_active : $order_by; ?>"></i></a></th>

							<!--<th class="sorter"><a class="sort" href="<?php echo $sort_cust_lname; ?>"><?php echo lang('column_cust_lname'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'cust_lname') ? $order_by_active : $order_by; ?>"></i></a></th>-->

							<th class="sorter"><a class="sort" href="<?php echo $sort_cust_email; ?>"><?php echo lang('column_email'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'cust_email') ? $order_by_active : $order_by; ?>"></i></a></th>

							<th><?php echo lang('column_refund_amount'); ?></th>
							<th><?php echo lang('column_status'); ?></th>
							<th class="id">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($tables) {?>
						<?php foreach ($tables as $table) { ?>
						<tr>
							<!-- <td class="action"><input type="checkbox" value="<?php echo $table['reservation_id']; ?>" name="delete[<?php echo $table['staff_id'];?>]"/></td> -->
							<td class="sorter"><?php echo $table['reservation_id']; ?></td>
							<td class="sorter"><?php echo $table['cust_fname']; ?></td>
							<!--<td class="sorter"><?php echo $table['cust_lname']; ?></td>-->
							<td class="sorter"><?php echo $table['cust_email']; ?></td>
							<td class="sorter"><?php echo $table['refund_amount'];?></td>
							<td class="sorter"><?php echo ucfirst($table['type']);?></td>

							<?php if($table['type']=='requested'){ ?>
								<td><button type="button" class="btn btn-primary" name="spay" id="spay<?php echo $table['reservation_id'];?>" onclick="javascript:singlepay('<?php echo $table['reservation_id'];?>','<?php echo $table['staff_id'];?>')">Refund</button>
								</td>
							<?php } else {?>
									<td>-----</td>
							<?php } ?>	
							<!-- <td class="id"><?php echo $table['table_id']; ?></td> -->
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="6" style="text-align:center;"><?php echo lang('text_empty');?></td>
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
<script type="text/javascript">
function filterList() {
	$('#filter-form').submit();
}

function confirmpay() {
	$('#list-form').submit();
}

function singlepay($id,$vid) {
		$('#spay'+ $id).prop('disabled',true);
		$.ajax({
        type: 'POST',
        url: '<?php echo site_url("refund/stat");?>',
        dataType: 'html',
        data: ({sid : $id,vid : $vid}),
        cache: false,
        success: function(data) {
        	$('#spay'+ $id).prop('disabled',false);

        	window.location.reload();

        },
        error: function(xhr, textStatus, errorThrown) {
        	 window.location.reload();
        }
    });
}

</script>
<?php echo get_footer(); ?>