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
class Vendor_model extends TI_Model {
	
	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('staff_name', $filter['filter_search']);
		}

		if (is_numeric($filter['filter_status'])) {
			$this->db->where('staff_status', $filter['filter_status']);
		}
		$this->db->where('staff_group_id',12);
		$this->db->from('staffs');

		return $this->db->count_all_results();		
	}

	public function getList($filter = array()) {

		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('staffs');
			$this->db->join('locations', 'locations.added_by = staffs.staff_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('staff_name', $filter['filter_search']);
			}

			$this->db->where('staff_group_id',12);
			
			$query = $this->db->get();

			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getStaffId($email = '') {
		
		$this->db->select('staff_id');
		$this->db->from('staffs');
		$this->db->where('staff_email', $email);			
		$query = $this->db->get();

		$result = array();
		if ($query->num_rows() > 0) {
			$result = !empty($query->result_array()[0]['staff_id'])? $query->result_array()[0]['staff_id']: '';
		}
		
		return $result;		
	}

	public function resetCustomerPassword($email = '', $password = '') 
	{
		$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
		$this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
		$this->db->where('email', $email);
		$query = $this->db->update('customers');
		return true;
	}

	public function resetRestaurantPassword($email = '', $staff_id = '') 
	{
		$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
		$this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
		$this->db->where('staff_id', $staff_id);
		$query = $this->db->update('users');
		return true;
	}

}

/* End of file categories_model.php */
/* Location: ./system/spotneat/models/categories_model.php */