<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class Ptservices extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Ptservices_model'));
    }  

    /*
    * Training program
    */
    public function list_get() {
        $output = array();
       
        $getAllServices = $this->Ptservices_model->getAllServices();
        if(!empty($getAllServices)){                
            $output    = array('result'  => $getAllServices,
            'message'  => 'Certificate records Fetched');
        } else {
            $error_data = array('code'  => 401 , 'error' => 'Certificate Not Found.');
            $output = array('message'  => $error_data);
        }        

        echo json_encode($output);
    }

    /*
    * Training certificate by trainer id
    */
    public function trainerservices_get($trainer_id = '') {
        $output = array();
        $trainer_id = $this->input->get('trainer_id');

        if(empty($trainer_id)){
            $error_data = array('code'  => 401 , 'error' => 'Trainer info Not Found.');
            $output = array('message'  => $error_data);
        } else {
            $getServicesByTrainerId = $this->Ptservices_model->getServicesByTrainerId($trainer_id);
            if(!empty($getServicesByTrainerId)){                
                $output    = array('result'  => $getServicesByTrainerId,
                'message'  => 'Trainer services records Fetched');
            } else {
                $error_data = array('code'  => 401 , 'error' => 'Trainer certificate Not Found.');
                $output = array('message'  => $error_data);
            }
        }

        echo json_encode($output);

    }
}
 ?>