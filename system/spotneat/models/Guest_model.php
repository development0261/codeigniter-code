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
class Guest_model extends TI_Model {

	public function getReservationDetails($res_id,$email){
			$this->db->select('*');
			$this->db->from('reservations');
			$this->db->join('locations','locations.location_id = reservations.location_id','left');
			$array = array('reservation_id' => $res_id , 'email' => $email);
			$this->db->where($array);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
			}
			return $row;
	}
	public function checkReservation($res_id,$uniqueid)
	{
		
			$this->db->from('reservations');
			$array = array('reservation_id' => $res_id , 'otp' => $uniqueid);
			$this->db->where($array);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return TRUE;
			}
			else{
				return FALSE;
			}
			
	}

}