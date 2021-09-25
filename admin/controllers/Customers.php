<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Customers extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Customers');

        $this->load->model('Customers_model');
        $this->load->model('Addresses_model');
        $this->load->model('Countries_model');
        $this->load->model('Security_questions_model');
        $this->load->model('Orders_model');
        $this->load->model('Reservations_model');
        $this->load->model('Currencies_model');
        $this->load->model('Locations_model');

        $this->load->library('pagination');

        $this->lang->load('customers');
        $this->load->helper('user');
    }

	public function index() {
		//print_r();
	
//exit;
		// $location_id=$this->user->getLocationId();
		// $data['location_id']=$location_id;
		$url = '?';
		$filter = array();
		// if($location_id!=''){
		// 	$filter['location_id']=$location_id;
		// }
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = "cusotmers.".$this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'customers.customer_id';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

		if ($this->input->post('delete') AND $this->_deleteCustomer() === TRUE) {
			redirect('customers');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_first'] 		= site_url('customers'.$url.'sort_by=first_name&order_by='.$order_by);
		$data['sort_last'] 			= site_url('customers'.$url.'sort_by=last_name&order_by='.$order_by);
		$data['sort_email'] 		= site_url('customers'.$url.'sort_by=email&order_by='.$order_by);
		$data['sort_date'] 			= site_url('customers'.$url.'sort_by=date_added&order_by='.$order_by);
		$data['sort_id'] 			= site_url('customers'.$url.'sort_by=customer_id&order_by='.$order_by);

		$data['access_customer_account'] = $this->user->canAccessCustomerAccount();

		$data['customers'] = array();

		$logged_userID = $this->user->getStaffId();

		$getUserLocs = $this->Locations_model->getLocationAddedBy($logged_userID,'loc_id');
		
		$user_id=$_SESSION['user_info']['user_id'];
		 $staff_ids=$this->db->get_where('users',array('user_id'=>$user_id))->result_array();
		 $staff_id= $staff_ids[0]['staff_id'];

if($staff_id==11){
	// echo '<pre>';
	// print_r($filter);
	// exit();
	//$results1=$this->Customers_model->getListCustomer($filter,$staff_id);
	//$results = $this->Customers_model->getList($filter,$getUserLocs);
	//$results =array_merge($results1,$results);

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
				$pref = $this->db->dbprefix("customers");
				$date = explode('-', $filter['filter_date']);
				$this->db->where("YEAR($pref.date_added)", $date[0]);
				$this->db->where("MONTH($pref.date_added)", $date[1]);
			}
	$results=$this->db->get('customers')->result_array();

	//print_r($this->db->last_query()); exit;
}else{
		$results1=$this->Customers_model->getListCustomer($filter,$staff_id);
		$results2 = $this->Customers_model->getList($filter,$getUserLocs);

		$results =array_unique(array_merge($results1,$results2), SORT_REGULAR);
		//echo "<pre>"; print_r(array_unique(array_merge($results1,$results2), SORT_REGULAR)); exit;

	}
		

		foreach ($results as $result) {

			$data['customers'][] = array(
				'customer_id' 		=> $result['customer_id'],
				'first_name' 		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				// 'email' 			=> $this->hiddenemail($result['email']),
				'email' 			=> $result['email'],
				'country_code' 		=> $result['country_code'],
				// 'telephone' 		=> $this->hiddenphone($result['telephone']),
				'telephone' 		=> $result['telephone'],
				'date_added' 		=> day_elapsed($result['date_added']),
				'status' 			=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'vip_status' 		=> ($result['vip_status'] === '1') ? 'Enabled' : 'Disabled',
				'login' 			=> site_url('customers/login?id=' . $result['customer_id']),
				'edit' 				=> site_url('customers/edit?id=' . $result['customer_id'])
			);
		}
		$data['isAdmin'] = $logged_userID; 
		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'id'	=> $result['question_id'],
				'text'	=> $result['text']
			);
		}

		$data['country_id'] = $this->config->item('country_id');
		$data['countries'] = array();
		$results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
		foreach ($results as $result) {															// loop through crountries array
			$data['countries'][] = array( 														// create array of countries data to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$data['customer_dates'] = array();
		$customer_dates = $this->Customers_model->getCustomerDates();
		foreach ($customer_dates as $customer_date) {
			$month_year = '';
			$month_year = $customer_date['year'].'-'.$customer_date['month'];
			$data['customer_dates'][$month_year] = mdate('%F %Y', strtotime($customer_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		// print_r($filter);
		// exit;
		$config['base_url'] 		= site_url('customers'.$url);
		// $config['total_rows'] 		= $this->Customers_model->getCount($filter,$getUserLocs);
		$config['total_rows'] 		= count($data['customers']);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
	//exit;

	
			$this->template->render('customers', $data);
	}
	public function hiddenemail($strEmail){		

	    $arrEamil = explode("@", $strEmail);
	    $arrReverse = array_reverse($arrEamil);
	    $strEamilDomain = $arrReverse[0];

	    if ($strEamilDomain != "") {
	        return $strNewEmail = "xxxxxxxxxxx@".$strEamilDomain;
	    }
	}

	public function hiddenphone($strPhone){		

	    $arrEamil = explode("-", $strPhone);
	    $arrReverse = array_reverse($arrEamil);
	    $strEamilDomain = $arrReverse[1];

	    if ($strEamilDomain != "") {
	        return $strNewEmail = $strEamilDomain."-xxxxxxxxxxx";
	    }
	}

	public function edit() {
		$customer_info = $this->Customers_model->getCustomer((int)$this->input->get('id'));

		if ($customer_info) {		   
		    $customer_id = $customer_info['customer_id'];
			$data['_action']	= site_url('customers/edit?id='. $customer_id);
		} else {
		    $customer_id = 0;
			$data['_action']	= site_url('customers/edit');
		}
		$str = file_get_contents('../assets/js/country_phone_code.json');

		$data['phone_code'] = json_decode($str);
		$title = (isset($customer_info['first_name']) AND isset($customer_info['last_name'])) ? $customer_info['first_name'] .' '. $customer_info['last_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('customers'), 'title' => 'Back'));

		$currencies = $this->Currencies_model->getCurrencies();
		// echo '<pre>';
		// print_r($currencies);
		// exit;
		foreach ($currencies as $currency) {
			// if($currency['currency_id'] == "227" || $currency['currency_id'] == "187"){
				$data['currencies'][] = array(
					'currency_id'		=>	$currency['currency_id'],
					'currency_name'		=>	$currency['country_name'] . ' - ' . $currency['currency_name'],
					'currency_status'	=>	$currency['currency_status']
				);
			// }
		}


		if ($this->input->post() AND $customer_id = $this->_saveCustomer($customer_info['email'])) {


			if ($this->input->post('save_close') === '1') {
				redirect('customers');
			}

			redirect('customers/edit?id='. $customer_id);
		}

        $data['first_name'] 		= $customer_info['first_name'];
		$data['last_name'] 			= $customer_info['last_name'];
		//$data['email'] 				= $this->hiddenemail($customer_info['email']);
		$data['email'] 				= $customer_info['email'];
		$data['currency'] 			= $customer_info['currency'];
		$data['language'] 			= $customer_info['language'];
		$data['telephone'] 			= explode('-',$customer_info['telephone']);
		$data['security_question'] 	= $customer_info['security_question_id'];
		$data['security_answer'] 	= $customer_info['security_answer'];
		$data['newsletter'] 		= $customer_info['newsletter'];
		$data['customer_group_id'] 	= (!empty($customer_info['customer_group_id'])) ? $customer_info['customer_group_id'] : $this->config->item('customer_group_id');
		$data['status'] 			= $customer_info['status'];
		$data['vip_status'] 		= $customer_info['vip_status'];

		if ($this->input->post('address')) {
			$data['addresses'] 			= $this->input->post('address');
		} else {
			$data['addresses'] 			= $this->Addresses_model->getAddresses($customer_id);
		}

		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'id'	=> $result['question_id'],
				'text'	=> $result['text']
			);
		}

		$this->load->model('Languages_model');
		$data['languages'] = array();
		$results = $this->Languages_model->getLanguages();
		foreach ($results as $result) {
			$data['languages'][] = array(
				'language_id'	=>	$result['language_id'],
				'name'			=>	$result['name'],
				'idiom'			=>	$result['idiom'],
			);
		}

		$this->load->model('Customer_groups_model');
		$data['customer_groups'] = array();
		$results = $this->Customer_groups_model->getCustomerGroups();
		foreach ($results as $result) {
			$data['customer_groups'][] = array(
				'customer_group_id'	=>	$result['customer_group_id'],
				'group_name'		=>	$result['group_name']
			);
		}

		$data['countries'] = array();
		$data['country_id'] = $this->config->item('country_id');
		
		$resul = $this->Countries_model->getCountry($data['country_id']);
		$data['default_country_code'] = $resul['iso_code_2'];
		$results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
		foreach ($results as $result) {															// loop through crountries array
			$data['countries'][] = array( 														// create array of countries data to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}
		$this->template->render('customers_edit', $data);
	}

	public function login() {
		$customer_info = $this->Customers_model->getCustomer((int)$this->input->get('id'));

		if ( ! $this->user->canAccessCustomerAccount()) {
			$this->alert->set('warning', $this->lang->line('alert_login_restricted'));
		} else if ($customer_info) {
			$customer_id = $customer_info['customer_id'];

			$this->load->library('customer');
			$this->load->library('cart');

			$this->customer->logout();
			$this->cart->destroy();

			if ($this->customer->login($customer_info['email'], '', TRUE)) {
				log_activity($customer_id, 'logged in', 'customers', get_activity_message('activity_master_logged_in',
					array('{staff}', '{staff_link}', '{customer}', '{customer_link}'),
					array($this->user->getStaffName(), admin_url('staffs/edit?id=' . $this->user->getId()), $this->customer->getName(), admin_url('customers/edit?id=' . $customer_id))
				));

				redirect(root_url('account/account'));
			}
		}

		redirect('customers');
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term') OR $this->input->get('customer_id')) {
			$filter['customer_name'] = $this->input->get('term');
			$filter['customer_id'] = $this->input->get('customer_id');

			$results = $this->Customers_model->getAutoComplete($filter);

			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 	=> $result['customer_id'],
						'text' 	=> utf8_encode($result['first_name'] .' '. $result['last_name'])
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}
		$this->output->set_output(json_encode($json));
	}

	private function _saveCustomer($customer_email) {
    	if ($this->validateForm($customer_email) === TRUE) {

            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($customer_id = $this->Customers_model->saveCustomer($this->input->get('id'), $this->input->post())) {
                $customer_name = $this->input->post('first_name').' '.$this->input->post('last_name');

                log_activity($this->user->getStaffId(), $save_type, 'customers', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), $save_type, 'customer', site_url('customers/edit?id='.$customer_id), $customer_name)
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Customer '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $customer_id;
		}
	}

	private function validateForm($customer_email = FALSE) {
		$this->form_validation->set_rules('first_name', 'lang:label_first_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'lang:label_last_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');

		if ($customer_email !== $this->input->post('email')) {
			$this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email|max_length[96]|is_unique[customers.email]');
		}

		if ($this->input->post('password') || $this->input->get('id') == '') {
			$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[40]|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'lang:label_confirm_password', 'xss_clean|trim|required');
		}

		$this->form_validation->set_rules('telephone', 'lang:label_telephone', 'xss_clean|trim|required|integer|min_length[9]|max_length[12]');
		$this->form_validation->set_rules('security_question_id', 'lang:label_security_question', 'xss_clean|trim|integer|required');
		$this->form_validation->set_rules('security_answer', 'lang:label_security_answer', 'xss_clean|trim|min_length[2]|required');
		$this->form_validation->set_rules('newsletter', 'lang:label_newsletter', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('customer_group_id', 'lang:label_customer_group', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('vip_status', 'lang:label_vip', 'xss_clean|trim|integer');

		if ($this->input->post('address')) {
			foreach ($this->input->post('address') as $key => $value) {
				$this->form_validation->set_rules('address['.$key.'][address_1]', 'lang:label_address_1', 'xss_clean|trim|required|min_length[3]|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][city]', 'lang:label_city', 'xss_clean|trim|required|min_length[2]|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][state]', '['.$key.'] lang:label_state', 'xss_clean|trim|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][postcode]', '['.$key.'] lang:label_postcode', 'xss_clean|trim|min_length[2]|max_length[10]');
				// $this->form_validation->set_rules('address['.$key.'][country_id]', '['.$key.'] lang:label_country', 'xss_clean|trim|required|integer');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function _deleteCustomer() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Customers_model->deleteCustomer($this->input->post('delete'));

			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Customers': 'Customer';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}
}

/* End of file customers.php */
/* Location: ./admin/controllers/customers.php */