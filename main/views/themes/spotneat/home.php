<?php echo get_header();  ?>
      <div class="fh5co-hero">
            <?php echo get_partial('content_top'); ?>
      </div>
        
      <div id="fh5co-tours" class="fh5co-section-gray">
          <div class="container">
              <div class="row">
                  <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 text-center heading-section animate-box">
                        <h2><?php echo lang('top_hotels_&_restaurants_maybe_you_will_like'); ?></h2>
                        <p><?php echo lang("here_some_hotel_reputation_that_maybe_youll_like"); ?></p>
                  </div>
              </div>
          </div>
          <?php if($locations){?>
           <div class="col-md-12 ">
              <div class="carousel slide" data-ride="carousel" data-type="multi" id="myCarousel">
                  <div class="carousel-inner">

                            <?php 
                            $i = 1;
                            
                            foreach($locations as $location){
                              if($i==1)
                              {
                                  $item_class = "active";
                              }
                              else
                              { 
                                  $item_class = "";
                              }?>
                               <div class="<?php if(count($locations)>4){?> item <?php } echo $item_class;?>">
                                <div class="col-md-3 col-sm-6 col-xs-12"><a class="img-wrap" href="<?php echo base_url().'local/'.$location['permalink'].'?action=select_time&menu_page=true'; ?>" ><img src="<?php echo base_url().'assets/images/'.$location['location_image']; ?>" class="img-responsive slide-img"></a>
                                          <span class="ratings">
                                          <?php
                                          $starNumber =$location['location_ratings'];
                                          for($x=1;$x<=$starNumber;$x++) {
                                              echo '<span class="icon-star"></span>';
                                          }
                                          if (strpos($starNumber,'.')) {
                                              echo '<span class="fa fa-star-half-o"></span>';
                                           $x++;   
                                          }
                                          while ($x<=5) {
                                              echo '<span class="fa fa-star-o"></span>';
                                              $x++;
                                          }
                                          ?>               
                                          <span class="ratings1"><?php echo $location['location_ratings'];?> <?php echo lang('ratings'); ?></span>
                                          <span class="hotel_name"><a class="img-wrap" href="<?php echo base_url().'local/'.$location['permalink'].'?action=select_time&menu_page=true'; ?>" ><?php echo lang_trans($location['location_name'],$location['location_name_ar'] ); ?></a></span>
                                         <!--  <span class="price"><?php// echo lang('starting_from'); ?><?php echo $this->currency->format($location['first_table_price']); ?></span> -->
                                         
                                </div>
                              </div>
                              <?php $i++; } ?>
                  </div>
                  <?php if(count($locations)>4){?>
                  <a style="color: #ffffff !important;" class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                  <a style="color: #ffffff !important;" class="right carousel-control" href="#myCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                </ol>
                  <?php } ?>
              </div>
            </div>
            <?php } ?>

        </div>
        <div class="clearfix"></div>
        <div id="fh5co-features">
            <div class="container" >
                <?php echo get_partial('content_bottom'); ?>
            </div>
        </div>
        <div class="clearfix"></div>
        
        <div id="fh5co-destination">
          <div class="container">      
            <div class="col-sm-12 ">
                <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <img src="<?php echo image_url("data/mobile.png");  ?>" class="img-responsive">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 rt_cont destination-menu__right">
                  <h3 class="unique"><?php echo lang('now_unique_hotels_&_restaurants_in_your_pockets');  ?></h3>
                  <p class=" mar-top40"><?php echo lang('order_from_your_favourite_hotel_&_restaurants_&_track_on_the_go_with_all_new_spotneat_app'); ?></p>
                  <div class="app-icon">
                    <a href="#" class="rt_link" ><img src="<?php echo image_url("data/app_store.jpg");  ?>" class="mar-bot40 mar-right40"></a>
                    <a href="#" class="rt_link" ><img src="<?php echo image_url("data/play_store.png");  ?>" class="mar-bot40"></a>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
<?php echo get_footer();  ?>