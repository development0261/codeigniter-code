<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>

<div id="page-content" style="background-color: #fdcec0 !important;">
	<div class="container ">
		<div class="col-md-12 col-sm-12 col-xs-12 content_bacg after-log-top-space" >
		<div class="row top-spacing">
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

<div class="<?php echo $class; ?> " style="padding-left: <?php echo ($class != "col-md-12") ? '3%' : ''; ?>">
				<div class="row list-group-item">
					<form method="POST" accept-charset="utf-8" action="<?php echo $_action; ?>" role="form">
						<?php if ($address) {
							// print_r( $address);
							// exit;
							?>
							<div class="col-md-12">
								<div class="form-group">
									<label for=""><?php echo lang('label_address_1'); ?></label>
									<input type="text" name="address[address_1]" class="form-control"  id="address_1" value="<?php echo set_value('address[address_1]', $address['address_1']); ?>" />
									<?php echo form_error('address[address_1]', '<span class="text-danger">', '</span>'); ?>
								</div>

								<div class="form-group">
									<label for=""><?php echo lang('label_address_2'); ?></label>
									<input type="text" name="address[address_2]" class="form-control" value="<?php echo set_value('address[address_2]', $address['address_2']); ?>" />
									<?php echo form_error('address[address_2]', '<span class="text-danger">', '</span>'); ?>
								</div>

								<div class="row">
									<div class="col-xs-12 col-sm-8 col-md-8">
										<div class="form-group">
                                            <label for=""><?php echo lang('label_state') . ' / ' . lang('label_city'); ?></label>
                                            <input type="text" class="form-control" value="<?php echo set_value('address[city]', $address['city']) ?>" name="address[city]" id="city" placeholder="<?php echo lang('label_city')?>" >
											<?php echo form_error('address[city]', '<span class="text-danger">', '</span>'); ?>
											
											<input type="hidden" class="form-control" value="<?php echo set_value('address[clatitude]'); ?>" name="address[clatitude]" id="latitude" >
											<input type="hidden" class="form-control" value="<?php echo set_value('address[clongitude]'); ?>" name="address[clongitude]" id="longitude" >
											<input type="hidden" class="form-control" id="state" value="<?php echo set_value('address[state]'); ?>" name="address[state]" placeholder="<?php echo lang('label_state'); ?>">
											<?php echo form_error('address[state]', '<span class="text-danger">', '</span>'); ?>

										</div>
									</div>
									<!--<div class="col-xs-12 col-sm-4 col-md-4">
										<div class="form-group">
                                            <label for=""><?php echo lang('label_state'); ?></label>
                                            <input type="text" class="form-control" value="<?php echo set_value('address[state]', $address['state']); ?>" name="address[state]" placeholder="<?php echo lang('label_state'); ?>">
											<?php echo form_error('address[state]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>-->
									<div class="col-xs-12 col-sm-4 col-md-4">
										<div class="form-group">
                                            <label for=""><?php echo lang('label_postcode'); ?></label>
											<input type="text" class="form-control" id="postcode" name="address[postcode]" value="<?php echo set_value('address[postcode]', $address['postcode']); ?>" placeholder="<?php echo lang('label_postcode'); ?>">
											<?php echo form_error('address[postcode]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for=""><?php echo lang('label_country'); ?></label>
									<!-- <select name="address[country]" class="form-control">
									<?php foreach ($countries as $country) {?>
                                        <?php if ($country['country_id'] === $address['country_id']) {?>
                                            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                        <?php } else {?>
                                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php }?>
									<?php }?>
									</select> -->
									<input type="text" class="form-control" name="address[country]" id="country" value="<?php echo set_value('address[country]', $address['country_id']); ?>" placeholder="<?php echo lang('label_country'); ?>">
									<?php echo form_error('address[country]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>

						<?php } else {?>

							<div id="new-address" class="col-md-12">
								<div class="form-group">
									<label for=""><?php echo lang('label_address_1'); ?></label>
									<input type="text" name="address[address_1]"  id="address_1" class="form-control" value="<?php echo set_value('address[address_1]'); ?>" />
									<?php echo form_error('address[address_1]', '<span class="text-danger">', '</span>'); ?>
								</div>

								<div class="form-group">
									<label for=""><?php echo lang('label_address_2'); ?></label>
									<input type="text" name="address[address_2]" class="form-control" value="<?php echo set_value('address[address_2]'); ?>" />
									<?php echo form_error('address[address_2]', '<span class="text-danger">', '</span>'); ?>
								</div>

								<div class="row">
									<div class="col-xs-12 col-sm-8 col-md-8">
										<div class="form-group">
											<input type="text" autocomplete="new-password" class="form-control" value="<?php echo set_value('address[city]'); ?>" name="address[city]" id="city" placeholder="<?php echo lang('label_state') . ' / ' . lang('label_city'); ?>" >
											<?php echo form_error('address[city]', '<span class="text-danger">', '</span>'); ?>
											
											<input type="hidden" class="form-control" value="<?php echo set_value('address[clatitude]'); ?>" name="address[clatitude]" id="latitude" >
											<input type="hidden" class="form-control" value="<?php echo set_value('address[clongitude]'); ?>" name="address[clongitude]" id="longitude" >
											<input type="hidden" class="form-control" id="state" value="<?php echo set_value('address[state]'); ?>" name="address[state]" placeholder="<?php echo lang('label_state'); ?>">
											<?php echo form_error('address[state]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<!--<div class="col-xs-12 col-sm-4 col-md-4">
										<div class="form-group">

										</div>
									</div>-->
									<div class="col-xs-12 col-sm-4 col-md-4">
										<div class="form-group">
											<input type="text" class="form-control" name="address[postcode]" id="postcode" value="<?php echo set_value('address[postcode]'); ?>" placeholder="<?php echo lang('label_postcode'); ?>">
											<?php echo form_error('address[postcode]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>
								<div class="form-group country-bg-none">
									<label for=""><?php echo lang('label_country'); ?></label>
									<!-- <select name="address[country]" class="form-control">
									<?php foreach ($countries as $country) {?>
                                        <?php if ($country['country_id'] === $address['country_id']) {?>
                                            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                        <?php } else {?>
                                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php }?>
									<?php }?>
									</select> -->
									<input type="text" class="form-control" name="address[country]" id="country" value="<?php echo set_value('address[country]', $address['country']); ?>" placeholder="<?php echo lang('label_country'); ?>">
									<?php echo form_error('address[country]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
						<?php }?>
						<div class="col-md-12">
							<div class="buttons">
								<a  href="<?php echo $back_url; ?>"><b><?php echo lang('button_back'); ?></b></a>
								<button type="submit" class="btn btn-primary btn-sm" style="height:35px;"><?php echo $button_update; ?></button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('#add-address').on('click', function() {

  	if($('#new-address').is(':visible')){
     	$('#new-address').fadeOut();
	}else{
   		$('#new-address').fadeIn();
	}
	});
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo $this->config->item('maps_api_key')?>&libraries=places&callback=initAutocomplete" async defer></script>
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
        var autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('address_1')),
            {types: ['address']}
            );
        autocomplete.addListener('place_changed', function() {

        var place = autocomplete.getPlace();
        console.log(place);
        document.getElementById('city').value=place.address_components[1].long_name;
        // document.getElementById('city_state').value=place.address_components[1].long_name;
        var postal_code = place.address_components.find(item => item.types.includes('postal_code'));
        var country = place.address_components.find(item => item.types.includes('country'));
        document.getElementById('country').value=  country.long_name;
        document.getElementById('postcode').value=  postal_code.long_name;
		document.getElementById('state').value=place.address_components[2].long_name;
		document.getElementById('latitude').value=place.geometry.location.lat();
		document.getElementById('longitude').value=place.geometry.location.lng();
		});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        //autocomplete.addListener('place_changed', fillInAddress);
      }
      $( function() {


	    	$( "#datepicker" ).datepicker({
				 autoclose:true,
				 format : "dd-mm-yyyy",
				 startDate: new Date() ,
                 orientation: 'bottom'  ,
                 todayHighlight: 'true'
			});

			$('#datepicker').datepicker(
      			'setDate', new Date()
      			);

  		});

    </script>
<?php echo get_footer(); ?>