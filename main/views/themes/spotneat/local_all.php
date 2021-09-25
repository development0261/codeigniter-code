<?php
	// echo '<pre>';
	// print_r($locations_filter);
	// exit;
?>
<?php echo get_header();


 ?>
 <style type="text/css">
 	.form-control{
 		color: #fff !important;
 	}
 </style>
<div class="fh5co-hero-search">		
	<div class="fh5co-cover-search" data-stellar-background-ratio="0.5" style="background-color: #f5511e;">		
		<div class="container">
			<div class="row" style="padding: 30px 0px;color: #fff;">
					<form id="filter-search-form" method="GET" class="form-search form-horizontal" action="<?php echo $locations_filter['search_action']; ?>" onsubmit="return check_validate()">
					<div class="col-sm-5 col-md-5" >
						<label><?php echo lang('keywords');?>:</label>
						<input type="text" class="form-control search-input" name="keyword" id="from-place"  placeholder="<?php echo lang('restaurants');?>" value="<?php //echo $locations_filter['keyword']; ?>"/>
						<label></label>
					</div>
					<div class="col-sm-4 col-md-4">
						<label>
						<?php echo lang('location');?>:</label>
						<input type="text" class="form-control search-input" name="search" id="search"  placeholder=" <?php echo lang('location');?>" value="<?php echo $locations_filter['search']; ?>"/>
						 <span id="ent_loc" class="search_err"><?php echo lang('err_label_search_query'); ?></span>
						 <label></label>
					</div>
					<input type="hidden" class="form-control" name="type" id="type" value="<?php echo $locations_filter['type']; ?>"/>
					<input type="hidden" class="form-control" name="rating" id="rating" value="<?php echo $locations_filter['rating']; ?>"/>
					<input type="hidden" class="form-control" name="sort_by" id="sort_by" value="<?php echo $locations_filter['sort_by']; ?>"/>
					<input type="hidden" class="form-control" name="veg_type" id="veg_type" value="<?php echo $locations_filter['veg_type']; ?>"/>
					<input type="hidden" class="form-control" name="delivery_fee" id="delivery_fee" value="<?php echo $locations_filter['delivery_fee']; ?>"/>

					<input type="hidden" class="form-control" name="offer_collection" id="offer_collection" value="<?php echo $locations_filter['offer_collection']; ?>"/>
					<!-- <input type="hidden" class="form-control" name="sort_by" id="sort_by" value="<?php echo $locations_filter['sort_by']; ?>"/> -->
					<!--<div class="col-sm-3 col-md-3 ">								
						<section>
							<label for="class">
							<?php //echo lang('search_for');?>:</label>
							<select class="cs-select cs-skin-border1">
								<option value="" disabled selected>
							<?php //echo lang('food');?></option>
								<option value="restaturants">
							<?php //echo lang('restaurants');?></option>
								<option value="food">
								<?php //echo lang('cafeteria');?></option>
							</select>
						</section>
					</div>
					<div class="col-sm-3 col-md-3 ">								
						<div class="input-field">
							<label for="from">
								<?php //echo lang('enter_keyword');?></label>
							<input type="text" class="form-control" id="keyword" placeholder="
								<?php //echo lang('home.shawarma');?>"/>
						</div>
					</div>-->
					<div class="col-sm-2 col-md-2 " style="padding-top: 20px;">
						
						<input type="submit" class="btn btn-primary btn-block" value="<?php echo lang('search');?>" style="height: 45px;background-color: #fff !important;color: #0000008a !important;">
					</div>
					</form>
				  
				

			</div>
		</div>
		
	</div>	
</div>
<div id="fh5co-search-results" class="fh5co-section-gray">
	<div class="container">
		<div class="row">
			<?php if ($locations) {?>
			<div class="col-sm-12  col-md-12 col-xs-12">
				
				<h2 class="list-title"><span class="search_count"></span> <?php echo $pagination['info']; ?></h2>
			</div>
			
			<div class="col-sm-8 col-md-8 col-xs-12 brdr-right">
				<?php foreach ($locations as $location) { ?>
				<div class="search_results col-sm-12  col-md-12 col-xs-12">
					<?php if (!empty($location['location_image'])) { ?>
						<div class="col-sm-6 col-md-4 col-xs-12">
							<img src="<?php echo $location['location_image']; ?>" class="search_img">
							<p class="rest-type"><?= ucfirst($location['veg_type']) ?></p>
						</div>
					<?php } ?>
					<div class="col-sm-6  col-md-4 col-xs-12">
						<div class="search_res">
							<!--<div class="search_location">Saudi Arbia</div>-->
							<div class="search_hotel_name"><?php echo lang_trans($location['location_name'],$location['location_name_ar']);?></div>
							<div class="search_hotel_desc"><?php echo lang_trans_addr($location['address'],$location['address_ar']); ?></div>
							<div class="del-details">
								<!-- <div class="detail-info"><b>Distance:</b> <span>1.5km away</span></div> -->
								<div class="detail-info"><b>Delivery Fee:</b> <span><?= $location['delivery_fee'] > 0 ? $currency_symbol.' '.$location['delivery_fee'] : 'Free' ?></span></div>
								<!-- <div class="detail-info"><b>Delivery Time:</b> <span>15 Minutes</span></div> -->
							</div>
							<span class="ratings">
							
							<?php
							if($location['location_ratings'] > 0) {
							$starNumber =$location['location_ratings'];
						    for($x=1;$x<=$starNumber;$x++) {
						        echo '<span class="fa fa-star"></span>';
						    }
						    if (strpos($starNumber,'.')) {
						        echo '<span class="fa fa-star-half"></span>';
						        $x++;
						    }
						    while ($x<=5) {
						        echo '<span class="fa fa-star-o"></span>';
						        $x++;
						    }
						    } else {

							}	
						?>
						<?php if($location['location_ratings'] > 0) {?>
						<span class="ratings1"><?php echo $location['location_ratings'];?> <?php echo lang('ratings'); ?></span>
							</span>
							<?php } else { ?>
								
								<span class="ratings1"><?php echo lang('no_ratings'); ?></span>
							<?php } ?>

			            <!-- <div class="col-sm-12  col-md-3 col-xs-3 padd-none">    
						<span class="star_rate"><a href="#"><span class="fa fa-star"></span> <?php echo $location['location_ratings'];?></a></span>
						</div> -->
						<div class="col-sm-12  col-md-9 col-xs-9 padd-none">    
						<!-- <?php echo lang('book_a_table_from').' <b>'.$this->currency->format($location['first_table_price']).'</b>';?>  -->
						</div>
			            </div>
					</div>
					<div class="col-sm-offset-6 col-md-offset-0 col-sm-6  col-md-4 col-xs-12">
						
						 <input type="submit" class="btn btn-primary btn-block" value="
<?php echo lang('book_a_table');?>" onclick="bookatable(<?php echo $location['location_id'];?>)">
						<input type="submit" class="btn btn-primary btn-block" value="
				<?php echo lang('book_a_food');?>" onclick="bookafood(<?php echo $location['location_id'];?>)">
						<form id="formoid_<?php echo $location['location_id'];?>" action="<?php echo base_url('local')."/".$location['permalink']['slug'];?>"  method="post">
            				<input type="hidden" id="location" name="location" value="<?php echo $location['location_id'];?>" >
						</form>
						<form id="formorderid_<?php echo $location['location_id'];?>" action="<?php echo base_url('local')."/".$location['permalink']['slug']."?action=select_time&menu_page=true";?>"  method="post">
            				<input type="hidden" id="location" name="location" value="<?php echo $location['location_id'];?>" >
						</form>
					</div>
				</div>
				
				<?php } ?> <!-- End Foreach -->
				<div class=" col-sm-12 col-md-12 col-xs-12 text-center">
				<div class="pagination"><?php echo $pagination['links']; ?></div>
				<div class="info"></div>
				</div>
				

			</div>

			<div class="col-sm-4 col-md-4 col-xs-12">
				<div class="col-sm-12 col-md-12 col-xs-12 price_slider">
					
					<div class="col-sm-12 col-md-12 col-xs-12 padd-none">
			        <h1><?php echo lang('type');?></h1>
			        <select class="cs-select cs-skin-border2" onchange="filter_data('type',this.value)">
								<option value="restaurant" <?php if($locations_filter['type'] == 'restaurant') { echo "selected";}?>><?php echo lang('restaurants');?></option>
								<option value="cafe" <?php if($locations_filter['type'] == 'cafe') { echo "selected";}?>><?php echo lang('cafeteria');?></option>
								<option value="both" <?php if($locations_filter['type'] == 'both'||$locations_filter['type'] == '') { echo "selected";}?>><?php echo lang('both');?></option>
					</select>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12 padd-none">
					<h1><?php echo lang('star_rating');?></h1>
						
						<div class="star-rating-check">
						      <a <?php if($locations_filter['rating'] == 1 && $locations_filter['rating'] != ''){ echo 'class=""'; }?> onclick="filter_data('rating','1')">
						      		<input type="checkbox" id="1star" value="1" <?php if($locations_filter['rating'] == 1 && $locations_filter['rating'] != ''){ echo 'checked'; }?>>
						      		<label for="1star"><span class="fa fa-star"></span> 1</label>
						      </a>
					    </div>
					    <div class="star-rating-check">
						      <a <?php if($locations_filter['rating'] == 2 && $locations_filter['rating'] != ''){ echo 'class=""'; }?>  onclick="filter_data('rating','2')">
						      	<input type="checkbox" id="2star" value="2" <?php if($locations_filter['rating'] == 2 && $locations_filter['rating'] != ''){ echo 'checked'; }?>>
						      	<label for="2star"><span class="fa fa-star"></span> 2</label>
						  	  </a>
					    </div>
					    <div class="star-rating-check">
						    <a <?php if($locations_filter['rating'] == 3 && $locations_filter['rating'] != ''){ echo 'class=""'; }?> onclick="filter_data('rating','3')">
						      	<input type="checkbox" id="3star" value="3" <?php if($locations_filter['rating'] == 3 && $locations_filter['rating'] != ''){ echo 'checked'; }?>>
						      <label for="3star"><span class="fa fa-star"></span> 3</label>
					  		</a>
					    </div>
					    <div class="star-rating-check">
					      	<a <?php if($locations_filter['rating'] == 4 && $locations_filter['rating'] != ''){ echo 'class=""'; }?>  onclick="filter_data('rating','4')">
						      	<input type="checkbox" id="4andabove" value="4" <?php if($locations_filter['rating'] == 4 && $locations_filter['rating'] != ''){ echo 'checked'; }?>>
						      	<label for="4andabove"><span class="fa fa-star"></span> 4 & <?php echo lang('above'); ?></label>
						    </a>
					    </div>

					<!-- <div class="star_ratings">
							
			                <span class="star_rate"><a <?php if($locations_filter['rating'] == 1 && $locations_filter['rating'] != ''){ echo 'class="star_rate_bg"'; }?> onclick="filter_data('rating','1')"><span class="fa fa-star"></span> 1</a></span>
			                <span class="star_rate"><a <?php if($locations_filter['rating'] == 2 && $locations_filter['rating'] != ''){ echo 'class="star_rate_bg"'; }?>  onclick="filter_data('rating','2')"><span class="fa fa-star"></span> 2</a></span>
			                <span class="star_rate"><a <?php if($locations_filter['rating'] == 3 && $locations_filter['rating'] != ''){ echo 'class="star_rate_bg"'; }?> onclick="filter_data('rating','3')"><span class="fa fa-star"></span> 3</a></span>
			                <span class="star_rate"><a <?php if($locations_filter['rating'] == 4 && $locations_filter['rating'] != ''){ echo 'class="star_rate_bg"'; }?>  onclick="filter_data('rating','4')"><span class="fa fa-star"></span> 4 & <?php echo lang('above'); ?></a></span>
			                <span class="star_rate"><a href="#"><span class="fa fa-star"></span> 5</a></span>
			        </div> -->
			    	</div>
			    	<div class="col-sm-12 col-md-12 col-xs-12 padd-none">
				    	<div class="extra-filter">
				    		<!-- <button type="button" class="open-now-btn">Open Now</button> -->
							<ul>
								<a <?php if($locations_filter['veg_type'] == 'veg' && $locations_filter['veg_type'] != ''){ echo 'class="link-select"'; }?> ><li onclick="filter_data('veg_type','veg')" ><i class="fa fa-hand-point-right"></i> Vegitarian</li></a>
								<a <?php if($locations_filter['delivery_fee'] == 'free' && $locations_filter['delivery_fee'] != ''){ echo 'class="link-select"'; }?> ><li onclick="filter_data('delivery_fee','free')"><i class="fa fa-hand-point-right"></i> Free delivery</li></a>

								<a <?php if($locations_filter['offer_collection'] == 'pickup' && $locations_filter['offer_collection'] != ''){ echo 'class="link-select"'; }?> ><li onclick="filter_data('offer_collection','pickup')"><i class="fa fa-hand-point-right"></i> Offer Pickup</li></a>
							</ul>
				    	</div>
				    </div>
			    	<div class="col-sm-12 col-md-12 col-xs-12 padd-none">
			        <h1><?php echo lang('sort_by');?></h1>

			        <select class="cs-select cs-skin-border2" onchange="filter_data('sort_by',this.value)">
						<option value="low_high" <?php if($locations_filter['sort_by'] == 'low_high') { echo "selected";}?>>
							<?php echo lang('price:low_to_high');?></option>
						<option value="high_low" <?php if($locations_filter['sort_by'] == 'high_low') { echo "selected";}?>>
							<?php echo lang('price:high_to_low');?></option>
						<option value="newest" <?php if($locations_filter['sort_by'] == 'newest') { echo "selected";}?>>
							<?php echo lang('newest');?></option>
					</select>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12 padd-none">
						<a href="<?php echo site_url().'locations?keyword=&search='.$locations_filter['search'].'&type=';?>"><button class="btn btn-primary btn-block" ><?php echo lang('reset');?></button></a>
					</div>
				</div>
			</div>
			
		<?php } else { ?> <!-- End IF Condition -->
			<div class="col-sm-4 col-md-2 ">
				<a href="<?php echo site_url().'locations?keyword=&search='.$locations_filter['search'].'&type=';?>"><button class="btn btn-primary btn-block" ><?php echo lang('reset');?></button></a>
			</div>
		<?php } ?>	
		</div>
	</div>
</div>	
<script>
function check_validate()
{
	var search_query = $('input[name=\'search\']').val();
	/*if(search_query == '')
	{
		document.getElementById("ent_loc").style.display = 'block';;
		return false;	
	}*/
}
</script>

    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      

      function initAutocomplete() 
      {

      	var placeSearch, autocomplete;
      	var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      	};
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('search')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }	
	function bookatable(id)
	{
		$("#formoid_"+id).submit();
	}
	function bookafood(id)
	{
		$("#formorderid_"+id).submit();
	}
	function filter_data(name,value)
	{

		$("#"+name).val(value);
		$("#filter-search-form").submit();
	}
</script>	
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo $this->config->item('maps_api_key')?>&libraries=places&callback=initAutocomplete" async defer></script>
<?php echo get_footer(); ?>	