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
class Subscriptions_model extends TI_Model {

	public function getCount($filter = array()) {
		$this->db->from('workout_video_purchases');
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
			//$wherestory=array('purchase_type'=>'subscription');
			
			// $this->db->group_by('email');
			// $this->db->limit('1');
			// $this->db->order_by('video_purchase_id');
			// $result =  $this->db->get('workout_video_purchases');

			$query = $this->db->select('V1.*')
				->join('(SELECT MAX(video_purchase_id) AS video_purchase_id, email FROM yvdnsddqu_workout_video_purchases GROUP BY email) AS V2','`V1`.`video_purchase_id` = `V2`.`video_purchase_id`','inner')
				->get('yvdnsddqu_workout_video_purchases AS V1');

			
			if ($query->num_rows()) {
				return $query->result_array();
			}else{
				return array();
			}	
			
		}
	}

	public function updateWeek($id, $data = array()) {
		
		if (empty($data)) return FALSE;			 

			$this->db->where('video_purchase_id', $id);
			$query = $this->db->update('workout_video_purchases',$data);

			if ($this->db->affected_rows() > 0) {
				return true ;
			}
			return false; 

	}


}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */