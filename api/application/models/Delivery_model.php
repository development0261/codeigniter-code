<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Delivery_model extends CI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('first_name', $filter['filter_search']);
			$this->db->or_like('last_name', $filter['filter_search']);
			$this->db->or_like('email', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		if ( ! empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		$this->db->from('delivery');

		return $this->db->count_all_results();
	}

	public function getDelivery($delivery_id) {
		if (is_numeric($delivery_id)) {
			$this->db->from('delivery');
			$this->db->where('delivery_id', $delivery_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->result_array()[0];
			}
		}
	}

	public function getDeliveryIdByEmail($delivery_id,$email) {
		$this->db->from('delivery');
	    $this->db->where('email', $email);
	    $this->db->where('delivery_id !=', $delivery_id);
	    $query = $this->db->get();
	    return $query->num_rows();
	}


	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('delivery');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('first_name', $filter['filter_search']);
				$this->db->or_like('last_name', $filter['filter_search']);
				$this->db->or_like('email', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}

			if ( ! empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}


	public function check_email_exists($email) {

    $this->db->from('delivery');
    $this->db->where('email', $email);
    $query = $this->db->get();
    return $query->num_rows();
    
    }

    public function check_mobile_exists($mobile) {

    $this->db->from('delivery');
    $this->db->where('telephone', $mobile);
    $query = $this->db->get();
    return $query->num_rows();
    
    }


    public function check_id_exists($delivery_id) {

    $this->db->from('delivery');
    $this->db->where('delivery_id', $delivery_id);
    $query = $this->db->get();
    return $query->num_rows();
    
    }


    public function check_address_id_exists($delivery_id,$address_id) {

     $this->db->join('delivery', 'delivery.delivery_id = addresses.delivery_id AND addresses.delivery_id='.$delivery_id.' AND addresses.address_id='.$address_id, 'inner'); 
     $query = $this->db->get('addresses');
     return $query->num_rows();
    
    }


    /*public function getDelivery() {
		$this->db->from('delivery');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}*/

	public function getDeliveries($delivery_id) {
		if (is_numeric($delivery_id)) {
			$this->db->from('delivery');
			$this->db->where('delivery_id', $delivery_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->result_array()[0];
			}
		}
	}

	public function getDeliveryDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('delivery');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getDeliveryForMessages($type) {
		$this->db->select('delivery_id, email, status');
		$this->db->from('delivery');
		$this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)
				$result[] = ($type === 'email') ? $row['email'] : $row['delivery_id'];
		}

		return $result;
	}

	public function getDeliveriesForMessages($type, $delivery_id) {
		if ( ! empty($delivery_id) AND is_array($delivery_id)) {
			$this->db->select('delivery_id, email, status');
			$this->db->from('delivery');
			$this->db->where('status', '1');
			$this->db->where_in('delivery_id', $delivery_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['email'] : $row['delivery_id'];
			}

			return $result;
		}
	}

	public function getDeliveryByGroupIdForMessages($type, $delivery_group_id) {
		if (is_numeric($delivery_group_id)) {
			$this->db->select('delivery_id, email, delivery_group_id, status');
			$this->db->from('delivery');
			$this->db->where('delivery_group_id', $delivery_group_id);
			$this->db->where('status', '1');

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['email'] : $row['delivery_id'];
			}

			return $result;
		}
	}

	public function getDeliveryByNewsletterForMessages($type) {
		$this->db->select('delivery_id, email, newsletter, status');
		$this->db->from('delivery');
		$this->db->where('newsletter', '1');
		$this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)
				$result[] = ($type === 'email') ? $row['email'] : $row['delivery_id'];

			$this->load->model('Extensions_model');
			$newsletter = $this->Extensions_model->getModule('newsletter');
			if ($type === 'email' AND !empty($newsletter['ext_data']['subscribe_list'])) {
				$result = array_merge($result, $newsletter['ext_data']['subscribe_list']);
			}
		}

		return $result;
	}

	public function getDeliveryByEmail($email) {

		$this->db->from('delivery');
		$this->db->where('email', strtolower($email));

		$query = $this->db->get();

		if ($query->num_rows() === 1) {
			$row = $query->row_array();

			return $row;
		}
	}

	public function getDeliveryByOtp($otp){

		$this->db->from('delivery');
		$this->db->where('otp', $otp);
		$query = $this->db->get();
		if ($query->num_rows() === 1) {
			$row = $query->row_array();
			return $row;
		}
	}


	public function insertDeviceId($email,$deviceid) {
			$this->db->set('deviceid', $deviceid);
			$this->db->where('email', $email);
			$query = $this->db->update('delivery');
	}

	public function resetPassword($delivery_id, $reset = array()) {
		
		if ($delivery_id AND ! empty($reset)) {

			$this->db->from('delivery');
			$this->db->where('email', strtolower($reset['email']));

			$this->db->where('status', '1');
			$query = $this->db->get();
			if ($query->num_rows() === 1) {
				$row = $query->row_array();

				$alphabet = "0123456789";
				$pass = array();
				for ($i = 0; $i < 4; $i ++) {
					$n = rand(0, strlen($alphabet) - 1);
					$pass[$i] = $alphabet[$n];
				}

				$password = implode('', $pass);
				$this->db->set('otp', $password);
				// $this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				// $this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
				$this->db->where('delivery_id', $row['delivery_id']);
				$this->db->where('email', $row['email']);

				if ($this->db->update('delivery') AND $this->db->affected_rows() > 0) {

					$data = $this->getDeliveryByEmail($row['email']);

					$this->load->helper('url');
					$mail_data['first_name'] = $row['first_name'];
					$mail_data['last_name'] = $row['last_name'];
					$mail_data['created_password'] = $password;
					$mail_data['account_login_link'] = site_url('/account/login');
					$this->load->model('Mail_templates_model');
					$lang = $this->input->post('language');
					if($lang=='arabic'){
						$registration = 'password_reset_ar';
					}else{
						$registration = 'password_reset_app';
					}
					$mail_template = $this->Mail_templates_model->getTemplateData('11','password_reset_app');
					$this->sendMail($row['email'], $mail_template, $mail_data);
					log_activity($row['delivery_id'], 'Password Reset', 'delivery','<a href="'.site_url().'admin/delivery/edit?id='.$row['delivery_id'].'">'.$row['first_name'] .' '.$row['last_name'].'</a> <b>Password Reset</b>.');
					return $data;
				}
			}
		}

		return FALSE;
	}

	public function setpassword($password, $reset = array()){

		if ($password AND ! empty($reset)) {
			$this->db->from('delivery');
			$this->db->where('email', strtolower($reset['email']));
			$this->db->where('status', '1');
			$query = $this->db->get();
			if ($query->num_rows() === 1) {
				$row = $query->row_array();
				$this->db->set('otp','');
				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
				$this->db->where('delivery_id', $row['delivery_id']);
				$this->db->where('email', $row['email']);

				if ($this->db->update('delivery') AND $this->db->affected_rows() > 0) {
					$this->load->helper('url');

					// echo $password;exit;

					$mail_data['first_name'] = $row['first_name'];
					$mail_data['last_name'] = $row['last_name'];
					$mail_data['created_password'] = $password;
					$mail_data['account_login_link'] = site_url('/account/login');
					$this->load->model('Mail_templates_model');
					$lang = $this->input->post('language');
					if($lang=='arabic'){
						$registration = 'password_reset_ar';
					}else{
						$registration = 'password_reset';
					}
					$mail_template = $this->Mail_templates_model->getTemplateData('11','password_reset');
					$this->sendMail($row['email'], $mail_template, $mail_data);
					log_activity($row['delivery_id'], 'Password Reset', 'delivery','<a href="'.site_url().'admin/delivery/edit?id='.$row['delivery_id'].'">'.$row['first_name'] .' '.$row['last_name'].'</a> <b>Password Reset</b>.');
					return $password;
				}
			}
		}
		return FALSE;
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) && ! empty($filter_data)) {
			$this->db->from('delivery');

			if ( ! empty($filter_data['delivery_name'])) {
				$this->db->like('CONCAT(first_name, last_name)', $filter_data['delivery_name']);
			}

			if ( ! empty($filter_data['delivery_id'])) {
				$this->db->where('delivery_id', $filter_data['delivery_id']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getImageUrl($delivery_id){
		if (is_numeric($delivery_id)) {
			$this->db->from('delivery');
			$this->db->select('profile_image');
			$this->db->where('delivery_id', $delivery_id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array()[0]['profile_image'];
			}
		}
	}

	public function saveDelivery($delivery_id, $save = array()) {


		if (empty($save)) return FALSE;

		if (isset($save['first_name'])) {
			$this->db->set('first_name', $save['first_name']);
		}

		if (isset($save['last_name'])) {
			$this->db->set('last_name', $save['last_name']);
		}

		if (isset($save['email'])) {
			$this->db->set('email', strtolower($save['email']));
		}

		if (isset($save['language'])) {

			if(strtolower($save['language']) == "english"){
				$save['language'] = 11;
			}else if(strtolower($save['language']) == "arabic"){
				$save['language'] = 12;
			}

			$this->db->set('language', $save['language']);
		}

		if (isset($save['currency'])) {

			if($save['currency'] == "USD"){
				$save['currency'] = 227;
			}else if($save['currency'] == "SAR"){
				$save['currency'] = 187;
			}
			$this->db->set('currency', $save['currency']);
		}

		if (isset($save['deviceid'])) {
			$this->db->set('deviceid', strtolower($save['deviceid']));
		}

		if (isset($save['password'])) {
			$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
			$this->db->set('password', sha1($salt . sha1($salt . sha1($save['password']))));
		}

		if (isset($save['telephone'])) {
			$this->db->set('telephone', $save['telephone']);
		}

		if (isset($save['security_question_id'])) {
			$this->db->set('security_question_id', $save['security_question_id']);
		}

		if (isset($save['security_answer'])) {
			$this->db->set('security_answer', $save['security_answer']);
		}

		if (isset($save['newsletter']) AND $save['newsletter'] === '1') {
			$this->db->set('newsletter', $save['newsletter']);
		} else {
			$this->db->set('newsletter', '0');
		}

		if (isset($save['delivery_group_id'])) {
			$this->db->set('delivery_group_id', $save['delivery_group_id']);
		}

		if (isset($save['profile_image'])) {
			$this->db->set('profile_image', $save['profile_image']);
		}

		if (isset($save['bank_name'])) {
			$this->db->set('bank_name', $save['bank_name']);
		}

		if (isset($save['account_number'])) {
			$this->db->set('account_number', $save['account_number']);
		}

		if (isset($save['routing_number'])) {
			$this->db->set('routing_number', $save['routing_number']);
		}

		if (isset($save['verify_otp'])) {
			$this->db->set('verify_otp', $save['verify_otp']);
		}

		if (isset($save['date_added'])) {
			$add['date_added'] = date("Y-m-d H:i:s");
			$this->db->set('date_added', $save['date_added']);
		}

		if (is_numeric($delivery_id)) {

			$action = 'updated';
			$this->db->where('delivery_id', $delivery_id);
			$query = $this->db->update('delivery');
			return true;
			exit;
		} else {
			$this->db->set('status', '1');
			$action = 'added';
			$this->db->set('date_added', date("Y-m-d H:i:s"));
			$query = $this->db->insert('delivery');
			$delivery_id = $this->db->insert_id();
			/*return $delivery_id;
			exit;*/
		}

		if ($query === TRUE AND is_numeric($delivery_id)) {
			if (isset($save['address'])) {
				$this->saveAddress($delivery_id, $save['address']);
			}

			if ($action === 'added') {
				
				$registration_email = unserialize($this->GetTable('settings','item = "registration_email"'));
				//$registration_email = unserialize($registration_email[0]['value']);
				//echo $$registration_email;exit;

				$mail_data['first_name'] = $save['first_name'];
				$mail_data['last_name'] = $save['last_name'];
				$mail_data['site_name'] = $this->GetTable('settings','item = "site_name"');

				$mail_data['account_login_link'] = $this->config->base_url('account/login');

				$this->load->model('Mail_templates_model');
				$config_registration_email = is_array($registration_email) ? $registration_email : array();
				$mail_temp_id = $this->GetTable('settings','item = "mail_template_id"');
				//$mail_temp_id = $mail_temp_id[0]['value'];
				//print_r($config_registration_email);exit;
				
				if ($registration_email === '1' OR in_array('delivery', $config_registration_email)) {
					$lang = $this->input->post('language');
					if($lang=='arabic'){
						$registration = 'registration_ar';
					}else{
						$registration = 'registration';
					}
					$mail_template = $this->Mail_templates_model->getTemplateData($mail_temp_id, $registration);
					$this->sendMail($save['email'], $mail_template, $mail_data);
				}

				if (in_array('admin', $config_registration_email)) {
						$lang = $this->input->post('language');
					$site_email = $this->GetTable('settings','item = "site_email"');
					//$site_email = $site_email[0]['value'];
					if($lang=='arabic'){
						$registration_alert = 'registration_alert_ar';
					}else{
						$registration_alert = 'registration_alert';
					}
					$mail_template = $this->Mail_templates_model->getTemplateData($mail_temp_id, $registration_alert);
					$this->sendMail($site_email, $mail_template, $mail_data);
				}

				$this->saveDeliveryGuestOrder($delivery_id, $save['email']);
			}

			return $delivery_id;
		}
		return $delivery_id;
	}

	private function saveDeliveryGuestOrder($delivery_id, $delivery_email) {
		$query = FALSE;

		if (is_numeric($delivery_id) AND ! empty($delivery_email)) {

			$query = $this->db->from('orders')->where('email', $delivery_email)->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					if (empty($row['order_id'])) continue;

					$this->db->set('delivery_id', $delivery_id);
					$this->db->where('order_id', $row['order_id'])->where('email', $delivery_email);
					$this->db->update('orders');

					if ($row['order_type'] === '1' AND ! empty($row['address_id'])) {
						$this->db->set('delivery_id', $delivery_id);
						$this->db->where('address_id', $row['address_id']);
						$this->db->update('addresses');
					}

					if ( ! empty($row['payment'])) {
						$this->db->set('delivery_id', $delivery_id);
						$this->db->where('order_id', $row['order_id']);
						$this->db->update('pp_payments');
					}

					$this->db->set('delivery_id', $delivery_id);
					$this->db->where('order_id', $row['order_id']);
					$this->db->update('coupons_history');
				}
			}

			$this->db->set('delivery_id', $delivery_id);
			$this->db->where('email', $delivery_email);
			$this->db->update('reservations');

			$query = TRUE;
		}

		return $query;
	}

	public function saveAddress($delivery_id, $addresses = array()) {
		if ( is_numeric($delivery_id) AND ! empty($addresses)) {
			$this->db->where('delivery_id', $delivery_id);
			$this->db->delete('addresses');

			$this->load->model('Addresses_model');

			foreach ($addresses as $key => $address) {
				if (!empty($address['address_1'])) {
					$this->Addresses_model->saveAddress($delivery_id, '', $address);
				}
			}
		}
	}

	public function deleteDelivery($delivery_id) {
		if (is_numeric($delivery_id)) $delivery_id = array($delivery_id);

		if ( ! empty($delivery_id) AND ctype_digit(implode('', $delivery_id))) {
			$this->db->where_in('delivery_id', $delivery_id);
			$this->db->delete('delivery');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('delivery_id', $delivery_id);
				$this->db->delete('addresses');

				return $affected_rows;
			}
		}
	}

	public function sendMail($email, $template = array(), $data = array()) {
		if (empty($template) OR empty($email) OR !isset($template['subject'], $template['body']) OR empty($data)) {
			return FALSE;
		}

		$this->load->library('email');

		$this->email->initialize();

		$this->email->from($this->GetTable('settings','item = "site_email"'), $this->GetTable('settings','item = "site_name"'));
		$this->email->to(strtolower($email));
		$this->email->subject($template['subject'], $data);
		$this->email->set_mailtype("html");
		$body = $this->email->message($template['body'], $data);

		if ($this->email->send()) {
			return TRUE;
		} else {
			log_message('debug', $this->email->print_debugger(array('headers')));
		}
	}


	public function check_review_exists($delivery_id) {

    $this->db->from('reviews');
    $this->db->where('delivery_id', $delivery_id);
    $query = $this->db->get();
    return $query->num_rows();
    
    }

    public function check_address_exists($delivery_id) {

    $this->db->from('addresses');
    $this->db->where('delivery_id', $delivery_id);
    $query = $this->db->get();
    return $query->num_rows();
    
    }

    public function getAddress($delivery_id) {
		if (is_numeric($delivery_id)) {

			$this->db->select('addresses.*');
            
            $this->db->from('addresses');
    
            $this->db->join('delivery', 'delivery.delivery_id = addresses.delivery_id and addresses.delivery_id='.$delivery_id);

			$query = $this->db->get();

            if ($query->num_rows() > 0) {
				return $query->result_array();
			}
		}
	}


    public function getReviews($delivery_id) {
		if (is_numeric($delivery_id)) {

			$this->db->select('*');
            
            $this->db->from('reviews');
    
            $this->db->join('reservations', 'reviews.sale_id = reservations.order_id and reservations.delivery_id='.$delivery_id);

			$query = $this->db->get();

            if ($query->num_rows() > 0) {
				return $query->result_array();
			}
		}
	}

	public function validateDelivery($delivery_id) {
		if (is_numeric($delivery_id)) {
			$this->db->from('delivery');
			$this->db->where('delivery_id', $delivery_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}
	public function verifystatusupdate($delivery_id) {
			$this->db->set('verified_status', 1);
			$this->db->where('delivery_id', $delivery_id);
			$query = $this->db->update('delivery');
			return TRUE;
	}
	public function verifyotpupdate($delivery_id,$otp,$mobile = '') {
			$this->db->set('verify_otp', $otp);
			if($mobile)
			{
				$this->db->set('telephone', $mobile);
			}
			$this->db->where('delivery_id', $delivery_id);
			$query = $this->db->update('delivery');
			return TRUE;
	}

	public function GetTable($tablename,$condition=''){

		$this->db->select('*');
		$this->db->from($tablename);
		if($condition!="") {
			$this->db->where($condition);
		}	
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			return $result[0]['value'];
		} else {
		 return FALSE;
		}
	}

	public function GetAllTable($tablename,$condition=''){

		$this->db->select('*');
		$this->db->from($tablename);
		if($condition!="") {
			$this->db->where($condition);
		}	
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			return $result;
		} else {
		 return FALSE;
		}
	}

	public function GetAllTables($tablename,$condition=''){

		$this->db->select('*');
		$this->db->from($tablename);
		if($condition!="") {
			$this->db->where($condition);
		}	
		$this->db->order_by('id','desc');

		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result_array()[0];
			return $result;
		} else {
		 return FALSE;
		}
	}


	public function CheckSTable($tablename,$condition=''){

		$this->db->select('*');
		$this->db->from($tablename);
		if($condition!="") {
			$this->db->where($condition);
		}	
		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			$result = $query->result_array()[0];
			return $result;
		} else {
		 return FALSE;
		}
	}

	public function getCurrency() {
		$this->db->from('currencies');

		$this->db->where('currency_status',1);

		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getTotalOfDelivery($sum,$user_id,$date) {
		$this->db->from('delivery_booking');
        $this->db->select_sum($sum, $sum); 
        $this->db->where('delivery_id',$user_id);
        $this->db->where('today_date',$date);
        $this->db->group_by('today_date');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result = $query->result_array()[0];
        return $result;
	}

	public function getLoginTime($user_id) {
		$this->db->from('deliver_checkin');
        $this->db->select('checkin_date'); 
        $this->db->where('delivery_id',$user_id);
        $this->db->where('checkin_status',1);
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result = $query->result_array()[0];
        return $result;
	}

	public function getTotalRides($user_id,$date) {
		$this->db->from('delivery_booking');
        //$this->db->select_sum($sum, $sum); 
        $this->db->where('delivery_id',$user_id);
        $this->db->where('today_date',$date);
        //$this->db->group_by('today_date');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result = $query->num_rows();
        return $result;
	}

	public function getTotalHours($sum,$user_id,$date) {
		$this->db->from('deliver_checkin');
        $this->db->select_sum($sum, $sum); 
        $this->db->where('delivery_id',$user_id);
        $this->db->where('checkin_date >=',$date.' 00:00:00');
        $this->db->where('checkin_date <=',$date.' 23:59:59');
        //$this->db->group_by('today_date');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result = $query->result_array()[0];
        return $result;
	}

	public function getAllRides($user_id,$date) {
		
        $this->db->select('delivery_booking.order_id,delivery_booking.fare,orders.order_time'); 
        $this->db->from('delivery_booking');
        $this->db->join('orders', 'delivery_booking.order_id = orders.order_id', 'right outer');
        $this->db->where('delivery_booking.delivery_id',$user_id);
        $this->db->where('delivery_booking.today_date',$date);
        //$this->db->group_by('today_date');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $result = $query->result_array();
        return $result;
	}

	
	public function getTotal($table,$total,$user_id,$condition='') {
		$this->db->from($table);
        $this->db->select_sum($total, $total); 
        $this->db->where('deliver_id',$user_id);
        if($condition!=''){
			$this->db->where($condition);        	
        }       
        $this->db->group_by('deliver_id');
        $query = $this->db->get();
        $result = $query->result_array()[0];
        return $result;
	}	

	public function getDeliverByEmail($email) {

		$this->db->from('delivery');
		$this->db->where('email', strtolower($email));

		$query = $this->db->get();

		if ($query->num_rows() === 1) {
			$row = $query->row_array();

			return $row;
		}
	}

	

}

/* End of file delivery_model.php */
