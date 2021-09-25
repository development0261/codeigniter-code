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
class Ptclients_model extends CI_Model {

	public function __construct() {
        parent::__construct();

        //load database library
        $this->load->database();
    }
	/*
	* Get Trainers List
	*/
	public function getTrainersList()
	{
		$where = "status = '1'";
		if(!empty($added_by)){
			$where = "status = '1' AND added_by = $added_by ";
		}

		$this->db->select('trainer_id, first_name, last_name, trainer_short_info, profile_picture, main_image, followCount, rating');
		$this->db->from('trainers');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainer Details by ID
	*/
	public function getTrainerDetails($trainer_id = '')
	{
		$where = "status = '1'";
		if(!empty($trainer_id)){
			$where = "`status` = '1' AND `trainer_id` = $trainer_id ";
		}

		$this->db->select('trainer_id, first_name, last_name, email, telephone, skype, gender, country, city, device_time_zone, timezone, trainer_short_info, trainer_key_points, about_trainer, profile_picture, main_image, instagram_link, followCount, rating, vidoes, courses');
		$this->db->from('trainers');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Add/Update client data
	*/

	public function AddClient($pt_client_id, $save = array()) {

		if (empty($save)) return FALSE;

		if (isset($save['trainer_id'])) {
			$this->db->set('trainer_id', $save['trainer_id']);
		}

		if (isset($save['first_name'])) {
			$this->db->set('first_name', $save['first_name']);
		}

		if (isset($save['last_name'])) {
			$this->db->set('last_name', $save['last_name']);
		}
		
		if (isset($save['email'])) {
			$this->db->set('email', $save['email']);
		}

		if (isset($save['phone'])) {
			$this->db->set('phone', $save['phone']);
		}

		if (is_numeric($pt_client_id)) {
			$action = 'updated';
			$this->db->where('pt_client_id', $pt_client_id);
			$query = $this->db->update('ptclients');
			return true;
			exit;
		} else {
			$this->db->set('date_added', date('Y-m-d H:i:s'));
			$this->db->set('status', '1');
			$action = 'added';
			$query = $this->db->insert('ptclients');
			$pt_client_id = $this->db->insert_id();
			return $pt_client_id;
			exit;
		}

		return $pt_client_id;
	}
	
	/*
	* Add/Update client data
	*/

	public function clientProgramRelation($clients_program_id = '', $save = array()) {

		if (empty($save)) return FALSE;
		
		if (isset($save['pt_client_id'])) {
			$this->db->set('pt_client_id', $save['pt_client_id']);
		}

		if (isset($save['trainer_program_id'])) {
			$this->db->set('trainer_program_id', $save['trainer_program_id']);
		}

		if (isset($save['program_category_id'])) {
			$this->db->set('pt_client_program_category_id', $save['program_category_id']);
		}

		if (isset($save['custom_values'])) {
			$this->db->set('custom_values', json_encode($save['custom_values']));
		}

		if (is_numeric($clients_program_id)) {
			$action = 'updated';
			$this->db->where('clients_program_id', $clients_program_id);
			$query = $this->db->update('ptclients_program_relation');
			
			// Insert program into schedule
			$this->addProgramSchedule($clients_program_id, $save);
			return true;
			exit;
		} else {
			$this->db->set('date_added', date('Y-m-d H:i:s'));
			$this->db->set('status', '1');
			$action = 'added';
			$query = $this->db->insert('ptclients_program_relation');
			$clients_program_id = $this->db->insert_id();
			// Insert program into schedule
			$this->addProgramSchedule($clients_program_id, $save);

			return $clients_program_id;
			exit;
		}

		return $clients_program_id;
	}	

	/*
	* Add program schedule
	*/

	public function addProgramSchedule($clients_program_id = '', $save = array()) {
		
		if (empty($save)) return FALSE;

		if(!empty($save['schedule_date'])){
			// Delete existing records
			$this->db->where_in('clients_program_id', $clients_program_id);
			$this->db->where_in('pt_client_id', $save['pt_client_id']);
			$this->db->where_in('trainer_program_id', $save['pt_client_id']);
			$this->db->delete('ptclients_program_schedule');
			
			// Insert records
			foreach($save['schedule_date'] as $key=>$value){
				if (isset($clients_program_id)) {
					$this->db->set('clients_program_id', $clients_program_id);
				}

				if (isset($save['pt_client_id'])) {
					$this->db->set('pt_client_id', $save['pt_client_id']);
				}

				if (isset($save['trainer_program_id'])) {
					$this->db->set('trainer_program_id', $save['trainer_program_id']);
				}

				if (isset($save['program_category_id'])) {
					$this->db->set('pt_client_program_category_id', $save['program_category_id']);
				}

				$this->db->set('date_added', date('Y-m-d H:i:s'));
				$this->db->set('status', '1');
		
				$this->db->set('schedule_date', $value['date']);
				$query = $this->db->insert('ptclients_program_schedule');
			}
		}
		return true;
		exit;	
	}

	/*
	* Add/Update client data
	*/

	public function addClientGoal($pt_client_goal_module_id = '', $save = array()) {

		if (empty($save)) return FALSE;
		
		if (isset($save['pt_client_id'])) {
			$this->db->set('pt_client_id', $save['pt_client_id']);
		}

		if (isset($save['trainer_id'])) {
			$this->db->set('trainer_id', $save['trainer_id']);
		}

		if (isset($save['title'])) {
			$this->db->set('title', $save['title']);
		}

		if (isset($save['order'])) {
			$this->db->set('order', $save['order']);
		}

		if (isset($save['progress_percent'])) {
			$this->db->set('progress_percent', $save['progress_percent']);
		}

		if (is_numeric($pt_client_goal_module_id)) {
			$action = 'updated';
			$this->db->where('pt_client_goal_module_id', $pt_client_goal_module_id);
			$query = $this->db->update('ptclients_goal_module');
			// Change item order		
			if(!empty($save['new_order'])){

				foreach($save['new_order'] as $key=>$value){
					$this->db->set('order', $value['order']);
					$this->db->where('pt_client_goal_module_id', $value['id']);
					$query = $this->db->update('ptclients_goal_module');
				}
				
			}		
			return true;
			exit;
		} else {
			$this->db->set('date_added', date('Y-m-d H:i:s'));
			$this->db->set('status', '1');
			$action = 'added';
			$query = $this->db->insert('ptclients_goal_module');
			$pt_client_goal_module_id = $this->db->insert_id();
			// Update order
			$this->db->set('order', $pt_client_goal_module_id);
			$this->db->where('pt_client_goal_module_id', $pt_client_goal_module_id);
			$query = $this->db->update('ptclients_goal_module');

			return $pt_client_goal_module_id;
			exit;
		}

		return $pt_client_goal_module_id;
	}	

	/*
	* Get Client list by trainer_id
	*/
	public function getClientListByTrainerId($trainer_id = '', $status = '', $is_deleted = '')
	{
		$this->db->select('*');
		$this->db->from('ptclients');
		$this->db->where("trainer_id = '".$trainer_id."'");
		if($status!='')
		{
			$this->db->where("status = ".$status);
		}
		if($is_deleted != '')
		{
			$this->db->where("is_deleted = ".$is_deleted);
		}
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Client list by client_id
	*/
	public function getClientdetails($pt_client_id = '', $status = '', $is_deleted = '')
	{
		$this->db->select('*');
		$this->db->from('ptclients');
		$this->db->where("pt_client_id = '".$pt_client_id."'");
		if($status!='')
		{
			$this->db->where("status = ".$status);
		}
		if($is_deleted != '')
		{
			$this->db->where("is_deleted = ".$is_deleted);
		}
		$query = $this->db->get();
		return $query;
	}

	/*
	* Get Client Goal list by client id
	*/
	public function getClientGoalListByClientId($pt_client_id = '')
	{
		$this->db->select('*');
		$this->db->from('ptclients_goal_module');
		$this->db->where('status', '1');
		$this->db->order_by('order', 'ASC');
		$this->db->where("pt_client_id = '".$pt_client_id."'");
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainig Program list by client id
	*/
	public function getProgramListByClientId($pt_client_id = '', $program_category_id = '')
	{
		$this->db->select('pr.clients_program_id, tp.trainer_program_id, tp.program_name, tp.program_picture, tp.program_short_description, pr.custom_values');
		$this->db->from('ptclients_program_relation pr');
		$this->db->join('trainer_programs tp', 'tp.trainer_program_id = pr.trainer_program_id');
		if(!empty($pt_client_id)){
			$this->db->where('pr.pt_client_id',$pt_client_id);
		}
		if(!empty($program_category_id)){
			$this->db->where('pr.pt_client_program_category_id',$program_category_id);
		}
		$query = $this->db->get();
		
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainig Program list by program id
	*/
	public function getProgramListByProgramId($save = array())
	{
		$this->db->select('pr.clients_program_id, pr.custom_values');
		$this->db->from('ptclients_program_relation pr');
		$this->db->join('trainer_programs tp', 'tp.trainer_program_id = pr.trainer_program_id');

		if(!empty($save['trainer_program_id'])){
			$this->db->where('pr.trainer_program_id',$save['trainer_program_id']);
		}
		if(!empty($save['pt_client_id'])){
			$this->db->where('pr.pt_client_id',$save['pt_client_id']);
		}
		if(!empty($save['pt_client_program_category_id'])){
			$this->db->where('pr.pt_client_program_category_id',$save['pt_client_program_category_id']);
		}


		if(!empty($save['clients_program_id'])){
			$this->db->where('pr.clients_program_id',$save['clients_program_id']);
		}

		
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainig Program videos by program id
	*/
	public function getProgramVideosProgramId($save = array())
	{
		$this->db->select('video_url');
		$this->db->from('pttrainer_program_videos pr');
		$this->db->join('trainer_programs tp', 'tp.trainer_program_id = pr.trainer_program_id');

		if(!empty($save['trainer_program_id'])){
			$this->db->where('pr.trainer_program_id',$save['trainer_program_id']);
		}
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainig Program list Group By date
	*/
	public function getProgramListGroupByDate($pt_client_id = '')
	{
		$this->db->select('pr.clients_program_id, pr.pt_client_id, pr.pt_client_program_category_id, tp.trainer_program_id, tp.program_name, tp.program_picture, tp.program_short_description, pr.schedule_date, pc.category_name');
		$this->db->from('trainer_programs tp');
		$this->db->join('ptclients_program_schedule pr', 'tp.trainer_program_id = pr.trainer_program_id');
		$this->db->join('ptclients_program_categories pc', 'pc.pt_client_program_category_id = pr.pt_client_program_category_id');
		if(!empty($pt_client_id)){
			$this->db->where('pr.pt_client_id',$pt_client_id);
		}
		$query = $this->db->get();
		
		if ($query->num_rows()) {
			$packageinfo = $query->result_array();
			// GEt Sets & Reps of each program
			foreach($packageinfo as $key=>$value){
				$sets_rests = $this->getProgramListByProgramId($value);				
				if(!empty($sets_rests)){
					foreach($sets_rests as $key_info=>$value_info){
						$sets_rests[$key_info]['custom_values'] = !empty($value_info['custom_values'])?json_decode($value_info['custom_values']):array();
					}
				}				
				$packageinfo[$key]['sets_rests'] = !empty($sets_rests)?$sets_rests:array();

				$videos = $this->getProgramVideosProgramId($value);
				$packageinfo[$key]['videos'] = !empty($videos)?$videos:array();
			}
			return $packageinfo;
		}else{
			return array();
		}
	}

	/*
	* Delete goal data
	*/

	public function deleteClientGoal($pt_client_goal_module_id = '') {

		if (is_numeric($pt_client_goal_module_id)) {
			$action = 'updated';
			$this->db->set('status', '0');
			$this->db->where('pt_client_goal_module_id', $pt_client_goal_module_id);
			$query = $this->db->update('ptclients_goal_module');
			return true;
			exit;
		} 

		return $pt_client_goal_module_id;
	}	

	/*
	* Get Client Program Categories
	*/
	public function programCategories()
	{
		$this->db->select('pt_client_program_category_id as program_category_id, category_name, category_image');
		$this->db->from('ptclients_program_categories');
		$this->db->where("status", "1");
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Check Trainer Program Relation exists or not
	*/
	public function check_program_relation_exists($userData = array()) {

		$this->db->select('clients_program_id');
		$this->db->from('ptclients_program_relation');
		$this->db->where('clients_program_id', $userData['clients_program_id']);
		$this->db->where('pt_client_id', $userData['pt_client_id']);
		$this->db->where('trainer_program_id', $userData['trainer_program_id']);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}

	}

	/*
	* Activate deactivate client
	*/
	public function UpdateClientStatus($save)
	{
		if($save['status'] == 'Activate')
		{
			$this->db->set('status', 1);
		}
		else
		{
			$this->db->set('status', 0);
		}
		$this->db->where('pt_client_id', $save['trainer_id']);
		return $query = $this->db->update('ptclients');
	}
	/*
	* Remove client
	*/
	public function RemoveClient($save)
	{
		$this->db->set('is_deleted', 0);
		$this->db->where('pt_client_id', $save['trainer_client_id']);
		return $query = $this->db->update('ptclients');
	}

}