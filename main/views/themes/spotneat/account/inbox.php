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
	$class = "col-sm-6 col-md-6";
} else if (partial_exists('content_left') OR partial_exists('content_right')) {
	$class = "col-sm-12 col-md-12";
} else {
	$class = "col-md-12";
}
?>
			<div class="col-md-9 col-sm-9 col-xs-12 ">
			<div class=" <?php echo $class; ?> list-group-item">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<?php if ($messages) {?>
							<div class="list-group">
								<?php foreach ($messages as $message) {?>
									<a href="<?php echo $message['view']; ?>" class="list-group-item <?php echo $message['state']; ?>">
										<div class="row">
											<div class="col-sm-9 col-md-9">
												<span class=""><?php echo $message['subject']; ?></span>
												<span class="text-muted small" style="font-size: 11px;">- <?php echo $message['body']; ?></span>
											</div>
											<div class="col-sm-3 col-md-3 text-right">
												<span class="badge"><?php echo $message['date_added']; ?></span>
											</div>
										</div>
									</a>
								<?php }?>
							</div>
						<?php } else {?>
							<p><?php echo lang('text_empty'); ?></p>
						<?php }?>
					</div>
				</div>

				<div class="row">
					<div class="buttons col-sm-6">
						<!-- <a href="<?php echo $back_url; ?>"><b><?php //echo lang('button_back'); ?></b></a> -->
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

			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>