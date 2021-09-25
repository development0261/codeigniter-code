<?php

$pages = $this->Pages_model->getPages();

$body_class = '';
if ($this->uri->rsegment(1) === 'menus') {
	$body_class = 'menus-page';
}

if ($_SESSION['lang'] == 'arabic') {
	$dir = "rtl";
	$lan = 'ar';
	$this->template->setStyleTag('css/bootstrap-rtl.css', 'bootstrap-css', '5');
	$this->template->setStyleTag('css/superfish-rtl.css', 'superfish-css', '6');
	$this->template->setStyleTag('css/style-rtl.css', 'style-css', '17');
} elseif ($_SESSION['lang'] == 'spanish') {
	$dir = "ltr";
	$lan = 'es';
	$this->template->setStyleTag('css/bootstrap.css', 'bootstrap-css', '5');
	$this->template->setStyleTag('css/superfish.css', 'superfish-css', '6');
	$this->template->setStyleTag('css/style.css', 'style-css', '17');
} else {
	$dir = "ltr";
	$lan = 'en';
	$this->template->setStyleTag('css/bootstrap.css', 'bootstrap-css', '5');
	$this->template->setStyleTag('css/superfish.css', 'superfish-css', '6');
	$this->template->setStyleTag('css/style.css', 'style-css', '17');
}
?>
<?php echo get_doctype(); ?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<style>

 body{
 	unicode-bidi:bidi-override;
    direction:<?php echo $dir; ?>;
 }
<?php if ($dir == "rtl") {?>
   .datepicker {
        direction: rtl;
      }
    .datepicker.dropdown-menu {
right: initial;
      }
<?php }?>
</style>
<!DOCTYPE html lang="<?php echo $lan; ?>">
	<head>

        <?php echo get_metas(); ?>
        <?php if ($favicon = get_theme_options('favicon')) {?>
            <link href="<?php echo image_url($favicon); ?>" rel="shortcut icon" type="image/ico">
        <?php } else {?>
            <?php echo get_favicon(); ?>
        <?php }?>
       <title><?php echo sprintf(get_title(), config_item('site_name')); ?></title>
        <?php echo get_style_tags(); ?>
        <?php echo get_active_styles(); ?>
        <?php echo get_script_tags(); ?>
        <?php echo get_theme_options('ga_tracking_code'); ?>
		<script type="text/javascript">
			var alert_close = '<button type="button" class="close top-35" data-dismiss="alert" aria-hidden="true">&times;</button>';

			var js_site_url = function(str) {
				var strTmp = "<?php echo rtrim(site_url(), '/') . '/'; ?>" + str;
			 	return strTmp;
			};

			var js_base_url = function(str) {
				var strTmp = "<?php echo base_url(); ?>" + str;
				return strTmp;
			};

            var pageHeight = $(window).height();

			$(document).ready(function() {
				if ($('#notification > p').length > 0) {
					setTimeout(function() {
						$('#notification > p').slideUp(function() {
							$('#notification').empty();
						});
					}, 3000);
				}

				$('.alert').alert();
				$('.dropdown-toggle').dropdown();
                $('a[title], i[title]').tooltip({placement: 'bottom'});
                $('select.form-control').select2();


			//$('#resend').addEventListener("click", disable_resend);

			});
			$(document).ready(function() {

							    $('#submit_phone').click(function() {
							    	$tel = $('#telephone').val();

				if($tel==''){
					$('#phchecker1').show();
					return false;
				}

			        return confirm('Are you sure to update the Phone number?');
			    });
			});
		</script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
        <?php $custom_script = get_theme_options('custom_script');?>
        <?php if (!empty($custom_script['head'])) {echo '<script type="text/javascript">' . $custom_script['head'] . '</script>';}
;?>
	</head>
	<body class="<?php echo $body_class; ?>" lang="<?php echo $lang; ?>" dir="<?php echo $dir; ?>">
		<?php
$this->load->model('Locations_model');
$customer_id = $this->customer->getId();
$telephone = $this->customer->getTelephone();

if (isset($_POST["otp"])) {
	$otp = $_POST["otp"];
	$get_otp = $this->Locations_model->getOTP($customer_id);
	if ($otp == $get_otp) {
		$this->Locations_model->updateVerifyStatus($customer_id);
	} else {?>
		 	<script type="text/javascript">
		 		$( document ).ready(function() {
		 		 $('#wrong_otp').show();
		 		 });
		 	</script>
		 <?php }
}
if (isset($_POST['submit_phone'])) {
	$mob = $_POST['country_code'] . '-' . $_POST['telephone'];
	$mob_update = $this->Locations_model->updatePhone($customer_id, $mob);

	$this->load->model('Extensions_model');
	$this->load->library('session');
	$i = 0;
	$pin = "";
	while ($i < 4) {

		$pin .= mt_rand(0, 9);
		$i++;
	}
	$this->Locations_model->updateOTP($customer_id, $pin);
	$sms_status = $this->Extensions_model->getExtension('twilio_module');

	$verify_otp = $pin;
	$telephone = $this->customer->getTelephone();
	if ($sms_status['status'] == 1) {
		$current_lang = $this->session->userdata('lang');
		if (!$current_lang) {$current_lang = "english";}
		$sms_code = 'resend_' . $current_lang;
		$sms_template = $this->Extensions_model->getTemplates($sms_code);
		$message = $sms_template['body'];
		$message = str_replace("{otp}", $verify_otp, $message);
		if ($telephone != '') {
			$ctlObj = modules::load('twilio_module/twilio_module/');
			$client_msg = $ctlObj->Sendsms($telephone, $message);

		}
	}
	header("Refresh:0");

}

$verify_status = $this->Locations_model->getOTPStatus($customer_id);
if ($verify_status == 0 && $verify_status != '') {
	?>
			<script type="text/javascript">

				// $("#resend").click(function(){
				// 	//disable_resend();
				// });
			    $(window).on('load',function(){
			        //$('#otp_popup').modal('show');
			    });
			    $('#otp_popup').modal({
			    backdrop: 'static',
			    keyboard: false  // to prevent closing with Esc button (if you want this too)
			});

			    function resend_otp() {

			    	jQuery.ajax({
				        type: "POST",
				        url: 'resend_sms',
				        data: {functionname: 'resend_sms'},
				         success:function(data) {
				        	//console.log(data);
				        	//return false;
				        	 //$("#success_sms").html(data);
				        	disable_resend();
				         }
				    });
			    }
			    function disable_resend(){
			    	//console.log('hello');
			    document.getElementById("resend").disabled = true;
			    document.getElementById("resend_text").style.display = 'block';
			     document.getElementById("success_sms").style.display = 'block';
			    setTimeout(function() {
			        document.getElementById("resend").disabled = false;
			        document.getElementById("resend_text").style.display = 'none';
			        document.getElementById("success_sms").style.display = 'none';
			    }, 60000);

			}

			function showphone(){
				document.getElementById("resend_show").style.display = 'none';
				document.getElementById("update_phone").style.display = 'block';
			}
			function hidephone(){
				document.getElementById("resend_show").style.display = 'block';
				document.getElementById("update_phone").style.display = 'none';
			}
			var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        $(function () {
            $("#telephone").bind("keypress", function (e) {
                var keyCode = e.which ? e.which : e.keyCode
                var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
                $(".error").css("display", ret ? "none" : "inline");
                return ret;
            });
            $("#telephone").bind("paste", function (e) {
                return false;
            });
            $("#telephone").bind("drop", function (e) {
                return false;
            });
        });
			 function AjaxLookupph() {
            var pnNum = $('#telephone').val();

            var isValid = false;


            var cc = $('#country_code').val();
            var pn = cc + '-' + pnNum;

            console.log(pnNum);


           if(!pn) {


	             var result = '<span style="color:red">Enter Valid phone number</span>';
	        	 $("#phchecker").html(result);
	        	}
	        else {
	        	$.ajax({
	                     url:"account/check_ph",
	                     data:{phone:pn},
	                     type:"POST",
	                     success:function(result) {
	                     	console.log(result);
	                     	if(result == '<span style="color:red">Phone Number Already Exists</span>'){
	                     		 $(':input[type="submit"]').prop('disabled', true);
	                     	}
	                     	else{
	                     		$(':input[type="submit"]').prop('disabled', false);
	                        }
	                         //$("#phchecker").html(result);


	                    }
	                 });

	        }
	         if(pnNum==''){
            	var result = '<span style="color:red">Enter Valid phone number</span>';
	        	 $("#phchecker").hide();
	        	  document.getElementById("phchecker1").style.display = 'block';
            }	else{
            	$("#phchecker").show();
           	document.getElementById("phchecker1").style.display = 'none';
            }
	    }
			</script>
			<div id="otp_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <h4 class="modal-title">Enter 4 Digit OTP</h4>
			      </div>
			      <div class="modal-body">


			        <div style="float: left;">	A 4 digit verification code sent to your number  <?php echo substr($telephone, 0, 6) . str_repeat("X", strlen($telephone) - 8) . substr($telephone, 12, 2); ?>.</div>
			       	<div style="float: right;"><a style="cursor: pointer;" onclick="showphone()">Change Number</a></div>

			       	<div id="update_phone" style="display: none;">
			       		<p><br />
			       		<form action="" method="POST">
			        		 	<div class="row">
					        <div class="col-sm-3">
					        	<select class="class-select2" name="country_code" id="country_code">

								                                <option data-countrycode="AF" value="+93">AF (+93)</option>
                            	                                <option data-countrycode="AX" value="+358">AX (+358)</option>
                            	                                <option data-countrycode="AL" value="+355">AL (+355)</option>
                            	                                <option data-countrycode="DZ" value="+213">DZ (+213)</option>
                            	                                <option data-countrycode="AS" value="+1684">AS (+1684)</option>
                            	                                <option data-countrycode="AD" value="+376">AD (+376)</option>
                            	                                <option data-countrycode="AO" value="+244">AO (+244)</option>
                            	                                <option data-countrycode="AI" value="+1264">AI (+1264)</option>
                            	                                <option data-countrycode="AQ" value="+672">AQ (+672)</option>
                            	                                <option data-countrycode="AG" value="+1268">AG (+1268)</option>
                            	                                <option data-countrycode="AR" value="+54">AR (+54)</option>
                            	                                <option data-countrycode="AM" value="+374">AM (+374)</option>
                            	                                <option data-countrycode="AW" value="+297">AW (+297)</option>
                            	                                <option data-countrycode="AU" value="+61">AU (+61)</option>
                            	                                <option data-countrycode="AT" value="+43">AT (+43)</option>
                            	                                <option data-countrycode="AZ" value="+994">AZ (+994)</option>
                            	                                <option data-countrycode="BS" value="+1242">BS (+1242)</option>
                            	                                <option data-countrycode="BH" value="+973">BH (+973)</option>
                            	                                <option data-countrycode="BD" value="+880">BD (+880)</option>
                            	                                <option data-countrycode="BB" value="+1246">BB (+1246)</option>
                            	                                <option data-countrycode="BY" value="+375">BY (+375)</option>
                            	                                <option data-countrycode="BE" value="+32">BE (+32)</option>
                            	                                <option data-countrycode="BZ" value="+501">BZ (+501)</option>
                            	                                <option data-countrycode="BJ" value="+229">BJ (+229)</option>
                            	                                <option data-countrycode="BM" value="+1441">BM (+1441)</option>
                            	                                <option data-countrycode="BT" value="+975">BT (+975)</option>
                            	                                <option data-countrycode="BO" value="+591">BO (+591)</option>
                            	                                <option data-countrycode="BQ" value="+599">BQ (+599)</option>
                            	                                <option data-countrycode="BA" value="+387">BA (+387)</option>
                            	                                <option data-countrycode="BW" value="+267">BW (+267)</option>
                            	                                <option data-countrycode="BV" value="+55">BV (+55)</option>
                            	                                <option data-countrycode="BR" value="+55">BR (+55)</option>
                            	                                <option data-countrycode="IO" value="+246">IO (+246)</option>
                            	                                <option data-countrycode="BN" value="+673">BN (+673)</option>
                            	                                <option data-countrycode="BG" value="+359">BG (+359)</option>
                            	                                <option data-countrycode="BF" value="+226">BF (+226)</option>
                            	                                <option data-countrycode="BI" value="+257">BI (+257)</option>
                            	                                <option data-countrycode="KH" value="+855">KH (+855)</option>
                            	                                <option data-countrycode="CM" value="+237">CM (+237)</option>
                            	                                <option data-countrycode="CA" value="+1">CA (+1)</option>
                            	                                <option data-countrycode="CV" value="+238">CV (+238)</option>
                            	                                <option data-countrycode="KY" value="+1345">KY (+1345)</option>
                            	                                <option data-countrycode="CF" value="+236">CF (+236)</option>
                            	                                <option data-countrycode="TD" value="+235">TD (+235)</option>
                            	                                <option data-countrycode="CL" value="+56">CL (+56)</option>
                            	                                <option data-countrycode="CN" value="+86">CN (+86)</option>
                            	                                <option data-countrycode="CX" value="+61">CX (+61)</option>
                            	                                <option data-countrycode="CC" value="+61">CC (+61)</option>
                            	                                <option data-countrycode="CO" value="+57">CO (+57)</option>
                            	                                <option data-countrycode="KM" value="+269">KM (+269)</option>
                            	                                <option data-countrycode="CG" value="+242">CG (+242)</option>
                            	                                <option data-countrycode="CD" value="+243">CD (+243)</option>
                            	                                <option data-countrycode="CK" value="+682">CK (+682)</option>
                            	                                <option data-countrycode="CR" value="+506">CR (+506)</option>
                            	                                <option data-countrycode="CI" value="+225">CI (+225)</option>
                            	                                <option data-countrycode="HR" value="+385">HR (+385)</option>
                            	                                <option data-countrycode="CU" value="+53">CU (+53)</option>
                            	                                <option data-countrycode="CW" value="+5999">CW (+5999)</option>
                            	                                <option data-countrycode="CY" value="+357">CY (+357)</option>
                            	                                <option data-countrycode="CZ" value="+420">CZ (+420)</option>
                            	                                <option data-countrycode="DK" value="+45">DK (+45)</option>
                            	                                <option data-countrycode="DJ" value="+253">DJ (+253)</option>
                            	                                <option data-countrycode="DM" value="+1767">DM (+1767)</option>
                            	                                <option data-countrycode="DO" value="+1849">DO (+1849)</option>
                            	                                <option data-countrycode="EC" value="+593">EC (+593)</option>
                            	                                <option data-countrycode="EG" value="+20">EG (+20)</option>
                            	                                <option data-countrycode="SV" value="+503">SV (+503)</option>
                            	                                <option data-countrycode="GQ" value="+240">GQ (+240)</option>
                            	                                <option data-countrycode="ER" value="+291">ER (+291)</option>
                            	                                <option data-countrycode="EE" value="+372">EE (+372)</option>
                            	                                <option data-countrycode="ET" value="+251">ET (+251)</option>
                            	                                <option data-countrycode="FK" value="+500">FK (+500)</option>
                            	                                <option data-countrycode="FO" value="+298">FO (+298)</option>
                            	                                <option data-countrycode="FJ" value="+679">FJ (+679)</option>
                            	                                <option data-countrycode="FI" value="+358">FI (+358)</option>
                            	                                <option data-countrycode="FR" value="+33">FR (+33)</option>
                            	                                <option data-countrycode="GF" value="+594">GF (+594)</option>
                            	                                <option data-countrycode="PF" value="+689">PF (+689)</option>
                            	                                <option data-countrycode="TF" value="+262">TF (+262)</option>
                            	                                <option data-countrycode="GA" value="+241">GA (+241)</option>
                            	                                <option data-countrycode="GM" value="+220">GM (+220)</option>
                            	                                <option data-countrycode="GE" value="+995">GE (+995)</option>
                            	                                <option data-countrycode="DE" value="+49">DE (+49)</option>
                            	                                <option data-countrycode="GH" value="+233">GH (+233)</option>
                            	                                <option data-countrycode="GI" value="+350">GI (+350)</option>
                            	                                <option data-countrycode="GR" value="+30">GR (+30)</option>
                            	                                <option data-countrycode="GL" value="+299">GL (+299)</option>
                            	                                <option data-countrycode="GD" value="+1473">GD (+1473)</option>
                            	                                <option data-countrycode="GP" value="+590">GP (+590)</option>
                            	                                <option data-countrycode="GU" value="+1671">GU (+1671)</option>
                            	                                <option data-countrycode="GT" value="+502">GT (+502)</option>
                            	                                <option data-countrycode="GG" value="+44">GG (+44)</option>
                            	                                <option data-countrycode="GN" value="+224">GN (+224)</option>
                            	                                <option data-countrycode="GW" value="+245">GW (+245)</option>
                            	                                <option data-countrycode="GY" value="+592">GY (+592)</option>
                            	                                <option data-countrycode="HT" value="+509">HT (+509)</option>
                            	                                <option data-countrycode="HM" value="+672">HM (+672)</option>
                            	                                <option data-countrycode="VA" value="+379">VA (+379)</option>
                            	                                <option data-countrycode="HN" value="+504">HN (+504)</option>
                            	                                <option data-countrycode="HK" value="+852">HK (+852)</option>
                            	                                <option data-countrycode="HU" value="+36">HU (+36)</option>
                            	                                <option data-countrycode="IS" value="+354">IS (+354)</option>
                            	                                <option data-countrycode="IN" value="+91" selected="">IN (+91)</option>
                            	                                <option data-countrycode="ID" value="+62">ID (+62)</option>
                            	                                <option data-countrycode="IR" value="+98">IR (+98)</option>
                            	                                <option data-countrycode="IQ" value="+964">IQ (+964)</option>
                            	                                <option data-countrycode="IE" value="+353">IE (+353)</option>
                            	                                <option data-countrycode="IM" value="+44">IM (+44)</option>
                            	                                <option data-countrycode="IL" value="+972">IL (+972)</option>
                            	                                <option data-countrycode="IT" value="+39">IT (+39)</option>
                            	                                <option data-countrycode="JM" value="+1876">JM (+1876)</option>
                            	                                <option data-countrycode="JP" value="+81">JP (+81)</option>
                            	                                <option data-countrycode="JE" value="+44">JE (+44)</option>
                            	                                <option data-countrycode="JO" value="+962">JO (+962)</option>
                            	                                <option data-countrycode="KZ" value="+77">KZ (+77)</option>
                            	                                <option data-countrycode="KE" value="+254">KE (+254)</option>
                            	                                <option data-countrycode="KI" value="+686">KI (+686)</option>
                            	                                <option data-countrycode="KP" value="+850">KP (+850)</option>
                            	                                <option data-countrycode="KR" value="+82">KR (+82)</option>
                            	                                <option data-countrycode="XK" value="+383">XK (+383)</option>
                            	                                <option data-countrycode="KW" value="+965">KW (+965)</option>
                            	                                <option data-countrycode="KG" value="+996">KG (+996)</option>
                            	                                <option data-countrycode="LA" value="+856">LA (+856)</option>
                            	                                <option data-countrycode="LV" value="+371">LV (+371)</option>
                            	                                <option data-countrycode="LB" value="+961">LB (+961)</option>
                            	                                <option data-countrycode="LS" value="+266">LS (+266)</option>
                            	                                <option data-countrycode="LR" value="+231">LR (+231)</option>
                            	                                <option data-countrycode="LY" value="+218">LY (+218)</option>
                            	                                <option data-countrycode="LI" value="+423">LI (+423)</option>
                            	                                <option data-countrycode="LT" value="+370">LT (+370)</option>
                            	                                <option data-countrycode="LU" value="+352">LU (+352)</option>
                            	                                <option data-countrycode="MO" value="+853">MO (+853)</option>
                            	                                <option data-countrycode="MK" value="+389">MK (+389)</option>
                            	                                <option data-countrycode="MG" value="+261">MG (+261)</option>
                            	                                <option data-countrycode="MW" value="+265">MW (+265)</option>
                            	                                <option data-countrycode="MY" value="+60">MY (+60)</option>
                            	                                <option data-countrycode="MV" value="+960">MV (+960)</option>
                            	                                <option data-countrycode="ML" value="+223">ML (+223)</option>
                            	                                <option data-countrycode="MT" value="+356">MT (+356)</option>
                            	                                <option data-countrycode="MH" value="+692">MH (+692)</option>
                            	                                <option data-countrycode="MQ" value="+596">MQ (+596)</option>
                            	                                <option data-countrycode="MR" value="+222">MR (+222)</option>
                            	                                <option data-countrycode="MU" value="+230">MU (+230)</option>
                            	                                <option data-countrycode="YT" value="+262">YT (+262)</option>
                            	                                <option data-countrycode="MX" value="+52">MX (+52)</option>
                            	                                <option data-countrycode="FM" value="+691">FM (+691)</option>
                            	                                <option data-countrycode="MD" value="+373">MD (+373)</option>
                            	                                <option data-countrycode="MC" value="+377">MC (+377)</option>
                            	                                <option data-countrycode="MN" value="+976">MN (+976)</option>
                            	                                <option data-countrycode="ME" value="+382">ME (+382)</option>
                            	                                <option data-countrycode="MS" value="+1664">MS (+1664)</option>
                            	                                <option data-countrycode="MA" value="+212">MA (+212)</option>
                            	                                <option data-countrycode="MZ" value="+258">MZ (+258)</option>
                            	                                <option data-countrycode="MM" value="+95">MM (+95)</option>
                            	                                <option data-countrycode="NA" value="+264">NA (+264)</option>
                            	                                <option data-countrycode="NR" value="+674">NR (+674)</option>
                            	                                <option data-countrycode="NP" value="+977">NP (+977)</option>
                            	                                <option data-countrycode="NL" value="+31">NL (+31)</option>
                            	                                <option data-countrycode="AN" value="+599">AN (+599)</option>
                            	                                <option data-countrycode="NC" value="+687">NC (+687)</option>
                            	                                <option data-countrycode="NZ" value="+64">NZ (+64)</option>
                            	                                <option data-countrycode="NI" value="+505">NI (+505)</option>
                            	                                <option data-countrycode="NE" value="+227">NE (+227)</option>
                            	                                <option data-countrycode="NG" value="+234">NG (+234)</option>
                            	                                <option data-countrycode="NU" value="+683">NU (+683)</option>
                            	                                <option data-countrycode="NF" value="+672">NF (+672)</option>
                            	                                <option data-countrycode="MP" value="+1670">MP (+1670)</option>
                            	                                <option data-countrycode="NO" value="+47">NO (+47)</option>
                            	                                <option data-countrycode="OM" value="+968">OM (+968)</option>
                            	                                <option data-countrycode="PK" value="+92">PK (+92)</option>
                            	                                <option data-countrycode="PW" value="+680">PW (+680)</option>
                            	                                <option data-countrycode="PS" value="+970">PS (+970)</option>
                            	                                <option data-countrycode="PA" value="+507">PA (+507)</option>
                            	                                <option data-countrycode="PG" value="+675">PG (+675)</option>
                            	                                <option data-countrycode="PY" value="+595">PY (+595)</option>
                            	                                <option data-countrycode="PE" value="+51">PE (+51)</option>
                            	                                <option data-countrycode="PH" value="+63">PH (+63)</option>
                            	                                <option data-countrycode="PN" value="+870">PN (+870)</option>
                            	                                <option data-countrycode="PL" value="+48">PL (+48)</option>
                            	                                <option data-countrycode="PT" value="+351">PT (+351)</option>
                            	                                <option data-countrycode="PR" value="+1939">PR (+1939)</option>
                            	                                <option data-countrycode="QA" value="+974">QA (+974)</option>
                            	                                <option data-countrycode="RO" value="+40">RO (+40)</option>
                            	                                <option data-countrycode="RU" value="+7">RU (+7)</option>
                            	                                <option data-countrycode="RW" value="+250">RW (+250)</option>
                            	                                <option data-countrycode="RE" value="+262">RE (+262)</option>
                            	                                <option data-countrycode="BL" value="+590">BL (+590)</option>
                            	                                <option data-countrycode="SH" value="+290">SH (+290)</option>
                            	                                <option data-countrycode="KN" value="+1869">KN (+1869)</option>
                            	                                <option data-countrycode="LC" value="+1758">LC (+1758)</option>
                            	                                <option data-countrycode="MF" value="+590">MF (+590)</option>
                            	                                <option data-countrycode="PM" value="+508">PM (+508)</option>
                            	                                <option data-countrycode="VC" value="+1784">VC (+1784)</option>
                            	                                <option data-countrycode="WS" value="+685">WS (+685)</option>
                            	                                <option data-countrycode="SM" value="+378">SM (+378)</option>
                            	                                <option data-countrycode="ST" value="+239">ST (+239)</option>
                            	                                <option data-countrycode="SA" value="+966">SA (+966)</option>
                            	                                <option data-countrycode="SN" value="+221">SN (+221)</option>
                            	                                <option data-countrycode="RS" value="+381">RS (+381)</option>
                            	                                <option data-countrycode="SC" value="+248">SC (+248)</option>
                            	                                <option data-countrycode="SL" value="+232">SL (+232)</option>
                            	                                <option data-countrycode="SG" value="+65">SG (+65)</option>
                            	                                <option data-countrycode="SX" value="+1721">SX (+1721)</option>
                            	                                <option data-countrycode="SK" value="+421">SK (+421)</option>
                            	                                <option data-countrycode="SI" value="+386">SI (+386)</option>
                            	                                <option data-countrycode="SB" value="+677">SB (+677)</option>
                            	                                <option data-countrycode="SO" value="+252">SO (+252)</option>
                            	                                <option data-countrycode="ZA" value="+27">ZA (+27)</option>
                            	                                <option data-countrycode="SS" value="+211">SS (+211)</option>
                            	                                <option data-countrycode="GS" value="+500">GS (+500)</option>
                            	                                <option data-countrycode="ES" value="+34">ES (+34)</option>
                            	                                <option data-countrycode="LK" value="+94">LK (+94)</option>
                            	                                <option data-countrycode="SD" value="+249">SD (+249)</option>
                            	                                <option data-countrycode="SR" value="+597">SR (+597)</option>
                            	                                <option data-countrycode="SJ" value="+47">SJ (+47)</option>
                            	                                <option data-countrycode="SZ" value="+268">SZ (+268)</option>
                            	                                <option data-countrycode="SE" value="+46">SE (+46)</option>
                            	                                <option data-countrycode="CH" value="+41">CH (+41)</option>
                            	                                <option data-countrycode="SY" value="+963">SY (+963)</option>
                            	                                <option data-countrycode="TW" value="+886">TW (+886)</option>
                            	                                <option data-countrycode="TJ" value="+992">TJ (+992)</option>
                            	                                <option data-countrycode="TZ" value="+255">TZ (+255)</option>
                            	                                <option data-countrycode="TH" value="+66">TH (+66)</option>
                            	                                <option data-countrycode="TL" value="+670">TL (+670)</option>
                            	                                <option data-countrycode="TG" value="+228">TG (+228)</option>
                            	                                <option data-countrycode="TK" value="+690">TK (+690)</option>
                            	                                <option data-countrycode="TO" value="+676">TO (+676)</option>
                            	                                <option data-countrycode="TT" value="+1868">TT (+1868)</option>
                            	                                <option data-countrycode="TN" value="+216">TN (+216)</option>
                            	                                <option data-countrycode="TR" value="+90">TR (+90)</option>
                            	                                <option data-countrycode="TM" value="+993">TM (+993)</option>
                            	                                <option data-countrycode="TC" value="+1649">TC (+1649)</option>
                            	                                <option data-countrycode="TV" value="+688">TV (+688)</option>
                            	                                <option data-countrycode="UG" value="+256">UG (+256)</option>
                            	                                <option data-countrycode="UA" value="+380">UA (+380)</option>
                            	                                <option data-countrycode="AE" value="+971">AE (+971)</option>
                            	                                <option data-countrycode="GB" value="+44">GB (+44)</option>
                            	                                <option data-countrycode="US" value="+1">US (+1)</option>
                            	                                <option data-countrycode="UM" value="+1581">UM (+1581)</option>
                            	                                <option data-countrycode="UY" value="+598">UY (+598)</option>
                            	                                <option data-countrycode="UZ" value="+998">UZ (+998)</option>
                            	                                <option data-countrycode="VU" value="+678">VU (+678)</option>
                            	                                <option data-countrycode="VE" value="+58">VE (+58)</option>
                            	                                <option data-countrycode="VN" value="+84">VN (+84)</option>
                            	                                <option data-countrycode="VG" value="+1284">VG (+1284)</option>
                            	                                <option data-countrycode="VI" value="+1340">VI (+1340)</option>
                            	                                <option data-countrycode="WF" value="+681">WF (+681)</option>
                            	                                <option data-countrycode="EH" value="+212">EH (+212)</option>
                            	                                <option data-countrycode="YE" value="+967">YE (+967)</option>
                            	                                <option data-countrycode="ZM" value="+260">ZM (+260)</option>
                            	                                <option data-countrycode="ZW" value="+263">ZW (+263)</option>

							</select>
						</div>
						 <div class="col-sm-3">
					        <input type="text" name="telephone" id="telephone" class="form-control" autocomplete="off"  onkeyup="AjaxLookupph()" maxlength="<?php echo $this->config->item('digits_mobile'); ?>">
					        <span id="phchecker"></span><span id="phchecker1" style="display: none;color: red;">Enter Phone Number</span>
					    	</div>
					    	<div class="col-sm-5 ">
					    		<input type="submit" name="submit_phone" id="submit_phone" value="Update Mobile & Resend OTP" class="btn btn-primary btn-sm" >
					    	</div>
					    	</div>
					    	<br />
					    	<div align="right"><a style="cursor:pointer;" onclick="hidephone()">Back</a></div>
					    	</form></p>
			       	</div>

			        <div id="resend_show">
			         <p>	<br />

			        		 <form action="" method="POST">
			        		 	<div class="row">
					        <div class="col-sm-3">
					        <input type="text" name="otp" class="form-control" autocomplete="off" maxlength="4" style="height: 30px !important;" >
					        <span id="wrong_otp" style='color: red;display: none;'>Invalid OTP</span>
					    	</div>
					    	<div class="col-sm-3 ">
					    		<input type="submit" name="submit" value="Verify" class="btn btn-primary btn-sm" >
					    	</div>
					    	</div>
					    	<br />

					    	</form>

					    	<div class="col-sm-3">
					    		<a class="" id="resend" name="resend" onclick="resend_otp()" style="cursor: pointer;" >Resend OTP</a>
					    	</div>
					    	<div class="col-sm-9">
					    		<span id="success_sms"></span>
					    		<span id="resend_text" style="display: none;color: red;"> Wait for 60 seconds till next click!</span>
					    	</div>
					    	</p>
			    	</div>
			      </div>

			    </div>

			  </div>
			</div>

		<?php }?>
		<div id="opaclayer" onclick="closeReviewBox();"></div>
        <!--[if lt IE 7]>
            <p class="chromeframe"><?php echo lang('alert_info_outdated_browser'); ?></p>
        <![endif]-->
		<div id="fh5co-wrapper">
		<div id="fh5co-page">

		<header id="fh5co-header-section" class="sticky-banner">
			<div class="container">
				<div class="">
				<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle dark ui-link"><i></i></a>

					<div class="col-md-6 col-sm-6 col-xs-6 padd-none text-center " >
						<a  href="<?php echo rtrim(site_url(), '/') . '/'; ?>">
									<?php if (get_theme_options('logo_image')) {?>
										<img alt="<?php echo $this->config->item('site_name'); ?>" src="<?php echo image_url(get_theme_options('logo_image')) ?>" class="img-responsive" style="height:95px" >
									<?php } else if (get_theme_options('logo_text')) {?>
										<?php echo get_theme_options('logo_text'); ?>
									<?php } else if ($this->config->item('site_logo') === 'data/no_photo.png') {?>
										<?php echo $this->config->item('site_name'); ?>
									<?php } else {?>
										<img alt="<?php echo $this->config->item('site_name'); ?>" src="<?php echo image_url($this->config->item('site_logo')) ?>"  class="img-responsive" style="height:95px">
									<?php }?>
								</a>
					</div>


					<div class="col-md-6 col-sm-6 col-xs-6 padd-none">
					<!-- START #fh5co-menu-wrap -->
					<nav id="fh5co-menu-wrap"   role="navigation">

						<ul class="sf-menu" id="fh5co-primary-menu">
								<!-- <li style="margin-top: 8px;">
									<form id ="langform" method="POST">
									<?php if ($_SESSION['lang'] == 'spanish') {?>
									<input type="button" name="lang" class="change_lang"  onclick="change_lang(this.form)" value="english" >
									<?php } else {?>
									<input type="button" name="lang" class="change_lang"  onclick="change_lang(this.form)" value="spanish" >
									<?php }?>
									</form>
								</li> -->
							<?php /* if ($this->config->item('reservation_mode') === '1') { ?>
<li><a href="<?php echo site_url('reservation'); ?>" class="fh5co-sub-ddown"><?php echo lang('menu_reservation'); ?></a></li>
<?php }*/?>
								<?php if ($this->customer->isLogged()) {
	?>
									<li class="dropdown"><a class="dropdown-toggle clickable" data-toggle="dropdown" id="dropdownLabel1" class="fh5co-sub-ddown">


									<?php
$prof_img = $this->customer->getProfileImage();
	$email = $this->customer->getEmail();
	$getName = $this->customer->getName();
echo $getName = $this->customer->getName();
	if ($prof_img != '') {
		?> <?php } else {?>
										
										<?php }?>

									<!-- <span class="caret"></span> --></a>

										<ul class="fh5co-sub-menu" role="menu" aria-labelledby="dropdownLabel1">

											<li class="res-color-white" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;font-weight: bold;text-transform: capitalize;"><?php echo $getName; ?></li>
											<li class="res-color-white" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis; font-size: 10px;"><?php echo $email; ?></li>

                                            <li><a role="presentation" href="<?php echo site_url('account/account'); ?>" class="fh5co-sub-ddown"><img src="<?php echo site_url() . 'assets/images/profile_images/acc.png'; ?>" width="25" height="25">
                                            <!-- <i class="fa fa-tachometer " aria-hidden="true"></i> --> &nbsp;&nbsp;<?php echo lang('menu_my_account'); ?></a></li>
                                           <!--  <li><a role="presentation" href="<?php //echo site_url('account/address'); ?>" class="fh5co-sub-ddown"><?php //echo lang('menu_address'); ?></a></li> -->

											<?php if ($this->config->item('reservation_mode') === '1') {?>
												 <li><a role="presentation" href="<?php echo site_url('account/reservations'); ?>" class="fh5co-sub-ddown"><img src="<?php echo site_url() . 'assets/images/profile_images/list.png'; ?> " width="25" height="25">&nbsp;&nbsp;<?php echo lang('menu_recent_reservation'); ?></a></li>
												 <li><a role="presentation" href="<?php echo site_url('account/orders'); ?>" class="fh5co-sub-ddown"><img src="<?php echo site_url() . 'assets/images/profile_images/list.png'; ?> " width="25" height="25">&nbsp;&nbsp;	<?php echo lang('menu_order'); ?></a></li>
											<?php }?>

											<li><a role="presentation" href="<?php echo site_url('account/logout'); ?>" class="fh5co-sub-ddown" ><img src="<?php echo site_url() . 'assets/images/profile_images/logout.png'; ?> " width="25" height="25"><!-- <i class="fa fa-sign-out" aria-hidden="true"></i> -->&nbsp;&nbsp;<?php echo lang('menu_logout'); ?></a></li>

										</ul>
									</li>
								<?php } else {?>

									<?php
										if($this->uri->segment(1) != 'policy')
										{
									?>
									<li>
									<a href="<?php echo site_url('account/login'); ?>" class="fh5co-sub-ddown"><?php echo lang('menu_login'); ?></a>
										<?php /* <ul class="fh5co-sub-menu">
<li><a href="<?php echo site_url('account/login'); ?>"><?php echo lang('user_login'); ?></a></li>
<li><a href="<?php echo site_url('admin'); ?>"><?php echo lang('client_login'); ?></a></li>
</ul>	*/?>
									</li>
									<li><a href="<?php echo site_url('account/register'); ?>" class="fh5co-sub-ddown"><?php echo lang('menu_register'); ?></a></li>
								<?php 
									} 
								}
								?>

								<?php if (!empty($pages)) {?>
									<?php foreach ($pages as $page) {?>
										<?php if (is_array($page['navigation']) AND in_array('header', $page['navigation'])) {?>
											<li><a href="<?php echo site_url('pages?page_id=' . $page['page_id']); ?>" class="fh5co-sub-ddown"><?php echo $page['name']; ?></a></li>
										<?php }?>
									<?php }?>
								<?php }?>

						</ul>


					</nav>

				</div>

				</div>

			</div>
			<!-- <div class="<?php echo (!$is_mobile AND !$is_checkout) ? 'visible-xs' : 'hide'; ?>" style="float: right; padding-right: 20px;padding-bottom: 15px;">
			    <a  href="<?php echo site_url('cart') ?>" style="text-overflow:ellipsis; overflow:hidden;">
			    Cart &nbsp;<i class="fa fa-shopping-cart" aria-hidden="true"></i>
			    </a>
			</div> -->
		</header>

