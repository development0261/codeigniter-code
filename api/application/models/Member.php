<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database();

    }

    /*
     * Fetch user data
     */
    function getRows($id = ""){
        if(!empty($id)){
            $query = $this->db->get_where('users', array('id' => $id));
            return $query->row_array();
        }else{
            $query = $this->db->get('users');
            return $query->result_array();
        }
    }
    
    /*
     * Insert user data
     */
    public function insert($data = array()) {
        
        $insert = $this->db->insert('tyehnd0gd_customers', $data);
        if($insert){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    /*
     * Update user data
     */
    public function update($data, $id) {
        if(!empty($data) && !empty($id)){
            if(!array_key_exists('modified', $data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }
            $update = $this->db->update('users', $data, array('id'=>$id));
            return $update?true:false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete user data
     */
    public function delete($id){
        $delete = $this->db->delete('users',array('id'=>$id));
        return $delete?true:false;
    }

    public function loginStaff($username, $password,$franchise_id,$deviceid) {
		$this->db->select('users.user_id,users.username,staffs.staff_email,staffs.staff_group_id,theme_color.logo,theme_color.site_color,staffs.staff_id,staffs.staff_name,staffs.date_added,staffs.language_id,staffs.staff_telephone,locations.location_id,locations.added_by,locations.location_image');
		$this->db->from('users');
        $this->db->join('staffs', 'staffs.staff_id = users.staff_id', 'left');
        $this->db->join('locations', 'locations.location_email = staffs.staff_email', 'left');
		$this->db->join('theme_color', 'theme_color.staff_id = users.staff_id', 'left');

        $this->db->where('staffs.staff_group_id !=', '13');
        if(!empty($franchise_id))  $this->db->where('locations.added_by', $franchise_id);
        $this->db->where('username', strtolower($username));
		$this->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $password . '")))))', FALSE);
		$this->db->where('staff_status', '1');

		$query = $this->db->get();
		if ($query->num_rows() === 1) {
            $row = $query->row_array();
            $this->session->set_userdata('cust_info', array(
				'customer_id' 	=> $row['staff_id'],
				'username'			=> $username
			));
			
	  		return $row;
		} else {
      		return FALSE;
		}
	}
    
    public function insertDeviceId($username,$deviceid,$deviceInfo) {
        $this->db->set('deviceid', $deviceid);
        $this->db->set('deviceInfo', $deviceInfo);
        $this->db->where('username', $username);
        $query = $this->db->update('users');
    }
    /*
    * Check customer email
    */
    public function checkcustomeremail($email) {

		$this->db->from('customers');
		$this->db->where('email', strtolower($email));

		$query = $this->db->get();
		if ($query->num_rows() === 1) {	
	  		return TRUE;
		} else {
      		return FALSE;
		}
	}

    /*
    * Check restaurant email
    */
    public function checkrestaurantemail($email) {

		$this->db->from('staffs');
		$this->db->where('staff_email', strtolower($email));

		$query = $this->db->get();
		if ($query->num_rows() === 1) {	
	  		return TRUE;
		} else {
      		return FALSE;
		}
	}

}
?>