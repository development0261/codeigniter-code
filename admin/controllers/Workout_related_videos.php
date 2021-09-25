<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

 

class workout_related_videos extends Admin_Controller {


    public function __construct() {

        
        parent::__construct();
        $this->load->model(array('Workout_related_videos_model'));
        $this->user->restrict('Site.Stories');

         
        $this->load->library('pagination');
        $this->load->library('form_validation');

    }   
    
    // Workout videos categories


    public function index()
    {
        
         
 

        $this->template->setTitle('Workout Videos');
        $this->template->setHeading('Workout Videos');        
 
        $data['workoutVvideoModules'] = $this->Workout_related_videos_model->workoutVvideoModules() ; 
        $data['scheduleList'] = $this->Workout_related_videos_model->scheduleList() ; 
        $data['moduleList'] = $this->Workout_related_videos_model->moduleList() ; 


        $this->template->render('workout_related_videos', $data);
    }


    public function __index()
    {
        
         
        // echo "<pre>";print_r($_SESSION);exit();
        $url = '?';
        $filter = array();
        if ($this->input->get('page')) {
            $filter['page'] = (int) $this->input->get('page');
        } else {
            $filter['page'] = '';
        }

        if ($this->config->item('page_limit')) {
            $filter['limit'] = $this->config->item('page_limit');
        }

        if ($this->input->get('sort_by')) {
            $filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
        } else {
            $filter['sort_by'] = $data['sort_by'] = 'workout_related_video_id';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') . ' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = '';
        }

        $this->template->setTitle('Workout Videos');
        $this->template->setHeading('Workout Videos');        
        //$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

        if ($this->input->post('delete') and $this->_deleteWorkoutVideos() === true) {
            redirect('subscriptions');
        }

        //load stories data into array
        $data['subscriptionsRec'] = $this->Workout_related_videos_model->getList($filter);
        
        if ($this->input->get('sort_by') and $this->input->get('order_by')) {
            $url .= '&sort_by=' . $filter['sort_by'] . '&';
            $url .= '&order_by=' . $filter['order_by'] . '&';
        }

        $config['base_url'] = site_url('subscriptions' . $url);
        $config['total_rows'] = $this->Workout_related_videos_model->getCount($filter);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info' => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links(),
        );

         //echo "<pre>";print_r($data['subscriptionsRec']->result()); die('eeess') ; 


        $this->template->render('workout_related_videos', $data);
    }


    private function _deleteWorkoutVideos()
    {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Workout_videos_model->deleteTrainers($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Trainers' : 'Trainer';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return true;
        }
    }


     public function actionlist(){ 

        if(!empty($_POST['action']) && $_POST['action'] == 'listVideo') {
            $this->videoList();
            exit() ; 
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'addVideo') {
             
            $this->addVideo();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'getVideo') {
            
            $this->getVideo();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'updateVideo') {
            $this->updateVideo();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'empVideo') {
            $this->deleteVideo();
        }
       if(!empty($_POST['action']) && $_POST['action'] == 'updateIndiviVideo') {
            $this->updateIndiviVideo();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'cloneVideo') {
            $this->addVideo();
        }

     }   


    function updateIndiviVideo(){

       $data = array() ; 
       $data[$_POST['column_name']] = $_POST['value'] ; 
       unset($data['action']) ;
       unset($data['empId']) ;
       $this->Workout_related_videos_model->updateVideo($_POST['empId'],$data);


    } 


    function addVideo(){

          if ($this->validateForm() === TRUE) {
               
               if(empty($_FILES['image']['tmp_name'])){
                    $data['error_message'] = 'Select Image' ; 
                    $data['error'] = 1;
                    echo json_encode($data);
                    exit();
               }     
               $image = $this->validateImage() ;
               $data =  $_POST;      
               unset($data['empId']) ;
               unset($data['action']) ;
               $data['image'] = $image ; 
               $this->Workout_related_videos_model->saveVideo($data);
               $data['error_message'] = '' ; 
               $data['error'] = 0;
               echo json_encode($data);
               exit();
            
        }
        else{
            $data['error_message'] = validation_errors() ; 
            $data['error'] = 1;
            
        }    
        echo json_encode($data);
        exit();
    } 

    public function validateImage()
    {
 


       if(!empty($_FILES['image']['tmp_name'])){

     
            $image_name= time().'_'.$_FILES['image']['name'] ; 

            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));        

            $allowedExts = array("gif", "jpeg", "jpg", "png","bmp");
            if(!in_array($file_ext, $allowedExts)){

                $data['error_message'] = 'You are allowed to upload gif, jpeg, jpg, png, bmp only' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();           
            }


            $image_info = getimagesize($_FILES["image"]["tmp_name"]);
            $image_width = $image_info[0];
          
            $image_height = $image_info[1];
            if($image_width!=300 or $image_height!=300 ){

                $data['error_message'] = 'Please resize your image to 300x300 and try again' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();                     


            }         
            //echo APPPATH ; 

            $target_dir = APPPATH.'views/uploads/workoutvideos/'.$image_name;

            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)){
                        
               return $image_name ;  
           }else{
                $data['error_message'] = 'Error while uploading image' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();                     


           }     

       }

 


    }


    function getVideo(){
        //echo 'yes' ;
        $data = $this->Workout_related_videos_model->getVideo($_POST['empId']);
        //print_r($data);
        echo json_encode($data);
        exit(0);

    } 

    function updateVideo(){

        $data =  $_POST; 
        unset($data['action']) ;
        unset($data['empId']) ;


       if(!empty($_FILES['image']['tmp_name'])){
              $image = $this->validateImage() ;
              $data['image'] = $image ;

       } 



        $this->Workout_related_videos_model->updateVideo($_POST['empId'],$data);
        $data['error_message'] = '' ; 
        $data['error'] = 0;
        echo json_encode($data);
        exit();
    } 

 
    function deleteVideo(){

       $data =  $_POST;  
       $this->Workout_related_videos_model->deleteVideo($_POST['empId']);


    }    
 

    public function videoList(){     
 
    

         
        $search_cond = '';
        $order = '' ; 
        $limit = '' ; 
        //if(!empty($_POST["search"]["value"])){
         if($_POST["search"]["value"]!=''){
            if($_POST['searchCol']!=''){                
                $search_cond .= ' where ('.$_POST['searchCol'].'  LIKE "%'.$_POST["search"]["value"].'%" ) ';
                if($_POST['week']!=''){
                    $search_cond .= '  AND (  workout_video_schedule_id  LIKE "%'.$_POST["week"].'%" ) ';
                }

                if($_POST['category']!=''){
                    $search_cond .= '  AND  ( workout_video_module_id  LIKE "%'.$_POST["category"].'%" ) ';
                }

            }else{                 
                $search_cond .= ' where (workout_related_video_id  LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR workout_video_id LIKE "%'.$_POST["search"]["value"].'%" ';            
                $search_cond .= ' OR title LIKE "%'.$_POST["search"]["value"].'%" ';            
                $search_cond .= ' OR description LIKE "%'.$_POST["search"]["value"].'%" ';            
                $search_cond .= ' OR video_url LIKE "%'.$_POST["search"]["value"].'%" ';            
                $search_cond .= ' OR week LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR day LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR sets LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR reps LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR duration LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR status LIKE "%'.$_POST["search"]["value"].'%" ';         
                $search_cond .= ' OR is_paid LIKE "%'.$_POST["search"]["value"].'%") ';
 

                if($_POST['week']!=''){
                    $search_cond .= '  AND (  workout_video_schedule_id  LIKE "%'.$_POST["week"].'%" ) ';
                }

                if($_POST['category']!=''){
                    $search_cond .= '  AND  ( workout_video_module_id  LIKE "%'.$_POST["category"].'%" ) ';
                }


                /*
                    
                $search_cond .= ' where (rv.workout_related_video_id  LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR rv.workout_video_id LIKE "%'.$_POST["search"]["value"].'%" ';            
                $search_cond .= ' OR rv.title LIKE "%'.$_POST["search"]["value"].'%" ';            
                $search_cond .= ' OR rv.description LIKE "%'.$_POST["search"]["value"].'%" ';            
                $search_cond .= ' OR rv.video_url LIKE "%'.$_POST["search"]["value"].'%" ';            
                $search_cond .= ' OR rv.week LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR rv.day LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR rv.sets LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR rv.reps LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR rv.duration LIKE "%'.$_POST["search"]["value"].'%" ';
                $search_cond .= ' OR rv.status LIKE "%'.$_POST["search"]["value"].'%" ';         
                $search_cond .= ' OR rv.is_paid LIKE "%'.$_POST["search"]["value"].'%") '; 
                */
                }      
        }else{

                $search_cond .= ' where 1=1 ';
                if($_POST['week']!=''){
                    $search_cond .= '  AND (  workout_video_schedule_id  LIKE "%'.$_POST["week"].'%" ) ';
                }

                if($_POST['category']!=''){
                    $search_cond .= '  AND  ( workout_video_module_id  LIKE "%'.$_POST["category"].'%" ) ';
                }

        }

        //echo $search_cond ; 
        //$or_array(0=>'rv.workout_related_video_id',1=>'rv.title') ;

        $or_array = array(0=>'workout_related_video_id',1=>'title') ;
        
        if(!empty($_POST["order"])){
            $order = 'ORDER BY '.$or_array[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
        } else {
            $order = 'ORDER BY workout_related_video_id DESC ';
        }
        //echo $order ; 
        $sqlQuery_before_limit  = $sqlQuery ; 

        if($_POST["length"] != -1){
            $limit = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
           // $limit = 'LIMIT 0 , 10';
        } else{
            $limit = 'LIMIT 0 , 10';
        }  


        $data['subscriptionsRec'] = $this->Workout_related_videos_model->get_all_records_related_videos($search_cond,$order,$limit);
        //print_r($data['subscriptionsRec']);
        
        $videoData = array();    
        foreach($data['subscriptionsRec'] as $key=>$value) {
            
            $empRows = array();         
            $empRows[] = $value->workout_related_video_id;
            $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="title">'.$value->title.'</div>'  ;
            $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="description">'.$value->description.'</div>'  ;
            //$empRows[] = $value->description ;

            //$empRows[] = $value->name;
           // $empRows[] = $value->name;
            
            $empRows[] = $this->Workout_related_videos_model->get_workout_video(8);
            $empRows[] = $this->Workout_related_videos_model->get_workout_video_module($value->workout_video_module_id);
            $empRows[] = $this->Workout_related_videos_model->get_workout_video_schedule($value->workout_video_schedule_id);
            //$empRows[] = $value->module_name;
            //$empRows[] = $value->schedule_name;

            //$empRows[] = $value->video_url;
            $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="video_url">'.$value->video_url.'</div>'  ;
        
            //$empRows[] = $value->image;
            //$empRows[] =  '<img src="'.base_url().'views/uploads/workoutvideos/'.$value->image.' />';
            $empRows[] =  '<a target="_blank" href="'.base_url().'views/uploads/workoutvideos/'.$value->image.'"> <img alt="No Image" width="50" src="'.base_url().'views/uploads/workoutvideos/'.$value->image.'"/></a>';
            //<img src="img_girl.jpg" alt="Girl in a jacket" width="500" height="600">
            //$empRows[] = $value->image;
            $empRows[] = $value->filename;

            // $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="first_name">' . $row["first_name"] . '</div>';

                        $empRows[] =  '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="week">'.$value->week.'</div>'  ;     
                        $empRows[] =  '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="day">'.$value->day.'</div>'  ;  
                        $empRows[] =  '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="sets">'.$value->sets.'</div>'  ;  

                        $empRows[] =  '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="reps">'.$value->reps.'</div>'  ;                    
                        $empRows[] =  '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="duration">'.$value->duration.'</div>'  ;  
                        //if($value->status==1) $empRows[]  = 'Active' ; else  $empRows[]  = 'Active' ;
                        //if($value->is_paid==1) $empRows[]  = 'Paid' ; else  $empRows[]  = 'UpPaid' ;
                        $empRows[] = $value->status;                  
                        $empRows[] = $value->is_paid;
            /*
            $empRows[] = $value->workout_related_video_id;
            $empRows[] = $value->workout_related_video_id;
            $empRows[] = $value->workout_related_video_id;
            $empRows[] = $value->workout_related_video_id;
            $empRows[] = $value->workout_related_video_id;
            $empRows[] = $value->workout_related_video_id;
            */
                  
            $empRows[] = '<button title="Edit" type="button" name="update" id="'.$value->workout_related_video_id.'" class="btn btn-warning btn-xs update"><i class="fa fa-edit"></i></button> &nbsp;&nbsp; <button title="Delete" type="button" name="delete" id="'.$value->workout_related_video_id.'" class="btn btn-danger btn-xs delete" ><i class="fa fa-trash"></i></button><button title="Clone" type="button" name="update" id="'.$value->workout_related_video_id.'" class="btn btn-warning btn-xs clone"><i class="fa fa-clipboard"></i></button> &nbsp;&nbsp;';
        
            $videoData[] = $empRows;
        }

 
       // print_r($videoData); die() ; 

        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      => $this->Workout_related_videos_model->get_all_records_related_videos_count(),
            "recordsFiltered"   => $this->Workout_related_videos_model->get_all_records_related_videos_with_condition($search_cond),
            "data"              =>  $videoData
        );
        
        echo json_encode($output);  
    }





    private function validateForm() {


        //print_r($_POST);
        $this->form_validation->set_rules('workout_video_id', 'Workout Video', 'xss_clean|trim|required');

        //$this->form_validation->set_rules('image', 'Image', 'xss_clean|trim|required');

        $this->form_validation->set_rules('title', 'Title ', 'xss_clean|trim|required');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|trim|required');
        $this->form_validation->set_rules('video_url', 'Video Url', 'xss_clean|trim|required');
        $this->form_validation->set_rules('workout_video_module_id', 'Category', 'xss_clean|trim|required');
        $this->form_validation->set_rules('workout_video_schedule_id', 'Schedule', 'xss_clean|trim|required');



        $this->form_validation->set_rules('week', 'Week', 'xss_clean|trim|required');
        $this->form_validation->set_rules('day', 'Day', 'xss_clean|trim|required');
        $this->form_validation->set_rules('sets', 'Sets', 'xss_clean|trim|required');
        $this->form_validation->set_rules('reps', 'Reps', 'xss_clean|trim|required');

        $this->form_validation->set_rules('filename', 'Filename', 'xss_clean|trim|required');
        $this->form_validation->set_rules('duration', 'Duration', 'xss_clean|trim|required');
        $this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required');
        $this->form_validation->set_rules('is_paid', 'Paid Status', 'xss_clean|trim|required');
 

        //$this->form_validation->set_rules('min_capacity', 'lang:label_min_capacity', 'xss_clean|trim|required|integer|greater_than[1]');
        //$this->form_validation->set_rules('max_capacity', 'lang:label_capacity', 'xss_clean|trim|required|integer|greater_than[1]|callback__check_capacity');
        //$this->form_validation->set_rules('table_status', 'lang:label_status', 'xss_clean|trim|required|integer');
        //$this->form_validation->set_rules('additional_charge', 'lang:label_additional_charge', 'xss_clean|trim|required|integer');
        //$this->form_validation->set_rules('total_price', 'lang:label_total_price', 'xss_clean|trim|required|integer');

        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }




    public function categories()
    {
        

        $this->template->setTitle('Workout Videos Categories');
        $this->template->setHeading('Workout Videos Categories');        
        $this->template->render('workout_related_videos_category', $data);
    }


     public function categoryactionlist(){ 


        if(!empty($_POST['action']) && $_POST['action'] == 'listCategory') {
            $this->CategoryList();
            exit() ; 
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'addCategory') {
             
            $this->addCategory();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'getCategory') {
            
            $this->getCategory();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'updateCategory') {
            $this->updateCategory();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'empCategory') {
             
            $this->deleteCategories();
            
        }
       if(!empty($_POST['action']) && $_POST['action'] == 'updateIndiviCategory') {
            $this->updateIndiviCategory();
        }

     }   














   function updateIndiviCategory(){

       $data = array() ; 
       $data[$_POST['column_name']] = $_POST['value'] ; 
       unset($data['action']) ;
       unset($data['empId']) ;
       $this->Workout_related_videos_model->updateCategory($_POST['empId'],$data);


    } 


    function addCategory(){

          if ($this->validateFormCategory() === TRUE) {

                //print_r($_FILES);
               
               if(empty($_FILES['image']['tmp_name'])){
                 
                    $data['error_message'] = 'Select Image' ; 
                    $data['error'] = 1;
                     echo json_encode($data);
                    exit();
               } 

               $image = $this->validateImageCategory() ;
               $data =  $_POST;      
               unset($data['empId']) ;
               unset($data['action']) ;
               $data['module_image'] = $image ;
               $data['workout_video_id'] = 8 ;

               $this->Workout_related_videos_model->saveCategory($data);
               $data['error_message'] = '' ; 
               $data['error'] = 0;
                echo json_encode($data);
                 exit();
            
        }
        else{
            $data['error_message'] = validation_errors() ; 
            $data['error'] = 1;
            
        }    
        echo json_encode($data);
        exit();
    } 

    public function validateImageCategory()
    {
 


       if(!empty($_FILES['image']['tmp_name'])){

     
            $image_name= time().'_'.$_FILES['image']['name'] ; 

            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));        

            $allowedExts = array("gif", "jpeg", "jpg", "png","bmp");
            if(!in_array($file_ext, $allowedExts)){

                $data['error_message'] = 'You are allowed to upload gif, jpeg, jpg, png, bmp only' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();           
            }


            $image_info = getimagesize($_FILES["image"]["tmp_name"]);
            $image_width = $image_info[0];
          
            $image_height = $image_info[1];
            if($image_width!=300 or $image_height!=300 ){

                $data['error_message'] = 'Please resize your image to 300x300 and try again' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();                     


            }         
            //echo APPPATH ; 

            $target_dir = APPPATH.'views/uploads/modules/'.$image_name;

            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)){
                        
               return $image_name ;  
           }else{
                $data['error_message'] = 'Error while uploading image' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();                     


           }     

       }

 


    }


    function getCategory(){
        //echo 'yes' ;
        $data = $this->Workout_related_videos_model->getCategory($_POST['empId']);
        //print_r($data);
        echo json_encode($data);
        exit(0);

    } 

    function updateCategory(){

  
         $data =  $_POST;  

          if ($this->validateFormCategory() === TRUE) {

                //print_r($_FILES);
               
               if(!empty($_FILES['image']['tmp_name'])){
                      $image = $this->validateImageCategory() ;
                      $data['module_image'] = $image ;


               } 

               
                  
               unset($data['empId']) ;
               unset($data['action']) ;
               
               $data['workout_video_id'] = 8 ;

               $this->Workout_related_videos_model->updateCategory($_POST['empId'],$data);
               $data['error_message'] = '' ; 
               $data['error'] = 0;
                echo json_encode($data);
                 exit();
            
        }
        else{
            $data['error_message'] = validation_errors() ; 
            $data['error'] = 1;
            
        }    
        echo json_encode($data);
        exit();

 
    } 

 
    function deleteCategories(){
       
       $this->Workout_related_videos_model->deleteCategory($_POST['empId']);
        

    }    
 

    public function CategoryList(){     
 
        
        $search_cond = '';
        $order = '' ; 
        $limit = '' ; 
        if(!empty($_POST["search"]["value"])){
            $search_cond .= ' where (module_name  LIKE "%'.$_POST["search"]["value"].'%" ';
            $search_cond .= ' OR description LIKE "%'.$_POST["search"]["value"].'%" ';  

           
            $search_cond .= ' OR status LIKE "%'.$_POST["search"]["value"].'%") ';         
        }
        //echo $search_cond ; 
        
        if(!empty($_POST["order"])){
            $order = 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        } else {
            $order = 'ORDER BY workout_video_module_id DESC ';
        }
        $sqlQuery_before_limit  = $sqlQuery ; 

        if($_POST["length"] != -1){
            $limit = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
           // $limit = 'LIMIT 0 , 10';
        } else{
            $limit = 'LIMIT 0 , 10';
        }  


        $data['subscriptionsRec'] = $this->Workout_related_videos_model->get_all_records_related_videos_cateogory($search_cond,$order,$limit);
        //print_r($data['subscriptionsRec']);
        
        $videoData = array();    
        foreach($data['subscriptionsRec'] as $key=>$value) {
            
            $empRows = array();         
            $empRows[] = $value->workout_video_module_id;
            //$empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_video_module_id .'" data-column="module_name">'.$value->module_name.'</div>'  ;
            // $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_video_module_id .'" data-column="description">'.$value->description.'</div>'  ;
            $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_video_module_id .'" data-column="module_name">'.$value->module_name.'</div>'  ;
            $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_video_module_id .'" data-column="description">'.$value->description.'</div>'  ;
          
                   
            //$empRows[] =  '<div contenteditable class="update_row" data-id="'.$value->workout_video_module_id.'" data-column="duration">'.$value->module_image.'</div>'  ;  

            $empRows[] =  '<a target="_blank" href="'.base_url().'views/uploads/modules/'.$value->module_image.'"> <img alt="No Image" width="50" src="'.base_url().'views/uploads/modules/'.$value->module_image.'"/></a>';
      
  
            $empRows[] = $value->status;                  
            
 
                  
            $empRows[] = '<button title="Edit" type="button" name="update" id="'.$value->workout_video_module_id.'" class="btn btn-warning btn-xs update"><i class="fa fa-edit"></i></button> &nbsp;&nbsp; <button title="Delete" type="button" name="delete" id="'.$value->workout_video_module_id.'" class="btn btn-danger btn-xs delete" ><i class="fa fa-trash"></i></button>';
        
            $videoData[] = $empRows;
        }

 
       // print_r($videoData); die() ; 

        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      => $this->Workout_related_videos_model->get_all_records_related_videos_count_category(),
            "recordsFiltered"   => $this->Workout_related_videos_model->get_all_records_related_videos_with_condition_category($search_cond),
            "data"              =>  $videoData
        );
        
        echo json_encode($output);  
    }





    private function validateFormCategory() {


 

        $this->form_validation->set_rules('module_name', 'Title ', 'xss_clean|trim|required');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|trim|required');
        $this->form_validation->set_rules('status', 'Video Url', 'xss_clean|trim|required');
 
 
        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


 
 


 











//////////////////////














   function updateIndiviSchedule(){

       $data = array() ; 
       $data[$_POST['column_name']] = $_POST['value'] ; 
       unset($data['action']) ;
       unset($data['empId']) ;
       $this->Workout_related_videos_model->updateSchedule($_POST['empId'],$data);


    } 

                      
    function addSchedule(){

          if ($this->validateFormSchedule() === TRUE) {
               
               if(empty($_FILES['image']['tmp_name'])){
                 
                    $data['error_message'] = 'Select Image' ; 
                    $data['error'] = 1;
                     echo json_encode($data);
                    exit();
               } 

               $image = $this->validateImageSchedule() ;
               $data =  $_POST;      
               unset($data['empId']) ;
               unset($data['action']) ;
               $data['schedule_image'] = $image ;
               $data['workout_video_id'] = 8 ;

               $this->Workout_related_videos_model->saveSchedule($data);
               $data['error_message'] = '' ; 
               $data['error'] = 0;
                echo json_encode($data);
                 exit();
            
        }
        else{
            $data['error_message'] = validation_errors() ; 
            $data['error'] = 1;
            
        }    
        echo json_encode($data);
        exit();
    } 

    public function validateImageSchedule()
    {
 


       if(!empty($_FILES['image']['tmp_name'])){

     
            $image_name= time().'_'.$_FILES['image']['name'] ; 

            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));        

            $allowedExts = array("gif", "jpeg", "jpg", "png","bmp");
            if(!in_array($file_ext, $allowedExts)){

                $data['error_message'] = 'You are allowed to upload gif, jpeg, jpg, png, bmp only' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();           
            }


            $image_info = getimagesize($_FILES["image"]["tmp_name"]);
            $image_width = $image_info[0];
          
            $image_height = $image_info[1];
            if($image_width!=300 or $image_height!=300 ){

                $data['error_message'] = 'Please resize your image to 300x300 and try again' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();                     


            }         
            //echo APPPATH ; 

            $target_dir = APPPATH.'views/uploads/schedules/'.$image_name;

            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)){
                        
               return $image_name ;  
           }else{
                $data['error_message'] = 'Error while uploading image' ; 
                $data['error'] = 1;
                echo json_encode($data);
                exit();                     


           }     

       }

 


    }


    function getSchedule(){
        
        $data = $this->Workout_related_videos_model->getSchedule($_POST['empId']);
        echo json_encode($data);
        exit(0);

    } 

    function updateSchedule(){
  
         $data =  $_POST;  
          if ($this->validateFormSchedule() === TRUE) { 
               
               if(!empty($_FILES['image']['tmp_name'])){
                      $image = $this->validateImageSchedule() ;
                      $data['schedule_image'] = $image ;


               } 

               
                  
               unset($data['empId']) ;
               unset($data['action']) ;
               
                

               $this->Workout_related_videos_model->updateSchedule($_POST['empId'],$data);
               $data['error_message'] = '' ; 
               $data['error'] = 0;
                echo json_encode($data);
                 exit();
            
        }
        else{
            $data['error_message'] = validation_errors() ; 
            $data['error'] = 1;
            
        }    
        echo json_encode($data);
        exit();

 
    } 

 
    function deleteSchedule(){
       
       $this->Workout_related_videos_model->deleteSchedule($_POST['empId']);
        

    }    
 

    public function ScheduleList(){     
 
        
        $search_cond = '';
        $order = '' ; 
        $limit = '' ; 
        if(!empty($_POST["search"]["value"])){
            $search_cond .= ' where (schedule_name  LIKE "%'.$_POST["search"]["value"].'%" ';
            $search_cond .= ' OR description LIKE "%'.$_POST["search"]["value"].'%" ';  

           
            $search_cond .= ' OR status LIKE "%'.$_POST["search"]["value"].'%") ';         
        }
        //echo $search_cond ; 
        
        if(!empty($_POST["order"])){
            $order = 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        } else {
            $order = 'ORDER BY workout_video_schedule_id  DESC ';
        }
        $sqlQuery_before_limit  = $sqlQuery ; 

        if($_POST["length"] != -1){
            $limit = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
           // $limit = 'LIMIT 0 , 10';
        } else{
            $limit = 'LIMIT 0 , 10';
        }  


        $data['subscriptionsRec'] = $this->Workout_related_videos_model->get_all_records_related_videos_schedule($search_cond,$order,$limit);
        //print_r($data['subscriptionsRec']);
        
        $videoData = array();    
        foreach($data['subscriptionsRec'] as $key=>$value) {
            
            $empRows = array();         
            $empRows[] = $value->workout_video_schedule_id;
            $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_video_schedule_id  .'" data-column="schedule_name">'.$value->schedule_name.'</div>'  ;
             $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_video_schedule_id  .'" data-column="description">'.$value->description.'</div>'  ;
          
                   
            //$empRows[] =  '<div contenteditable class="update_row" data-id="'.$value->workout_video_schedule_id .'" data-column="duration">'.$value->schedule_image.'</div>'  ;  

            $empRows[] =  '<a target="_blank" href="'.base_url().'views/uploads/schedules/'.$value->schedule_image.'"> <img alt="No Image" width="50" src="'.base_url().'views/uploads/schedules/'.$value->schedule_image.'"/></a>';
  
            $empRows[] = $value->status;                  
            
 
                  
            $empRows[] = '<button title="Edit" type="button" name="update" id="'.$value->workout_video_schedule_id .'" class="btn btn-warning btn-xs update"><i class="fa fa-edit"></i></button> &nbsp;&nbsp; <button title="Delete" type="button" name="delete" id="'.$value->workout_video_schedule_id .'" class="btn btn-danger btn-xs delete" ><i class="fa fa-trash"></i></button>';
        
            $videoData[] = $empRows;
        }

 
       // print_r($videoData); die() ; 

        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      => $this->Workout_related_videos_model->get_all_records_related_videos_count_schedule(),
            "recordsFiltered"   => $this->Workout_related_videos_model->get_all_records_related_videos_with_condition_schedule($search_cond),
            "data"              =>  $videoData
        );
        
        echo json_encode($output);  
    }





    private function validateFormSchedule() {


 

        $this->form_validation->set_rules('schedule_name', 'schedule_name ', 'xss_clean|trim|required');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|trim|required');
        $this->form_validation->set_rules('status', 'Video Url', 'xss_clean|trim|required');
 
 
        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }















   public function schedules()
    {
        

        $this->template->setTitle('Workout Videos Schedules');
        $this->template->setHeading('Workout Videos Schedules');        
        $this->template->render('workout_related_videos_schedule', $data);
    }


     public function scheduleactionlist(){ 


        if(!empty($_POST['action']) && $_POST['action'] == 'listSchedule') {
            $this->ScheduleList();
            exit() ; 
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'addSchedule') {
             
            $this->addSchedule();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'getSchedule') {
            

            $this->getSchedule();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'updateSchedule') {
            $this->updateSchedule();
        }
        if(!empty($_POST['action']) && $_POST['action'] == 'empSchedule') {
             
            $this->deleteSchedule();
            
        }
       if(!empty($_POST['action']) && $_POST['action'] == 'updateIndiviSchedule') {
            $this->updateIndiviSchedule();
            echo 'here' ; die() ; 
        }

     }   










    
    public function import() 
    {           
            // Allowed mime types
            $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
            
            // Validate whether selected file is a CSV file
           

            if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
            {       
                // If the file is uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name']))
                {
                    
                    // Open uploaded CSV file with read-only mode
                    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                    
                    // Skip the first line
                    fgetcsv($csvFile);
                    
                    // Parse data from CSV file line by line
                    $iCnt = 1;
                    $row  = 1;
                    while(($line = fgetcsv($csvFile)) !== FALSE)
                    {       
                        if(!empty($line) && $line[1] == 'Sno' && $line[1] == 'Title'){
                            $row = $row + 1;
                            continue;
                        }  
                        
                        // Get row data
                        if(!empty($line[1])){
                            $csvData = array();
                            $csvData['workout_video_id']            = isset($line[8])? $this->remove_double_quote($line[8]) : '8';
                            $csvData['image']                       = rand(1,48).'.png';
                            $csvData['title']                       = isset($line[1])? $this->remove_double_quote($line[1]) : '';
                            $csvData['description']                 = isset($line[2])? $this->remove_double_quote($line[2]) : '';
                            $csvData['video_url']                   = isset($line[5])? $this->remove_double_quote($line[5]) : '';
                            $csvData['workout_video_module_id']     = isset($line[9])? $line[9] : '';
                            $csvData['workout_video_schedule_id']   = isset($line[10])? $this->remove_double_quote($line[10]) : '';
                            $csvData['week']                        = isset($line[6])? $this->remove_double_quote($line[6]) : '';
                            $csvData['day']                         = isset($line[7])? $this->remove_double_quote($line[7]) : '';
                            $csvData['sets']                        = isset($line[3])? $this->remove_double_quote($line[3]) : '';
                            $csvData['reps']                        = isset($line[4])? $this->remove_double_quote($line[4]) : '';
                            $csvData['filename']                    = isset($line[11])? $this->remove_double_quote($line[11]) : '';
                            $csvData['duration']                    = isset($line[12])? $this->remove_double_quote($line[12]) : '';
                            $csvData['status']                      = isset($line[13])? $this->remove_double_quote($line[13]) : '1';
                            $csvData['is_paid']                     = isset($line[14])? $this->remove_double_quote($line[14]) : '1';
                            
                            // Insert into related video table                      
                            $csvData['workout_related_video_id']    = $this->Workout_related_videos_model->importRelatedVideoData($csvData);    
                            unset($csvData);            
                            
                            $row = $row + 1;
                        }                       
                    }
                    
                    // Close opened CSV file
                    fclose($csvFile);
                }

                ///echo 'row inserted = '.$row;
                $data['error_message'] ='row inserted = '.$row;
                $data['error'] = 0;
                echo json_encode($data);  
                exit();
            
            }else{

                  $data['error_message'] = 'Please upload CSV file ' ; 
                  $data['error'] = 1;
            
            }
            $data['error_message'] = 'Please upload CSV file ' ; 
            $data['error'] = 1;
            echo json_encode($data);  
   
            
    }





    function remove_double_quote($string){

        return trim($string,'"'); // double quotes

    }







   
}
 ?>