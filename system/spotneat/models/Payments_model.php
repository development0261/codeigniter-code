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
 * Locations Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Locations_model.php
 * @link           http://docs.spotneat.com
 */
class Payments_model extends TI_Model {

	public function getCount() {
		$this->db->select('*');	
		$this->db->from('staffs_commission');
		return $this->db->count_all_results();
	}

	public function getList($vendor_id='') {
		
			$this->db->select('a.* , b.location_name , b.added_by , c.staff_name, SUM(a.table_amount) as table_amount, SUM(a.order_amount) as ord_total, SUM(a.total_amount) as total_amount');						
			$this->db->from('staffs_commission a');
			$this->db->join('locations b', 'b.location_id = a.location_id', 'left'); 
			$this->db->join('staffs c', 'c.staff_id = a.staff_id', 'left');

			$this->db->group_by('a.location_id'); 
			$this->db->order_by('table_amount', 'desc');

			if($vendor_id!=''){
				$this->db->where('b.added_by',$vendor_id); 
			}
			$where = "a.status='16' AND a.payment_status='confirmed' AND a.order_amount >0 OR a.status='17' AND a.payment_status='canceled' AND a.order_amount >0";
			$this->db->where($where);   

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		
	}
	public function getFullList($lc_id='',$vendor_id='') {

			$this->db->select('a.* , b.location_name , b.added_by  , c.staff_name');						
			$this->db->from('staffs_commission a');
			$this->db->join('locations b', 'b.location_id = a.location_id', 'left'); 
			$this->db->join('staffs c', 'c.staff_id = a.staff_id', 'left');		 
			
			
			if($lc_id!=''){
				$this->db->where('a.location_id',$lc_id);
			}

			if($vendor_id!=''){
				$this->db->where('b.added_by',$vendor_id); 
			}
			//$array = array('a.status' => 16, 'a.payment_status' => 'confirmed');

			$where = "a.status='16' AND a.payment_status='confirmed' AND a.order_amount >0 OR a.status='17' AND a.payment_status='canceled' AND a.order_amount >0";
			$this->db->where($where); 
			
			$query = $this->db->get();
			$result = array();
			//echo $this->db->last_query();exit;
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		
	}

}

/* End of file Payments_model.php */
/* Location: ./system/spotneat/models/Payments_model.php */