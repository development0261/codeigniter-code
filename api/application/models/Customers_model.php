<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customers_model extends CI_Model {

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

		$this->db->from('customers');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('customers');

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

    $this->db->from('customers');
    $this->db->where('email', $email);
    $query = $this->db->get();
    return $query->num_rows();
    
    }

    public function check_mobile_exists($mobile) {

    $this->db->from('customers');
    $this->db->where('telephone', $mobile);
    $query = $this->db->get();
    return $query->num_rows();
    
    }


    public function check_id_exists($customer_id) {

    $this->db->from('customers');
    $this->db->where('customer_id', $customer_id);
    $query = $this->db->get();
    return $query->num_rows();
    
    }


    public function check_address_id_exists($customer_id,$address_id) {

     $this->db->join('customers', 'customers.customer_id = addresses.customer_id AND addresses.customer_id='.$customer_id.' AND addresses.address_id='.$address_id, 'inner'); 
     $query = $this->db->get('addresses');
     return $query->num_rows();
    
    }


    public function getCustomers() {
		$this->db->from('customers');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCustomer($customer_id) {
		if (is_numeric($customer_id)) {
			$this->db->from('customers');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->result_array()[0];
			}
		}
	}

	public function getCustomerDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('customers');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCustomersForMessages($type) {
		$this->db->select('customer_id, email, status');
		$this->db->from('customers');
		$this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)
				$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
		}

		return $result;
	}

	public function getCustomerForMessages($type, $customer_id) {
		if ( ! empty($customer_id) AND is_array($customer_id)) {
			$this->db->select('customer_id, email, status');
			$this->db->from('customers');
			$this->db->where('status', '1');
			$this->db->where_in('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
			}

			return $result;
		}
	}

	public function getCustomersByGroupIdForMessages($type, $customer_group_id) {
		if (is_numeric($customer_group_id)) {
			$this->db->select('customer_id, email, customer_group_id, status');
			$this->db->from('customers');
			$this->db->where('customer_group_id', $customer_group_id);
			$this->db->where('status', '1');

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];
			}

			return $result;
		}
	}

	public function getCustomersByNewsletterForMessages($type) {
		$this->db->select('customer_id, email, newsletter, status');
		$this->db->from('customers');
		$this->db->where('newsletter', '1');
		$this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)
				$result[] = ($type === 'email') ? $row['email'] : $row['customer_id'];

			$this->load->model('Extensions_model');
			$newsletter = $this->Extensions_model->getModule('newsletter');
			if ($type === 'email' AND !empty($newsletter['ext_data']['subscribe_list'])) {
				$result = array_merge($result, $newsletter['ext_data']['subscribe_list']);
			}
		}

		return $result;
	}

	public function getCustomerByEmail($email) {

		$this->db->from('customers');
		$this->db->where('email', strtolower($email));

		$query = $this->db->get();

		if ($query->num_rows() === 1) {
			$row = $query->row_array();

			return $row;
		}
	}

	public function getCustomerByOtp($otp){

		$this->db->from('customers');
		$this->db->where('otp', $otp);
		$query = $this->db->get();
		if ($query->num_rows() === 1) {
			$row = $query->row_array();
			return $row;
		}
	}


	public function insertDeviceId($email = '',$deviceid = '', $deviceInfo = '') {	
			$this->db->set('deviceid', $deviceid);
			$this->db->set('deviceInfo', $deviceInfo);
			$this->db->where('email', $email);
			$query = $this->db->update('customers');
	}

	public function resetPassword($customer_id, $reset = array()) {
		
		if ($customer_id AND ! empty($reset)) {

			$this->db->from('customers');
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
				$this->db->where('customer_id', $row['customer_id']);
				$this->db->where('email', $row['email']);

				if ($this->db->update('customers') AND $this->db->affected_rows() > 0) {

					$data = $this->getCustomerByEmail($row['email']);

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
					log_activity($row['customer_id'], 'Password Reset', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$row['customer_id'].'">'.$row['first_name'] .' '.$row['last_name'].'</a> <b>Password Reset</b>.');
					return $data;
				}
			}
		}

		return FALSE;
	}

	public function setpassword($password, $reset = array()){

		if ($password AND ! empty($reset)) {
			$this->db->from('customers');
			$this->db->where('email', strtolower($reset['email']));
			$this->db->where('status', '1');
			$query = $this->db->get();
			if ($query->num_rows() === 1) {
				$row = $query->row_array();
				$this->db->set('otp','');
				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
				$this->db->where('customer_id', $row['customer_id']);
				$this->db->where('email', $row['email']);

				if ($this->db->update('customers') AND $this->db->affected_rows() > 0) {
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
					log_activity($row['customer_id'], 'Password Reset', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$row['customer_id'].'">'.$row['first_name'] .' '.$row['last_name'].'</a> <b>Password Reset</b>.');
					return $password;
				}
			}
		}
		return FALSE;
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) && ! empty($filter_data)) {
			$this->db->from('customers');

			if ( ! empty($filter_data['customer_name'])) {
				$this->db->like('CONCAT(first_name, last_name)', $filter_data['customer_name']);
			}

			if ( ! empty($filter_data['customer_id'])) {
				$this->db->where('customer_id', $filter_data['customer_id']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function saveCustomer($customer_id, $save = array()) {


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

		if (isset($save['customer_group_id'])) {
			$this->db->set('customer_group_id', $save['customer_group_id']);
		}

		if (isset($save['profile_image'])) {
			$this->db->set('profile_image', $save['profile_image']);
		}

		if (isset($save['verify_otp'])) {
			$this->db->set('verify_otp', $save['verify_otp']);
		}

		if (isset($save['date_added'])) {
			$add['date_added'] = date("Y-m-d H:i:s");
			$this->db->set('date_added', $save['date_added']);
		}

		if (is_numeric($customer_id)) {

			$action = 'updated';
			$this->db->where('customer_id', $customer_id);
			$query = $this->db->update('customers');
			return true;
			exit;
		} else {
			$this->db->set('status', '1');
			$action = 'added';
			$this->db->set('date_added', date("Y-m-d H:i:s"));
			$query = $this->db->insert('customers');
			$customer_id = $this->db->insert_id();
			/*return $customer_id;
			exit;*/
		}

		if ($query === TRUE AND is_numeric($customer_id)) {
			if (isset($save['address'])) {
				$this->saveAddress($customer_id, $save['address']);
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
				
				if ($registration_email === '1' OR in_array('customer', $config_registration_email)) {
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

				$this->saveCustomerGuestOrder($customer_id, $save['email']);
			}

			return $customer_id;
		}
		return $customer_id;
	}

	private function saveCustomerGuestOrder($customer_id, $customer_email) {
		$query = FALSE;

		if (is_numeric($customer_id) AND ! empty($customer_email)) {

			$query = $this->db->from('orders')->where('email', $customer_email)->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					if (empty($row['order_id'])) continue;

					$this->db->set('customer_id', $customer_id);
					$this->db->where('order_id', $row['order_id'])->where('email', $customer_email);
					$this->db->update('orders');

					if ($row['order_type'] === '1' AND ! empty($row['address_id'])) {
						$this->db->set('customer_id', $customer_id);
						$this->db->where('address_id', $row['address_id']);
						$this->db->update('addresses');
					}

					if ( ! empty($row['payment'])) {
						$this->db->set('customer_id', $customer_id);
						$this->db->where('order_id', $row['order_id']);
						$this->db->update('pp_payments');
					}

					$this->db->set('customer_id', $customer_id);
					$this->db->where('order_id', $row['order_id']);
					$this->db->update('coupons_history');
				}
			}

			$this->db->set('customer_id', $customer_id);
			$this->db->where('email', $customer_email);
			$this->db->update('reservations');

			$query = TRUE;
		}

		return $query;
	}

	public function saveAddress($customer_id, $addresses = array()) {
		if ( is_numeric($customer_id) AND ! empty($addresses)) {
			$this->db->where('customer_id', $customer_id);
			$this->db->delete('addresses');

			$this->load->model('Addresses_model');

			foreach ($addresses as $key => $address) {
				if (!empty($address['address_1'])) {
					$this->Addresses_model->saveAddress($customer_id, '', $address);
				}
			}
		}
	}

	public function deleteCustomer($customer_id) {
		if (is_numeric($customer_id)) $customer_id = array($customer_id);

		if ( ! empty($customer_id) AND ctype_digit(implode('', $customer_id))) {
			$this->db->where_in('customer_id', $customer_id);
			$this->db->delete('customers');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('customer_id', $customer_id);
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


	public function check_review_exists($customer_id) {

    $this->db->from('reviews');
    $this->db->where('customer_id', $customer_id);
    $query = $this->db->get();
    return $query->num_rows();
    
    }

    public function check_address_exists($customer_id) {

    $this->db->from('addresses');
    $this->db->where('customer_id', $customer_id);
    $query = $this->db->get();
    return $query->num_rows();
    
    }

    public function getAddress($customer_id) {
		if (is_numeric($customer_id)) {

			$this->db->select('addresses.*');
            
            $this->db->from('addresses');
    
            $this->db->join('customers', 'customers.customer_id = addresses.customer_id and addresses.customer_id='.$customer_id);

			$query = $this->db->get();

            if ($query->num_rows() > 0) {
				return $query->result_array();
			}
		}
	}


    public function getReviews($customer_id) {
		if (is_numeric($customer_id)) {

			$this->db->select('*');
            
            $this->db->from('reviews');
    
            $this->db->join('reservations', 'reviews.sale_id = reservations.order_id and reservations.customer_id='.$customer_id);

			$query = $this->db->get();

            if ($query->num_rows() > 0) {
				return $query->result_array();
			}
		}
	}

	public function validateCustomer($customer_id) {
		if (is_numeric($customer_id)) {
			$this->db->from('customers');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}
	public function verifystatusupdate($customer_id) {
			$this->db->set('verified_status', 1);
			$this->db->where('customer_id', $customer_id);
			$query = $this->db->update('customers');
			return TRUE;
	}
	public function verifyotpupdate($customer_id,$otp,$mobile = '') {
			$this->db->set('verify_otp', $otp);
			if($mobile)
			{
				$this->db->set('telephone', $mobile);
			}
			$this->db->where('customer_id', $customer_id);
			$query = $this->db->update('customers');
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


	public function GetTableFav($tablename,$condition=''){

		$this->db->select('*');
		$this->db->from($tablename);
		if($condition!="") {
			$this->db->where($condition);
		}	
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			return $result[0];
		} else {
		 return FALSE;
		}
	}


}

/* End of file customers_model.php */
