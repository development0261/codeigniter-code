<?php
	
	if($_SESSION['admin_lang']=='')	{
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
	$spotneat_logo       = $this->user->getSpotnEatLogo();
	$site_bg_color       = $this->user->getSiteColor();
	$spotneat_mini_logo  = base_url('views/themes/spotneat-blue/images/sidemenu-mini-logo.png');
	$site_logo          = base_url('views/themes/spotneat-blue/images/login-logo.png');
    $system_name 		= lang('spotneat_system_name');
    $site_name 		    = config_item('site_name');
    $site_url 			= rtrim(site_url(), '/').'/';
    $base_url 			= base_url();
    $active_menu 		= ($this->uri->rsegment(1)) ? $this->uri->rsegment(1) : ADMINDIR;
    $message_unread 	= $this->user->unreadMessageTotal();
    $islogged 			= $this->user->islogged();
    $username 			= $this->user->getUsername();
    //if($this->user->getStaffId()=='11'){
    	$user_name 		= $this->user->getUserName();
   // }else{
		$staff_name 		= $this->user->getStaffName();
	//}
	$staff_email 		= $this->user->getStaffEmail();
	$staff_avatar 		= md5(strtolower(trim($staff_email)));
    $staff_group 		= $this->user->staffGroup();
    $staff_location		= $this->user->getLocationName();
    // $staff_location_id	= $this->user->getLocationId();
    //$staff_location_id=$data['location_id'];
    $staff_edit 		= site_url('staffs/edit?id='. $this->user->getStaffId());
    $logout 			= site_url('logout');
    if($this->user->getStaffId() != '11') {
		$restaurant 		= $this->user->getRestaurant($this->user->getStaffId());
		if(empty($restaurant)){
			$restaurant = $this->user->getRestaurantByClient('restaurant_by',$this->user->getStaffId());
		}
	    if(isset($_SESSION['location_id']) && $_SESSION['location_id'] != '') {
	    	$_SESSION['location_id'] = $_SESSION['location_id'];
	    } else {
	    	$_SESSION['location_id'] = $restaurant[0]['location_id'];
	    }
	}
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
	<script type="text/javascript">
		var js_site_url = function(str) {
			var strTmp = "<?php echo $site_url; ?>" + str;
			return strTmp;
		};

		var js_base_url = function(str) {
			var strTmp = "<?php echo $base_url; ?>" + str;
			return strTmp;
		};

		var active_menu = '<?php echo $active_menu; ?>';
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('a[title], span[title], button[title]').tooltip({placement: 'bottom'});
			$('select.form-control').select2({minimumResultsForSearch: 10});

			$('.alert').alert();
			$('.dropdown-toggle').dropdown();

			$("#list-form td:contains('<?php echo lang('text_disabled'); ?>')").addClass('red');
		});
		function change_lang(theForm){

		     // get the form data
		        // there are many ways to get this data using jQuery (you can use the class or id also)
		       
		        var formData = {
		            'lang'              : $('input[name=language]').val(),
		        };

		        // process the form
		        $.ajax({
		            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		            url         : "<?php echo site_url().'dashboard/change_lang';?>", // the url where we want to POST
		            data        : formData, // our data object
		        })
		            // using the done promise callback
		            .done(function(data) {

		                // log data to the console so we can see
		                console.log(data); 
		                window.location.reload();
		                // here we will handle errors and validation messages
		            });

		        // stop the form from submitting the normal way and refreshing the page
		        event.preventDefault();
		   

		}
$(document).ready(function(){
	if($("#wrapper").hasClass("hide-sidebar")) {
		$("#side_img").removeClass("logo-text");
		$("#side_img").addClass("logo-text1");
		$(".logo-text1").attr("src","<?php echo $spotneat_mini_logo; ?>");
		var flag = 1;  
	} else {
		$("#side_img").removeClass("logo-text1");
		$("#side_img").addClass("logo-text");
		$(".logo-text").attr("src","<?php echo  $spotneat_logo;  ?>");
		var flag = 0; 
	}
	  
	  $(".collap").click(function(){

	    if(flag == 0) {
	    	$("#side_img").removeClass("logo-text");
			$("#side_img").addClass("logo-text1");
	      $(".logo-text1").attr("src","<?php echo $spotneat_mini_logo; ?>");
	      flag = 1;
	    }
	    else if(flag == 1) {
	    	$("#side_img").removeClass("logo-text1");
			$("#side_img").addClass("logo-text");
	      $(".logo-text").attr("src","<?php echo  $spotneat_logo;  ?>");
	      flag = 0;
	    }
	  });
	});
		 $(document).one('ready', function () {
		 	or_count = $('#or_count').val();
              $.ajax({
					    url: js_site_url('orders/check_first_count'),
					    type: 'POST',
					    dataType: 'json',
					    data: { 
					    	or_count: or_count},
					   	// data: 'order_id=<?php echo $order_id; ?>',
					    success: function(data) {
					    	if(data.status == 1){
					    		$('#or_count').val(data.unread);
					    		$('.unread').html(data.html);					    		
					    	}
						    // window.location.href = json['redirect'];
					    }
				    })
			});       
		$(document).ready(function() {
			or_count = $('#or_count').val();
			setInterval(function(){ 		
			     $.ajax({
					    url: js_site_url('orders/check_or_count'),
					    type: 'POST',
					    dataType: 'json',
					    data: { 
					    	or_count: or_count},
					   	// data: 'order_id=<?php echo $order_id; ?>',
					    success: function(data) {
					    	if(data.status == 1){
					    		$('#or_count').val(data.unread);
					    		$('.unread_list').html(data.unread_html);					    		
					    	}
					    	$('#or_count').val(data.or_count);
					    	// if(data.status == 1){
					    	// 	location.reload();
					    	// }
						    // window.location.href = json['redirect'];
					    }
				    });
			}, 60000);
		});
		$(document).on('click', '#mark_all_read', function(){
		    $.ajax({
			    url: js_site_url('orders/mark_all_read'),
			    type: 'POST',
			    dataType: 'json',
			    data: { 
			    	all_read: '1'},
			   	// data: 'order_id=<?php echo $order_id; ?>',
			    success: function(data) {
			    	if(data.status == 1){
			    		$('#or_count').val(data.unread);
			    		$('.unread_list').html(data.unread_html);					    		
			    	}
			    	$('#or_count').val(data.or_count);
			    	// if(data.status == 1){
			    	// 	location.reload();
			    	// }
				    // window.location.href = json['redirect'];
			    }
		    });
		});
	</script>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
</head>
<style>
	.navbar-top .navbar-header {
    background-color: <?php echo $site_bg_color; ?> !important;
}
.sidebar .nav>li>a {
    color: <?php echo $site_bg_color; ?> !important;
    cursor: pointer;
    font-weight: normal;
    transition: all 0.4s ease-in-out 0s;
    font-size: 14px;
}

.sidebar .nav>li>a:hover,
.sidebar .nav>li>a:focus {
    background-color: <?php echo $site_bg_color; ?> !important;
    border-left: 0px solid #93abc6 !important;
    background-color: #93abc6;
}

.sidebar ul>li.active>a{
    background-color: <?php echo $site_bg_color; ?> !important;
    color: #FFFFFF !important;
    font-weight: bold;
}
.sidebar ul>li>a.active {
    background-color: <?php echo $site_bg_color; ?> !important;
    color: #FFFFFF !important;
    font-weight: bold;
}
</style>
<body lang="<?php echo $lang; ?>" dir="<?php echo $dir; ?>">
    <div id="wrapper" class="<?php echo $wrapper_class; ?>">
    	<input type="hidden" id="or_count">
		<nav class="navbar navbar-static-top navbar-top" role="navigation" style="margin-bottom: 0; background-color:<?php echo $site_bg_color; ?>">
			<div class="navbar-header">
				<div class="navbar-brand">
					<!--<div class="navbar-logo col-xs-3">
						<img class="logo-image" alt="<?php echo $system_name; ?>" title="<?php echo $system_name; ?>" src="<?php echo $site_logo; ?>"/>
					</div>-->
					<div class="navbar-logo col-xs-9">
						<img class="logo-text" id="side_img" alt="<?php echo $system_name; ?>" title="<?php echo $system_name; ?>" src="<?php echo $spotneat_logo; ?>"/>
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
						<?php echo get_nav_menu(array(
							'container_open'    => '<ul class="nav" id="side-menu">',
							'container_close'   => '</ul>',
						)); ?>
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

					
						<!-- <li>
						<form id ="langform" method="POST">
									<?php if($_SESSION['admin_lang']=='spanish'){ ?>
									<a><SPAN class="content"><i class="fa fa-language fa-fw lang_color"></i></SPAN><input type="button" name="language" class="change_lang lang_color"  onclick="change_lang(this.form)" value="english" ></a>
									<?php } else{ ?>
									<a><SPAN class="content"><i class="fa fa-language fa-fw lang_color"></i></SPAN><input type="button" name="language" class="change_lang lang_color"  onclick="change_lang(this.form)" value="spanish" ></a>
									<?php } ?>

								</form>
							
						</li> -->
				
				
					<!-- <li class="dropdown unread_list">
						<a class="dropdown-toggle messages" data-toggle="dropdown">
							<i class="fa fa-envelope"></i>
                            <span class="label label-danger unread"></span>
						</a>
						<ul class="dropdown-menu dropdown-messages notify">
                        </ul>
                    </li>
	                
					<li class="dropdown hide-data">
						<a class="dropdown-toggle alerts" data-toggle="dropdown">
							<i class="fa fa-bell"></i>
						</a>
                        <ul class="dropdown-menu dropdown-activities">
                            <li class="menu-header"><?php echo sprintf(lang('text_activity_count'), '4'); ?></li>
                            <li class="menu-body"></li>
                            <li class="menu-footer">
                                <a class="text-center" href="<?php echo site_url('activities'); ?>"><?php echo lang('text_see_all_activity'); ?></a>
                            </li>
                        </ul>
                    </li> -->
					<li class="dropdown hide-data">
						<a class="dropdown-toggle settings" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu dropdown-settings">
							<li class="hide-data"><a href="<?php echo site_url('pages'); ?>"><?php echo lang('menu_page'); ?></a></li>
							<li class="hide-data"><a href="<?php echo site_url('banners'); ?>"><?php echo lang('menu_banner'); ?></a></li>
							<li class="hide-data"><a href="<?php echo site_url('layouts'); ?>"><?php echo lang('menu_layout'); ?></a></li>
<!--							<li><a href="--><?php //echo site_url('uri_routes'); ?><!--">--><?php //echo lang('menu_uri_route'); ?><!--</a></li>-->
							<li class="hide-data"><a href="<?php echo site_url('error_logs'); ?>"><?php echo lang('menu_error_log'); ?></a></li>
							<li><a href="<?php echo site_url('settings'); ?>"><?php echo lang('menu_setting'); ?></a></li>
							<li class="menu-footer"></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user"></i>
						</a>
						<ul class="dropdown-menu  dropdown-user">
							<li>
								<div class="row wrap-vertical text-center">
									<div class="col-xs-12 wrap-top">
										<img class="img-rounded" src="<?php echo 'https://www.gravatar.com/avatar/'.$staff_avatar.'.png?s=48&d=mm'; ?>">
									</div>
									<div class="col-xs-12 wrap-none wrap-top wrap-right">
										<span><strong><?php echo $staff_name; ?></strong></span>
										<span class="small"><i>(<?php echo $username; ?>)</i></span><br>
										<span class="small text-uppercase"><?php echo $staff_group; ?></span>
										<span><?php echo $staff_location; ?></span>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<li><a href="<?php echo $staff_edit; ?>"><i class="fa fa-user fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_edit_details'); ?></a></li>
							<li><a class="list-group-item-danger" href="<?php echo $logout; ?>"><i class="fa fa-power-off fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_logout'); ?></a></li>
							<li class="divider"></li>
							<!--<li><a href="http://spotneat.com/about/" target="_blank"><i class="fa fa-info-circle fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_about_spotneat'); ?></a></li>
							<li><a href="http://docs.spotneat.com" target="_blank"><i class="fa fa-book fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_documentation'); ?></a></li>
							<li><a href="http://forum.spotneat.com" target="_blank"><i class="fa fa-users fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_community_support'); ?></a></li>
							<li class="menu-footer"></li>-->
						</ul>
					</li>
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
					
							<select name="restaurant" id="restaurant_ids" style="height: 40px; margin: auto; color: #fff; background: transparent;border:0px;outline:0px;">
									
								<?php 								
								foreach ($restaurant as $rest) { ?>

									<option <?php echo $_SESSION['location_id'] == $rest['location_id'] ? 'selected' : ''?> value="<?php echo $rest['location_id']; ?>" 
										<?php if($staff_location_id == $rest['location_id']){ echo "selected";
								} ?>
								 > <?php echo $rest['location_name'];?> </option>
								<?php } ?>
								
							</select>
							
							

				<?php } ?></strong></span>
										
							
										
			<?php } ?>
		</nav>
	<script type="text/javascript">
$(document).on('change', '#restaurant_ids', function(e) {
	var id = $( "#restaurant_ids option:selected" ).val();
	// alert(id);
    $.ajax({
		type: 'post',
		data: {
			id : id
		},
		url: '<?php echo site_url("menus/changelocation"); ?>',
		dataType: 'json',
		async: false,
		success: function(json) {
            location.reload();
        }
	});
});

			/*$('#restaurant').off("change");
								$(function() {
								    $('#restaurant').change(function() {
								       this.form.submit();
								        
								    });
								});


								$('#restaurant').on('change', function(e){
									//alert("hi");
  									$("#rest").submit();

								});
*/

							</script>		

		<div id="page-wrapper">
			<?php if ($islogged) { ?>
				<div class="page-header clearfix">
                    <?php
                        $button_list = get_button_list();
                        $icon_list = get_icon_list();
                    ?>

                   <?php if (!empty($button_list) OR !empty($icon_list)) { ?>
						<div class="page-action" onclick="buttonHide()">
                            <?php if (!empty($icon_list)) { ?>
                               <?php echo $icon_list; ?>
                            <?php } ?>

                            <?php if (!empty($button_list)) { ?>
                                <?php echo $button_list; ?>
                            <?php } ?>
						</div>
					<?php } ?>
				</div>

				<?php if (!empty($context_help)) { ?>
					<div class="collapse" id="context-help-wrap">
						<div class="well"><?php echo $context_help; ?></div>
					</div>
				<?php } ?>

				<div id="notification">
					<?php echo $this->alert->display(); ?>
				</div>
			<?php } ?>

			

