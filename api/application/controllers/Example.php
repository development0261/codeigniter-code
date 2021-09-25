<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

//include Rest Controller library
//echo APPPATH . '/libraries/REST_Controller.php';exit;
//echo "aas";exit;
//use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
//use Restserver\Libraries\REST_Controller;

 //require('application/libraries/REST_Controller.php');

class Example extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        //load user model
        $this->load->model('user');
    }


     public function user_get($id='') {
        //returns all rows if the id parameter doesn't exist,
        //otherwise single row will be returned
        
        $users = $this->user->getRows($id);

        if(!empty($users)){
            //set the response and exit
            $this->response($users, REST_Controller::HTTP_OK);
        }else{
            //set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    public function user_post() {
        
        $userData = array();

        /*$userData['first_name'] = $this->post('first_name');
        $userData['last_name'] = $this->post('last_name');
        $userData['email'] = $this->post('email');
        $userData['phone'] = $this->post('phone');*/

            $userData['first_name']              = $this->input->post('first_name');
            $userData['last_name']               = $this->input->post('last_name');
            $userData['email']                   = $this->input->post('email');
            $userData['password']                = $this->input->post('password');
            $userData['telephone']               = $this->input->post('telephone');
            $userData['security_question_id']    = $this->input->post('security_question');
            $userData['security_answer']         = $this->input->post('security_answer');
            $userData['newsletter']              = $this->input->post('newsletter');
            $userData['terms_condition']         = $this->input->post('terms_condition');
            $userData['customer_group_id']       = $this->input->post('customer_group_id');
            $userData['date_added']              = $this->input->post('date_added');

           // && !empty($userData['email']) && !empty($userData['password']) && !empty($userData['telephone']) && !empty($userData['security_question_id']) && !empty($userData['security_answer']) && !empty($userData['newsletter']) && !empty($userData['terms_condition']) && !empty($userData['customer_group_id']) && !empty($userData['date_added'])



            echo "<pre>";
            print_r($userData);exit;
            echo "</pre>";


           if(!empty($userData['first_name']) && !empty($userData['last_name'])){

            
            echo "<pre>";
            print_r($userData);exit;
            echo "</pre>";


            //insert user data
            $insert = $this->user->insert($userData);
            
            //check if the user data inserted
            if($insert){
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User has been added successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            //set the response and exit
            $this->response("Provide complete user information to create.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }




     public function user_delete($id=''){
        //check whether post id is not empty
        if($id){
            //delete post
            
            $delete = $this->user->delete($id);
            
            if($delete){
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User has been removed successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            //set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }  


    public function user_put() {
        $userData = array();
        $id = $this->put('id');
        $userData['first_name'] = $this->put('first_name');
        $userData['last_name'] = $this->put('last_name');
        $userData['email'] = $this->put('email');
        $userData['phone'] = $this->put('phone');
        if(!empty($id) && !empty($userData['first_name']) && !empty($userData['last_name']) && !empty($userData['email']) && !empty($userData['phone'])){
            //update user data
            $update = $this->user->update($userData, $id);
            
            //check if the user data updated
            if($update){
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_post(){

        $userData = array();

        $id = $this->post('id');
        $userData['first_name'] = $this->post('first_name');
        $userData['last_name'] = $this->post('last_name');
        $userData['email'] = $this->post('email');
        $userData['phone'] = $this->post('phone');

         if(!empty($id) && !empty($userData['first_name']) && !empty($userData['last_name']) && !empty($userData['email']) && !empty($userData['phone'])){
            //update user data
            $update = $this->user->update($userData, $id);
            
            //check if the user data updated
            if($update){
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function razorpay_get() {        
        $postData = array(
            "type" => "link",
            "amount" => "10000",
            "currency" => "INR",
            "description" => "Payment Link for services offered"
        );
        $fields = json_encode($postData);

        $ch = curl_init();        
        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/invoices');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_USERPWD, "rzp_test_agIuiofegiEopy:8uZVFKAlVUFhcHBdE7uJlTCL");
        
        $headers   = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close($ch);

        echo 'AA<pre>';        
        print_r($result);
        exit;
    }
}
 ?>