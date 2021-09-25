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
class Trainers_model extends TI_Model {

	public function getCount($filter = array()) {
		$this->db->from('trainers');

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
			//$wherestory=array('status'=>'1');
			//$this->db->where($wherestory);
			return $this->db->get('trainers');
			
		}
	}

	public function getTrainers($trainer_id) {
		$this->db->select('*');
		$this->db->where('trainer_id', $trainer_id);
		return $this->db->get('trainers');
	}
	/*
	* Save stories
	*/
	
	public function saveTrainers($trainer_id, $save = array()) {
		
		if (empty($save)) return FALSE;
		
		// echo "<pre>";print_r($save );exit();
		$query=FALSE;
		$trainersData = array(
			'status'=>$save['status']
		);
		if (is_numeric($trainer_id)) {
			$istrainersData = $this->db->select('trainer_id')->get_where('trainers',array('trainer_id'=>$trainer_id));
			if($istrainersData->num_rows() >0 ){
				$trainersDBData=$istrainersData->row();			
				$trainersData['date_modified'] = date('Y-m-d H:i:s');
				
				$this->db->where('trainer_id', $trainersDBData->trainer_id);
				$query = $this->db->update('trainers',$trainersData);
			}
			
		} else {
			$trainersData['added_by']=$this->session->user_info['user_id'];
			$trainersData['date_added']=date('Y-m-d H:i:s');
			$query = $this->db->insert('trainers',$trainersData);
			$story_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($trainer_id)) ? $trainer_id : FALSE;
	}

	public function deleteTrainers($trainer_id) {
		if (is_numeric($trainer_id)) 
			$trainer_id = (array) $trainer_id;

		if ( ! empty($trainer_id) AND ctype_digit(implode('', $trainer_id))) {
			$this->db->where_in('trainer_id', $trainer_id);
			$this->db->delete('trainers');

			return $this->db->affected_rows();
		}
	}


}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */