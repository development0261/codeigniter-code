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
 * Categories Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Categories_model.php
 * @link           http://docs.spotneat.com
 */
class Delivery_payout_model extends TI_Model {

	public function getList($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			// echo 'alkdshkj';
			// exit;
				$this->db->like('first_name', $filter['filter_search']);
				$this->db->or_like('email', $filter['filter_search']);
				// $this->db->or_like('email', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}
			if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
			
			} else {
				$filter['page'] = 0;
			}
			$this->db->limit($filter['limit'], $filter['page']);
			$this->db->from('delivery');
			
			$query = $this->db->get();

			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
	}
	public function getUser($delivery_id=null) {

		if (is_numeric($delivery_id)) {			
			$this->db->where('delivery_id', $delivery_id);
			$query = $this->db->get('delivery');
			$result = $query->row_array();
			
			// print_r($result);
			// exit;
			// $this->db->from('delivery_history');
			// $this->db->where('deliver_id', $delivery_id);
			// $this->db->where('status', 'pending');

			// $query = $this->db->get();

			// if ($query->num_rows() > 0) {
			// 	$result = $query->result_array();
			// }
			return $result;
		}
	}
	public function getPendinglist($filter = array()) {

		// print_r($filter);
		// exit;
		if ( ! empty($filter['filter_search'])) {
			// echo 'alkdshkj';
			// exit;
				$this->db->like('invoice_id', $filter['filter_search']);
				// $this->db->or_like('last_name', $filter['filter_search']);
				// $this->db->or_like('email', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}
			$this->db->where('status', 'pending');
			$this->db->where('deliver_id', $filter['deliver_id']);
			if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
			
			} else {
				$filter['page'] = 0;
			}
			$this->db->limit($filter['limit'], $filter['page']);
			$this->db->from('delivery_history');
			
			$query = $this->db->get();
			
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
	}
	public function getcompletedlist($filter = array()) {

		// print_r($filter);
		// exit;
		if ( ! empty($filter['filter_search'])) {
			// echo 'alkdshkj';
			// exit;
				$this->db->like('invoice_id', $filter['filter_search']);
				// $this->db->or_like('last_name', $filter['filter_search']);
				// $this->db->or_like('email', $filter['filter_search']);
			}

		if ( ! empty($filter['filter_status']) && $filter['filter_status'] == 'completed') {
			$this->db->where('status', 'completed');
		}
		if ( ! empty($filter['filter_status']) && $filter['filter_status'] == 'rejected') {
			$this->db->where('status', 'rejected');
		}
			
			$this->db->where('deliver_id', $filter['deliver_id']);
			
			$this->db->from('delivery_history');
			if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
			$this->db->limit($filter['limit'], $filter['page']);
			} else {
				$filter['page'] = 0;
				$this->db->limit($filter['limit'], $filter['page']);
			}
			
			$query = $this->db->get();
			
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
	}
	public function getPendinghistory($delivery_id=null) {


		if (is_numeric($delivery_id)) {
			$this->db->select('SUM(amount) AS amount', FALSE);
			$this->db->where('deliver_id', $delivery_id);
			$this->db->where('status', 'pending');
			$this->db->group_by('deliver_id');
			$query = $this->db->get('delivery_history');

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
			}
			
			// print_r($result);
			// exit;
			// $this->db->from('delivery_history');
			// $this->db->where('deliver_id', $delivery_id);
			// $this->db->where('status', 'pending');

			// $query = $this->db->get();

			// if ($query->num_rows() > 0) {
			// 	$result = $query->result_array();
			// }
			return $result;
		}
	}

	public function getPending($delivery_id=null) {


		if (is_numeric($delivery_id)) {
			$array = array('deliver_id' => $delivery_id, 'status' => 'pending');
			$this->db->where($array);
			$query = $this->db->get('delivery_history');

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
			
			// print_r($result);
			// exit;
			// $this->db->from('delivery_history');
			// $this->db->where('deliver_id', $delivery_id);
			// $this->db->where('status', 'pending');

			// $query = $this->db->get();

			// if ($query->num_rows() > 0) {
			// 	$result = $query->result_array();
			// }
			return $result;
		}
	}

	public function getCompleted($delivery_id=null) {


		if (is_numeric($delivery_id)) {
			$array = array('deliver_id' => $delivery_id, 'status' => 'completed');
			$this->db->where($array);
			$query = $this->db->get('delivery_history');

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
			
			// print_r($result);
			// exit;
			// $this->db->from('delivery_history');
			// $this->db->where('deliver_id', $delivery_id);
			// $this->db->where('status', 'pending');

			// $query = $this->db->get();

			// if ($query->num_rows() > 0) {
			// 	$result = $query->result_array();
			// }
			return $result;
		}
	}

	public function getPayouts($delivery_id) {
		if (is_numeric($delivery_id)) {
			$this->db->from('delivery');
			$this->db->where('delivery_id', $delivery_id);


			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getHistoryid() {
		$this->db->from('delivery_history');
		$this->db->order_by("id", "desc");
		$query = $this->db->get(); 
		$history =  $query->row_array();

		return $history['id'];
	}

	public function insertHistory($data=array()) {
		$insert = $this->db->insert('delivery_history', $data); 	
		return $insert;
	}

	public function selectHistory($history_id) {
		if (is_numeric($history_id)) {
			$array = array('id' => $history_id);
			$this->db->where($array);
			$query = $this->db->get('delivery_history');

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
			}
			
		}
		return $result;
	}

	public function updateDelivery($delivery_id,$data=array()) {
		$this->db->where('delivery_id', $delivery_id);
        $update = $this->db->update('delivery', $data);

		return $update;
	}

	public function updateHistory($history_id,$data=array()) {
		$this->db->where('id', $history_id);
        $update = $this->db->update('delivery_history', $data);

		return $update;
	}

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('first_name', $filter['filter_search']);
			$this->db->or_like('email', $filter['filter_search']);
		}

		if (is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}
		$this->db->from('delivery');

		return $this->db->count_all_results();
		
	}

public function getPendingCount($filter = array()) {
			// print_r($filter);
			// exit;
			if ( ! empty($filter['filter_search'])) {
			// echo 'alkdshkj';
			// exit;
				$this->db->like('invoice_id', $filter['filter_search']);
				// $this->db->or_like('last_name', $filter['filter_search']);
				// $this->db->or_like('email', $filter['filter_search']);
			}

			$this->db->where('status', 'pending');
			$this->db->where('deliver_id', $filter['deliver_id']);
			$this->db->from('delivery_history');
			
			return $this->db->count_all_results();
	
}
public function getCompletedCount($filter = array()) {
			if ( ! empty($filter['filter_search'])) {
				$this->db->like('invoice_id', $filter['filter_search']);
			}

			if ( ! empty($filter['filter_status']) && $filter['filter_status'] == 'completed') {
			$this->db->where('status', 'completed');
		}
		if ( ! empty($filter['filter_status']) && $filter['filter_status'] == 'rejected') {
			$this->db->where('status', 'rejected');
		}
			$this->db->where('deliver_id', $filter['deliver_id']);
			$this->db->from('delivery_history');
			
			return $this->db->count_all_results();
	
}
}

/* End of file categories_model.php */
/* Location: ./system/spotneat/models/categories_model.php */