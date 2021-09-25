<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



class Get_user extends CI_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }

    public function user_data() {


    //API URL
    $url = 'http://localhost/restaurant_site/api/example/user';

    //API key
    $apiKey = 'CODEX@123';

    //Auth credentials
    $username = "admin";
    $password = "1234";

    //create a new cURL resource
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
    

    $result = curl_exec($ch);

    echo "<pre>";
    print_r($result);
    echo "</pre>";exit;
    //close cURL resource
    curl_close($ch);
        
    }

    



}
 ?>