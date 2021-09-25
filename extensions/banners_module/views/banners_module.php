
        <div class="container top-60">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 text-center heading-section animate-box fadeInUp animated">
                            <h2><?php echo lang('offers&promotions'); ?></h2>                           
                </div>
            </div>
            <div class="row">
             <?php if ($banners) foreach ($banners as $banner) { ?>              
              <!-- Place somewhere in the <body> of your page -->
                <div class="flexslider carousel padd-none">
                  <ul class="slides">
                      <?php foreach ($banner['images'] as $image) { ?>
                        <li>
                              <!-- <a href="<?php echo $banner['click_url']; ?>"> -->
                                  <img alt="<?php echo $banner['alt_text']; ?>" src="<?php echo $image['url']; ?>" style="height: 300px;width: 100%;" />
                              <!-- </a> -->
                        </li>
                        <?php } ?>
                    
                  </ul>
                </div>
               <?php } ?>
            </div>
        </div>

<script type="text/javascript">
    

$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    animationLoop: true,
    itemWidth: 580,
    itemMargin: 5,
    minItems: 1,
    maxItems: 2
  });
});
</script>