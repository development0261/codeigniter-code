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
class Ptcertificates_model extends CI_Model {

	public function __construct() {
        parent::__construct();

        //load database library
        $this->load->database();
    }

	/*
	* Get All Certificates
	*/
	public function getAllCertificates()
	{
		$this->db->select('*');
		$this->db->from('ptcertificates');
		$this->db->order_by('certificate_name');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}
	
	/*
	* Get All Certificates by trainer id
	*/
	public function getCertificatesByTrainerId($trainer_id = '')
	{
		$this->db->select('t.pt_certificate_id, t.certificate_name');
		$this->db->from('ptcertificates t');
		$this->db->join('pttrainer_certificates tp','t.pt_certificate_id = tp.pt_certificate_id','inner');
		$this->db->where("tp.trainer_id = '".$trainer_id."'");
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Check Email exists or not
	*/
	public function check_trainer_exists($trainer_id = '') {

		$this->db->select('trainer_id');
		$this->db->from('trainers');
		$this->db->where('trainer_id', $trainer_id);
		$query = $this->db->get();
		return $query->num_rows();

	}

	
    public function updateCertificates($userData = array(), $trainer_id = '') {
    	
    	if (!empty($userData['pt_certificates']) AND $trainer_id) {			 
            foreach ($userData['pt_certificates'] as $key => $item) {				
				if (!empty($item['id'])) {
					// Get certificate 
					$this->db->select('pt_trainer_certificate_id');
					$this->db->from('pttrainer_certificates');
					$this->db->where('trainer_id', $trainer_id);
					$this->db->where('pt_certificate_id	', $item['id']);
					$query = $this->db->get();
					if($query->num_rows() > 0){						
						$this->db->where('trainer_id', $trainer_id);
						$this->db->where('pt_certificate_id',  $item['id']);
						$this->db->delete('pttrainer_certificates');			
					} else {						
						$this->db->set('trainer_id', $trainer_id);
						$this->db->set('pt_certificate_id', $item['id']);
						$this->db->set('status', '1');
						$this->db->set('date_added', date('Y-m-d h:i:s'));
						$this->db->insert('pttrainer_certificates');
					}					
				}	
            }
            
            
            return TRUE;
        }
    }

	public function updateServices($userData = array(), $trainer_id = '') {
    	
    	if (!empty($userData['pt_services']) AND $trainer_id) {			 
            foreach ($userData['pt_services'] as $key => $item) {					
				if (!empty($item['id'])) {
				// Get certificate 
				$this->db->select('pt_trainer_service_id');
				$this->db->from('pttrainer_services');
				$this->db->where('trainer_id', $trainer_id);
				$this->db->where('pt_service_id	', $item['id']);
				$query = $this->db->get();
				if($query->num_rows() > 0){						
					$this->db->where('trainer_id', $trainer_id);
					$this->db->where('pt_service_id',  $item['id']);
					$this->db->delete('pttrainer_services');			
				} else {
					$this->db->set('trainer_id', $trainer_id);
					$this->db->set('pt_service_id', $item['id']);
					$this->db->set('status', '1');
					$this->db->set('date_added', date('Y-m-d h:i:s'));
					$this->db->insert('pttrainer_services');
				}
				}	
            }
            
            
            return TRUE;
        }
    }
}