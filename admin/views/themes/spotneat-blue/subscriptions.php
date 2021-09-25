<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Subscriptions</h3>
				<div id="alert_message"></div>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border" id="VideoList">
						<thead>
							<tr>								 
								<th>Email</th>
								<th>Type</th>								 
								<th>Date Added</th>
								<th>Amount(aud)</th>
								<th>Status</th>
								<th>Total Weeks</th>
							</tr>
						</thead>
						<tbody>
							<?php 

							//first_name, last_name, email, purchase_type, date, amount
							// echo "<pre>";print_r($subscriptionsRec->result());
						
							if (!empty($subscriptionsRec)) {
								 foreach ($subscriptionsRec as $trainers) { ?>
							<tr>
								<td><?php echo $trainers['email']; ?></td>
								<td><?php 
								//echo $trainers->purchase_type;
								if($trainers['purchase_type']=='fixed') echo 'One-Off';
								if($trainers['purchase_type']=='subscription') echo 'Recurring';
								 ?></td>
								<td><?php echo date('F j,Y',strtotime($trainers['purchase_date'])); ?></td>
								<td><?php echo $trainers['price']; ?></td>
								<td><?php echo $trainers['is_active'] == '1'?'Active':'In Active'; ?></td>
								<td><div contenteditable class="update_row" data-id="<?php echo $trainers['video_purchase_id']; ?>"><?php echo $trainers['subscription_payment_iteration']; ?></div></td>
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

<script type="text/javascript">
//datatable 
	
$(document).ready( function () {
    $('#VideoList').DataTable();

});

$(document).on('blur', '.update_row', function(){
   var id = $(this).data("id");
   var value = $(this).text();

   $.ajax({
    url:"<?php echo  base_url() ?>subscriptions/updateWeek",
    method:"POST",
    data:{video_purchase_id:id, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">Updated Successfully</div>');
     //VideoData.ajax.reload();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);




  })

</script>