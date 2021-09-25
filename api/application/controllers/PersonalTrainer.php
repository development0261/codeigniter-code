<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class personaltrainer extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('PersonalTrainers_model'));
    }

    /* Personal Trainer Regsitration Section */
    public function register_post()
    {        
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
            // else if(empty(trim($this->post('business_name')))){
            //     $error_message .= 'Business Name is missing';
            // }

            if(empty($error_message))
                {
                    $userData = array();
                    $userData['email']          = trim($this->post('email'));
                    $userData['password']       = trim($this->post('password'));
                    $userData['date_added']     = date("Y-m-d H:i:s");
                    $userData['business_name']  = trim($this->post('business_name'));
                    $userData['deviceid']       = trim($this->post('deviceid'));
                    
                    $userData['status']    = 1;
                    $userData['user_type']    = 'PersonalTrainer';

                    $email_already_exists = $this->PersonalTrainers_model->check_email_exists($userData['email']);

                    if($email_already_exists == 0)
                    {
                        if ($trainer_id = $this->PersonalTrainers_model->savePersonalTrainer(NULL, $userData))
                        {
                            /*Activate Trial plan by Default*/
                            $planDetails    = array();
                            $currDate       = date('Y-m-d');
                            $expiryDate     = date('Y-m-d', strtotime($currDate. ' + 30 days'));
                            $planDetails    = array('stripe_customer_id' => '', 'trainer_email' => $userData['email'], 'subscription_id' => '', 'is_active'=>'1', 'package_price' => 0, 'package_id' => 14, 'date_added' => date('Y-m-d H:i:s'), 'subscription_payment_iteration' => '1', 'subscription_end_date' => $expiryDate,'subscription_start_date' => $currDate);

                            // Insert into table
                            $coupon_id = $this->PersonalTrainers_model->savePlanPurchase(NULL, $planDetails);
                            // Insert into history table
                            $coupon_id = $this->PersonalTrainers_model->savePlanPurchaseHistory(NULL, $planDetails);

                            /*Activate Trial plan by Default Over*/
                            $trainer_data = array('trainer_id' => $trainer_id ,
                                            'email'       => $userData['email'],
                                            'date_added'  => $userData['date_added'],
                                            'business_name'  => $userData['business_name'] );

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Registered Successfully');

                            echo json_encode($output);
                            exit;
                        }
                    }
                    else
                    {
                        $msg =    'Email already exists.';
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

    /* Personal Trainer Regsitration Section */
    public function add_registration_details_post()
    {        
        if (!empty($this->post()))
        {
            $error_message = '';
            // if(empty(trim($this->post('timezone')))){
            //     $error_message .= 'timezone is missing';
            // } else 
            if(empty(trim($this->post('business_type')))){
                $error_message .= 'About Business is missing';
            } else if(empty(trim($this->post('about_trainer')))){
                $error_message .= 'About Trainer is missing';
            }else if(empty(trim($this->post('first_name')))){
                $error_message .= 'First Name is missing';
            }else if(empty(trim($this->post('last_name')))){
                $error_message .= 'Last Name is missing';
            }
            // else if(empty(trim($this->post('country')))){
            //     $error_message .= 'Country is missing';
            // }
            else if(empty(trim($this->post('city')))){
                $error_message .= 'City is missing';
            }else if(empty(trim($this->post('trainer_id')))){
                $error_message .= 'Tranier Id is missing';
            }
            
            if(!empty($_FILES['profile_image']['tmp_name'])){
                $file_name  = pathinfo($_FILES['profile_image']['name'], PATHINFO_FILENAME);
                $file_name  = preg_replace('/[^A-Za-z0-9\-]/', '-', $file_name).'-'.str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT);
                
                $file_ext  = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $image_name= $file_name.'.'.$file_ext;

                $target_dir = dirname(__FILE__).'/../../../admin/views/uploads/trainers/profile/'.$image_name;
                if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_dir)){
                    $imageData['profile_image'] = $image_name;
                } else {
                    $error_message .= 'Profile image upload failed';
                }
            }
                if(empty($error_message))
                {
                    $userData = array();
                    $userData['timezone']      = trim($this->post('timezone'));
                    $userData['business_type'] = trim($this->post('business_type'));
                    $userData['about_trainer'] = trim($this->post('about_trainer'));
                    $userData['first_name']    = trim($this->post('first_name'));
                    $userData['last_name']     = trim($this->post('last_name'));
                    $userData['country']       = trim($this->post('country'));
                    $userData['city']          = trim($this->post('city'));
                    $userData['trainer_id']    = trim($this->post('trainer_id'));
                    $userData['status']    = 1;
                    if(!empty($imageData)){
                        $userData['profile_picture']    = $imageData['profile_image'];
                        $userData['main_image']         = $imageData['profile_image'];
                    }

                    $check_trainer_exists = $this->PersonalTrainers_model->check_trainer_exists($userData['trainer_id']);
                    if($check_trainer_exists > 0)
                    {
                        if ($trainer_id = $this->PersonalTrainers_model->savePersonalTrainer($userData['trainer_id'], $userData))
                        {
                            $trainer_data = array(
                                            'first_name'       => $userData['first_name'],
                                            'last_name'  => $userData['last_name'],
                                            'business_type'  => $userData['business_type'],
                                            'about_trainer'  => $userData['about_trainer'],
                                            'timezone'  => $userData['timezone'],
                                            'country'  => $userData['country'],
                                            'city'  => $userData['city']);
                            if(!empty($imageData)){
                                $trainer_data['profile_picture'] = $imageData['profile_image'];
                            }

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Registration Fields Updated Successfully');

                            echo json_encode($output);
                            exit;
                        }
                    }
                    else
                    {
                        $msg    = 'Personal Trainer does not exists.';
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

    /*Personal Trainer profile details*/
    public function profile_details_get($trainer_id='')
    {
        $output = array();
        if(empty($trainer_id)){
            $error_data = array('code'  => 401 , 'error' => 'Trainer info Not Found.');
            $output = array('message'  => $error_data);
            echo json_encode($output);
            exit;
        } else{
            $check_trainer_exists = $this->PersonalTrainers_model->check_trainer_exists($trainer_id);
            if($check_trainer_exists > 0)
            {
                $profile_details    = $this->PersonalTrainers_model->personal_trainer_profile_details($trainer_id);
                $output     = array('result'  => $profile_details);
                echo json_encode($output);
                exit;
            }
            else
            {
                $output = array('message'  => 'Personal Trainer does not exists.');
                echo json_encode($output);
                exit;
            }
        }
    }
}
 ?>