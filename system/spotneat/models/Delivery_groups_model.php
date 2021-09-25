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
 * delivery_groups Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\delivery_groups_model.php
 * @link           http://docs.spotneat.com
 */

class Delivery_groups_model extends TI_Model {

	public function getCount($filter = array()) {
		$this->db->from('delivery_groups');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('delivery_groups');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getDeliveryGroups() {
		$this->db->from('delivery_groups');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getDeliveryGroup($delivery_group_id) {
		$this->db->from('delivery_groups');

		$this->db->where('delivery_group_id', $delivery_group_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function saveDeliveryGroup($delivery_group_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['group_name'])) {
			$this->db->set('group_name', $save['group_name']);
		}

		if (isset($save['description'])) {
			$this->db->set('description', $save['description']);
		}

		if (isset($save['approval']) AND $save['approval'] === '1') {
			$this->db->set('approval', $save['approval']);
		} else {
			$this->db->set('approval', '0');
		}

		if (is_numeric($delivery_group_id)) {
			$this->db->where('delivery_group_id', $delivery_group_id);
			$query = $this->db->update('delivery_groups');
		} else {
			$query = $this->db->insert('delivery_groups');
			$delivery_group_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($delivery_group_id)) ? $delivery_group_id : FALSE;
	}

	public function deleteDeliveryGroup($delivery_group_id) {
		if (is_numeric($delivery_group_id)) $delivery_group_id = array($delivery_group_id);

		if ( ! empty($delivery_group_id) AND ctype_digit(implode('', $delivery_group_id))) {
			$this->db->where_in('delivery_group_id', $delivery_group_id);
			$this->db->delete('delivery_groups');

			return $this->db->affected_rows();
		}
	}
}

/* End of file delivery_groups_model.php */
/* Location: ./system/spotneat/models/delivery_groups_model.php */