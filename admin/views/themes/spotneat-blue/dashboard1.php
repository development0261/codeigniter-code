<?php
    
    if($_SESSION['admin_lang']=='') {
    $lang = get_current_language();
    }
    else{
        $lang = $_SESSION['admin_lang'];
        $GLOBALS['admin_lan'] = $_SESSION['admin_lang'];
        if($lang=='arabic')
        $lan = 'ar';
        else
        $lan='en';
    }

    $this->template->setDocType('html5');
    $this->template->setMeta(array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'));
    $this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'));
    $this->template->setMeta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no', 'type' => 'name'));
    $this->template->setFavIcon('spotneat-blue/images/favicon.png');
    
    if($lang == "arabic"){
        $this->template->setStyleTag('css/bootstrap-rtl.css', 'bootstrap-css', '10');
        $this->template->setStyleTag('css/stylesheet-rtl.css', 'stylesheet-css', '1000000');
        $dir = "rtl";
    }else{
        $this->template->setStyleTag('css/bootstrap.min.css', 'bootstrap-css', '10');
        $this->template->setStyleTag('css/stylesheet.css', 'stylesheet-css', '1000000');
        $dir = "ltr";
    }
    
    $this->template->setStyleTag('css/font-awesome.min.css', 'font-awesome-css', '11');
    $this->template->setStyleTag('css/metisMenu.min.css', 'metis-menu-css', '12');
    $this->template->setStyleTag('css/select2.css', 'select2-css', '13');
    $this->template->setStyleTag('css/select2-bootstrap.css', 'select2-bootstrap-css', '14');
    $this->template->setStyleTag('css/jquery.raty.css', 'jquery-raty-css', '15');
    $this->template->setStyleTag('css/fonts.css', 'fonts-css', '16');
    $this->template->setStyleTag('css/bootstrap-datepicker.min.css', 'datepicker-css', '17');
    $this->template->setStyleTag('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', 'data-table-css', '20');
   

    $this->template->setScriptTag('js/jquery-1.11.2.min.js', 'jquery-js', '1');
    $this->template->setScriptTag('js/bootstrap.min.js', 'bootstrap-js', '10');
    $this->template->setScriptTag(assets_url('js/js.cookie.js'), 'js-cookie-js', '14');
    $this->template->setScriptTag('js/metisMenu.min.js', 'metis-menu-js', '11');
    $this->template->setScriptTag('js/select2.js', 'select-2-js', '12');
    $this->template->setScriptTag('js/jquery.raty.js', 'jquery-raty-js', '13');
    $this->template->setScriptTag('js/common.js', 'common-js');
    $this->template->setScriptTag('js/bootstrap-datepicker.min.js', 'datepicker-js', '17');
    
    $this->template->setScriptTag('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', 'data-table-js', '20');
    if($_POST['restaurant']!=''){
        $res_id = $_POST['restaurant'];
        $this->user->updateVendor($res_id,$this->user->getStaffId());
        header("Refresh:0");
    }
    $spotneat_logo  = base_url('views/themes/spotneat-blue/images/sidemenu-logo.png');
    $spotneat_mini_logo  = base_url('views/themes/spotneat-blue/images/sidemenu-mini-logo.png');
    $site_logo          = base_url('views/themes/spotneat-blue/images/spotneat-logo-text.png');
    $system_name        = lang('spotneat_system_name');
    $site_name          = config_item('site_name');
    $site_url           = rtrim(site_url(), '/').'/';
    $base_url           = base_url();
    $active_menu        = ($this->uri->rsegment(1)) ? $this->uri->rsegment(1) : ADMINDIR;
    $message_unread     = $this->user->unreadMessageTotal();
    $islogged           = $this->user->islogged();
    $username           = $this->user->getUsername();
    //if($this->user->getStaffId()=='11'){
        $user_name      = $this->user->getUserName();
   // }else{
        $staff_name         = $this->user->getStaffName();
    //}
    $staff_email        = $this->user->getStaffEmail();
    $staff_avatar       = md5(strtolower(trim($staff_email)));
    $staff_group        = $this->user->staffGroup();
    $staff_location     = $this->user->getLocationName();
    // $staff_location_id  = $this->user->getLocationId();
    $staff_edit         = site_url('staffs/edit?id='. $this->user->getStaffId());
    $logout             = site_url('logout');
    $restaurant         = $this->user->getRestaurant($this->user->getStaffId());

    $wrapper_class = '';
    if (!$this->user->islogged()) {
        $wrapper_class .= 'wrap-none';
    }

    if ($this->input->cookie('ti_sidebarToggleState') == 'hide') {
        $wrapper_class .= ' hide-sidebar';
    }
?>
<?php echo get_doctype(); ?>

<style>
 .hide-data
 {
    display:none !important;
 }
 body{
    unicode-bidi:bidi-override;
    direction:<?php echo $dir; ?>;
 }



</style>
<!DOCTYPE html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $lan;?>">
<head>
    <?php echo get_metas(); ?>
    <?php echo get_favicon(); ?>
    <title><?php echo sprintf(lang('site_title'), get_title(), $site_name, $system_name); ?></title>
    <?php echo get_style_tags(); ?>
    <?php echo get_script_tags(); ?>

</head>
<body lang="<?php echo $lang; ?>" dir="<?php echo $dir; ?>">
    <div id="wrapper" class="<?php echo $wrapper_class; ?>">
        <nav class="navbar navbar-static-top navbar-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <div class="navbar-brand">
                    <div class="navbar-logo col-xs-3">
                        <img class="logo-image" alt="<?php echo $system_name; ?>" title="<?php echo $system_name; ?>" src="<?php echo $spotneat_logo; ?>"/>
                    </div>
                    <div class="navbar-logo col-xs-9">
                        <!--<img class="logo-text" alt="<?php echo $system_name; ?>" title="<?php echo $system_name; ?>" src="<?php echo $site_logo; ?>"/>-->
<!--                        <a class="logo-text" href="--><?php //echo site_url('dashboard'); ?><!--">--><?php //echo $site_name; ?><!--</a>-->
                    </div>
                </div>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <?php if ($islogged) { ?>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                           <li><a class="dashboard admin" href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard fa-fw"></i><span class="content">Dashboard</span></a></li> 
                        </ul>

                    </div>
                    <div>
                    
                    </div>
                </div>

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="front-end" title="<?php echo lang('menu_storefront'); ?>" href="<?php echo root_url(); ?>" target="_blank">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    
                    <li><a class="" href="<?php echo $logout; ?>"><i class="fa fa-power-off fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_logout'); ?></a></li>
                            <li class="divider"></li>
                </ul>

                <h1 class="navbar-heading"  style="border-right: 1px dashed #fff;">
                    <?php echo get_heading(); ?>

                    <?php if (!empty($context_help)) { ?>
                        <a class="btn btn-help" role="button" data-toggle="collapse" href="#context-help-wrap" title="<?php echo lang('text_help'); ?>">
                            <i class="fa fa-question-circle"></i>
                        </a>
                    <?php } ?>
                </h1>
                
                   
                
                <span><?php //echo trim($staff_location)!=""? "for ". $staff_location: "" ; ?></span>
                    <span style="float: right;margin-top: 1%;"><?php echo "<b>Username : </b>". $user_name; if($this->user->getStaffId()!='11'){ echo "&nbsp;&nbsp;<b>Restaurant Name : </b>"; ?>
                    <form action="" method="post" style="display: inline-block;">
                            <select name="restaurant" id="restaurant" style="height: 40px; margin: auto; color: #000; background: transparent;border:0px;outline:0px;">
                                
                                <?php                               
                                foreach ($restaurant as $rest) { ?>

                                    <option value="<?php echo $rest['location_id']; ?>" <?php if($staff_location_id == $rest['location_id']){ echo "selected"; } ?> > <?php echo $rest['location_name']; ?></option>
                                <?php } ?>
                                
                            </select>
                            
                        </form>
                          

                <?php } ?></strong></span>
                                        
                                        
                                        
            <?php } ?>
        </nav>

        <div id="page-wrapper">
            <?php if ($islogged) { ?>
                <div class="page-header clearfix">
                    <?php
                        $button_list = get_button_list();
                        $icon_list = get_icon_list();
                    ?>

                </div>

                <?php if (!empty($context_help)) { ?>
                    <div class="collapse" id="context-help-wrap">
                        <div class="well"><?php echo $context_help; ?></div>
                    </div>
                <?php } ?>

            <?php } ?>


<style>
.list-group-item{
    padding: 18px 15px !important;
    font-size: 18px;
}

</style>
<div class="row content dashboard">

    <div class="col-md-12">
        Kindly Contact Administrator To Assign Restaurant!
    </div>
</div>


<?php echo get_footer(); ?>