<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

class reservation extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Member','Customers_model','Locations_model','Reservations_model'));
        $this->load->library(array('form_validation','Customer','Location'));
        $this->load->helper('security');
    }

    // Login Section

    public function makeReservation_post() {

        if ($this->validateReservationForm() === TRUE) {
           
           $customer_exists = $this->Customers_model->check_id_exists($this->post('customer_id'));

           if($customer_exists > 0){

           $customer_details = $this->Customers_model->getCustomer($this->post('customer_id'));

           $reservationData = array();
           $reservationData['location']    = $this->post('location');
           $reservationData['table_id']    = $this->post('table_id');
           $reservationData['guest_num']   = $this->post('guest_num');
           $reservationData['reserve_date']= mdate('%d-%m-%Y', strtotime($this->post('reserve_date')));
           $reservationData['reserve_time']= mdate('%H:%i', strtotime($this->post('reserve_time')));
           $reservationData['customer_id'] = $this->post('customer_id');
           $reservationData['first_name']  = $customer_details['first_name'];
           $reservationData['last_name']   = $customer_details['last_name'];
           $reservationData['email']       = $customer_details['email'];
           $reservationData['telephone']   = $customer_details['telephone'];
           $reservationData['date_added']  = date("Y-m-d H:i:s");
           $reservationData['reservation_id'] = $this->Reservations_model->addReservation($reservationData);
           $output = array('result'  => $reservationData, 
                                'message' => 'Reservation done Successfully');
           echo json_encode($output);

           }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'Invalid CustomerId.');               
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


    public function view_post() {

        $customer_id = $this->post('customer_id');

        if (!empty($customer_id) && is_numeric($customer_id)){

        $reservation_exists = $this->Reservations_model->check_reservation_exists($customer_id);

        if($reservation_exists > 0){

        $reservation_details = $this->Reservations_model->getReservationsNew($customer_id);

        $output = array('result'  => $reservation_details, 
                                'message' => 'Reservation List');
        echo json_encode($output);



        }else{

            $error_data = array('code'  => 401 ,
                                'error' => 'No Reservation Found.');               
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

    // Login Form Validation Section

    private function validateReservationForm() {

        $this->form_validation->set_rules('location', 'Location', 'xss_clean|trim|required|integer');
        $this->form_validation->set_rules('guest_num', 'Guest Num', 'xss_clean|trim|required|integer');
        //$this->form_validation->set_rules('reserve_date', 'Reserve Date', 'xss_clean|trim|required|callback__validate_date');
        $this->form_validation->set_rules('reserve_date', 'Reserve Date', 'xss_clean|trim|required');
        $this->form_validation->set_rules('reserve_time', 'Reserve Time', 'xss_clean|trim|required|callback__validate_time');
        $this->form_validation->set_rules('customer_id', 'Customer Id', 'xss_clean|trim|required|integer');

        if ($this->form_validation->run() === TRUE) {                                           
            return TRUE;
        } else {
            return FALSE;
        }

    }


    public function _validate_date($str) {
        if (strtotime($str) < time()) {
            $this->form_validation->set_message('_validate_date', 'sddssd');
            return FALSE;
        } else {
            return TRUE;
        }
    }


     public function _validate_time($str) {

        if (!empty($str)) {

            $reserve_time = strtotime(urldecode($str));

            if ($hour = $this->Locations_model->getOpeningHourByDay(urldecode($this->post('location')), $this->post('reserve_date'))) {
                if ($hour['status'] === '1' AND (strtotime($hour['open']) <= $reserve_time AND strtotime($hour['close']) >= $reserve_time)) {
                    return TRUE;
                }
            }

            $this->form_validation->set_message('_validate_time', 'Validation Time');
            return FALSE;
        }
    }




}
 ?>