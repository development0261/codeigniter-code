<div class="col-md-12 padd-none">
    <?php if ($local_gallery) { ?>
        <h5><b><?php echo $local_gallery['title']; ?></b></h5>
        <p><?php echo $local_gallery['description']; ?></p><br />
        <?php if (!empty($local_gallery['images'])) { ?>
            <ul class="gallery" style="">
	            <?php foreach ($local_gallery['images'] as $image) { ?>
	                <li>
		                <img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['alt_text']; ?>" class="img-border gal-img" >
	                </li>
	            <?php } ?>
            </ul>
        <?php } ?>
    <?php } else { ?>
        <p><?php echo lang('text_gallery'); ?></p>
    <?php } ?>
</div>
<script type="text/javascript"><!--
	$(document).ready(function(){
		$('#local-gallery ul.gallery').bsPhotoGallery({
			"classes" : "col-lg-2 col-md-2 col-sm-3 col-xs-6 padd-none",
			"hasModal" : true
		});
	});
//--></script>