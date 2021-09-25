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
					<div class="col-md-12 col-sm-12 col-xs-12">

					<div class="table-responsive">
						<table class="table table-none">
							<tr>
								<td width="20%"><b><?php echo lang('column_date'); ?>:</b></td>
								<td><?php echo $date_added; ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('column_subject'); ?>:</b></td>
								<td><?php echo $subject; ?></td>
							</tr>
							<tr>
								<td colspan="2"><div class="msg_body"><?php echo $body; ?></div></td>
							</tr>
						</table>
					</div>
					</div>
				</div>

				<div class="row wrap-all">
					<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="buttons">
						<a href="<?php echo $back_url; ?>" style="float: left;"><?php echo lang('button_back'); ?></a>
						<a href="<?php echo $delete_url; ?>" style="float: right;"><?php echo lang('button_delete'); ?></a>
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