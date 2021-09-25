<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class subscriptions extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Subscriptions_model');

        define('STRIPE_MODE', 'DEV');
        define('STRIPE_KEY_DEV', 'sk_test_51GxRVFJpxyLWDkuo0rVAU4nxTR0eyPLidiQ92igKB3MsUuK2R5uhEbH2LEGIszV7sTLrGDNWLyt8yNDlufBioYNG00A3K8ZAuY');
        define('STRIPE_KEY_LIVE', 'sk_test_51GxRVFJpxyLWDkuo0rVAU4nxTR0eyPLidiQ92igKB3MsUuK2R5uhEbH2LEGIszV7sTLrGDNWLyt8yNDlufBioYNG00A3K8ZAuY');

    }
    // Trainers List

    public function subscron_get() {
  

                
        //$STRIPE_KEY  = '';
        if(STRIPE_MODE == 'DEV'){
            $STRIPE_KEY =  STRIPE_KEY_DEV;
        } else if($MODE == 'LIVE'){
            $STRIPE_KEY = STRIPE_KEY_LIVE;
        }

                 


        $data = $this->Subscriptions_model->getDiscontinueSubscriberList();
        if(!empty($data)){
            foreach($data as $info){

                //Now findout the user from workout_video_purchases table and update his/her subsscription status to cancelled 
                $user_info  = $this->Subscriptions_model->getSubscriptionByEmail($info['email']);
                foreach($user_info as $user){
                    // Update that entry is_active = 0 , if purchase_type = subscription then also call the stripe api to cancel that subscription with the subsciption id 
                    $this->Subscriptions_model->updateSubscription($user['video_purchase_id'],$info['is_agreed_to_continue']);
 

                    require_once('../stripe-checkout-session/stripe-php/init.php');    
                    \Stripe\Stripe::setApiKey($STRIPE_KEY);    
                                        //Now update the subscription 
                    $subscription = \Stripe\Subscription::retrieve($info['subscription_id']);                     
                    $result = $subscription->cancel();
                   

                    
                }
            }
        }


    }

 

    public function unsubs_post()
    {        
        
        if(STRIPE_MODE == 'DEV'){
            $STRIPE_KEY =  STRIPE_KEY_DEV;
        } else if($MODE == 'LIVE'){
            $STRIPE_KEY = STRIPE_KEY_LIVE;
        }
 
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('email')))){
                $error_message .= 'First name is missing';
            }

            if(empty($error_message))
                {
                    
                    $user_info  = $this->Subscriptions_model->getSubscriptionByEmail($this->post('email'));
                    //print_r($user_info);

                    foreach($user_info as $user){
                        // Update that entry is_active = 0 ,if purchase_type = subscription then also call the stripe api to cancel that subscription with the subsciption id 
                        $this->Subscriptions_model->updateSubscription($user['video_purchase_id'],0);
                         $this->Subscriptions_model->updateSubscriptionRecord($this->post('email'),0,$user['subscription_id']);

                         
     

                            if($user['is_active']==1 and $user['subscription_id']!=''){

                               //echo 'test' ; die('ee') ; 
                                require_once('../stripe-checkout-session/stripe-php/init.php');    
                                \Stripe\Stripe::setApiKey($STRIPE_KEY);    
                                                    //Now update the subscription 
                                $subscription = \Stripe\Subscription::retrieve($user['subscription_id']);                     
                                $result = $subscription->cancel();
                                //print_r($result);
                            }                            


                    }                      

                    $output = array('message'  => 'Successfully updated ');
                    echo json_encode($output);
                    exit;

                }else{
                    $output = array('message'  => $error_message);
                    echo json_encode($output);
                    exit;                    
                }    

 
        }else{
            $output = array('message'  => 'Invalid post data');
                    echo json_encode($output);
                    exit;  
        }

    }






    public function modulelist_get() {
        $output = array();
        $List = $this->Subscriptions_model->getModuleList();               
        if(!empty($List)){
            $result = $List;
            $output    = array('result'  => $List,
            'message'  => 'Module List Fetched');
        }else{
            $error_data = array('code'  => 401 ,
            'error' => 'Trainer Not Found.');
            $output = array('message'  => $error_data);
        }

        echo json_encode($output);

    }


    public function calculators_get() {
        $List = $this->Subscriptions_model->getCalculatorList();
        if(!empty($List)){ 
            $output    = array('code' => 200 , 'result'  => $List,
            'message'  => 'Calculator List Fetched');
        }else{
            $error_data = array('code'  => 401 ,
            'error' => 'No list found .');
            $output = array('message'  => $error_data);
        }

        echo json_encode($output);

    }


    /*
    *Cancel subscription
    */
    public function cancelSubscription_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('trainer_email')))){
                $error_message .= 'Trainer Email is missing';
            }
            if(empty(trim($this->post('package_id')))){
                $error_message .= 'Package ID is missing';
            }

            if(empty($error_message))
            {
                $trainer_email  = $this->post('trainer_email');
                $package_id     = $this->post('package_id');
                /*check exists or not*/
                $currentPlanDetails = $this->Subscriptions_model->getCustomerSbscriptionCurrentPlan($trainer_email, $package_id);
                if($currentPlanDetails->num_rows()>0)
                {
                    $details = $currentPlanDetails->row();
                    $packagePurchaseId = $details->package_purchase_id;
                    $trainerid = $this->Subscriptions_model->getTrainerDetailsByEmail($trainer_email);

                    /*Deactivate the plan*/
                    if($cancelSubscription = $this->Subscriptions_model->cancelSubscription($packagePurchaseId, 0, $trainerid[0]['trainer_id']))
                    {
                        $output = array('message'  => "Plan Cancelled Successfully.");
                        echo json_encode($output);
                        exit;
                    }
                    else
                    {
                        $output = array('message'  => "Something went wrong.");
                        echo json_encode($output);
                        exit;
                    }
                }
                else
                {
                    $output = array('message'  => "Plan Does not exists.");
                    echo json_encode($output);
                    exit;
                }
            }
            else
            {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }
        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }
  
}
 ?>