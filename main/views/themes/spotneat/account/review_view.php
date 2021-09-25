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
		<div class="col-md-12 col-sm-12 col-xs-12 content_bacg after-log-top-space" >

		<div class="row top-spacing">
			<?php echo get_partial('content_left'); ?>
			<?php
if (partial_exists('content_left') AND partial_exists('content_right')) {
	$class = "col-sm-6 col-md-6 col-xs-12";
} else if (partial_exists('content_left') OR partial_exists('content_right')) {
	$class = "col-sm-12 col-md-12 col-xs-12";
} else {
	$class = "col-md-12 col-xs-3 col-sm-12";
}
?>
			<div class="col-md-9 col-sm-9 col-xs-12 ">
			<div class="<?php echo $class; ?> list-group-item" >
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
						<table class="table table-none">
							<tr>
								<td><b><?php echo lang('column_restaurant'); ?></b></td>
								<td><?php echo lang_trans($location_name, $location_name_ar); ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('column_sale_id'); ?></b></td>
								<td><?php echo $sale_id; ?> - <?php echo lang($sale_type); ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('column_author'); ?></b></td>
								<td><?php echo $author; ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('column_rating'); ?></b></td>
								<td>
									<ul class="list-inline rating-inline">
										<li class="col-md-3 col-sm-3 col-xs-12"><b><?php echo lang('label_quality'); ?></b><br />
											<div class="rating rating-star" data-score="<?php echo $quality; ?>" data-readonly="true"></div>
										</li>
										<!-- <li><b><?php //echo lang('label_delivery'); ?></b><br />
											<div class="rating rating-star" data-score="<?php //echo $delivery; ?>" data-readonly="true"></div>
										</li> -->
										<li  class="col-md-3 col-sm-3 col-xs-3"><b><?php echo lang('label_service'); ?></b><br />
											<div class="rating rating-star" data-score="<?php echo $service; ?>" data-readonly="true"></div>
										</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td><b><?php echo lang('label_review'); ?></b></td>
								<td><?php echo $review_text; ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('label_date'); ?></b></td>
								<td><?php echo $date; ?></td>
							</tr>
						</table>
						</div>
					</div>

					<div class="col-md-12">
						<div class="buttons">
							<a  href="<?php echo $back_url; ?>"><button class="btn btn-default"><?php echo lang('button_back'); ?></button></a>						</div>
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
<script type="text/javascript"><!--
$(document).ready(function() {
	var ratings = <?php echo json_encode(array_values($ratings)); ?>;
	displayRatings(ratings);
});
//--></script>
<?php echo get_footer(); ?>