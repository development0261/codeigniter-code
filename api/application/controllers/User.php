<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

class user extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Member','Customers_model','Addresses_model','Locations_model','Delivery_model','Settings_model'));
        $this->load->library(array('form_validation','Customer','Delivery'));
        $this->load->helper('security');
        $this->load->library('session');
        $this->load->helper('logactivity');

    }

    // Login Section

    public function login_post() {

        if ($this->validateLoginForm() === TRUE) {

            $email = $this->post('email');
            $password = $this->post('password');
            $deviceid = $this->post('deviceid');
            $deviceInfo = $this->post('deviceInfo');
            
            if ($this->customer->login($email, $password) === FALSE) {                      
               /* $error_data = array('code'  => 401 ,
                                    'error' => 'Invalid login credentials.');   */

                $msg =   'Invalid login credentials.';          
                $output = array('message'  => $msg);
                
                echo json_encode($output);
            }else{

                
                $this->Customers_model->insertDeviceId($email,$deviceid, $deviceInfo);
                $customer_details = $this->Customers_model->getCustomerByEmail($email);
                    
                $get_address = $this->Addresses_model->getDefault(0,$customer_details['customer_id']);
                // print_r($get_address);exit;
                if($get_address){
                   $default = $get_address['address_id'];
                } else {
                    $default = '0';
                }

                $customer_data = array('customer_id' => $customer_details['customer_id'] ,
                                       'first_name'  => $customer_details['first_name'] ,
                                       'last_name'   => $customer_details['last_name'], 
                                       'email'       => $customer_details['email'], 
                                       'telephone'   => $customer_details['telephone'],
                                       'profile_image'=> $customer_details['profile_image'],
                                       'language'   => $customer_details['language'],
                                       'status'      => $customer_details['status'],
                                       'otp_verified_status'  =>  $customer_details['verified_status'],
                                       'date_added'  => $customer_details['date_added'],
                                       'default_address' => $default);

                log_activity($customer_details['customer_id'], 'Login', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_details['customer_id'].'">'.$customer_details['first_name'] .' '.$customer_details['last_name'].'</a> <b>Logged in</b>.');       
                        
                $output = array('result'  => $customer_data, 
                                'message' => 'Login Successfull');

                echo json_encode($output);

            }                                  

        }else{

                $error_data = array('code'  => 401 ,
                                    'error' => 'Invalid Params.');               
                $output = array('message'  => $error_data);
                
                echo json_encode($output);
        
        }

    }

    // Login Section

    public function sociallogin_post() {
        
        $email      = !empty($this->post('email'))?$this->post('email'):'';
        $name       = !empty($this->post('name'))?$this->post('name'):'';
        $socialtype = !empty($this->post('socialtype'))?$this->post('socialtype'):'';
        $logintoken = !empty($this->post('logintoken'))?$this->post('logintoken'):'';     
        $deviceid   = !empty($this->post('deviceid'))?$this->post('deviceid'):'';
        $appleauthorizationcode   = !empty($this->post('appleauthorizationcode'))?$this->post('appleauthorizationcode'):'';
        $appleidentitytoken   = !empty($this->post('appleidentitytoken'))?$this->post('appleidentitytoken'):'';
        
        if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($socialtype) && !empty($logintoken)) {             
            $email      = $this->post('email');
            $name       = $this->post('name');
            $socialtype   = $this->post('socialtype');
            $logintoken = $this->post('logintoken');            
            
            if ($this->customer->sociallogin($email, $socialtype, $logintoken, $name, $appleauthorizationcode, $appleidentitytoken) === FALSE) {   
                $msg =   'Invalid login credentials.';          
                $output = array('message'  => $msg);                
                echo json_encode($output);
            }else{   
                $this->Customers_model->insertDeviceId($email,$deviceid);
                $customer_details = $this->Customers_model->getCustomerByEmail($email);
                    
                $get_address = $this->Addresses_model->getDefault(0,$customer_details['customer_id']);
                // print_r($get_address);exit;
                if($get_address){
                   $default = $get_address['address_id'];
                } else {
                    $default = '0';
                }

                $customer_data = array('customer_id' => $customer_details['customer_id'] ,
                                       'first_name'  => $customer_details['first_name'] ,
                                       'last_name'   => $customer_details['last_name'], 
                                       'email'       => $customer_details['email'], 
                                       'telephone'   => $customer_details['telephone'],
                                       'profile_image'=> $customer_details['profile_image'],
                                       'language'   => $customer_details['language'],
                                       'status'      => $customer_details['status'],
                                       'otp_verified_status'  =>  $customer_details['verified_status'],
                                       'date_added'  => $customer_details['date_added'],
                                       'default_address' => $default);

                log_activity($customer_details['customer_id'], 'Login', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_details['customer_id'].'">'.$customer_details['first_name'] .' '.$customer_details['last_name'].'</a> <b>Logged in</b>.');       
                        
                $output = array('result'  => $customer_data, 
                                'message' => 'Login Successfull');

                echo json_encode($output);

            }                                  

        }else{

                $error_data = array('code'  => 401 ,
                                    'error' => 'Invalid Params.');               
                $output = array('message'  => $error_data);
                
                echo json_encode($output);
        
        }

    }

    //Deliver login section

     public function deliverlogin_post() {

        if ($this->validateLoginForm() === TRUE) {

            $email = $this->post('email');
            $password = $this->post('password');
            $deviceid = $this->post('deviceid');
            
            if ($this->delivery->login($email, $password) === FALSE) {                      
               /* $error_data = array('code'  => 401 ,
                                    'error' => 'Invalid login credentials.');   */

                $msg =   'Invalid login credentials.';          
                $output = array('message'  => $msg);
                
                echo json_encode($output);
            }else{

                
                $this->Delivery_model->insertDeviceId($email,$deviceid);
                $customer_details = $this->Delivery_model->getDeliveryByEmail($email);
    
                if($customer_details['profile_image']!=''){
                    $image = '../assets/images/'.$customer_details['profile_image'];
                    if(file_exists($image)){
                        $imag = $customer_details['profile_image'];
                    } else {
                       $imag = 'profile_images/no-pic.png';
                    }
                 } else {
                    $imag = 'profile_images/no-pic.png';
                 }


                $customer_data = array('id' => $customer_details['delivery_id'] ,
                    'name' => $customer_details['first_name'].' '.$customer_details['last_name'],
                                       'first_name'  => $customer_details['first_name'] ,
                                       'last_name'   => $customer_details['last_name'], 
                                       'email'       => $customer_details['email'], 
                                       'telephone'   => $customer_details['telephone'],
                                       'profile_picture'=> $imag,
                                       'language'   => $customer_details['language'],
                                       'status'      => $customer_details['status'],
                                       'otp_verified_status'  =>  $customer_details['verified_status'],
                                       'date_added'  => $customer_details['date_added'] );

                log_activity($customer_details['customer_id'], 'Login', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_details['customer_id'].'">'.$customer_details['first_name'] .' '.$customer_details['last_name'].'</a> <b>Logged in</b>.');       
                        
                $output = array('result'  => $customer_data, 
                                'message' => 'Successfully Login',
                                'status' => $customer_details['status']
                            );

                echo json_encode($output);

            }                                  

        }else{

                $error_data = array('code'  => 401 ,
                                    'error' => 'Invalid Params.');               
                $output = array('message'  => $error_data);
                
                echo json_encode($output);
        
        }

    }

    // Customer forgot password

    public function customerforgotpass_post() {
        $email = !empty($this->post('email'))? $this->post('email'): '';

        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) { 

            if ($this->Member->checkcustomeremail($email) === TRUE) {                
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
                $to_email = $email;
                $from_email_address = $this->config->item('from_email_address');
                $from_email_name = $this->config->item('from_email_name');
                
                $reset_link = base_url().'forgotpassword/setpass/?email='.$to_email.'&date='.date('Y-m-d').'&hash='.md5($to_email.'#'.date('Y-m-d').'#customer');

                $subject_data = 'Reset password link';     
                $message_data = 'Please use below link to reset password <br> <br> '.$reset_link;
    
                $mail_body = '<!DOCTYPE html><html><head><title></title></head><body>
                '.$message_data.'</body></html>';
                
                $headers = "From: ".$from_email_name."<".$from_email_address.">\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                if (mail($to_email, $subject_data, $mail_body, $headers)) {
                    $output = array('result'  => array(), 'message' => 'Password reset link has been sent in your mail');
                } else{            
                    $output = array('result'  => array(), 'message' => 'Send sending failed.');
                }  

                // $this->email->set_mailtype("html");
                // $this->email->set_newline("\r\n");
                // $this->email->set_crlf("\r\n");
                // $this->email->from($from_email_address, $from_email_name);
                // $this->email->to($to_email);
                // $this->email->subject($subject_data);
                // $this->email->message($mail_body);
                
                //Send mail
                // if ($this->email->send()) {
                //     $output = array('result'  => array(), 'message' => 'Password reset link has been sent in your mail');
                // } else{            
                //     $output = array('result'  => array(), 'message' => 'Send sending failed.');
                // }  
    
                echo json_encode($output);
            } else {
                $error_data = array('code'  => 401 , 'error' => 'Email does not exists.');               
                $output = array('message'  => $error_data);                
                echo json_encode($output);      
            }
            
                                

        }else{
            $error_data = array('code'  => 401 , 'error' => 'Invalid Params.');               
            $output = array('message'  => $error_data);                
            echo json_encode($output);        
        }
    }

    // Restaurant forgot password

    public function restaurantforgotpass_post() {
        $email = !empty($this->post('email'))? $this->post('email'): '';

        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) { 

            if ($this->Member->checkrestaurantemail($email) === TRUE) {                
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
                $to_email = $email;
                $from_email_address = $this->config->item('from_email_address');
                $from_email_name = $this->config->item('from_email_name');
                
                $reset_link = base_url().'forgotpassword/setpass/?email='.$to_email.'&date='.date('Y-m-d').'&hash='.md5($to_email.'#'.date('Y-m-d').'#restaurant');

                $subject_data = 'Reset password link';     
                $message_data = 'Please use below link to reset password <br> <br> '.$reset_link;
    
                $mail_body = '<!DOCTYPE html><html><head><title></title></head><body>
                '.$message_data.'</body></html>';
                
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");
                $this->email->set_crlf("\r\n");
                $this->email->from($from_email_address, $from_email_name);
                $this->email->to($to_email);
                $this->email->subject($subject_data);
                $this->email->message($mail_body);
                
                //Send mail
                if ($this->email->send()) {
                    $output = array('result'  => array(), 'message' => 'Password reset link has been sent in your mail');
                } else{            
                    $output = array('result'  => array(), 'message' => 'Send sending failed.');
                }  
    
                echo json_encode($output);
            } else {
                $error_data = array('code'  => 401 , 'error' => 'Email does not exists.');               
                $output = array('message'  => $error_data);                
                echo json_encode($output);      
            }
            
                                

        }else{
            $error_data = array('code'  => 401 , 'error' => 'Invalid Params.');               
            $output = array('message'  => $error_data);                
            echo json_encode($output);        
        }

    }    

    //Restaurant login section
    public function restaurant_post() {

        if ($this->validateLoginForm() === TRUE) {

            $username     = $this->post('username');
            $password     = $this->post('password');
            $franchise_id = $this->post('franchise_id');
            $deviceid     = $this->post('deviceid');
            $deviceInfo   = $this->post('deviceInfo');

            $restaurant_details = $this->Member->loginStaff($username, $password,$franchise_id,$deviceid);
            if ($loginDetails === FALSE || $restaurant_details['user_id'] ==null) {   
                $msg =   'Invalid login credentials.';          
                $output = array('message'  => $msg);
                echo json_encode($output);
           } else{
               
                
               $this->Member->insertDeviceId($username,$deviceid,$deviceInfo);
    
                $restaurant_data = array(
                    'id' => $restaurant_details['staff_id'] ,
                    'user_id' => $restaurant_details['user_id'] ,
                    'location_id'=>$restaurant_details['location_id'] ,
                    'name' => $restaurant_details['username'],
                    'staff_name'  => $restaurant_details['staff_name'] ,
                    'email'       => $restaurant_details['staff_email'], 
                    'telephone'   => $restaurant_details['staff_telephone'],
                    'profile_image'=>$restaurant_details['location_image'],
                    'language'   => $restaurant_details['language_id'],
                    'staff_group_id'      => $restaurant_details['staff_group_id'],
                    'date_added'  => $restaurant_details['date_added'] );

                // log_activity($restaurant_details['staff_id'], 'Login', 'users','<a href="'.site_url().'admin/staffs/edit?id='.$restaurant_details['staff_id'].'">'.$restaurant_details['staff_name'].'</a> <b>Logged in</b>.');       
                        
                $output = array(
                    'result'  => $restaurant_data, 
                    'message' => 'Successfully Login',
                   //'status' => $restaurant_details
                );
                echo json_encode($output);
                
            }                                  

        }else{
            $error_data = array('code'  => 401 ,'error' => 'Invalid Params.');               
            $output = array('message'  => $error_data);
            echo json_encode($output);
    
        }

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
        $resp = '0:0';
        if($deliver!=''){
            $wallet = $deliver['wallet'];
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
      
        $resul = array('id' => $user_id,
            'today_earnings' => $earnings['earnings'] ? $earnings['earnings'] : 0,
            'today_rides'  => $count,
            'login_hrs' => $resp,
            'wallet' => $currency['currency_symbol'].' '.$wallet,
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


    // Regsitration Section

    public function register_post() {

            //if ($this->validateForm() === TRUE) {
            if (TRUE) {
            $userData = array();
            
            $userData['username']              = $this->post('username');
            $userData['first_name']              = $this->post('first_name');
            $userData['last_name']               = $this->post('last_name');
            $userData['language']                = $this->post('language');
            $userData['currency']                = $this->post('currency');
            $userData['deviceid']                = $this->post('deviceid');
            $userData['email']                   = $this->post('email');
            $userData['password']                = $this->post('password');
            $userData['telephone']               = $this->post('telephone');
            /*$userData['security_question_id']    = $this->post('security_question');
            $userData['security_answer']         = $this->post('security_answer');
            $userData['newsletter']              = $this->post('newsletter');
            $userData['terms_condition']         = $this->post('terms_condition');
            $userData['customer_group_id']       = $this->post('customer_group_id');*/
            $userData['date_added']              = date("Y-m-d H:i:s");
            $userData['verify_otp']              = rand(1111,9999);
            $userData['lang']                    = $this->post('lang');

            $user_already_exists = $this->Customers_model->check_email_exists($userData['email']);

            if($user_already_exists == 0){

                // $mobile_already_exists = $this->Customers_model->check_mobile_exists($userData['telephone']);

            if($mobile_already_exists == 0){

            if ($customer_id = $this->Customers_model->saveCustomer(NULL, $userData)) {                             
                $customer_data = array('customer_id' => $customer_id ,
                                   'username' => $userData['username'],
                                   'first_name'  => $userData['first_name'] ,
                                   'last_name'   => $userData['last_name'], 
                                   'email'       => $userData['email'], 
                                   'language'    => $userData['language'],
                                   'currency'    => $userData['currency'],
                                   'deviceid'    => $userData['deviceid'],
                                   'telephone'   => $userData['telephone'],
                                   'status'      => 1, 
                                   'date_added'  => $userData['date_added'] );


                $this->load->model('Extensions_model');
                $this->load->model('Twilio_model');
                $sms_status = $this->Extensions_model->getExtension('twilio_module');

                if($sms_status['status'] == 1)
                { 
                    
                    $current_lang = $userData['lang'];
                    if(!$current_lang) { $current_lang = "english"; }
                    $sms_code = 'register_'.$current_lang;
                    $sms_template = $this->Extensions_model->getTemplates($sms_code);
                    $message = $sms_template['body'];
                    $message = str_replace("{username}",$userData['first_name'],$message);
                    //$message = str_replace("{email}",$userData['email'],$message);
                    $message = str_replace("{otp}",$userData['verify_otp'],$message);
                    if($userData['telephone']!=''){
                        $client_msg = $this->Twilio_model->Sendsms($userData['telephone'],$message);
                    }
                }                                
                log_activity($customer_id, 'New Registration', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_id.'">'.$userData['first_name'] .'  '.$userData['last_name'].'</a> <b>New Customer Registered</b>.');
       
                $output = array('result'  => $customer_data, 
                                'message' => 'Registered Successfully');

                 
                echo json_encode($output);
                exit;

            }
            }else{

               /* $error_data = array('code'  => 401 ,
                                    'error' => 'Email-id already exists.');      */
                $msg =    'Mobile Number already exists.';      
                $output = array('message'  => $msg);
                
                echo json_encode($output);
                exit;
            }

            }else{

               /* $error_data = array('code'  => 401 ,
                                    'error' => 'Email-id already exists.');      */
                $msg =    'Email-id already exists.';      
                $output = array('message'  => $msg);
                
                echo json_encode($output);
                exit;
            }

            }else{

            /*$error_data = array('code'  => 401 ,
                                    'error' => 'Invalid Params.'); */
            $msg =    'Invalid Params.';                   
            $output = array('message'  => $msg);
                
            echo json_encode($output);
            exit;


           }
    }



    public function Search_get() {
         
         $locationData = array();
         $location_info = $this->Locations_model->getLocation((int) $this->get('location'));
         /*echo "<pre>";
         print_r($location_info);
         echo "</pre>";exit;*/

    
    }

    // Edit Profile Section 


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
                if ($this->Customers_model->saveCustomer($user_id, $userData)) 
                {
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

    public function imageUpload_post(){

        if($_FILES){

            $name = time().'_'.basename($_FILES["profile_picture"]["name"]);
            $target_dir = '../assets/images/data/'.$name;
            $profile_picture = $name;

            $imagename = 'data/'.$name;

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_dir)) {
                $result['result']['image'] = $imagename;
                $result['result']['profile_picture_status'] = "Successfully uploaded";
            } else {
                $result['result']['profile_picture_status'] = "Sorry, there was an error uploading your file.";
            }
            echo json_encode($result);
        }

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
            
            $customer_exists = $this->Customers_model->check_id_exists($this->post('id'));

            if($customer_exists >= 1){            

            if(count($this->post()) <= 1){

                $result['message'] = "User Profile Updated Successfully";
                 
                $this->response($result);
                exit;

            }else{

                $customer_id = $this->post('id');  
                
                $email_exists = $this->Customers_model->check_email_exists($this->post('email'));
                if($email_exists > 0)
                {
                    $error_data = array('code'  => 401 , 'error' => 'Email id already exists.');               
                    $output = array('message'  => $error_data);    
                    echo json_encode($output);
                }
                else
                {
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
     
                     if ($customer_id = $this->Customers_model->saveCustomer($customer_id, $userData)) {
                         
                         $customer_details = $this->Customers_model->getCustomer($this->post('id'));
                         
                         $result['result'] = array();
                         $result['result']['first_name'] = $customer_details['first_name'];
                         $result['result']['last_name'] = $customer_details['last_name'];
                         $result['result']['email'] = $customer_details['email'];
                         $result['result']['telephone'] = $customer_details['telephone'];
                         $result['result']['password'] = $customer_details['password'];
                         $result['result']['vip_status'] = $customer_details['vip_status'];
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

                
            }
            
            }else{

                $result['message'] = "Invalid customer id";
                
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


    // User Address Book

    public function addAddress_post() {

        if ($this->validateAddressForm() === TRUE) {

            $customer_exists = $this->Customers_model->check_id_exists($this->post('customer_id'));
            
           


            if($customer_exists >= 1){

                $customer_id           = $this->post('customer_id');  
                $userData['address_1'] = $this->post('address_1');
                $userData['address_2'] = $this->post('address_2');
                $userData['city']      = $this->post('city');
                $userData['state']     = $this->post('state');
                $userData['postcode']  = $this->post('postcode');
                $userData['country']   = $this->post('country');
                $userData['clatitude'] = $this->post('latitude');
                $userData['clongitude']= $this->post('longitude');

                $userData['specification']= $this->post('specification');
                $userData['default_address']= $this->post('default_address');
                $address_exists = $this->Customers_model->check_address_exists($this->post('customer_id'));

                if($address_exists == 0)
                {
                    $userData['default_address'] = "on";
                }

                if ($customer_id = $this->Addresses_model->saveAddress($customer_id,'',$userData)) {

                    $customer_details = $this->Customers_model->getCustomer($customer_id);
                    $customer_data = array(
                        'customer_id' => $customer_id,
                        'address_1' => $userData['address_1'],
                        'address_2' => $userData['address_2'], 
                        'city'      => $userData['city'],
                        'state'     => $userData['state'],
                        'postcode'  => $userData['postcode'],
                        'country'   => 0
                    );
                    $output = array('result'  => $userData, 
                                'message' => 'New Addess Added Successfully');
                 
                    echo json_encode($output);

                }

        }else{
                 
            $error_data = array('code'  => 401 ,
                                'error' => 'Invalid CustomerId.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);

            }

        }else{
            $rep = array('<p>','</p>');
            $validation =  str_ireplace($rep,' ',validation_errors());
            $exp = explode('.',$validation);
            $error_data = array('code'  => 401 ,
                                'error' => $exp[0]);               
            $output = array('message'  => $error_data);
            echo json_encode($output);
        }
    }


    public function editAddress_post() {

        $update_details = "";

        if ($this->validateEditAddressForm() === TRUE) {

            $customer_address_exists = $this->Customers_model->check_address_id_exists($this->post('customer_id'),$this->post('address_id'));

            if($customer_address_exists >= 1){

                $customer_id               = $this->post('customer_id');  
                $address_id                = $this->post('address_id'); 

                if(!empty($this->post('address_1'))){ 
                $userData['address_1']     = $this->post('address_1'); }

                if(!empty($this->post('address_2'))){ 
                $userData['address_2']     = $this->post('address_2'); }

                if(!empty($this->post('city'))){ 
                $userData['city']          = $this->post('city'); }

                if(!empty($this->post('state'))){ 
                $userData['state']         = $this->post('state'); }

                if(!empty($this->post('postcode'))){ 
                $userData['postcode']      = $this->post('postcode'); }

                if(!empty($this->post('country'))){
                $userData['country']       = $this->post('country'); }

                if(!empty($this->post('latitude'))){
                    $userData['clatitude']       = $this->post('latitude');
                }
                
                if(!empty($this->post('longitude'))){
                    $userData['clongitude']       = $this->post('longitude');
                }

                if(!empty($this->post('specification'))){
                    $userData['specification']= $this->post('specification');
                }

                if(!empty($this->post('default_address'))){
                    $userData['default_address']=$this->post('default_address');
                }    

                if ($customer_id = $this->Addresses_model->saveAddress($customer_id,$address_id,$userData)) {

                    $customer_details = $this->Customers_model->getCustomer($customer_id);


                    $update_details = "'customer_id' => $customer_id,'address_id' => $address_id";

                    $output = array('result'  => $userData, 
                                'message' => 'Address Updated Successfully');

                 
                    echo json_encode($output);

                }
            }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'Invalid CustomerId or AddressId.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);

            }

        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'Invalid Params.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);

        }
    }

    public function removeAddress_post(){

        $id = $this->post('id');
        $cust_id = $this->post('customer_id');
        $this->db->where('address_id',$id);
        $this->db->delete('addresses');

        $output = array( 
        'message' => 'Address Deleted Successfully');
        echo json_encode($output);
    }

    public function defaultAddress_post(){

        $id = $this->post('id');
        $cust_id = $this->post('customer_id');
        $this->db->where('customer_id',$cust_id);
        $this->db->update('addresses',array('default_address'=>'off'));

        $this->db->where('address_id',$id);
        $this->db->update('addresses',array('default_address'=>'on'));        
        $output = array( 
        'message' => 'Address updated Successfully');
        echo json_encode($output);               
    }

    public function getdefaultAddress_get() {

        $customer_id = $this->get('customer_id');
        $address_id = $this->get('address_id');
        if (!empty($customer_id) && is_numeric($customer_id)){

        $address_exists = $this->Customers_model->check_address_exists($customer_id);

        if($address_exists > 0){

        $address_details = $this->Addresses_model->getDefault($address_id,$customer_id);    
        
        $output = array('result'  => $address_details, 
                                'message' => 'Address List');
        echo json_encode($output);



        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'No Address Found.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);

        }

        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'Invalid Params.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);

        }
    
    }

    public function viewAddress_get() {

        $customer_id = $this->get('customer_id');

        if (!empty($customer_id) && is_numeric($customer_id)){

        $address_exists = $this->Customers_model->check_address_exists($customer_id);

        if($address_exists > 0){

        $address_details = $this->Customers_model->getAddress($customer_id);

        $output = array('result'  => $address_details, 
                                'message' => 'Address List');
        echo json_encode($output);



        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'No Address Found.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);

        }

        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'Invalid Params.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);

        }
    
    }


    public function deleteAddress_get() {
        
        $address_details = array();
        $customer_id = $this->get('customer_id');
        $address_id = $this->get('address_id');

        //echo $customer_id.'<br/>'.$address_id;exit;

        if (!empty($customer_id) && is_numeric($customer_id) && !empty($address_id) && is_numeric($address_id)){

           $customer_address_exists = $this->Customers_model->check_address_id_exists($customer_id,$address_id);

        if($customer_address_exists >= 1){

        if ($this->Addresses_model->deleteAddress($customer_id, $address_id)) {


             $address_details['customer_id']     = $customer_id;
             $address_details['address_id']      = $address_id;

             $output = array('result'  => $address_details, 
                                'message' => 'Address Deleted Successfully');
             echo json_encode($output);


        }


        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'No Address Found.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);


        }

        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'Invalid Params.');               
            $output = array('message'  => $error_data);
                
            echo json_encode($output);

        }

    }


    private function validateEditAddressForm() {
        // START of form validation rules
        if(!empty($this->post('address_1'))){

        $this->form_validation->set_rules('address_1', 'address_1', 'xss_clean|trim|required|min_length[3]|max_length[128]');

        }

        if(!empty($this->post('address_2'))){

            $this->form_validation->set_rules('address_2', 'address_2', 'xss_clean|trim|max_length[128]');
        }  

        if(!empty($this->post('city'))){

            $this->form_validation->set_rules('city', 'city', 'xss_clean|trim|required|min_length[2]|max_length[128]');

        }    

        if(!empty($this->post('state'))){

            $this->form_validation->set_rules('state', 'state', 'xss_clean|trim|max_length[128]');

        }  

        if(!empty($this->post('postcode'))){

            $this->form_validation->set_rules('postcode', 'postcode', 'xss_clean|trim|min_length[2]|max_length[11]');

        }


        if(!empty($this->post('country'))){

            $this->form_validation->set_rules('country', 'country', 'xss_clean|trim|required|integer');

        }

        if ($this->form_validation->run() === TRUE) {                                           // checks if form validation routines ran successfully
            return TRUE;
        } else {
            return FALSE;
        }
    }


    private function validateAddressForm() {

        // print_r($this->post());exit;

        // START of form validation rules
        $this->form_validation->set_rules('address_1', 'Location', 'xss_clean|trim|required|min_length[3]');
        $this->form_validation->set_rules('address_2', 'address_2', 'xss_clean|trim');
        $this->form_validation->set_rules('city', 'city', 'xss_clean|trim|required|min_length[2]|max_length[128]');
        $this->form_validation->set_rules('state', 'state', 'xss_clean|trim|max_length[128]');
        $this->form_validation->set_rules('postcode', 'postcode', 'xss_clean|trim|min_length[2]|max_length[11]');
        $this->form_validation->set_rules('country', 'country', 'xss_clean|trim');
        // END of form validation rules

        if ($this->form_validation->run() === TRUE) {                                           // checks if form validation routines ran successfully
            return TRUE;
        } else {
            return FALSE;
        }
    }


    // Login Form Validation Section

    private function validateLoginForm() {
        return TRUE;
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[32]');
        
        if ($this->form_validation->run() === TRUE) {                                           
            return TRUE;
        } else {
            return FALSE;
        }

    }

    // Login Form Validation Section

    private function validateSocialLoginForm() {
        return TRUE;
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required|valid_email');
        $this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('socialtype', 'Social Type', 'xss_clean|trim|required');
        $this->form_validation->set_rules('logintoken', 'Login Token', 'xss_clean|trim|required');

        if ($this->form_validation->run() === TRUE) {                                           
            return TRUE;
        } else {
            return FALSE;
        }

    }

    // Profile Edit Validation Section

    private function validateEditForm() {

        $this->form_validation->set_rules('id', 'Id', 'xss_clean|trim|required|integer');

        if(!empty($this->post('first_name'))){

        $this->form_validation->set_rules('first_name', 'Firstname', 'xss_clean|trim|required|min_length[2]|max_length[32]'); 
        }

        if(!empty($this->post('last_name'))){

        $this->form_validation->set_rules('last_name', 'Lastname', 'xss_clean|trim|required|min_length[2]|max_length[32]'); 
        }

        if(!empty($this->post('email'))){

        $this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required|valid_email');
        }

        if(!empty($this->post('password'))){

        $this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[32]');
        }

        if(!empty($this->post('telephone'))){

        $this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|min_length[10]|integer');
        }

        if ($this->form_validation->run() === TRUE) {                                           
            return TRUE;
        } else {
            return FALSE;
        }

    }

    // Regsitration Form Validation Section

    private function validateForm() {
        // return TRUE;
        $this->form_validation->set_rules('first_name', 'Firstname', 'xss_clean|trim|required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', 'Lastname', 'xss_clean|trim|required|min_length[2]|max_length[32]');
        //$this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tyehnd0gd_customers.email]');
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[32]');
        //$this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
        //$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'xss_clean|trim|required');
        $this->form_validation->set_rules('telephone', 'Telephone', 'xss_clean|trim|required|min_length[10]');

        if ($this->form_validation->run() === TRUE) {                                           
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function viewProfile_post() {
        $customer_id = $this->post('id');
        $customer_details = $this->Customers_model->getCustomer($customer_id);
        
        if(empty($customer_details)){
            $result['message'] = "Invalid customer id";
            $this->response($result);
            exit;
        }
        $result['result'] = array();
        $result['result']['first_name'] = $customer_details['first_name'];
        $result['result']['last_name'] = $customer_details['last_name'];
        $result['result']['email'] = $customer_details['email'];
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

    public function passwordreset_post() {
        $customer_mail  = $this->post('email');
        $reset['email'] = $customer_mail;  
        $customer_details = $this->Customers_model->getCustomerByEmail($customer_mail);

        if(empty($customer_details)) {
            $result['message'] = "Invalid Email ID";
            $this->response($result);
            exit;
        }

        $data = $this->Customers_model->resetPassword($customer_mail, $reset);
        /*$result['result'] = array();
        $result['result']['name'] = $customer_details['first_name'];
        $result['result']['email'] = $customer_details['email'];
        $result['result']['telephone'] = $customer_details['telephone'];
        $result['result']['password'] = $customer_details['password'];
        $result['result']['vip_status'] = $customer_details['vip_status'];
        if($customer_details['language'] == 11){
            $result['result']['language'] = "English";
        }else{
            // $result['result']['language'] = "Arabic";
        }

        if($customer_details['currency'] == 187){
            // $result['result']['currency'] = "SAR";
        }else{
            // $result['result']['currency'] = "USD";
        }
        // $result['result']['profile_picture'] = $customer_details['profile_picture'];*/

        $result['result'] = $data;
        $result['message'] = "Success";
        $result['content'] = "Generated password sent to mail";

        $this->response($result);
    }

    public function setpass_post(){

        $userid = $this->post('user_id');
        $customer_mail = $this->post('password');
        $customer_details = $this->Customers_model->getCustomer($userid);
            // print_r($customer_details);exit;
        if(empty($customer_details)) {
            $result['message'] = "Invalid user";
            $this->response($result);
            exit;
        }
        $reset['email'] = $customer_details['email'];
        $this->Customers_model->setpassword($customer_mail, $reset);
        $result['message'] = "Success";
        $result['content'] = "Password set successfully";
        $this->response($result);

    }

    public function passwordupdate_post() {
        // $customer_mail = $this->post('email');
        $customer_id   = $this->post('user_id');
        $old_password  = $this->post('old_pass');
        $new_password  = $this->post('new_pass');
        $language = $this->post('language');

        $userData['password'] = $new_password;

        if(strtolower($language)=='en'){
         $lang = 'english';
        } else if(strtolower($language)=='ar'){
         $lang = 'arabic';
        } else {
         $lang = 'english';
        }

        //$reset['email'] = $customer_mail;
        $customer_details = $this->Customers_model->getCustomer($customer_id);
        if(empty($customer_details)) {
            $result['message'] = "Invalid Customer Id";
            $this->response($result);
            exit;
        }
        // print_r($customer_details);exit;
        if($customer_details['customer_id']!=$customer_id){
           $result['message'] = "Invalid user";
            $this->response($result);
            exit;    
        }

        $check = $this->customer->checkPassword($old_password,$customer_id);
        if(empty($check)){
            $result['message'] = "Old Password does not match";
            $this->response($result);
            
        } else {
           if($new_password!=''){
            $customer = $this->Customers_model->saveCustomer($customer_id, $userData);
             if($customer){
                $result['message'] = "Success";
                $result['content'] = "Password changed successfully";
                log_activity($customer_id, 'Password Updated', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_id.'">'.$customer_details['first_name'] .' '.$customer_details['last_name'].'</a> <b>Password Updated</b>.');
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
    public function checkVerifyOTP_post() {
        
        $customer_mail  = $this->post('email');
        $verify_otp     = $this->post('verify_otp');
        $reset['email'] = $customer_mail;  
        if(!empty($customer_mail) && !empty($verify_otp))
        {
            $customer_details = $this->Customers_model->getCustomerByEmail($customer_mail);
            if($customer_details['verify_otp'] != $verify_otp) {
                $msg =   'OTP not match';          
                $output = array('message'  => $msg);
                echo json_encode($output);
                exit;
            }
            else
            {
                $update_status = $this->Customers_model->verifystatusupdate($customer_details['customer_id']);
                $customer_data = array('customer_id' => $customer_details['customer_id'] ,
                                           'first_name'  => $customer_details['first_name'] ,
                                           'last_name'   => $customer_details['last_name'], 
                                           'email'       => $customer_details['email'], 
                                           'telephone'   => $customer_details['telephone'],
                                           'language'   => $customer_details['language'],
                                           'profile_image'=> $customer_details['profile_image'],
                                           'status'      => $customer_details['status'],
                                           'otp_verified_status'  =>  $customer_details['verified_status'],
                                           'date_added'  => $customer_details['date_added'] );               
                $output = array('result'  => $customer_data, 
                                    'message' => 'OTP Match');

                echo json_encode($output);
            }        
        }
        else
        {
            $msg =   'Invalid Params';          
            $output = array('message'  => $msg);
            echo json_encode($output);
            exit;
        }        
        
        /*$result['message'] = "Success";
        $result['content'] = "Generated password sent to mail";

        $this->response($result);*/
    }
    public function resendOTPCode_post() {
        
        $customer_mail  = $this->post('email');
        $language       = $this->post('language');
        if(!empty($customer_mail))
        {
            $customer_details = $this->Customers_model->getCustomerByEmail($customer_mail);
                
            $this->load->model('Twilio_model');
            
            $sms_status = $this->Extensions_model->getExtension('twilio_module');

            if($sms_status['status'] == 1)
            { 
                $verify_otp    = rand(1111,9999);
                $current_lang = $language;
                if(!$current_lang) { $current_lang = "english"; }
                $sms_code = 'resend_'.$current_lang;
                $sms_template = $this->Extensions_model->getTemplates($sms_code);
                $message = $sms_template['body'];
                $message = str_replace("{email}",$customer_details['email'],$message);
                $message = str_replace("{otp}",$verify_otp,$message);
                if($customer_details['telephone']!=''){
                    $client_msg = $this->Twilio_model->Sendsms($customer_details['telephone'],$message);
                }
                $update_otp_code = $this->Customers_model->verifyotpupdate($customer_details['customer_id'],$verify_otp);
                $output = array('message' => 'OTP Sent');

                echo json_encode($output);
            }
            else
            {
                    $msg =   'SMS not sent';          
                    $output = array('message'  => $msg);
                    echo json_encode($output);
                    exit;
            }  

        }
        else
        {
            $msg =   'Invalid Params';          
            $output = array('message'  => $msg);
            echo json_encode($output);
            exit;
        }        
        
        /*$result['message'] = "Success";
        $result['content'] = "Generated password sent to mail";

        $this->response($result);*/
    }
    public function updateMobileNumber_post() {
        
        $customer_mail      = $this->post('email');
        $customer_mobile    = $this->post('mobile');
        $language       = $this->post('language');
        if(!empty($customer_mail))
        {
            $customer_details = $this->Customers_model->getCustomerByEmail($customer_mail);
            
            $mobile_already_exists = $this->Customers_model->check_mobile_exists($customer_mobile);

            if($mobile_already_exists == 0){

            $this->load->model('Twilio_model');
            
            $sms_status = $this->Extensions_model->getExtension('twilio_module');

                if($sms_status['status'] == 1)
                { 
                    $verify_otp    = rand(1111,9999);
                    $current_lang = $language;
                    if(!$current_lang) { $current_lang = "english"; }
                    $sms_code = 'register_'.$current_lang;
                    $sms_template = $this->Extensions_model->getTemplates($sms_code);
                    $message = $sms_template['body'];
                    $username = $customer_details['first_name'] .' '.$customer_details['last_name'];
                    $message = str_replace("{email}",$customer_details['email'],$message);
                    $message = str_replace("{username}",$username,$message);
                    $message = str_replace("{otp}",$verify_otp,$message);
                    if($customer_mobile!=''){
                        $client_msg = $this->Twilio_model->Sendsms($customer_mobile,$message);
                    }
                    $update_otp_code = $this->Customers_model->verifyotpupdate($customer_details['customer_id'],$verify_otp,$customer_mobile);
                    $output = array('message' => 'Mobile Number Updated and OTP Sent');

                    echo json_encode($output);
                }
                else
                {
                        $msg =   'SMS not sent';          
                        $output = array('message'  => $msg);
                        echo json_encode($output);
                        exit;
                } 
            }
            else
            {
               $msg =   'Mobile Already Exist';          
                        $output = array('message'  => $msg);
                        echo json_encode($output);
                        exit; 
            } 

        }
        else
        {
            $msg =   'Invalid Params';          
            $output = array('message'  => $msg);
            echo json_encode($output);
            exit;
        }        
        
        /*$result['message'] = "Success";
        $result['content'] = "Generated password sent to mail";

        $this->response($result);*/
    }
}
 ?>