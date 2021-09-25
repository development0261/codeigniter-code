<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="col-md-12"><h3 class="panel-title"><?php echo lang('payments_report'); ?></h3></div>
				<div class="col-md-12"><input type="button" onclick="printDiv('print')" value="Print" class="btn btn-primary text-right"  /></div>
				<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive" id="print">
				<table border="0" class="table table-striped table-border" id="example">
					<thead>
						<tr>
														
							<th><?php echo lang('column_receipt'); ?></th>
							<th><?php echo lang('column_total_amount'); ?></th>
							<?php 
							if($vendor_id!='11' && $vendor_id!=''){?>
							<th><?php echo lang('column_amount_paid'); ?></th>
							<?php } ?>
							<th><?php echo lang('column_amount_received'); ?></th>							
							<th><?php echo lang('column_payment_date'); ?></th>
							<!--<th><?php echo lang('column_description'); ?></th>
							<th><?php echo lang('column_no_orders'); ?></th>-->
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($reports) { ?>
						<?php foreach ($reports as $report) { ?>
						<tr>
														
							<td><?php echo $report['receipt_no'] ; ?></td>							
							<td><?php echo $report['total_booking_amount']; ?></td>
							<?php 
							if($vendor_id!='11' && $vendor_id!=''){?>
							<td><?php echo $report['total_amount_received']; ?></td>
							<?php } ?>
							<td><?php echo $report['total_amount_received']; ?></td>							
							<td><?php echo mdate('%d %M %Y - %H:%i', strtotime($report['payment_date'])); ?></td>
							<!--<td><?php echo $report['description']; ?></td>
							<td><?php echo $report['no_of_orders']; ?></td>
							<td><a class="btn btn-primary" href="<?php echo site_url().'payments_report/payments_report_detail/?receipt='.$report['receipt_no'] ; ?>"> View Detail</a> </td>-->
							
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="7" style="text-align: center;"><?php echo lang('text_empty'); ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
			</form>
			</div>
			</div></div>
	<script type="text/javascript">
		$(document).ready(function() {
    $('#example').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );
	} );
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
	</script>		
<?php echo get_footer(); ?>