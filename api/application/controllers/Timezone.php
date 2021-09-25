<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class timezone extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('PersonalTrainers_model'));
    }

    public function list_get()
    {        
        // echo "<pre>";print_r($this->PersonalTrainers_model->time_zones());exit();
        $timezones_list = $this->PersonalTrainers_model->time_zones();
            $timezones  = [];
            $offsets    = [];
            $now = new DateTime('now', new DateTimeZone('UTC'));

            foreach (DateTimeZone::listIdentifiers(DateTimeZone::ALL) as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[] = '(' . $this->format_GMT_offset($offset) . ') ' . $this->format_timezone_name($timezone);
            }

        array_multisort($offsets, $timezones);
        $output = array('result'  => $timezones);
        echo json_encode($output);
        exit;
    }

    public function format_GMT_offset($offset) {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    public function format_timezone_name($name) {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }
}
 ?>