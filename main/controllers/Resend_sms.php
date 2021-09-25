<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Resend_sms extends Main_Controller {

	public function index() {
					$this->load->model('Extensions_model');
					$this->load->model('Locations_model');
					$this->load->library('session');
					$this->lang->load('resend');
					$i = 0; 
				    $pin = ""; 
				    while($i < 4){
				       
				        $pin .= mt_rand(0, 9);
				        $i++;
				    }
				    $customer_id = $this->customer->getId();
				    $this->Locations_model->updateOTP($customer_id, $pin);
					$sms_status = $this->Extensions_model->getExtension('twilio_module');
					
					$verify_otp = $pin;
					$telephone = $this->customer->getTelephone();
					if($sms_status['status'] == 1)
                	{ 
	                    $current_lang = $this->session->userdata('lang');
	                    if(!$current_lang) { $current_lang = "english"; }
	                    $sms_code = 'resend_'.$current_lang;
	                    $sms_template = $this->Extensions_model->getTemplates($sms_code);
	                    $message = $sms_template['body'];	                   
	                    $message = str_replace("{otp}",$verify_otp,$message);
	                    if($telephone!=''){
	                    	$ctlObj = modules::load('twilio_module/twilio_module/');
	                        $client_msg = $ctlObj->Sendsms($telephone,$message);	                       
	                    }
                	} 
                	$data['verify_otp'] = $verify_otp;
					$this->template->render('resend_sms', $data);

	}
	

}