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
 * Reservations Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Reservations_model.php
 * @link           http://docs.spotneat.com
 */
class Cancel_policy_model extends TI_Model {

	public function getPolicy($loc_id) {

		$this->db->select('*');		
		$this->db->from('locations');
		$this->db->where('location_id', $loc_id);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();			
		}

	return $row;
	}
}

/* End of file reservations_model.php */
/* Location: ./system/spotneat/models/reservations_model.php */