<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');
require __DIR__.'/../../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class Delivery extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Delivery');

        $this->load->model('Delivery_model');
        $this->load->model('Addresses_model');
        $this->load->model('Countries_model');
        $this->load->model('Security_questions_model');
        $this->load->model('Orders_model');
        $this->load->model('Reservations_model');
        $this->load->model('Currencies_model');
        $this->load->model('Locations_model');

        $this->load->library('pagination');

        $this->lang->load('delivery');
        $this->load->helper('user');
    }

	public function index() {
		$url = '?';
		$filter = array();
		$restaurant = $this->user->getRestaurant($this->user->getStaffId());

	    
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}
		if(isset($_SESSION['location_id']) && $_SESSION['location_id'] != '') {
	    	$_SESSION['location_id'] = $_SESSION['location_id'];
	    } else {
	    	$_SESSION['location_id'] = $restaurant[0]['location_id'];
	    }
		if (isset($_SESSION['location_id']) && $_SESSION['location_id'] != '') {
			$filter['location_id'] = isset($_SESSION['location_id']);
		} else {
			$filter['location_id'] = '';
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
			$filter['sort_by'] = $data['sort_by'] = 'delivery.date_added';
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
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteDelivery() === TRUE) {
			redirect('delivery');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_first'] 		= site_url('delivery'.$url.'sort_by=first_name&order_by='.$order_by);
		$data['sort_last'] 			= site_url('delivery'.$url.'sort_by=last_name&order_by='.$order_by);
		$data['sort_email'] 		= site_url('delivery'.$url.'sort_by=email&order_by='.$order_by);
		$data['sort_date'] 			= site_url('delivery'.$url.'sort_by=date_added&order_by='.$order_by);
		$data['sort_id'] 			= site_url('delivery'.$url.'sort_by=delivery_id&order_by='.$order_by);

		//$data['access_delivery_account'] = $this->user->canAccessDeliveryAccount();

		$data['delivery'] = array();

		$logged_userID = $this->user->getStaffId();
		//$logged_userID = 11;
		//$getUserLocs = $this->Locations_model->getLocationAddedBy(isAdminID($logged_userID),'loc_id');
		$getUserLocs = $this->Locations_model->getLocationAddedBy($logged_userID,'loc_id');
		$results = $this->Delivery_model->getList($filter,$logged_userID);
			//echo "<pre>"; print_r($results); exit;
		foreach ($results as $result) {

			$data['delivery'][] = array(
				'delivery_id' 		=> $result['delivery_id'],
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
				'login' 			=> site_url('delivery/login?id=' . $result['delivery_id']),
				'edit' 				=> site_url('delivery/edit?id=' . $result['delivery_id']),
				'added_by'			=> $result['added_by'] 
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

		$data['delivery_dates'] = array();
		$delivery_dates = $this->Delivery_model->getDeliveryDates();
		foreach ($delivery_dates as $delivery_date) {
			$month_year = '';
			$month_year = $delivery_date['year'].'-'.$delivery_date['month'];
			$data['delivery_dates'][$month_year] = mdate('%F %Y', strtotime($delivery_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('delivery'.$url);
		$config['total_rows'] 		= $this->Delivery_model->getCount($filter,$getUserLocs,$logged_userID );
		$config['per_page'] 		= $filter['limit'];
		
		// echo '<pre>';
		// print_r($_SESSION);
		// exit;

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
		$this->template->render('delivery', $data);
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
		$delivery_info = $this->Delivery_model->getDeliveries((int)$this->input->get('id'));

		 /*echo '<pre>';
		 print_r($delivery_info);
		 exit;*/

		
		if ($delivery_info) {		   
		    $delivery_id = $delivery_info['delivery_id'];
			$data['_action']	= site_url('delivery/edit?id='. $delivery_id);
		} else {
		    $delivery_id = 0;
			$data['_action']	= site_url('delivery/edit');
		}
		$str = file_get_contents('../assets/js/country_phone_code.json');

		$data['phone_code'] = json_decode($str);

		$title = (isset($delivery_info['first_name']) AND isset($delivery_info['last_name'])) ? $delivery_info['first_name'] .' '. $delivery_info['last_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('delivery'), 'title' => 'Back'));

		$currencies = $this->Currencies_model->getCurrencies();
		foreach ($currencies as $currency) {
			if($currency['currency_id'] == "227" || $currency['currency_id'] == "187"){
				$data['currencies'][] = array(
					'currency_id'		=>	$currency['currency_id'],
					'currency_name'		=>	$currency['country_name'] . ' - ' . $currency['currency_name'],
					'currency_status'	=>	$currency['currency_status']
				);
			}
		}


		if ($this->input->post() AND $delivery_id = $this->_saveDelivery($delivery_info['email'])) {
			
			if ($this->input->post('save_close') === '1') {
				redirect('delivery');
			}



			redirect('delivery/edit?id='. $delivery_id);
		}

        $data['first_name'] 		= $delivery_info['first_name'];
		$data['last_name'] 			= $delivery_info['last_name'];
		$data['bank_name'] 			= $delivery_info['bank_name'];
		$data['account_name'] 		= $delivery_info['account_name'];
		$data['account_number'] 	= $delivery_info['account_number'];
		$data['routing_number'] 	= $delivery_info['routing_number'];
		// $data['email'] 				= $this->hiddenemail($delivery_info['email']);
		$data['email'] 				= $delivery_info['email'];
		$data['currency'] 			= $delivery_info['currency'];
		$data['language'] 			= $delivery_info['language'];
		$data['telephone'] 			= explode('-',$delivery_info['telephone']);
		$data['security_question'] 	= $delivery_info['security_question_id'];
		$data['security_answer'] 	= $delivery_info['security_answer'];
		$data['newsletter'] 		= $delivery_info['newsletter'];
		$data['delivery_group_id'] 	= (!empty($delivery_info['delivery_group_id'])) ? $delivery_info['delivery_group_id'] : $this->config->item('delivery_group_id');
		$data['status'] 			= $delivery_info['status'];
		$data['vip_status'] 		= $delivery_info['vip_status'];
		$data['added_by'] 			= $delivery_info['added_by'];

		if ($this->input->post('address')) {
			$data['addresses'] 			= $this->input->post('address');
		} else {
			$data['addresses'] 			= $this->Addresses_model->getDeliveryAddresses($delivery_id);
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

		$this->load->model('Delivery_groups_model');
		$data['delivery_groups'] = array();
		$results = $this->Delivery_groups_model->getDeliveryGroups();
		foreach ($results as $result) {
			$data['delivery_groups'][] = array(
				'delivery_group_id'	=>	$result['delivery_group_id'],
				'group_name'		=>	$result['group_name']
			);
		}

		$data['country_id'] = $this->config->item('country_id');
		
		$resul = $this->Countries_model->getCountry($data['country_id']);
		$data['default_country_code'] = $resul['iso_code_2'];
		$results = $this->Countries_model->getCountries(); 	
										// retrieve countries array from getCountries method in locations model
		foreach ($results as $result) {															// loop through crountries array
			$data['countries'][] = array( 														// create array of countries data to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}
//echo "<pre/>";print_r($data);exit;
		$this->template->render('delivery_edit', $data);
	}

	public function login() {
		$delivery_info = $this->Delivery_model->getDelivery((int)$this->input->get('id'));
		
		if ( ! $this->user->canAccessDeliveryAccount()) {
			$this->alert->set('warning', $this->lang->line('alert_login_restricted'));
		} else if ($delivery_info) {
			$delivery_id = $delivery_info['delivery_id'];

			$this->load->library('delivery');
			$this->load->library('cart');

			$this->delivery->logout();
			$this->cart->destroy();

			if ($this->delivery->login($delivery_info['email'], '', TRUE)) {
				log_activity($delivery_id, 'logged in', 'delivery', get_activity_message('activity_master_logged_in',
					array('{staff}', '{staff_link}', '{delivery}', '{delivery_link}'),
					array($this->user->getStaffName(), admin_url('staffs/edit?id=' . $this->user->getId()), $this->delivery->getName(), admin_url('delivery/edit?id=' . $delivery_id))
				));

				redirect(root_url('account/account'));
			}
		}

		redirect('delivery');
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term') OR $this->input->get('delivery_id')) {
			$filter['delivery_name'] = $this->input->get('term');
			$filter['delivery_id'] = $this->input->get('delivery_id');

			$results = $this->Delivery_model->getAutoComplete($filter);

			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 	=> $result['delivery_id'],
						'text' 	=> utf8_encode($result['first_name'] .' '. $result['last_name'])
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}

		$this->output->set_output(json_encode($json));
	}

	private function _saveDelivery($delivery_email) {
		
		//print_r($this->db->last_query()	);exit;
    	if ($this->validateForm($delivery_email) === TRUE) {
        $address1=$this->input->post('address');
        $delivery_id=$this->input->get('id');
      // print_r($this->input->post());
       //exit;
      // print_r($this->input->get('id'));

      // exit;
       if(!empty($address1)){
       foreach ($address1 as $addresses) {
       	# code...
      
       
			$this->db->where('address_id!=', $addresses['address_id']);
			$this->db->where('customer_id', $delivery_id);
			$this->db->delete('delivery_addresses');
	
		 }}else{
		 		$this->db->where('customer_id', $delivery_id);
			$this->db->delete('delivery_addresses');
		 }

		 
		// print_r($this->db->last_query());exit;
//print_r($this->input->post());exits;


            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($delivery_id = $this->Delivery_model->saveDelivery($this->input->get('id'), $this->input->post())) {

				
                $delivery_name = $this->input->post('first_name').' '.$this->input->post('last_name');


                $url = BASEPATH.'/../firebase.json';
				$uid1 = $this->Delivery_model->DeliveryId();
				$uid = $uid1[0]['delivery_id'];
				$project_id = json_decode(file_get_contents($url));
				
				$db = 'https://'.$project_id->project_id.'.firebaseio.com/';
				$serviceAccount = ServiceAccount::fromJsonFile($url);
				$firebase = (new Factory)
							->withServiceAccount($serviceAccount)
							->withDatabaseUri($db)
							->create();
				$database = $firebase->getDatabase();
				
				$input = [
				    'delivery_partners/'.$uid.'/status' => 0,
				    'delivery_partners/'.$uid.'/l/0' => 0,
				    'delivery_partners/'.$uid.'/l/1' => 0,
				    'delivery_partners/'.$uid.'/name' => $this->input->post('first_name').' '.$this->input->post('last_name'),
				    'delivery_partners/'.$uid.'/profile' =>'profile_images/no-pic.png',
				    'delivery_partners/'.$uid.'/phone_number' => $this->input->post('telephone'),
				    'delivery_partners/'.$uid.'/delivery_id' => $uid,
				    'delivery_partners/'.$uid.'/added_by' => $this->user->getStaffId(),

				];
				$newpost = $database->getReference()->update($input);


                log_activity($this->user->getStaffId(), $save_type, 'delivery', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), $save_type, 'delivery', site_url('delivery/edit?id='.$delivery_id), $delivery_name)
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Delivery '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $delivery_id;
		}
	}

	private function validateForm($delivery_email = FALSE) {
		$this->form_validation->set_rules('first_name', 'lang:label_first_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'lang:label_last_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');

		if ($delivery_email !== $this->input->post('email')) {
			$this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email|max_length[96]|is_unique[delivery.email]');
		}

		// if ($this->input->post('password')) {
		// 	$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[40]|matches[confirm_password]');
		// 	$this->form_validation->set_rules('confirm_password', 'lang:label_confirm_password', 'xss_clean|trim|required');
		// }
		// print_r($this->input->get());
		// exit;

		if (! $this->input->get('id')) {
			$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[40]|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'lang:label_confirm_password', 'xss_clean|trim|required');
		}

		$this->form_validation->set_rules('telephone', 'lang:label_telephone', 'xss_clean|trim|required|min_length[9]|max_length[12]|integer');
		$this->form_validation->set_rules('security_question_id', 'lang:label_security_question', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('security_answer', 'lang:label_security_answer', 'xss_clean|trim|min_length[2]');
		$this->form_validation->set_rules('newsletter', 'lang:label_newsletter', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('delivery_group_id', 'lang:label_delivery_group', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('vip_status', 'lang:label_vip', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('bank_name', 'lang:bank_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('account_number', 'lang:account_number', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('routing_number', 'lang:routing_number', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('account_name', 'lang:account_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');

		if ($this->input->post('address')) {
			foreach ($this->input->post('address') as $key => $value) {
				$this->form_validation->set_rules('address['.$key.'][address_1]', 'lang:label_address_1', 'xss_clean|trim|required|min_length[3]|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][city]', 'lang:label_city', 'xss_clean|trim|required|min_length[2]|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][state]', '['.$key.'] lang:label_state', 'xss_clean|trim|max_length[128]');
				$this->form_validation->set_rules('address['.$key.'][postcode]', '['.$key.'] lang:label_postcode', 'xss_clean|trim|min_length[2]|max_length[10]');
				$this->form_validation->set_rules('address['.$key.'][country_id]', '['.$key.'] lang:label_country', 'xss_clean|trim|required|integer');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function _deleteDelivery() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Delivery_model->deleteDelivery($this->input->post('delete'));

			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Delivery': 'Delivery';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}
}

/* End of file delivery.php */
/* Location: ./admin/controllers/delivery.php */