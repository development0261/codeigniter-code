<?php echo get_header(); ?>
<style>
@media screen and (max-width: 414px) {

	#page-content{
		height: 87vh !important;
		}

    footer {
        margin-top: 0rem;
    }
}
</style>
<div id="page-content" style="background-color: #fdcec0 !important; height:67.1vh;">
	<div class="container ">
		

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center top-20">
			
			<div class="col-md-4 col-sm-3 col-xs-12"></div>
				<div id="login-form" class="content-wrap col-md-4 col-sm-6 col-xs-12 center-block">
				<div class="text-center">
				<div class="heading-section top-20" >
						<h2 style="color: #f5511e;"><?php echo lang('text_login'); ?></h2>
						<span class="under-heading"></span>
					</div>
				</div>
					<?php if ($this->alert->get('', 'alert')) { ?>
						<div id="notification">
							<?php echo $this->alert->display('', 'alert'); ?>
						</div>
					<?php } ?>
					<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" role="form">
						<fieldset>
							<div class="form-group">
								<div class="input-group">
									<input type="text" name="email" id="login-email" class="form-control input-md" placeholder="<?php echo lang('label_email'); ?>" autofocus="" />
	         		 				<span class="input-group-addon" style="color: #f5511e !important;">@</span>
								</div>
								<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="form-group">
								<div class="input-group">
									<input type="password" name="password" id="login-password" class="form-control input-md" placeholder="<?php echo lang('label_password'); ?>" />
         		 					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								</div>
								<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary btn-md btn-block"><?php echo lang('button_login'); ?></button>
									</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 wrap-none">
                                        <a  href="<?php echo $reset_url; ?>"><b style="color: #f5511e;"><?php echo lang('text_forgot'); ?></b></a>
                                    </div>
                                    <div class="col-md-6">
                                        <a   href="<?php echo $register_url; ?>"><b style="color: #f5511e;"><?php echo lang('button_register'); ?></b></a>
                                    </div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			<div class="col-md-4 col-sm-3 col-xs-12"></div>
 			</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>