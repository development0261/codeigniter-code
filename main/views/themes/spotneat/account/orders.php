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
            <div class="col-md-9 col-sm-9 col-xs-12 no-pad">
            <div class="<?php echo $class; ?> list-group-item">
                <div class="row">
                    <div class="order-lists col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th><?php echo lang('column_id'); ?></th>
                                    <th><?php echo lang('column_status'); ?></th>
                                    <th><?php echo lang('column_location'); ?></th>
                                    <th><?php echo lang('column_date'); ?></th>
                                    <th><?php echo lang('column_order'); ?></th>
                                    <th><?php echo lang('column_items'); ?></th>
                                    <th><?php echo lang('column_total'); ?></th>
                                    <th></th>
                                    <?php if (config_item('allow_reviews') !== '1') {?>
                                        <th></th>
                                    <?php }?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($orders) {?>
                                    <?php foreach ($orders as $order) {?>
                                        <tr>
                                            <td><a href="<?php echo $order['view']; ?>"><?php echo $order['order_id']; ?></a></td>
                                            <td><?php echo $order['status_name']; ?></td>
                                            <td style="color:#434446;"><?php echo $order['location_name']; ?></td>
                                            <td><?php echo $order['order_time']; ?> - <?php echo $order['order_date']; ?></td>
                                            <td><?php echo $order['order_type']; ?></td>
                                            <td><?php echo $order['total_items']; ?></td>
                                            <td><?php echo $order['order_total']; ?></td>
                                           <!--  <td><a title="<?php echo lang('text_reorder'); ?>" href="<?php echo $order['reorder']; ?>"><i class="fa fa-mail-reply"></i></a></td> -->
                                            <?php if (config_item('allow_reviews') !== '1') {?>
                                                <td><a title="<?php echo lang('text_leave_review'); ?>" href="<?php echo $order['leave_review']; ?>">
                                                <!-- <i class="fa fa-heart"></i> -->
                                                Review</a></td>
                                            <?php }?>
                                        </tr>
                                    <?php }?>
                                <?php } else {?>
                                    <tr>
                                        <td colspan="9"><?php echo lang('text_empty'); ?></td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="buttons col-xs-6 wrap-none">
                            <a href="<?php echo $back_url; ?>"  style="float: left;"><b><?php echo lang('button_back'); ?></b></a>
                            <a href="<?php echo $new_order_url; ?>" style="float: right;"><b><?php echo lang('button_order'); ?></b></a>
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
            <?php echo get_partial('content_right'); ?>
            <?php echo get_partial('content_bottom'); ?>
        </div>
        </div>
    </div>
</div>
<?php echo get_footer(); ?>