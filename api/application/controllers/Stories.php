<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

class Stories extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Stories_model'));
        $this->load->library(array('form_validation','Customer'));
        $this->load->helper('security');
    }

    
    public function index_get() {
         
        $location_id=$this->uri->segment(2);
        $added_by=$this->uri->segment(3);
        if(is_numeric($location_id)){
            $locationStoriesSql=$this->Stories_model->getStoryBasedOnLocation($location_id,$added_by);
            if($locationStoriesSql->num_rows() >0){
                $storydata=$locationStoriesSql->result();
                $output = array('result'  => $storydata, 
                'message' => 'Story Search');
               
            }else{
                $error_data = array('code'  => 401 ,
                'error' => 'Story Not Found.');               
                $output = array('message'  => $error_data);
               
            }
        }
        else{
            $error_data = array('code'  => 401 ,
            'error' => 'Story Not Found.');               
            $output = array('message'  => $error_data);
           
        }
        echo json_encode($output);
    }


    public function index_post() {
        $_POST = $this->post();

        if (empty($_POST)) return FALSE;
		$query=FALSE;
		$storyData=array(
			'title'=>$_POST['title'],
			'content'=>$_POST['content'],
			'status'=>$_POST['status'],
            'video_url'=>$_POST['video_url'],
			'story_image'=>$_POST['story_image'],
		);
        $story_id = $_POST['story_id'];
		if (is_numeric($story_id)) {
            $isStoryData=$this->db->select('story_image,id')->get_where('stories',array('id'=>$story_id));
			if($isStoryData->num_rows() >0 ){
				$storyDBData=$isStoryData->row();
				unlink($storyDBData->story_image);// Remove previous images from the folder.
				unset($storyData['story_image']);
				$storyData['modified_by']=$_POST['location_id'];
				$storyData['modified_date']=date('Y-m-d H:i:s');

				$this->db->where('id', $storyDBData->id);
				$query = $this->db->update('stories',$storyData);
			}
		} else {
			$storyData['added_by']=$_POST['location_id'];
			$storyData['added_date']=date('Y-m-d H:i:s');
			$query = $this->db->insert('stories',$storyData);
			$story_id = $this->db->insert_id();
		}
		if($query === TRUE){
			if(count($_POST['staff_location_id']) >0){
				$wherelocations=array('story_id'=>$story_id);
				$wherelocations['added_by']=$_POST['location_id'];

				$this->db->delete('stories_access',$wherelocations);
				$storyLocationData=array();
				foreach($_POST['staff_location_id'] as $storylocation){
					$storyLocationData[]=array(
						'story_id'=>$story_id,
						'location_id'=>$storylocation,
						'added_by'=>$_POST['location_id'],
						'added_date'=>date('Y-m-d H:i:s')
					);
				}
				$this->db->insert_batch('stories_access',$storyLocationData);
			}
		}
        if($query === TRUE AND is_numeric($story_id)){
			$output = array('result'  => $storydata, 'status'=>true,'message' => 'Story Add');
			echo json_encode($output);
		}else{
			$output = array('status'=>false,
			'message' => 'Story Add');
			echo json_encode($output);
		}
    }

	public function delete_post(){
		$story_id = $this->post('story_id');
		$storyItem =$this->Stories_model->deleteStory($story_id);
		if($storyItem){
		  $output = array(
			'result'  => "success",
			'message' => 'Successfully Delete story',
			'status'=>true
			);
			echo json_encode($output);
		}else{
		  $error_data = array('code'  => 401 ,'error' => 'something wrong.');
		  $output = array('message'  => $error_data,'status'=>false);
		  echo json_encode($output);
		}
	}

	public function imageUpdate_post() {

		$result = array();
		$image_url = "";
		$result['status']=false;
		if($_FILES){
		  $name = time().'_'.basename( $_FILES["image_upload"]["name"]);
		  $folderPath = '../admin/views/themes/spotneat-blue/images/stories/';
		  if (!file_exists($folderPath)) {
			mkdir($folderPath,0777);
		  }
		  $target_dir = '../admin/views/themes/spotneat-blue/images/stories/'.$name;
		//   $image_url = 'stories/'.$name;
		  $image_url = '/views/themes/spotneat-blue/images/stories/'.$name;

		  if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_dir)) {
			if($image_url){ 
			  $result['image_url']  = $image_url;
			  $result['status'] = true;
			  $result['message'] = "Image upload successfully";
			}
		  }else {
			$result['message'] = "Sorry, there was an error uploading your file.";
		  }
		}else{
		  $result['message'] = "Sorry, Image Empty";
		}
		$this->response($result);
		exit;
	}
}
 ?>