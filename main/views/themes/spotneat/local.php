<?php echo get_header(); 
 // echo '<pre>'; print_r($this->session->userdata('cart_contents'));
 // exit;
//print_r($this->customer->islogged());

?>
<!-- <div class="fh5co-hero-list">       
    <img src="<?php //echo image_url("data/img1.png");  ?>" >     
    <img src="<?php //echo image_url("data/img2.png");  ?>" >     
    <img src="<?php //echo image_url("data/img3.png");  ?>" >     
</div> -->

<?php if(!$_GET['menu_page']) { ?>
<style>
  .menu-list{
    margin-top: 0px; 
  }
</style>

<?php } ?>

<style>

  @media screen and (max-width:  767px)
  {
    .menu-list
    {
      margin-top: 82px; 
    }
  }
@media screen and (max-width: 414px) {
  .panel-cart{
    height: 60rem;
  }
  .mob-fix{
    max-height: 209rem;
    justify-content: center;
    position: relative;
  }

    footer {
    display: block !important;
    position: relative !important;
    justify-content: center !important;
    }

    #footer div {
        display: block !important;
        padding-bottom: 1rem !important;
     } 

    /* #fh5co-destination {
        position: absolute !important;
    }
    }
    footer {
        justify-content: center !important;
        text-align: center !important;
        position: absolute !important;
        margin-top: 29rem !important;
    }
    #footer div {
        display: block !important;
        padding-bottom: 1rem !important;
    } */
}

</style>

<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('feedback');?></h4>
      </div>
      <div class="modal-body">
        <form id="feedback_form" enctype="multipart/form-data" method="POST">
        <label style="text-align: left;"><?php echo lang('Select_type');?>:</label> 
        <select name="feedback_type" id="feedback_type" class="class-select2">
            <option value=""> </option>
            <option value="Feedback"><?php echo lang('feedback');?></option>
            <option value="Suggestion"><?php echo lang('suggestion');?></option>            
            <option value="Complaints"><?php echo lang('complaints');?></option>
        </select>
        <span id="feed_type" class="search_err" style="display: none;"><?php echo lang('Select_type');?></span>
        <label><?php echo lang('comment');?>:</label> 
        <textarea name="feedback_comment" id="feedback_comment" class="form-control"></textarea>
         <span id="feed_comment" class="search_err" style="display: none;"><?php echo lang('comment');?></span>
         <span id="feed_comment1" class="search_err" style="display: none;"><?php echo lang('comment_more');?></span>
      </div>
      <center style="padding-bottom: 3%;"><input type="submit" name="feedback" class="btn btn-primary" value="Submit" onclick="check_feed();"></center>
      </form>
      <script type="text/javascript">
      $('#feedback_form').submit(function(event) {

            check_feed();

            function check_feed(){
                var type,comment;
                type = document.getElementById("feedback_type").value;
                comment = document.getElementById("feedback_comment").value;
                if(type == '' && comment==''){
                   document.getElementById("feed_type").style.display = 'block';
                   document.getElementById("feed_comment").style.display = 'block';
                   event.preventDefault();
                   return false;
                }else if(type == '' && comment!=''){
                   document.getElementById("feed_type").style.display = 'block';
                   document.getElementById("feed_comment").style.display = 'none';
                   event.preventDefault();
                   return false;
                }else if(type != '' && comment==''){
                   document.getElementById("feed_type").style.display = 'none';
                   document.getElementById("feed_comment").style.display = 'block';
                   event.preventDefault();
                   return false;
                }else{
                   document.getElementById("feed_type").style.display = 'none';
                   document.getElementById("feed_comment").style.display = 'none'; 
                   var str = document.getElementById("feedback_comment").value;                  
                   if(str.length < 10){
                   document.getElementById("feed_comment1").style.display = 'block'; 
                    event.preventDefault();
                   return false;
                   }
                   else{
                    document.getElementById("feed_comment1").style.display = 'none'; 
                    return true;
                  }
                   
                }

              }
  });

      </script>

    </div>

  </div>
</div>
<?php 

if($_SESSION['feedback']=='true'){ 
$_SESSION['feedback']='';
 ?>
   <script type="text/javascript">
$(window).load(function()
{
    $('#myModal2').modal('show');


});
</script>
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('feedback_status'); ?></h4>
      </div>
      <div class="modal-body m_body">
        <p><?php echo lang('feedback_received'); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<?php } ?>


<div id="page-content">
<div class="container">

<?php if ($this->alert->get()) { ?>
    <div id="notification">
        <div class="container">
            <div class="row">
                   <div class="col-md-12">
                    <?php echo $this->alert->display(); ?>
                </div>
            </div>
        </div>
    </div>
<?php }


 ?>
<div id="" class="fh5co-section-gray">
    <div class="">
        <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 mob-nopad">    
            <div class="col-sm-12 col-md-12 col-xs-12 mob-nopad">  
             
                <img class="location-banner" src="<?php echo $banner_image; ?>" >
             
            </div>
        </div>
            <div class="col-sm-12 col-md-12 col-xs-12 mob-fix mob-nopad">
                
            
            <div id="res_mod" class="col-sm-4 col-md-4 col-xs-12 flt-right mob-nopad" >
            
                
                     <div class="col-sm-12 col-xs-12 col-md-12 padd-none" style="display:<?php if($_GET['action'] === 'checkout' || $_GET['menu_page'] != "") { echo 'none';}else{echo 'block';} ?>">
                        <?php 
                        $ctlObj = modules::load('reservation_module/Reservation_module/');
                        $reservation_module=$ctlObj->index();
                        echo $reservation_module;?>                      

                    </div>
                    <div class="col-sm-12 col-xs-12 col-md-12 padd-none" style="display:<?php if($_GET['action'] === 'select_time' || $_GET['menu_page'] ) { echo 'block';}else{ echo 'none';} ?>">
                    <?php echo get_partial('content_right', 'col-sm-12 col-md-12 col-xs-12 padd-none'); ?>
                    </div>
                    <div class="panel col-sm-12 col-xs-12 col-md-12 padd-none" style="display:<?php echo ($_GET['action'] === 'checkout') ? 'block' : 'none'; ?>">
                    <div class="sidebar_check_cont"><?php echo lang('summary_details'); ?></div>
          <?php if(empty($this->session->userdata('cart_contents')) || $payment_details['payment_status'] == 0) {?>
                        <form  accept-charset="utf-8" id="confirm-form" action="<?php echo site_url()?>Local/reserve_order_insert" method="post" role="form">
                        <input type="hidden" name="method" value="book_table">
                    <?php }else{?>
                       <!-- <form method='post' id="confirm-form" action='https://<?php //echo $payment_details['payment_api_mode'];?>.2checkout.com/checkout/purchase'> -->
                        <form method='post' id="confirm-form" action="<?php echo site_url()?>Local/reserve_order_insert" >

                       
                    <?php }?>
                    

                        <div class="col-sm-12 col-xs-12 col-md-12 ">
                            <label class="sidebar_cart_title"><?php echo lang('name'); ?>*</label><br>
                            <input type="text" class="form-control" readonly name="card_holder_name" id="card_holder_name" value="<?php echo $cus_name;?>"   autocomplete="off">
                            <span id="ent_name" class="search_err" style="display: none;"><?php echo lang('enter_name'); ?></span>
                        </div>
                        <div class="col-sm-12 col-xs-12 col-md-12">
                            <label class="sidebar_cart_title"><?php echo lang('email'); ?>*</label><br>
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $cus_email;?>" onkeyup="AjaxLookup()"  autocomplete="off" disabled>
                            <input type="hidden" name="email1" id="email1" value="<?php echo $cus_email;?>">
                            <span id="emailchecker"></span>
                            <span id="ent_email" class="search_err" style="display: none;"><?php echo lang('enter_email'); ?></span>
                        </div>


                        <div class="col-sm-12 col-xs-12 col-md-12">
                            <label class="sidebar_cart_title"><?php echo lang('mobile'); ?>*</label><br>

                            <div class="col-sm-12 col-xs-5 col-md-4 padd-none">
                        <select class="class-select2" name="country_code">
                            <?php foreach($phone_code as $pcode){?>
                                <option data-countryCode="<?php echo $pcode->code;?>" value="<?php echo $pcode->dial_code;?>"<?php if($cus_mobile[0] == $pcode->dial_code) {echo ' selected';} else if($pcode->dial_code == '+91' && $cus_mobile[0] == '') {echo ' selected';}?>><?php echo $pcode->code.' ('.$pcode->dial_code.')';?></option>
                            <?php }?>
                            </select>
                            </div>
                            <div class="col-sm-12 hidden-xs">&nbsp;</div>
                            <div class="col-sm-12 col-xs-7 col-md-8 padd-right pad-l0">
                                <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo $cus_mobile[1];?>" maxlength="10"   autocomplete="off">
                                <span id="spnPhoneStatus"></span>
                            <span id="ent_mobile" class="search_err" style="display: none;"><?php echo lang('enter_mobile'); ?></span>
                            </div>

                        </div>
                        <?php 
                        $reservation_data=$_SESSION['reservation_data'];
                        if($reservation_data==''){ 
                          if($_SESSION['local_info']['order_type'] != 2)
                          {  
                          ?>
                        <div class="col-sm-12 col-xs-12 col-md-12">
                            <label class="sidebar_cart_title"><?php echo lang('delivery_address'); ?>*</label><br>
                            <select class="class-select2" name="delivery_address" id="delivery_address" style="
    background-position: 99%;">
                             <?php  foreach($delivery_address as $address){ ?>
                              <option value="<?php echo $address['address_id'];?>"<?php 
                                if($address['default_address'] == 'on') {echo ' selected';} 
                                ?> >
                                <?php echo $address['address_1'].', '.$address['address_2'].', '.$address['city'].', '.$address['state'].', '.$address['postcode'];?>
                              </option>
                                  
                              <?php }
                              ?>
                              <option value="add_new_addr">Add New Address</option>
                              </select>
                              <span id="address_err" class="search_err" style="display: none;"> Enter New Address</span>
                        </div>
                        <div class="col-sm-12 col-xs-12 col-md-12" id="new_address" style="display: none;">
                          <br />   
                          <div class="col-sm-12 padd-none">                      
                             <input type="text" name="address[address_1]" id="street_number" class="form-control" onFocus="geolocate()" placeholder="Enter Address" ><br /> 
                          </div>
                          <div class="col-sm-12 padd-none">
                            <input type="text" name="address[address_2]" id="route" class="form-control" placeholder="Street Name" readonly /><br /> 
                          </div>
                          <div class="col-sm-12 padd-none">
                            <input type="text" name="address[city]" id="locality" placeholder="City" class="form-control" readonly / ><br /> 
                          </div>
                          <div class="col-sm-12 padd-none">
                            <input type="text" name="address[state]" id="administrative_area_level_1" class="form-control" placeholder="State" readonly /><br />
                          </div>

                          <input type="hidden" name="address[postcode]" id="postal_code" class="form-control" >
                          <div class="col-sm-12 padd-none"  >
                            <input type="text" name="address[country]" id="country" placeholder="Country" class="form-control" readonly /><br />
                          </div>
                          <input type="hidden" name="address[location_lat]" id="inputaddresslatitude" class="form-control">
                          <input type="hidden" name="address[location_lng]" id="inputaddresslongitude" class="form-control">
                        </div>
                        <div class="col-sm-12 col-xs-12 col-md-12">
                            <label class="sidebar_cart_title"><?php echo lang('comments'); ?></label><br>
                            <input type="text" class="form-control" name="comment" id="comment" value="" autocomplete="off">
                        </div>
                        <script type="text/javascript">
                         $(document).ready(function() {
                              var currentSelectVal = $('#delivery_address').val();
                              if(currentSelectVal == 'add_new_addr'){
                                    $('#new_address').css('display','block');
                                  }else{
                                    $('#new_address').css('display','none');
                                  }
                          });

                          $('#delivery_address').change(function() {
                                  var new_address = $('#delivery_address').val();
                                  if(new_address == 'add_new_addr'){
                                    $('#new_address').css('display','block');
                                  }else{
                                    $('#new_address').css('display','none');
                                  }
                           });
                        </script>
                        <?php } ?>
                        <input type='hidden' name='currency_code' value='USD'/>
                        <input type='hidden' name='sid' value="<?php echo $payment_details['payment_seller_id'];?>"/>
                        <input type='hidden' name='mode' value='2CO' />
                        <input type='hidden' name='li_0_type' value='product' />
                        <input type='hidden' name='li_0_name' value='invoice123' />
                        <input type='hidden' name='li_0_price' id="payment_tot" value="<?php  echo $total_amount; ?>" />
                        <div class="col-sm-12 col-xs-12 col-md-12 " style="margin: 20px 0px;">

                        <?php if($sess_amount && $tax_percentage) {?>
                          <div class="col-sm-8 col-xs-3 col-md-8">
                            <span class="book-title"><?php echo lang('booking_price'); ?> : </span>
                          </div>
                          <div class="col-sm-4 col-xs-3 col-md-4">
                            <b><?php echo $this->currency->format($sess_amount);?></span></b>
                          </div>
                          <div class="col-sm-8 col-xs-3 col-md-8">
                            <span class="book-title"><?php echo lang('tax'); ?>(<?php echo $this->config->item('tax_percentage');?>%) :</span>
                          </div>
                          <div class="col-sm-4 col-xs-3 col-md-4">
                              <b><?php echo $this->currency->format($tax_amount);?></span></b>
                          </div>
                        <?php } ?>

                        <div class="col-sm-8 col-xs-6 col-md-8">
                        <span class="book-title" id="total_amount" name="total_amount"><?php echo lang('total'); ?> </span>
                        </div>
                        <div class="col-sm-4 col-xs-6 col-md-4">
                        <b><?php echo $this->currency->format($total_amount);?></span></b>
                        </div>
                        </div>


                        <!-- Reward Points -->
                       
                        <?php
                        if(empty($this->session->userdata('cart_contents'))) {
                           $order = 'no_order';
                        }else{
                           $order= 'order';
                        }
                      
                      
                      if(($rewards_enable == 1)  || (($rewards_enable == 2) &&(!empty($this->session->userdata('cart_contents'))) ) || (($rewards_enable == 3) &&(empty($this->session->userdata('cart_contents'))) )  ){
                         if($cus_reward && $reward_price_eligible) {?>
                        <div class="col-sm-12 col-xs-12 col-md-12 " style="margin: 10px 0px;">
                            <?php echo lang('your_reward_point'); ?> - <span class="book-title1"><?php echo $cus_reward;?> <br /><br />
                            <?php if($rewards_method == "custom") {?>
                            
                            <?php echo lang('you_can_use'); ?> - <span class="book-title1"><?php echo $reward_maximum_amount;?> <?php echo lang('points_only'); ?> </span><br /><br />
                            <?php } ?>

                        <span class="book-title"><input type="checkbox" name="using_reward_points" id="reward_point_chk" value="1" onclick="show_reward_div()"> <?php echo lang('use_reward_points'); ?>  </span> 
                        </div>
                        <?php } ?>
                        <div class="col-sm-12 col-xs-12 col-md-12 " id="reward_div" style="margin: 10px 0px;display: none">
                            <div class="col-sm-8 col-xs-3 col-md-8">
                               <span class="book-title1" align="left"><?php echo lang('reward_point'); ?></span>
                            </div>
                            <div class="col-sm-4 col-xs-3 col-md-4">
                              <input type="text" class="form-control"  name="reward_point" id="reward_point" value="0" onkeyup="calculate_reward(this.value)" style="height: 30px !important;width: 70px;" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-xs-12 col-md-12 text-right ">
                            <span id="reward_valid" class="search_err"  style="display: none"><?php echo lang('reward_max_validation'); ?></span>
                            <span id="reward_valid1" class="search_err"  style="display: none"><?php echo lang('reward_max_validation'); ?></span>
                            </div>
                            <div class="col-sm-8 col-xs-3 col-md-8">
                                <span class="book-title1" align="left"><?php echo lang('reward_amount'); ?></span>
                            </div>
                            <div class="col-sm-4 col-xs-3 col-md-4">
                                
                                <input type="text" class="form-control"  name="reward_amount" id="reward_amount" value="0" disabled="disabled" style="height: 30px !important;width: 70px;">
                            </div>
                            <div class="col-sm-8 col-xs-3 col-md-8">
                                <span class="book-title" align="left"><?php echo lang('amount_to_be_paid'); ?></span>

                            </div>
                             <div class="col-sm-4 col-xs-3 col-md-4">
                            
                             <input type="text" class="form-control"  name="reward_total_amount" id="reward_total_amount" value="<?php echo $total_amount;?>" disabled="disabled" style="height: 30px !important;width: 70px;">
                             
                             <input type="hidden" name="using_reward_amount" id="using_reward_amount" value="<?php echo $reward_amount;?>">
                          </div>
                          <input type="hidden" name="rew_point_value" id="rew_point_value" value="<?php echo $reward_point_value;?>">
                          <input type="hidden" name="rew_point_price" id="rew_point_price" value="<?php echo $reward_point_price;?>">
                         </div>
                          
                        <?php } ?> 
                        <!-- Reward Points --> 

                        <div class="col-sm-12 col-xs-12 col-md-12 " style="margin-bottom: 20px;">
                           <div class="col-sm-6 col-xs-3 col-md-6">
                             <span class="book-title1" align="left">Payment type : </span>
                           </div>
                            <div class="col-sm-6 col-xs-9 col-md-6">
                              <select name="payment_type" id="payment_type" class="class-select2" required="required" onChange="getDropDown(this)">
                               <!--  <option>Select </option> -->
                              <?php if($payments){
                                foreach($payments as $payment){
                                  if($payment=="cod")
                                  echo '<option value="cash">Cash</option>';

                                 if($payment=="paypal_express")
                                 echo '<option value="paypal">Paypal</option>';

                                  if($payment=="stripe")
                                 echo '<option value="stripe">Card</option>';


                                }
                              }else{?>
                                <option value="cash">Cash</option>
                                <option value="stripe">Card</option>
                                <option value="paypal">Paypal</option>
                               <?php } ?>
                              </select>
                            </div>
                        </div>
                        <?php } ?> 
                        <div class="col-sm-12 col-xs-12 col-md-12 " style="display: none;" id="stripe_pay"> 
                          
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_test_xVVyfHyNOM12eAJ5xgBhsVwc"
                                data-description="Access for a year"
                                data-amount="<?php echo $stripe_amount; ?>"
                                data-locale="<?php echo $currency_code;?>" data-value="Pay with Stripe"></script>

                        </div>
                         <div class="col-sm-12 col-xs-12 col-md-12 " style="display: none;" id="paypal_pay"> 
                          
                        <!--<form class="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="paypal_form" role="form">-->
                            <input type="hidden" name="cmd" value="_xclick" />
                            <input type="hidden" name="no_note" value="1" />
                            <input type="hidden" name="business" value="arun.uplogic@gmail.com" />
                            <input type="hidden" name="lc" value="UK" />
                            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                            <input type="hidden" name="first_name" value="<?php echo $cus_name;?>" />
                            <input type="hidden" name="last_name" value="Customer's Last Name" />
                            <input type="hidden" name="payer_email" value="<?php echo $cus_email;?>" />
                            <input type="hidden" name="item_number" value="123456" / >
                            <input type="hidden" name="amount" value="<?php echo $total_amount;?>" / >
                             <input type="hidden" name="currency_code" value="<?php echo $this->currency->getCurrencyCode();?>" / >
                             <input type="hidden" name="item_name" value="test item" / >
                             <input type="hidden" name="return" value="<?php echo site_url()?>Local/reserve_order_insert" / >
                             <input type="hidden" name="cancel" value="<?php echo site_url()?>" / >
                             <input type="hidden" name="notify_url" value="<?php echo site_url()?>Local/reserve_order_insert" / >
                             <input type='hidden' name='rm' value='2'>
                             <input type="button" id="loadimg_paypal" class="btn btn-primary btn-block btn-sm" name="paypal_submit" value="<?php echo lang('confirm_reserve'); ?>">
                        <!--</form>-->

                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 " id="cash_pay" style="display: block;">                   
                          <div style="margin-bottom: 20px;"></div>
                          <input type="button" id="loadimg" class="btn btn-primary btn-block btn-sm" name="reserve" value="<?php echo lang('confirm_reserve'); ?>">
                          <div id="buttonreplacement" style="display:none;background-color: transparent !important;" class="btn btn-block btn-sm">
                            <img src="<?php echo root_url();?>assets/images/preloader.gif" height="100" width="100" alt="loading...">
                          </div>
                        </div>

                        <script type="text/javascript">
                          function getDropDown(){
                            
                          var pay_type = $('#payment_type').val();
                            if(pay_type == 'cash'){
                              $('#cash_pay').show();
                              $('#stripe_pay').hide();
                              $('#paypal_pay').hide();
                            }else if(pay_type == 'stripe'){
                              $('#cash_pay').hide();
                              $('#stripe_pay').show();
                              $('#paypal_pay').hide();
                              $(".stripe-button-el").addClass("btn-block");
                              
                            }else if(pay_type == 'paypal'){

                              $('#cash_pay').hide();
                              $('#stripe_pay').hide();
                              $('#paypal_pay').show();
                              
                              
                            }
                          }
                        </script>

                         <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 20px">
                          </div>
                        </form>
                    </div>   

                    
                     <?php 
                        $reservation_data=$_SESSION['reservation_data'];
                        if($reservation_data!=''){ ?>
                    <div class="col-sm-12 col-xs-12 col-md-12 padd-none">
                        <div class="sidebar_cart_good">Good to Know</div>
                        <div class="sidebar_check_cont"><?php echo lang('open_hours'); ?></div>
                        <p class="sidebar_cart_content">15:00-18:00 Hours</p>
                        <hr>
                        <div class="sidebar_check_cont"><?php echo lang('cancellation_payment'); ?></div>
                        <p class="sidebar_cart_content"><?php echo lang('cancel_text'); ?><a href="#"><?php echo lang('table_booking_conditions'); ?></a> <?php echo lang('table_food'); ?> </p>
                        <!-- <hr>
                        <div class="sidebar_check_cont"><?php echo lang('card_accepted'); ?></div>
                        <p class="sidebar_cart_content"><img src="<?php echo image_url("data/card.png"); ?>"></p> -->
                    </div>
                    <?php } ?>
                

               
            </div>

            <div class="col-sm-8 col-md-8 col-xs-12 menu-list mob-nopad" style="margin-bottom:20px;">
                    <div class="brdr-full-right">
                    <?php if(!$_GET['menu_page']) { ?>
                    <div class="row">
                      
                            <div class="col-sm-4 col-md-5 col-xs-5">
                                <?php 
                                $back_url = $this->agent->referrer();?>
                                <span class="padd-left return ret-10"><a href="<?php echo $back_url.'?action=select_time&menu_page=true'; ?>"  style="cursor: pointer;" ><b><?php echo '<< '.lang('button_back'); ?></b></a></span>
                                <!-- <h1 class="list-title padd-left"><?php echo lang_trans($location_name , $location_name_ar) ;?></h1>  -->
                                <!-- <div class="location padd-left col-sm-12 col-md-12 col-xs-12">
                                    <div class="col-sm-1 col-md-1 col-xs-1">
                                        <i class="fa fa-map-marker" style="color:#f5511e"></i>
                                    </div>
                                  
                                    <div class="col-sm-11 col-md-11 col-xs-10">
                                        <span class="full_location">
                                            <b><?php echo lang('address'); ?></b> <br />  <?php  echo  lang_trans($location_address_1 , $location_address_1_ar );?>  
                                            
                                        </span>
                                    </div> -->

                                    <!-- <div class="col-sm-1 col-md-1 col-xs-1">
                                        <i class="fa fa-phone" style="color:#f5511e"></i>
                                    </div>
                                    <div class="col-sm-11 col-md-11 col-xs-10">
                                        <span class="full_location">
                                        <b><?php //echo lang('contact'); ?> </b><br /> 
                                            <?php //echo $contact;?>
                                        </span>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-xs-1">
                                        <i class="fa fa-envelope" style="color:#f5511e"></i>
                                    </div>
                                    <div class="col-sm-11 col-md-11 col-xs-10">
                                        <span class="full_location">
                                            <b><?php //echo lang('email'); ?> </b>   <br />                                  
                                            <a href="mailto:<?php //echo $email;?>"><?php //echo $email;?></a>
                                        </span>
                                    </div> -->
                                <!-- </div> -->
                            </div>

                            <div class="col-sm-8 col-md-7 col-xs-7 ">
                                <div class="col-sm-12 col-md-12 col-xs-12 ">
                                    <div class="col-sm-5 col-md-5 col-xs-5 padd-none">
                                    <!--  <p class="book"><?php echo lang('book_a_table'); ?> <?php echo $this->currency->format($first_table_price);?></p>-->
                                   
                                    </div> 
                                    <div class="col-sm-7 col-md-7 col-xs-7 padd-none">
                                      <span class="ratings text-right">
                                          <?php
                                          $starNumber =$location_ratings;
                                            for($x=1;$x<=$starNumber;$x++) {
                                                echo '<span class="fa fa-star"></span>';
                                            }
                                            if (strpos($starNumber,'.')) {
                                                echo '<span class="fa fa-star-half"></span>';
                                                $x++;
                                            }
                                            while ($x<=5) {
                                                echo '<span class="fa fa-star-o"></span>';
                                                $x++;
                                            }
                                        ?>
                                          <span class="ratings1"><?php echo $location_ratings; ?> <?php echo lang('ratings'); ?></span>
                                        </span>
                                    <!-- <span class="ratings1">
                                    <span class="star_rate">                                    
                                        <a href="#"><span class="fa fa-star"></span> <?php echo $location_ratings;?></a></span>
                                    </span> -->
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12 col-md-12 col-xs-12">
                                    
                                    <div class="map" id="map">                                   
                                    </div>
                                </div> -->
                            </div>

                            <div class="col-sm-12 col-md-12 col-xs-12 ">
                              <div class="col-sm-12 col-md-12 col-xs-12 ">
                                <div class="ratings-with-title">
                                    <h1 class="list-title list-bottom"><?php echo lang_trans($location_name , $location_name_ar) ;?></h1>
                                </div>
                                  <div class="row">
                                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  
                                          <div class="location location-top">
                                              <div class="row">
                                                  <div class="col-sm-1 col-md-1 col-xs-1">
                                                      <i class="fa fa-map-marker" style="color:#f5511e"></i>
                                                  </div> 
                                                  <div class="col-sm-11 col-md-11 col-xs-10">
                                                      <span class="full_location">
                                                          <b><?php echo lang('address'); ?></b> <br />  <?php  echo  lang_trans($location_address_1 , $location_address_1_ar );?>   
                                                      </span>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-sm-6 col-md-6 col-xs-12">
                                          <div class="map mar-20" id="map"></div>
                                      </div>
                                    </div>
                                  </div>
                              </div>

                        </div>  
                         <div class="row">  
                         <div class="col-sm-12 col-md-12 col-xs-12 padd-none">
                             <div id="local-gallery" class="tab-pane row wrap-all col-sm-12 col-md-12 col-xs-12 ">
                                
                            </div>
                        </div>
                      </div>
                       <?php } ?>
                    <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12 padd-none">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <div class="col-sm-12 col-md-12 col-xs-12 mob-nopad">                    
                                <div class="about-content mt-10-list">
                                       <?php if(!$_GET['menu_page']) { ?>
                                      <h4 class="about-heading"><?php echo lang('about'); ?></h4>
                                       <?php echo lang_trans($local_info['local_description'] , $local_info['local_description_ar']); ?>
                                       <?php } else { ?>
                                       <?php if(empty($this->session->userdata('cart_contents'))) {?><?php } ?>
                                      <div class="row">
                                       <div class="col-sm-7 col-md-7 col-xs-6 mob-nopad">
                                       
                                       <span class="padd-left return" style="padding-left: 0px !important"><a href="<?php echo site_url().'locations?search=%20';?>"><b><?php echo lang('return'); ?></b></a></span>
                                       
                                       <?php if(empty($this->session->userdata('cart_contents'))) {?><?php } ?>
                                       </div>
                                       
                                       <div class="col-sm-5 col-md-5 col-xs-6">
                                         <span class="ratings text-right mt-0">
                                              <?php
                                              $starNumber =$location_ratings;
                                                for($x=1;$x<=$starNumber;$x++) {
                                                    echo '<span class="fa fa-star"></span>';
                                                }
                                                if (strpos($starNumber,'.')) {
                                                    echo '<span class="fa fa-star-half"></span>';
                                                    $x++;
                                                }
                                                while ($x<=5) {
                                                    echo '<span class="fa fa-star-o"></span>';
                                                    $x++;
                                                }
                                            ?>
                                              <span class="ratings1"><?php echo $location_ratings; ?> <?php echo lang('ratings'); ?></span>
                                            </span>
                                          </div>
                                        
                                      </div>
                                      <div class="ratings-with-title">
                                          <div class="list-with-btn">
                                              <h1 class="list-title padd-none"><?php echo lang_trans($location_name , $location_name_ar) ;?></h1> 
                                          </div>
                                          <div class="title-with-btn">
                                              <div class="book-table-btn" id="book_table">
                                                  <input type="submit" class="btn btn-primary btn-block book-table-order" value="<?php echo lang('book_a_table');?>" onclick="bookatable(<?php echo $location_id;?>)"> 
                                              </div>
                                          </div>
                                      </div>

                                     
                                      <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  
                                            <div class="location location-top">
                                                <div class="row">
                                                    <div class="col-sm-1 col-md-1 col-xs-1">
                                                        <i class="fa fa-map-marker" style="color:#f5511e"></i>
                                                    </div> 
                                                    <div class="col-sm-11 col-md-11 col-xs-10">
                                                        <span class="full_location">
                                                            <b><?php echo lang('address'); ?></b> <br />  <?php  echo  lang_trans($location_address_1 , $location_address_1_ar );?>   
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-xs-12">
                                            <div class="map mar-20" id="map"></div>
                                        </div>

                                    </div>
                                      <h4 class="about-heading"><?php echo lang('about'); ?></h4>
                                      <?php echo lang_trans($local_info['local_description'] , $local_info['local_description_ar']); ?>
                                      <form id="formoid_<?php echo $location_id;?>" action="<?php echo base_url('local')."/".$location_slug;?>"  method="post">
                                              <input type="hidden" id="location" name="location" value="<?php echo $location_id;?>" >
                                      </form>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xs-12 mob-nopad" id="menu_tab_scroll" >
                                <ul class="nav nav-tabs orders-tab" role="tablist">
                                   <?php if($_GET['action'] != 'select_time' && !$_GET['menu_page']){ 
                                   // unset($_SESSION['reservation_data']);
                                    ?>

                                     <li role="presentation" style="display: none;"><a href="#menu_tab" aria-controls="menu_tab" role="tab" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true" style="color: #fff !important;"></i>&nbsp;&nbsp;<?php echo lang('text_tab_menu'); ?></a></li>
                                     <?php }else{ ?>

                                  <li role="presentation" class="active" style="display: block;"><a href="#menu_tab" aria-controls="menu_tab" role="tab" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true" style="color: #fff !important;"></i>&nbsp;&nbsp;<?php echo lang('text_tab_menu'); ?></a></li>
                                   <?php } ?>

                                  <?php if($_GET['action'] != 'select_time' && !$_GET['menu_page']){ ?>
                                    <!-- <li role="presentation" class="active"><a href="#review_tab" aria-controls="review_tab" role="tab" data-toggle="tab"><i class="fa fa-comments-o" aria-hidden="true" style="color: #fff !important;"></i>&nbsp;&nbsp;<?php echo lang('text_tab_review'); ?></a></li> -->

                                  <?php }else{ ?>
                                 <li role="presentation" ><a href="#review_tab" aria-controls="review_tab" role="tab" data-toggle="tab"><i class="fa fa-comments-o" aria-hidden="true" style="color: #fff !important;"></i>&nbsp;&nbsp;<?php echo lang('text_tab_review'); ?></a></li>

                                  <?php } ?>
                                  <?php if($_GET['action'] != 'select_time' && !$_GET['menu_page']){ ?>
                                  <li role="presentation" class="active"><a href="#info_tab" aria-controls="info_tab" role="tab" data-toggle="tab"><i class="fa fa-info-circle" aria-hidden="true" style="color: #fff !important;"></i>&nbsp;&nbsp;<?php echo lang('text_tab_info'); ?></a></li>
                                  <?php }else{ ?>

                                  <li role="presentation"><a href="#info_tab" aria-controls="info_tab" role="tab" data-toggle="tab"><i class="fa fa-info-circle" aria-hidden="true" style="color: #fff !important;"></i>&nbsp;&nbsp;<?php echo lang('text_tab_info'); ?></a></li>
                                  <?php } ?>

                                  <?php if($local_gallery) { ?><li role="presentation" ><a href="#gallery_tab" aria-controls="gallery_tab" role="tab" data-toggle="tab"><i class="fa fa-info-circle" aria-hidden="true" style="color: #fff !important;"></i>&nbsp;&nbsp;<?php echo lang('text_tab_gallery'); ?></a></li>
                                        <?php }?>
                                </ul>
                                <div class="login-feed">
                                  <div class="login-feed-right">
                                      <?php 
                                        
                                        $is_logged = $this->customer->isLogged(); 
                                        if($is_logged == ''){ 
                                          ?>
                                          <a href="<?php echo site_url().'login'; ?>"><button class="btn btn-primary btn-sm feed-btn" id="login" ><?php echo lang('write_feedback'); ?></button></a>
                                       <?php }else{
                                      ?>                         
                                          <button class="btn btn-primary btn-sm feed-btn" id="feedback" data-toggle="modal" data-target="#myModal1"><?php echo lang('suggestion_queries'); ?> </button>
                                          <?php } ?>
                                    </div>
                                </div>
                                <div class="tab-content orders-tab-content" style="margin-bottom: 20px;">
                                    <div id="gallery_tab" role="tabpanel" class="tab-pane" >
                                      <?php if($local_gallery) { ?><?php  echo load_partial('local_gallery', $local_gallery); ?>
                                        <?php }?>
                                    </div>
                                    <?php if($_GET['action'] != 'select_time' && !$_GET['menu_page']){ ?>
                                    <div id="menu_tab" role="tabpanel" class="tab-pane" >
                                      <?php } else{ ?>
                                    <div id="menu_tab" role="tabpanel" class="tab-pane active" >
                                      <?php } ?> 
                                        <div class="row">
                                          <div class="col-sm-12 col-md-12 col-xs-12 padd-none">
                                            <?php echo get_partial('content_left', 'col-md-4 hidden-xs hidden-sm'); ?>
                                            <?php echo load_partial('menu_list', $menu_list); ?>
                                            
                                          </div>
                                        </div>
                                    </div>
                                  <?php if($_GET['action'] != 'select_time' && !$_GET['menu_page']){ ?>
                                  <div id="review_tab"  role="tabpanel" class="tab-pane" >
                                  <?php }else{ ?>
                                  <div id="review_tab" role="tabpanel" class="tab-pane" >
                                  <?php } ?> 
                                      <div class="row">
                                          <div class="col-sm-12 col-md-12 col-xs-12 ">
                                              <div class="row ">
                                                  <div class="user_reviews ">
                                                      <div class="row">
                                                          <div class="review col-sm-12 col-md-12 col-xs-12 padd-none">
                                                              <div class="col-sm-12 col-md-12 col-xs-12 padd-none">
                                                                  <h1 class="list-title padd-left"><?php echo lang('user_reviews'); ?></h1>
                                                              <!-- <div class="col-sm-12 col-md-12 col-xs-12 padd-none">
                                                                  
                                                                  <div class="col-sm-12 col-md-12 col-xs-12">
                                                                       
                                                                              <a href="<?php echo site_url().'account/reservations'; ?>"><button type="submit" class="btn btn-primary btn-sm text-right"><?php echo lang('write_review'); ?></button></a>
                                                                  </div>
                                                              </div> -->
                                                                  <div class="col-sm-12 col-md-12 col-xs-12 padd-none">
                                                                      <div class="menu_brdr1">
                                                                         <!-- Tab panes -->
                                                                          <div class="tab-content">
                                                                               <div role="tabpanel" class="tab-pane active" id="positive" >
                                                                                  <div class="row" >
                                                                                   <?php echo load_partial('local_reviews', $local_reviews); ?>
                                                                                     
                                                                                      <!--<div class="col-sm-12 col-md-12 col-xs-12 padd-none text_center">
                                                                                          <a href="#" class="view_more">View more (453)</a>
                                                                                      </div>-->
                                                                                  </div>
                                                                              </div>
                                                                              
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($_GET['action'] != 'select_time' && !$_GET['menu_page']){ ?>
                                    <div id="info_tab"  role="tabpanel" class="tab-pane active" >
                                      <?php }else{ ?>
                                    <div id="info_tab" role="tabpanel" class="tab-pane" >
                                      <?php } ?> 
                                        <div class="row">
                                            <div class="review col-sm-12 col-md-12 col-xs-12 padd-none">
                                                <?php echo load_partial('local_info', $local_info); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>          
                            </div>
                          </div>
                      </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div id="confirm_reserve" style="display: none;">             

                    <?php echo $status; ?>
</div>
<div class="clearfix"></div>
<?php echo get_footer(); ?>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
<script type="text/javascript">
/*$(document).ready(function() {
    var action_table=$('input[name="action"]').val();
    if(action_table == 'select_time')
    {
        alert("hai");
    }
});*/


function show_reward_div()
{
  var total_amount = "<?php echo $total_amount;?>";
  if(document.getElementById('reward_point_chk').checked) {
    $("#reward_div").show();

  } else {
     document.getElementById("payment_tot").value = total_amount;
    $("#reward_div").hide();
     document.getElementById("reward_point").value = 0;
     document.getElementById("reward_amount").value = 0;
     document.getElementById("reward_total_amount").value = total_amount;
      $("#loadimg").attr("disabled", false);
      $("#loadimg_paypal").attr("disabled", false);
  }
}
function calculate_reward(val)
{
  var max_amount = "<?php echo $reward_maximum_amount?>";

  
  var reward_point_value  = $("#rew_point_value").val();
  var reward_point_amount = $("#rew_point_price").val();
  var total_amount = "<?php echo $total_amount;?>";
  
  var reward_amount = (parseFloat(val) / parseFloat(reward_point_value)) * parseFloat(reward_point_amount);

  var rew_tot_amount = parseFloat(parseFloat(total_amount) - parseFloat(reward_amount)).toFixed( 2 );

if(parseFloat(rew_tot_amount) >0){
 
   $("#loadimg").attr("disabled", false);
   $("#loadimg_paypal").attr("disabled", false);
    document.getElementById("reward_valid1").style.display = 'none';
}
else{
    document.getElementById("reward_valid1").style.display = 'block';
    $("#loadimg").attr("disabled", true);
     $("#loadimg_paypal").attr("disabled", true);
     document.getElementById("reward_valid").style.display = 'block';
     event.preventDefault(); 
}

  if((parseFloat(reward_amount) <= parseFloat(max_amount)) || (parseFloat(reward_amount) < parseFloat(total_amount)))
  {
    
    $("#reward_amount").val(reward_amount);
    $("#reward_total_amount").val(rew_tot_amount);
    $("#using_reward_amount").val(reward_amount);
    $("#payment_tot").val(rew_tot_amount);
    document.getElementById("reward_valid").style.display = 'none';
  }
  else
  {
   document.getElementById("reward_valid1").style.display = 'none';
    document.getElementById("reward_valid").style.display = 'block';
    document.getElementById("payment_tot").value = rew_tot_amount;
    
  }


}
function bookatable(id)
  {
    $("#formoid_"+id).submit();
  }
$('#reward_point').keypress(function(event){

       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
          document.getElementById("reward_valid").style.display = 'block';
           event.preventDefault(); //stop character from entering input
       }

   });
  /*$('#confirm-form').submit(function(event) { alert("hi");

    myFunction();

    //event.preventDefault();
    //alert(document.getElementById("cart_status").value);return false;
    var formEl = $(this);
    var submitButton = $('input[type=submit]', formEl);

    $.ajax({
      type: 'POST',
      url: "<?php //echo site_url().'Local/reserve_order_insert';?>",
      accept: {
        javascript: 'application/javascript'
      },
      data: formEl.serialize(),
      beforeSend: function() {
        submitButton.prop('disabled', 'disabled');
      }
    }).done(function(data) {
        var res = data.split('&');
        $("#reser_id").html(res[0]);
        $("#otp_id").html(res[1]);
        $("#myModal").modal();
      //submitButton.prop('disabled', false);
    });
  });*/

$("#loadimg").click(function(){
    
  var response = myFunction();
  if(response===true){ 
    // event.preventDefault();
    
    var addres = $('#delivery_address').val();
    //console.log(addres);
    
    if(addres == 'add_new_addr'){
      if($('#street_number').val() == ""){
      $("#address_err").show();
      return false;
      }else{
        $('#confirm-form').submit();
     $("#loadimg").hide();
      $("#address_err").hide();
     $("#buttonreplacement").show();
      }
    }
    else{
     $('#confirm-form').submit();
     $("#loadimg").hide();
      $("#address_err").hide();
     $("#buttonreplacement").show();
    }
  } else {
  }
});
$("#loadimg_paypal").click(function(){
    
  var response = myFunction();
  if(response===true){ 
    // event.preventDefault();
    
    var addres = $('#delivery_address').val();
    //console.log(addres);
    
    if(addres == 'add_new_addr'){
      if($('#street_number').val() == ""){
      $("#address_err").show();
      return false;
      }else{

       $('#confirm-form').submit();
     $("#loadimg").hide();
     $("#loadimg_paypal").hide();
     $("#address_err").hide();
     $("#buttonreplacement").show();
      }
    }
    else{
      $('#confirm-form').submit();
     $("#loadimg").hide();
     $("#loadimg_paypal").hide();
      $("#address_err").hide();
     $("#buttonreplacement").show();
    }
  } else {
  }
});

function AjaxLookup() {
            var emAddr = $('#email').val();
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;   
            var eml= emailReg.test( emAddr );
            
           if(!eml) {
               var result = '<span style="color:red;font-weight:bold;">Enter Valid Email</span>';
             $("#emailchecker").html(result);
             $("#ent_email").hide();
             $("#loadimg").attr("disabled", true);
             $("#loadimg_paypal").attr("disabled", true);
            }
          else {

             var result = '<span style="color:green;font-weight:bold;">Valid Email</span>';
            $("#emailchecker").html(result);
             $("#loadimg").attr("disabled", false);
             $("#loadimg_paypal").attr("disabled", false);
            event.preventDefault();
            return false;            
          }
      }
$(window).load(function(){
$(document).ready(function() {
  //$('#myModal2').modal('hide');

    $('#mobile').keyup(function(e) {
        if (validatePhone('mobile')) {
            $('#spnPhoneStatus').html('<b>Valid Mobile Number</b>');
            $('#spnPhoneStatus').css('color', 'green');
        }
        else {
            $('#spnPhoneStatus').html('<b>Invalid Mobile Number</b>');
            $('#spnPhoneStatus').css('color', 'red');
            $('#ent_mobile').hide();

        }
    });
});

function validatePhone(mobile) {
    var a = document.getElementById(mobile).value;
    var filter = /[1-9]{1}[0-9]{8}/;
    if (filter.test(a)) {
      $("#loadimg").attr("disabled", false);
        return true;
    }
    else {
       event.preventDefault();
       $("#loadimg").attr("disabled", true);
        return false;
    }
}
});


function myFunction() {

    var name,email,mobile;

    name = document.getElementById("card_holder_name").value;
    email = document.getElementById("email").value;
    mobile = document.getElementById("mobile").value;

    if(name=='' && email=='' && mobile==''){
       document.getElementById("ent_name").style.display = 'block';
       document.getElementById("ent_email").style.display = 'block';
       document.getElementById("ent_mobile").style.display = 'block';
       return false;
    }else if(name==''){
       document.getElementById("ent_name").style.display = 'block';
       document.getElementById("ent_email").style.display = 'none';
       document.getElementById("ent_mobile").style.display = 'none';
       return false;
    }else if(email==''){
        document.getElementById("ent_email").style.display = 'block';
        document.getElementById("ent_name").style.display = 'none';
        document.getElementById("ent_mobile").style.display = 'none';
        return false;
    }else if(mobile==''){
        document.getElementById("ent_mobile").style.display = 'block';
        document.getElementById("ent_name").style.display = 'none';
        document.getElementById("ent_email").style.display = 'none';
        return false;
    }
    else{ 
        document.getElementById("ent_mobile").style.display = 'none';
        document.getElementById("ent_name").style.display = 'none';
        document.getElementById("ent_email").style.display = 'none';
        document.getElementById("confirm_reserve").style.display = 'block';
        return true;
    }
}
function map() {
var myMapCenter = new google.maps.LatLng(<?php echo $local_info['location_lat']; ?>, <?php echo $local_info['location_lng']; ?>);
var myMapProp = {center:myMapCenter, zoom:12, scrollwheel:false, draggable:false, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("map"),myMapProp);
var marker = new google.maps.Marker({position:myMapCenter});
marker.setMap(map);
}

$("#myButton").click(function() {
  //console.log(window.location.href);return false;
  var url = window.location.href + '&menu_page=true';
  window.location.href = url;
    /*$('html, body').animate({
        scrollTop: $("#menu_tab_scroll").offset().top
    }, 2000);*/
});
</script>

 <script>     

$(document).ready(function() {
  initAutocomplete();
  
});

      var street_number;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {       
        street_number = new google.maps.places.Autocomplete(
         (document.getElementById('street_number')),
            {
              types: ['geocode']
              // componentRestrictions: { country: "au" }
            });
        

        street_number.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {       
        var place = street_number.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
            
          }
        }
        //console.log(place.geometry);
         document.getElementById('street_number').value  = place.address_components[0].long_name;  
        document.getElementById('inputaddresslatitude').value  = place.geometry.location.lat();
        document.getElementById('inputaddresslongitude').value = place.geometry.location.lng();
      }


      function geolocate() {
        document.getElementById("street_number").autocomplete = "new-password";
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
          
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            
              document.getElementById('inputaddresslatitude').value = position.coords.latitude;
              document.getElementById('inputaddresslongitude').value = position.coords.longitude;
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            street_number.setBounds(circle.getBounds());
          });
        }
      }
    </script>

<script src="https://maps.googleapis.com/maps/api/js?<?php echo $map_key; ?>&callback=map&libraries=places&sensor=false"></script>

<style>
.btn-group label {
    margin-right: 2px !important;
    background-color: #fdcec0;
    color: #0000008a !important;
}
</style>
