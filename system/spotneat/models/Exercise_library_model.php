<?php
/**
 * SpotnEat
 *
 *
 *
 * @package   SpotnEat
 * @author    Sp
 * @copyright SpotnEat
 * @link      http://spotneat.com
 * @license   http://spotneat.com
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Trainer Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Staff_groups_model.php
 * @link           http://docs.spotneat.com
 */

class Exercise_library_model extends TI_Model {

	public function getCount($filter = array()) {
		$this->db->from('workout_related_videos');
		return $this->db->count_all_results();
	}                                            

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
		
			
			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}
			  
			$result =  $this->db->get('workout_related_videos');
			
			
			return $result;
			//return $this->db->get('workout_video_purchases');
			
		}
	}





	function workoutVvideoModules(){

			$this->db->select('workout_video_module_id, module_name');
			$result =  $this->db->get('workout_video_modules');
			return $result->result();

	}


	function scheduleList(){
			$this->db->select('workout_video_schedule_id, schedule_name');
			$result =  $this->db->get('workout_video_schedules');
			return $result->result();

	}


	function moduleList(){
			$this->db->select('workout_video_id, name');
			$result =  $this->db->get('workout_videos');
			return $result->result();

	}








	function get_all_records_related_videos($search_cond, $sOrder , $sLimit )
	{
		
		
		//echo $this->db->dbprefix('workout_related_videos') ; 
		$cond =  $search_cond.' '.$sOrder.' '.$sLimit ; 
		/* $sQuery = "
			SELECT rv.* , rvs.schedule_name,  rvm.module_name, rvmm.name
			FROM   ".$this->db->dbprefix('workout_related_videos')." as rv inner join  ".$this->db->dbprefix('workout_video_schedules')." as rvs on rv.workout_video_schedule_id=rvs.workout_video_schedule_id inner join ".$this->db->dbprefix('workout_video_modules')." as rvm on  rv.workout_video_module_id=rvm.workout_video_module_id 
				inner join ".$this->db->dbprefix('workout_videos')." as rvmm on  rv.workout_video_id=rvmm.workout_video_id

			".	$cond ;
		*/

		$sQuery = "
			SELECT *
			FROM   ".$this->db->dbprefix('workout_related_videos')."  ".$cond ;

 
			 
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  		//die() ; 
  		//print_r($query->result());
		return $query->result();		
	}

	function get_all_records_related_videos_with_condition($search_cond)
	{
		//echo $this->db->dbprefix('workout_related_videos') ; 
		$cond =  $search_cond; 
		/*  $sQuery = "
			SELECT rv.* , rvs.schedule_name,  rvm.module_name, rvmm.name
			FROM   ".$this->db->dbprefix('workout_related_videos')." as rv inner join  ".$this->db->dbprefix('workout_video_schedules')." as rvs on rv.workout_video_schedule_id=rvs.workout_video_schedule_id inner join ".$this->db->dbprefix('workout_video_modules')." as rvm on  rv.workout_video_module_id=rvm.workout_video_module_id 
				inner join ".$this->db->dbprefix('workout_videos')." as rvmm on  rv.workout_video_id=rvmm.workout_video_id

			".	$cond ;

			$cond =  $search_cond ;  */

		$sQuery = "
			SELECT *
			FROM   ".$this->db->dbprefix('workout_related_videos')."  ".$cond ;

			 
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  		//die() ; 
  		//print_r($query->result());
		//return $query->result();
		return  $query->num_rows() ; 
		
	} 

	function get_all_records_related_videos_count()
	{
		
		
 
		$sQuery = "
			SELECT *
			FROM   ".$this->db->dbprefix('workout_related_videos') ;
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  	
  		//print_r($query->result());
		return  $query->num_rows() ; 
		
	} 
 



	public function saveVideo( $data = array()) {
		
		if (empty($data)) return FALSE;
			unset($data['empId']) ;
			unset($data['action']) ; 
 
			$query = $this->db->insert('workout_related_videos',$data);
			$video_id = $this->db->insert_id();
			//echo $this->db->last_query() ;  die('ee') ;
			return ($query === TRUE AND is_numeric($video_id)) ? $video_id : FALSE;

	}

 


 	public function updateVideo($id, $data = array()) {
		
		if (empty($data)) return FALSE;			 

			$this->db->where('workout_related_video_id', $id);
			$query = $this->db->update('workout_related_videos',$data);

			if ($this->db->affected_rows() > 0) {
				return true ;
			}
			return false; 

	}



 	public function deleteVideo($id) {
		
	 	 

			$this->db->where('workout_related_video_id', $id);
			$this->db->delete('workout_related_videos');

			if ($this->db->affected_rows() > 0) {
				return true ;
			}
			return false; 

	}



  
 

	public function getVideo($id) {
		$this->db->from('workout_related_videos');

		$this->db->where('workout_related_video_id', $id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return '' ; 
	}













 




	function get_all_records_related_videos_cateogory($search_cond, $sOrder , $sLimit )
	{
		
		
		//echo $this->db->dbprefix('workout_related_videos') ; 
		$cond =  $search_cond.' '.$sOrder.' '.$sLimit ; 
		 $sQuery = "
			SELECT *  FROM   ".$this->db->dbprefix('workout_video_modules').$cond ;

			 
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  		//die() ; 
  		//print_r($query->result());
		return $query->result();
		
	} 


 

	function get_all_records_related_videos_with_condition_category($search_cond)
	{
		
		

		//echo $this->db->dbprefix('workout_related_videos') ; 
		$cond =  $search_cond; 
		 $sQuery = "
			SELECT *  FROM   ".$this->db->dbprefix('workout_video_modules').$cond ;

			 
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  		//die() ; 
  		//print_r($query->result());
		//return $query->result();
		return  $query->num_rows() ; 
		
	} 

	function get_all_records_related_videos_count_category()
	{
		
		
 
		$sQuery = "
			SELECT *
			FROM   ".$this->db->dbprefix('workout_video_modules') ;
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  	
  		//print_r($query->result());
		return  $query->num_rows() ; 
		
	} 



 


 	public function updateCategory($id, $data = array()) {
		
		if (empty($data)) return FALSE;			 

			$this->db->where('workout_video_module_id', $id);
			$query = $this->db->update('workout_video_modules',$data);

			if ($this->db->affected_rows() > 0) {
				return true ;
			}
			return false; 

	}



 	public function deleteCategory($id) {
		
	 	 

			$this->db->where('workout_video_module_id', $id);
			$this->db->delete('workout_video_modules');

			if ($this->db->affected_rows() > 0) {
				return true ;
			}
			return false; 

	}



  
 

	public function getCategory($id) {
		$this->db->from('workout_video_modules');

		$this->db->where('workout_video_module_id', $id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return '' ; 
	}





	public function saveCategory( $data = array()) {
		
		if (empty($data)) return FALSE;
			unset($data['empId']) ;
			unset($data['action']) ; 
 
			$query = $this->db->insert('workout_video_modules',$data);
			$video_id = $this->db->insert_id();
			//echo $this->db->last_query() ;  die('ee') ;
			return ($query === TRUE AND is_numeric($video_id)) ? $video_id : FALSE;

	}







	function get_all_records_related_videos_schedule($search_cond, $sOrder , $sLimit )
	{
		
		
		//echo $this->db->dbprefix('workout_related_videos') ; 
		$cond =  $search_cond.' '.$sOrder.' '.$sLimit ; 
		 $sQuery = "
			SELECT *  FROM   ".$this->db->dbprefix('workout_video_schedules').$cond ;

			 
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  		//die() ; 
  		//print_r($query->result());
		return $query->result();
		
	} 


 

	function get_all_records_related_videos_with_condition_schedule($search_cond)
	{
		
		

		//echo $this->db->dbprefix('workout_related_videos') ; 
		$cond =  $search_cond; 
		 $sQuery = "
			SELECT *  FROM   ".$this->db->dbprefix('workout_video_schedules').$cond ;

			 
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  		//die() ; 
  		//print_r($query->result());
		//return $query->result();
		return  $query->num_rows() ; 
		
	} 

	function get_all_records_related_videos_count_schedule()
	{
		
		
 
		$sQuery = "
			SELECT *
			FROM   ".$this->db->dbprefix('workout_video_schedules') ;
  		$query = $this->db->query($sQuery);
  		//echo $this->db->last_query() ; 
  	
  		//print_r($query->result());
		return  $query->num_rows() ; 
		
	} 



 


 	public function updateSchedule($id, $data = array()) {
		
		if (empty($data)) return FALSE;			 

			$this->db->where('workout_video_schedule_id', $id);
			$query = $this->db->update('workout_video_schedules',$data);

			if ($this->db->affected_rows() > 0) {
				return true ;
			}
			return false; 

	}



 	public function deleteSchedule($id) {
		
	 	 

			$this->db->where('workout_video_schedule_id', $id);
			$this->db->delete('workout_video_schedules');

			if ($this->db->affected_rows() > 0) {
				return true ;
			}
			return false; 

	}



  
 

	public function getSchedule($id) {
		$this->db->from('workout_video_schedules');

		$this->db->where('workout_video_schedule_id', $id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return '' ; 
	}





	public function saveSchedule( $data = array()) {
		
		if (empty($data)) return FALSE;
			unset($data['empId']) ;
			unset($data['action']) ; 
 
			$query = $this->db->insert('workout_video_schedules',$data);
			$video_id = $this->db->insert_id();
			//echo $this->db->last_query() ;  die('ee') ;
			return ($query === TRUE AND is_numeric($video_id)) ? $video_id : FALSE;

	}




/*
	* Insert into related video table
	*/
	public function importRelatedVideoData($save = array()) {

		if (empty($save)) return FALSE;

		if (isset($save['workout_video_id'])) {
			$this->db->set('workout_video_id', $save['workout_video_id']);
		}

		if (isset($save['image'])) {
			$this->db->set('image', $save['image']);
		}

		if (isset($save['title'])) {
			$this->db->set('title', $save['title']);
		}

		if (isset($save['description'])) {
			$this->db->set('description', $save['description']);
		}		

		if (isset($save['video_url'])) {
			$this->db->set('video_url', $save['video_url']);
		}

		if (isset($save['workout_video_module_id'])) {
			$this->db->set('workout_video_module_id', $save['workout_video_module_id']);
		}		

		if (isset($save['workout_video_schedule_id'])) {
			$this->db->set('workout_video_schedule_id', $save['workout_video_schedule_id']);
		}

		if (isset($save['week'])) {
			$this->db->set('week', $save['week']);
		}

		if (isset($save['day'])) {
			$this->db->set('day', $save['day']);
		}
		
		if (isset($save['sets'])) {
			$this->db->set('sets', $save['sets']);
		}

		if (isset($save['reps'])) {
			$this->db->set('reps', $save['reps']);
		}

		if (isset($save['filename'])) {
			$this->db->set('filename', $save['filename']);
		}

		if (isset($save['duration'])) {
			$this->db->set('duration', $save['duration']);
		}

		if (isset($save['status'])) {
			$this->db->set('status', $save['status']);
		}

		if (isset($save['is_paid'])) {
			$this->db->set('is_paid', $save['is_paid']);
		}
		
		$query = $this->db->insert('workout_related_videos');
		$workout_related_video_id = $this->db->insert_id();
		
		return $workout_related_video_id;
	}



	function get_workout_video($id){


		$this->db->from('workout_videos');

		$this->db->where('workout_video_id', $id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result =  $query->row_array();
			return $result['name'] ; 
		}
		return '' ; 	


	}


	function get_workout_video_module($id){


		$this->db->from('workout_video_modules');

		$this->db->where('workout_video_module_id', $id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result =  $query->row_array();
			return $result['module_name'] ; 
		}
		return '' ; 	


	}

 




	function get_workout_video_schedule($id){


		$this->db->from('workout_video_schedules');

		$this->db->where('workout_video_schedule_id', $id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result =  $query->row_array();
			return $result['schedule_name'] ; 
		}
		return '' ; 
	}
 






}