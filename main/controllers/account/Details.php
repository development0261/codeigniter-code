<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Details extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

        $this->load->model('Customers_model');
        $this->load->model('Security_questions_model');											// load the security questions model

        $this->lang->load('account/details');
	}

	public function index() {
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/details');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['back_url'] 				= site_url('account/account');

		$result = $this->Customers_model->getCustomer($this->customer->getId());				// retrieve customer data based on customer id from getCustomer method in Customers model
		$str = file_get_contents(site_url().'/assets/js/country_phone_code.json');

		$data['phone_code'] = json_decode($str);

		if ($result) {
			$data['first_name'] 		= $result['first_name'];
			$data['last_name'] 			= $result['last_name'];
			$data['email'] 				= $result['email'];
			$data['telephone'] 			= explode('-',$result['telephone']);
			$data['security_question'] 	= $result['security_question_id'];
			$data['security_answer'] 	= $result['security_answer'];
			// $data['profile_image']		= $result['profile_image'];
			$data['newsletter'] 		= $result['newsletter'];
		}

		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();						// retrieve security questions from getQuestions in Security questions model
		foreach ($results as $result) {
			$data['questions'][] = array(														// create array of security questions to pass to view
				'question_id'	=> $result['question_id'],
				'text'	=> $result['text'],
				'text_ar'	=> $result['text_ar']
			);
		}

		// check if $_POST is set and if update details validation was successful then redirect
		if ($this->input->post() AND $this->_updateDetails() === TRUE) {
			redirect('account/details');
		}

		$this->template->render('account/details', $data);
	}

	private function _updateDetails() {															// method to validate update details form fields
		if ($this->validateForm() === TRUE) {
			$update = array();

			if(isset($_FILES['profile_image'])){
			
			      $errors= array();
			      $file_name = $_FILES['profile_image']['name'];
			      $file_name_full = $_FILES['profile_image']['name'].'_full';
			      $file_size =$_FILES['profile_image']['size'];
			      $file_tmp =$_FILES['profile_image']['tmp_name'];
			      $file_type=$_FILES['profile_image']['type'];
			      $expensions= array("jpeg","jpg","png");
			      $file_ext=strtolower(end(explode('.',$_FILES['profile_image']['name'])));
			      if(in_array($file_ext,$expensions)=== false){
			         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
			      }	      
			       if($file_name != '') {
			      	if(count($errors) > 0)  {
				      	$this->alert->set('alert', $this->lang->line('alert_updated_error'));
				      	return false;
				      }	
			      }
			      

					$size = getimagesize($file_tmp);
					$ratio = $size[0]/$size[1]; // width/height
					if( $ratio > 1) {
					    $width = 190;
					    $height = 190/$ratio;
					}
					else {
					    $width = 190*$ratio;
					    $height = 190;
					}
					$id = $this->customer->getId();
					$folderPath = 'assets/images/profile_images/'.$id;
					mkdir($folderPath,0777);
					$src = imagecreatefromstring(file_get_contents($file_tmp));
					$dst = imagecreatetruecolor($width,$height);
					imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
					imagedestroy($src);
					$file1 = imagepng($dst,'assets/images/profile_images/'.$id.'/'.$file_name); // adjust format as needed
					imagedestroy($dst);
					move_uploaded_file($file_tmp,'assets/images/profile_images/'.$id.'/'.$file_name_full);
			     	
			  	
			   }


			// START: retrieve $_POST data if $_POST data is not same as existing customer library data
			$update['first_name'] 				= $this->input->post('first_name');
			$update['last_name'] 				= $this->input->post('last_name');
			$update['country_code'] 			= $this->input->post('country_code');
			$update['telephone'] 				= $this->input->post('telephone');
			$update['security_question_id'] 	= $this->input->post('security_question_id');
			$update['security_answer'] 			= $this->input->post('security_answer');
			if($file_name!=''){
			$update['profile_image'] 			= $id.'/'.$file_name;
			}
			
			if($this->input->post('new_password')!==''){
			$update['password'] 				= $this->input->post('new_password');
			}	
			$update['newsletter'] 				= $this->input->post('newsletter');
			$update['status'] 					= '1';
			// END: retrieve $_POST data if $_POST data is not same as existing customer library data

			if (!empty($update)) {																// if update array is not empty then update customer details and display success message
				if ($this->Customers_model->saveCustomer($this->customer->getId(), $update)) {
                    log_activity($this->customer->getId(), 'updated', 'customers', get_activity_message('activity_updated_account',
                        array('{customer}', '{link}'),
                        array($this->customer->getFirstName(). ' '. $this->customer->getLastName(), admin_url('customers/edit?id='.$this->customer->getId()))
                    ));

                    if (!empty($update['password'])) {
                        log_activity($this->customer->getId(), 'updated', 'customers', get_activity_message('activity_changed_password',
                            array('{customer}', '{link}'),
                            array($this->customer->getFirstName(). ' '. $this->customer->getLastName(), admin_url('customers/edit?id=' . $this->customer->getId()))
                        ));
                    }

                    $this->alert->set('alert', $this->lang->line('alert_updated_success'));
				}

				return TRUE;
			}
		}
	}

	private function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('first_name', 'lang:label_first_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'lang:label_last_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('telephone', 'lang:label_telephone', 'xss_clean|trim|required|integer|min_length[9]|max_length[12]');
		// $this->form_validation->set_rules('security_question_id', 'lang:label_s_question', 'xss_clean|trim|required|integer');
		// $this->form_validation->set_rules('security_answer', 'lang:label_s_answer', 'xss_clean|trim|required|min_length[2]');

		if ($this->input->post('old_password')) {
			$this->form_validation->set_rules('old_password', 'lang:label_old_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|callback__check_old_password');
			$this->form_validation->set_rules('new_password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[confirm_new_password]');
			$this->form_validation->set_rules('confirm_new_password', 'lang:label_password_confirm', 'xss_clean|trim|required');
		}
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}

 	public function _check_old_password($pwd) {													// validation callback function to check if old password is valid

		if (!$this->customer->checkPassword($pwd)) {
        	$this->form_validation->set_message('_check_old_password', $this->lang->line('error_password'));
      		return FALSE;
    	} else {
        	return TRUE;
      	}
    }
}

/* End of file details.php */
/* Location: ./main/controllers/details.php */