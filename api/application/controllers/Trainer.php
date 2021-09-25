<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class trainer extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Trainers_model'));
        $this->load->model(array('Ptclients_model'));
        $this->load->model(array('PersonalTrainers_model'));
        

        define('STRIPE_MODE', 'DEV');
        define('STRIPE_KEY_DEV', 'sk_test_51JElSfKCqIz4jCDxMPBDodXGrPTQ0WIbHmHpDB5494FIXqhbuKbQ88Do5JdasAmJt8jk4dtHXacn7ApHzfgpTAcu005upfvl1L');
        define('STRIPE_KEY_LIVE', 'sk_test_51GxRVFJpxyLWDkuo0rVAU4nxTR0eyPLidiQ92igKB3MsUuK2R5uhEbH2LEGIszV7sTLrGDNWLyt8yNDlufBioYNG00A3K8ZAuY');
    }
    // Trainers List

    public function list_get() {
        $trainersList = $this->Trainers_model->getTrainersList();
        if(!empty($trainersList)){
            foreach($trainersList as $key=>$value){
                $trainersList[$key]['profile_picture'] = base_url().'admin/views/uploads/trainers/profile/'.$value['profile_picture'];
                $trainersList[$key]['main_image'] = base_url().'admin/views/uploads/trainers/mainimage/'.$value['main_image'];
            }
            $output    = array('result'  => $trainersList,
            'message'  => 'Trainers List Fetched');
        }else{
            $error_data = array('code'  => 401 ,
            'error' => 'Trainer Not Found.');
            $output = array('message'  => $error_data);
        }

        echo json_encode($output);

    }

    // Trainers details by trainer id

    public function details_get($trainer_id = '') {
        $output = array();

        if(empty($trainer_id)){
            $error_data = array('code'  => 401 , 'error' => 'Trainer id Not Found.');
            $output = array('message'  => $error_data);
        } else{
            /*
            * Fetch trainer details
            */
            $trainerDetails = $this->Trainers_model->getTrainerDetails($trainer_id);
            if(!empty($trainerDetails)){
                $trainerDetails = $trainerDetails[0];
                $trainerDetails['profile_picture'] = base_url().'admin/views/uploads/trainers/profile/'.$trainerDetails['profile_picture'];
                $trainerDetails['main_image'] = base_url().'admin/views/uploads/trainers/mainimage/'.$trainerDetails['main_image'];
                $trainerDetails['trainer_key_points'] = json_decode($trainerDetails['trainer_key_points']);
                $trainerDetails['vidoes'] = json_decode($trainerDetails['vidoes']);
                /*
                * Fetch trainer programs
                */
                // $trainerPrograms = $this->Trainers_model->getTrainerPrograms($trainer_id);
                // if(!empty($trainerPrograms)){
                //     foreach($trainerPrograms as $key=>$value){
                //         $trainerPrograms[$key]['program_picture'] = base_url().'admin/views/uploads/programs/'.$value['program_picture'];
                //     }
                //     $trainerDetails['trainer_programs'] = $trainerPrograms;
                // }
                $output    = array('result'  => $trainerDetails,
                'message'  => 'Trainer Details Fetched');
            }else{
                $error_data = array('code'  => 401 ,
                'error' => 'Trainer Not Found.');
                $output = array('message'  => $error_data);
            }
        }

        echo json_encode($output);

    }

    // Update trainer profile

    public function updateprofile_put()
    {
        if (!empty($this->put()))
        {
            extract($this->put());

            $error_message = '';
            if(empty(trim($this->put('first_name')))){
                $error_message .= 'First name is missing';
            } else if(empty(trim($this->put('last_name')))){
                $error_message .= 'Last name is missing';
            }

            if(empty($error_message))
                {
                    $userData = array();
                    $userData['trainer_id']              = trim($this->put('trainer_id'));
                    $userData['first_name']              = trim($this->put('first_name'));
                    $userData['last_name']               = trim($this->put('last_name'));
                    $userData['date_modified']           = date("Y-m-d H:i:s");
                    $userData['trainer_short_info']      = trim($this->put('trainer_short_info'));
                    $userData['about_trainer']           = trim($this->put('about_trainer'));
                    $userData['trainer_key_points']      = trim(json_encode($this->put('trainer_key_points')));

                    $userData['email']                   = trim($this->put('email'));
                    $userData['telephone']               = trim($this->put('telephone'));
                    $userData['skype']                   = trim($this->put('skype'));
                    $userData['gender']                  = trim($this->put('gender'));
                    $userData['country']                 = trim($this->put('country'));
                    $userData['city']                    = trim($this->put('city'));
                    $userData['device_time_zone']        = trim($this->put('device_time_zone'));
                    $userData['timezone']                = trim($this->put('timezone'));

                    $userData['instagram_link']          = trim($this->put('instagram_link'));
                    $userData['facebook_link']           = trim($this->put('facebook_link'));
                    
                    $userData['business_name']           = trim($this->put('business_name'));
                    $userData['business_type']           = trim($this->put('business_type'));


                    $email_already_exists = $this->Trainers_model->check_email_exists($userData['email'], $userData['trainer_id']);
                    if(empty($email_already_exists))
                    {
                        if ($trainer_id = $this->Trainers_model->saveTrainer($userData['trainer_id'], $userData))
                        {
                            $trainer_data = array(
                                            'trainer_id' => $trainer_id ,
                                            'first_name'            => $userData['first_name'] ,
                                            'last_name'             => $userData['last_name'],
                                            'trainer_short_info'    => $userData['trainer_short_info'],
                                            'about_trainer'         => $userData['about_trainer'],
                                            'trainer_key_points'    => $userData['trainer_key_points'],
                                            'email'                 => $userData['email'],
                                            'telephone'             => $userData['telephone'],
                                            'skype'                 => $userData['skype'],
                                            'gender'                => $userData['gender'],
                                            'country'               => $userData['country'],
                                            'city'                  => $userData['city'],
                                            'device_time_zone'      => $userData['device_time_zone'],
                                            'timezone'              => $userData['timezone'],
                                            'instagram_link'        => $userData['instagram_link'],
                                            'facebook_link'         => $userData['facebook_link'],
                                            'business_name'         => $userData['business_name'],
                                            'business_type'         => $userData['business_type']
                                            );

                            //log_activity($customer_id, 'New Registration', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_id.'">'.$userData['first_name'] .'  '.$userData['last_name'].'</a> <b>New Customer Registered</b>.');

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Trainer info updated Successfully');

                            echo json_encode($output);
                            exit;

                        }
                    }
                    else
                    {
                        $output = array('message'  => 'Email id already exists');
                        echo json_encode($output);
                        exit;
                    }

                }
             else
             {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }

        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    // Trainers images update

    public function updatedimages_post($trainer_id = '') {
        $output   = array();
        $imageData= array();
        $message  = '';
        if(empty($trainer_id)){
            $error_data = array('code'  => 401 , 'error' => 'Trainer id Not Found.');
            $output = array('message'  => $error_data);
        } else{
            if(empty($_FILES['profile_picture']['tmp_name']) && empty($_FILES['main_image']['tmp_name'])){
                    $output = array('message'  => 'Image is missing');
            } else {
                if(!empty($_FILES['profile_picture']['tmp_name'])){
                    $file_name  = pathinfo($_FILES['profile_picture']['name'], PATHINFO_FILENAME);
                    $file_name  = preg_replace('/[^A-Za-z0-9\-]/', '-', $file_name).'-'.str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT);

                    $file_ext  = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
                    $image_name= $file_name.'.'.$file_ext;

                    $target_dir = dirname(__FILE__).'/../../../admin/views/uploads/trainers/profile/'.$image_name;
                    if(move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_dir)){
                        $message .= 'Profie image uploaded successfully';
                        $imageData['profile_picture'] = $image_name;
                    } else {
                        $message .= 'Profie image upload failed';
                    }
                }

                if(!empty($_FILES['main_image']['tmp_name'])){
                    $file_name  = pathinfo($_FILES['main_image']['name'], PATHINFO_FILENAME);
                    $file_name  = preg_replace('/[^A-Za-z0-9\-]/', '-', $file_name).'-'.str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT);;

                    $file_ext  = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
                    $image_name= $file_name.'.'.$file_ext;

                    $target_dir = dirname(__FILE__).'/../../../admin/views/uploads/trainers/mainimage/'.$image_name;
                    if(move_uploaded_file($_FILES['main_image']['tmp_name'], $target_dir)){
                        $message .= '<br> Main image uploaded successfully';
                        $imageData['main_image'] = $image_name;
                    } else {
                        $message .= '<br> Main image upload failed';
                    }
                }
                /*
                * Update trainer info
                */
                if(!empty($imageData)){
                    $this->Trainers_model->updateImage($trainer_id, $imageData);
                }

                $output = array('message'  => $message);
            }
        }

        echo json_encode($output);

    }

    // Trainer program details by trainer_program_id
    public function trainer_program_get($trainer_program_id = '') {
        $output = array();

        if(empty($trainer_program_id)){
            $error_data = array('code'  => 401 , 'error' => 'Trainer program id Not Found.');
            $output = array('message'  => $error_data);
        } else{
            $trainerProgramDetails = $this->Trainers_model->getTrainerProgramDetails($trainer_program_id);
            if(!empty($trainerProgramDetails)){
                $trainerProgramDetails['program_picture'] = base_url().'admin/views/uploads/programs/'.$trainerProgramDetails['program_picture'];

                $output    = array('result'  => $trainerProgramDetails,
                'message'  => 'Trainer Program Details Fetched');
            } else{
                $error_data = array('code'  => 401 , 'error' => 'Trainer program Not Found.');
                $output = array('message'  => $error_data);
            }
        }

        echo json_encode($output);

    }

    // Trainer Regsitration Section

    public function register_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('first_name')))){
                $error_message .= 'First name is missing';
            } else if(empty(trim($this->post('last_name')))){
                $error_message .= 'Last name is missing';
            } else if(empty(trim($this->post('email')))){
                $error_message .= 'Email is missing';
            } else if(!$this->valid_email(trim($this->post('email')))){
                $error_message .= 'Email format is not correct';
            } else if(empty(trim($this->post('password'))) || empty(trim($this->post('confirm_password')))){
                $error_message .= 'Password is missing';
            } else if(trim($this->post('password')) != trim($this->post('confirm_password'))){
                $error_message .= 'Password does not match';
            } else if(empty(trim($this->post('telephone')))){
                $error_message .= 'Telephone is missing';
            }

            if(empty($error_message))
                {
                    $userData = array();
                    $userData['first_name']              = trim($this->post('first_name'));
                    $userData['last_name']               = trim($this->post('last_name'));
                    $userData['email']                   = trim($this->post('email'));
                    $userData['password']                = trim($this->post('password'));
                    $userData['telephone']               = trim($this->post('telephone'));
                    $userData['date_added']              = date("Y-m-d H:i:s");
                    $userData['status']                  = 0;
                    $userData['deviceid']                = trim($this->post('deviceid'));

                    $mobile_already_exists = $this->Trainers_model->check_email_exists($userData['email']);

                    if($mobile_already_exists == 0)
                    {
                        if ($trainer_id = $this->Trainers_model->saveTrainer(NULL, $userData))
                        {
                            $trainer_data = array('trainer_id' => $trainer_id ,
                                            'first_name'  => $userData['first_name'] ,
                                            'last_name'   => $userData['last_name'],
                                            'email'       => $userData['email'],
                                            'telephone'   => $userData['telephone'],
                                            'status'      => $userData['status'],
                                            'date_added'  => $userData['date_added'] );

                            //log_activity($customer_id, 'New Registration', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_id.'">'.$userData['first_name'] .'  '.$userData['last_name'].'</a> <b>New Customer Registered</b>.');

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Registered Successfully');

                            echo json_encode($output);
                            exit;

                        }
                    }
                    else
                    {
                    /* $error_data = array('code'  => 401 ,
                                            'error' => 'Email-id already exists.');      */
                        $msg =    'Mobile Number already exists.';
                        $output = array('message'  => $msg);

                        echo json_encode($output);
                        exit;
                    }
                }
             else
             {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }

        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    /*
    * Trainer Login
    */
    public function login_post() {

        if (!empty($this->post()))
        {
            $error_message = '';

            if(empty(trim($this->post('email')))){
                $error_message .= 'Email is missing';
            } else if(!$this->valid_email(trim($this->post('email')))){
                $error_message .= 'Email format is not correct';
            } else if(empty(trim($this->post('password')))){
                $error_message .= 'Password is missing';
            }

            if(empty($error_message))
            {
                $email      = trim($this->post('email'));
                $password   = trim($this->post('password'));
                $deviceid   = trim($this->post('deviceid'));
                $deviceInfo = trim($this->post('deviceInfo'));

                $trainer_data = $this->Trainers_model->login($email, $password);
                if (empty($trainer_data))
                {
                    $msg =   'Invalid login credentials.';
                    $output = array('message'  => $msg);
                    echo json_encode($output);
                }
                else
                {
                    //log_activity($customer_details['customer_id'], 'Login', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_details['customer_id'].'">'.$customer_details['first_name'] .' '.$customer_details['last_name'].'</a> <b>Logged in</b>.');
                    /*check user has been subscribed any plan or not*/
                    $checkSubscription = $this->Trainers_model->getCustomerSbscriptionCurrentPlan($email);
                    $status = 'Not Subscribed';
                    if($checkSubscription->num_rows()>0)
                    {
                        $status = 'Subscribed';
                    }
                    /*update device info*/
                    $this->Trainers_model->updateDeviceInfo($trainer_data['trainer_id'], $deviceid, $deviceInfo);
                    
                    $trainer_data['status'] = $status;
                    $output = array('result'  => $trainer_data, 'message' => 'Login Successfull');
                    echo json_encode($output);

                }
            }
            else
            {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }
        }
        else
        {
                $error_data = array('code'  => 401 , 'error' => 'Invalid Params.');
                $output = array('message'  => $error_data);

                echo json_encode($output);
        }

    }

    /**
     * Valid Email
     *
     * @access  public
     * @param   string
     * @return  bool
     */
    function valid_email($str)
    {
        return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    // Training program create by Trainer

    public function createprogram_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('trainer_id')))){
                $error_message .= 'Trainer is missing';
            } else if(empty(trim($this->post('program_name')))){
                $error_message .= 'Program name is missing';
            }


            if(empty($error_message))
                {
                    $userData = array();
                    $userData['trainer_id']                 = trim($this->post('trainer_id'));
                    $userData['program_name']               = trim($this->post('program_name'));
                    $userData['program_short_description']  = trim($this->post('program_short_description'));
                    $userData['program_overview']           = trim($this->post('program_overview'));
                    $userData['program_price']              = trim($this->post('program_price'));
                    $userData['program_types']              = $this->post('program_types');
                    $userData['program_tags']               = $this->post('program_tags');

                    $trainer_already_exists = $this->Trainers_model->check_trainer_exists($userData['trainer_id']);

                    if($trainer_already_exists)
                    {
                        if ($trainer_program_id = $this->Trainers_model->saveTraingProgram(NULL, $userData))
                        {
                            $trainer_data = array(
                                                'trainer_program_id'        => $trainer_program_id ,
                                                'trainer_id'                => $userData['trainer_id'] ,
                                                'program_name'              => $userData['program_name'] ,
                                                'program_short_description' => $userData['program_short_description']
                                                );

                            //log_activity($customer_id, 'New Registration', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_id.'">'.$userData['first_name'] .'  '.$userData['last_name'].'</a> <b>New Customer Registered</b>.');

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Training Program Successfully');

                            echo json_encode($output);
                            exit;

                        }
                    }
                    else
                    {
                    /* $error_data = array('code'  => 401 ,
                                            'error' => 'Email-id already exists.');      */
                        $msg =    'Mobile Number already exists.';
                        $output = array('message'  => $msg);

                        echo json_encode($output);
                        exit;
                    }
                }
             else
             {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }

        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    // Training program update by Trainer

    public function updateprogram_put()
    {
        if (!empty($this->put()))
        {
            $error_message = '';
            if(empty(trim($this->put('trainer_program_id')))){
                $error_message .= 'Trainer program is missing';
            }else if(empty(trim($this->put('trainer_id')))){
                $error_message .= 'Trainer is missing';
            }

            if(empty($error_message))
                {
                    $userData = array();
                    $userData['trainer_program_id']         = trim($this->put('trainer_program_id'));
                    $userData['trainer_id']                 = trim($this->put('trainer_id'));
                    $userData['program_name']               = trim($this->put('program_name'));
                    $userData['program_short_description']  = trim($this->put('program_short_description'));
                    $userData['program_overview']           = trim($this->put('program_overview'));
                    $userData['program_price']              = trim($this->put('program_price'));
                    $userData['program_types']              = $this->put('program_types');
                    $userData['program_tags']               = $this->put('program_tags');

                    $trainer_program_already_exists = $this->Trainers_model->check_trainer_program_exists($userData['trainer_id'], $userData['trainer_program_id']);

                    if(!empty($trainer_program_already_exists))
                    {
                        if ($trainer_program_id = $this->Trainers_model->saveTraingProgram($userData['trainer_program_id'], $userData))
                        {
                            $trainer_data = array(
                                                'trainer_program_id'        => $trainer_program_id ,
                                                'trainer_id'                => $userData['trainer_id'] ,
                                                'program_name'              => $userData['program_name'] ,
                                                'program_short_description' => $userData['program_short_description'],
                                                'program_types'             => $userData['program_types'],
                                                'program_tags'              => $userData['program_tags']
                                                );

                            //log_activity($customer_id, 'New Registration', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_id.'">'.$userData['first_name'] .'  '.$userData['last_name'].'</a> <b>New Customer Registered</b>.');

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Training Program Updated Successfully');

                            echo json_encode($output);
                            exit;

                        }
                    }
                    else
                    {
                    /* $error_data = array('code'  => 401 ,
                                            'error' => 'Email-id already exists.');      */
                        $msg =    'Trainer program does not exist.';
                        $output = array('message'  => $msg);

                        echo json_encode($output);
                        exit;
                    }
                }
             else
             {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }

        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    // Training program list by trainer id

    public function programs_get($trainer_id = '') {
        $output = array();
        $videoSeriesInfo = array();

        if(empty($trainer_id)){
            $error_data = array('code'  => 401 , 'error' => 'Trainer info Not Found.');
            $output = array('message'  => $error_data);
        } else{
            // Trainer programs
            $trainerProgramsList = $this->Trainers_model->getTrainerProgramsList($trainer_id);
            if(!empty($trainerProgramsList)){
                foreach($trainerProgramsList as $key=>$value){
                    $trainerProgramsList[$key]['program_picture'] = base_url().'admin/views/uploads/programs/'.$value['program_picture'];

                    // Fetch Types
                    $trainerProgramsList[$key]['program_types'] = $this->Trainers_model->trainerProgramTypes($value['trainer_program_id']);
                    // Fetch Tags
                    $trainerProgramsList[$key]['program_tags']  = $this->Trainers_model->trainerProgramTags($value['trainer_program_id']);
                    // Fetch Videos
                    $trainerProgramsList[$key]['program_videos'] = $this->Trainers_model->trainerProgramVideos($value['trainer_program_id']);

                    // Type
                    $trainerProgramsList[$key]['type'] = 'TRAINER_VIDEO';
                }
            } 
            
            // Workout videos
            $workoutVideoSeries = $this->Trainers_model->getWorkoutVideoSeries();
            if(!empty($workoutVideoSeries))
            {
                /*
                * Fetch workout videos details
                */                          
                if(!empty($workoutVideoSeries))
                {          
                    foreach($workoutVideoSeries as $key=>$value)
                    {                   
                        $workoutVideoSeries[$key]['image'] = base_url().'admin/views/uploads/workoutvideos/'.$value['image'];
                        $workoutVideoSeries[$key]['type'] = 'WORKOUT_VIDEO';
                    }
                    
                }  
            }
            // Merge two arrays
            $result_array = array_merge($trainerProgramsList, $workoutVideoSeries);

            $output    = array('result'  => $result_array,
            'message'  => 'Trainer Programs Fetched');            
        }

        echo json_encode($output);

    }

    // Trainer Contact Messages

    public function contactmessage_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('first_name')))){
                $error_message .= 'First name is missing';
            } else if(empty(trim($this->post('last_name')))){
                $error_message .= 'Last name is missing';
            } else if(empty(trim($this->post('email')))){
                $error_message .= 'Email is missing';
            } else if(!$this->valid_email(trim($this->post('email')))){
                $error_message .= 'Email format is not correct';
            }

            if(empty($error_message))
                {
                    $contactData = array();
                    $contactData['first_name']              = trim($this->post('first_name'));
                    $contactData['last_name']               = trim($this->post('last_name'));
                    $contactData['email']                   = trim($this->post('email'));

                    //$mobile_already_exists = $this->Trainers_model->check_email_exists($contactData['email']);

                    if ($id = $this->Trainers_model->saveContactMessages($contactData))
                        {
                            $contact_data = array('id' => $id ,
                                            'first_name'  => $contactData['first_name'] ,
                                            'last_name'   => $contactData['last_name'],
                                            'email'       => $contactData['email'],
                                            'date_added'  => $contactData['date_added'] );

                            $output = array('result'  => $contact_data,
                                            'message' => 'Merketing data saved  Successfully');

                            echo json_encode($output);
                            exit;

                        }
                }
             else
             {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }

        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    // Training program types by trainer id

    public function programtypes_get() {
        $output = array();

        $getAllTypes = $this->Trainers_model->getAllTypes();
        if(!empty($getAllTypes)){
            $output    = array('result'  => $getAllTypes,
            'message'  => 'Program types records Fetched');
        } else {
            $error_data = array('code'  => 401 , 'error' => 'Program type Not Found.');
            $output = array('message'  => $error_data);
        }

        echo json_encode($output);

    }

    // Training program video add

    public function programvideo_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('trainer_id')))){
                $error_message .= 'Trainer id missing';
            } else if(empty(trim($this->post('trainer_program_id')))){
                $error_message .= 'Program id is missing';
            } else if(empty(trim($this->post('video_url')))){
                $error_message .= 'Video url is missing';
            }

            if(empty($error_message))
                {
                    $userData = array();
                    $userData['trainer_id']                 = trim($this->post('trainer_id'));
                    $userData['trainer_program_id']         = trim($this->post('trainer_program_id'));
                    $userData['video_url']                  = trim($this->post('video_url'));
                    $userData['image_url']                  = trim($this->post('image_url'));
                    $userData['title']                      = trim($this->post('title'));

                    $trainer_program_exists = $this->Trainers_model->check_trainer_program_exists($userData['trainer_id'], $userData['trainer_program_id']);

                    if(!empty($trainer_program_exists))
                    {
                        if ($pt_trainer_program_video_id = $this->Trainers_model->saveTraingProgramVideos(NULL, $userData))
                        {
                            $trainer_data = array(
                                                'pt_trainer_program_video_id'        => $pt_trainer_program_video_id ,
                                                'trainer_id'                => $userData['trainer_id'] ,
                                                'trainer_program_id'        => $userData['trainer_program_id'] ,
                                                'video_url' => $userData['video_url'],
                                                'image_url' => $userData['image_url'],
                                                'title'        => $userData['title'] ,
                                                );

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Training Program video added successfully');

                            echo json_encode($output);
                            exit;

                        }
                    }
                    else
                    {
                    /* $error_data = array('code'  => 401 ,
                                            'error' => 'Email-id already exists.');      */
                        $msg =    'Trainer program does not exists.';
                        $output = array('message'  => $msg);

                        echo json_encode($output);
                        exit;
                    }
                }
             else
             {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }

        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    // Training program video update

    public function programvideoupdate_put()
    {
        if (!empty($this->put()))
        {
            $error_message = '';
            if(empty(trim($this->put('pt_trainer_program_video_id')))){
                $error_message .= 'Trainer video id missing';
            } else if(empty(trim($this->put('trainer_id')))){
                $error_message .= 'Trainer id missing';
            } else if(empty(trim($this->put('trainer_program_id')))){
                $error_message .= 'Program id is missing';
            } else if(empty(trim($this->put('video_url')))){
                $error_message .= 'Video url is missing';
            }

            if(empty($error_message))
                {
                    $userData = array();
                    $userData['pt_trainer_program_video_id']= trim($this->put('pt_trainer_program_video_id'));
                    $userData['trainer_id']                 = trim($this->put('trainer_id'));
                    $userData['trainer_program_id']         = trim($this->put('trainer_program_id'));
                    $userData['video_url']                  = trim($this->put('video_url'));
                    $userData['image_url']                  = trim($this->put('image_url'));
                    $userData['title']                      = trim($this->put('title'));

                    $trainer_program_video_exists = $this->Trainers_model->check_trainer_program_video_exists($userData['trainer_id'], $userData['trainer_program_id'], $userData['pt_trainer_program_video_id']);

                    if(!empty($trainer_program_video_exists))
                    {
                        if ($pt_trainer_program_video_id = $this->Trainers_model->saveTraingProgramVideos($userData['pt_trainer_program_video_id'], $userData))
                        {
                            $trainer_data = array(
                                                'pt_trainer_program_video_id'=> $pt_trainer_program_video_id ,
                                                'trainer_id'                 => $userData['trainer_id'] ,
                                                'trainer_program_id'         => $userData['trainer_program_id'] ,
                                                'video_url'                  => $userData['video_url'],
                                                'image_url'                  => $userData['image_url'],
                                                'title'                      => $userData['title'] ,
                                                );

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Training Program video added successfully');

                            echo json_encode($output);
                            exit;

                        }
                    }
                    else
                    {
                    /* $error_data = array('code'  => 401 ,
                                            'error' => 'Email-id already exists.');      */
                        $msg =    'Trainer program does not exists.';
                        $output = array('message'  => $msg);

                        echo json_encode($output);
                        exit;
                    }
                }
             else
             {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }

        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    // Trainer program tags

    public function programtags_get() {
        $output = array();
        $tags_array = array();
        $parent_id = $this->input->get('parent_id');
        $getProgramTags = $this->Trainers_model->getProgramTags($parent_id);
        $output    = array('result'  => $getProgramTags,
        'message'  => 'Trainer Program Tags Fetched');


        echo json_encode($output);

    }

    // Trainers Packages List

    public function packages_get() {
        $trainersPackagesList = $this->Trainers_model->getTrainersPackagesList();

        $output    = array('result'  => $trainersPackagesList,
        'message'  => 'Trainer Packages List Fetched');

        echo json_encode($output);

    }

    /*Customer data with current subscription plan*/
    public function customers_subscription_get() {
        // $jsonArray = json_decode($this->input->raw_input_stream, true);
        $jsonArray = $this->get('cust_email');
        // echo $jsonArray;exit();
        if(empty($jsonArray)){
            $output    = array('message'  => 'Customer Email ID missing.');
            echo json_encode($output);
        }
        else
        {
            $cust_email = $jsonArray;

            /*get subscription plan details*/
            $purchaseDetails = $this->Trainers_model->getCustomerSbscriptionCurrentPlan($cust_email);
            // echo $this->db->last_query();exit();
            $purchaseHistoryDetails = $this->Trainers_model->getCustomerSbscriptionPurchaseHistory($cust_email);
            /*activeClient*/
            $trainersDetails = $this->Trainers_model->getTrainerDetailsByEmail($cust_email);
            $trainerID = 0;
            if(!empty($trainersDetails)){
                $trainerID  = $trainersDetails[0]['trainer_id'];
            }
            $activeClient = $this->Ptclients_model->getClientListByTrainerId($trainerID, 1, 1);
            $activeClientCount = 0;
            if(!empty($activeClient)){
                $activeClientCount = count($activeClient);
            }
            // print_r($purchaseDetails->result_array());
            // exit();

            $customer_sbscriptions_current_plan['current_plan'] = $purchaseDetails->num_rows()>0 ? $purchaseDetails->result_array() : '';
            $customer_sbscriptions_current_plan['purchase_history'] = $purchaseDetails->num_rows()>0 ? $purchaseHistoryDetails->result_array() : '';
            $customer_sbscriptions_current_plan['activeClient'] = $activeClientCount;

            if($purchaseHistoryDetails->num_rows()>=0)
            {
                $output    = array('result'  => $customer_sbscriptions_current_plan,
                'message'  => 'Customer Subscription Details Fetched');
                echo json_encode($output);
            }
            else
            {
                $output    = array('message'  => 'Customer does not exists.');
                echo json_encode($output);
            }
        }

    }
    /*customers subscription plan end*/

    // Update plan

    public function upgradepackage_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('package_id')))){
                $error_message .= 'Package is missing';
            } else if(empty(trim($this->post('trainer_email')))){
                $error_message .= 'Email is missing';
            }


            if(empty($error_message))
                {
                    $userData = array();
                    $userData['stripe_customer_id']             = trim($this->post('stripe_customer_id'));
                    $userData['package_id']                     = trim($this->post('package_id'));
                    $userData['trainer_email']                  = trim($this->post('trainer_email'));
                    $userData['package_price']                  = trim($this->post('package_price'));

                    if ($trainer_program_id = $this->Trainers_model->updateTraingPackage($userData))
                    {
                        $package_name = $this->Trainers_model->getTrainersPackageName($userData['package_id']);
                        $trainer_data = array(
                                            'stripe_customer_id'        => $userData['stripe_customer_id'] ,
                                            'package_id'                => $userData['package_id'] ,
                                            'trainer_email'             => $userData['trainer_email'] ,
                                            'package_name'              => $package_name,
                                            'package_price'             => $userData['package_price']
                                            );

                        //log_activity($customer_id, 'New Registration', 'customers','<a href="'.site_url().'admin/customers/edit?id='.$customer_id.'">'.$userData['first_name'] .'  '.$userData['last_name'].'</a> <b>New Customer Registered</b>.');

                        $output = array('result'  => $trainer_data,
                                        'message' => 'Training Package Updated Successfully');

                        echo json_encode($output);
                        exit;

                    }

                }
             else
             {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }

        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    // Cancel subscription
    public function unsubs_post()
    {        
        
        if(STRIPE_MODE == 'DEV'){
            $STRIPE_KEY =  STRIPE_KEY_DEV;
        } else if($MODE == 'LIVE'){
            $STRIPE_KEY = STRIPE_KEY_LIVE;
        }
 
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('trainer_email')))){
                $error_message .= 'Trainer Email is missing';
            }

            if(empty($error_message))
                {
                    
                    $user_info  = $this->Trainers_model->getSubscriptionByEmail($this->post('trainer_email'));                   

                    foreach($user_info as $user){
                        // Update that entry is_active = 0 ,if purchase_type = subscription then also call the stripe api to cancel that subscription with the subsciption id
                    
                        $record = $this->Trainers_model->updateTrainerSubscription($user['package_purchase_id'], '0');
                            
                        if($user['is_active']==1 and $user['subscription_id']!=''){
                            //echo 'test' ; die('ee') ; 
                            require_once('../stripe-checkout-session/stripe-php/init.php');    
                            \Stripe\Stripe::setApiKey($STRIPE_KEY);    
                                                //Now update the subscription 
                            $subscription = \Stripe\Subscription::retrieve($user['subscription_id']);                     
                            $result = $subscription->cancel();
                            //print_r($result);
                        } 
                    }                      

                    $output = array('message'  => 'Successfully updated ');
                    echo json_encode($output);
                    exit;

                }else{
                    $output = array('message'  => $error_message);
                    echo json_encode($output);
                    exit;                    
                }    

 
        }else{
            $output = array('message'  => 'Invalid post data');
                    echo json_encode($output);
                    exit;  
        }

    }

    public function freeVipPlanSubscription_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('package_id')))){
                $error_message .= 'Package ID is missing';
            } else if(!$this->valid_email(trim($this->post('trainer_email')))){
                $error_message .= 'Trainer Email is missing';
            }else if($this->post(trim($this->post('plan_type')))){
                $error_message .= 'Plan Type is missing';
            }
            /*check plan as vip */
            if($this->post('plan_type') == 'vip' && $this->post('code') == null)
            {
                $error_message .= 'Code is missing.';
            }
            else if($this->post('plan_type') == 'vip' && $this->post('code') != null)
            {
                /*if plan is vip*/
                $activecode = null;
                if($this->post('plan_type') == 'vip')
                {
                    /*check code is valida or not*/
                    $vippasscode = $this->Trainers_model->getActivePasscode();
                    if(!empty($vippasscode))
                    {
                        $activecode = $vippasscode->code;
                        if($activecode != $this->post('code'))
                        {
                            $error_message .= 'Code does not matched.';
                        }
                    }
                    else
                    {
                        $error_message .= 'Code is not available.';
                    }
                }
            }
            // echo $activecode;
            // exit();
            if(empty($error_message))
            {
                $packageID      = $this->post('package_id');
                $trainerEmail   = $this->post('trainer_email');
                $plan_type      = $this->post('plan_type');
                $currentPlan    = $this->Trainers_model->getCustomerSbscriptionCurrentPlan($trainerEmail);
                $purchase_package_id = 0;
                if($currentPlan->num_rows() > 0)
                {
                    $purchase_package_id = $currentPlan->row()->package_purchase_id;
                    /*Deactivate the stripe plan if old existing plan subscription id is existing for user*/
                    $stripeSubscriptionID = $currentPlan->row()->subscription_id;
                    if($stripeSubscriptionID!='')
                    {
                        if(STRIPE_MODE == 'DEV'){
                            $STRIPE_KEY =  STRIPE_KEY_DEV;
                        } else if($MODE == 'LIVE'){
                            $STRIPE_KEY = STRIPE_KEY_LIVE;
                        }
                        require_once('../stripe-checkout-session/stripe-php/init.php');    
                        \Stripe\Stripe::setApiKey($STRIPE_KEY);    
                        //Now update the subscription 
                        $subscription = \Stripe\Subscription::retrieve($stripeSubscriptionID);                     
                        $result = $subscription->cancel();
                    }
                }
                /*get package details*/
                $detailsTrains = $this->Trainers_model->getTrainersPackageDetails($packageID);
                


                /*Activate Trial plan by Default*/
                $planDetails    = array();
                $currDate       = date('Y-m-d');
                $plan_duration  = $detailsTrains->package_duration;
                // echo $plan_duration;exit();
                if($plan_duration == 'Unlimited')
                {
                    $expiryDate     = date('Y-m-d',strtotime('2099-01-01'));
                }
                else
                {
                    $expiryDate     = date('Y-m-d', strtotime($currDate. ' + '.$plan_duration));
                }
                $updatedCode = $this->post('code');
                $planDetails    = array('stripe_customer_id' => '', 'trainer_email' => $trainerEmail, 'subscription_id' => '', 'is_active'=>'1', 'package_price' => 0, 'package_id' => $packageID, 'date_added' => date('Y-m-d H:i:s'), 'subscription_payment_iteration' => '1', 'subscription_end_date' => $expiryDate,'subscription_start_date' => $currDate, 'subscription_code' => $updatedCode);

                // Insert into table
                if($purchase_package_id > 0)
                {
                    $coupon_id = $this->PersonalTrainers_model->savePlanPurchase($purchase_package_id, $planDetails);
                }
                else
                {
                    $coupon_id = $this->PersonalTrainers_model->savePlanPurchase(NULL, $planDetails);
                }
                // Insert into history table
                $coupon_id = $this->PersonalTrainers_model->savePlanPurchaseHistory(NULL, $planDetails);
                $output = array('message' => 'Upgraded Plan Successfully');

                echo json_encode($output);
                exit;
            }
            else
            {
                $output = array('message'  => $error_message);
                echo json_encode($output);
                exit;
            }
        } else {
            $output = array('message'  => 'Input values are missing');
            echo json_encode($output);
            exit;
        }
    }

    public function getStripeKey_get()
    {
        $mode = "TEST";
        if ($this->config->item('production_server') == true) {
            $mode = "LIVE";
        }
        $keys = $this->Trainers_model->getStripeKey($mode);      
        $response['result']  = $keys;
        $response['message'] = "Success";
        echo json_encode($response);
    }
}
?>