<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="col-md-12"><h3 class="panel-title"><?php echo lang('payments_report'); ?></h3></div>
			<div class="">
				
				<div class="col-md-12"><input type="button" onclick="printDiv('print')" value="Print" class="btn btn-primary text-right"  /></div>
				<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive" id="print">
				<table border="0" class="table table-striped table-border" id="example">
					<thead>
						<tr>							
							<th><?php echo lang('column_reserve'); ?></th>
							<th><?php echo lang('column_cust_name'); ?></th>
							<th><?php echo lang('column_cust_email'); ?></th>
							<th><?php echo lang('column_total_amount'); ?></th>
							<th><?php echo lang('column_amount_refund'); ?></th>
							<th><?php echo lang('column_payment_date'); ?></th>
							<th><?php echo lang('column_payment_type');?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($reports) { ?>
						<?php foreach ($reports as $report) { ?>
						<tr>
							<td><?php echo $report['reservation_id'] ; ?></td>					
							<td><?php echo $report['customer_name']; ?></td>
							<td><?php echo $report['email']; ?></td>
							<td><?php echo $this->currency->format($report['total_amount']);?></td>			
							<td><?php echo $this->currency->format($report['refund_amount']); ?></td>
							<td><?php echo $report['updated_at']; ?></td>
							<td align="center"><?php echo ucfirst($report['payment_status']);?></td>
							<td></td>
							
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td align="center" colspan="7"><?php echo lang('text_empty'); ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
			</form>
			</div>
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