<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Trainers</h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
								<th>Name</th>
								<th class="text-center">Email</th>
								<th class="text-center">Date Added</th>
								<th class="text-center">Status</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							// echo "<pre>";print_r($trainersRec->result());
						
							if ($trainersRec->num_rows() > 0) {
								 foreach ($trainersRec->result() as $trainers) { ?>
							<tr>
								<td class="action"><input type="checkbox" value="<?php echo $trainers->trainer_id; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
									<a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo site_url('trainers/add_edit?id=' .$trainers->trainer_id); ?>"><i class="fa fa-pencil"></i></a></td>
								<td><?php echo $trainers->first_name.' '.$trainers->last_name; ?></td>
								<td class="text-center"><?php echo $trainers->email; ?></td>
								<td class="text-center"><?php echo date('F j,Y',strtotime($trainers->date_added)); ?></td>
								<td class="text-center"><?php echo ($trainers->status == '1') ? "Active" : "In Active"; ?></td>
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