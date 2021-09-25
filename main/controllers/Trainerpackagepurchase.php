<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Trainerpackagepurchase extends Main_Controller {

	public function __construct() 
	{
		parent::__construct();	
		$this->load->model('Trainerpackagepurchase_model');
	}

	public function index() 
	{	
		echo '11';
		$payload = @file_get_contents('php://input');
		$event= json_decode( $payload, TRUE );   		

		error_log('======== Payment Response date time '.date('Y-m-d H:i:s').' ===== '.PHP_EOL, 3, "./main/trainer_plan_purchase_payment_response.log");
		error_log(print_r($event, true).PHP_EOL, 3, "./main/trainer_plan_purchase_payment_response.log");

		// Subscription created
		if($event['type'] == 'customer.subscription.created'){
			$metadata  = $event['data']['object']['metadata'];
        	$subscription_id = !empty($event['data']['object']['id'])?$event['data']['object']['id']:'';
			$customer_id     = !empty($event['data']['object']['customer'])?$event['data']['object']['customer']:'';
			$trainer_email   = !empty($metadata['trainer_email'])?$metadata['trainer_email']: '';

			// Write to log
			error_log('======== Metadata Date Added  '.date('Y-m-d H:i:s').' ===== '.PHP_EOL, 3, "./main/trainer_plan_purchase_metadata.log");
			error_log(print_r($metadata, true).PHP_EOL, 3, "./main/trainer_plan_purchase_metadata.log");

			$package_rec 		= $this->Trainerpackagepurchase_model->recordByPackageCustomer('', $metadata['package_id']);
			$pkg_dunation 		= !empty($package_rec['package_duration'])? $package_rec['package_duration'] : '0';
			$add_days = $pkg_dunation == 'Unlimited'? '2099-01-01': ($pkg_dunation == 'Weekly'? '7 days': ($pkg_dunation == 'Day'? '1 days': ($pkg_dunation == 'Month'? '30 days': $pkg_dunation)));
			$subscription_start_date  = date('Y-m-d');
			$subscription_end_date    = date('Y-m-d', strtotime($subscription_start_date. ' + '.$add_days));

			$record_array = array('stripe_customer_id' => $customer_id, 'trainer_email' => $trainer_email, 'subscription_id' => $subscription_id, 'is_active'=>'1', 'package_price' => $metadata['unit_amount'], 'package_id' => $metadata['package_id'], 'date_added' => date('Y-m-d H:i:s'), 'subscription_payment_iteration' => '1', 'subscription_start_date'=> $subscription_start_date, 'subscription_end_date' => $subscription_end_date);

			error_log('======== Record Array ====='.PHP_EOL, 3, "./main/trainer_plan_purchase_metadata.log");
			error_log(print_r($record_array, true).PHP_EOL, 3, "./main/trainer_plan_purchase_metadata.log");

			// Insert into table
			$coupon_id = $this->Trainerpackagepurchase_model->savePlanPurchase(NULL, $record_array);

			// Insert into history table
			$coupon_id = $this->Trainerpackagepurchase_model->savePlanPurchaseHistory(NULL, $record_array);
			//$coupon_id = $this->db->insert_id();
			//$this->_sendmail('subhamoy84@gmail.com', 'Trainer subscription created', print_r($event, true));
		}

		// For recurring call from stripe
		if($event['type'] == 'charge.succeeded'){
			$description   = strtolower($event['data']['object']['description']);			
			if (strpos($description, 'subscription update') !== false){
				$update['stripe_customer_id']  = !empty($event['data']['object']['customer'])?$event['data']['object']['customer']:'';
				$package_id   = '';
				// Ftech purchase record by customer id
				$record = $this->Trainerpackagepurchase_model->recordByPackageCustomer($update['stripe_customer_id'], $package_id);
				
				$update['trainer_email']   = !empty($record['trainer_email'])? $record['trainer_email'] : '';
				$update['subscription_id'] = !empty($record['subscription_id'])? $record['subscription_id'] : '';	
				$update['package_id'] 	   = !empty($record['package_id'])? $record['package_id'] : '';	
				$update['package_price']   = !empty($record['package_price'])? $record['package_price'] : '';
				$update['subscription_payment_iteration'] = !empty($record['subscription_payment_iteration'])? $record['subscription_payment_iteration'] : '';				
				$update['is_active'] 	= !empty($record['is_active'])? $record['is_active'] : '1';

				$update['package_price']= !empty($event['data']['object']['amount'])?$event['data']['object']['amount'] / 100:'';
				$update['txn_id']       = $event['data']['object']['balance_transaction'];

				
				$pkg_dunation 			= !empty($record['package_duration'])? $record['package_duration'] : '0';
				$add_days = $pkg_dunation == 'Unlimited'? '2099-01-01': ($pkg_dunation == 'Weekly'? '7 days': ($pkg_dunation == 'Day'? '1 days': $pkg_dunation));

				$update['subscription_start_date']  = date('Y-m-d');
				$update['subscription_end_date']    = date('Y-m-d', strtotime($update['subscription_start_date']. ' + '.$add_days));				
				// Insert into purchase table
				$dpdate_record 						= $this->Trainerpackagepurchase_model->updatePurchaseRecord($update);		

				// Insert into history table
				$purchase_history 					= $this->Trainerpackagepurchase_model->savePlanPurchaseHistory(NULL, $update);				
			}
		}

	}

	private function _sendmail($to_email = '', $subject_data = '', $message_data = ''){
		$from_email_address = 'maitysubha@gmail.com';
		$from_email_name = 'Subhamoy';

		$mail_body = '<!DOCTYPE html><html><head><title></title></head><body>
		'.$message_data.'</body></html>';
		
		$headers = "From: ".$from_email_name."<".$from_email_address.">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		
		if (mail($to_email, $subject_data, $mail_body, $headers)) {
			echo 'Packages mail sent';
		} else{            
			echo 'Failed';
		}  
	}
}