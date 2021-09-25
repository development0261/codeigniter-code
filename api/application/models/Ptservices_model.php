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
 * Trainer Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Staff_groups_model.php
 * @link           http://docs.spotneat.com
 */
class Ptservices_model extends CI_Model {

	public function __construct() {
        parent::__construct();

        //load database library
        $this->load->database();
    }

	/*
	* Get All Services
	*/
	public function getAllServices()
	{
		$this->db->select('*');
		$this->db->from('ptservices');
		$this->db->order_by('service_name');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	/*
	* Get All Services by trainer id
	*/
	public function getServicesByTrainerId($trainer_id = '')
	{
		$this->db->select('t.pt_service_id, t.service_name');
		$this->db->from('ptservices t');
		$this->db->join('pttrainer_services tp','t.pt_service_id = tp.pt_service_id','inner');
		$this->db->where("tp.trainer_id = '".$trainer_id."'");
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}
}