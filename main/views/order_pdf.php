
                    <div class="order-lists row">
                        <div class="col-md-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-none">
                                    <tr>
                                        <td style="width:20%;"><b><?php echo lang('column_id'); ?>:</b></td>
                                        <td><?php echo $order_id; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo lang('column_time'); ?>:</b></td>
                                        <td><?php echo $order_time; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo lang('column_date_added'); ?>:</b></td>
                                        <td><?php echo $date_added; ?></td>
                                    </tr>
                                   <!--  <tr>
                                        <td><b><?php //echo lang('column_order'); ?>:</b></td>
                                        <td><?php //echo ($order_type === '1') ? lang('text_delivery') : lang('text_collection'); ?></td>
                                    </tr> -->
                                   <!--  <?php if ($order_type === '1') {?>
                                        <tr>
                                            <td><b><?php //echo lang('column_delivery'); ?>:</b></td>
                                            <td><?php //echo $delivery_address; ?></td>
                                        </tr>
                                    <?php }?> -->
                                    <tr>
                                        <td><b><?php echo lang('column_payment'); ?>:</b></td>
                                        <td><?php echo $payment; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo lang('column_location'); ?>:</b></td>
                                        <td><b><?php echo $location_name; ?></b><br /><?php echo $location_address; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        </div>

                        <div class="col-md-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="text-center">
                                <h4><?php echo lang('text_order_menus'); ?></h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="10%" ><?php echo lang('column_menu_qty'); ?> </th>
                                        <th width="60%" class="text-left"><?php echo lang('column_menu_name'); ?></th>
                                        <th width="20%" class="text-left"><?php echo lang('column_menu_price'); ?></th>
                                        <th width="10%" class="text-left"><?php echo lang('column_menu_subtotal'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($menus as $menu) {?>
                                        <tr id="<?php echo $menu['id']; ?>">
                                            <td><?php echo $menu['qty']; ?> x</td>
                                            <td class="text-left"><?php echo $menu['name']; ?><br />
                                                <?php if (!empty($menu['options'])) {?>
                                                    <div><small><?php echo lang('text_plus'); ?><?php echo $menu['options']; ?></small></div>
                                                <?php }?>
                                                <?php if (!empty($menu['comment'])) {?>
                                                    <div><small><b><?php echo $menu['comment']; ?></b></small></div>
                                                <?php }?>
                                            </td>
                                            <td class="text-left"><?php echo $menu['price']; ?></td>
                                            <td class="text-left"><?php echo $menu['subtotal']; ?></td>
                                        </tr>
                                    <?php }?>
                                   <!--<tr>
                                            <td class="no-line" colspan="2"></td>
                                            <td><b><?php echo lang('table_price'); ?></b></td>
                                            <td class="text-left"><b><?php echo $menu['table_price']; ?></b></td>
                                        </tr>-->
                                    <?php if ($reward_amount) {?>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                            <td><?php echo lang('reward_amount'); ?></td>
                                            <td><?php echo '(-) ' . $this->currency->format($reward_amount); ?></td>
                                        </tr>

                                    <?php }?>
                                    <?php if (isset($offers)) {?>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                            <td><?php echo lang('coupon_discount'); ?></td>
                                            <td><?php echo ' ' . $this->currency->format($offer); ?></td>
                                        </tr>

                                    <?php }?>
                                    <?php foreach ($totals as $total) {
	?>

                                        <tr>
                                            <td class="no-line" colspan="2"></td>
                                            <?php if ($total['code'] === 'order_total') {?>

                                                <td class="text-left thick-line"><b><?php echo lang('order_total'); ?></b></td>
                                                <td class="text-left thick-line"><b><?php echo $total['value']; ?></b></td>
                                            <?php } else {?>
                                                <td class="text-left no-line"><?php //echo $total['title'];
		if ($total['title'] == "Sub Total") {
			echo '<b>' . lang('sub_total') . '</b>:';
			// $total['value'] = $this->currency->format($total['value'] + $offer);
		} else if ($total['title'] == "Delivery") {
			echo '<b>' . lang('text_delivery') . '</b>:';
			// $total['value'] = $this->currency->format($total['value']);
		} else if ($total['code'] == "coupon") {
			echo '<b>' . $total['title'] . '</b>:';
			// $total['value'] = $this->currency->format($total['value']);
		} else {
			//$tax = $this->config->item('tax_percentage');
			//echo '<b>'.lang('vat').' ( '.$tax.'% )</b> : ';
			echo '<b>' . $tax . '</b>';
		}
		?></td>
                                                <td class="text-left no-line"><?php echo $total['value']; ?></td>
                                            <?php }?>
                                        </tr>
                                    <?php }?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="buttons">
                                <a href="<?php echo site_url() . 'account/orders/view/' . $reservation_id; ?>"  class="btn btn-primary" style="float: left;color: #fff !important;margin-bottom: 20px;"><?php echo lang('button_back'); ?></a>

                                <a href="<?php echo site_url() . 'account/orders/generatepdf/' . $order_id; ?>"  class="btn btn-primary" style="float: left;color: #fff !important;margin-bottom: 20px;"><?php echo lang('generate_pdf'); ?></a>
                               <!--  <a  href="<?php //echo $reorder_url; ?>" style="float: right;"><button class="btn btn-default" ><?php //echo lang('button_reorder'); ?></button></a> -->
                            </div>
                        </div>
                        </div>
                    </div>
              