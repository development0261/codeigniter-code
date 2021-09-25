<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
				<table class="table table-striped table-border">
					<thead>
						<tr>
							<th class="name sorter"><a class="sort" href="<?php echo $sort_name; ?>"><?php echo lang('client_name'); ?> <i class="fa fa-sort-<?php echo ($sort_by === 'category_name') ? $order_by_active : $order_by; ?>"></i></a></th>
                            <th width="40%"><?php echo lang('client_email'); ?> </th>
							<th class="text-center"><?php echo lang('column_status'); ?></th>
							<th class="text-center"><?php echo lang('view_tables'); ?></th>

						</tr>
					</thead>
					<tbody>
						<?php if ($vendor) { ?>
						<?php foreach ($vendor as $category) { ?>
						<tr>
							<td><?php echo $category['staff_name']; ?></td>
                            <td><?php echo $category['staff_email']; ?></td>
							<td class="text-center"><?php echo $category['status']; ?></td>
							<td class="text-center"><a href="../tables?id=<?php echo $category['staff_id']; ?>" class="btn btn-info" title="View Tables"><i class="fa fa-eye"></i></a></td>
						</tr>

						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="7"><?php echo lang('text_empty'); ?></td>
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