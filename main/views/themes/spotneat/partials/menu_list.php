<?php if ($categories) {?>
	
	<div id="Container" class="col-sm-12 col-md-8 padd-none">
		<?php $category_count = 1; ?>
		<?php foreach ($categories as $category_id => $category) { ?>
			
				
					<?php if($category['is_child'] == 0) { 
						$cat_id = $category['category_id'];
						$cat = $this->Menus_model->getChild($category['category_id']);
						$cate_id = $cat['category_id'];
						// echo $cate_id;
						?>
						<?php $category_name = strtolower(str_replace(' ', '-', str_replace('&', '_', $category['name']))); ?>
			<div class="menu-container mix <?php echo $category_name; ?>  col-sm-12 col-md-12 padd-none">
				<a class="menu-toggle visible-xs visible-sm collapsed  tablinks left_menu" href="#<?php echo $category_name; ?>" role="button" data-toggle="collapse" data-parent=".menu-list" aria-expanded="<?php echo ($category_count === 1) ? 'true' : 'false'; ?>" aria-controls="<?php echo $category_name; ?>">
					<?php echo lang_trans($category['name'],$category['name_ar']); ?>
					<i class="fa fa-angle-down fa-2x fa-pull-right text-muted"></i>
					<i class="fa fa-angle-up fa-2x fa-pull-right text-muted"></i>
				</a>
						<div id="<?php echo $category_name; ?>" class="navbar-collapse collapse <?php echo ($category_count === 1) ? 'in' : ''; ?> wrap-none">
						<div class="menu-category">

							<span class="about-heading hidden-xs hidden-sm padd-none"><?php echo lang_trans($category['name'],$category['name_ar']); ?></span>
							<?php /*<p><?php echo $category['description']; ?></p>
							<?php if (!empty($category['image'])) { ?>
								<img class="img-responsive" src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>"/>
							<?php }?>*/ ?>
						</div>
						<div class="menu-items">
						<?php if (isset($menus[$category_id]) AND !empty($menus[$category_id])) { 
							?>
							<?php foreach ($menus[$category_id] as $menu) { 
								// print_r($menu);

								?>
								
								<div class="food col-sm-12 padd-none">
								  	<div class="col-sm-2 col-md-3 hidden-xs padd-none">
								  	<?php if ($show_menu_images === '1' AND !empty($menu['menu_photo'])) { ?>
											
												<img class="img-responsive items-img" alt="<?php echo $menu['menu_name']; ?>" src="<?php echo $menu['menu_photo']; ?>"  width="55" height="45" style="max-height: 45px;">
											
										<?php } ?>	
								  		</div>						  		
								  		<div class="col-sm-6 col-md-5 col-xs-10 padd-none">
								  			
									  		<div class="food_name"><?php echo  lang_trans($menu['menu_name'],$menu['menu_name_ar']); ?></div>

									  		<?php// print_r($menu);?>
									  		<div class="food_description"><?php echo  lang_trans($menu['menu_description'],$menu['menu_description_ar']); ?></div>


									  		<div class="food_price">
									  			<?php 
									  			if($menu['menu_price'] != $this->currency->format('0.00')){
									  				echo $menu['menu_price'];
									  			}

									  		 ?> </div>
								  		</div>
								  		<div class="add_cart col-sm-4 col-md-4 col-xs-2 padd-none" >

<!-- 
								  						<?php ?>
											
											<?php $i=1;?>
                                          <a  id="<?php echo $menu['menu_id'];?>" class="sidebar_cart_remove cart-btn remove text-muted small " onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');"><i class="fa fa-plus-circle"></i></a>
                                               
                                               <?php //echo "<pre/>"; print_r( $this->session->userdata('cart_contents'));
                                              		//print_r($menu['rowid']);
                                               ?>
                                       
                                         <a class="sidebar_cart_remove cart-btn remove text-muted small" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');"><i class="fa fa-minus-circle"></i></a>
                                         -->



								  			<span class="menu-button">
												<?php if ($menu['mealtime_status'] === '1' AND empty($menu['is_mealtime'])) { ?>
													<a class="disabled"><button class="cart_button cart-gren"> <?php echo lang('add_to_cart'); ?></button></a>
												<?php } else if (isset($menu_options[$menu['menu_id']])) { ?>
													<a class="add_cart" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');">
														<button class="cart_button cart-gren"><?php echo lang('add_to_cart'); ?></button>
													</a>
												<?php } else { ?>
													<a class="add_cart" onClick="addToCart('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');">
														<button class="cart_button cart-gren"><?php echo lang('add_to_cart'); ?></button>
													</a>
												<?php } ?>
											</span>
											<?php if ($menu['mealtime_status'] === '1' AND empty($menu['is_mealtime'])) { ?>
												<div class="menu-mealtime text-danger"><?php echo sprintf(lang('text_mealtime'), $menu['mealtime_name'], $menu['start_time'], $menu['end_time']); ?></div>
											<?php }?>

											<?php if ($menu['special_status'] === '1' AND $menu['is_special'] === '1') { ?>
												<div class="menu-special"><?php echo $menu['end_days']; ?></div>
											<?php }?>
								  		</div>
								</div>

								<div id="menu<?php echo $menu['menu_id']; ?>" class="menu-item">
									<div class="menu-item-wrapper row">
										

										<div class="menu-right col-xs-4 wrap-none">
											
											
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } else { ?>
							<!-- <p><?php echo lang('text_empty'); ?></p> -->
						<?php } ?>

						<div class="gap"></div>
						<div class="gap"></div>
					 </div>
					 
					 </div>
					 </div>
					<?php } ?>
					

					 <?php if($cat['count'] > 0) {
					 $cate = $categories[$cate_id]; ?>
					 <?php $category_name = strtolower(str_replace(' ', '-', str_replace('&', '_', $cate['name']))); ?>
			<div class="menu-container mix <?php echo $category_name; ?>  col-sm-12 col-md-12 padd-none">
				<a class="menu-toggle visible-xs visible-sm collapsed  tablinks left_menu" href="#<?php echo $category_name; ?>" role="button" data-toggle="collapse" data-parent=".menu-list" aria-expanded="<?php echo ($category_count === 1) ? 'true' : 'false'; ?>" aria-controls="<?php echo $category_name; ?>">
					<?php echo lang_trans($cate['name'],$cate['name_ar']); ?>
					<i class="fa fa-angle-down fa-2x fa-pull-right text-muted"></i>
					<i class="fa fa-angle-up fa-2x fa-pull-right text-muted"></i>
				</a>
						<div id="<?php echo $category_name; ?>" class="navbar-collapse collapse <?php echo ($category_count === 1) ? 'in' : ''; ?> wrap-none">
						<div class="menu-category">

							<span class="about-heading hidden-xs hidden-sm padd-none"><?php echo lang_trans($cate['name'],$cate['name_ar']); ?></span>
							<?php /*<p><?php echo $category['description']; ?></p>
							<?php if (!empty($category['image'])) { ?>
								<img class="img-responsive" src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>"/>
							<?php }?>*/ ?>
						</div>
						<div class="menu-items">
						<?php if (isset($menus[$cate_id]) AND !empty($menus[$cate_id])) { 
							?>
							<?php foreach ($menus[$cate_id] as $menu) { 
								// print_r($menu);

								?>
								
								<div class="food col-sm-12 padd-none">
								  	<div class="col-sm-2 hidden-xs padd-none">
								  	<?php if ($show_menu_images === '1' AND !empty($menu['menu_photo'])) { ?>
											
												<img class="img-responsive" alt="<?php echo $menu['menu_name']; ?>" src="<?php echo $menu['menu_photo']; ?>"  width="55" height="45" style="max-height: 45px;">
											
										<?php } ?>	
								  		</div>						  		
								  		<div class="col-sm-6 col-xs-12 padd-none">
								  			
									  		<div class="food_name"><?php echo  lang_trans($menu['menu_name'],$menu['menu_name_ar']); ?></div>

									  		<?php// print_r($menu);?>
									  		<div class="food_description"><?php echo  lang_trans($menu['menu_description'],$menu['menu_description_ar']); ?></div>


									  		<div class="food_price">
									  			<?php 
									  			if($menu['menu_price'] != $this->currency->format('0.00')){
									  				echo $menu['menu_price'];
									  			}

									  		 ?> </div>
								  		</div>
								  		<div class="add_cart col-sm-4 col-xs-12 padd-none" >

<!-- 
								  						<?php ?>
											
											<?php $i=1;?>
                                          <a  id="<?php echo $menu['menu_id'];?>" class="sidebar_cart_remove cart-btn remove text-muted small " onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');"><i class="fa fa-plus-circle"></i></a>
                                               
                                               <?php //echo "<pre/>"; print_r( $this->session->userdata('cart_contents'));
                                              		//print_r($menu['rowid']);
                                               ?>
                                       
                                         <a class="sidebar_cart_remove cart-btn remove text-muted small" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');"><i class="fa fa-minus-circle"></i></a>
                                         -->



								  			<span class="menu-button">
												<?php if ($menu['mealtime_status'] === '1' AND empty($menu['is_mealtime'])) { ?>
													<a class="disabled"><button class="cart_button"> <?php echo lang('add_to_cart'); ?></button></a>
												<?php } else if (isset($menu_options[$menu['menu_id']])) { ?>
													<a class="add_cart" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');">
														<button class="cart_button"><?php echo lang('add_to_cart'); ?></button>
													</a>
												<?php } else { ?>
													<a class="add_cart" onClick="addToCart('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');">
														<button class="cart_button"><?php echo lang('add_to_cart'); ?></button>
													</a>
												<?php } ?>
											</span>
											<?php if ($menu['mealtime_status'] === '1' AND empty($menu['is_mealtime'])) { ?>
												<div class="menu-mealtime text-danger"><?php echo sprintf(lang('text_mealtime'), $menu['mealtime_name'], $menu['start_time'], $menu['end_time']); ?></div>
											<?php }?>

											<?php if ($menu['special_status'] === '1' AND $menu['is_special'] === '1') { ?>
												<div class="menu-special"><?php echo $menu['end_days']; ?></div>
											<?php }?>
								  		</div>
								</div>

								<div id="menu<?php echo $menu['menu_id']; ?>" class="menu-item">
									<div class="menu-item-wrapper row">
										

										<div class="menu-right col-xs-4 wrap-none">
											
											
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } else { ?>
							<!-- <p><?php echo lang('text_empty'); ?></p> -->
						<?php } ?>

						<div class="gap"></div>
						<div class="gap"></div>
					 </div>
					 
					 </div>
					 </div>
					 <?php
					} ?>

				
			
			<?php $category_count++; ?>
		<?php } ?>
	</div>

<?php } else { ?>
	<div  class=" col-sm-8 col-md-8 padd-none">
		<p style="padding: 0px 20px;"><?php echo lang('text_no_category'); ?></p>
	</div>
<?php } ?>

<?php if (!empty($menu_total) AND $menu_total < 150) { ?>
	<div class="pager-list"></div>
<?php } else { ?>
<?php if ($categories) {?>	
	<div class="col-sm-6 col-xs-12 col-md-6">
	<div class="pagination-bar text-right">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div>
	</div>
</div>
<?php } ?>
<?php } ?>

