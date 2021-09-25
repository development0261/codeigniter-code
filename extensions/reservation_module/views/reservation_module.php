<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
        <form method="GET" accept-charset="utf-8" action="<?php echo $current_url; ?>" id="find-table-form" role="form">
            <input type="hidden" name="action" id="find_table_action" value="<?php echo $find_table_action; ?>"/>
            <div class="panel panel-default panel-find-table" style="margin-bottom:0;display:<?php echo ($find_table_action === 'find_table') ? 'block' : 'none'; ?>">
                <div class="book-head">
                    <h3 class="col-md-10 col-sm-8 col-xs-8 book-title"><?php echo lang('book_your_table'); ?></h3>
                    <div class="col-md-2 col-sm-4 col-xs-4 text-right ">
                        <a href="<?php echo $reset_url; ?>"><b><?php echo lang('button_reset'); ?></b></a>
                    </div>
                </div>
                <input type="hidden" name="location" value="<?php echo $location_id;?>">
                <div class="panel-body">
                    <div id="reservation-alert" class="col-md-12 col-sm-12 col-xs-12 padd-none">
                        <div class="reservation-alert"></div>
                        <?php if (!empty($reservation_alert)) { ?>
                            <?php echo $reservation_alert; ?>
                        <?php } ?>
                        <?php echo form_error('time', '<span class="text-danger">', '</span><br>'); ?>
                        <?php echo form_error('guest_num', '<span class="text-danger">', '</span><br>'); ?>
                        <?php echo form_error('reserve_date', '<span class="text-danger">', '</span><br>'); ?>
                        <?php echo form_error('reserve_time', '<span class="text-danger">', '</span><br>'); ?>
                        <?php echo form_error('selected_time', '<span class="text-danger">', '</span><br>'); ?>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 padd-none"">
                        <?php //echo lang('text_find_msg'); ?>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                        <div class="form-group">

                             <div class="col-xs-12 col-sm-12 col-md-6 padd-none wrap-none <?php echo (form_error('guest_num')) ? 'has-error' : ''; ?>">
                               
                                <label class="label-show" for="guest-num"><?php echo lang('label_guest_num'); ?></label>
                                <input type="number" min="2" onkeyup="get_num_tables(this.value,<?php echo $location_id;?>)" name="guest_num" id="guest-num" class="form-control" value="2" >
                                <?php if ($guest_numbers) { ?>
                                    <!-- <select name="guest_num" id="guest-num" class="class-select2"  onchange=get_num_tables(this.value,<?php echo $location_id;?>) >
                                        <?php foreach ($guest_numbers as $key => $value) { ?>
                                            <?php if ($value === $guest_num) { ?>
                                                <option value="<?php echo $value; ?>" <?php echo set_select('guest_num', $value, TRUE); ?>><?php echo $value; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $value; ?>" <?php echo set_select('guest_num', $value); ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select> -->
                                <?php } else { ?>
                                    <span><?php echo lang('text_no_table'); ?></span>
                                <?php } ?>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 padd-none "> &nbsp;</div>

                            <div class="col-xs-12 col-sm-12 col-md-5 padd-none wrap-none <?php echo (form_error('tables')) ? 'has-error' : ''; ?>">
                               
                                <label class="label-show" for="tables"><?php echo lang('total_tables'); ?></label>
                                <input type="text" name="tables" id="tables" class="form-control" value="<?php echo set_value('tables', $tables); ?>" readonly>
                                <input type="hidden" name="table_price" id="table_price" class="form-control" value="<?php echo $table_price;?>" readonly>
                                  
                            </div>
                            <div class="col-sm-12 padd-none "> &nbsp;</div>
                            <div class="col-xs-12 col-sm-12 col-md-6 padd-none wrap-none <?php echo (form_error('reserve_date')) ? 'has-error' : ''; ?>">
                               
                                <label class="label-show" for="date"><?php echo lang('label_date'); ?></label>
                                <div class="input-group">
                                    <input type="text" name="reserve_date" id="date" class="form-control" value="<?php echo set_value('reserve_date', $date); ?>" autocomplete="off" onchange="get_timings(this.value)" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-1 padd-none "> &nbsp;</div>

                            <div class="col-xs-12 col-sm-12 col-md-5 padd-none <?php echo (form_error('reserve_time')) ? 'has-error' : ''; ?>">
                                
                                 <label  class="label-show" for="time"><?php echo lang('label_time'); ?></label>
	                            <?php
                                 if ($reservation_times) { ?>
                                 <div id="reser_time">
		                            <select name="reserve_time" id="time" class="class-select2">
			                            <?php foreach ($reservation_times as $key => $value) { ?>
				                            <?php if ($value == $time) { ?>
					                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
				                            <?php } else { ?>
					                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
				                            <?php } ?>
			                            <?php } ?>
		                            </select>
                                </div>
	                            <?php } else { ?>
		                            <br /><?php echo lang('text_location_closed'); ?>
	                            <?php } ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 padd-none text-center wrap-none" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo lang('book_now'); ?></button>
                    </div>

                </div>
            </div>
           
            <div class="panel panel-default panel-time-slots" style="margin-bottom:0;display:<?php echo ($find_table_action === 'select_time') ? 'block' : 'none'; ?>">
                <div class="book-head">
                    <h3 class="col-md-12 col-sm-12 col-xs-12 book-title"><?php echo lang('text_time_heading'); ?></h3>
                   
                </div>
               
                <div class="panel-body ">

                    <p class="sidebar_cart_content text-uppercase" style="padding-top: 20px;"><?php echo sprintf(lang('text_time_msg'), mdate('%l, %j %F, %Y', strtotime($date)), $guest_num); ?></p>

                    <?php if ($time_slots) { ?>
                        <div id="time-slots" class="col-md-12 col-sm-12 col-xs-12 padd-none">
                            <div class="btn-group" data-toggle="buttons">
                                <?php foreach ($time_slots as $key => $slot) { ?>
                                    <?php if ($slot['time'] === $time) { ?>
                                        <label class="btn btn-default col-md-2 col-sm-2 col-xs-2 active <?php echo $slot['state']; ?>" data-btn="btn-primary" style="font-size: 12px;padding: 12px !important;width: auto;    margin-bottom: 5px !important;">
                                            <input type="radio" name="selected_time" id="reserve_time<?php echo $key; ?>" value="<?php echo $slot['time']; ?>" <?php echo set_radio('selected_time', $slot['time'], TRUE); ?>/><?php echo $slot['time']; ?>
                                        </label>
                                    <?php } else { ?>
                                        <label class="btn btn-default col-md-2 col-sm-2 col-xs-2   <?php echo $slot['state']; ?>" data-btn="btn-primary" style="font-size: 12px;padding: 12px !important;width: auto;    margin-bottom: 5px !important;">
                                            <input type="radio" name="selected_time" id="reserve_time<?php echo $key; ?>" value="<?php echo $slot['time']; ?>" <?php echo set_radio('selected_time', $slot['time']); ?>/><?php echo $slot['time']; ?>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12  padd-none">
                            <button type="submit" class="btn btn-primary btn-block"><?php echo lang('button_select_time'); ?></button>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <a onclick="backToFind();" style="padding-top:20px;float:right;cursor: pointer;" ><b><?php echo lang('button_back'); ?></b></a>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-12 col-sm-12 col-xs-12  wrap-none"><?php echo lang('text_no_time_slot'); ?></div>

                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <a onclick="backToFind();" style="padding-top:20px;float:right;cursor: pointer;" ><b><?php echo lang('button_back'); ?></b></a>
                        </div>
                    <?php } ?>

                    
                </div>
            </div>
                
        </form>

        <div class="panel panel-default panel-summary" style="margin-bottom:0;display:<?php echo ($find_table_action === 'view_summary') ? 'block' : 'none'; ?>">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo lang('text_reservation'); ?></h3>
            </div>

            <div class="panel-body">
            <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
               <!-- <div class="col-md-3 col-sm-3 col-xs-3 padd-none">
                <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                    <img class="img-responsive" src="<?php echo $location_image; ?>">
                </div>
                </div> -->
                <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                    <label class="text-muted large reservation_title"><?php echo lang('restaurant'); ?>&nbsp;:&nbsp;</label>
                    <span class="form-control-static text-">
                        <?php foreach ($locations as $location) { ?>
                            <?php if ($location['id'] === $location_id) { ?>
                                <?php echo $location['name']; ?>
                            <?php } ?>
                        <?php } ?>
                    </span>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                    <label class="text-muted large reservation_title"><?php echo lang('label_date'); ?>&nbsp;:&nbsp;</label>
                    <span class="form-control-static"><?php echo mdate('%D, %j %M, %Y', strtotime($date)); ?></span>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                    <label class="text-muted large reservation_title"><?php echo lang('label_time'); ?>&nbsp;:&nbsp;</label>
                    <span class="form-control-static"><?php echo $time; ?></span>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                    <label class="text-muted large reservation_title"><?php echo lang('label_guest_num'); ?>&nbsp;:&nbsp;</label>
                    <span class="form-control-static"><?php echo $guest_num; ?></span>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                    <label class="text-muted large reservation_title"><?php echo lang('label_table_nos'); ?>&nbsp;:&nbsp;</label>
                    <span class="form-control-static"><?php echo $tables; ?></span>
                </div>
                <!-- <div class="col-md-12 col-sm-12 col-xs-12 padd-none">
                    <label class="text-muted text-uppercase large reservation_title"><b><?php echo lang('label_price'); ?>&nbsp;:&nbsp;</b></label>
                    <span class="form-control-static"><b><?php echo $this->currency->format($table_price); ?></b></span>
                </div> -->
                <?php if(empty($this->session->userdata('cart_contents'))) {?>
                <div class="col-md-12 col-sm-12 col-xs-12 padd-none" id="cart-reserve-button">
                    <a href='<?php echo page_url()."?action=checkout&";?>'><button class="btn btn-default btn-block btn-lg"><b><?php echo $this->lang->line('button_confirm');?></b></button>
                    </a>
                    <br /> <!-- <center><a href="#" id="myButton" style="font-size: 16px;"><b><?php echo lang('click_menu'); ?></b></a></center>  -->
                   </div> 
                   <?php } ?>
                <div class="col-md-12 col-sm-12 col-xs-12 ">

                    <!-- <a onclick="backToTime();" style="padding-top:20px;float:right;cursor: pointer;" ><b><?php echo lang('button_back'); ?></b></a> -->
                </div>

                </div>
            </div>
            </div>
        </div>
    
<script type="text/javascript"><!--
    $(document).ready(function() {
        $('#check-postcode').on('click', function() {
            $('.check-local').fadeIn();
            $('.display-local').fadeOut();
        });

//        $('#time').timepicker({
//            <?php //echo ($time_format === '24hr') ? 'showMeridian: false' : 'showMeridian: true'; ?>
//        });

        $('#date').datepicker({
                autoclose:true,
                startDate: new Date() ,
                 orientation: 'auto'  ,
                 todayHighlight: 'true',

            <?php if ($date_format === 'year_first') { ?>
                <?php echo "format: 'yyyy-mm-dd'" ?>
            <?php } else if ($date_format === 'month_first') { ?>
                <?php echo "format: 'mm-dd-yyyy'" ?>
            <?php } else { ?>
                <?php echo "format: 'dd-mm-yyyy'" ?>
            <?php } ?>

        });

        if ($('input[name="action"]').val() == 'view_summary') {
            //$('html,body').animate({scrollTop: $("#reservation-box > .container").offset().top}, 'slow');
        }
        //$("#date").datepicker().datepicker("setDate", new Date());
        

    });

    function backToFind() {
        $('input[name="action"]').val('find_table');
        $('#find, .panel-find-table').fadeIn();
        $('.panel-time-slots').fadeOut().empty();
        $('#reservation-alert .alert p').fadeOut();
    }

    function backToTime() {
        $('input[name="action"]').val('select_time');
        $('#find, .panel-time-slots').fadeIn();
        $('.panel-find-table').fadeOut();
        $('.panel-summary').fadeOut();
        $('#reservation-alert .alert p').fadeOut();
    }

    function get_num_tables(val,location_id)
    {
        $.ajax({
                url: js_site_url('reservation/get_table_details'),
                type: 'POST',
                data: {value : val,location_id : location_id},
                success: function(data) {
                    if(data != 0)
                    {
                        var values = data.split('&');
                        $("#tables").val(values[0]);
                        $("#table_price").val(values[1]);
                    }
                    else
                    {
                        $("#tables").val(0);
                    }
                    //console.log(data);return false;
                }
            });
    }
    function get_timings(date)
    {
        var find_table_action = $("#find_table_action").val();
        if(find_table_action == "find_table")
        { 
            $.ajax({
                url: js_site_url('reservation_module/get_timings'),
                type: 'POST',
                data: {date : date},
                success: function(data) {
                    $("#reser_time").html(data);
                    //$("#table_price").val(values[1]);
                    //console.log(data);return false;
                }
            });
        }
    }
//--></script>