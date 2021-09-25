<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Check_ph extends Main_Controller {
	
	public function __construct() {
		parent::__construct(); 	
		$this->load->model('Customers_model');																//  calls the constructor
			
	}
	public function index()
		{
			$phone = $this->input->post('phone');
			$data = $this->Customers_model->phone_exists($phone);
			if($data == '0'){
				//echo '<span style="color:green">Phone Number Available To Register</span>';
				return true;			
			}else if($data == '1'){
				echo '<span style="color:red">Phone Number Already Exists</span>';

				return false;

			}else if($data == ''){
				echo '<span style="color:red">Enter Valid phone number</span>';
				return true;			
			}


		}

	}