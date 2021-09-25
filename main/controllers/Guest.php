<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Guest extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
       
        $this->load->model('Guest_model');
        $this->lang->load('guest');
        $this->load->library('currency');

		
	}

	public function index() {

		
		$email = base64_decode($this->input->get('user'));
		$res_id = base64_decode($this->input->get('res_id'));

		if($this->input->post('uniqueid')!=''){
			$uniqueid = $this->input->post('uniqueid');
			$check_cancel = $this->Guest_model->checkReservation($res_id,$uniqueid);

			if($check_cancel == '1'){
				
				 $refund_amount = $this->input->post('refund_amount');
				 //$curren_status = $this->input->post('curren_status');				
				 $poss = array(
				 	'X-API-KEY:RfTjWnZr4u7x!A-D',
				 	);
				
				 $pass_data = array(
				    'reservation_id' => $res_id ,
				    'refund_amount'  => $refund_amount
				  );
				  $curl = curl_init();
				  
				  // We POST the data
				  curl_setopt($curl, CURLOPT_POST, 1);
				  // Set the url path we want to call
				  curl_setopt($curl, CURLOPT_URL, site_url().'api/RestaurantsList/restaurantCancellation');  
				  // Make it so the data coming back is put into a string
				  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				  // Insert the data
				  curl_setopt($curl, CURLOPT_POSTFIELDS, $pass_data);
				  curl_setopt($curl, CURLOPT_HTTPHEADER, $poss);

				  $result = curl_exec($curl);
				   // Get some cURL session information back
				  $info = curl_getinfo($curl);  
				  // print_r($result);exit;
				  // Free up the resources $curl is using
				  curl_close($curl);
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Cancelled '));
			}
			

		}

		$data = $this->Guest_model->getReservationDetails($res_id,$email);
		
		$this->template->render('guest', $data);
	}
}