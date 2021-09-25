<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="wrap-all" >
    <div class="cart-buttons wrap-bottom" >
        <div class="center-block text-center" >
            <a onclick="window.history.back();">
            	<button class="btn btn-primary ">
            	<?php echo lang('button_go_back') ?>
            	</button>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php if( $this->session->userdata('cart_contents') == '' ||  $this->session->userdata('cart_contents')== NULL){
    ?>
        <div class="panel-body" style="margin-bottom: 200px;margin-top: 50px;"><?php echo lang('text_no_cart_items'); ?></div>
 <?php } ?>
</div>
<?php echo get_partial('content_bottom'); ?>
<?php echo get_footer(); ?>