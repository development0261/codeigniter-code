<?php echo get_header(); ?>
<style>
@media screen and (max-width: 414px) {
    footer {
        margin-top: 0rem;
    }
}

</style>
<div id="page-content" style="background-color: #fdcec0 !important;">
	<div class="container">
		

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center top-20">

				<div id="login-form" class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12  content-wrap">
				
				<div class="heading-section top-20" >
						<h2 style="color: #f5511e;"><?php echo lang('text_register'); ?></h2>
						<!--<span class="under-heading"></span>-->
					
				</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 center-block">
				
				<div id="register-form" class="content-wrap col-md-12 col-sm-12 col-xs-12 center-block">
					<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form" class="">
						<div class="row">

							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="text" id="first-name" class="form-control input-md" value="<?php echo set_value('first_name'); ?>" name="first_name" placeholder="<?php echo lang('label_first_name'); ?>" autofocus="" maxlength="16"  onkeypress="return (event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" >
									<?php echo form_error('first_name', '<span class="text-danger" id="text-danger1">', '</span>'); ?>
								</div>
							</div>
							<div class="col-xs-12  col-sm-6 col-md-6 ">
								<div class="form-group">
									<input type="text" id="last-name" class="form-control input-md" value="<?php echo set_value('last_name'); ?>" name="last_name" placeholder="<?php echo lang('label_last_name'); ?>" maxlength="16"  onkeypress="return (event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" >
									<?php echo form_error('last_name', '<span class="text-danger" id="text-danger2">', '</span>'); ?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<input type="text" id="email" class="form-control input-md" value="<?php echo set_value('email'); ?>" name="email" placeholder="<?php echo lang('label_email'); ?>" onkeyup="AjaxLookup()"  autocomplete="off">
							<?php echo form_error('email', '<span class="text-danger" id="text-danger3">', '</span>'); ?>
							<span id="emailchecker"></span><span id="emailchecker1"  style="display: none;color: red;">Enter Email</span>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="password" id="password" class="form-control input-md" value="" name="password" placeholder="<?php echo lang('label_password'); ?>" maxlength="16">
									<?php echo form_error('password', '<span class="text-danger" id="text-danger4">', '</span>'); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="password" id="password-confirm" class="form-control input-md" name="password_confirm" value="" placeholder="<?php echo lang('label_password_confirm'); ?>" maxlength="16">
									<?php echo form_error('password_confirm', '<span class="text-danger" id="text-danger5">', '</span>'); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
							<select class="class-select2" name="country_code" id="country_code">

								<?php
								
								 foreach($phone_code as $pcode){?>

                                <option data-countryCode="<?php echo $pcode->code;?>" value="<?php echo $pcode->dial_code;?>"<?php if($pcode->dial_code == '+61' && $pcode->code == 'AU' && $telephone[0] == '') {echo ' selected';}?>><?php echo $pcode->code.' ('.$pcode->dial_code.')';?></option>
                            	<?php }?>

							</select>
							</div>
							</div>
							<div class="col-xs-12 col-sm-8 col-md-8">
							<div class="form-group">
							<input type="text" id="telephone" class="form-control input-md" value="<?php echo set_value('telephone'); ?>" name="telephone" placeholder="<?php echo lang('label_telephone'); ?>" maxlength="20<?php //echo $digits; ?>" onkeyup="AjaxLookupph()" autocomplete="off" >
							<?php echo form_error('telephone', '<span class="text-danger" id="text-danger6">', '</span>'); ?>
							<span id="phchecker"></span><span id="phchecker1" style="display: none;color: red;">Enter Phone Number</span>
							</div>
							
						</div>
						</div>
						<div class="form-group">
							<?php $val = set_value('security_question'); ?>
							
							<select name="security_question" id="security-question" class="class-select2" placeholder="<?php echo lang('label_s_question'); ?>">
							<?php foreach ($questions as $question) { ?>
								<option <?php echo $val == $question['id'] ? 'selected' : ''?> value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
							<?php } ?>
							</select>
							<?php echo form_error('security_question', '<span class="text-danger" id="text-danger7">', '</span>'); ?>
						</div>
						<div class="form-group">
							<input type="text" id="security-answer" class="form-control input-md" name="security_answer" value="<?php echo set_value('security_answer'); ?>" placeholder="<?php echo lang('label_s_answer'); ?>">
							<?php echo form_error('security_answer', '<span class="text-danger" id="text-danger8">', '</span>'); ?>
						</div>
						<!-- <div class="form-group">
							<div class="input-group" style="width: 100%">
         		 				<span><?php //echo $captcha['image']; ?></span>
								<input type="hidden" name="captcha_word" class="form-control" value="<?php //echo $captcha['word']; ?>" />
								<input type="text" name="captcha" class="form-control" placeholder="<?php //echo lang('label_captcha'); ?>" />
							</div>
							<?php //echo form_error('captcha', '<span class="text-danger" id="text-danger">', '</span>'); ?>
						</div> -->
						<!--<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<span class="button-checkbox">
									<button id="newsletter" type="button" class="btn" data-color="info" tabindex="7">&nbsp;&nbsp<?php //echo lang('button_subscribe'); ?></button>
			                        <input type="checkbox" name="newsletter" class="hidden" value="1" <?php //echo set_checkbox('newsletter', '1'); ?>>
								</span>
								 <?php //echo lang('label_newsletter'); ?>
							</div>
							<?php //echo form_error('newsletter', '<span class="text-danger" id="text-danger">', '</span>'); ?>
						</div>
						<br />-->

						<?php if ($registration_terms) {?>
							<div class="row">
								<div class="col-xs-8 col-sm-9 col-md-9">
									<span class="button-checkbox">
										<button id="terms-condition" type="button" class="btn" data-color="info" tabindex="7">&nbsp;&nbsp;<?php echo lang('button_terms_agree'); ?></button>
				                        <input type="checkbox" name="terms_condition" class="hidden" value="1" <?php echo set_checkbox('terms_condition', '1'); ?>>
									</span>
									<?php echo sprintf(lang('label_terms'), $registration_terms); ?>
								</div>
								<?php echo form_error('terms_condition', '<span class="text-danger" id="text-danger9">', '</span>'); ?>
							</div>
							<div class="modal fade" id="terms-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-body">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<br />
						<br />

						<div class="row">
							<div class="col-xs-12 col-md-12 col-sm-12">
								<button type="submit" class="btn btn-primary btn-block btn-lg"><?php echo lang('button_register'); ?></button>
							</div><br><br>
							<div class="col-xs-12 col-md-12 col-sm-12">
								<a href="<?php echo $login_url; ?>" style="text-align: right;float: right;margin-top: 30px; color: #f5511e !important;"><b><?php echo lang('label_already_have_account'); ?><?php echo lang('button_login'); ?></b></a>
							</div>
						</div>
					</form>
				</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#telephone').keypress(function(event){

       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
          document.getElementById("telephone").style.display = 'block';
           event.preventDefault(); //stop character from entering input
       }

   });

$('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});

	
     function AjaxLookup() {
            var emAddr = $('#email').val();
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;   
            var eml= emailReg.test( emAddr );
            //console.log(eml);
           if(!eml) {
           	$("#emailchecker").show();
           	document.getElementById("emailchecker1").style.display = 'none';
	             var result = '<span style="color:red">Enter Valid Email</span>';
	        	 $("#emailchecker").html(result);
	        	}
	        else {
	        	$.ajax({
	                     url:"account/check_reg",
	                     data:{email:emAddr},
	                     type:"POST",
	                     success:function(result) {
	                     	
	                         $("#emailchecker").html(result);
	                    }
	                 });
	        	
	        }
	         if(emAddr.length==0){
            	var result = '<span style="color:red">Enter Email</span>';
            	$("#emailchecker").hide();
            	 document.getElementById("emailchecker1").style.display = 'block';
	        	// $("#emailchecker1").html(result);
            }
	    }

	    function AjaxLookupph() {
            var pnNum = $('#telephone').val();
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
	                         $("#phchecker").html(result);
	                     	
	                     	
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
$("#first-name").keypress(function(){
	$('#text-danger1').css("display", "none");
});
$("#last-name").keypress(function(){
	$('#text-danger2').css("display", "none");
});
$("#email").keypress(function(){
	$('#text-danger3').css("display", "none");
});
$("#password").keypress(function(){
	$('#text-danger4').css("display", "none");
});
$("#password-confirm").keypress(function(){
	$('#text-danger5').css("display", "none");
});
$("#telephone").keypress(function(){
	$('#text-danger6').css("display", "none");
});
$("#security-question").keypress(function(){
	$('#text-danger7').css("display", "none");
});
$("#security-answer").keypress(function(){
	$('#text-danger8').css("display", "none");
});

$("#terms-condition").keypress(function(){
	$('#text-danger9').css("display", "none");
});
           
    
 </script>
<?php echo get_footer(); ?>