<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cronscript extends Main_Controller {

	public function __construct() 
	{
		parent::__construct();	
		$this->load->model('Cronscript_model');
		$this->load->model('Notifications_model');
	}

	public function index() 
	{
		//mail("subhamoy84@gmail.com","Schedule push cron executed","Schedule push cron executed");		
		$schedule_notifications = $this->Cronscript_model->getList();	
		echo 'Hii';
		if(!empty($schedule_notifications)){
			foreach($schedule_notifications as $notification){	
				$user_deviceid= array();	
				$sent_to 		= $notification['sent_to'];		
				/*
				* Cron from recurring cron
				*/
				if($notification['schedule_type'] == 'RECURRING'){
					if(!empty($notification['recurring_start_date']) && !empty($notification['recurring_end_date'])){						
						$start_date      = date('Y-m-d', strtotime($notification['recurring_start_date']));
						$end_date        = date('Y-m-d', strtotime($notification['recurring_end_date']));
						
						$start_date_time = date('Y-m-d H:i', strtotime($notification['recurring_start_date']));
						$recurring_time  = date('H:i', strtotime($notification['recurring_start_date']));
						
						$earlier   = new DateTime($start_date_time);
						$current   = new DateTime(date('Y-m-d H:i'));
						$days_diff = $current->diff($earlier)->format("%a");

						$current_date = date('Y-m-d');		
						if($current_date >= $start_date && $current_date <= $end_date && $recurring_time == date('H:i')){
							if(!empty($notification['recurring_type'])){								
								$recurring_type = $notification['recurring_type'];
								if($recurring_type=='DAILY'){
										// Get data
										$user_deviceid = $this->Cronscript_model->getSubscriptionsRecords($sent_to);
										echo 'DAILY';
										mail("subhamoy84@gmail.com","Schedule recurring daily push",print_r($user_deviceid,true));	
								} else if($recurring_type=='MONTHLY'){
									if($days_diff % 30 == 0){
										// Get data
										$user_deviceid = $this->Cronscript_model->getSubscriptionsRecords($sent_to);
										echo 'MONTHLY';
										mail("subhamoy84@gmail.com","Schedule recurring monthly push",print_r($user_deviceid, true));
									}
								} else if($recurring_type=='YEARLY'){
									if($days_diff % 365 == 0){
										// Get data
										$user_deviceid = $this->Cronscript_model->getSubscriptionsRecords($sent_to);
										echo 'YEARLY';
										mail("subhamoy84@gmail.com","Schedule recurring yearly push",print_r($user_deviceid, true));
									}
								}
							}							
						}
					}
				}
				/*
				* Cron from later schedule date
				*/
				if($notification['schedule_type'] == 'LATER'){					
					if(date('Y-m-d H:i') == date('Y-m-d H:i', strtotime($notification['schedule_date']))){
						// Get data
						$user_deviceid = $this->Cronscript_model->getSubscriptionsRecords($sent_to);
						echo 'LATER';
						mail("subhamoy84@gmail.com","Schedule scheduled later push",print_r($user_deviceid, true));						
					}
				}
				
				// Send push
				if(!empty($user_deviceid)){
					$this->load->library('Push_Notification');    
					$push_notification = new Push_Notification;
					$result = $push_notification->sendPushNotification($notification['message'],$notification['title'],$notification['web_url'],$notification['schedule_notification_id'], $user_deviceid, $notification['page_url']);
	
					$result_array = json_decode($result) ;
					if($result_array->success>=1){
						$array = array('sent'=>'Yes') ;
					}else{
						$array = array('sent'=>'No') ;
					}
					//Now update the notification status
					$get_notification_info = $this->Notifications_model->update($notification['schedule_notification_id'],$array);
				}

			}
		}

	}

	public function eod_report(){	
		$admin_emails = $this->Cronscript_model->getAdminEmailList();
		
		if(!empty($admin_emails)){
			
			foreach($admin_emails as $key=>$adminemail){

				$config = array(
					'protocol'  => $this->config->item('protocol'),
					'smtp_host' => $this->config->item('smtp_host'),
					'smtp_port' => $this->config->item('smtp_port'),
					'smtp_user' => $this->config->item('smtp_user'),
					'smtp_pass' => $this->config->item('smtp_pass'),
					'mailtype'  => $this->config->item('mailtype'),
					'charset'   => $this->config->item('charset'),
				);
				$this->load->library('email', $config);

				$to_email = $adminemail['admin_to_email'];
				$cc_email = $adminemail['admin_cc_email'];

				$from_email_address = $this->config->item('from_email_address');
                $from_email_name    = $this->config->item('from_email_name'); 
		
				$subject_data = 'EOD Report for '.$adminemail['location_name'].' - '.date('d/m/Y');   
				$mail_body = $this->mailContent($adminemail['location_id'], $adminemail['location_name']);		

				// Always set content-type when sending HTML email
				$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
				// More headers
				$headers .= "From: ".$from_email_name."<".$from_email_address.">\r\n";
				$headers .= 'Cc: '. $cc_email . "\r\n";		
		
				@mail($to_email, $subject_data, $mail_body, $headers);
			}
		}		
	}

	/*
    * mailContent
    */
	public function mailContent($location_id = '', $location_name = ''){

		$total_records  = $this->Cronscript_model->getTotalReportList($location_id);				
		$weekly_records = $this->Cronscript_model->getWeeklyReportList($location_id);	
		
		$total_order_count     = '';
		$total_order_amount    = '';
		$time_difference       = '';

		$total_order_wk_count  = '';
		$total_order_wk_amount = '';
		$time_wk_difference   = '';

		if(!empty($total_records)){
			$total_order_count  = $total_records['total_order_count'];
			$total_order_amount = 'AUD '.number_format($total_records['total_order_amount'], 2);
			$time_difference    = $total_records['time_difference'] / 60;
		}

		if(!empty($weekly_records)){
			$total_order_wk_count  = $weekly_records['total_order_count'];
			$total_order_wk_amount = 'AUD '.number_format($weekly_records['total_order_amount'], 2);
			$time_wk_difference    = $weekly_records['time_difference'] / 60;
		}	    

		$content = " 
			<div>
				<p>Hello Admin,</p>
				<p>Please find below the EOD report for ".$location_name." for ".date('d/m/Y')."</p>
				<p><strong>Summary for ".date('d/m/Y')."</strong></p>
				<p>
					Total Number of Orders: ".$total_order_count."
					<br>
					Total Sales Amount: ".$total_order_amount."
					<br>
					AVG Time to Complete an Order: ".$time_difference."
				</p>
				<p><strong>Summary for last 7 days(".date('d/m/Y', strtotime('-7 days'))." to ".date('d/m/Y').")</strong></p>
				<p>
					Total Number of Orders: ".$total_order_wk_count."
					<br>
					Total Sales Amount: ".$total_order_wk_amount."
					<br>
					AVG Time to Complete an Order: ".$time_wk_difference."
				</p>
				<p>
					Thank you
					<br>
					".$location_name." Team
				</p>
			</div>
		";
    	return $content;
	}

	/*
	* Update order status from cron depending on below conditions
	* From 60 minutes from the pickup time, the status will automatically change from pending to completed( if no action has been *taken by the staff)
	* If no pick up time is mentioned, from the time of placing an order, after 60 minutes, status will be changed automatically change from pending to completed
	*/
	public function update_order_status(){		
		$orders = $this->Cronscript_model->getPendingOrdersList();
		if(!empty($orders)){
			foreach($orders as $key=>$value){				
				$order_time  = !empty($value['pickup_time'])? date('H:i', strtotime($value['pickup_time'])) : date('H:i', strtotime($value['order_time']));
				$order_time  = strtotime($order_time);

				$current_date = date('Y-m-d');
				$current_time = strtotime(date('H:i'));

				$time_difference = floor(($current_time - $order_time) / 60);
				// Update order status
				if(($current_date == $value['order_date']) && $current_time > $order_time && $time_difference >= 60){		
					$orders = $this->Cronscript_model->updateOrderStatus($value['order_id']);
				} 
				// else if($current_date > $value['order_date']){
				// 	$orders = $this->Cronscript_model->updateOrderStatus($value['order_id']);
				// }
			}
		}
	}
}