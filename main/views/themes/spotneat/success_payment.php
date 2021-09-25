<?php echo get_header(); ?>
<div id="page-content" style="padding: 69px 0px;">
	<div class="container top-spacing">
		<div class="row">
			<div class="content-wrap col-xs-12 center-block text-center">

			<?php 
			$logged = $this->customer->isLogged();

			if($order != 'Order' ){

			if($status != 'Fail') { ?>
			<div class="col-sm-offset-3 col-md-offset-3 col-sm-6 col-md-6 col-xs-12 padd-none" style="border: 1px solid #38dcc1;">
				<div class="success_confirm">
					<img src="<?php echo theme_url().'/spotneat/images/success.png'; ?>" width="auto" height="auto" class="img-responsive">
				</div>   
				

				<h3> <?php echo lang('reservation_status'); ?> : <?php echo lang('success'); ?></h3>
				
				
					<p>  <?php echo lang('thanks_for_your_reservation'); ?><br/>
				      <?php echo lang('your_booking_id'); ?> <span id="reser_id"><?php echo $reservation_id; ?></span>. <br />
				     <?php echo lang('kindly_show_unique'); ?> </p>
				    <span id="otp_id" style="margin-bottom: 300px;font-size: 32px;"><b><center>"<?php echo $otp; ?>"</center></b></span>

				    <p> <a href="<?php echo site_url().'account/reservations';?>"> <?php echo lang('click_here'); ?></a>  <?php echo lang('for_your_reservation_page'); ?></p>
				    <p> <?php echo lang('kindly_check'); ?> > <a href='<?php echo site_url().'locations';?>'> <?php echo lang('my_location'); ?> </a>  <?php echo lang('further_reservation'); ?></p>
				
				    <?php if($logged!='' && $res_id!='') {
				    	?>
					<meta http-equiv="refresh" content="10;url=<?php echo site_url().'account/reservations/view/'.$res_id;?>"> 
				    <?php }else{?>
				    	<meta http-equiv="refresh" content="10;url=<?php echo site_url(); ?>"> 

				    <?php } ?>
               
			</div>
			 <?php  } else{ ?>

			 <div class="col-sm-6 col-sm-offset-3 col-md-offset-3 col-md-6 col-xs-12 padd-none" style="border: 1px solid #d5393d;">
			 	<div class="failure_confirm">
			 		<img src="<?php echo theme_url().'/spotneat/images/failure.png'; ?>" width="auto" height="auto" class="img-responsive">
			 	</div>   
				<h3> <?php echo lang('reservation_status'); ?> : <?php echo lang('fail'); ?></h3>
				
				
				    <p style="margin-bottom: 100px;"> <?php echo lang('kindly_check'); ?> <a href='<?php echo site_url().'locations';?>'> <?php echo lang('my_location'); ?> </a>  <?php echo lang('further_reservation'); ?> </p>	
               
			</div>

			<?php } 
			}

			else{ 

				if($status != 'Fail') { ?>
					<div class="col-sm-offset-3 col-md-offset-3 col-sm-6 col-md-6 col-xs-12 padd-none" style="border: 1px solid #38dcc1;">
						<div class="success_confirm">
							<img src="<?php echo theme_url().'/spotneat/images/success.png'; ?>" width="auto" height="auto" class="img-responsive">
						</div>   
						

						<h3> <?php echo lang('order_status'); ?> : <?php echo lang('success'); ?></h3>
						
						
							<p>  <?php echo lang('thanks_for_your_order'); ?><br/>
						      <?php echo lang('your_order_id'); ?> <span id="order_id"><?php //echo '#'.str_pad($order_id,6,"0",STR_PAD_LEFT);
						      echo $order_id; ?></span>. <br />
						  </p>
					</div>
					<meta http-equiv="refresh" content="10;url=<?php echo site_url().'account/orders/view/'.$order_id;?>"> 
					
				<?php }else{ ?>

					<div class="col-sm-6 col-sm-offset-3 col-md-offset-3 col-md-6 col-xs-12 padd-none" style="border: 1px solid #d5393d;">
			 	<div class="failure_confirm">
			 		<img src="<?php echo theme_url().'/spotneat/images/failure.png'; ?>" width="auto" height="auto" class="img-responsive">
			 	</div>   
				<h3> <?php echo lang('order_status'); ?> : <?php echo lang('fail'); ?></h3>
				
				
				    <p style="margin-bottom: 100px;"> <?php echo lang('kindly_check'); ?> <a href='<?php echo site_url().'locations';?>'> <?php echo lang('my_location'); ?> </a>  <?php echo lang('further_reservation'); ?> </p>	
               
			</div>
			<?php 
					} 

			 } ?>

			</div>
		</div>
	</div>
</div>
<?php echo get_footer();exit; ?>