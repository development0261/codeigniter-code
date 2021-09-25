<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

require __DIR__.'/../../../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class Deliver extends REST_Controller {

	public function __construct() { 
      parent::__construct();
      $this->load->model(array('Member','Customers_model','Addresses_model','Locations_model','Delivery_model','Settings_model'));
      $this->load->library(array('form_validation','Customer','Delivery'));
      $this->load->helper('security');
      $this->load->library('session');
      $this->load->helper('logactivity');
  }

    public function deliverdashboard_post(){

       $user_id = $this->post('user_id');
       $earn = array();
       if($user_id!=''){
        /****** Today Count ******/
           $this->db->from('delivery_booking');
           $this->db->where('delivery_id',$user_id);
           $this->db->where('today_date',date('Y-m-d'));
           $today = $this->db->get();
           $count = $today->num_rows();
            
        /****** Today Earnings ******/    
           $this->db->from('delivery_booking');
           $this->db->select_sum('amount', 'earnings'); 
           $this->db->where('delivery_id',$user_id);
           $this->db->where('today_date',date('Y-m-d'));
           $this->db->group_by('today_date');
           $today = $this->db->get();
           $earnings = $today->result_array()[0];

        /********* CheckSTable ************/   

        $condition = "delivery_id = '".$user_id."'";
        $deliver =  $this->Delivery_model->CheckSTable('deliver_checkin',$condition);

        $condition = "delivery_id = '".$user_id."'";
        $details =  $this->Delivery_model->CheckSTable('delivery',$condition);

        $resp = '0:0';
        if($deliver!=''){
            $wallet = $details['wallet'];
            $chckin = $deliver['checkin_status'];
            $checkin =  $deliver['checkin_date'];
            $datetime1 = date_create(date('Y-m-d H:i:s'));
            $datetime2 = date_create($checkin);
            $interval = date_diff($datetime1, $datetime2);

            if($interval->format('%d')!='0' || $interval->format('%h')!='0' || $interval->format('%i')!='0'){
                $resp='';
                $dat=0;
                if($interval->format('%d')!=0){
                    $dat = $interval->format('%d') * 24;
                    // $resp.= $interval->format('%d') * '24'.':';
                }
                if($interval->format('%h')!=0){
                    if($dat!=0){
                      $resp.= $dat + $interval->format('%h').':';
                    } else {
                        $resp.= $interval->format('%h').':';
                    }
                } else {
                    $resp.='0:';
                }
                if($interval->format('%i')!=0){
                    $resp.= $interval->format('%i');
                }
            }    
        } else {
            $wallet = 0;
        }
       
        $cur = $this->Settings_model->getCurrencyId();

        $this->db->select('currency_symbol');
        $this->db->from('currencies');
        $this->db->where('currency_id',$cur);
        $curr = $this->db->get();
        $curren = $curr->result_array()[0];

        $currency['currency_symbol'] = $curren['currency_symbol'];
        $fare = $this->Delivery_model->getTotalOfDelivery('fare',$user_id,date('Y-m-d'));
        $total_rides = $this->Delivery_model->getTotalRides($user_id,date('Y-m-d'));
        $total_hrs = $this->Delivery_model->getTotalHours('total_hrs',$user_id,date('Y-m-d'));
        $total_hrs['total_hrs'] =  strval($total_hrs['total_hrs'] ? $total_hrs['total_hrs'] : "00:00");
        $total_hrs['total_hrs'] = strval(number_format($total_hrs['total_hrs'],2));
        $resul = array('id' => $user_id,
            'today_earnings' => $fare['fare'] ? $fare['fare'] : 0,
            'today_rides'  => $total_rides,
            'login_hrs' => $total_hrs['total_hrs'],
            'wallet' => $currency['currency_symbol'].' '.$wallet,
            'profile_picture' => $details['profile_image'],
            'currency_symbol' => $currency['currency_symbol'],
            'status'=>1
        );
        $result['result']  = $resul;
        $result['message'] = "Success";
        $result['status']  = 1;
        
       }else{

            $result['message'] = "user id cannot be empty";
        }
            $this->response($result);
        exit;

    }

    public function checkin_post(){

    	$userid = $this->post('user_id');
    	$checkinstatus = $this->post('check_status');

    	$date = date('Y-m-d H:i:s');

    	$condition = "delivery_id = '".$userid."'";

  		if($checkinstatus == 1){

        //Update time
        $total_hrs = 0;
        $checkin_date = $this->Delivery_model->getLoginTime($userid);
        if($checkin_date['checkin_date']){
            $to_time = strtotime($date);
            $from_time = strtotime($checkin_date['checkin_date']);
            $total_hrs = round(round(abs($to_time - $from_time) / 60,2) / 60,2);
        }
       $arr = array(
          'delivery_id'=>$userid,
          'checkin_status' => 0,
          'checkout_date' => $date,
          'total_hrs' => $total_hrs 
        );
        $this->db->where('delivery_id',$userid);
        $this->db->where('checkin_status',1);
        $query = $this->db->update('deliver_checkin',$arr);

        //Insert Checkin
  			$arr = array(
          'delivery_id'=>$userid,
    			'checkin_status' => $checkinstatus,
    			'checkin_date' => $date,
          'checkout_date' =>  '',
          'total_hrs' =>  '0'
  			);
  			//$this->db->where('delivery_id',$userid);
			  //$query = $this->db->update('deliver_checkin',$arr);
        $query = $this->db->insert('deliver_checkin',$arr);

  		} else {
  			$total_hrs = 0;
        $checkin_date = $this->Delivery_model->getLoginTime($userid);
        if($checkin_date['checkin_date']){
            $to_time = strtotime($date);
            $from_time = strtotime($checkin_date['checkin_date']);
            $total_hrs = round(round(abs($to_time - $from_time) / 60,2) / 60,2);
        }
       $arr = array(
          'delivery_id'=>$userid,
    			'checkin_status' => $checkinstatus,
    			'checkout_date' => $date,
          'total_hrs' => $total_hrs 
  			);
  			$this->db->where('delivery_id',$userid);
        $this->db->where('checkin_status',1);
			  $query = $this->db->update('deliver_checkin',$arr);
  		}

    	//$dat = $this->Delivery_model->CheckSTable('deliver_checkin',$condition);

    	//$result['result'] = $dat;
    	$result['message'] = 'success';
    	return $this->response($result);
    }

    public function earnings_post(){

    	$user_id = $this->post('user_id');
      $date = $this->post('date');
    	$i = 0;
    	if($user_id!=''){
            $cur = $this->Settings_model->getCurrencyId();

        $this->db->select('currency_symbol');
        $this->db->from('currencies');
        $this->db->where('currency_id',$cur);
        $curr = $this->db->get();
        $currency = $curr->result_array()[0];
   		   $trip_earnings = array(); 
   		   //$earnings = $this->Delivery_model->getTotalOfDelivery('amount',$user_id);
   		   $fare = $this->Delivery_model->getTotalOfDelivery('fare',$user_id,$date);
         $total_rides = $this->Delivery_model->getTotalRides($user_id,$date);
         $all_rides = $this->Delivery_model->getAllRides($user_id,$date);
         $total_hrs = $this->Delivery_model->getTotalHours('total_hrs',$user_id,$date);
   		   //$Surge_charge = $this->Delivery_model->getTotalOfDelivery('Surge_charge',$user_id);
   		   //$rest_fee = $this->Delivery_model->getTotalOfDelivery('rest_fee',$user_id);

   		   //$earn  = $earnings['amount'] ? $earnings['amount'] : 0;

         if(count($all_rides) > 0){
           foreach ($all_rides as $key => $value) {
             $all_rides[$key]['order_num'] = '#'.str_pad($value['order_id'], 6,"0",STR_PAD_LEFT);
           }
         }
   		   $fare = $fare['fare'] ? $fare['fare'] : 0;
         $result['result']['fare'] = $currency['currency_symbol'].$fare;
         $result['result']['currency_symbol'] = $currency['currency_symbol'];
         $result['result']['total_rides'] = $total_rides;
         $result['result']['all_orders'] = $all_rides;
         $result['result']['total_hrs'] =  strval($total_hrs['total_hrs'] ? $total_hrs['total_hrs'] : 0);
         $result['result']['total_hrs'] = strval(number_format($result['result']['total_hrs'],2));
         $result['result']['status'] = 1;
         $result['result']['message'] = "Success";

   		   //$surge = $Surge_charge['Surge_charge'] ? $Surge_charge['Surge_charge'] : 0;
   		   //$restfee = $rest_fee['rest_fee'] ? $rest_fee['rest_fee'] : 0;


    	} else {
    	     	$result['message'] = "user id cannot be empty";
        }
        $this->response($result);
        exit;
    }

    function weeks_between($datefrom, $dateto)
  	{
  	    $day_of_week = date("w", $datefrom);
  	    $fromweek_start = $datefrom - ($day_of_week * 86400) - ($datefrom % 86400);
  	    $diff_days = days_between($datefrom, $dateto);
  	    $diff_weeks = intval($diff_days / 7);
  	    $seconds_left = ($diff_days % 7) * 86400;

  	    if( ($datefrom - $fromweek_start) + $seconds_left > 604800 )
  	        $diff_weeks ++;

  	    return $diff_weeks;
  	}

    public function reasonlist_post(){

        $condition = 'status = 1';
        $reason = $this->Delivery_model->GetAllTable('reasons',$condition);       
        if(!$reason){
            $result['result'] = array();
            $result['message']= 'Success';
        } else {
            $result['result'] = $reason;
            $result['message']= 'Success';
        }

        $this->response($result);
        exit;
    }

    public function deliverHistory_post(){

        $cur = $this->Settings_model->getCurrencyId();

        $this->db->select('currency_symbol');
        $this->db->from('currencies');
        $this->db->where('currency_id',$cur);
        $curr = $this->db->get();
        $currency = $curr->result_array()[0];

        $id = $this->post('user_id');
        $condition = "deliver_id = ".$id;
        $resul = $this->Delivery_model->GetAllTable('delivery_history',$condition);
        $i = 0;
        $trans = array();
        foreach ($resul as $key => $value) {
            $trans[$i]['invoice_id'] = $value['invoice_id'];
            $trans[$i]['payment_type'] = $value['payment_type'];
            $trans[$i]['date'] =  date('d-M-Y',strtotime($value['date']));
            $trans[$i]['status'] = $value['status'];
            $trans[$i]['amount'] = $currency['currency_symbol'].' '.$value['amount'];
            $i++;
        }
        $condition = "delivery_id = ".$id;
        $resul =   $this->Delivery_model->CheckSTable('delivery',$condition);

        $condition = "status = 'pending'";
        
        $pending = $this->Delivery_model->getTotal('delivery_history','amount',$id,$condition);
        if ($resul['wallet'] == null){
          $result['result']['available_balance'] = '0';
        }
        else{
        $result['result']['available_balance'] = $resul['wallet'];
         }
         if($pending['amount'] == null){
          $result['result']['uncleared_balance'] = '0';
         }
         else{
           $result['result']['uncleared_balance'] = $pending['amount'];
         }
        $result['result']['currency_symbol'] = $currency['currency_symbol'];
        $result['result']['transaction'] = $trans;
        $result['message'] = 'Success';
        $result['status'] = '1';
        $this->response($result);
        exit;
        
    }

    public function paymentReq_post(){
        $user_id  = $this->post('user_id');
        $pay_type = $this->post('payment');
        
        if($pay_type){
           $pay_type = $pay_type; 
        } else {
            $pay_type = 'Bank';
        }

        if($user_id!=0){
          $condition = "delivery_id = ".$user_id;
          $resul = $this->Delivery_model->CheckSTable('delivery',$condition);
   
          $inv_id = $this->Delivery_model->GetAllTables('delivery_history');
          $inv = $inv_id['id'] + 1;
          $invoice = 'INV00'.$inv;
          if($resul['wallet'] == 0 || $resul['wallet'] == ""){
            $result['message'] = 'Insufficient Balance';
            $this->response($result);
            exit;  
          }
          $valet = array(
                'deliver_id'=>$user_id,
                'payment_type' => $pay_type,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'amount' => $resul['wallet'],
                'invoice_id' => $invoice
          );
          $this->db->insert('delivery_history',$valet);

          $this->db->where('delivery_id',$user_id);
          $this->db->update('delivery',array('wallet'=>0));

          $result['message'] = 'Success';
          $this->response($result);
          exit;  

        } else {
          $result['message'] = 'Failure';
          $this->response($result);
          exit;
        }
    }

    public function deliverComplete_post(){
       $order_id = $this->post('order_id');      
       $deliver_id = $this->post('delivery_id');

       $condition = 'order_id ='.$order_id;
       $chk = $this->Delivery_model->CheckSTable('orders',$condition);

        if($chk['status_id']=='20'){

           $this->db->where('order_id',$order_id);
           $this->db->update('orders',array('status_id' => '20'));

           $condition = 'order_id ='.$order_id;
           $chk = $this->Delivery_model->CheckSTable('orders',$condition);

           $condition = 'location_id ='.$chk['location_id'];
           $loc = $this->Delivery_model->CheckSTable('locations',$condition);       

           $locat = array(
            'order_id' => $order_id,
            'restaurant_id' => $chk['location_id'],
            'delivery_id' => $deliver_id,
            'date_time' => date('Y-m-d H:i:s'),
            'today_date' => date('Y-m-d'),
            'status' => '1',
            'amount' => $loc['delivery_boy_commission'],
            'fare' => 0,
            'Surge_charge' => 0,
            'rest_fee' => 0,
           );
           $this->db->insert('delivery_booking',$locat);

           $condition = 'delivery_id ='.$deliver_id;
           $chk = $this->Delivery_model->CheckSTable('deliver_checkin',$condition);    
           
           $wallt = $chk['wallet'] + $loc['delivery_boy_commission'];
           $this->db->where('delivery_id',$deliver_id);
           $this->db->update('deliver_checkin',array('wallet' => $wallt));
        }
        $result['message'] = 'Success';
        $this->response($result);
        exit;
    }

    public function fxmsend_post($message,$token)
    {
        //$token = $this->post('token');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        //$token = $token;
        
        $notification = [
            'body' => $message,
            'sound' => true,
        ];
        
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AIzaXXXX',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        print_r($result);
    }  

    public function fcmsend_post()
    {
        $token = $this->post('token');
        $message = $this->post('message');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        
        $notification = [
            'body' => $message,
            'sound' => true,
        ];
        
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AIzaXXXX',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        // print_r($result);
    } 

    public function DeliverUpdate_post(){

      $order_id = $this->post('order_id');
      $status = $this->post('status_id');

      $condition = 'order_id ='.$order_id;
      $chk = $this->Delivery_model->CheckSTable('orders',$condition);

      $deliver_id = $chk['delivery_id'];
      
      if($status=='20'){

         $this->db->where('order_id',$order_id);
         $this->db->update('orders',array('status_id' => '20'));

         $condition = 'order_id ='.$order_id;
         $chk = $this->Delivery_model->CheckSTable('orders',$condition);

         $locations = explode(',',$chk['location_id']);

         foreach($locations as $location_id)
         {
         $condition = 'location_id ='.$location_id;
         $loc = $this->Delivery_model->CheckSTable('locations',$condition);    

         $commission_amount = round(($chk['order_total'] * $loc['delivery_boy_commission']) / 100, 2);

         $locat = array(
          'order_id' => $order_id,
          'restaurant_id' => $location_id,
          'delivery_id' => $deliver_id,
          'date_time' => date('Y-m-d H:i:s'),
          'today_date' => date('Y-m-d'),
          'status' => '1',
          'amount' => $chk['order_total'],
          'fare' => $commission_amount,
          'Surge_charge' => 0,
          'rest_fee' => 0,
         );
         $this->db->insert('delivery_booking',$locat);
        }
         $condition = 'delivery_id ='.$deliver_id;
         $chk_del = $this->Delivery_model->CheckSTable('delivery',$condition);    
         
        /* if($chk['payment'] == "cash")
         {
            $wallt = $chk_del['wallet'] - $chk['order_total'];
         }
         else
         {
            $wallt = $chk_del['wallet'] + $commission_amount;
         }*/

         $wallt = $chk_del['wallet'] + $commission_amount;
         $this->db->where('delivery_id',$deliver_id);
         $this->db->update('delivery',array('wallet' => $wallt));
      }else{
        if($status == 4){
          $this->db->where('order_id',$order_id);
          $this->db->update('orders',array('status_id' => '4'));
        }
        
      }

      $condition = "order_id = '".$order_id."'";
      $deliver = $this->Delivery_model->CheckSTable('orders',$condition);

      $customer = $deliver['customer_id'];

      $condition = "status_code = '".$status."'";
      $deliver = $this->Delivery_model->CheckSTable('statuses',$condition);      

      $updates = array(
          'status'=> $deliver['status_name'],
          'status_id'=> (int) $status
        );
      
      $json = BASEPATH.'/../firebase.json';

      
      $project_id = json_decode(file_get_contents($json));


      $db = 'https://'.$project_id->project_id.'.firebaseio.com/';

      // echo $db;
      // exit;
      $serviceAccount = ServiceAccount::fromJsonFile($json);
      $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri($db)
            ->create();
      $database = $firebase->getDatabase();

      $newpost1 = $database->getReference('customer_pendings/'.$customer.'/'.$order_id) 
        ->update($updates);

        $result['message'] = 'Success';
        echo json_encode($result);
    }

    public function editProfile_post() {

        $result = array();
        /*$profile_picture = "";
        if($_FILES){
            $name = time().'_'.basename( $_FILES["profile_picture"]["name"]);
     
            $target_dir = '../assets/images/data/'.$name;
            
            $profile_picture = $name;

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_dir)) {
                //$result['result']['profile_picture_status'] = "Successfully uploaded";
            } else {
                //$result['result']['profile_picture_status'] = "Sorry, there was an error uploading your file.";
            }
        }*/
        
        

        if (TRUE) {
            
            $customer_exists = $this->Delivery_model->check_id_exists($this->post('id'));

            if($customer_exists >= 1){            

            $mailExist = $this->Delivery_model->getDeliveryIdByEmail($this->post('id'),$this->post('email'));
            if($mailExist > 0){
              
              $result['message'] = "Sorry this email already exist!";
              $this->response($result);
              exit;                
            }
            if(count($this->post()) <= 1){

                $result['message'] = "User Profile Updated Successfully";
                 
                $this->response($result);
                exit;

            }else{

                $customer_id = $this->post('id');  
                
                if(!empty($this->post('first_name'))){ 
                   $userData['first_name']    = $this->post('first_name');
                }

                if(!empty($this->post('last_name'))){ 
                   $userData['last_name']    = $this->post('last_name');
                }

                if(!empty($this->post('email'))){ 
                   $userData['email']      = $this->post('email');
                }

                if(!empty($this->post('password'))){ 
                   $userData['password']      = $this->post('password');
                }

                if(!empty($this->post('telephone'))){ 
                    $userData['telephone']     = $this->post('telephone');
                }

                if(!empty($this->post('language'))){ 
                    $userData['language']     = $this->post('language');
                }

                if(!empty($this->post('currency'))){ 
                    $userData['currency']     = $this->post('currency');
                }

                if(!empty($this->post('profile_picture'))){ 
                  $userData['profile_image']= $this->post('profile_picture');
                }

                if (!empty($this->post('bank_name'))) {
                  $userData['bank_name'] = $this->post('bank_name');
                }

                if (!empty($this->post('account_number'))) {
                  $userData['account_number'] = $this->post('account_number');
                }

                if (!empty($this->post('routing_number'))) {
                  $userData['routing_number'] = $this->post('routing_number');
                }


                if ($customer_id = $this->Delivery_model->saveDelivery($customer_id, $userData)) {
                    
                    $customer_details = $this->Delivery_model->getDeliveries($this->post('id'));
                    
                    $result['result'] = array();
                    $result['result']['first_name'] = $customer_details['first_name'];
                    $result['result']['last_name'] = $customer_details['last_name'];
                    $result['result']['email'] = $customer_details['email'];
                    $result['result']['telephone'] = $customer_details['telephone'];
                    $result['result']['password'] = $customer_details['password'];
                    $result['result']['vip_status'] = $customer_details['vip_status'];
                    $result['result']['bank_name'] = $customer_details['bank_name'];
                    $result['result']['account_number'] = $customer_details['account_number'];
                    $result['result']['routing_number'] = $customer_details['routing_number'];
                    if($customer_details['language'] == 11){
                        $result['result']['language'] = "English";
                    } else {
                        $result['result']['language'] = "Arabic";
                    }

                    if($customer_details['currency'] == 187){
                        $result['result']['currency'] = "SAR";
                    }else{
                        $result['result']['currency'] = "USD";
                    }
                    $result['result']['profile_picture'] = $customer_details['profile_image'];

                    $result['result']['reward_points'] = $customer_details['reward_points'];

                    $result['message'] = "User Profile Updated Successfully";

                    $this->response($result);
                    exit;
                }
            }           
            }else{
                $result['message'] = "Invalid delivery id";
                $this->response($result);
                exit;
            }
            }else{
            $error_data = array('code'  => 401 ,
                                'error' => 'Invalid Params.');               
            $output = array('message'  => $error_data);               
            echo json_encode($output);
        }
    }

    public function viewProfile_post() {
        $customer_id = $this->post('id');
        $customer_details= $this->Delivery_model->getDeliveries($customer_id);
        if(empty($customer_details)){
            $result['message'] = "Invalid delivery id";
            $this->response($result);
            exit;
        }

        $result['result'] = array();
        $result['result']['first_name'] = $customer_details['first_name'];
        $result['result']['last_name'] = $customer_details['last_name'];
        $result['result']['email'] = $customer_details['email'];
        $result['result']['bank_name'] = $customer_details['bank_name'];
        $result['result']['account_number'] = $customer_details['account_number'];
        $result['result']['routing_number'] = $customer_details['routing_number'];
        $result['result']['telephone'] = $customer_details['telephone'];
        $result['result']['password'] = $customer_details['password'];
        $result['result']['vip_status'] = $customer_details['vip_status'];
        if($customer_details['language'] == 11){
            $result['result']['language'] = "English";
        }else{
            $result['result']['language'] = "Arabic";
        }

        if($customer_details['currency'] == 187){
            $result['result']['currency'] = "SAR";
        }else{
            $result['result']['currency'] = "USD";
        }
        $result['result']['profile_picture'] = $customer_details['profile_image'];
        $result['result']['notification_status'] = $customer_details['notification_status'];
        $result['result']['reward_points'] = $customer_details['reward_points'];

        $result['message'] = "Success";

        $this->response($result);
    }

public function profileImageUpdate_post() {

        $result = array();
        $profile_picture = "";
        $user_id = $this->post('user_id');
        if($user_id)
        {
        if($_FILES){
            $name = time().'_'.basename( $_FILES["profile_picture"]["name"]);
            $folderPath = '../assets/images/profile_images/'.$user_id;
            if (!file_exists($folderPath)) {
            mkdir($folderPath,0777);
            }
            $target_dir = '../assets/images/profile_images/'.$user_id.'/'.$name;
            
            $profile_picture = 'profile_images/'.$user_id.'/'.$name;

            if($profile_picture){ 
                    $userData['profile_image']  = $profile_picture;
            }

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_dir)) {
                if ($this->Delivery_model->saveDelivery($user_id, $userData)) 
                {
                    //$result['url'] = $userData['profile_image'];
                    $result['url'] = $this->Delivery_model->getImageUrl($user_id);
                    $this->firebaseImageUpdate($user_id, $result['url']);
                    $result['message'] = "Successfully uploaded";

                } else {
                    $result['message'] = "Profile not updated";
                }
            }
            else {
                $result['message'] = "Sorry, there was an error uploading your file.";
            }
        }
        else
        {
            $result['message'] = "Sorry, Image Empty";
        }
    }
    else
    {
        $result['message'] = "Sorry, Customer ID Empty";
    }
        $this->response($result);
        exit;
    }

    public function firebaseImageUpdate($delivery_id,$image_path){
      $url = BASEPATH.'/../firebase.json';
     
      $uid = $delivery_id;
      $project_id = json_decode(file_get_contents($url));
      
      $db = 'https://'.$project_id->project_id.'.firebaseio.com/';
      $serviceAccount = ServiceAccount::fromJsonFile($url);
      $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri($db)
            ->create();
      $database = $firebase->getDatabase();      
      $input = [
          'delivery_partners/'.$uid.'/profile' => $image_path
      ];
      $newpost = $database->getReference()->update($input);
    }
    
    public function passwordupdate_post() {
        
        $delivery_id   = $this->post('user_id');
        $old_password  = $this->post('old_pass');
        $new_password  = $this->post('new_pass');
        //$language = $this->post('language');

        $userData['password'] = $new_password;

        /*if(strtolower($language)=='en'){
         $lang = 'english';
        } else if(strtolower($language)=='ar'){
         $lang = 'arabic';
        } else {
         $lang = 'english';
        }*/

        //$reset['email'] = $customer_mail;
        $delivery_details = $this->Delivery_model->getDelivery($delivery_id);
        if(empty($delivery_details)) {
            $result['message'] = "Invalid Delivery Partner Id";
            $this->response($result);
            exit;
        }
        // print_r($customer_details);exit;
        if($delivery_details['delivery_id']!=$delivery_id){
           $result['message'] = "Invalid Delivery Partner";
            $this->response($result);
            exit;    
        }

        $check = $this->customer->checkDeliverPassword($old_password,$delivery_id);
        
        if(empty($check)){
            $result['message'] = "Old Password does not match";
            $this->response($result);
            
        } else {
           if($new_password!=''){
            $customer = $this->Delivery_model->saveDelivery($delivery_id, $userData);
             if($customer){
                $result['message'] = "Success";
                $result['content'] = "Password changed successfully";
                
                $this->response($result);
                exit;
             } else {
                $result['message'] = "Error";
                $this->response($result);
                exit;
             }
           } else {
                $result['message'] = "Password cannot be empty";
                // $result['content'] = "password changed successfully";
                $this->response($result);
                exit;
           }
        }
    }

    public function passwordreset_post() {
        $deliver_mail  = $this->post('email');
        $reset['email'] = $deliver_mail;  
        $deliver_details = $this->Delivery_model->getDeliverByEmail($deliver_mail);

        if(empty($deliver_details)) {
            $result['message'] = "Invalid Email ID";
            $this->response($result);
            exit;
        }

        $data = $this->Delivery_model->resetPassword($deliver_mail, $reset);
        $result['result'] = $data;
        $result['message'] = "Success";
        $result['content'] = "Generated password sent to mail";

        $this->response($result);
    }

    public function setpass_post(){

        $userid = $this->post('user_id');
        $deliver_mail = $this->post('password');
        $deliver_details = $this->Delivery_model->getDelivery($userid);
            // print_r($customer_details);exit;
        if(empty($deliver_details)) {
            $result['message'] = "Invalid user";
            $this->response($result);
            exit;
        }
        $reset['email'] = $deliver_details['email'];
        $this->Delivery_model->setpassword($deliver_mail, $reset);
        $result['message'] = "Success";
        $result['content'] = "Password set successfully";
        $this->response($result);

    }
     
       public function gettransaction_post(){
         $order_id = $this->post('order_id');
         if($order_id != '') {
         $transaction_details = $this->Delivery_model->getTransaction($order_id);
            if(empty($transaction_details)) {
                $result['message'] = "No transaction available";
                $this->response($result);
                exit;
            }
            $result['transaction_id'] = $transaction_details['transaction_id'];
            $result['message'] = "Success";
            $this->response($result);
            }
        else{
             $result['message'] = "Empty params";
            $this->response($result);
        }
       }
}