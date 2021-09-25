<?php if (!empty($cart_items)) { ?>

<style>
@media screen and (max-width: 414px) {
    .rate-card {
        justify-content: center !important;
        height: 50em;
        position: relative !important;
    }
}

</style>

<?php } ?>

<?php if($is_mobile){ ?>
<div class="<?php echo ($is_mobile OR $is_checkout) ? '' : 'col-xs-12 padd-none'; ?>" style="z-index:1;display : <?php echo empty($cart_items) ? 'none' : 'block'; ?>" id="cart-div">
<?php }else{ ?>
<div class="<?php echo ($is_mobile OR $is_checkout) ? '' : 'col-xs-12 padd-none'; ?>" <?php echo $fixed_cart; ?> style="z-index:1;display : <?php echo (empty($cart_items) && $_GET['menu_page'] == "") ? 'none' : 'block'; ?>" id="cart-div">
<?php } ?>
    <div id="cart-box" class="module-box" >
        <div class="panel panel-cart col-sm-12 col-md-12 col-xs-12 rate-card <?php echo (count($cart_items)) ? '' : 'hidden-xs'; ?> grey-bg-smoova" >
        <div class="sidebar_head" >   
                 <span class="sidebar_cart"><?php echo lang('text_heading'); ?></span>
                
                    <?php
                    if ($has_delivery){
                         if ($delivery_status === 'open') { 
                           ?> 
                           <span class="sidebar_cart_items"><i><?php  
                                echo lang('text_estimate_delivery_time');
                              ?> : 
                            <strong>
                          <?php echo sprintf(lang('text_in_minutes'), $delivery_time);
                          ?></strong></i></span>
                          <?php
                            }
                            else if ($delivery_status === 'opening') {
                            ?>
                             <span class="sidebar_cart_items"><i><?php  
                                echo lang('text_estimate_delivery_time');
                              ?> : 
                            <strong>
                            <?php  
                                echo lang('text_is_closed');
                              ?></strong></i></span>
                          <?php  
                             } else { ?>
                                 <span class="sidebar_cart_items"><i><?php  
                                echo lang('text_estimate_delivery_time');
                              ?> : 
                            <strong>
                            <?php 
                                echo lang('text_is_closed');
                                 ?></strong></i></span>
                          <?php  
                             } 
                    }

                        ?>
                
        </div>   
                <div id="cart-alert" class="cart-alert-wrap">
                    <div class="cart-alert"></div>
                    <?php if (!empty($cart_alert)) { ?>
                        <?php echo $cart_alert; ?>
                    <?php } ?>
                </div>
                <!-- Delivery Hided Starts -->
                
                <?php if ($has_delivery OR $has_collection) { ?>
                    <div class="location-control text-center text-muted">
                        <div id="my-postcode" style="display:<?php echo (empty($alert_no_postcode)) ? 'block' : 'none'; ?>">
                            <div class="btn-group-md text-center order-type col-md-12" data-toggle="buttons">
                                <?php if ($has_delivery) { ?>
                                    <label class="col-md-6 btn <?php echo ($order_type === '1') ? 'btn-default active' : 'btn'; ?>" data-btn="btn-primary">
                                        <input type="radio" name="order_type" value="1" <?php echo ($order_type === '1') ? 'checked="checked"' : ''; ?>>&nbsp;&nbsp;<strong><?php echo lang('text_delivery'); ?></strong>
                                        <span class="small center-block">
                                            <?php echo lang('text_to_home'); ?>
                                        </span>
                                        <!-- <span class="small center-block">
                                            <?php if ($delivery_status === 'open') { ?>
                                                <?php echo sprintf(lang('text_in_minutes'), $delivery_time); ?>
                                            <?php } else if ($delivery_status === 'opening') { ?>
                                                <?php echo sprintf(lang('text_starts'), $delivery_time); ?>
                                            <?php } else { ?>
                                                <?php echo lang('text_is_closed'); ?>
                                            <?php } ?>
                                        </span> -->
                                    </label>
                                <?php } ?>
                                <?php if ($has_collection) { ?>
                                    <label class="col-md-6 btn <?php echo ($order_type === '2') ? 'btn-default active' : 'btn'; ?>" data-btn="btn-primary">
                                        <input type="radio" name="order_type" value="2" <?php echo ($order_type === '2') ? 'checked="checked"' : ''; ?>>&nbsp;&nbsp;<strong><?php echo lang('text_collection'); ?></strong>
                                        <span class="small center-block">
                                            <?php echo lang('text_at_restaurant'); ?>
                                        </span>
                                        <!-- <span class="small center-block">
                                            <?php if ($collection_status === 'open') { ?>
                                                <?php echo sprintf(lang('text_in_minutes'), $collection_time); ?>
                                            <?php } else if ($collection_status === 'opening') { ?>
                                                <?php echo sprintf(lang('text_starts'), $collection_time); ?>
                                            <?php } else { ?>
                                                <?php echo lang('text_is_closed'); ?>
                                            <?php } ?>
                                        </span> -->
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } 

                /*Delivery  Hided Ends*/
                 ?>

                <div id="cart-info">
                    <?php if ($cart_items) {
                    //     echo '<pre>';
                    // print_r($cart_items);
                    // exit; 
                    ?>
                        <div class="cart-items sidebar_content" style="max-height: 260.35px;">
                        
                        
                            <ul style="padding-left: 0px !important;">
                                <?php foreach ($cart_items as $cart_item) { 
                                    // print_r($cart_totals);
                                    // exit();
                                    ?>
                                    <li class="row padd-none">
                                        <div class="col-sm-7 col-md-6 col-xs-6">
                                        <a class="name-image" onClick="openMenuOptions('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>');">
                                            <?php if (!empty($cart_item['image'])) { ?>
                                                <img class="image img-responsive img-thumbnail" width="<?php echo $cart_images_w; ?>" height="<?php echo $cart_images_h; ?>" alt="<?php echo $cart_item['name']; ?>" src="<?php echo $cart_item['image']; ?>">
                                            <?php } ?>
                                            <span class="sidebar_cart_title" style="display: block;">

                                                <i class="fa fa-plus-circle"></i>
                                                
                                                <span class="quantity"><?php echo $cart_item['qty'].lang('text_times'); ?></span>
                                                <?php echo $cart_item['menu_price']; ?>
                                                <?php //echo $cart_item['name']; ?>
                                                <?php echo lang_trans($cart_item['name'],$cart_item['name_ar']); ?>

                                            </span>
                                        </a>
                                        </div>
                                        <div class="col-sm-3 col-md-4 col-xs-4" >
                                        <p class="sidebar_cart_price">
                                            <span class="amount pull-right"><?php echo $cart_item['sub_total']; ?></span>
                                            
                                        </p>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-xs-2" style="text-align: center;">
                                         <a class="sidebar_cart_remove cart-btn remove text-muted small" onClick="removeCart('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>', '0');"><i class="fa fa-times-circle"></i></a>
                                         </div>
                                         <div class="col-sm-7 col-md-7 col-xs-7">
                                         <?php if (!empty($cart_item['comment'])) { ?>
                                                <br><span class="comment text-muted small">[<?php echo $cart_item['comment']; ?>]</span>
                                            <?php } ?>
                                            <?php if (!empty($cart_item['options'])) { ?>
                                                <span class="options text-muted small"><?php echo $cart_item['options']; ?></span>
                                            <?php } ?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                       <div class="cart-coupon">
                            <div class="input-group">
                            <?php if (!empty($cart_totals['coupon'])) { ?>
                                <input type="text" name="coupon_code" class="form-control" value="<?php echo isset($coupon['code']) ? $coupon['code'] : ''; ?>" placeholder="<?php echo lang('text_apply_coupon'); ?>" style="border-color: #ff8c00;height: 45px !important;" disabled/>
                                <?php  } else{ ?>
                           
                                <input type="text" name="coupon_code" class="form-control" value="<?php echo isset($coupon['code']) ? $coupon['code'] : ''; ?>" placeholder="<?php echo lang('text_apply_coupon'); ?>" style="border-color: #ff8c00;height: 45px !important;"/>
                            <?php  } ?>
                                
                          
                                <!-- <input type="text" name="coupon_code" class="form-control" value="<?php echo isset($coupon['code']) ? $coupon['code'] : ''; ?>" placeholder="<?php echo lang('text_apply_coupon'); ?>" style="border-color: #ff8c00;height: 45px !important;"/> -->
                                
                                
                           
                            
                                <span class="input-group-btn"><a class="btn btn-primary" onclick="applyCoupon();" title="<?php echo lang('button_apply_coupon'); ?>" style="color:#fff !important; pointer-events:<?php echo ($cart_totals['coupon']) ? 'none' : ''?>"><b><?php echo lang('text_apply'); ?></b></a></span>
                            </div>
                        </div>
                        <?php //echo 'menu-'.$_GET['menu_page'];?>
                        <div class="cart-total">
                            <div class="table-responsive">
                                <table width="100%" height="auto" class="table table-none">
                                    <tbody>
                                        <?php if($this->session->userdata('reservation_data')['table_price'] > 0){ ?>
                                        <tr style="height: 40px;">
                                         <td><span class="sidebar_cart_title"><b><?php echo lang('label_price'); ?> : </b></span> </td>
                                         <td class="text-right">
                                         <b><?php echo $this->currency->format($this->session->userdata('reservation_data')['table_price']); ?> </b>  </td>
                                         </tr>
                                         <?php } ?>
                                        <?php foreach ($cart_totals as $name => $total) { ?>
                                            <?php if (!empty($total)) { ?>
                                                <tr style="height: 40px;">
                                                    <td ><span class="sidebar_cart_title" >
                                                        <?php if ($name === 'order_total') { ?>
                                                            <b style="color: #000 !important;"><?php echo $total['title']; ?>:</b>
                                                        <?php } else if ($name === 'coupon' AND isset($total['code'])) { ?>
                                                            <?php echo $total['title']; ?>:&nbsp;&nbsp;
                                                            <a class="remove clickable" onclick="clearCoupon('<?php echo $total['code']; ?>');" ><span class="fa fa-times" ></span></a>
                                                        <?php } else { ?>
                                                            <?php if($total['title'] == "Sub Total"){
                                                                echo '<b>'.lang('sub_total').'</b>:';
                                                            } else if($name == "taxes"){
                                                               
                                                        foreach ($total as $key => $taxs) {
                                                                if(is_numeric($key))
                                                                {
                                                              echo '<b>'.$taxs['tax'].' ( '.$taxs['percent'].'% )   :  <br>';

                                                                }
                                                            }
                                                                //$tax = $this->config->item('tax_percentage');
                                                                //echo '<br><b>Total Tax ( '.$overall_tax.'% )   :  </b>';
                                                            }
                                                            else { 
                                                                  echo $total['title']; ?> :
                                                                <?php }                                                           ?>

                                                          
                                                        <?php } ?>
                                                    </span></td>
                                                    <td class="text-center">
                                                        <?php if ($name === 'coupon') { ?>
                                                            -<?php echo $total['amount']; ?>
                                                        <?php } else if ($name === 'order_total') { ?>
                                                            <span class="order-total" ><b>
                                                                <?php
                                                                // echo $this->currency->format($overall_price);
                                                                echo $total['amount'];
                                                               // print_r($this->session->userdata('cart_contents'));
                                                               


                                                               //echo "<pre/>"; print_r($this->session->userdata('cart_contents'));
                                                                 ?></b></span>
                                                        <?php 

                                                    } else  if ($name === 'cart_total') { ?>

                                                            <b><?php echo $total['amount']; ?></b>
                                                       
                                                        <?php } else if($name == "taxes")  { 
                                                            foreach ($total as $key => $taxs) {
                                                            if(is_numeric($key))
                                                                {
                                                            ?>

                                                             <b><?php echo $taxs['amount'].'<br>'; ?></b>
                                                        <?php }}
                                                           // echo '<br><b>'.$this->currency->format($overall_tax_price).'</b>';

                                                         }
                                                         else{?>
                                                            <b><?php echo $total['amount'].'<br>'; ?></b>
                                                           <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="panel-body"><?php echo lang('text_no_cart_items'); ?></div>
                    <?php } ?>
                </div>
            <?php if (!empty($button_order)) { ?>
            <div class="cart-buttons wrap-none">
                <div class="center-block">
                    <?php 
                    if ($cart_items) {
                        echo $button_order; 
                    }
                    ?>
                    <?php if (!$is_mobile) { ?>
                        <a class="btn btn-link btn-block hidden-xs hidden-sm hidden-lg" href="<?php echo site_url('cart') ?>"><?php echo lang('button_view_cart'); ?></a>
                        <!-- <center><a href="#" id="myButton" style="font-size: 16px;"><b><?php echo lang('click_menu'); ?></b></a></center>  -->
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php } ?>
        </div>

       
    </div>
</div>
<!-- <div id="cart-buttons" class="<?php echo (!$is_mobile AND !$is_checkout) ? 'visible-xs' : 'hide'; ?>">
    <a  href="<?php echo site_url('cart') ?>" style="text-overflow:ellipsis; overflow:hidden;">
    <button class="btn btn-default cart-toggle">
        <?php echo lang('text_heading'); ?>
        <span class="order-total"><?php echo (!empty($order_total)) ? '&nbsp;&nbsp;-&nbsp;&nbsp;'.$order_total : ''; ?></span>
        </button>
    </a>
</div>
<?php if (!$is_mobile) { ?>
<div class="cart-alert-wrap cart-alert-affix visible-xs-block"><div class="cart-alert"></div><?php if (!empty($cart_alert)) { echo $cart_alert; } ?></div>
<?php } ?> -->
<script type="text/javascript"><!--
    var alert_close = '<button type="button" class="close top-20" data-dismiss="alert" aria-hidden="true">&times;</button>';

    var cartHeight = pageHeight-( 65/100*pageHeight);

    $(document).on('ready', function() {
        $('.cart-alert-wrap .alert').fadeTo('slow', 0.1).fadeTo('slow', 1.0).delay(5000).slideUp('slow');
        $('#cart-info .cart-items').css({"height" : "auto", "max-height" : cartHeight, "overflow" : "auto", "margin-right" : "-15px", "padding-right" : "5px"});

        $(window).bind("load resize", function() {
            var sideBarWidth = $('#content-right .side-bar').width();
            $('#cart-box-affix').css('width', sideBarWidth);
        });
    });

    $(document).on('change', 'input[name="order_type"]', function() {
        if (typeof this.value !== 'undefined') {
            var order_type = this.value;

            $.ajax({
                url: js_site_url('cart_module/cart_module/order_type'),
                type: 'post',
                data: 'order_type=' + order_type,
                dataType: 'json',
                success: function (json) {
                    if (json['redirect'] && json['order_type'] == order_type) {
                        window.location.href = json['redirect'];
                    }
                }
            });
        }
    });

    function addToCart(menu_id, quantity) {
        $("#cart-reserve-button").css('display', 'none');
        $("#cart-box-affix").css('display', 'block');
        if ($('#menu-options' + menu_id).length) {
            var data = $('#menu-options' + menu_id + ' input:checked, #menu-options' + menu_id + ' input[type="hidden"], #menu-options' + menu_id + ' select, #menu-options' + menu_id + ' textarea, #menu-options' + menu_id + '  input[type="text"]');
        } else {
            var data = 'menu_id=' + menu_id + '&quantity=' + quantity;
        }

        $('#menu'+menu_id+ ' .add_cart').removeClass('failed');
        $('#menu'+menu_id+ ' .add_cart').removeClass('added');
        if (!$('#menu'+menu_id+ ' .add_cart').hasClass('loading')) {
            $('#menu'+menu_id+ ' .add_cart').addClass('loading');
        }

        $.ajax({
            url: js_site_url('cart_module/cart_module/add'),
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(json) {
                 $('#book_table').hide();
                $('#menu'+menu_id+ ' .add_cart').removeClass('loading');
                $('#menu'+menu_id+ ' .add_cart').removeClass('failed');
                $('#menu'+menu_id+ ' .add_cart').removeClass('added');

                if (json['option_error']) {
                    $('#cart-options-alert .alert').remove();

                    $('#cart-options-alert').append('<div class="alert" style="display: none;">' + alert_close + json['option_error'] + '</div>');
                    $('#cart-options-alert .alert').fadeIn('slow');

                    $('#menu' + menu_id + ' .add_cart').addClass('failed');
                } else {
                    $('#optionsModal').modal('hide');

                    if (json['error']) {
                        $('#menu' + menu_id + ' .add_cart').addClass('failed');
                    }

                    if (json['success']) {
                        $('#menu' + menu_id + ' .add_cart').addClass('added');
                    }

                    updateCartBox(json);
                }
                 var s_elmnt = document.getElementById("res_mod");
                  s_elmnt.scrollIntoView();
            }
        });
    }

    function openMenuOptions(menu_id, row_id) {
        if (menu_id) {
            var row_id = (row_id) ? row_id : '';

            $.ajax({
                url: js_site_url('cart_module/cart_module/options?menu_id=' + menu_id + '&row_id=' + row_id),
                dataType: 'html',
                success: function(html) {
                    $('#optionsModal').remove();
                    $('body').append('<div id="optionsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>');
                    $('#optionsModal').html(html);

                    $('#optionsModal').modal();
                    $('#optionsModal').on('hidden.bs.modal', function(e) {
                        $('#optionsModal').remove();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }

    function removeCart(menu_id, row_id, quantity) {
        $.ajax({
            url: js_site_url('cart_module/cart_module/remove'),
            type: 'post',
            data: 'menu_id' + menu_id + '&row_id=' + row_id + '&quantity=' + quantity,
            dataType: 'json',
            success: function(json) {
                updateCartBox(json)
            }
        });
    }

    function applyCoupon() {
        var coupon_code = $('#cart-box input[name="coupon_code"]').val();
        $.ajax({
            url: js_site_url('cart_module/cart_module/coupon'),
            type: 'post',
            data: 'action=add&code=' + coupon_code,
            dataType: 'json',
            success: function(json) {
                updateCartBox(json)
            }
        });
    }

    function clearCoupon(coupon_code) {
        $('input[name=\'coupon\']').attr('value', '');

        $.ajax({
            url: js_site_url('cart_module/cart_module/coupon'),
            type: 'post',
            data: 'action=remove&code=' + coupon_code,
            dataType: 'json',
            success: function(json) {
                updateCartBox(json)
            }
        });
    }

    function updateCartBox(json) {
        var alert_message = '';

        if (json['redirect']) {
            window.location.href = json['redirect'];
        }

        if (json['error']) {
            alert_message = '<div class="alert">' + alert_close + json['error'] + '</div>';
            updateCartAlert1(alert_message);
            // window.location.reload();
        } else {
            if (json['success']) {
                alert_message = '<div class="alert">' + alert_close + json['success'] + '</div>';
              // window.location.reload();
            }

            $('#cart-box').load(js_site_url('cart_module/cart_module #cart-box > *'), function(response) {
                updateCartAlert(alert_message);
                // window.location.reload();

            });
        }
    }

    function updateCartAlert(alert_message) {
        //window.location.reload();
        if (alert_message != '') {
            $('.cart-alert-wrap .alert, .cart-alert-wrap .cart-alert').empty();
            $('.cart-alert-wrap .cart-alert').append(alert_message);
            $('.cart-alert-wrap .alert').slideDown('slow').fadeTo('slow', 0.1).fadeTo('slow', 1.0).delay(2000).slideUp('slow');
        }
        if ($('#cart-info .order-total').length > 0) {
            $('#cart-box-affix .navbar-toggle .order-total').html(" - " + $('#cart-info .order-total').html());
        }
        else
        {
         $('#book_table').show();
        }

        $('#cart-info .cart-items').css({"height" : "auto", "max-height" : cartHeight, "overflow" : "auto", "margin-right" : "-15px", "padding-right" : "5px"});
    }
    function updateCartAlert1(alert_message) {
        //window.location.reload();
        if (alert_message != '') {
            $('.cart-alert-wrap .alert, .cart-alert-wrap .cart-alert').empty();
            $('.cart-alert-wrap .cart-alert').append(alert_message);
            $('.cart-alert-wrap .alert').slideDown('slow').fadeTo('slow', 0.1).fadeTo('slow', 1.0).delay(2000).slideUp('slow');
        }

        if ($('#cart-info .order-total').length > 0) {
            $('#cart-box-affix .navbar-toggle .order-total').html(" - " + $('#cart-info .order-total').html());
        }
        else
        {
         $('#book_table').show();
        }

        $('#cart-info .cart-items').css({"height" : "auto", "max-height" : cartHeight, "overflow" : "auto", "margin-right" : "-15px", "padding-right" : "5px"});
    }
    //--></script>