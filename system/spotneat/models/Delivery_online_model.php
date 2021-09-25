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
 * deliver_checkin Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\deliver_checkin_model.php
 * @link           http://docs.spotneat.com
 */
class Delivery_online_model extends TI_Model {

	public function getCount($filter = array()) {
		
		

		$this->db->from('deliver_checkin');
		$this->db->join('delivery', 'delivery.delivery_id = deliver_checkin.delivery_id', 'left');
		$this->db->where('checkin_status', 1);

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		
			$this->db->select('*');
			$this->db->from('deliver_checkin');
			$this->db->join('delivery', 'delivery.delivery_id = deliver_checkin.delivery_id', 'left');
			

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		
	}

	public function getDeliveryOnline() {
		$this->db->from('deliver_checkin');
		$this->db->join('delivery', 'delivery.delivery_id = deliver_checkin.delivery_id', 'left');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
	public function getDeliveryOnlin($staffid='') {
		$this->db->from('deliver_checkin');
		$this->db->join('delivery', 'delivery.delivery_id = deliver_checkin.delivery_id', 'left');	
		$this->db->group_by('deliver_checkin.delivery_id');
		$this->db->where('deliver_checkin.checkin_status',1);
		if($getStaffId!='11'){
			$this->db->where('delivery.added_by',$staffid);
		}
		$this->db->order_by('deliver_checkin.delivery_id','DESC');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		return $result;
	}
	public function getDeliveryCount($getStaffId=''){
		$this->db->from('deliver_checkin');
		$this->db->join('delivery', 'delivery.delivery_id = deliver_checkin.delivery_id', 'left');
		$this->db->group_by('deliver_checkin.delivery_id');
		$this->db->where('deliver_checkin.checkin_status',1);
		if($getStaffId!='11'){
			$this->db->where('delivery.added_by',$staffid);
		}
		$this->db->order_by('deliver_checkin.delivery_id','DESC');
		
		$query = $this->db->get();
		$result = array();
		return $query->num_rows();
	}

	public function getDeliveriesOnline($delivery_id) {
		$result = array();
		if ($delivery_id) {
			$this->db->select('*');
			$this->db->from('deliver_checkin');
			$this->db->join('delivery', 'delivery.delivery_id = deliver_checkin.delivery_id', 'left');
			
			$this->db->where('deliver_checkin.delivery_id', $delivery_id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		}

		return $result;
	}

	public function getLastOnline($ip) {
		if ($this->input->valid_ip($ip)) {
			$this->db->select('*');
			$this->db->select_max('date_added');
			$this->db->from('deliver_checkin');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getOnlineDates($filter = array()) {
		$this->db->select('*');
		$this->db->from('deliver_checkin');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
}

/* End of file delivery_model.php */
/* Location: ./system/spotneat/models/delivery_model.php */