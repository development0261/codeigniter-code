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
 * Mealtimes Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Mealtimes_model.php
 * @link           http://docs.spotneat.com
 */
class Mealtimes_model extends TI_Model {

	public function getMealtimes() {
		$this->db->from('mealtimes');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getMealtime($mealtime_id) {
		$this->db->from('mealtimes');

		$this->db->where('mealtime_id', $mealtime_id);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function updateMealtimes($mealtimes = array()) {
		$query = FALSE;

		if ( ! empty($mealtimes)) {
			foreach ($mealtimes as $mealtime) {

				$this->db->set('mealtime_name', $mealtime['mealtime_name']);
				$this->db->set('start_time', mdate('%H:%i', strtotime($mealtime['start_time'])));
				$this->db->set('end_time', mdate('%H:%i', strtotime($mealtime['end_time'])));
				$this->db->set('mealtime_status', $mealtime['mealtime_status']);

				if ( ! empty($mealtime['mealtime_id']) AND $mealtime['mealtime_id'] > 0) {
					$this->db->where('mealtime_id', $mealtime['mealtime_id']);
					$this->db->update('mealtimes');
				} else {
					$this->db->insert('mealtimes');
				}
			}

			$query = TRUE;
		}

		return $query;
	}
}

/* End of file Mealtimes_model.php */
/* Location: ./system/spotneat/models/Mealtimes_model.php */