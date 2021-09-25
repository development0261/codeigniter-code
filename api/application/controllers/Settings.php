<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Rest Controller library Loaded
use Restserver\Libraries\REST_Controller; 
require APPPATH . 'libraries/REST_Controller.php';

class Settings extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Settings_model'));
        //$this->load->library(array('form_validation','Customer'));
        $this->load->helper('security');
    }

    // Login Section

    public function app_settings_post() {

          $response['result']['default_currency'] = $this->Settings_model->getCurrencyCode($this->Settings_model->getCurrencyId());

          $cur = $this->Settings_model->getCurrencyId();

          $this->db->select('currency_symbol');
          $this->db->from('currencies');
          $this->db->where('currency_id',$cur);
          $curr = $this->db->get();
          $curren = $curr->result_array()[0];
          $response['result']['currency_symbol'] = $curren['currency_symbol'];

          $language = $this->Settings_model->getlanguage();

          $response['result']['language'] = $language;          

         $response['result']['conversion_rate'] = number_format($this->get_conversion_rate($response['result']['default_currency'],"USD"),2);
         /*$response['result']['date_format'] = $data[14]['value'];
         $response['result']['time_format'] = $data[15]['value'];*/
         $response['result']['distance_unit'] = $this->Settings_model->getDistanceUnit();
         $response['result']['tax_details'] = $this->Settings_model->getTaxDetails();
         $response['message'] = "Success";
         echo json_encode($response);

    }

    public function banners_post() {

       $response['result'] = $this->Settings_model->getBanners();
       $response['message'] = "Success";
       echo json_encode($response);

    }

    public function get_conversion_rate($from_currency,$to_currency){
        $param = "q=".$from_currency."_".$to_currency."&compact=y";
        $get_data = $this->callAPI('GET', 'http://free.currencyconverterapi.com/api/v5/convert?'.$param, false);
        $response = json_decode($get_data, true);
      //  $errors = $response['response']['errors'];
        $data = $response[$from_currency."_".$to_currency]['val'];
        return $data;
    }

    public function callAPI($method, $url, $data){
       $curl = curl_init();

       switch ($method){
          case "POST":
             curl_setopt($curl, CURLOPT_POST, 1);
             if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
             break;
          case "PUT":
             curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
             if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                              
             break;
          default:
             if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
       }

       // OPTIONS:
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'APIKEY: 111111111111111111111',
          'Content-Type: application/json',
       ));
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

       // EXECUTE:
       $result = curl_exec($curl);
       if(!$result){die("Connection Failure");}
       curl_close($curl);
       return $result;
    }
    public function policy_post() {
       $policies = $this->Settings_model->getpolicies();
       foreach ($policies as $key => $value) {
       if($value['name'] == "Policy")
       {
          $result['policy_content_english'] = $value['content'];
          $result['policy_content_arabic']  = $value['content_arabic'];
       }
       if($value['name'] == "Terms & Condition")
       {
          $result['terms_content_english']  = $value['content'];
          $result['terms_content_arabic']   = $value['content_arabic'];
       }
        if($value['name'] == "About Us")
       {
          $result['about_content_english']  = $value['content'];
          $result['about_content_arabic']   = $value['content_arabic'];
       }
     }
       $response['result'] = $result;
       $response['message'] = "Success";
       echo json_encode($response);

    }

    /*
    * Coupons info get
    */
    public function coupons_get() 
    {
      $emailid                = $this->input->get('emailid');
      $deviceid               = $this->input->get('deviceid');
      $location_id            = $this->input->get('location_id');
      $menu_ids               = $this->input->get('menu_ids');
      $is_all_menus_selected  = $this->input->get('is_all_menus_selected');
      $return_all_codes       = $this->input->get('return_all_codes');

      file_put_contents(dirname(__FILE__)."/../logs/orderinfo_device.txt", 'Datetime= '.date('Y-m-d H:i:s').'Deviceid='.$deviceid.', '.'email='.$emailid.PHP_EOL, FILE_APPEND | LOCK_EX);
      /*
      * Check if coupon is used or not for customer
      */      
      $coupons = array();
      $response['message'] = 'Coupon is already used';
      $used_coupons_except_fd = '';
      /*
      * Check for FD type
      */
      $final_coupons_list = array();
      $used_coupons_fd = $this->Settings_model->check_coupon_used_or_not($emailid, $deviceid, $coupon_type = 'FD');         
      $coupons_fd = $this->Settings_model->getCouponList_fd($used_coupons_fd, $coupon_type = 'FD', $location_id, $return_all_codes); 
      
      if(!empty($coupons_fd)){
            $final_coupons_list = $coupons_fd;                 
      }
      /*
      * Check for code types other than FD
      */      
      $used_coupons_others = $this->Settings_model->check_coupon_used_or_not($emailid, $deviceid, $coupon_type = '');
      $other_coupons_list = array();      
      if(!empty($used_coupons_others))
      {
         $others = explode(',',$used_coupons_others);         
         foreach($others as $value)
         {
            if(!empty($value)){
               $coupons_others = $this->Settings_model->getCouponList_others($used_coupons = $value, $coupon_type = '', $menu_ids);          
               if(!empty($coupons_others))
               {
                  if(intval($coupons_others['is_one_time_discount']) == 0)
                  {
                     if(intval($coupons_others['is_all_menus_discount']) == 0)
                     {
                        $stra = explode(",", $coupons_others['menu_ids']);
                        $strb = explode(",", $menu_ids);
                        $array_diff = array();
   
                        if(count($stra) > count($strb))
                           $array_diff = array_diff($stra,$strb);
                        else if(count($stra) <= count($strb))
                           $array_diff = array_diff($strb,$stra);  
                        // == Allow coupon code
                        if(empty($array_diff))
                        {
                           if(!empty($coupons_others)){
                              if(!empty($final_coupons_list)){
                                 $final_coupons_list = array_merge($final_coupons_list , array($coupons_others));
                              } else {
                                 $final_coupons_list = array($coupons_others);
                              }    
                              $used_coupons_except_fd .= ','.$value;
                           }
                        }
                     } else if(intval($coupons_others['is_all_menus_discount']) == 1)
                     {                      
                        if($is_all_menus_selected == 1)
                        {
                           if(!empty($coupons_others)){
                              if(!empty($final_coupons_list)){
                                 $final_coupons_list = array_merge($final_coupons_list , array($coupons_others));
                              } else {
                                 $final_coupons_list = array($coupons_others);
                              }    
                              $used_coupons_except_fd .= ','.$value;
                           }
                        }
                     }
                  } 
                  else 
                  {         
                     $used_coupons_except_fd .= ','.$value;            
                     // if(!empty($coupons_others)){   
                     //    if(!empty($final_coupons_list)){
                     //       $final_coupons_list = array_merge($final_coupons_list , array($coupons_others));
                     //    } else {
                     //       $final_coupons_list = array($coupons_others);
                     //    }                 
                     //    $used_coupons_except_fd .= ','.$value;
                     // }
                  }
               }
            }
            
         }
      }
      // For F & D coupon which is not used before
      $used_coupons_except_fd = trim($used_coupons_except_fd, ',');
      $coupons_others = $this->Settings_model->getCouponList($used_coupons = $used_coupons_except_fd, $coupon_type = array('F','P'), $menu_ids);    

      if(!empty($coupons_others)){
         if(!empty($final_coupons_list)){
            $final_coupons_list = array_merge($final_coupons_list , $coupons_others);
         } else {
            $final_coupons_list = $coupons_others;
         }
      }
      
      $response['message'] = "Success";
      
      $response['result'] = $final_coupons_list;
      
      echo json_encode($response);
    }

    /*
    * Restaurant coupons API list
    */
    public function restaurantcoupons_get() 
    {
      $location_id = $this->input->get('location_id');
      $coupons = $this->Settings_model->getRestaurantCoupons($location_id);
      if(!empty($coupons)){
         foreach($coupons as $key=>$value){
            // fetch Menu of coupon     
            $menus = $this->Settings_model->getCouponMenus($value['coupon_id'], $value['location_id']);
            $coupons[$key]['menus'] = array();
            if(!empty($menus)){
               $coupons[$key]['menus'] = $menus;
            }
         }

      }
      $response['result'] = $coupons;
      $response['message'] = "Success";
      echo json_encode($response);
    }

    /*
    * Coupon update by restaurant
    */
    public function couponupdate_post()
    {
      $response['result'] = array();
      $response['message'] = "Failed";
      if(!empty($this->post()))
      {
         extract($this->post());
         /*
         * Check  if coupon code exists by coupon code id
         */
        if(!empty($location_id) && !empty($coupon_id) && !empty($name) && !empty($type) && !empty($discount)){
            $check_exists = $this->Settings_model->check_coupon_status($location_id, $coupon_id);
            if($check_exists > 0){
               $this->Settings_model->update_coupon($this->post());
               $response['message'] = "Coupon code updated successfully";
            } else {
               $response['message'] = "No coupon code found";
            }
        } else {
         $response['message'] = "Please enter values";
        }       

      }
      else
      {         
         $response['message'] = "No data found";
      }      
      echo json_encode($response);
    }

    /*
    * Restaurant variant add
    */
    public function restaurantMenuVariantTypeAdd_post()
    {
      $response['result'] = array();
      $response['message'] = "Variant added successfully";
      if(!empty($this->post()))
      {
         extract($this->post());
         /*
         * Check  if coupon code exists by coupon code id
         */
        if(!empty($menu_id) && !empty($variant_type_name) && !empty($location_id)){
            $check_exists = $this->Settings_model->check_menu_exists_or_not($menu_id, $location_id);
            if($check_exists > 0){
               $this->Settings_model->add_menu_variant_type($this->post());
               $response['message'] = "Menu variant added successfully";
            } else {
               $response['message'] = "No menu variant found";
            }
        } else {
         $response['message'] = "Please enter values";
        }       

      }
      else
      {         
         $response['message'] = "No data found";
      }      
      echo json_encode($response);
    }

    /*
    * Restaurant variant type value add by variant id
    */
    public function restaurantMenuVariantTypeValueAdd_post()
    {
      $response['result'] = array();
      $response['message'] = "Variant type value added successfully";
      if(!empty($this->post()))
      {
         extract($this->post());
         /*
         * Check  if coupon code exists by coupon code id
         */
        if(!empty($menu_variant_type_id) && !empty($type_value_name)){
            $check_exists = $this->Settings_model->check_variant_type_exists_or_not($menu_variant_type_id);
            if($check_exists > 0){
               $this->Settings_model->add_menu_variant_type_value($this->post());
               $response['message'] = "Menu variant type added successfully";
            } else {
               $response['message'] = "No menu variant type found";
            }
        } else {
         $response['message'] = "Please enter values";
        }       

      }
      else
      {         
         $response['message'] = "No data found";
      }      
      echo json_encode($response);
    }

   /*
   * Restaurant variant delete
   */
   public function restaurantMenuVariantTypeDelete_delete()
   {
      $menu_variant_type_id  = $this->input->get('menu_variant_type_id');      
      $response['message'] = '';
      /*
      * Delete menu variant
      */
      if(!empty($menu_variant_type_id))
      {
         $count = $this->Settings_model->delete_menu_variant_type($menu_variant_type_id);
         $response['message'] = $count. " variant type deleted";         
      } 
      else 
      {
         $response['message'] = "Please enter values";
      }       

      echo json_encode($response);
   }

   /*
   * Restaurant variant type value
   */
  public function restaurantMenuVariantTypeValueDelete_delete()
  {
     $menu_variant_type_value_id  = $this->input->get('menu_variant_type_value_id');      
     $response['message'] = '';
     /*
     * Delete menu variant
     */
     if(!empty($menu_variant_type_value_id))
     {
        $count = $this->Settings_model->delete_menu_variant_type_value($menu_variant_type_value_id);
        $response['message'] = $count. " variant type value deleted";         
     } 
     else 
     {
        $response['message'] = "Please enter values";
     }       

     echo json_encode($response);
  }

    /*
    * Customer workout video subscription extend
    */
    public function extendsubscription_post()
    {
      $response['result'] = array();
      $response['message'] = "Failed";
      if(!empty($this->post()) && !empty($this->post('email')))
      {
         extract($this->post());
         /*
         * Check  if coupon code exists by coupon code id
         */     
         $this->Settings_model->add_user_confirmation($this->post());
         $response['message'] = "Confirmation data updated successfully";
      }
      else
      {         
         $response['message'] = "No data found";
      }      
      echo json_encode($response);
    }

    /*
    * Restaurant coupons API list
    */
    public function leeprieststripekeys_get() 
    {
      $keys = $this->Settings_model->getleePrieStstripeKeys();      
      $response['result'] = $keys;
      $response['message'] = "Success";
      echo json_encode($response);
    }

    /*
    * Restaurant coupons API list
    */
    public function eatrightpdf_get() 
    {
      $record = $this->Settings_model->getEatrightpdf();  
      $response = [];  
      if(!empty($record)){
         foreach($record as $index=>$value){
            $record[$index]['pdf_image_name'] =  base_url().'admin/views/uploads/trainers/eat_right_pdf/'.$value['pdf_image_name'];
         }  
         $response['result'] = $record;
         $response['message'] = "Success";       
      }  else {
         $response['result'] = [];
         $response['message'] = "Failed";       
      }
      
      echo json_encode($response);
    }

    /*
    * Restaurant home banner
    */
    public function homebanner_get() 
    {
      $banner_id = 1;
      $banners = $this->Settings_model->getHomeBanner($banner_id);
      //echo 'mm='.unserialize($banners['image_code']);      
      if(!empty($banners)){
         $path = unserialize($banners['image_code']);        
         if(!empty($path['path'])){
            $banners['home_banner_image'] = base_url().'assets/images/'.$path['path'];            
         } 
      }
      $response['result'] = $banners;
      $response['message'] = "Success";
      echo json_encode($response);
    }

    /*
    * Check coupon status
    */
    public function validate_coupon_get($location_id = '', $coupon_code = ''){
       $result  = array();
       $message = 'failure';
       $location_id = $this->input->get('location_id');
       $coupon_code = $this->input->get('coupon_code');

       if(!empty($location_id) && !empty($coupon_code)){        
         $result_coupon = $this->Settings_model->validate_coupon($location_id, $coupon_code);
         if(!empty($result_coupon)){
            $result = $result_coupon;
            $message = 'Success';
         }
       } 
       $response['result']  = $result;
       $response['message'] = $message;
       echo json_encode($response);
      
    }

    /*
    * Get customer cards
    */
    public function customer_cards_list_get($customer_email = '', $stripe_card_token = ''){
      $result  = array();
      $message = 'failure';
      $customer_email = $this->input->get('customer_email');
      $stripe_card_token = $this->input->get('stripe_card_token');

      if(!empty($customer_email) || !empty($stripe_card_token)){        
        $records = $this->Settings_model->get_customer_cards($customer_email, $stripe_card_token);
        if(!empty($records)){
           $result = $records;
           $message = 'Success';
        }
      } 
      $response['result']  = $result;
      $response['message'] = $message;
      echo json_encode($response);
     
   }

}
 ?>