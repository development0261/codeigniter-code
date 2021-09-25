<?php 
// echo $this->user->getStaffId();
// exit;
echo get_header(); ?>
<style>
.list-group-item{
    padding: 18px 15px !important;
    font-size: 18px;
}

</style>
<div class="row content dashboard">
    <?php if($this->user->getStaffId() !='11' ){ ?>
        <!-- <div class="col-md-12">       
            <div class="col-sm-offset-9 col-xs-12 col-sm-3 ">               
                <div class="row">  
                    <div class="col-xs-5 stat-content" style="padding-top: 6px;">
                        <?php echo lang('text_location_status'); ?>
                    </div>                          
                    <div class="col-xs-7 stat-content">
                        <form action="" id="loc_active" name="loc_active" method="POST">
                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                            <?php

                            if($location_status=='1'){ ?>
                                <label class="btn btn-danger"><input type="radio" name="location_status" id="location_status" value="0" <?php echo set_radio('location_status', '0'); ?> onchange="AjaxLookupoff(0)" >OFF</label>
                                        <label class="btn btn-success active"><input type="radio" name="location_status" id="location_status" value="1" <?php echo set_radio('location_status', '1', TRUE); ?> >ON</label>
                            <?php }  else { ?>
                                        <label class="btn btn-danger active"><input type="radio" name="location_status" id="location_status" value="0" <?php echo set_radio('location_status', '0', TRUE); ?> >OFF</label>
                                        <label class="btn btn-success"><input type="radio" name="location_status" id="location_status" value="1" <?php echo set_radio('location_status', '1'); ?> onchange="AjaxLookupon(1)" >ON</label>
                            <?php } ?>
                            <script type="text/javascript">
                                
                                function AjaxLookupoff($str) {
                                        //var eml = $('#location_status').val();                                   
                                        //console.log($str);
                                        var r = confirm('Do you want to disable this Restaurant?');
                                        if (r == true) {
                                            $.ajax({
                                                    url: '<?php echo site_url(); ?>dashboard',
                                                    data:{location_status:$str},
                                                    type:"POST",
                                                    success:function(result) {
                                                        location.reload();
                                                        //console.log(result);
                                                    }
                                                });
                                        }else{
                                        
                                            location.reload();
                                            event.preventDefault();
                                        }   
                                    
                                        
                                    }
                                function AjaxLookupon($str) {
                                        //var eml = $('#location_status').val();                                   
                                        //console.log($str);
                                        var r = confirm('Do you want to enable this Restaurant?');
                                        if (r == true) {
                                            $.ajax({
                                                    url: '<?php echo site_url(); ?>dashboard',
                                                    data:{location_status:$str},
                                                    type:"POST",
                                                    success:function(result) {
                                                        location.reload();
                                                        //console.log(result);
                                                    }
                                                });
                                        }else{
                                            
                                            location.reload();
                                            event.preventDefault();
                                        }  
                                            
                                    
                                        
                                    }
                            </script>
                        </div>
                        </form>
                    </div>
                </div>                  
            </div>       
        </div> -->
    <?php } ?>
    <br /><br />
    <div class="col-md-12">
        <div class="row mini-statistics">
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <a href="orders?show=all&id=&filter_search=&filter_location=&filter_status=all&filter_payment=&filter_date">
                                <div class="col-xs-4 stat-icon">
                                    <span class="bg-red"><i class="fa fa-line-chart fa-2x"></i></span>
                                </div>
                                <div class="col-xs-8 stat-content">
                                    <span class="stat-text text-red"><?php //echo lang('text_dash_dash'); 
                                    echo ($sales_all!='')?$sales_all:"0";?></span>
                                    <span class="stat-heading text-red"><?php echo lang('text_total_sale'); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <a href="customers">
                                <div class="col-xs-4 stat-icon">
                                    <span class="bg-blue"><i class="stat-icon fa fa-users fa-2x"></i></span>
                                </div>
                                <div class="col-xs-8 stat-content">
                                    <span class="stat-text text-blue"><?php //echo lang('text_dash_dash');
                                     echo ($customers_all>0)?$customers_all:"0"; ?></span>
                                    <span class="stat-heading text-blue"><?php echo lang('text_total_customer'); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <a href="orders?show=all&id=&filter_search=&filter_location=&filter_status=all&filter_payment=&filter_date">
                                <div class="col-xs-4 stat-icon">
                                    <span class="bg-green"><i class="stat-icon fa fa-shopping-cart fa-2x"></i></span>
                                </div>
                                <div class="col-xs-8 stat-content">
                                    <span class="stat-text text-green"><?php //echo lang('text_dash_dash');
                                    echo ($orders_all>0)?$orders_all:"0"; ?></span>
                                    <span class="stat-heading text-green"><?php echo lang('text_total_order'); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="col-xs-12 col-sm-6 col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <a href="reservations?show=all">
                                <div class="col-xs-4 stat-icon">
                                    <span class="bg-primary"><i class="stat-icon fa fa-calendar fa-2x"></i></span>
                                </div>
                                <div class="col-xs-8 stat-content">
                                    <span class="stat-text text-primary tables_reserved"><?php echo lang('text_dash_dash'); ?></span>
                                    <span class="stat-heading text-primary"><?php echo lang('text_total_reservation'); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>

        <div class="row statistics">
            <div class="col-sm-12 col-md-8">
                <div class="panel panel-default panel-chart">
                    <div class="panel-heading">
                        <div class="form-inline">
                            <div class="row">
                                <div class="col-md-4 pull-left">
                                    <h3 class="panel-title"><i class="fa fa-line-chart"></i>&nbsp;&nbsp;<?php echo lang('text_reports_chart'); ?></h3>
                                </div>

                                <div class="col-md-5 pull-right text-right">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <button class="btn btn-default btn-xs" id="allReport">
                                                <i class="fa fa fa-file-export"></i>&nbsp;&nbsp;
                                                <a href='<?= site_url("dashboard/exports_data?reportBy=chartReportAll") ?>' style="color:rgb(51, 51, 51);"><?php echo lang('text_export'); ?></a>
                                            </button>&nbsp;&nbsp;
                                            <button class="btn btn-default btn-xs daterange">
                                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span><?php echo lang('text_select_range'); ?></span>&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="chart-legend"></div>
                        <div class="chart-responsive">
                            <div id="chart-holder" width="600px" height="295px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="panel panel-default panel-statistics">
                    <div class="panel-heading">
                        <div class="form-inline">
                            <div class="row">
                                <div class="col-md-5 pull-left">
                                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_statistic'); ?></h3>
                                </div>

                                <div class="col-md-5 pull-right text-right">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            <span id="range_value" style="text-transform: capitalize;"></span>
                                            &nbsp;&nbsp;<span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-range pull-right" role="menu">
                                            <li><a rel="today"><?php echo lang('text_today'); ?></a></li>
                                            <li><a rel="week"><?php echo lang('text_week'); ?></a></li>
                                            <li><a rel="month"><?php echo lang('text_month'); ?></a></li>
                                            <li><a rel="year"><?php echo lang('text_year'); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="statistics">
                        <ul class="list-group text-sm">
                            <li class="list-group-item"><?php echo lang('text_total_sale'); ?> <span class="text-red sales"><?php echo ($sales>0)?$sales:"0"; ?></span></li>
                            <!-- <li class="list-group-item"><?php echo lang('text_total_lost_sale'); ?> <span class="text-yellow lost_sales"><?php echo lang('text_zero'); ?></span></li> -->
                            <li class="list-group-item"><?php echo lang('text_total_cash_payment'); ?><span class="text-primary cash_payments"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_customer'); ?> <span class="text-blue customers"><?php echo ($customers>0)?$customers:"0"; ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_order'); ?> <span class="text-green orders"><?php echo ($orders>0)?$orders:"0"; ?></span></li>
                        <!--     <li class="list-group-item"><?php echo lang('text_total_delivery_order'); ?> <span class="text-success delivery_orders"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_collection_order'); ?> <span class="text-info collection_orders"><?php echo lang('text_zero'); ?></span></li> 
                            <li class="list-group-item"><?php echo lang('text_total_completed_order'); ?> <span class="text-danger orders_completed"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_reserved_table'); ?><span class="text-primary tables_reserved"><?php echo lang('text_zero'); ?></span></li>-->
                        </ul>
                    </div>
                    <!-- <div class="panel-footer"></div>  -->
                </div>
            </div>
            <!-- Started By elemensis -->
            
            <?php if($staff_group_id =='13' ){ ?>
                <div class="col-sm-12 col-md-8">
                    <div class="panel panel-default panel-chart">
                        <div class="panel-heading">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-4 pull-left">
                                        <h3 class="panel-title"><i class="fa fa-line-chart"></i>&nbsp;&nbsp;<?php echo lang('text_newCustomer_chart'); ?></h3>
                                    </div>
                                    <div class="col-md-6 pull-right text-right">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <button class="btn btn-default btn-xs" id="newCustomerExport">
                                                        <i class="fa fa fa-file-export"></i>&nbsp;&nbsp;
                                                        <a href='<?= site_url("dashboard/exports_data?reportBy=chartNewCustomerData") ?>' style="color:rgb(51, 51, 51);"><?php echo lang('text_export'); ?></a>
                                                </button>&nbsp;&nbsp;
                                                <button class="btn btn-default btn-xs daterangeNewCustomer">
                                                    <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span><?php echo lang('text_select_range'); ?></span>&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="chart-legend"></div>
                            <div class="chart-responsive">
                                <div id="chart-customer" width="600px" height="295px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="panel panel-default panel-chart">
                        <div class="panel-heading">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-4 pull-left">
                                        <h3 class="panel-title"><i class="fa fa-line-chart"></i>&nbsp;&nbsp;<?php echo lang('text_sales_chart'); ?></h3>
                                    </div>

                                    <div class="col-md-5 pull-right text-right">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <button class="btn btn-default btn-xs" id="salesExport">
                                                        <i class="fa fa fa-file-export"></i>&nbsp;&nbsp;
                                                        <a href='<?= site_url("dashboard/exports_data?reportBy=chartSalesData") ?>' style="color:rgb(51, 51, 51);"><?php echo lang('text_export'); ?></a>
                                                </button>&nbsp;&nbsp;
                                                <button class="btn btn-default btn-xs daterangeSales">
                                                    <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span><?php echo lang('text_select_range'); ?></span>&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="chart-legend"></div>
                            <div class="chart-responsive">
                                <div id="chart-salesOrder" width="600px" height="295px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="panel panel-default panel-chart">
                        <div class="panel-heading">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-4 pull-left">
                                        <h3 class="panel-title"><i class="fa fa-line-chart"></i>&nbsp;&nbsp;<?php echo lang('text_top_item'); ?></h3>
                                    </div>
                                    
                                    <div class="col-md-5 pull-right text-right">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <button class="btn btn-default btn-xs" id="top10Export">
                                                    <i class="fa fa fa-file-export"></i>&nbsp;&nbsp;
                                                    <a href='<?= site_url("dashboard/exports_data?reportBy=chartTop10MenuData") ?>' style="color:rgb(51, 51, 51);"><?php echo lang('text_export'); ?></a>
                                                </button>&nbsp;&nbsp;
                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                    <span id="location_name" style="text-transform: capitalize;">
                                                        <?php echo $Location_name ?>
                                                    </span>
                                                    <span id="location_id" style="display: none;">
                                                        <?php echo $Location_id ?>
                                                    </span>
                                                    &nbsp;&nbsp;<span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-location pull-right" role="menu">
                                                    <?php foreach ($LocationList as $loc) { ?> 
                                                        <li><a rel=<?php echo $loc['location_id'] ?> tag=<?php echo $loc['location_name'] ?> >
                                                            <?php echo $loc['location_name'] ?>
                                                        </a></li>
                                                    <?php } ?>   
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body">
                            <!-- <div class="chart-legend"></div>
                            <div class="chart-responsive">
                                <div id="chart-menuItem" width="600px" height="295px"></div>
                            </div> -->
                            <ul class="list-group" id="menuList">
                            </ul>
                            <!-- <div class="table-responsive">
                                <table class="table table-striped table-border">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Menu Name</th>
                                            <th class="text-center">Menu Price</th>
                                            <th class="text-center">Total orders</th>
                                        </tr>
                                    </thead>
                                    <tbody id="menuList1"></tbody>
                                </table>
                            </div> -->
                        </div>
                    </div>
                </div>
            <?php } else { }?>
            <!-- Ended By elemensis -->

        </div>

        <?php if ($activities) { ?>
        <div>
            <div class="row">
                
                <!--<div class="col-sm-12 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title"><?php //echo lang('text_complete_setup'); ?></h3></div>
                        <div class="panel-body">
                            <h5><?php //echo lang('text_progress_summary'); ?></h5>
                        </div>
                        <div class="list-group check-list-group">
                            <a href="<?php //echo site_url('settings#location'); ?>" class="list-group-item">
                                <span class=""><?php //echo lang('text_settings_progress'); ?></span>
                            </a> 
                            <a href="<?php //echo site_url('settings#mail'); ?>" class="list-group-item">
                                <span class=""><?php //echo lang('text_email_progress'); ?></span>
                            </a>
                        </div>
                        <div class="panel-footer"></div>
                    </div>                    
                </div>-->

                <div class="col-sm-12 col-md-12">

                    <div class="panel panel-default panel-activities">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo lang('text_recent_activity'); ?></h3></div>
                        <ul class="list-group">
                           
                                <?php foreach ($activities as $activity) { ?>
                                    <li class="list-group-item">
                                        <div class="clearfix">
                                            <div class="activity-body"><i class="<?php echo $activity['icon']; ?> fa-fw bg-primary"></i>
                                                <?php echo $activity['message']; ?>
                                                <span class="activity-time text-muted small">
                                                <span class="small"><?php echo $activity['time']; ?>&nbsp;-&nbsp;<?php echo $activity['time_elapsed']; ?></span>
                                            </span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            
                        </ul>
                        <div class="panel-footer text-right">
                            <a href="<?php echo site_url('activities'); ?>"><?php echo lang('text_see_all_activity'); ?>&nbsp;<i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>

                </div>
                

            </div>
        </div>
        <?php } else { }?>
                                

        <?php /*if ($orders) { ?>
            <div class="panel panel-default panel-orders">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;<?php echo lang('text_latest_order'); ?></h3></div>
                <div class="table-responsive">
                    <table border="0" class="table table-striped table-no-spacing">
                        <thead>
                        <tr>
                            <th class="action action-one"></th>
                            <th><?php echo lang('column_id'); ?></th>
                            <th><?php echo lang('column_location'); ?></th>
                            <th><?php echo lang('column_name'); ?></th>
                            <th class="text-center"><?php echo lang('column_status'); ?></th>
                            <!-- <th class="text-center"><?php echo lang('column_type'); ?></th> -->
                            <th class="text-center"><?php echo lang('column_ready_type'); ?></th>
                            <th class="text-center"><?php echo lang('column_date_added'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td class="action action-one"><a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $order['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['location_name']; ?></td>
                                <td><?php echo $order['first_name']; ?> <?php echo $order['last_name']; ?></td>
                                <td class="text-center"><span class="label label-default" style="background-color: <?php echo $order['status_color']; ?>;"><?php echo $order['order_status']; ?></span></td>
                                <!-- <td class="text-center"><?php echo $order['order_type']; ?></td> -->
                                <td class="text-center"><?php echo $order['order_time']; ?></td>
                                <td class="text-center"><?php echo $order['date_added']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer text-right">
                    <a href="<?php echo site_url('orders'); ?>"><?php echo lang('text_see_all_orders'); ?>&nbsp;<i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        <?php } */ ?>
    </div>
</div>
<script type="text/javascript"><!--
    $(document).on('click', '.dropdown-menu-range a', function() {
        if ($(this).parent().is(':not(.active)')) {
            $('.dropdown-menu-range li').removeClass('active');
            $(this).parent().addClass('active');
            var stat_range = $(this).attr('rel');
            getStatistics(stat_range);
        }
    });
    $(document).on('click', '.dropdown-menu-location a', function() {
        if ($(this).parent().is(':not(.active)')) {
            $('.dropdown-menu-location li').removeClass('active');
            $(this).parent().addClass('active');
            var stat_range = $(this).attr('rel');
            $('#location_id').html(stat_range);
            $('#location_name').html($(this).text());
            getChartTopItem(stat_range);
        }
    });

    function getStatistics(stat_range) {
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("dashboard/statistics?stat_range="); ?>' + stat_range,
            dataType: 'json',
            async: false,
            success: function(json) {
                if (json) {
                    $('#range_value').html(stat_range);
                    $('#statistics .sales, .mini-statistics .sales').html(json['sales']);
                    $('#statistics .lost_sales').html(json['lost_sales']);
                    $('#statistics .cash_payments').html(json['cash_payments']);
                    $('#statistics .customers, .mini-statistics .customers').html(json['customers']);
                    $('#statistics .orders, .mini-statistics .orders').html(json['orders']);
                    $('#statistics .orders_completed').html(json['orders_completed']);
                    $('#statistics .delivery_orders').html(json['delivery_orders']);
                    $('#statistics .collection_orders').html(json['collection_orders']);
                    $('#statistics .tables_reserved, .mini-statistics .tables_reserved').html(json['tables_reserved']);
                }
            }
        });
    }

    $(document).ready(function() {
        $('button.daterange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('button.daterangeNewCustomer span').html(moment().subtract(30, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('button.daterangeSales span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        getChart(moment().subtract(29, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'));
       
        let customeId = document.getElementById("chart-customer"); 
        let salesId = document.getElementById("chart-salesOrder"); 
        let location_id = document.getElementById("location_id"); 
        if(customeId !=null){
            getChartCustomer(moment().subtract(30, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'));
        }
        if(salesId !=null){
            getChartSalesOrder(moment().subtract(30, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'));
        }
        if(location_id !=null){
            getChartTopItem($('#location_id').text());

        }

        var pickerConfig = {
            format: 'DD/MM/YYYY',
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            showDropdowns: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn', 'btn-xs'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-default',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        };
        /*---------- report chart ------------*/
            $('button.daterange').daterangepicker(pickerConfig, function(start, end, label) {
                $('button.daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

            $('button.daterange').on('cancel.daterangepicker', function(ev, picker) {
                $('button.daterange').val('');
            });

            $('button.daterange').on('apply.daterangepicker', function(ev, picker) {
                getChart(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
            });
        /*---------- report new customer chart ------------*/
            $('button.daterangeNewCustomer').daterangepicker(pickerConfig, function(start, end, label) {
                $('button.daterangeNewCustomer span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
            $('button.daterangeNewCustomer').on('cancel.daterangepicker', function(ev, picker) {
                $('button.daterangeNewCustomer').val('');
            });
            $('button.daterangeNewCustomer').on('apply.daterangepicker', function(ev, picker) {
                getChartCustomer(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
            });

        /*---------- report new sales chart ------------*/
            $('button.daterangeSales').daterangepicker(pickerConfig, function(start, end, label) {
                $('button.daterangeSales span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
            $('button.daterangeSales').on('cancel.daterangepicker', function(ev, picker) {
                $('button.daterangeSales').val('');
            });
            $('button.daterangeSales').on('apply.daterangepicker', function(ev, picker) {
                getChartSalesOrder(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
            });


        $('.dropdown-menu-range a[rel="today"]').trigger('click');

        // $("#newCustomerExport").click(function(){
        //     exportData('chartNewCustomerData');
        // });
        // $("#salesExport").click(function(){
        //     exportData('chartSalesData');
        // });
        // $("#top10Export").click(function(){
        //     exportData('chartTop10MenuData');
        // });
        
    });

    var monthNames = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
        "Aug", "Sep", "Oct", "Nov", "Dec"
    ];


    var myAreaChart = Morris.Area({
        element: 'chart-holder',
        data: [],
        xkey: 'time',
        ykeys: ['customers', 'orders', 'reviews'],
        labels: ['Total customer', 'Total order', 'Total reviews'],
        lineColors: ['#63ADD0', '#5CB85C', '#337AB7', '#D9534F'],
        parseTime: false,
        behaveLikeLine: false,
        resize: true,
        hideHover: true,
    });

   

    function getChart(startDate, endDate) {
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("dashboard/chart?start_date="); ?>' + startDate + '&end_date=' + endDate,
            dataType: 'json',
            async: false,
            success: function(json) {
                myAreaChart.setData(json.data);
            }
        });
    }
    function getChartCustomer(startDate, endDate) {
        $("#chart-customer").empty();

        var myCustomerChart = Morris.Area({
            element: 'chart-customer',
            data: [],
            xkey: 'time',
            ykeys: ['customers', 'orders', 'reviews'],
            labels: ['Total customer', 'Total order', 'Total reviews'],
            lineColors: ['#63ADD0', '#5CB85C', '#337AB7', '#D9534F'],
            parseTime: false,
            behaveLikeLine: false,
            resize: true,
            hideHover: true,
        });
   
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("dashboard/chartCustomer?start_date="); ?>' + startDate + '&end_date=' + endDate,
            dataType: 'json',
            async: false,
            success: function(json) {
                myCustomerChart.options.labels =json.labels;
                myCustomerChart.options.ykeys=json.ykeys;
                myCustomerChart.setData(json.data);
            }
        });
    }

    function getChartSalesOrder(startDate, endDate) {
        $("#chart-salesOrder").empty();
        var mySalesOrderChart = Morris.Area({
            element: 'chart-salesOrder',
            data: [],
            xkey: 'time',
            ykeys: ['customers', 'orders', 'reviews'],
            labels: ['customers', 'orders', 'reviews'],
            lineColors: ['#63ADD0', '#5CB85C', '#337AB7', '#D9534F'],
            parseTime: false,
            behaveLikeLine: false,
            resize: true,
            hideHover: true,
        });

        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("dashboard/chartSalesOrder?start_date="); ?>' + startDate + '&end_date=' + endDate,
            dataType: 'json',
            async: false,
            success: function(json) {
            mySalesOrderChart.options.labels =json.labels;
            mySalesOrderChart.options.ykeys=json.ykeys;
            mySalesOrderChart.setData(json.data);
            }
        });
    }
    function getChartTopItem(locationId=null) {
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("dashboard/chartTopMenuItem?locationId="); ?>'+locationId,
            dataType: 'json',
            async: false,
            success: function(json) {
            //  myTopMenuItemChart.setData(json.data);
                const menuList = document.getElementById('menuList');
                menuList.innerHTML = json.data.map((product,index) => {  
                    return `<li class="list-group-item">
                        <div class="clearfix"> 
                            <div class="activity-body">
                                <i class="fa fa-cutlery fa-fw" style="width:25px;height:25px;color:balck;font-size:16px;border:2px solid #f7e9e5">${ index+1 } </i>
                                ${ product.menu_name }
                                <span class="activity-time text-muted small">
                                    <span class="small">
                                     $ ${ product.menu_price } price
                                    </span>
                                    <span class="small">
                                       &nbsp;&nbsp;&nbsp; orders: ${ product.total_orders }
                                    </span>
                                </span>
                                
                            </div>
                        </div>               
                    </li>` ;


                   
                }).join('');
            }
        });
    }

    function exportData(reportBy ='chartTop10MenuData'){
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("dashboard/exports_data?reportBy="); ?>' + reportBy,
            dataType: 'json',
            async: false,
            success: function(json) {
                console.log("get reportBy data---------------",json)
            }
        });
    }
    setTimeout(function() {
    location.reload();
    }, 60000);
</script>
<?php echo get_footer(); ?>