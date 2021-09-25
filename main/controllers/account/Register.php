<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Register extends Main_Controller {
	var $recaptcha_error = '';

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
				$this->load->model('Pages_model');
		$this->lang->load('account/login_register');
	}

	public function index() {
		$data['digits'] = $this->config->item('digits_mobile');

		if ($this->input->post() AND $this->_addCustomer() === TRUE) {							// checks if $_POST data is set and if registration validation was successful

			$this->alert->set('alert', $this->lang->line('alert_account_created'));	// display success message and redirect to account login page

			if ($redirect_url = $this->input->get('redirect')) {
				redirect($redirect_url);
			}

			redirect('account/login');
		}

		$this->template->setTitle($this->lang->line('text_register_heading'));

		$data['login_url'] 				        = site_url('account/login');

		if ($this->config->item('registration_terms') > 0) {
			$data['registration_terms'] = str_replace(root_url(), '/', site_url('pages?popup=1&page_id='.$this->config->item('registration_terms')));
		} else {
			$data['registration_terms'] = FALSE;
		}

		$str = file_get_contents(site_url().'/assets/js/country_phone_code.json');
		$data['phone_code'] = json_decode($str);
		// echo '<pre>';
		// print_r($data['phone_code']);
		// exit;
		$this->load->model('Security_questions_model');											// load the security questions model
		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();								// retrieve array of security questions from getQuestions method in Security questions model
		foreach ($results as $result) {															// loop through security questions array
			$data['questions'][] = array(														// create an array of security questions to pass to view
				'id'	=> $result['question_id'],
				'text'	=> $result['text']
			);
		}

		//$data['captcha'] = $this->createCaptcha();
		$this->template->render('account/register', $data);
	}

	private function _addCustomer() {

		if ($this->validateForm() === TRUE) {

            $this->load->model('Customers_model');													// load the customers model
            $this->load->model('Customer_groups_model');

 			$add = array();

 			// echo '<pre>';
 			// 	print_r($_POST);
 			// echo '</pre>';
 			// exit;

 			$i = 0; 
		    $pin = ""; 
		    while($i < 4){
		       
		        $pin .= mt_rand(0, 9);
		        $i++;
		    }

 			// if successful CREATE an array with the following $_POST data values
			$add['first_name'] 				= $this->input->post('first_name');
			$add['last_name'] 				= $this->input->post('last_name');
			$add['email'] 					= $this->input->post('email');
			$add['password'] 				= $this->input->post('password');
			$add['country_code']			= $this->input->post('country_code');
			$add['telephone'] 				= $this->input->post('telephone');
			$add['phone'] 					= $this->input->post('country_code').'-'.$this->input->post('telephone');
			$add['security_question_id']	= $this->input->post('security_question');
			$add['security_answer'] 		= $this->input->post('security_answer');
			$add['newsletter'] 				= $this->input->post('newsletter');
			$add['terms_condition'] 		= $this->input->post('terms_condition');
			$add['customer_group_id'] 		= $this->config->item('customer_group_id');
			$add['date_added'] 				= mdate('%Y-%m-%d', time());
			$add['verify_otp']				= $pin;



			$sms_mobile =$this->input->post('country_code').'-'.$this->input->post('telephone');

			// echo '<pre>';
 		// 		print_r($add);
 		// 	echo '</pre>';
 		// 	exit;

			$result = $this->Customer_groups_model->getCustomerGroup($this->config->item('customer_group_id'));

			if ($result['approval'] === '1') {
				$add['status'] = '0';
			} else {
				$add['status'] = '1';
			}

			if (!empty($add) AND $customer_id = $this->Customers_model->saveCustomer(NULL, $add)) {								// pass add array data to saveCustomer method in Customers model then return TRUE

					/****************SEND SMS******************/
					$this->load->model('Extensions_model');
					$sms_status = $this->Extensions_model->getExtension('twilio_module');

					if($sms_status['status'] == 1)
                	{ 
	                    $current_lang = $this->session->userdata('lang');
	                    if(!$current_lang) { $current_lang = "english"; }
	                    $sms_code = 'register_'.$current_lang;
	                    $sms_template = $this->Extensions_model->getTemplates($sms_code);
	                    $message = $sms_template['body'];
	                    $message = str_replace("{username}",$add['first_name'].' '.$add['last_name'],$message);
	                    $message = str_replace("{otp}",$add['verify_otp'],$message);
	                    if($add['telephone']!=''){
	                    	$ctlObj = modules::load('twilio_module/twilio_module/');
	                        $client_msg = $ctlObj->Sendsms($sms_mobile,$message);
	                    }
                	}  

					/****************SEND SMS******************/

                log_activity($customer_id, 'registered', 'customers', get_activity_message('activity_registered_account',
                    array('{customer}', '{link}'),
                    array($this->input->post('first_name').' '.$this->input->post('last_name'), admin_url('customers/edit?id='.$customer_id))
                ));

                return TRUE;
			}
		}
	}

	private function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('first_name', 'lang:label_first_name', 'xss_clean|required|min_length[2]|max_length[16]');
		$this->form_validation->set_rules('last_name', 'lang:label_last_name', 'xss_clean|required|min_length[2]|max_length[16]');
		$this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email|is_unique[customers.email]');
		$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[16]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'lang:label_password_confirm', 'xss_clean|trim|required');
		$this->form_validation->set_rules('telephone', 'lang:label_telephone', 'xss_clean|required|min_length[9]|max_length[12]|integer');

		$this->form_validation->set_rules('phone', 'lang:label_telephone', 'is_unique[customers.telephone]');
		$this->form_validation->set_rules('security_question', 'lang:label_s_question', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('security_answer', 'lang:label_s_answer', 'xss_clean|trim|required|min_length[2]');
		$this->form_validation->set_rules('newsletter', 'lang:label_subscribe', 'xss_clean|trim|integer');
		//$this->form_validation->set_rules('captcha', 'lang:label_captcha', 'xss_clean|trim|required|callback__validate_captcha');

		if ($this->config->item('registration_terms') === '1') {
			$this->form_validation->set_rules('terms_condition', 'lang:label_i_agree', 'xss_clean|trim|integer|required');
		}
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}

	 

    public function _validate_captcha($word) {
		$session_caption = $this->session->tempdata('captcha');

        if (strtolower($word) !== strtolower($session_caption['word'])) {
            $this->form_validation->set_message('_validate_captcha', $this->lang->line('error_captcha'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

	private function createCaptcha() {
        $this->load->helper('captcha');

        $captcha = create_captcha();
        $this->session->set_tempdata('captcha', array('word' => $captcha['word'], 'image' => $captcha['time'].'.jpg'), '120'); //set data to session for compare
        return $captcha;
    }
}

/* End of file register.php */
/* Location: ./main/controllers/register.php */