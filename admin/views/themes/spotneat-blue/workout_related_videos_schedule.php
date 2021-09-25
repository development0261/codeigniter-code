<?php echo get_header(); ?>


<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Workout Related Schedules</h3>

			</div>
			<div id="alert_message"></div>
				<div class="col-md-12" align="right" style="margin:5px 0px">
					<!-- <button type="button" name="add" id="addSchedule_" class="btn btn-success btn-xs">Add Schedule</button> -->
					<a class="btn btn-primary" name="add" id="addSchedule"  ><i class="fa fa-plus"></i> New</a>
				</div>


			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border" id="ScheduleList">
						<thead>
							<tr>
								 
								<th>Id</th>
								<th>Schedule Name</th>
								<th>Description</th>								
								<th>Image</th>
								<th>Status</th>

 

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


	var ScheduleData = $('#ScheduleList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		 
		"order":[],
		"ajax":{
			url:"<?php echo  base_url() ?>workout_related_videos/scheduleactionlist",
			type:"POST",
			data:{action:'listSchedule'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[3],
				"orderable":false,
			},
		],
		"pageLength": 10
	});		
	$('#addSchedule').click(function(){
		$('#ScheduleModal').modal('show');
		$('#ScheduleForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Schedule");
		$('#action').val('addSchedule');
		$('#save').val('Add');
	});		
	$("#ScheduleList").on('click', '.update', function(){
		var empId = $(this).attr("id");
		var action = 'getSchedule';
		$.ajax({
			url:"<?php echo  base_url() ?>workout_related_videos/scheduleactionlist",
			method:"POST",
			data:{empId:empId, action:action},
			dataType:"json",
			success:function(data){
				$('#ScheduleModal').modal('show');

 


				$('#empId').val(data.workout_video_schedule_id  );

				 
				$('#schedule_name').val(data.schedule_name);
 				$('#description').val(data.description);
 			 
 				$('#status').val(data.status);
 
 



				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Schedule");
				$('#action').val('updateSchedule');
				$('#save').val('Save');
			}
		})
	});
	$("#ScheduleModal").on('submit','#ScheduleForm', function(event){
		event.preventDefault();
		//$('#save').attr('disabled','disabled');
		//var formData = $(this).serialize();






		var form = $("#ScheduleForm");
    // you can't pass Jquery form it has to be javascript form object
    var formData = new FormData(form[0]);

 





		$.ajax({
			url:"<?php echo  base_url() ?>workout_related_videos/scheduleactionlist",
			method:"POST",
			data:formData,
			processData: false,
			contentType: false,
			success:function(data){	

				reseult = $.parseJSON(data);
	 			//	alert(reseult.error);
				if(reseult.error==1){
					$('#alert_message_error').html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+reseult.error_message+'</div>');
					return false ;	

					 				
				}


				
				$('#ScheduleForm')[0].reset();
				$('#ScheduleModal').modal('hide');				
				$('#save').attr('disabled', false);
				
				ScheduleData.ajax.reload();
			}
		})
	});		
	$("#ScheduleList").on('click', '.delete', function(){
		var empId = $(this).attr("id");		
		var action = "empSchedule";
		if(confirm("Are you sure you want to delete this Schedule?")) {
			$.ajax({
				url:"<?php echo  base_url() ?>workout_related_videos/scheduleactionlist",
				method:"POST",
				data:{empId:empId, action:action},
				success:function(data) {					
					ScheduleData.ajax.reload();
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
    url:"<?php echo  base_url() ?>workout_related_videos/scheduleactionlist",
    method:"POST",
    data:{empId:id, column_name:column_name, value:value,action:'updateIndiviSchedule'},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">Updated Successfully</div>');
     ScheduleData.ajax.reload();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);




  })











});

 



</script>


	<div id="ScheduleModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="ScheduleForm" enctype="multipart/form-data">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
    				</div>
    				<div class="modal-body">

    				 

      					<div class="row">
	    					<div class="col-md-12" >

		    					<div class="form-group"
									<label for="name" class="control-label">Schedule Name<span class="requied-span">*</span> </label>
									<input type="text" class="form-control" id="schedule_name" name="schedule_name" placeholder="title" required>			
								</div>


	    					</div>
	    				</div>	


						<div class="row">
	    					
	    					<div class="col-md-12" >
			    				<div class="form-group">
									<label for="address" class="control-label">Description</label>							
									<input type="text" class="form-control" id="description" name="description" ></textarea>							
								</div>
							</div>	
  						</div>

 

  



 

  						<div class="row">
	    					
 

	    					<div class="col-md-6" >
			    				<div class="form-group">
									<label for="address" class="control-label">Schedule Image<span class="requied-span">*</span> (300x300) </label>							
									<input type="file" class="form-control" id="image" name="image" > 

								</div>
							</div>	

	    					<div class="col-md-6" >
			    				<div class="form-group">
									<label for="address" class="control-label">Status<span class="requied-span">*</span></label>							
									 

									<select   class="form-control-1" id="status" name="status" required> 
										<option value="1">Active</option>
										<option value="0">InActive</option>
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