<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Activities_model extends CI_Model {

	public function getCount($filter = array()) {
		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}
		$this->db->where('user_id !=', 11,FALSE);

		$this->db->from('activities');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('activities');

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}
			$this->db->where('user_id !=', 11,FALSE);
			$this->db->order_by('date_added', 'DESC');

			$query = $this->db->get();
			$result = $sort_result = array();

			if ($query->num_rows() > 0) {
				return $query->result_array();
			}

			return $result;
		}
	}

	public function getActivities() {
		$this->db->from('activities');
		$this->db->order_by('date_added', 'DESC');

		$query = $this->db->get();
		$activities = array();

		if ($query->num_rows() > 0) {
			$activities = $query->result_array();
		}

		return $activities;
	}
	public function GetTable($tablename,$condition=''){
 
		$this->db->select('*');
		$this->db->from($tablename);
		if($condition!="") {
			$this->db->where($condition);
		}	
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			return $result[0]['value'];
			//print_r($result);
			//return $result;
		} else {
		 return FALSE;
		}
	}
	public function logActivity($user_id, $action, $context, $message) {
		if (method_exists($this->router, 'fetch_module')) {
			$this->_module = $this->router->fetch_module();
		}

		if (is_numeric($user_id) AND is_string($action) AND is_string($message)) {
			// set the current domain (e.g admin, main, module)
			//$domain = ( ! empty($this->_module)) ? 'module' : APPDIR;

			// set user if customer is logged in and the domain is not admin
			$user = 'customer';
			/*if ($domain !== ADMINDIR) {
				$this->load->library('customer');
				if ($this->customer->islogged()) {
					$user = 'customer';
				}
			}*/
			
			
			 $time_zone = $this->GetTable('settings','item = "timezone"');
       
       		date_default_timezone_set($time_zone);
       		date_default_timezone_get();

			
			$this->db->set('user', $user);
			$this->db->set('domain', 'mobile');
			$this->db->set('context', $context);

			if (is_numeric($user_id)) {
				$this->db->set('user_id', $user_id);
			}

			if (is_string($action)) {
				$this->db->set('action', $action);
			}

			if (is_string($message)) {
				$this->db->set('message', $message);
			}

			$this->db->set('date_added', date("Y-m-d H:i:s "));

			$this->db->insert('activities');
		}
	}

	public function getMessage($lang, $search = array(), $replace = array()) {
		$this->lang->load('activities');

		return str_replace($search, $replace, $this->lang->line($lang));
	}
}

