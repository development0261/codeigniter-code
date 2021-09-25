<?php if ($display_slides) { ?>
<div id="slider">
	<div class="flexslider">
		<ul class="slides">
			<?php if ($display_slides) { ?>
<?php if (!empty($slides)) { ?>
				<?php foreach ($slides as $slide) { ?>
					<?php if (isset($slide['image_src'])) { ?>
      <li class="fh5co-cover" data-stellar-background-ratio="0.5" style="background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)) 0px 73.5px / cover, url(<?php echo $slide['image_src']; ?>) no-repeat; background-size: cover !important;">
     
                

            </li>
             <?php } ?>
				<?php } ?>
				<?php } } ?>
	  	</ul>
	</div>
</div>
<script type="text/javascript"><!--
	$('.flexslider').flexslider({
		prevText: '',
		nextText: ''
	});
//--></script>
<?php } ?>