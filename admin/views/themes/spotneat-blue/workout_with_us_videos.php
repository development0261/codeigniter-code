<?php echo get_header(); ?>


<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Workout With Us Videos</h3>

			</div>
			<div id="alert_message"></div>
				<div class="col-md-12" align="right" style="margin:5px 0px">
					<!-- <button type="button" name="add" id="addVideo_" class="btn btn-success btn-xs">Add Video</button> -->
					<a class="btn btn-primary" name="import" id="importVideo"  ><i class="fa fa-plus"></i> Import </a>

					<a class="btn btn-primary" name="add" id="addVideo"  ><i class="fa fa-plus"></i> New</a>
				</div>


			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border" id="VideoList">
						<thead>
							<tr>
								 
								<th>Id</th>
								<th>Title</th>
								<th>Description</th>								
								<th>Workout Video</th>

								<th>Category</th>
								<th>Schedule</th>

								<th>Video URL</th>

								<th>Image</th>
								<th>File</th>
								<th >Week</th>

								<th >Day</th>
								<th>Sets</th>
								<th >Reps</th>					 

								<th >Duration</th>
								<th>Status</th>
								<th >Paid</th>


								<th nowrap="nowrap" width="77">Action</th>
								 
		 
							</tr>
						</thead>
						 
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>
<script type="text/javascript">
	
 
 
$(document).ready(function(){	


	var VideoData = $('#VideoList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		//"scrollX": true,
		"order":[],
		"ajax":{
			url:"<?php echo  base_url() ?>workout_with_us_videos/actionlist",
			type:"POST",
			data:{action:'listVideo'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
				"orderable":false,
			},
		],
		"pageLength": 10
	});		
	$('#addVideo').click(function(){
		$('#VideoModal').modal('show');
		$('#VideoForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Video");
		$('#action').val('addVideo');
		$('#save').val('Add');
	});		
	$("#VideoList").on('click', '.update', function(){
		var empId = $(this).attr("id");
		var action = 'getVideo';
		$.ajax({
			url:"<?php echo  base_url() ?>workout_with_us_videos/actionlist",
			method:"POST",
			data:{empId:empId, action:action},
			dataType:"json",
			success:function(data){

				$('#VideoModal').modal('show');

 


				$('#empId').val(data.workout_with_us_video_id);

				$('#day').val(data.day);
				$('#description').val(data.description);

				$('#duration').val(data.duration);
				$('#filename').val(data.filename);

				$('#is_paid').val(data.is_paid);
				$('#reps').val(data.reps);
				$('#sets').val(data.sets);


				$('#status').val(data.status);
				$('#title').val(data.title);
				$('#video_url').val(data.video_url);
				$('#week').val(data.week);
				//$('#workout_with_us_video_id').val(data.workout_with_us_video_id);



				$('#workout_video_id').val(data.workout_video_id);
				//$('#workout_video_module_id').val(data.workout_video_module_id);
				$('select#workout_video_module_id').find('option[value="'+data.workout_video_module_id+'"]').attr('selected','selected');
				var module_value = $('select#workout_video_module_id').find(":selected").text();
				$('#select2-chosen-2').text(module_value);

				//$('#workout_video_schedule_id').val(parseInt(data.workout_video_schedule_id));
				$('select#workout_video_schedule_id').find('option[value="'+data.workout_video_schedule_id+'"]').attr('selected','selected');
				var schedule_video = $('select#workout_video_schedule_id').find(":selected").text();
				$('#select2-chosen-3').text(schedule_video);


				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Video");
				$('#action').val('updateVideo');
				$('#save').val('Save');
			}
		})
	});
	$("#VideoModal").on('submit','#VideoForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		//var formData = $(this).serialize();






		var form = $("#VideoForm");
    // you can't pass Jquery form it has to be javascript form object
    var formData = new FormData(form[0]);

 





		$.ajax({
			url:"<?php echo  base_url() ?>workout_with_us_videos/actionlist",
			method:"POST",
			data:formData,
			processData: false,
			contentType: false,
			success:function(data){	

				reseult = $.parseJSON(data);
	 
				if(reseult.error==1){
					$('#alert_message_error').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+reseult.error_message+'</div>');
					
					setInterval(function(){
					    $('#alert_message_error').html('');
					}, 5000);
					return false ;	

					 				
				}


				
				$('#VideoForm')[0].reset();
				$('#VideoModal').modal('hide');				
				$('#save').attr('disabled', false);
				
				VideoData.ajax.reload();
			}
		})
	});		
	$("#VideoList").on('click', '.delete', function(){
		var empId = $(this).attr("id");		
		var action = "empVideo";
		if(confirm("Are you sure you want to delete this Video?")) {
			$.ajax({
				url:"<?php echo  base_url() ?>workout_with_us_videos/actionlist",
				method:"POST",
				data:{empId:empId, action:action},
				success:function(data) {					
					VideoData.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	








//update

  $(document).on('blur', '.update_row', function(){
   var id = $(this).data("id");
   var column_name = $(this).data("column");
   var value = $(this).text();
   //update_data(id, column_name, value);


   $.ajax({
    url:"<?php echo  base_url() ?>workout_with_us_videos/actionlist",
    method:"POST",
    data:{empId:id, column_name:column_name, value:value,action:'updateIndiviVideo'},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">Updated Successfully</div>');
     VideoData.ajax.reload();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);




  })













 

		$('#importVideo').click(function(){
			$('#ImportModal').modal('show');
			$('#ImportModalForm')[0].reset();
			$('.modal-title-import').html("<i class='fa fa-plus'></i> Import Videos");
			$('#action_import').val('importVideo');
			$('#save_import').val('Import');
		});	




		$("#ImportModal").on('submit','#ImportModalForm', function(event){
		event.preventDefault();
		 
		$('#save_import').attr('disabled','disabled');

		var form = $("#ImportModalForm");
		var formData = new FormData(form[0]);

 

		//alert();
		//return false ; 



		$.ajax({
			url:"<?php echo  base_url() ?>workout_with_us_videos/import",
			method:"POST",
			data:formData,
			processData: false,
			contentType: false,
			success:function(data){	

				reseult = $.parseJSON(data);
	 
				if(reseult.error==1){
					$('#alert_message_error_import').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+reseult.error_message+'</div>');
					
					setInterval(function(){
					    $('#alert_message_error_import').html('');
					}, 5000);
					$('#save_import').attr('disabled',false);
					return false ;	

					 				
				}

				$('#alert_message_error_import').html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+reseult.error_message+'</div>');

					setInterval(function(){
					   
					    

					   $('#alert_message_error_import').html('');
					}, 10000);
				
					
				
				$('#ImportModalForm')[0].reset();
				$('#ImportModal').modal('hide');				
				$('#save_import').attr('disabled', false);
				
				VideoData.ajax.reload();
			}
		})
	});	
 












});

 



</script>


	<div id="VideoModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="VideoForm" enctype="multipart/form-data">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
    				</div>
    				<div class="modal-body">

    				 

      					<div class="row">
	    					<div class="col-md-12" >

		    					<div class="form-group"
									<label for="name" class="control-label">Title<span class="requied-span">*</span></label>
									<input type="text" class="form-control" id="title" name="title" placeholder="title" required>			
								</div>


	    					</div>
	    				</div>	


						<div class="row">
	    					
	    					<div class="col-md-12" >
			    				<div class="form-group">
									<label for="address" class="control-label">Description<span class="requied-span">*</span></label>							
									<input type="text" class="form-control" id="description" name="description" ></textarea>							
								</div>
							</div>	
  						</div>

  						<div class="row">
	    					
	    					<div class="col-md-12" >
			    				<div class="form-group">
									<label for="address" class="control-label">Video URL<span class="requied-span">*</span></label>							
									<input type="text" class="form-control"  id="video_url" name="video_url" required></textarea>							
								</div>
							</div>	
  						</div>



  						<div class="row">
	    					
	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Workout Video<span class="requied-span">*</span></label>

       <?php  
       //$workoutVvideoModules = $this->workout_with_us_videos_model->workoutVvideoModules() ; 
        //$scheduleList = $this->workout_with_us_videos_model->scheduleList() ; 
        //$moduleList = $this->workout_with_us_videos_model->moduleList() ; 
       //print_r($moduleList);
        ?>

									 

									<select  class="form-control" class="form-control" id="workout_video_id" name="workout_video_id" required> 
										<?php foreach ($moduleList as $key => $value) {
											 if($value->workout_video_id==8){ 
										 ?>
										<option value="<?php echo $value->workout_video_id?>"><?php echo $value->name ?></option>
										<?php }} ?>
									</select>
								</div>
							</div>	
	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Category<span class="requied-span">*</span></label>							
									 

									<select  class="form-control"   id="workout_video_module_id" name="workout_video_module_id" required> 
										<?php foreach ($workoutVvideoModules as $key => $value) {
											 
										 ?>
										<option value="<?php echo $value->workout_video_module_id?>"><?php echo $value->module_name ?></option>
										<?php } ?>
									</select>			
								</div>
							</div>	
	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Schedule<span class="requied-span">*</span></label>							
									 	
									<select  class="form-control" id="workout_video_schedule_id" name="workout_video_schedule_id" required>
										<?php foreach ($scheduleList as $key => $value) {
											 
										 ?>
										<option value="<?php echo $value->workout_video_schedule_id?>"><?php echo $value->schedule_name ?></option>
										<?php } ?>
									</select>				
								</div>
							</div>	


							<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Duration<span class="requied-span">*</span></label>							
									<input type="text" class="form-control" id="duration" name="duration" required> 			
								</div>
							</div>	


  						</div>





  						<div class="row">
	    					
	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Week<span class="requied-span">*</span></label>							
									<input type="text" class="form-control" id="week" name="week" required> 						
								</div>
							</div>	
	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Day<span class="requied-span">*</span></label>							
									<input type="text" class="form-control" id="day" name="day" required> 			
								</div>
							</div>	
	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">sets<span class="requied-span">*</span></label>							
									<input type="text" class="form-control" id="sets" name="sets" required> 
								</div>
							</div>	
    						<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">reps<span class="requied-span">*</span></label>							
									<input type="text" class="form-control" id="reps" name="reps" required> 					
								</div>
							</div>	


  						</div>



  						<div class="row">
	    					
	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Filename<span class="requied-span">*</span></label>							
									<input type="text" class="form-control" id="filename" name="filename" required> 						
								</div>
							</div>	
	    					

	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Image<span class="requied-span">*</span> (300x300) </label>							
									<input type="file" class="form-control" id="image" name="image" > 

								</div>
							</div>	

	    					<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label">Status<span class="requied-span">*</span></label>							
									 

									<select  class="form-control-1" class="form-control" id="status" name="status" required> 
										<option value="1">Active</option>
										<option value="0">InActive</option>
									</select>

								</div>
							</div>	
    						<div class="col-md-3" >
			    				<div class="form-group">
									<label for="address" class="control-label-1">Paid<span class="requied-span">*</span></label>		
									<select  class="form-control-1" id="is_paid" name="is_paid" required> 
										<option value="1">Paid</option>
										<option value="0">Not Paid</option>
									</select>					
									 			
								</div>
							</div>	


  						</div>
 <div id="alert_message_error"></div>
 				
    				</div>
    				<div class="modal-footer">





    					<input type="hidden" name="empId" id="empId" />
    					<input type="hidden" name="action" id="action" value="" />
    					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>











	<div id="ImportModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="ImportModalForm" enctype="multipart/form-data">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title-import"><i class="fa fa-plus"></i>Import Workuot Videos</h4>
    				</div>
    				<div class="modal-body">

    				 
 


  						<div class="row">
	    					
	    					<div class="col-md-12" >
			    				<div class="form-group pull-right">
									<label for="address" class="control-label pull-right"> <a target="_blank"  href="<?php echo base_url()?>views/uploads/workout_video_sample_for_upload.csv">Click here to see sample csv file to upload</a> </label>							
									 
								 					
								</div>
							</div>	
	    					
 
 


  						</div>


						 


  						<div class="row">
	    					
	    					<div class="col-md-12" >
			    				<div class="form-group">
									<label for="address" class="control-label">Upload File (CSV) <span class="requied-span">*</span></label>							
									 
									<input type="file" class="form-control" id="file" name="file"   > 						
								</div>
							</div>	
	    					
 


  						</div>
 <div id="alert_message_error_import"></div>
 				
    				</div>
    				<div class="modal-footer">





    					 
    					<input type="hidden" name="action" id="action_import" value="" />
    					<input type="submit" name="save_import" id="save_import" class="btn btn-info" value="Import" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>



 




<style type="text/css">
	
	.requied-span{
		color: red;
	}
.form-control-1{
border: 1px solid #d2dce7;
    box-shadow: none;
    width: 100%;
    border-radius: 3px;
    height: 38px;
    line-height: 2;
    padding: 10px;
    font-size: 13px
}
</style>