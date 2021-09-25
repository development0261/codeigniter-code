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
								<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
								<th><?php echo lang('column_title'); ?></th>
								<th class="text-center"><?php echo lang('column_content'); ?></th>
								<th class="text-center"><?php echo lang('column_images'); ?></th>
								<th class="text-center"><?php echo lang('column_status'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							// echo "<pre>";print_r($storiesSql->result());
						
							if ($storiesSql->num_rows() > 0) {
								 foreach ($storiesSql->result() as $stories) { ?>
							<tr>
								<td class="action"><input type="checkbox" value="<?php echo $stories->id; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
									<a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo site_url('stories/add_edit?id=' .$stories->id); ?>"><i class="fa fa-pencil"></i></a></td>
								<td><?php echo $stories->title; ?></td>
								<td class="text-center"><?php echo $stories->content; ?></td>
								<td class="text-center"><img src="<?php echo base_url($stories->story_image); ?>" alt="" width="100px;" height="150px;"> </td>
								<td class="text-center"><?php echo ($stories->status) ? "Active" : "In Active"; ?></td>
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