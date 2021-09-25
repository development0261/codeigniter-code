<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

 

class Exercise_library extends Admin_Controller {


    public function __construct() {

        
        parent::__construct();
        $this->load->model(array('Exercise_library_model'));
        $this->user->restrict('Site.Stories');

         
        $this->load->library('pagination');
        $this->load->library('form_validation');

    }   
    
    // Exercise Library categories


    public function index()
    {        
        $this->template->setTitle('Exercise Library');
        $this->template->setHeading('Exercise Library');  

        $data['workoutVvideoModules'] = $this->Exercise_library_model->workoutVvideoModules() ; 
        $data['scheduleList'] = $this->Exercise_library_model->scheduleList() ; 
        $data['moduleList'] = $this->Exercise_library_model->moduleList() ;         

        $this->template->render('exercise_library', $data);
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

        $this->template->setTitle('Exercise Library');
        $this->template->setHeading('Exercise Library');        
        //$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

        if ($this->input->post('delete') and $this->_deleteWorkoutVideos() === true) {
            redirect('subscriptions');
        }

        //load stories data into array
        $data['subscriptionsRec'] = $this->Exercise_library_model->getList($filter);
        
        if ($this->input->get('sort_by') and $this->input->get('order_by')) {
            $url .= '&sort_by=' . $filter['sort_by'] . '&';
            $url .= '&order_by=' . $filter['order_by'] . '&';
        }

        $config['base_url'] = site_url('subscriptions' . $url);
        $config['total_rows'] = $this->Exercise_library_model->getCount($filter);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info' => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links(),
        );

         //echo "<pre>";print_r($data['subscriptionsRec']->result()); die('eeess') ; 


        $this->template->render('exercise_library', $data);
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

     }   


    function updateIndiviVideo(){

       $data = array() ; 
       $data[$_POST['column_name']] = $_POST['value'] ; 
       unset($data['action']) ;
       unset($data['empId']) ;
       $this->Exercise_library_model->updateVideo($_POST['empId'],$data);


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
               $this->Exercise_library_model->saveVideo($data);
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
        $data = $this->Exercise_library_model->getVideo($_POST['empId']);
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



        $this->Exercise_library_model->updateVideo($_POST['empId'],$data);
        $data['error_message'] = '' ; 
        $data['error'] = 0;
        echo json_encode($data);
        exit();
    } 

 
    function deleteVideo(){

       $data =  $_POST;  
       $this->Exercise_library_model->deleteVideo($_POST['empId']);


    }    
 

    public function videoList(){     
 
    

         
        $search_cond = '';
        $order = '' ; 
        $limit = '' ; 
        if(!empty($_POST["search"]["value"])){
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
        }
        $search_cond .= empty($search_cond)? ' WHERE is_paid = 1 ':' AND is_paid = 1 ';  
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

        $data['subscriptionsRec'] = $this->Exercise_library_model->get_all_records_related_videos($search_cond,$order,$limit);
        
        //print_r($data['subscriptionsRec']);
        
        $videoData = array();    
        foreach($data['subscriptionsRec'] as $key=>$value) {
            
            $empRows = array();         
            $empRows[] = $value->workout_related_video_id;
            $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="title">'.$value->title.'</div>'  ;
            //$empRows[] = $value->description

            //$empRows[] = $value->video_url;
            $empRows[] = '<div contenteditable class="update_row" data-id="'.$value->workout_related_video_id.'" data-column="video_url">'.$value->video_url.'</div>'  ;
        
            //$empRows[] = $value->image;
            //$empRows[] =  '<img src="'.base_url().'views/uploads/workoutvideos/'.$value->image.' />';
            $empRows[] =  '<a target="_blank" href="'.base_url().'views/uploads/workoutvideos/'.$value->image.'"> <img alt="No Image" width="50" src="'.base_url().'views/uploads/workoutvideos/'.$value->image.'"/></a>';
            //<img src="img_girl.jpg" alt="Girl in a jacket" width="500" height="600">            
                  
            $empRows[] = '<a href="'.site_url('exercise_library/add_edit?id=' . $value->workout_related_video_id).'"><button title="View" type="button" name="update" id="'.$value->workout_related_video_id.'" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></button></a> &nbsp;&nbsp;';        
            
            $videoData[] = $empRows;
        }
        // echo 'videoData<pre>';
        // print_r($videoData); die() ; 

        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      => $this->Exercise_library_model->get_all_records_related_videos_count(),
            "recordsFiltered"   => $this->Exercise_library_model->get_all_records_related_videos_with_condition($search_cond),
            "data"              =>  $videoData
        );
        
        echo json_encode($output);  
    }


    public function add_edit()
    {     
        $video_id = $this->input->get('id');
        if(empty($video_id)){
            redirect('exercise_library');
        }
        $video_modules   = [];
        $video_schedules = [];
        $storiesid = 0;
        $data['_action'] = site_url('exercise_library/add_edit');        

        $title = (isset($stories_info['title'])) ? $stories_info['title'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf('View video', $title));
        $this->template->setHeading(sprintf('View video', $title));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('exercise_library'), 'title' => 'Back'));
        
        $workoutVvideoModules = $this->Exercise_library_model->workoutVvideoModules() ; 
        $scheduleList = $this->Exercise_library_model->scheduleList() ;
        
        if(!empty($workoutVvideoModules)){
            foreach($workoutVvideoModules as $key=>$value){
                $video_modules[$value->workout_video_module_id] = $value->module_name;
            }
        }
        $data['workoutVvideoModules'] = $video_modules;

        if(!empty($scheduleList)){
            foreach($scheduleList as $key=>$value){
                $video_schedules[$value->workout_video_schedule_id] = $value->schedule_name;
            }
        }
        $data['scheduleList'] = $video_schedules;

        $data['video_detail'] = $this->Exercise_library_model->getVideo($video_id);
        // echo 'AA<pre>';
        // print_r($data['scheduleList']);
        // exit;
        
        $this->template->render('exercise_library_add_edit', $data);
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
        

        $this->template->setTitle('Exercise Library Categories');
        $this->template->setHeading('Exercise Library Categories');        
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
       $this->Exercise_library_model->updateCategory($_POST['empId'],$data);


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

               $this->Exercise_library_model->saveCategory($data);
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
        $data = $this->Exercise_library_model->getCategory($_POST['empId']);
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

               $this->Exercise_library_model->updateCategory($_POST['empId'],$data);
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
       
       $this->Exercise_library_model->deleteCategory($_POST['empId']);
        

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


        $data['subscriptionsRec'] = $this->Exercise_library_model->get_all_records_related_videos_cateogory($search_cond,$order,$limit);
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
            
 
                  
            $empRows[] = '<button title="Edit" type="button" name="update" id="'.$value->workout_video_module_id.'" class="btn btn-warning btn-xs "><i class="fa fa-edit"></i></button> &nbsp;&nbsp; <button title="Delete" type="button" name="delete" id="'.$value->workout_video_module_id.'" class="btn btn-danger btn-xs delete" ><i class="fa fa-trash"></i></button>';
        
            $videoData[] = $empRows;
        }

 
       // print_r($videoData); die() ; 

        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      => $this->Exercise_library_model->get_all_records_related_videos_count_category(),
            "recordsFiltered"   => $this->Exercise_library_model->get_all_records_related_videos_with_condition_category($search_cond),
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
       $this->Exercise_library_model->updateSchedule($_POST['empId'],$data);


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

               $this->Exercise_library_model->saveSchedule($data);
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
        
        $data = $this->Exercise_library_model->getSchedule($_POST['empId']);
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
               
                

               $this->Exercise_library_model->updateSchedule($_POST['empId'],$data);
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
       
       $this->Exercise_library_model->deleteSchedule($_POST['empId']);
        

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


        $data['subscriptionsRec'] = $this->Exercise_library_model->get_all_records_related_videos_schedule($search_cond,$order,$limit);
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
            "recordsTotal"      => $this->Exercise_library_model->get_all_records_related_videos_count_schedule(),
            "recordsFiltered"   => $this->Exercise_library_model->get_all_records_related_videos_with_condition_schedule($search_cond),
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
        

        $this->template->setTitle('Exercise Library Schedules');
        $this->template->setHeading('Exercise Library Schedules');        
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
                            $csvData['workout_video_id']            = isset($line[8])? $line[8] : '8';
                            $csvData['image']                       = rand(1,48).'.png';
                            $csvData['title']                       = isset($line[1])? $line[1] : '';
                            $csvData['description']                 = isset($line[2])? $line[2] : '';
                            $csvData['video_url']                   = isset($line[5])? $line[5] : '';
                            $csvData['workout_video_module_id']     = isset($line[9])? $line[9] : '';
                            $csvData['workout_video_schedule_id']   = isset($line[10])? $line[10] : '';
                            $csvData['week']                        = isset($line[6])? $line[6] : '';
                            $csvData['day']                         = isset($line[7])? $line[7] : '';
                            $csvData['sets']                        = isset($line[3])? $line[3] : '';
                            $csvData['reps']                        = isset($line[4])? $line[4] : '';
                            $csvData['filename']                    = isset($line[11])? $line[11] : '';
                            $csvData['duration']                    = isset($line[12])? $line[12] : '';
                            $csvData['status']                      = isset($line[13])? $line[13] : '1';
                            $csvData['is_paid']                     = isset($line[14])? $line[14] : '1';
                            
                            // Insert into related video table                      
                            $csvData['workout_related_video_id']    = $this->Exercise_library_model->importRelatedVideoData($csvData);    
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












   
}
 ?>