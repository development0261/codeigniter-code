<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
<?php if ($this->alert->get()) {?>
    <div id="notification">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->alert->display(); ?>
                </div>
            </div>
        </div>
    </div>
<?php }?>
</div>
<div id="page-content" style="background-color: #fdcec0 !important;">
	<div class="container">
		<div class="col-md-12 col-sm-12 col-xs-12 content_bacg after-log-top-space">
			<div class="row top-spacing">
			<?php echo get_partial('content_left'); ?>
			<?php
if (partial_exists('content_left') AND partial_exists('content_right')) {
	$class = "col-sm-6 col-md-6 col-xs-3";
} else if (partial_exists('content_left') OR partial_exists('content_right')) {
	$class = "col-sm-12 col-md-12 col-xs-12";
} else {
	$class = "col-md-12 col-xs-3 col-sm-12";
}
?>
			<div class="col-md-9 col-sm-9 col-xs-12 no-pad">
			<div class="<?php echo $class; ?> content_inn_wrap">
				<div class="row">
					<div class="tab-content col-md-12 col-sm-12 col-xs-12">
							<div class="row top-spacing-20">
                                <div class="col-xs-12 col-md-12 col-sm-12 padd-none text-center">
                                    <h4>Cancellation Policy For <?php echo $location_name; ?></h4>
                                    <hr><br />

                                    <?php
$period = explode('-', $cancellation_period);
$period0 = json_decode($period[0]);
$period1 = json_decode($period[1]);
$charge = json_decode($cancellation_charge);
$count = count($charge);
if ($charge != '0') {
	?>
                                    <table border="1" cellpadding="5" cellspacing="5" align="center" class="text-center">
                                    		<tr>
                                    			<th width="150" align="center" class="text-center">Time</th>
                                    			<th width="150" align="center" class="text-center">% of Deduction</th>
                                    		</tr>
                                    <?php
for ($i = 0; $i < $count; $i++) {
		?>
                                    	<tr>
                                    		<td><?php echo $period0[$i] . ' ' . $period1[$i] . '(s)'; ?></td>
                                    		<td><?php echo $charge[$i] . '%'; ?></td>
                                    	</tr>
                                    	<?php
}

	?>
                                    </table>
                                <?php } else {?>

                                	<table border="1" cellpadding="5" cellspacing="5" align="center" class="text-center">
                                		<tr>
                                    			<th width="150" align="center" class="text-center">Time</th>
                                    			<th width="150" align="center" class="text-center">% of Deduction</th>
                                    		</tr>
                                		<tr><td colspan="2" width="300">No Refund Policy For the Restaurant / Cafe</td></tr>
                                	</table>
                                <?php }?>

							    </div>
							</div>
					</div>
				</div>

			</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
		</div>
	</div>
</div>


<?php echo get_footer(); ?>