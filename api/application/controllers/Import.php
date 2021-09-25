<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

class Import extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->helper('security');
		$this->load->model(array('Workout_videos_model'));
    }

    
    public function index_post() 
	{			
			// Allowed mime types
			$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
			
			// Validate whether selected file is a CSV file
			if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
			{		
				// If the file is uploaded
				if(is_uploaded_file($_FILES['file']['tmp_name']))
				{
					
					// Open uploaded CSV file with read-only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					// Skip the first line
					fgetcsv($csvFile);
					
					// Parse data from CSV file line by line
					$iCnt = 1;
					$row  = 1;
					$row_ids  = '';
					while(($line = fgetcsv($csvFile)) !== FALSE)
					{		
						if($row == 1){
							$row = $row + 1;
							continue;
						}	
						// Get row data
						if(!empty($line[1])){

							$csvData = array();
							$csvData['workout_video_id']    		= isset($line[8])? $line[8] : '8';
							$csvData['image']    					= rand(1,48).'.png';
							$csvData['title']   					= isset($line[1])? $line[1] : '';
							$csvData['description']					= isset($line[2])? $line[2] : '';
							$csvData['video_url']					= isset($line[5])? $line[5] : '';
							$csvData['workout_video_module_id'] 	= isset($line[9])? $line[10] : rand(1,12);
							$csvData['workout_video_schedule_id']   = isset($line[11])? $line[11] : rand(1,4);
							$csvData['week']   						= isset($line[6])? $line[6] : '';
							$csvData['day']       					= isset($line[7])? $line[7] : '';
							$csvData['sets']   						= isset($line[3])? $line[3] : '';
							$csvData['reps']  						= isset($line[4])? $line[4] : '';
							$csvData['filename']   					= isset($line[10])? $line[9] : '';
							$csvData['duration']       				= isset($line[12])? $line[12] : '';
							$csvData['status']   					= isset($line[13])? $line[13] : '1';
							$csvData['is_paid']  					= isset($line[14])? $line[14] : '1';
							
							// Insert into related video table						
							$csvData['workout_related_video_id'] 	= $this->Workout_videos_model->importRelatedVideoData($csvData);				
							$row_ids .= empty($row_ids)?$line[0]:','.$line[0];
							$row = $row + 1;
						}						
					}
					
					// Close opened CSV file
					fclose($csvFile);
				}
			}
			echo 'row_ids='.$row_ids;;
			echo 'row inserted = '.$row;
    }
}
 ?>