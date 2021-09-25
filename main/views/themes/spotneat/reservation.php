<?php echo get_header(); 

     ?>
    
     	

<div id="fh5co-search-results" class="fh5co-section-gray">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-xs-12 ">	

				<img class="list-img" src="<?php echo image_url("data/banner_old.jpg"); ?>" >

			</div>
			<div class="col-sm-12 col-md-12 col-xs-12">
			<div class="col-sm-8 col-md-8 col-xs-12 padd-none">
				<div class="brdr-full-right">
					<div class="row">
						<div class="col-sm-7 col-md-7 col-xs-12">
							<span class="padd-left return"><a href="#"><?php echo lang('return');?></a></span>
							<h1 class="list-title padd-left"><?php echo $location_name;?></h1> 
							<div class="location padd-left col-sm-12 col-md-12 col-xs-12">
								<div class="col-sm-1 col-md-1 col-xs-1">
									<i class="fa fa-map-marker" style="color:#ff8c00"></i>
								</div>
								<div class="col-sm-11 col-md-11 col-xs-10">
									<span class="full_location">
										<b>Address: </b>	<br />
										<?php echo $location_address_1;?>,
										<?php echo $location_city;?>,<br />
										<?php echo $location_state;?>,<br />
										<?php echo $location_postcode;?>,<br />
										<?php echo $location_country;?><br />
										
									</span>
								</div>
								<div class="col-sm-1 col-md-1 col-xs-1">
									<i class="fa fa-phone" style="color:#ff8c00"></i>
								</div>
								<div class="col-sm-11 col-md-11 col-xs-10">
									<span class="full_location">
									<b>Contact: </b> 
										<?php echo $location_telephone;?>
									</span>
								</div>
								<div class="col-sm-1 col-md-1 col-xs-1">
									<i class="fa fa-envelope" style="color:#ff8c00"></i>
								</div>
								<div class="col-sm-11 col-md-11 col-xs-10">
									<span class="full_location">
										<b>E-mail: </b> 									
										<a href="#"><?php echo $location_email;?></a>
									</span>
								</div>
							</div>
						</div>
						<div class="col-sm-5 col-md-5 col-xs-12 ">
							<div class="col-sm-12 col-md-12 col-xs-12 ">
								<div class="col-sm-8 col-md-8 col-xs-8 padd-none">
<!-- 								<p class="book"><?php echo lang('book_a_table_from'); ?> <?php echo currency_format($first_table_price);?></p>
 -->								</div>
								<div class="col-sm-4 col-md-4 col-xs-4 padd-none">
								<span class="ratings1">
								<span class="star_rate">
									<a href="#"><span class="fa fa-star"></span> 4.0</a></span>
								</span>
								</div>
					        </div>
					        <div class="col-sm-12 col-md-12 col-xs-12">
					            <div class="map">
					            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d233328.2106301447!2d45.0105926060563!3d23.876941037343624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi+Arabia!5e0!3m2!1sen!2sin!4v1538024819742" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
					            </div>
							</div>
						</div>
					</div>
				<div class="row">
				<div class="border-bot">
					<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-sm-12 col-md-12 col-xs-12">
					<h1 class="about-heading">About</h1>
						<p class="about-content"><?php echo $description;?></p>
						<!--<a href="#" class="about-more">More...</a>-->
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12">
					<?php foreach ($gallery as $key => $img)
							{
							?>
						<div class="col-sm-2 col-md-2 col-xs-2 padd-none"><img src="<?php echo image_url($img['path']);  ?>" class="img-border" ></div>
						<?php } ?>
						
					</div>
					</div>			
				</div>
				</div>

				<div class="row ">
				<div class="border-bot"></div>
				<div class="user_reviews ">
					<div class="row">
						<div class="review col-sm-12 col-md-12 col-xs-12">



							<div class="col-sm-12 col-md-12 col-xs-12">
							<h1 class="list-title padd-left"><?php echo lang('user_reviews'); ?></h1>
							<div class="col-sm-12 col-md-12 col-xs-12">
								<div class="col-sm-12 col-md-12 col-xs-12">
									<textarea rows="5"  class="comment-text" placeholder="Share Your Thoughts and Comments..."> </textarea>
								</div>
								<div class="col-sm-12 col-md-12 col-xs-12 padd-none">
										<div class="col-sm-8 col-md-10 col-xs-7">
												<span class="ratings text-right">
									                <span class="fa fa-star-o"></span>
									                <span class="fa fa-star-o"></span>
									                <span class="fa fa-star-o"></span>
									                <span class="fa fa-star-o"></span>
									                <span class="fa fa-star-o"></span>
									                
									        	</span>
									    </div>
									    <div class="col-sm-4 col-md-2 col-xs-5">
											<button type="submit" class="btn btn-primary text-right">Submit</button>
										</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-xs-12 padd-none">
								<div class="menu_brdr1">
								
								   <!-- Tab panes -->
									<div class="tab-content">
										 <div role="tabpanel" class="tab-pane active" id="positive" >
											<div class="row" >
												<div class="col-sm-12 col-md-12 col-xs-12 padd-none review_block">
													<div class="">
														<div class="col-sm-9 col-md-9 col-xs-12 review_block">
														<div class="review_title">Abdullah  Mohammad - Dubai</div>
														<p class="review_content">Recognizable location large rooms ok breakfast"(If you enjoy saudi arabia food.)"</p>
													</div>
													<div class="col-sm-3 col-md-3 col-xs-12">
														<span class="ratings">
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <br>
											            		<span class="comment_date">11 October 2018</span>
											        	</span>
											         </div>

													</div>
													

												</div>
												<div class="col-sm-12 col-md-12 col-xs-12 padd-none review_block">
													<div class="">
														<div class="col-sm-9 col-md-9 col-xs-12 review_block">
														<div class="review_title">Abdullah  Mohammad - Dubai</div>
														<p class="review_content">Recognizable location large rooms ok breakfast"(If you enjoy saudi arabia food.)"</p>
													</div>
													<div class="col-sm-3 col-md-3 col-xs-12">
														<span class="ratings">
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <br>
											            		<span class="comment_date">13 October 2018</span>
											        	</span>
											         </div>

													</div>
													

												</div>
												<div class="col-sm-12 col-md-12 col-xs-12 padd-none review_block">
													<div class="">
														<div class="col-sm-9 col-md-9 col-xs-12 review_block">
														<div class="review_title">Abdullah  Mohammad - Dubai</div>
														<p class="review_content">Recognizable location large rooms ok breakfast"(If you enjoy saudi arabia food.)"</p>
													</div>
													<div class="col-sm-3 col-md-3 col-xs-12">
														<span class="ratings">
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <span class="fa fa-star"></span>
											                <br>
											            		<span class="comment_date">15 October 2018</span>
											        	</span>
											         </div>

													</div>
													

												</div>
												<div class="col-sm-12 col-md-12 col-xs-12 padd-none text_center">
													<a href="#" class="view_more">View more (453)</a>
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
			<div class="col-sm-4 col-md-4 col-xs-12 padd-none">
			<div>
				<?php echo get_partial('content_top'); ?>

			</div>



				<div class="sidebar_right">
					<div class="sidebar_content_detail" >
						<div class="col-sm-12 col-xs-12 col-md-12 padd-none">
							<!--<div class="sidebar_cart_good">Good to Know</div>-->
							<div class="sidebar_check_cont">Open Hours</div>
							<p class="sidebar_cart_content">15:00-18:00 Hours</p>
							<hr>
							<div class="sidebar_check_cont">Cancellation Prepayment</div>
							<p class="sidebar_cart_content">Cancellation and prepayment policies may vary according to room type, Please check the <a href="#">Table booking conditions</a> when selecting your room above.</p>
							<hr>
							<div class="sidebar_check_cont">Card Accepted at this restaurants</div>
							<p class="sidebar_cart_content"><img src="<?php echo image_url("data/card.png"); ?>"></p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>	
</div>

<div id="page-content" style="margin-bottom:0;display:<?php echo ($find_table_action === 'view_summary') ? 'block' : 'none'; ?>">
	<div class="container top-spacing-10">
		<div class="row">
			<?php echo get_partial('content_left'); ?>
			<?php
				if (partial_exists('content_left') AND partial_exists('content_right')) {
					$class = "col-sm-6 col-md-6";
				} else if (partial_exists('content_left') OR partial_exists('content_right')) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="<?php echo $class; ?>">
				<div class="content-wrap">
					<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="reservation-form" role="form">
	                    <p><?php echo $text_login_register; ?></p>

	                    <div class="row">
	                        <div class="col-xs-12 col-sm-6 col-md-6">
	                            <div class="form-group">
	                                <input type="text" name="first_name" id="first-name" class="form-control" placeholder="<?php echo lang('label_first_name'); ?>" value="<?php echo set_value('first_name', $first_name); ?>" />
	                                <?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
	                            </div>
	                        </div>

	                        <div class="col-xs-12 col-sm-6 col-md-6">
	                            <div class="form-group">
	                                <input type="text" name="last_name" id="last-name" class="form-control" placeholder="<?php echo lang('label_last_name'); ?>" value="<?php echo set_value('last_name', $last_name); ?>" />
	                                <?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="row">
	                        <div class="col-xs-12 col-sm-6 col-md-6">
	                            <div class="form-group">
	                                <input type="text" name="email" id="email" class="form-control" placeholder="<?php echo lang('label_email'); ?>" value="<?php echo set_value('email', $email); ?>" />
	                                <?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
	                            </div>
	                        </div>

	                        <div class="col-xs-12 col-sm-6 col-md-6">
	                            <div class="form-group">
	                                <input type="text" name="confirm_email" id="confirm-email" class="form-control" placeholder="<?php echo lang('label_confirm_email'); ?>" value="<?php echo set_value('confirm_email', $email); ?>" />
	                                <?php echo form_error('confirm_email', '<span class="text-danger">', '</span>'); ?>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <input type="text" name="telephone" id="telephone" class="form-control" placeholder="<?php echo lang('label_telephone'); ?>" value="<?php echo set_value('telephone', $telephone); ?>" />
	                        <?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
	                    </div>

	                    <div class="form-group">
	                        <textarea name="comment" id="comment" class="form-control" rows="2" placeholder="<?php echo lang('label_comment'); ?>"><?php echo set_value('comment', $comment); ?></textarea>
	                        <?php echo form_error('comment', '<span class="text-danger">', '</span>'); ?>
	                    </div>

	                    <div class="form-group">
	                        <div class="input-group">
	                            <span><?php echo $captcha['image']; ?></span>
	                            <input type="hidden" name="captcha_word" class="form-control" value="<?php echo $captcha['word']; ?>" />
	                            <input type="text" name="captcha" class="form-control" placeholder="<?php echo lang('label_captcha'); ?>" />
	                        </div>
	                        <?php echo form_error('captcha', '<span class="text-danger">', '</span>'); ?>
	                    </div>

	                    <?php if ($find_table_action === 'view_summary') { ?>
	                        <div class="row">
	                            <div class="col-sm-4">
	                                <button type="submit" class="btn btn-primary btn-block btn-lg"><?php echo lang('button_reservation'); ?></button>
	                            </div>
	                            <div class="col-sm-2">
	                                <a class="text-muted" href="<?php echo $reset_url; ?>"><b><?php echo lang('button_find_again'); ?></b></a>
	                            </div>
	                        </div>
	                    <?php } ?>
	                </form>
				</div>
			</div>
			<?php //echo get_partial('content_right'); ?>
			<?php //echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>