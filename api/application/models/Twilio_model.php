<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Twilio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        /*$this->load->model('twilio_module/Twilio_model');
        $this->lang->load('twilio_module/twilio_module');*/
        $this->load->library('twilio');
    }

  
     public function Sendsms($phone,$message) {

        
        $from = '+14792402098';
        $to = $phone;
        //$message = 'Your Booking ID is'.$booking_id.' ';

        $response = $this->twilio->sms($from, $to, $message);
        
        if($response->IsError)

            return $response->ErrorMessage;
            //echo 'Error: ' . $response->ErrorMessage;
        else
            return true;
            //echo 'Sent message to ' . $to;
     }
}

/* End of file twilio_module.php */
/* Location: ./extensions/twilio_module/controllers/twilio_module.php */