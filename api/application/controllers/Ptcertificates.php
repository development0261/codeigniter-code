<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class Ptcertificates extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Ptcertificates_model'));
    }  

    /*
    * Training program
    */
    public function list_get() {
        $output = array();
       
        $getAllCertificates = $this->Ptcertificates_model->getAllCertificates();
        if(!empty($getAllCertificates)){                
            $output    = array('result'  => $getAllCertificates,
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
    public function trainercertificates_get($trainer_id = '') {
        $output = array();
        $trainer_id = $this->input->get('trainer_id');

        if(empty($trainer_id)){
            $error_data = array('code'  => 401 , 'error' => 'Trainer info Not Found.');
            $output = array('message'  => $error_data);
        } else {
            $getCertificatesByTrainerId = $this->Ptcertificates_model->getCertificatesByTrainerId($trainer_id);
            if(!empty($getCertificatesByTrainerId)){                
                $output    = array('result'  => $getCertificatesByTrainerId,
                'message'  => 'Trainer certificates records Fetched');
            } else {
                $error_data = array('code'  => 401 , 'error' => 'Trainer certificate Not Found.');
                $output = array('message'  => $error_data);
            }
        }

        echo json_encode($output);

    }

    // Update certificate by trainer

    public function updatecertificate_put() 
    {   
        $trainer_id                         = $this->put('trainer_id');
        $pt_certificates                    = $this->put('pt_certificates');       
        /*
        * Check if customer exists
        */
        // $check_trainer = $this->Ptcertificates_model->check_trainer_exists($trainer_id);
        // if(!empty($check_trainer))
        // {            
        $userData = array();
    
        $userData['trainer_id']                   = $this->put('trainer_id');
        $userData['pt_certificates']              = $this->put('pt_certificates');
            
        $updateCount = $this->Ptcertificates_model->updateCertificates($userData, $trainer_id);
            
        $output = array('message'  => 'Certificate updated successfully');            
        echo json_encode($output);
        exit;            
        // }
        // else
        // {
        //     $msg =    'Trainer does not exists.';      
        //     $output = array('message'  => $msg);            
        //     echo json_encode($output);
        //     exit;
        // }
    }

    // Update services by trainer

    public function updateservices_put() 
    {   
        $trainer_id                         = $this->put('trainer_id');
        $pt_services                        = $this->put('pt_services');       
        /*
        * Check if customer exists
        */
        // $check_trainer = $this->Ptcertificates_model->check_trainer_exists($trainer_id);
        // if(!empty($check_trainer))
        // {            
        $userData = array();
    
        $userData['trainer_id']                   = $this->put('trainer_id');
        $userData['pt_services']                  = $this->put('pt_services');
            
        $updateCount = $this->Ptcertificates_model->updateServices($userData, $trainer_id);
            
        $output = array('message'  => 'Services updated successfully');            
        echo json_encode($output);
        exit;            
        // }
        // else
        // {
        //     $msg =    'Trainer does not exists.';      
        //     $output = array('message'  => $msg);            
        //     echo json_encode($output);
        //     exit;
        // }
    }
}
 ?>