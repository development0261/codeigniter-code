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
	$class = "col-sm-6 col-md-6 col-xs-12";
} else if (partial_exists('content_left') OR partial_exists('content_right')) {
	$class = "col-sm-12 col-md-12 col-xs-12";
} else {
	$class = "col-md-12 col-xs-3 col-sm-12";
}
?>

			<div class="col-md-9 col-sm-9 col-xs-12 no-pad">

				<div class="<?php echo $class; ?> list-group-item">
				<div class="col-md-12">
							<div class="buttons text-right">
							<a href="<?php echo base_url() . 'account/address/edit'; ?>" style="float: left;">
								<button type="button" class="btn btn-primary btn-sm"><?php echo lang('button_add'); ?></button>
							</a>
							</div>
						</div>
				<div class="row">
					<?php if ($addresses) {?>
						<?php $address_row = 0;?>
						<div class="col-sm-12 col-md-12 col-xs-12 list-group">
							<?php foreach ($addresses as $address) {?>
								<div class="list-group-item border-none border-top border-bottom <?php echo ($address_id == $address['address_id']) ? 'list-group-item-info' : ''; ?>" style="margin: 15px !important;" >
									<address class="text-left"><?php echo $address['address']; ?></address>
									<span class="">
										<a class="edit-address" href="<?php echo $address['edit']; ?>"><?php echo lang('text_edit'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
										<a class="delete-address text-danger" href="<?php echo $address['delete']; ?>"  onclick="if (confirm('<?php echo lang('alert_warning_confirm'); ?>')) {  return true; } else { return false;}"><?php echo lang('text_delete'); ?></a>
									</span>
								</div>
								<?php $address_row++;?>
							<?php }?>
						</div>
					<?php } else {?>
						<div class="col-md-12 col-sm-12 col-xs-12 "><?php echo lang('text_no_address'); ?></div>
					<?php }?>

					<div class="col-md-12 col-sm-12 col-xs-12  page-spacing"></div>

					<div class="col-md-12 col-sm-12 col-xs-12 ">
						<div class="row">
							<div class="buttons col-sm-6 col-sm-6 col-md-12">

								<a href="<?php echo $back_url; ?>" style="float: left;"><b><?php echo lang('button_back'); ?></b></a>
								<a href="<?php echo $continue_url; ?>"  style="float: right;"><b><?php //echo lang('button_add'); ?></b></a>
							</div>

							<div class="col-sm-6 col-xs-12 col-md-6">
								<div class="pagination-bar text-right">
									<div class="links"><?php echo $pagination['links']; ?></div>
									<div class="info"><?php echo $pagination['info']; ?></div>
								</div>
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
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#add-address').on('click', function() {
		if($('#new-address').is(':visible')) {
			$('#new-address').fadeOut();
		}else{
			$('#new-address').fadeIn();
		}
	});
});
//--></script>
<?php echo get_footer(); ?>