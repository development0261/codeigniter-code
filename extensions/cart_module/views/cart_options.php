<div class="modal-dialog modal-menu-options">
	<div class="modal-content" style="border:0px !important;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" style="color: #fff !important;">&times;</span></button>
			<h4 class="modal-title"  style="color: #fff !important;"><?php echo $text_heading; ?></h4>
		</div>

		<div class="modal-body" id="menu-options<?php echo $menu_id; ?>">
			<div class="row">
			    <div class="col-md-12">
                    <div id="cart-options-alert">
                        <?php if ($cart_option_alert) { ?>
                            <?php echo $cart_option_alert; ?>
                        <?php } ?>
                    </div>

                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo $menu_image; ?>">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading" id="media-heading"> <?php echo lang_trans($menu_name,$menu_name_ar); ?></h4>
                            <?php if ($description) { ?>
                                <p class="description">
                                    <?php echo lang_trans($description,$description_ar); ?>

                                <p class="price"><?php echo $menu_price; ?></p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="menu-quantity form-group clearfix">
                        <div class="col-sm-3 wrap-none">
                            <label for="quantity"><?php echo lang('label_menu_quantity'); ?></label>
                        </div>
                        <div class="col-sm-3 wrap-none">
                            <div class="input-group quantity-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="dwn" type="button"><i class="fa fa-minus" style="color: #fff !important;"></i></button>
                                    </span>
                                <input type="text" name="quantity" id="quantity" class="text-center" value="<?php echo $quantity; ?>" style="height: 41px;width: 41px;">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="up" type="button"><i class="fa fa-plus" style="color: #fff !important;"></i></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="menu-options">
                        <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" />
                        <input type="hidden" name="row_id" value="<?php echo $row_id; ?>" />
                        <?php if ($menu_options) { ?>
                            <?php foreach ($menu_options as $key => $menu_option) { ?>
                                <?php if ($menu_option['display_type'] == 'radio') {?>
                                    <div class="option option-radio">
                                        <input type="hidden" name="menu_options[<?php echo $key; ?>][option_id]" value="<?php echo $menu_option['option_id']; ?>" />
                                        <input type="hidden" name="menu_options[<?php echo $key; ?>][menu_option_id]" value="<?php echo $menu_option['menu_option_id']; ?>" />
                                        <label for=""><?php echo lang_trans($menu_option['option_name'],$menu_option['option_name_ar']); ?></label>

                                        <?php if (isset($menu_option['option_values'])) { ?>
                                            <?php foreach ($menu_option['option_values'] as $option_value) { ?>
                                                <?php isset($cart_option_value_ids[$key]) OR $cart_option_value_ids[$key] = array() ?>
                                                <?php if (in_array($option_value['menu_option_value_id'], $cart_option_value_ids[$key]) OR (empty($cart_option_value_ids[$key]) AND $menu_option['default_value_id'] == $option_value['menu_option_value_id'])) { ?>
                                                    <div class="radio rigt-padd" ><label>
                                                        <input type="radio" name="menu_options[<?php echo $key; ?>][option_values][]" value="<?php echo $option_value['option_value_id']; ?>" checked="checked" />
                                                        <?php echo lang_trans($option_value['value'],$option_value['value_ar']); ?> <span class="price small"><?php echo $option_value['price']; ?></span>
                                                    </label></div>
                                                <?php } else { ?>
                                                    <div class="radio rigt-padd" ><label>
                                                        <input type="radio" name="menu_options[<?php echo $key; ?>][option_values][]" value="<?php echo $option_value['option_value_id']; ?>" />
                                                        <?php  echo lang_trans($option_value['value'],$option_value['value_ar']); ?> <span class="price small"><?php echo $option_value['price']; ?></span>
                                                    </label></div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                                <?php if ($menu_option['display_type'] == 'checkbox') {?>
                                    <div class="option option-checkbox">
                                        <input type="hidden" name="menu_options[<?php echo $key; ?>][option_id]" value="<?php echo $menu_option['option_id']; ?>" />
                                        <input type="hidden" name="menu_options[<?php echo $key; ?>][menu_option_id]" value="<?php echo $menu_option['menu_option_id']; ?>" />
                                        <label for=""><?php echo lang_trans($menu_option['option_name'],$menu_option['option_name_ar']); ?></label>

                                        <?php if (isset($menu_option['option_values'])) { ?>
                                            <?php foreach ($menu_option['option_values'] as $option_value) { ?>
                                                <?php isset($cart_option_value_ids[$key]) OR $cart_option_value_ids[$key] = array() ?>
                                                <?php if (in_array($option_value['menu_option_value_id'], $cart_option_value_ids[$key]) OR (empty($cart_option_value_ids[$key]) AND $menu_option['default_value_id'] == $option_value['menu_option_value_id'])) { ?>
                                                    <div class="checkbox rigt-padd"><label>
                                                        <input type="checkbox" name="menu_options[<?php echo $key; ?>][option_values][]" value="<?php echo $option_value['option_value_id']; ?>" checked="checked" />
                                                        <?php echo lang_trans($option_value['value'],$option_value['value_ar']); ?> <span class="price small"><?php echo $option_value['price']; ?></span>
                                                    </label></div>
                                                <?php } else { ?>
                                                    <div class="checkbox rigt-padd" ><label>
                                                        <input type="checkbox" name="menu_options[<?php echo $key; ?>][option_values][]" value="<?php echo $option_value['option_value_id']; ?>" />
                                                        <?php echo lang_trans($option_value['value'],$option_value['value_ar']); ?> <span class="price small"><?php echo $option_value['price']; ?></span>
                                                    </label></div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                                <?php if ($menu_option['display_type'] == 'select') {?>
                                    <div class="option option-select">
                                        <div class="form-group clearfix">
                                            <div class="col-sm-5 wrap-none">
                                                <input type="hidden" name="menu_options[<?php echo $key; ?>][option_id]" value="<?php echo $menu_option['option_id']; ?>" />
                                                <input type="hidden" name="menu_options[<?php echo $key; ?>][menu_option_id]" value="<?php echo $menu_option['menu_option_id']; ?>" />

                                                <?php if (isset($menu_option['option_values'])) { ?>
                                                    <select name="menu_options[<?php echo $key; ?>][option_values][]" class="form-control rigt-padd" >
                                                        <option value=""><?php echo lang_trans($menu_option['option_name'],$menu_option['option_name_ar']); ?></option>
                                                        <?php foreach ($menu_option['option_values'] as $option_value) { ?>
                                                            <?php isset($cart_option_value_ids[$key]) OR $cart_option_value_ids[$key] = array() ?>
                                                            <?php if (in_array($option_value['menu_option_value_id'], $cart_option_value_ids[$key]) OR (empty($cart_option_value_ids[$key]) AND $menu_option['default_value_id'] == $option_value['menu_option_value_id'])) { ?>
                                                                <option value="<?php echo $option_value['option_value_id']; ?>" data-subtext="<?php echo $option_value['price']; ?>" selected="selected">
                                                                    <?php echo lang_trans($option_value['value'],$option_value['value_ar']); ?>
                                                                </option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo $option_value['option_value_id']; ?>" data-subtext="<?php echo $option_value['price']; ?>">
                                                                    <?php echo lang_trans($option_value['value'],$option_value['value_ar']); ?>
                                                                </option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <!-- div class="form-group clearfix">
                        <div class="col-sm-10 wrap-none wrap-top">
                            <label for="comment"><?php echo lang('label_add_comment'); ?></label>
                            <textarea name="comment" class="form-control" rows="3"><?php echo $comment; ?></textarea>
                        </div>
                    </div> -->
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <br />
                            <?php if ($row_id) { ?>
                                <a  onclick="addToCart('<?php echo $menu_id; ?>');" title="<?php echo lang('text_update'); ?>"><button class="btn btn-primary btn-block"><?php echo lang('button_update'); ?></button></a>
                            <?php } else { ?>
                                <a onclick="addToCart('<?php echo $menu_id; ?>');" title="<?php echo lang('text_add_to_order'); ?>"><button class="btn btn-primary btn-block" ><?php echo lang('button_add_to_order'); ?></button></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	//$('.option-select select.form-control').selectpicker({showSubtext:true});

	$('.quantity-control .btn').on('click', function() {
		var $button = $(this);
		var oldValue = $button.parent().parent().find('#quantity').val();

		if ($button.attr('data-dir') == 'up') {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			var newVal = (oldValue > 0) ? parseFloat(oldValue) - 1 : 0;
		}

		$button.parent().parent().find('#quantity').val(newVal);
	});
});
//--></script>