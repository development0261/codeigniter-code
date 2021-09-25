<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

class workout_videos extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Workout_videos_model'));
    }   
    
    // Workout videos categories

    public function categories_get() 
    {
        $categoriesList = $this->Workout_videos_model->getCategoriesList();
        if(!empty($categoriesList)){            
            $output    = array('result'  => $categoriesList, 'message'  => 'Categories List Fetched');            
        }else{
            $error_data = array('code'  => 401 , 'error' => 'Category Not Found.');               
            $output = array('message'  => $error_data);            
        }
        
        echo json_encode($output);   
       
    }
    
    // Workout videos List

    public function list_get($workout_video_categoryid = '') 
    {
        $output = array();

        /*
        * Fetch trainer details
        */
        $workoutVideos = $this->Workout_videos_model->getVideosList($workout_video_categoryid);
        if(!empty($workoutVideos))
        {
            foreach($workoutVideos as $key=>$value)
            {
                $workoutVideos[$key]['banner_image'] = base_url().'admin/views/uploads/workoutvideos/'.$value['banner_image'];
            }
            $output    = array('result'  => $workoutVideos, 'message'  => 'Workout Videos List Fetched');            
        }
        else
        {
            $error_data = array('code'  => 401 ,
            'error' => 'No Workout Video Found.');               
            $output = array('message'  => $error_data);            
        }       
        
        echo json_encode($output);
       
    }
    
    // Workout videos details by trainer id

    public function details_get($workout_video_id = '') 
    {
        $output = array();

        if(empty($workout_video_id))
        {
            $error_data = array('code'  => 401 , 'error' => 'Workout video id is missing.');               
            $output = array('message'  => $error_data);  
        } 
        else
        {
            /*
            * Fetch Workout videos details
            */
            $workoutVideoDetails = $this->Workout_videos_model->getWorkoutVideoDetails($workout_video_id);
            if(!empty($workoutVideoDetails))
            {                
                $workoutVideoDetails = $workoutVideoDetails[0];                
                $workoutVideoDetails['banner_image'] = base_url().'admin/views/uploads/workoutvideos/'.$workoutVideoDetails['banner_image'];
                $workoutVideoDetails['image'] = base_url().'admin/views/uploads/workoutvideos/'.$workoutVideoDetails['image'];
                $workoutVideoDetails['tags'] = json_decode($workoutVideoDetails['tags']);
                
                /*
                * Related free videos
                */
                $workoutVideoSeries = $this->Workout_videos_model->getWorkoutFreeVideos($workout_video_id);                
                if(!empty($workoutVideoSeries))
                {          
                    foreach($workoutVideoSeries as $key=>$value)
                    {                   
                        $workoutVideoSeries[$key]['image'] = base_url().'admin/views/uploads/workoutvideos/'.$value['image'];
                        $workoutVideoSeries[$key]['module_image'] = base_url().'admin/views/uploads/modules/'.$value['module_image'];
                    }
                    /*
                    * Add related videos in array
                    */
                    $workoutVideoDetails['related_videos'] = $workoutVideoSeries;
                    
                }

                $output    = array('result'  => $workoutVideoDetails, 
                'message'  => 'Workout video Details Fetched');            
            }
            else
            {
                $error_data = array('code'  => 401 , 'error' => 'Workout video Not Found.');               
                $output = array('message'  => $error_data);            
            }
        }       
        
        echo json_encode($output); 
    }    
    
    // Workout video series by video id

    public function videoseries_get() 
    {
        $output = array();

        $video_id = $this->input->get('video_id');
        $email    = $this->input->get('email');

        $type     = $this->input->get('type');
        $is_paid  = !empty($type) && $type == 'BONUS'?'2':'1';

        if(empty($video_id) || empty($email))
        {
            $error_data = array('code'  => 401 , 'error' => 'Required info is missing.');               
            $output = array('message'  => $error_data);  
        } 
        else
        {
            $videoSeriesInfo = array();
            $workoutVideoSeries = $this->Workout_videos_model->getWorkoutVideoSeries($video_id, $email, $is_paid);

            if(!empty($workoutVideoSeries))
            {
                /*
                * Fetch workout videos details
                */
                $related_videos = array();                             
                if(!empty($workoutVideoSeries))
                {          
                    foreach($workoutVideoSeries as $key=>$value)
                    {                   
                        $workoutVideoSeries[$key]['image'] = base_url().'admin/views/uploads/workoutvideos/'.$value['image'];
                        $workoutVideoSeries[$key]['module_image'] = base_url().'admin/views/uploads/modules/'.$value['module_image'];
                    }
                    /*
                    * Add related videos in array
                    */
                    $related_videos = $workoutVideoSeries;
                    
                }
                $workoutVideoDetails = $this->Workout_videos_model->getWorkoutVideoDetails($video_id);
                if(!empty($workoutVideoDetails))
                {
                    $workoutVideoDetails = $workoutVideoDetails[0];                
                    $workoutVideoDetails['banner_image'] = base_url().'admin/views/uploads/workoutvideos/'.$workoutVideoDetails['banner_image'];
                    $workoutVideoDetails['image'] = base_url().'admin/views/uploads/workoutvideos/'.$workoutVideoDetails['image'];
                    $workoutVideoDetails['tags'] = json_decode($workoutVideoDetails['tags']);

                    $workoutVideoDetails['related_videos'] = $related_videos;
                    $videoSeriesInfo = $workoutVideoDetails;
                }
                else
                {
                    $videoSeriesInfo['related_videos'] = $related_videos;
                }
                
                $output    = array('result'  => $videoSeriesInfo, 
                'message'  => 'Workout video Details Fetched');            
            }            
            else
            {
                $error_data = array('code'  => 401 , 'error' => 'No subscription found.');               
                $output = array('message'  => $error_data);            
            }
        }       
        
        echo json_encode($output);    
       
    }

    // Workout video modules by video id

    public function modules_get() 
    {
        $output = array();
        $video_id = $this->input->get('video_id');
        
        if(empty($video_id))
        {
            $error_data = array('code'  => 401 , 'error' => 'Required info is missing.');               
            $output = array('message'  => $error_data);  
        } 
        else
        {                   
            /*
            * Fetch workout videos modules
            */
            $workoutVideoModules = $this->Workout_videos_model->getWorkoutVideoModules($video_id);                
            if(!empty($workoutVideoModules))
            {          
                foreach($workoutVideoModules as $key=>$value)
                {                   
                    $workoutVideoModules[$key]['module_image'] = base_url().'admin/views/uploads/modules/'.$value['module_image'];
                }
                
            }
            $output    = array('result'  => $workoutVideoModules, 
            'message'  => 'Workout video modules Fetched');            
            
        }       
        
        echo json_encode($output);    
       
    }

    // Workout video schedules by video id

    public function schedules_get() 
    {
        $output = array();
        $video_id = $this->input->get('video_id');
        
        if(empty($video_id))
        {
            $error_data = array('code'  => 401 , 'error' => 'Required info is missing.');               
            $output = array('message'  => $error_data);  
        } 
        else
        {                   
            /*
            * Fetch workout videos schedules
            */
            $workoutVideoSchedules = $this->Workout_videos_model->getWorkoutVideoSchedules($video_id);                
            if(!empty($workoutVideoSchedules))
            {          
                foreach($workoutVideoSchedules as $key=>$value)
                {                   
                    $workoutVideoSchedules[$key]['schedule_image'] = base_url().'admin/views/uploads/schedules/'.$value['schedule_image'];
                }
                
            }
            $output    = array('result'  => $workoutVideoSchedules, 
            'message'  => 'Workout video schedules Fetched');            
            
        }       
        
        echo json_encode($output);    
       
    }
    
    // Workout onboarding process add

    public function onboarding_post() 
    {              
        $customer_id                         = $this->post('customer_id');
        $onboarding_id                       = !empty($this->post('onboarding_id'))?$this->post('onboarding_id'):'';
        /*
        * Check if customer exists
        */
        $check_customer = $this->Workout_videos_model->checkCustomer($customer_id);
        if($check_customer > 0)
        {
            $userData = array();
        
            $userData['customer_id']                  = $this->post('customer_id');
            $userData['weight']                       = $this->post('weight');
            $userData['height']                       = $this->post('height');
            $userData['body_fat']                     = $this->post('body_fat');
            $userData['activity_level']               = $this->post('activity_level');
            $userData['exercise_location_preference'] = $this->post('exercise_location_preference');
            $userData['experience_level']             = $this->post('experience_level');
            $userData['injuries']                     = $this->post('injuries');
            $userData['workout_days_per_week']        = $this->post('workout_days_per_week');
            $userData['workout_goal']                 = $this->post('workout_goal');
            $userData['workout_session_duration']     = $this->post('workout_session_duration');
            $userData['shoulders_size']               = $this->post('shoulders_size');
            $userData['arms_size']                    = $this->post('arms_size');
            $userData['chest_size']                   = $this->post('chest_size');
            $userData['waist_size']                   = $this->post('waist_size');
            $userData['hips_size']                    = $this->post('hips_size');
            $userData['legs_size']                    = $this->post('legs_size');
            $userData['calves_size']                  = $this->post('calves_size');
            $userData['ip_address']                   = $_SERVER['REMOTE_ADDR']; 
            
            $onboarding_id = $this->Workout_videos_model->saveOnboardingProcess($onboarding_id , $userData);

            if($onboarding_id > 0)
            {
                $msg =    'User info saved successfully'; 
            }
            else
            {
                $msg =    'User info could not be saved';
            }
                 
            $output = array('message'  => $msg);            
            echo json_encode($output);
            exit;
        }
        else
        {
            $msg =    'User does not exists.';      
            $output = array('message'  => $msg);            
            echo json_encode($output);
            exit;
        }  
        
    }

    // Workout onboarding process edit

    public function onboarding_put() 
    {   
        $customer_id                         = $this->put('customer_id');
        $onboarding_id                       = $this->put('onboarding_id');
        /*
        * Check if customer exists
        */
        $check_customer = $this->Workout_videos_model->checkCustomer($customer_id);
        if($check_customer > 0)
        {
            $check_onboardtype = $this->Workout_videos_model->checkOnboard($onboarding_id);

            if($check_onboardtype > 0)
            {
                $userData = array();
            
                $userData['customer_id']                  = $this->put('customer_id');
                $userData['weight']                       = $this->put('weight');
                $userData['height']                       = $this->put('height');
                $userData['body_fat']                     = $this->put('body_fat');
                $userData['activity_level']               = $this->put('activity_level');
                $userData['exercise_location_preference'] = $this->put('exercise_location_preference');
                $userData['experience_level']             = $this->put('experience_level');
                $userData['injuries']                     = $this->put('injuries');
                $userData['workout_days_per_week']        = $this->put('workout_days_per_week');
                $userData['workout_goal']                 = $this->put('workout_goal');
                $userData['workout_session_duration']     = $this->put('workout_session_duration');
                $userData['shoulders_size']               = $this->put('shoulders_size');
                $userData['arms_size']                    = $this->put('arms_size');
                $userData['chest_size']                   = $this->put('chest_size');
                $userData['waist_size']                   = $this->put('waist_size');
                $userData['hips_size']                    = $this->put('hips_size');
                $userData['legs_size']                    = $this->put('legs_size');
                $userData['calves_size']                  = $this->put('calves_size');
                $userData['ip_address']                   = $_SERVER['REMOTE_ADDR']; 
                    
                $updateCount = $this->Workout_videos_model->updateOnboardingProcess($userData, $onboarding_id);

                if($updateCount > 0)
                {
                    $msg =    'Info updated successfully'; 
                }
                else
                {
                    $msg =    'Info could not be updated';
                }
                    
                $output = array('message'  => $msg);            
                echo json_encode($output);
                exit;
            }
            else
            {
                $msg =    'Onboading does not exists.';      
                $output = array('message'  => $msg);            
                echo json_encode($output);
                exit;
            }
        }
        else
        {
            $msg =    'User does not exists.';      
            $output = array('message'  => $msg);            
            echo json_encode($output);
            exit;
        }
    }

    // Onboarding process get by ID

    public function onboardingdetails_get() 
    {
        $output = array();
        $customer_id = $this->input->get('customer_id');
        if(empty($customer_id))
        {
            $error_data = array('code'  => 401 , 'error' => 'Onboarding id is missing.');               
            $output = array('message'  => $error_data);  
        } 
        else
        {
            /*
            * Fetch Workout videos details
            */
            $onboardingdetails = $this->Workout_videos_model->onboardingdetails($customer_id);            
            $output    = array('result'  => $onboardingdetails, 'message'  => 'Onboarding process fetched successfully');
            
        }       
        
        echo json_encode($output);    
       
    }
    
    // Workout video subscription details

    public function subscriptiondetails_get() 
    {
        $output = array();
        $email    = $this->input->get('email');
        
        if(empty($email))
        {
            $error_data = array('code'  => 401 , 'error' => 'Required info is missing.');               
            $output = array('message'  => $error_data);  
        } 
        else
        {
            $videoSeriesInfo = array();
            $getSubscriptionDetails = $this->Workout_videos_model->getSubscriptionDetails($email);
            if(!empty($getSubscriptionDetails))
            {                
                $output    = array('result'  => $getSubscriptionDetails, 
                'message'  => 'Workout video Subscription Details Fetched');            
            }            
            else
            {
                $error_data = array('code'  => 401 , 'error' => 'No subscription found.');               
                $output = array('message'  => $error_data);            
            }
        }       
        
        echo json_encode($output);    
       
    }

}
 ?>