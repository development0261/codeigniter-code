<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="">
				<div class="col-md-12">
					<a href="<?php echo site_url().'payments_report'; ?>"><button class="btn btn-primary text-right" >Back</button></a>
					<input type="button" onclick="printDiv('print')" value="Print" class="btn btn-primary text-right"  /></div>
				<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive"  id="print">
				<table border="0" class="table table-striped table-border" id="example">
					<thead>
						<tr>
														
							<th><?php echo lang('column_reservation_id'); ?></th>
							<th><?php echo lang('column_payment_date'); ?></th>							
							<th><?php echo lang('column_total_amount'); ?></th>	
							<th><?php echo lang('column_receipt'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($reports) { ?>
						<?php foreach ($reports as $report) { ?>
						<tr>
														
							<td><?php echo $report['reservation_id'] ; ?></td>							
							<td><?php echo mdate('%d %M %Y - %H:%i', strtotime($report['payment_date'])); ?></td>							
							<td><?php echo $report['table_amount']; ?></td>							
							<td><?php echo $report['receipt_no']; ?></td>
														
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