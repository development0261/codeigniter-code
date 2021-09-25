<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

class Stripe extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Stripe_model'));
        $this->load->library(array('form_validation','Customer'));
        $this->load->helper('security');
    }

    
    public function index_get() {
         
        $location_id=$this->uri->segment(2);
        if(is_numeric($location_id)){
            $locationStripeSql=$this->Stripe_model->getStripeBasedOnLocation($location_id);
            if($locationStripeSql->num_rows() >0){
                $storydata=$locationStripeSql->result();
                $output = array('result'  => $storydata, 
                'message' => 'Stripe Search');
               
            }else{
                $error_data = array('code'  => 401 ,
                'error' => 'Stripe Detail Not Found.');               
                $output = array('message'  => $error_data);
               
            }
        }
        else{
            $error_data = array('code'  => 401 ,
            'error' => 'Story Not Found.');               
            $output = array('message'  => $error_data);
           
        }
        echo json_encode($output);
    }
}
 ?>