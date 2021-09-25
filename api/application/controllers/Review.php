<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

class review extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Member','Customers_model','Locations_model'));
        $this->load->library(array('form_validation','Customer'));
        $this->load->helper('security');
    }

    
    public function view_get() {
         
        $customer_id = $this->get('customer_id');

        if (!empty($customer_id) && is_numeric($customer_id)){

        $review_exists = $this->Customers_model->check_review_exists($customer_id);

        if($review_exists > 0){

        $review_details = $this->Customers_model->getReviews($customer_id);

        $output = array('result'  => $review_details, 
                                'message' => 'Review List');
        echo json_encode($output);



        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'No Review Found.');               
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
}
 ?>