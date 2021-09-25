<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Check_reg extends Main_Controller {
	
	public function __construct() {
		parent::__construct(); 	
		$this->load->model('Customers_model');																//  calls the constructor
			
	}
	public function index()
		{
			$email = $this->input->post('email');
			$data = $this->Customers_model->mail_exists($email);
			if($data == '0'){
				echo '<span style="color:green">Email Available To Register</span>';
				exit;				
			}else{
				echo '<span style="color:red">Email Already Exists</span>';
				exit;
			}


		}

	}