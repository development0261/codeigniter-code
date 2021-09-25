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
 * Staff_groups Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Staff_groups_model.php
 * @link           http://docs.spotneat.com
 */
class Stories_model extends TI_Model {

	public function getCount($filter = array()) {
		$this->db->from('stories');

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
			$wherestory=array('status'=>'1');
			if($this->session->user_info['staff_group_id']!=11){
				$wherestory['added_by']=$this->session->user_info['user_id'];
			}
			$this->db->where($wherestory);
			return $this->db->get('stories');
			
		}
	}

	public function getStaffGroupsPermissions($filter = array()) {
		
		$this->db->select('permissions');
		$this->db->from('staff_groups');
		$this->db->where('staff_group_id',12);
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array()[0]['permissions'];
		}

		return $result;
		
	}

	public function getStaffGroups() {
		$this->db->from('staff_groups');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getPermissionName($id) {
		$this->db->select('name');
		$this->db->from('permissions');
		$this->db->where('permission_id', $id);
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array()[0]['name'];
		}

		return $result;
	}

	public function getStories($stories_id) {
		$this->db->where('id', $stories_id);
		return $this->db->get('stories');

	}

	public function getUsersCount($staff_group_id) {
		if ($staff_group_id) {
			$this->db->from('staffs');

			$this->db->where('staff_group_id', $staff_group_id);

			return $this->db->count_all_results();
		}
	}

	public function saveStories($story_id, $save = array()) {
		
		if (empty($save)) return FALSE;
		
		// echo "<pre>";print_r($save );exit();
		$query=FALSE;
		$storyData=array(
			'title'=>$save['title'],
			'content'=>$save['content'],
			'status'=>$save['status'],
			'story_image'=>$this->session->storyImageName,

		);
		if (is_numeric($story_id)) {
			$isStoryData=$this->db->select('story_image,id')->get_where('stories',array('id'=>$story_id));
			if($isStoryData->num_rows() >0 ){
				$storyDBData=$isStoryData->row();

				if($this->session->storyImageName){
					unlink($storyDBData->story_image);// Remove previous images from the folder.
				}else{
					unset($storyData['story_image']);
				}
				$storyData['modified_by']=$this->session->user_info['user_id'];
				$storyData['modified_date']=date('Y-m-d H:i:s');
				
				$this->db->where('id', $storyDBData->id);
				$query = $this->db->update('stories',$storyData);
			}
			
		} else {
			$storyData['added_by']=$this->session->user_info['user_id'];
			$storyData['added_date']=date('Y-m-d H:i:s');
			$query = $this->db->insert('stories',$storyData);
			$story_id = $this->db->insert_id();
		}
		if($query === TRUE){
			if(count($save['staff_location_id']) >0){
				$wherelocations=array('story_id'=>$story_id);
				if($this->session->user_info['staff_group_id']!=11){
					$wherelocations['added_by']=$this->session->user_info['user_id'];
				}
				$this->db->delete('stories_access',$wherelocations);
				$storyLocationData=array();
				foreach($save['staff_location_id'] as $storylocation){
					$storyLocationData[]=array(
						'story_id'=>$story_id,
						'location_id'=>$storylocation,
						'added_by'=>$this->session->user_info['user_id'],
						'added_date'=>date('Y-m-d H:i:s')
					);
				}
				// echo "<pre>";print_r($storyLocationData);
				$this->db->insert_batch('stories_access',$storyLocationData);
				// echo  $this->db->last_query();exit();
			}
			
		}

		return ($query === TRUE AND is_numeric($story_id)) ? $story_id : FALSE;
	}

	
	public function deleteStories($story_id) {
		if (is_numeric($story_id)) 
			$story_id = (array) $story_id;

		if ( ! empty($story_id) AND ctype_digit(implode('', $story_id))) {
			$this->db->where_in('id', $story_id);
			$this->db->delete('stories');

			return $this->db->affected_rows();
		}
	}
	public function getStoryLocation($storiesid){
		$wherelocations=array('story_id'=>$storiesid);
        if($this->session->user_info['staff_group_id']!=11){
            $wherelocations['added_by']=$this->session->user_info['user_id'];
        }
       
        $story_location_id=$this->db->select('group_concat(location_id) as locations')
                                            ->get_where('stories_access',$wherelocations)
											->row();
		return $story_location_id->locations;
	}
	public function getStoryBasedOnLocation($filter=array(), $added_by, $location_id)
	{
		
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
		
			
			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by('stories.'.$filter['sort_by'], $filter['order_by']);
			}
			$location_id = implode(',', $location_id);
			return $this->db->select('stories.id,locations.location_name as resturent_name,stories.title, stories.content,stories.story_image, stories.status,stories.added_by')
				->join('stories_access ','locations.location_id=stories_access.location_id','inner')
				->join('stories','stories_access.story_id=stories.id','inner')
				->where("stories.status ='1'")
				->where("stories_access.location_id IN($location_id) OR stories.added_by=$added_by")
				->group_by('stories.id')
				->get('locations');
		}
		
	}
}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */