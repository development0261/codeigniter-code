<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class SendNotifications extends Main_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('SendNotifications_model');
	}

	public function index() 
	{
		/*get all trainers current plan details*/
		$data = $this->SendNotifications_model->getCustomerSbscriptionCurrentPlan();
		// $userdata = $this->SendNotifications_model->getCustomerDetails();
		// echo "<pre>"; print_r($userdata); exit();
		$user_deviceid = [];
		if($data->num_rows()>0)
		{
			/*current date*/
			$currentDate = date('Y-m-d');
			// $currentDate = date('Y-m-d',strtotime('2021-08-20'));
			foreach ($data->result() as $result_key => $result_val)
			{
				/*5 days before date of expiry of plan*/
				$beforeExpiryDate = date('Y-m-d',strtotime('-5 days', strtotime($result_val->subscription_end_date)));
				$deviceid = $result_val->deviceid;
				if($beforeExpiryDate == $currentDate)
				{
					$user_deviceid[$result_key]['deviceid']   = $result_val->deviceid;
					$user_deviceid[$result_key]['deviceInfo'] = $result_val->deviceInfo;

					echo $result_val->subscription_end_date."----before 5 days----".date('Y-m-d',strtotime('-5 days', strtotime($result_val->subscription_end_date)))."----notify user----".$result_val->trainer_email."<br>";
				}

			}
		}
		// echo "<pre>"; print_r($user_deviceid); exit();
		if(!empty($user_deviceid)){
			$this->load->library('Push_Notification');    
			$push_notification = new Push_Notification;
			$result = $push_notification->sendPushNotification("Your plan is going to expire in next 5 days. Please Upgrade your plan to continue subscription.", "Subscription Expiry Notification", '', '', $user_deviceid, '');

			$result_array = json_decode($result) ;
			if($result_array->success>=1){
				$array = array('sent'=>'Yes') ;
				mail("developer@technowand.com.au","Send notification for subscription expiry sent",json_encode($user_deviceid));
			}else{
				$array = array('sent'=>'No') ;
				mail("developer@technowand.com.au","Send notification for subscription expiry sent failed",json_encode($user_deviceid));
			}
			echo json_encode($array);
		}
		else
		{
			mail("developer@technowand.com.au","Send notification for subscription expiry",'Data not found for '.date('Y-m-d'));
			$array = ["msg" => "Data not available"];
			echo json_encode($array);
		}
	}
}