

<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="">
				
				
			</div>
			
<?php

 if(!$loc_id){ ?>
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
				<table border="0" class="table table-striped table-border" id="example">
					<thead>
						<tr>
														
							<th><?php echo lang('column_location'); ?></th>
							<th><?php echo lang('column_amount'); ?></th>
							<?php 
							if($vendor_id!='11' && $vendor_id!=''){?>
							<th><?php echo lang('column_Commission'); ?></th>
							<?php } ?>
							<th><?php echo lang('column_admin_Commission'); ?></th>							
							<th><?php echo lang('column_date'); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($payments) { ?>
						<?php foreach ($payments as $payment) { ?>
						<tr>
														
							<td><?php echo $payment['location_id'] ; ?></td>							
							<td><?php echo $payment['total_amount']; ?></td>
							<?php 
							if($vendor_id!='11' && $vendor_id!=''){?>
							<td><?php echo $payment['table_amount']; ?></td>
							<?php } ?>
							<td><?php echo $payment['table_amount']; ?></td>							
							<td><?php echo mdate('%d %M %Y - %H:%i', strtotime($payment['date'])); ?></td>
							<td><form action="" method="post">
							<input type="hidden" name="lc_id" value="<?php echo $payment['loc_id'] ; ?>"> 
							<input type="submit" class="btn btn-primary" value="View Detail"></form></td>
							
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="7" style="text-align:center;"><?php echo lang('text_empty'); ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
			</form>
<?php }else{ ?>
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-6  text-right">
									<div class="form-group"><a href="<?php echo site_url().'payments'; ?>"><button class="btn btn-primary" style="margin: 10px;">Back</button></a></div>
							</div>
						</div>
					</div>
					<div class="col-md-12"><input type="button" onclick="printDiv('print')" value="Print" class="btn btn-primary text-right"  /></div>
					
			<form role="form" id="payment_form" accept-charset="utf-8" enctype="multipart/form-data" method="POST" action="<?php echo site_url().'payments_report'; ?>">
				<div class="table-responsive">
					<div class="" id="print">
				<table border="0" class="table table-striped table-border" id="example">
					<thead>
						<tr><?php 
							if($vendor_id=='11'){?>
							<th class="action"><input type="checkbox" value="0" onclick="$('input[name*=\'checkbox\']').prop('checked', this.checked);"></th>	<?php } ?>						
							<th><?php echo lang('column_location'); ?></th>
							<th><?php echo lang('column_reservation'); ?></th>
							<th><?php echo lang('column_staff'); ?></th>
							<!--<th><?php //echo lang('column_percentage'); ?></th>-->
							<th><?php echo lang('column_amount'); ?></th>
							<?php 

							if($vendor_id!='11' && $vendor_id!=''){?>
							<th><?php echo lang('column_Commission'); ?></th>
							<?php } ?>
							<th><?php echo lang('column_admin_Commission'); ?></th>
							<th><?php echo lang('column_date'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($payments) { ?>
						<?php foreach ($payments as $payment) { ?>
						<tr><?php 
							if($vendor_id=='11'){?>
							<td class="action"><input type="checkbox" class="checkbox<?php echo $payment['reservation_id']; ?>" value="<?php echo $payment['table_amount']; ?>" name="checkbox<?php echo $payment['reservation_id']; ?>"  onClick="test(this);" /></td><?php } ?>
							<input type="hidden" name="reserve_id[]" id="reserve_id" value="<?php echo $payment['reservation_id']; ?>">
							<td><?php echo $payment['location_id'] ; ?></td>
							<td><?php echo $payment['reservation_id'] ; ?></td>
							<td><?php echo $payment['staff_id'] ; ?></td>
							<!--<td><?php //echo $payment['percentage']; ?></td>-->
							<td><?php echo $payment['total_amount']; ?></td>
							<?php 
							if($vendor_id!='11' && $vendor_id!=''){?>
							<td><?php echo $payment['vendor_commission_amount']; ?></td>
							<?php } ?>
							<td><?php echo $payment['table_amount']; ?></td>
							<td><?php echo mdate('%d %M %Y - %H:%i', strtotime($payment['date'])); ?></td>							
						</tr>
						<script type="text/javascript">

							var total = 0;

						    function test(item){
						        if(item.checked){
						           total+= parseFloat(item.value,2);
						        }else{
						           total-= parseFloat(item.value,2);
						        }
						        //console.log(total);
						        document.getElementById('total_booking_amount').value = total;
						    }

								// $('.checkbox<?php //echo $payment['reservation_id']; ?>').click(function() {
								//   if ($(this).is(':checked')) {
								//     //console.log('<?php //echo $payment['table_amount']; ?>');
								//    // console.log('<?php //echo $payment['reservation_id']; ?>');
								//   }else{
								//   	//console.log('<?php //echo $payment['table_amount']; ?>');
								//   	//console.log('<?php //echo $payment['reservation_id']; ?>');
								//   }
								// });								
							</script>

						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="7"><?php echo lang('text_empty'); ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
				<?php 
							if($vendor_id=='11'){ ?>
					<table border="0" class="table table-border" >
					
					<tr>
						<td><label>Total Booking Amount</label></td>
						<td><input type="text" name="total_booking_amount" id="total_booking_amount" autocomplete="off">
							<span id="book_amnt_err" style="color: red;display: none;">Check Any Payment To Proceed</span>
						</td>
					</tr>
					<tr>
						<td><label>Total Amount Received</label></td>
						<td><input type="text" name="total_amount_received" id="total_amount_received" autocomplete="off">
							<span id="amount_recvd_err" style="color: red;display: none;">Enter Total Amount Received</span>
						</td>
					</tr>
					<tr>
						<td><label>Payment Date</label></td>
						<td><input type="text" name="payment_date" id="datepicker" placeholder="dd/mm/yyyy" autocomplete="off">
						<span id="payment_date_err" style="color: red;display: none;">Enter Payment date</span>
					</td>
					</tr>
					<tr>
						<td><label>Receipt Number</label></td>
						<td><input type="text" name="receipt_no" id="receipt_no" autocomplete="off">
						<span id="receipt_no_err" style="color: red;display: none;">Enter Receipt No</span>
					</td>
					</tr>
					<tr>
						<td><label>Description</label></td>
						<td><textarea name="description" rows="6" cols="50" style="resize: none;" ></textarea></td>
					</tr>
					<tr>
						<td colspan="2" align="center" ><input type="submit" name="submit" id="submit" value="Payment Update" class="btn btn-primary"></td>
					</tr>
				</table>
				<?php } ?>
				</div>
			</form>
		
			<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );
	} );
	$( function() {
	    	$( "#datepicker" ).datepicker({
				autoclose:true,
				format:'dd/mm/yyyy'
				
			});
    
  	});

  	$("input[type=checkbox]").change(function(){  recalculate();});
  	function recalculate(){  
  	  var sum = 0;    
  	  $("input[type=checkbox]:checked").each(function(){  
  	      sum += parseFloat($(this).val(),2);   
  	       });   
  	        //console.log(sum);
  	         document.getElementById('total_booking_amount').value = sum;
  	    }
  	 $('#payment_form').submit(function(event) {

  	 		check_validation();

            
  });
  	 function check_validation(){
  	             
                var book_amount,amount_recvd,payment_date,receipt_no;

                book_amount = document.getElementById("total_booking_amount").value;
                amount_recvd = document.getElementById("total_amount_received").value;
                payment_date = document.getElementById("datepicker").value;
                receipt_no = document.getElementById("receipt_no").value;
                if(book_amount == '' ){
                   document.getElementById("book_amnt_err").style.display = 'block'; 
                   document.getElementById("amount_recvd_err").style.display = 'none'; 
                   document.getElementById("payment_date_err").style.display = 'none'; 
                   document.getElementById("receipt_no_err").style.display = 'none';                
                   event.preventDefault();
                   return false;
                }else if(amount_recvd == '' ){
                   document.getElementById("amount_recvd_err").style.display = 'block';
                   document.getElementById("book_amnt_err").style.display = 'none'; 
                   document.getElementById("payment_date_err").style.display = 'none'; 
                   document.getElementById("receipt_no_err").style.display = 'none';                  
                   event.preventDefault();
                   return false;
                }else if(payment_date == '' ){
                   document.getElementById("payment_date_err").style.display = 'block'; 
                   document.getElementById("book_amnt_err").style.display = 'none'; 
                   document.getElementById("amount_recvd_err").style.display = 'none';
                   document.getElementById("receipt_no_err").style.display = 'none';                 
                   event.preventDefault();
                   return false;
                }else if(receipt_no == '' ){
                   document.getElementById("receipt_no_err").style.display = 'block';
                   document.getElementById("book_amnt_err").style.display = 'none';
                   document.getElementById("amount_recvd_err").style.display = 'none';
                   document.getElementById("payment_date_err").style.display = 'none';                    
                   event.preventDefault();
                   return false;
                }else{
                	 document.getElementById("receipt_no_err").style.display = 'none';
                   document.getElementById("book_amnt_err").style.display = 'none';
                   document.getElementById("amount_recvd_err").style.display = 'none';
                   document.getElementById("payment_date_err").style.display = 'none';
                	return true;
                }


            }
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
<?php echo get_footer(); ?>