
    <?php if ($reviews) { ?>
        <?php foreach ($reviews as $review) { ?>
        <div class="col-sm-12 col-md-12 col-xs-12 review_block">
            <div class="">
            <div class="col-sm-12 col-md-9 col-xs-12">
                <div class="review_title"><?php echo $review['author']; ?></div>
                <p class="review_content"><?php echo $review['text']; ?></p>
            </div>
            
            <div class="col-sm-12 col-md-3 col-xs-12">
               
                <!--<b>Quality:</b><div class="rating rating-star" data-score="<?php //echo $review['quality']; ?>" data-readonly="true"></div>
                <b>Delivery:</b><div class="rating rating-star" data-score="<?php //echo $review['delivery']; ?>" data-readonly="true"></div>
                <b>Service:</b><div class="rating rating-star" data-score="<?php //echo $review['service']; ?>" data-readonly="true"></div>-->

                <?php 
                $qlty = $review['quality']; 
                $service = $review['service']; 

                $fastar = ($qlty + $service)/2;
                echo '<span class="ratings" title="'.$fastar.'">';    
                for($x=1;$x<=$fastar;$x++) {
                    echo '<span class="icon-star"></span>';
                }
                if (strpos($fastar,'.')) {
                    echo '<span class="fa fa-star-half-o"></span>';
                 $x++;   
                }
                while ($x<=5) {
                    echo '<span class="fa fa-star-o"></span>';
                    $x++;
                }
                
                ?>

                  
                    <br>
                        <span class="comment_date"><?php echo $review['date']; ?></span>
                </span>
             </div>
             </div>
        </div>
        <?php } ?>
    <?php } else { ?>
        <p><?php echo lang('text_no_review'); ?></p>
    <?php } ?>
    

<div class="col-sm-6 col-xs-12 col-md-6">
    <div class="pagination-bar text-right clearfix">
        <div class="links"><?php echo $pagination['links']; ?></div>
        <div class="info"><?php echo $pagination['info']; ?></div>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    var ratings = <?php echo json_encode(array_values($ratings)); ?>;
    displayRatings(ratings);
});
//--></script>