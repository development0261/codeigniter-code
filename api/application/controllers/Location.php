<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class location extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Member','Customers_model','Locations_model'));
        $this->load->library(array('form_validation','Customer'));
        $this->load->helper('security');
    }


    public function view_get() {

         $location_data = array();

         if($this->get('search_data')){

          $search_data = $this->get('search_data');

         }else{

          $search_data = '';

         }


         $location_data = $this->Locations_model->getLocation_New($search_data);

         if($location_data==0){

         $error_data = array('code'  => 401 ,
                             'error' => 'Location Not Found.');
         $output = array('message'  => $error_data);
         echo json_encode($output);

         }else{

         $output = array('result'  => $location_data,
                         'message' => 'Location Search');
         echo json_encode($output);

         }

    }

    /*
    * Get restaurant opening hours
    */
    public function operningHoursList_get() {
        $location_id = (int) $this->input->get('location_id');
        if(empty($location_id)){
            $error_data = array('code'  => 401 ,'status'  => false, 'error' => 'Invalid Params.');
            $output = array('message'  => $error_data);
        } else {
            $records = $this->Locations_model->getOpeningHoursList($location_id);
            if(!empty($records['options'])){
                $options = unserialize($records['options']);
                $result = array();
                if(!empty($options['opening_hours']['flexible_hours'])){
                    foreach ($options['opening_hours']['flexible_hours'] as $item) {
                        $result[] = array(
                            'day'		=> $item['day'],
                            'open'		=> $item['open'],
                            'close'		=> $item['close'],
                            'status'	=> $item['status']
                        );
                    }
                }
                    $output    = array('result'  => $result, 'message'  => 'Opening Hours Details Fetched');
            } else{
                    $opening_hours = array(
                        array('day' => '0', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '1', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '2', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '3', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '4', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '5', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '6', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1')
                    );
                    $output    = array('result'  => $opening_hours, 'message'  => 'Opening Hours Details Fetched');
            }
        }
        echo json_encode($output);
    }

    /*
    * Update restaurant opening hours
    */
    public function operningHoursUpdate_post() {
        $location_id = (int) $this->input->get('location_id');
        if(empty($location_id)){
            $error_data = array('code'  => 401 ,'status'  => false, 'error' => 'Invalid Params.');
            $output = array('message'  => $error_data);
        } else {
            /*
            * Save working hours
            */
            if ($this->post()) {
                $options = array();
                $opening_hours = $this->post('opening_hours');
                $records = $this->Locations_model->getOpeningHoursList($location_id);
                $options = unserialize($records['options']);
                if(!empty($opening_hours)){
                    /*
                    * Convert time to UTC time
                    */
                    foreach ($opening_hours as $key_hours => $item_hours) 
                    {
                        $opening_hours[$key_hours]['openingUTC'] = date('H:i',strtotime($item_hours['open']." UTC"));
                        $opening_hours[$key_hours]['closingUTC'] = date('H:i',strtotime($item_hours['close']." UTC"));
                    }
                    $options['opening_hours']['opening_type']   = 'flexible';
                    $options['opening_hours']['flexible_hours'] = $opening_hours;
                    $this->Locations_model->updateOpeningHours($location_id, $options);
                }
            }
            /*
            * fetch opening hours
            */
            $records = $this->Locations_model->getOpeningHoursList($location_id);
            if(!empty($records['options'])){
                $options = unserialize($records['options']);
                $result = array();
                if(!empty($options['opening_hours']['flexible_hours'])){
                    foreach ($options['opening_hours']['flexible_hours'] as $item) {
                        $result[] = array(
                            'day'		=> $item['day'],
                            'open'		=> $item['open'],
                            'close'		=> $item['close'],
                            'status'	=> $item['status']
                        );
                    }
                }
                    $output    = array('result'  => $result, 'message'  => 'Opening Hours Details Fetched');
            } else{
                    $opening_hours = array(
                        array('day' => '0', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '1', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '2', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '3', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '4', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '5', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1'),
                        array('day' => '6', 'open' => '12:00 AM', 'close' => '11:59 PM', 'status' => '1')
                    );
                    $output    = array('result'  => $opening_hours, 'message'  => 'Opening Hours Details Fetched');
            }
        }
        echo json_encode($output);
    }

    /*
    * Get restaurant holidays
    */
    public function holidaysList_get($restaurant_id = null) {
        $location_id = (int) $this->input->get('location_id');
        if(empty($location_id)){
            $error_data = array('code'  => 401 ,'status'  => false, 'error' => 'Invalid Params.');
            $output = array('message'  => $error_data);
        } else {
            $records = $this->Locations_model->getHolidaysList($location_id);
            if(!empty($records['options'])){
                $options = unserialize($records['options']);
                $result = array();
                if(!empty($options['opening_hours']['holidays_list'])){
                    foreach ($options['opening_hours']['holidays_list'] as $item) {
                        $result[] = array(
                            'date'		    => $item['date'],
                            'description'	=> $item['description']
                        );
                    }
                    $output    = array('result'  => $result, 'message'  => 'Holiday Details Fetched');
                } else{
                    $output    = array('result'  => array(), 'message'  => 'Holiday has not set yet');
                }
            }
            echo json_encode($output);
        }
    }

    /*
    * Update holidays update
    */
    public function holidaysUpdate_post() {
        $location_id = (int) $this->input->get('location_id');
        if(empty($location_id)){
            $error_data = array('code'  => 401 ,'status'  => false, 'error' => 'Invalid Params.');
            $output = array('message'  => $error_data);
        } else {
            /*
            * Save working hours
            */
            if ($this->post()) {
                $options = array();
                $records = $this->Locations_model->getHolidaysList($location_id);
                $holidays_list = $this->post('holidays_list');
                $options = unserialize($records['options']);
                if(is_array($holidays_list)){
                    $options['opening_hours']['holidays_list'] = $holidays_list;
                    $this->Locations_model->updateHolidays($location_id, $options);
                }
            }
            /*
            * fetch opening hours
            */
            $records = $this->Locations_model->getHolidaysList($location_id);
            if(!empty($records['options'])){
                $options = unserialize($records['options']);
                $result = array();
                if(!empty($options['opening_hours']['holidays_list'])){
                    foreach ($options['opening_hours']['holidays_list'] as $item) {
                        $result[] = array(
                            'date'		    => $item['date'],
                            'description'	=> $item['description']
                        );
                    }
                    $output    = array('result'  => $result, 'message'  => 'Holiday Details Fetched');
                } else{
                    $output    = array('result'  => array(), 'message'  => 'Holiday has not set yet');
                }
            }
        }
        echo json_encode($output);
    }
}
 ?>