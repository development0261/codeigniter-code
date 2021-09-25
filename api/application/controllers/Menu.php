<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
class menu extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Member','Customers_model','Locations_model','Menus_model'));
        $this->load->library(array('form_validation','Customer','Currency'));
        $this->load->helper('security');
    }

    // Login Section

    public function view_get() {

         if($this->get('search_data')){

          $search_data = $this->get('search_data');            

         }else{

          $search_data = '';  

         }

         $results = $this->Menus_model->getListNew($search_data);

         if($results=='0'){

         $error_data = array('code'  => 401 ,
                             'error' => 'Menu Not Found.');               
         $output = array('message'  => $error_data);
         echo json_encode($output);
            
         }else{
           
           $output = array('result'  => $results, 
                         'message' => 'Location Search');
           echo json_encode($output);

         }
    
    }

  public function category_get() {
    $added_by = $this->get('added_by');
    if (!empty($added_by) && is_numeric($added_by)){
      $categ = $this->Menus_model->getCategoryList($added_by);
      $output = array(
        'status'=>true,
       'result'  => $categ,
        'message' => 'Category List',
      );
      echo json_encode($output);

    }else{
      $error_data = array('code'  => 401 ,'error' => 'Invalid Params.','status'=>false);
      $output = array('message'  => $error_data);
      echo json_encode($output);
    }
  }

  public function add_post(){
    $menu_id = $this->post('menu_id');
    $menu = array();
    $menu['menu_name'] = $this->post('menu_name');
    $menu['menu_description'] = $this->post('menu_description');
    $menu['menu_price'] = $this->post('menu_price');
    $menu['menu_photo'] = $this->post('menu_photo');
    $menu_status = $this->post('menu_status');
    $menu['menu_status'] = isset($menu_status) ? $menu_status : '1';
    $menu['menu_category_id']=$this->post('menu_category_id');
    $menu['location_id'] = $this->post('location_id');
    $menu['is_shake_of_the_month'] = $this->post('is_shake_of_the_month');
    $menu['resturant_owner_comment'] = $this->post('resturant_owner_comment');
    $menu['added_by'] = $this->post('added_by');
    
    $menuItem = $this->Menus_model->addMenu($menu_id,$menu);
    if($menuItem){
      $output = array(
        'result'  => "success",
        'message' => 'Successfully Add to Menu Item',
        'status'=>true
        );
        echo json_encode($output);
    }else{
      $error_data = array('code'  => 401 ,'error' => 'something wrong.');
      $output = array('message'  => $error_data,'status'=>false);
      echo json_encode($output);
    }
  }

  public function delete_post(){
    $menu_id = $this->post('menu_id');
    $menuItem =$this->Menus_model->deleteMenu($menu_id);
    if($menuItem){
      $output = array(
        'result'  => "success",
        'message' => 'Successfully Delete to Menu Item',
        'status'=>true
        );
        echo json_encode($output);
    }else{
      $error_data = array('code'  => 401 ,'error' => 'something wrong.');
      $output = array('message'  => $error_data,'status'=>false);
      echo json_encode($output);
    }
  }

  public function imageUpdate_post() {

		$result = array();
		$image_url = "";
		$result['status']=false;
		if($_FILES){
		  $name = time().'_'.basename( $_FILES["image_upload"]["name"]);
		  $folderPath = '../assets/images/data/';
		  if (!file_exists($folderPath)) {
			mkdir($folderPath,0777);
		  }
		  $target_dir = '../assets/images/data/'.$name;
		  $image_url = 'data/'.$name;
		  if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_dir)) {
			if($image_url){
			  $result['image_url']  = $image_url;
			  $result['status'] = true;
			  $result['message'] = "Image upload successfully";
			}
		  }else {
			$result['message'] = "Sorry, there was an error uploading your file.";
		  }
		}else{
		  $result['message'] = "Sorry, Image Empty";
		}
		$this->response($result);
		exit;
	}
}
 ?>