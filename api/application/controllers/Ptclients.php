<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class Ptclients extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Ptclients_model'));
        $this->load->model(array('Trainers_model'));
    }

    // Add PT client by trainer

    public function add_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('trainer_id')))){
                $error_message .= 'Trainer is missing';
            } else if(empty(trim($this->post('first_name')))){
                $error_message .= 'First name is missing';
            } else if(empty(trim($this->post('last_name')))){
                $error_message .= 'Last name is missing';
            }

            if(empty($error_message))
                {
                    $userData                               = array();
                    $userData['trainer_id']                 = trim($this->post('trainer_id'));
                    $userData['first_name']                 = trim($this->post('first_name'));
                    $userData['last_name']                  = trim($this->post('last_name'));
                    $userData['email']                      = trim($this->post('email'));
                    $userData['phone']                      = trim($this->post('phone'));
                    /*check the trainer has been reached the limit or not*/
                    $trainerDetails = $this->Ptclients_model->getTrainerDetails($userData['trainer_id']);
                    // print_r($trainerDetails);exit();
                    $trainer_email  = '';
                    if(!empty($trainerDetails)){
                        $trainer_email  = $trainerDetails[0]['email'];
                    }
                    $trainersPlanLimit = 0;
                    if($trainer_email != '')
                    {
                        $trainersPlanLimitDetails = $this->Trainers_model->getCustomerSbscriptionCurrentPlan($trainer_email);
                        // print_r($trainersPlanLimitDetails->row());exit();
                        $planDetails = $trainersPlanLimitDetails->row();
                        $trainersPlanLimit = $planDetails->packag_client_limit;
                        // echo $trainersPlanLimit;exit();
                    }
                    /*get clients added*/
                    $getClientListByTrainerId = $this->Ptclients_model->getClientListByTrainerId($userData['trainer_id'], 1, 1);
                    $countTotalClients = count($getClientListByTrainerId);
                    // echo $trainersPlanLimit."-----".$countTotalClients;exit();
                    if(($trainersPlanLimit > 0) && ($countTotalClients < $trainersPlanLimit))
                    {
                        if ($trainer_program_id = $this->Ptclients_model->AddClient(NULL, $userData))
                        {
                            $trainer_data = array(
                                                'trainer_program_id'        => $trainer_program_id ,
                                                'trainer_id'                => $userData['trainer_id'] ,
                                                'first_name'                => $userData['first_name'] ,
                                                'last_name'                 => $userData['last_name'],
                                                'email'                     => $userData['email'],
                                                'phone'                     => $userData['phone']
                                                );

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Client added Successfully');

                            echo json_encode($output);
                            exit;

                        }
                        else
                        {
                        /* $error_data = array('code'  => 401 ,
                                                'error' => 'Email-id already exists.');      */
                            $msg =    'Client add failed.';
                            $output = array('message'  => $msg);

                            echo json_encode($output);
                            exit;
                        }
                    }
                    else if($trainersPlanLimit == 'Unlimited')
                    {
                        if ($trainer_program_id = $this->Ptclients_model->AddClient(NULL, $userData))
                        {
                            $trainer_data = array(
                                                'trainer_program_id'        => $trainer_program_id ,
                                                'trainer_id'                => $userData['trainer_id'] ,
                                                'first_name'                => $userData['first_name'] ,
                                                'last_name'                 => $userData['last_name'],
                                                'email'                     => $userData['email'],
                                                'phone'                     => $userData['phone']
                                                );

                            $output = array('result'  => $trainer_data,
                                            'message' => 'Client added Successfully');

                            echo json_encode($output);
                            exit;

                        }
                        else
                        {
                        /* $error_data = array('code'  => 401 ,
                                                'error' => 'Email-id already exists.');      */
                            $msg =    'Client add failed.';
                            $output = array('message'  => $msg);

                            echo json_encode($output);
                            exit;
                        }
                    }
                    else
                    { 
                        $msg =    'You have reached limit to add clients';
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

    // Add PT client program relation by trainer

    public function addprogram_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('pt_client_id')))){
                $error_message .= 'Client is missing';
            } else if(empty(trim($this->post('trainer_program_id')))){
                $error_message .= 'Trainer program is missing';
            } 

            if(empty($error_message))
                {
                    $userData                               = array();
                    $userData['pt_client_id']               = trim($this->post('pt_client_id'));
                    $userData['trainer_program_id']         = trim($this->post('trainer_program_id'));
                    $userData['program_category_id']        = trim($this->post('program_category_id'));
                    $userData['custom_values']              = $this->post('custom_values');
                    $userData['schedule_date']              = $this->post('schedule_date');

                    if ($clients_program_id = $this->Ptclients_model->clientProgramRelation(NULL, $userData))
                    {
                        $trainer_data = array(
                                            'clients_program_id'        => $clients_program_id ,
                                            'pt_client_id'              => $userData['pt_client_id'] ,
                                            'trainer_program_id'        => $userData['trainer_program_id'] ,
                                            'custom_values'             => $userData['custom_values'],
                                            'schedule_date'             => $userData['schedule_date'],
                                            );

                        $output = array('result'  => $trainer_data,
                                        'message' => 'Client Program Added Successfully');

                        echo json_encode($output);
                        exit;

                    }                    
                    else
                    {
                    /* $error_data = array('code'  => 401 ,
                                            'error' => 'Email-id already exists.');      */
                        $msg =    'Client add failed.';
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

    // Edit PT client program relation by trainer

    public function editprogram_put()
    {
        if (!empty($this->put()))
        {
            $error_message = '';
            if(empty(trim($this->put('clients_program_id')))){
                $error_message .= 'Client program id is missing';
            }else if(empty(trim($this->put('pt_client_id')))){
                $error_message .= 'Client id is missing';
            } else if(empty(trim($this->put('trainer_program_id')))){
                $error_message .= 'Trainer program id is missing';
            } 

            if(empty($error_message))
                {
                    $userData                               = array();
                    $userData['clients_program_id']         = trim($this->put('clients_program_id'));
                    $userData['pt_client_id']               = trim($this->put('pt_client_id'));
                    $userData['trainer_program_id']         = trim($this->put('trainer_program_id'));
                    $userData['program_category_id']        = trim($this->put('program_category_id'));
                    $userData['custom_values']              = $this->put('custom_values');
                    $userData['schedule_date']              = $this->put('schedule_date');
                    
                    // Check whether trainer program relation exists or not
                    $programRelationData = $this->Ptclients_model->check_program_relation_exists($userData);
                    // Allow update if record exists
                    if(!empty($programRelationData)){
                        if ($clients_program_id = $this->Ptclients_model->clientProgramRelation($userData['clients_program_id'], $userData))
                        {
                            $trainer_data = array(
                                                'clients_program_id'        => $clients_program_id,
                                                'pt_client_id'              => $userData['pt_client_id'],
                                                'trainer_program_id'        => $userData['trainer_program_id'],
                                                'custom_values'             => $userData['custom_values'],
                                                'schedule_date'             => $userData['schedule_date'],
                                                );
    
                            $output = array('result'  => $trainer_data,
                                            'message' => 'Client Program Added Successfully');
    
                            echo json_encode($output);
                            exit;
    
                        }                    
                        else
                        {
                            $msg =    'Client add failed.';
                            $output = array('message'  => $msg);    
                            echo json_encode($output);
                            exit;
                        }
                    } else {
                            $msg =    'Client program does not exists.';
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
    * Training program get by client ID
    */
    public function programgroupbydate_get($pt_client_id = '') {
        $output = array();
        $pt_client_id = $this->input->get('pt_client_id');
        $scheduled_programs = array();
        if(empty($pt_client_id)){
            $error_data = array('code'  => 401 , 'error' => 'Info Not Found.');
            $output = array('message'  => $error_data);
        } else {
            $getPrograms = $this->Ptclients_model->getProgramListGroupByDate($pt_client_id);         
            
            if(!empty($getPrograms)){    
                foreach($getPrograms as $key=>$value){
                    if(empty($scheduled_programs[$value['schedule_date']])){                       
                        $scheduled_programs[$value['schedule_date']] = array();
                    } 
                    $scheduled_programs[$value['schedule_date']][] =$value;
                }
                $output    = array('result'  => $getPrograms,
                'message'  => 'Client programs fetched');
            } else {
                $error_data = array('code'  => 401 , 'error' => 'Client Not Found.');
                $output = array('message'  => $error_data);
            }
        }

        echo json_encode($output);

    }

    
    // Add PT client goal by trainer

    public function addgoal_post()
    {
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('pt_client_id')))){
                $error_message .= 'Client is missing';
            } else if(empty(trim($this->post('trainer_id')))){
                $error_message .= 'Trainer is missing';
            } else if(empty(trim($this->post('title')))){
                $error_message .= 'Title is missing';
            } 

            if(empty($error_message))
                {
                    $userData                               = array();
                    $userData['pt_client_id']               = trim($this->post('pt_client_id'));
                    $userData['trainer_id']                 = trim($this->post('trainer_id'));
                    $userData['title']                      = $this->post('title');
                    $userData['order']                      = $this->post('order');
                    $userData['progress_percent']           = $this->post('progress_percent');

                    if ($pt_client_goal_module_id = $this->Ptclients_model->addClientGoal(NULL, $userData))
                    {
                        $trainer_data = array(
                                            'pt_client_goal_module_id'      => $pt_client_goal_module_id ,
                                            'pt_client_id'                  => $userData['pt_client_id'] ,
                                            'trainer_id'                    => $userData['trainer_id'] ,
                                            'title'                         => $userData['title'],
                                            'order'                         => $userData['order'] ,
                                            'progress_percent'              => $userData['progress_percent']
                                            );

                        $output = array('result'  => $trainer_data,
                                        'message' => 'Client Goal Added Successfully');

                        echo json_encode($output);
                        exit;

                    }                    
                    else
                    {
                    /* $error_data = array('code'  => 401 ,
                                            'error' => 'Email-id already exists.');      */
                        $msg =    'Client add failed.';
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

    // Add PT client goal by trainer

    public function editgoal_put()
    {
        if (!empty($this->put()))
        {
            $error_message = '';
            if(empty(trim($this->put('pt_client_goal_module_id')))){
                $error_message .= 'Client goal id is missing';
            } else if(empty(trim($this->put('pt_client_id')))){
                $error_message .= 'Client is missing';
            } else if(empty(trim($this->put('trainer_id')))){
                $error_message .= 'Trainer is missing';
            } 

            if(empty($error_message))
                {
                    $userData                               = array();
                    $userData['pt_client_goal_module_id']   = trim($this->put('pt_client_goal_module_id'));
                    $userData['pt_client_id']               = trim($this->put('pt_client_id'));
                    $userData['trainer_id']                 = trim($this->put('trainer_id'));
                    $userData['title']                      = $this->put('title');
                    $userData['order']                      = $this->put('order');
                    $userData['progress_percent']           = $this->put('progress_percent');
                    $userData['new_order']                  = $this->put('new_order');
                    //$userData['new_order']                  = $this->put('new_order');
                    
                    if ($pt_client_goal_module_id = $this->Ptclients_model->addClientGoal($userData['pt_client_goal_module_id'], $userData))
                    {
                        $trainer_data = array(
                                            'pt_client_goal_module_id'      => $pt_client_goal_module_id ,
                                            'pt_client_id'                  => $userData['pt_client_id'] ,
                                            'trainer_id'                    => $userData['trainer_id'] ,
                                            'title'                         => $userData['title'],
                                            'current_order'                 => $userData['current_order'] ,
                                            'new_order'                     => $userData['new_order'] ,
                                            'progress_percent'              => $userData['progress_percent']
                                            );

                        $output = array('result'  => $trainer_data,
                                        'message' => 'Client Goal Data Successfully Processed');

                        echo json_encode($output);
                        exit;

                    }                    
                    else
                    {
                    /* $error_data = array('code'  => 401 ,
                                            'error' => 'Email-id already exists.');      */
                        $msg =    'Client add failed.';
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
    * Training program
    */
    public function list_get($trainer_id = '') {
        $output = array();
        $trainer_id = $this->input->get('trainer_id');

        if(empty($trainer_id)){
            $error_data = array('code'  => 401 , 'error' => 'Trainer info Not Found.');
            $output = array('message'  => $error_data);
        } else {
            $clientListByTrainerId = $this->Ptclients_model->getClientListByTrainerId($trainer_id);
            if(!empty($clientListByTrainerId)){
                foreach ($clientListByTrainerId as $trainerKey => $trainerValue)
                {
                    if($clientListByTrainerId[$trainerKey]['status'] == 1)
                    {
                        $clientListByTrainerId[$trainerKey]['status'] = 'Active';
                    }
                    else
                    {
                        $clientListByTrainerId[$trainerKey]['status'] = 'Deactive';
                    }
                }
                $output    = array('result'  => $clientListByTrainerId,
                'message'  => 'Client records Fetched');
            } else {
                $error_data = array('code'  => 401 , 'error' => 'Client Not Found.');
                $output = array('message'  => $error_data);
            }
        }

        echo json_encode($output);

    }

    /*
    * Training program get by client ID
    */
    public function programlist_get($pt_client_id = '', $program_category_id = '') {
        $output = array();
        $pt_client_id = $this->input->get('pt_client_id');
        $program_category_id = $this->input->get('program_category_id');

        if(empty($pt_client_id) && empty($program_category_id)){
            $error_data = array('code'  => 401 , 'error' => 'Info Not Found.');
            $output = array('message'  => $error_data);
        } else {
            $getPrograms = $this->Ptclients_model->getProgramListByClientId($pt_client_id, $program_category_id);
            
            if(!empty($getPrograms)){    
                foreach($getPrograms as $key=>$value){
                    $getPrograms[$key]['custom_values'] = json_decode($getPrograms[$key]['custom_values']);
                    $getPrograms[$key]['program_picture'] = base_url().'admin/views/uploads/programs/'.$value['program_picture'];
                }            
                $output    = array('result'  => $getPrograms,
                'message'  => 'Client programs fetched');
            } else {
                $error_data = array('code'  => 401 , 'error' => 'Client Not Found.');
                $output = array('message'  => $error_data);
            }
        }

        echo json_encode($output);

    }

    /*
    * Client goal list by client id
    */
    public function listgoal_get($pt_client_id = '') {
        $output = array();
        $pt_client_id = $this->input->get('pt_client_id');

        if(empty($pt_client_id)){
            $error_data = array('code'  => 401 , 'error' => 'Client info Not Found.');
            $output = array('message'  => $error_data);
        } else {
            $getClientGoalListByClientId = $this->Ptclients_model->getClientGoalListByClientId($pt_client_id);
            if(!empty($getClientGoalListByClientId)){                
                $output    = array('result'  => $getClientGoalListByClientId,
                'message'  => 'Client goal records Fetched');
            } else {
                $error_data = array('code'  => 401 , 'error' => 'Client goal not found.');
                $output = array('message'  => $error_data);
            }
        }

        echo json_encode($output);

    }

    /*
    * Training program get by client ID
    */
    public function goaldelete_delete($pt_client_goal_module_id = '') {
        $output = array();
        $pt_client_goal_module_id = $this->input->get('pt_client_goal_module_id');
        
        if(empty($pt_client_goal_module_id)){
            $error_data = array('code'  => 401 , 'error' => 'Client Goal Info Not Found.');
            $output = array('message'  => $error_data);
        } else {
            $deleteClientGoal = $this->Ptclients_model->deleteClientGoal($pt_client_goal_module_id); 
            $output    = array('result'  => [],
            'message'  => 'Goal record deleted succesfully');
            echo json_encode($output);           
        }        

    }

    /*
    * Training program
    */
    public function programcategories_get() {
        $output = array();
        $programCategories = $this->Ptclients_model->programCategories();
        if(!empty($programCategories)){       
            foreach($programCategories as $key=>$value){
                $programCategories[$key]['category_image'] = base_url().'admin/views/uploads/programs/categories/'.$value['category_image'];
            }         
            $output    = array('result'  => $programCategories,
            'message'  => 'Progam categories records Fetched');
        } else {
            $error_data = array('code'  => 401 , 'error' => 'Client Not Found.');
            $output = array('message'  => $error_data);
        }      

        echo json_encode($output);

    }

    /*
    * Activate deactivate client
    */
    public function statusChange_post()
    {
        $output = array();
        // echo "hetal";print_r(trim($this->post('status')));exit();
        if (!empty($this->post()))
        {
            $error_message = '';
            if(empty(trim($this->post('trainer_id')))){
                $error_message .= 'Trainer is missing';
            } else if(empty(trim($this->post('status')))){
                $error_message .= 'Status is missing';
            }

            if(empty($error_message))
                {
                    $userData                    = array();
                    $userData['trainer_id']      = trim($this->post('trainer_id'));
                    $userData['status']          = trim($this->post('status'));
                    
                    /*check before deactivating the plan if any active clients are exists or not and which is exceeds the limit to add more client or not*/
                    $error = 0;
                    if($userData['status'] == 'Activate')
                    {
                        /*get trainers details*/
                        $getClientdetails = $this->Ptclients_model->getClientdetails($userData['trainer_id']);
                        $trainer_id = 0;
                        if($getClientdetails->num_rows() > 0 )
                        {
                            $trainer_id = $getClientdetails->row()->trainer_id;
                        }
                        /*get clients count based on trainer id*/
                        $getClientListByTrainerId = $this->Ptclients_model->getClientListByTrainerId($trainer_id, 1, 1);
                        $countTotalClients = count($getClientListByTrainerId);
                        /*get trainers selected plan details and profile details*/
                        $trainerDetails = $this->Ptclients_model->getTrainerDetails($trainer_id);
                        $trainerEmail   = '';
                        if(!empty($trainerDetails)){
                            $trainerEmail   = $trainerDetails[0]['email'];
                        }
                        $trainersPlanLimitDetails = $this->Trainers_model->getCustomerSbscriptionCurrentPlan($trainerEmail);
                        $planDetails = $trainersPlanLimitDetails->row();
                        $trainersPlanLimit = $planDetails->packag_client_limit;

                        // echo $countTotalClients."===".$trainersPlanLimit;
                        // exit();
                        if($countTotalClients == $trainersPlanLimit)
                        {
                            $msg =    'Your plan limit has been reached. If you want to activate the existing client please upgrade your plan.';
                            $output = array('message'  => $msg);

                            echo json_encode($output);
                            exit;
                        }
                    }
                    if ($this->Ptclients_model->UpdateClientStatus($userData))
                    {
                        if($userData['status'] == 'Activate')
                        {
                            $output = array('message' => 'Client Activate Successfully');
                        }
                        else
                        {
                            $output = array('message' => 'Client Deactivate Successfully');   
                        }
                        echo json_encode($output);
                        exit;
                    }                    
                    else
                    {
                        $msg =    'Client Status Change Failed.';
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
    * Remove client
    */
    public function removeClient_get($pt_client_id = '')
    {
        $output = array();
        $pt_client_id = $this->input->get('trainer_client_id');
        // echo $pt_client_id;exit();
        if (!empty($pt_client_id))
        {
            $error_message = '';
            if(empty(trim($pt_client_id))){
                $error_message .= 'Client is missing';
            }

            if(empty($error_message))
            {
                $userData                    = array();
                $userData['trainer_client_id']      = $pt_client_id;
                // print_r($userData);exit();
                if ($this->Ptclients_model->RemoveClient($userData))
                {
                    $output = array('message' => 'Client Removed Successfully.');
                    echo json_encode($output);
                    exit;
                }                    
                else
                {
                    $msg =    'Remove Client Is Failed.';
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
            $output = array('message'  => 'Input values are missing.');
            echo json_encode($output);
            exit;
        }
    }
}
 ?>