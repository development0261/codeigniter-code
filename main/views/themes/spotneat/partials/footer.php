
        <footer>
            <div id="footer">
                <div class="container">
                 
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <p>  

                        App by <a target="_blank" href="https://technowand.com.au/" style="font-size:14px;">Technowand</a>. 2021 IGNITIT. All Rights Reserved </p>


                            <?php //echo sprintf(lang('site_copyright'), date('Y'), config_item('site_name'), lang('spotneat_system_name')) . lang('spotneat_system_powered'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="clearfix"></div>

    </div>
    <!-- END fh5co-page -->

    </div>
    <!-- END fh5co-wrapper -->
    
   
<script type="text/javascript">
        
        $('.carousel[data-type="multi"] .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));
  
  for (var i=0;i<2;i++) {
    next=next.next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    
    next.children(':first-child').clone().appendTo($(this));
  }
});


jQuery(document).ready(function(){
    // This button will increment the value
    $('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });

    $("#hide1").click(function(){
        $("#filters").slideToggle();
    });
    $("#hide2").click(function(){
        $("#cuisine").slideToggle();
    });
    $("#hide3").click(function(){
        $("#est_type").slideToggle();
    });
    $("#hide4").click(function(){
        $("#trans").slideToggle();
    });



});


function change_lang(theForm){

     // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
       
        var formData = {
            'lang'              : $('input[name=lang]').val(),
        };

        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : "<?php echo site_url().'home/change_lang';?>", // the url where we want to POST
            data        : formData, // our data object
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data); 
                window.location.reload();
                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
   

}

</script>


<?php $custom_script = get_theme_options('custom_script'); ?>
<?php if (!empty($custom_script['footer'])) { echo '<script type="text/javascript">'.$custom_script['footer'].'</script>'; }; ?>

</body>
</html>