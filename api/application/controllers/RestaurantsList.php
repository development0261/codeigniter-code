<?php

if(!defined('BASEPATH')) exit ('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

// require __DIR__.'../../../vendor/autoload.php';
// use Kreait\Firebase\Factory;
// use Kreait\Firebase\ServiceAccount;

/**
 *
 */
class RestaurantsList extends REST_Controller
{

  function __construct()
  {

    error_reporting(0);
    parent::__construct();
    $this->load->model('RestaurantsList_model');
    $this->load->model('Reservations_model');
    // $this->load->model('Statuses_model');
    // $this->load->model('Orders_model');
    $this->load->model('Locations_model');
    $this->load->model('Customers_model');
    $this->load->model('Settings_model');
    $this->load->library('session');
    $this->load->library('stripe_lib');

    set_timezone();


  }

  public function getRestType_post(){

     $restaurant_type = $this->post('restaurant_type');

     if(!$restaurant_type){

            $this->response("No restaurant_id specified", 400);

            exit;
        }

        $result = $this->RestaurantsList_model->getRestType( $restaurant_type);

        if($result){
          $output = array('result'  => $result,
                                'message' => 'success');

            $this->response($output, 200);

            exit;
        }
        else{

             $this->response("Invalid restaturant_id", 404);

            exit;
        }
  }

  public function getPolicy_post(){
    $type = $this->post('type');

    $j=0;
    $result['result'] = array();
    if($type == "all" || $type == "policy"){

      $data = $this->RestaurantsList_model->getPolicy();
      $result['result'][$j]['name'] = $data['name'];
      $result['result'][$j]['titel'] = $data['title'];
      $result['result'][$j]['content'] = $data['content'];
      $j++;
    }

    if($type == "all" || $type == "terms"){
      $data = $this->RestaurantsList_model->getTerms();
      $result['result'][$j]['name'] = $data['name'];
      $result['result'][$j]['titel'] = $data['title'];
      $result['result'][$j]['content'] = $data['content'];
      $j++;
    }

    if($type == "all" || $type == "cancellation"){
      $data = $this->RestaurantsList_model->getCancellation();
      $result['result'][$j]['name'] = $data['name'];
      $result['result'][$j]['titel'] = $data['title'];
      $result['result'][$j]['content'] = $data['content'];
      $j++;
    }

    $this->response($result);

  }
  public function getOrderItems_post(){
    $order_id = $this->post('order_id');
    $order_items = $this->RestaurantsList_model->getOrderItems_new($order_id);
    //print_r($order_items);exit;
    $data =  $order_items;
    foreach($data as $key => $value)
    {

      /*$option_data = unserialize($order_items[$i]['option_values']);
      if(!empty($option_data))
      {

        $j=0;
        foreach ($option_data as $key => $value) {
          $order_itemm[$j] = $value[0];
          $j++;
        }*/
        $order_items[$key]['option_values'] = $this->RestaurantsList_model->getOptionValues($value['order_id'],$value['order_menu_id'],$value['quantity']);
      /* }
      else
      {
        $order_itemm = [];
      } */
        //$order_items[$i]['option_values'] = $order_itemm;
    }

    $result['result'] = array();
    $result['result'] = $order_items;//$this->RestaurantsList_model->getOrderItems($order_id);
    $result['message'] = "Success";
    $this->response($result);
  }
  public function getOrderHistory_post(){
      $result['result'] = array();
      $customer_id = $this->post('customer_id');
      $order_id = $this->post('order_id');
      $reservation_id = $this->post('reservation_id');
      $status = $this->post('status');

      if(!$customer_id){
            $result['message'] = "Failed";
            $this->response($result);
            exit;
      }

    $orders = $this->RestaurantsList_model->getOrderHistory($customer_id,$status,$this->post('page'),$order_id,$reservation_id);

    if(empty($orders)){
      $result['message'] = "Orders not available";
      $this->response($result);
      exit;
    }
    $result['result'] = array();
    $result['count'] = count($orders);

    if($orders){
        $j=0;
        foreach ($orders as $key => $value) {

          if($value['reservation_id']!=''){

            $result['result'][$j] = $this->RestaurantsList_model->getReservationDetails($value['reservation_id']);
          } else {
            $result['result'][$j] = $this->RestaurantsList_model->getReservationOrderDetails($value['order_id']);
          }
          //$result['result'][$j]['date'] = date('d M, Y', strtotime($value['date_added']));
          //$result['result'][$j]['status'] = $value['status_name'];
          $j++;
        }
        $result['message'] = "Success";
        $this->response($result);
    }
  }

  public function getReview_post(){

    $location_id = $this->post('location_id');

    if(!$location_id){

          $this->response("No review specified", 400);

          exit;
      }

      $result = $this->RestaurantsList_model->getReview ( $location_id);

      if($result){
        $output = array('result'  => $result,
                              'message' => 'success');

          $this->response($output, 200);

          exit;
      }
      else{

            $this->response("Invalid restaturant_id", 404);

          exit;
      }
  }

  public function checkTableTime_post(){

    $location_id = $this->post('location_id');
    $date = $this->post('date');
    $time = $this->post('time');
    $guest = $this->post('guest');

    $opening_time = $this->Locations_model->getOpeningHourByDay($location_id, $date);
    //echo strtotime($time).'<br>',strtotime($opening_time['open']);exit;
    $select_time = strtotime($date.' '.$time);
    $open_time   = strtotime($date.' '.$opening_time['open']);
    $close_time   = strtotime($date.' '.$opening_time['close']);

    if($select_time >= $open_time && $select_time <= $close_time)
    {
      /*$check_time = $this->RestaurantsList_model->checkTime($location_id,$date,$time);
      $result = array();

      if($check_time){

        $result['message'] = "Table not available at this time please choose another table";
      }else{

        $result['message'] = "Table available";
      }*/

      $available_table_id = $this->Reservations_model->checkReservationTable($guest,$location_id,$date,$time);

      if(empty($available_table_id)){
          $result['message'] = "Tables not available now";
          $this->response($result);
          exit;
      }

      $max_capacity = 5;

      if($max_capacity < $guest){
          $total_tables = ceil($guest / $max_capacity);
      }else{
          $total_tables = 1;
      }

      if(count($available_table_id) < $total_tables){
          $result['message'] = "Tables not available now";
          $result['openinghours'] = $opening_time;
          $this->response($result);
          exit;
      }else{
          $result['message'] = "Tables available";
          $result['openinghours'] = $opening_time;
          $this->response($result);
          exit;
      }
    }
    else
    {
      $result['openinghours'] = $opening_time;
      $result['message'] = "Time must be between restaurant opening time";
      $this->response($result);
      exit;
    }



  }

  public function feedback_post(){

    $user_id = $this->post('user_id');
    $location_id = $this->post('location_id');
    $feedback_type = $this->post('type');
    $feedback_message = $this->post('message');

    $check_row = $this->RestaurantsList_model->getFeedback();

    if($check_row == ""){
      $result['message'] = "Feedback api not configure";
      $this->response($result);
    }else if($check_row['status'] == 0){
      $result['message'] = "Feedback api not configure";
      $this->response($result);
    }

    $check_row = unserialize($check_row['data']);
    if($check_row['status'] != 1){
      $result['message'] = "Feedback api disabled";
      $this->response($result);
    }

    if($this->RestaurantsList_model->insertFeedback($user_id,$location_id,$feedback_type,$feedback_message)){
      $result['message'] = "Successfully added";
    }else{
      $result['message'] = "Failed";
    }

    $this->response($result);

  }

  /*public function getRestList_post(){

      // $restaurant_type = $this->post('restaurant_type');
      $c_lat = $this->post('location_lat');
      $c_lng = $this->post('location_lng');

      $result = $this->distance($location_lat,$location_lng,$c_lat,$c_lng,'km');
        if($result){
          $output = array('result'  => $result,
                            'message' => 'restaurant_type');

             echo json_encode($output);


        }
        else{

             $this->response("Invalid restaturant_id", 404);

            exit;
        }
  }*/


  function distance($d_lat, $d_lon, $c_lat, $c_lon, $unit) {
      $theta = $d_lon - $c_lon;
      $dist = (sin(deg2rad($d_lat)) * sin(deg2rad($c_lat))) +  (cos(deg2rad($d_lat)) * cos(deg2rad($c_lat))) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;

      if ($unit == "K") {
        return ($miles * 1.609344);
      } else {
        return $miles;
      }
  }

  function array_sort_by_column(&$arr, $col, $dir) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
  }

    public function getTableTime_post(){
      $guest = $this->post('guest');
      $location_id = $this->post('location_id');
      $total_tables = $this->post('total_tables');
      $date = $this->post('date');
      $time = date("H:i:s", strtotime($this->post('time')));
      $inter_time = $this->Reservations_model->GetTable('settings','item = "reservation_time_interval"');
      $sta_time = $this->Reservations_model->GetTable('settings','item = "reservation_stay_time"');
      $time_interval = $inter_time;
      $stay_time     = $sta_time;

      $opening_time = $this->Locations_model->getOpeningHourByDay($location_id, $date);
      //echo strtotime($time).'<br>',strtotime($opening_time['open']);exit;
      $select_time = strtotime($date.' '.$time);
      $open_time   = strtotime($date.' '.$opening_time['open']);
      $close_time   = strtotime($date.' '.$opening_time['close']);

      if($select_time >= $open_time && $select_time <= $close_time)
      {
        $pay_location = $this->Reservations_model->getLocationDetails($location_id);
        if($pay_location['reservation_time_interval'])
        {
          $time_interval = $pay_location['reservation_time_interval'];
        }
        if($pay_location['reservation_stay_time'])
        {
          $stay_time = $pay_location['reservation_stay_time'];
        }

        $start_time = date("H:i:s", strtotime($time)-(60*$time_interval));
        $end_time = date("H:i:s", strtotime($time)+(60*$time_interval));


        $current_time = $start_time;
        $result['times'] = array();
        $j=0;
        $k=0;
        while($current_time <= $end_time){

           $find = $this->RestaurantsList_model->findReservedLocation($date,$current_time,$location_id);

           if($find != ""){
              $result['times'][$k] = "NA";
           }else{
              if((strtotime($date.' '.$current_time) > now()) && (strtotime($date.' '.$current_time) >= $open_time) && (strtotime($date.' '.$current_time) <= $close_time) )
              {
                $result['times'][$k] = date("h:i A", strtotime($current_time));
                $k++;
              }
              /*else
              {
                $result['times'][$j] = "NA";
              }*/
             }
             $current_time = date("H:i:s", strtotime($current_time)+(60*$stay_time));
            $j++;

        }
        $result['openinghours'] = $opening_time;
        $result['message'] = "Success";
      }
      else
      {
        $result['times'] = array();
        $result['openinghours'] = $opening_time;
        $result['message'] = "Time must be between restaurant opening time";
      }

      $this->response($result);
    }

    public function favorite_post(){
      $customer_id = $this->post('customer_id');
      $location_id = $this->post('location_id');
      $favorite = $this->post('favorite');
      $list = $this->RestaurantsList_model->updateFavorite($customer_id,$location_id,$favorite);
      if($list){
         $result['message'] = "Success";
       }else {
         $result['message'] = "Failure";
       }
       $this->response($result);
    }

    public function locationchk_post(){
      $c_lat = $this->post('c_lat');
      $c_lng = $this->post('c_lng');

      $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($c_lat).','.trim($c_lng).'&sensor=false&key=AIzaSyB6NyQyaaPmX2WmcDOs-oJ1i2oI45tE6HA';
      $json = @file_get_contents($url);
      $data=json_decode($json);

      $var = $data->results[0]->address_components;

      if(!is_object($var)){
        foreach($var as $key => $value) {
          if($value->types[0]=='country'){
           $country_name = $value->long_name;
           }
        }
      }
    }

    public function getNearByRestaurants_post(){

       log_message('debug','\n Post Data :'.json_encode($this->post()).' \n\n');

       $location_type = $this->post('location_type');
       $keyword_lang = $this->post('language');
       $food_type = $this->post('food_type');
       $favorite = $this->post('favorite');
       $customer_id = $this->post('customer_id');

        if($this->post('c_lat')){
            $c_lat = $this->post('c_lat');
            $c_lng = $this->post('c_lng');

            log_message('debug','\n c_lat :'.$c_lat.' c_lng : '.$c_lng.'\n\n');

           $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($c_lat).','.trim($c_lng).'&sensor=false&key='.$this->Settings_model->getMapKey();

            $json = @file_get_contents($url);
            $data=json_decode($json);
            $var = $data->results[0]->address_components;

            log_message('debug','\n address_components : '.json_encode($var).' \n\n');

            if(!is_object($var)){
            foreach($var as $key => $value) {
              if($value->types[0]=='country'){
                $country_name = $value->long_name;
              }
            }
           } else {
            $country_name = 'India';
           }
         }else{
             $c_lat = '9.9208308';
             $c_lng = '78.0926804';
         }

         if($this->post('rating')){
             $rating = $this->post('rating');
         }else{
            $rating = 0;
         }

         if($this->post('price')){
             $price = $this->post('price');
         }else{
            $price = "";
         }

         if($this->post('distance')){
             $distance_param = $this->post('distance');
         }else{
            $distance_param = "";
         }



       $page = $this->post('page');

       if($this->post('next_offset')){
         $next_offset = $this->post('next_offset') + 10;
       } else {
        $next_offset = 0;
       }
       //$page = $page + 1;

       if($this->post('keyword')){
            $keyword = $this->post('keyword');
         }else{
            $keyword = "";
         }

       $list = $this->RestaurantsList_model->getRestType($location_type,$page,$keyword,$keyword_lang,$c_lat,$c_lng,$distance_param,$rating,$next_offset,$food_type,$favorite,$customer_id,$country_name);
         $data = array();
         $page_count = 0;
         $j=0;
         foreach($list as $key => $item)
         {
            $distance = round($this->distance($item['location_lat'],$item['location_lng'],$c_lat,$c_lng,'km'),1);

            // $overall_quality = round($this->RestaurantsList_model->getQualityRating($item['location_id']),2);
            // $overall_service = round($this->RestaurantsList_model->getServiceRating($item['location_id']),2);
            // $overall = round(($overall_quality + $overall_service) / 2,1);


            // if($overall >= 0 && $overall <= $rating){
            $minimum_price = $this->RestaurantsList_model->getminimumprice($item['location_id']);


            $item['location_id'] = $item['locationid'];
            if(isset($customer_id) && $customer_id!='0'){

              $dem =  array('customer_id' => $customer_id,
                'restaurant_id' => $item['location_id']
               );

              $fav = $this->Customers_model->GetTableFav('favorites',$dem);

              if(!empty($fav) && $fav!='0' && $fav!=''){
                $data[$j]['favorite'] = $fav['rating'];
              } else {
                $data[$j]['favorite'] = '0';
              }

            } else {
              $data[$j]['favorite'] = '0';
            }

            //Check opening time
             if($item['open_close_status'] == 1)
            {
              $date_time = date("Y-m-d H:i:s");

              $opening_time = $this->Locations_model->getOpeningHourByDay($item['location_id'], date("Y-m-d"));
              //echo strtotime($time).'<br>',strtotime($opening_time['open']);exit;

              $select_time = strtotime($date_time);
              $open_time   = strtotime(date("Y-m-d").' '.$opening_time['open']);
              $close_time   = strtotime(date("Y-m-d").' '.$opening_time['close']);
              if($select_time < $open_time || $select_time > $close_time)
              {
                $item['open_close_status'] = 0;
              }
            }


            $data[$j]['location_id'] = $item['location_id'];
            $data[$j]['location_name'] = $item['location_name'];
            $data[$j]['location_name_ar'] = $item['location_name_ar'];
            $data[$j]['location_email'] = $item['location_email'];
            $data[$j]['location_type'] = $location_type;
            $data[$j]['description'] = $item['description'];
            $data[$j]['description_ar'] = $item['description_ar'];
            $data[$j]['location_address_1'] = $item['location_address_1'];
            $data[$j]['location_address_1_ar'] = $item['location_address_1_ar'];
            $data[$j]['location_address_2'] = $item['location_address_2'];
            $data[$j]['location_address_2_ar'] = $item['location_address_2_ar'];
            $data[$j]['location_city'] = $item['location_city'];
            $data[$j]['location_city_ar'] = $item['location_city_ar'];
            $data[$j]['location_state'] = $item['location_state'];
            $data[$j]['location_state_ar'] = $item['location_state_ar'];
            $data[$j]['location_postcode'] = $item['location_postcode'];
            $data[$j]['location_country'] = $item['country_name'];
            $data[$j]['location_telephone'] = $item['location_telephone'];
            $data[$j]['location_lat'] = $item['location_lat'];
            $data[$j]['location_lng'] = $item['location_lng'];
            $data[$j]['location_ratings'] = $item['location_ratings'];

            $data[$j]['open_status'] = $item['open_close_status'];

            $image = '../assets/images/'.$item['location_image'];

            if(file_exists($image)){
              $imag = $item['location_image'];
            } else {
              $imag = 'data/no_img2.png';
            }

            $data[$j]['profile_image']= $imag;

            $data[$j]['offer_delivery']= $item['offer_delivery'];
            $data[$j]['delivery_time']= $item['delivery_time'];
            $data[$j]['delivery_boy_commission']= $item['delivery_boy_commission'];
            $data[$j]['delivery_fee'] = $item['delivery_fee'];
            $data[$j]['offer_collection']= $item['offer_collection'];

            //$data[$j]['distance'] = "$distance";
            $data[$j]['distance'] =  number_format($item['distance'],2, '.', '');
            $data[$j]['veg_type'] =  $item['veg_type'];

            if($item['location_status'] == 1)
            {
                $data[$j]['location_status'] = "Active";
            }else{
                $data[$j]['location_status'] = "In-Active";
            }
            $data[$j]['rewards_value'] = $item['rewards_value'];
            $data[$j]['reward_status'] = $item['reward_status'];
            $data[$j]['point_value'] = $item['point_value'];
            $data[$j]['point_price'] = $item['point_price'];
            $data[$j]['minimum_price'] = (int) $minimum_price;
            $data[$j]['rewards_method'] = $item['rewards_method'];
            $data[$j]['maximum_amount'] = $item['maximum_amount'];
            if($item['first_table_price'] != ""){
                $data[$j]['first_table_price'] = $item['first_table_price'];
            }else{
                $data[$j]['first_table_price'] = 0;
            }

            $data[$j]['additional_table_price'] = $item['additional_table_price'];
            $data[$j]['categories'] = $this->RestaurantsList_model->getCategories(NULL,"",$item['location_id']);
            $gallery = unserialize($item['options']);

            if(@$gallery['gallery']['images'] != ""){
                $i=0;
                foreach ($gallery['gallery']['images'] as $as => $value) {
                    if($i == 0)
                    {
                      $data[$j]['gallery'][$i]["path"] = $imag;
                      $data[$j]['gallery'][$i]["name"] = "";
                      $data[$j]['gallery'][$i]["alt_text"] = "";
                      $data[$j]['gallery'][$i]["status"] = "";
                    }
                    else
                    {
                      $data[$j]['gallery'][$i] = $value;
                    }
                    $i++;
                }
            }else{
               $data[$j]['gallery'] = array();
            }

            //Multi Tax options

            $taxes = [];
            $all_tax = 0;
            $tax_types = json_decode($item['tax_type']);
            $tax_perc  = json_decode($item['tax_perc']);
            $tax_status  = json_decode($item['tax_status']);
            for ($t=0;$t<count($tax_types);$t++)
            {
              if($tax_status[$t] == 1)
              {
               $all_tax += $tax_perc[$t];
               $taxes[$t]['tax_name']  = $tax_types[$t];
               $taxes[$t]['tax_value'] = $tax_perc[$t];
              }
            }

            $data[$j]['taxes'] = $taxes;
            $data[$j]['overall_tax'] = $all_tax;

            $ratings = $this->RestaurantsList_model->getReviews($item['location_id']);
            if($ratings == ""){
                $data[$j]['ratings'] = array();
            }else{
                $data[$j]['ratings'] = $ratings;
            }
            $data[$j]['tables'] = $this->RestaurantsList_model->getTables($item['location_id']);
            $data[$j]['payment_details'] = $this->RestaurantsList_model->getPaymentDetails($item['location_id']);
            /*$o_q = round($overall_quality,1);
            $o_s = round($overall_service,1);
            $data[$j]['overall_quality_ratings'] = "$o_q";
            $data[$j]['overall_service_ratings'] = "$o_s";
            $data[$j]['overall_ratings'] = "$overall";*/
            $page_count++;
            $j++;
            //$data['options'] =  unserialize($item['options']);
            }

        //}
        /*if($distance_param == "longest"){
          $this->array_sort_by_column($data, 'distance', SORT_DESC); // order by distance
        }
        else
        {
          $this->array_sort_by_column($data, 'distance', SORT_ASC); // order by distance
        }*/
        if($price == "high"){
          $this->array_sort_by_column($data, 'first_table_price', SORT_DESC);
        }
        if($price == "low"){
          $this->array_sort_by_column($data, 'first_table_price', SORT_ASC);
        }

        $pages = $page + 10;
        $next_offset = $next_offset + 10;
       $list = $this->RestaurantsList_model->getRestTypeCount($location_type,$pages,$keyword,$keyword_lang,$c_lat,$c_lng,$distance_param,$rating,$next_offset,$food_type,$favorite,$customer_id,$country_name);

         $response['result'] = $data;

        if($list!=0){
          $response['next_offset'] = $pages;
        } else {
          $response['next_offset'] = 0;
        }
         //$response['overall_count'] = $this->RestaurantsList_model->getOverallCount($location_type,$c_lat,$c_lng,$rating);
         $response['page_count'] = $page_count;
         $response['current_page_no'] = $page;
         $response['message'] = "Success";
         $this->response($response);
        // print_r($data);exit;
       if($rest_type){
      /*foreach($rest_type as  $row)
      {
        $location_id = $row['location_id'];
        $location_id = $this->RestaurantsList_model->getReview($location_id);

        $review = $location_id;
        $option = $row['options'];
        $var1 = unserialize($option);
        $image =$var1['gallery'];
                if($images['images']){
                    $gallery =$image['images'];
                }else{
                    $gallery = array();
                }


        $count =count($gallery);

          for ($i=1; $i <= $count; $i++) {
            $images[] =$gallery["$i"];
          }


        $location_lat = $row['location_lat'];
        $location_lng = $row['location_lng'];
        $distance = $this->distance($location_lat,$location_lng,$c_lat,$c_lng,'km');

          if($distance < 15){

        $restaurant_list[] = array(
          'id' => $row['location_id'],
          'title' => $row['location_name'],
          'first_table_price' => $row['first_table_price'],
          'additional_table_price' => $row['additional_table_price'],
          'description' => $row['description'],
          'location_lat' => $row['location_lat'],
          'location_lng' => $row['location_lng'],
          'distance' => $distance,
          'review' => $review,
          'image' =>$images);

          $output = array('result'  => $restaurant_list,
                         'message' => 'success');


       }


    }
     $this->response($output);    */
  }
  else{

             $this->response("Restaurant Not Found", 404);

            exit;
        }

    }


  public function getNearByRestaurantsFranchisee_post(){

    $location_type = $this->post('location_type');
    $keyword_lang = $this->post('language');
    $food_type = $this->post('food_type');
    $favorite = $this->post('favorite');
    $customer_id = $this->post('customer_id');
    $added_by = $this->post('franchisee_id');

    if($this->post('c_lat')){
      $c_lat = $this->post('c_lat');
      $c_lng = $this->post('c_lng');
      $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($c_lat).','.trim($c_lng).'&sensor=false&key='.$this->Settings_model->getMapKey();

      $json = @file_get_contents($url);
      $data=json_decode($json);
      $var = $data->results[0]->address_components;
      if(!is_object($var)){
        foreach($var as $key => $value) {
          if($value->types[0]=='country'){
            $country_name = $value->long_name;
          }
        }
      } else {
        $country_name = 'India';
      }
    }else{
        $c_lat = '9.9208308';
        $c_lng = '78.0926804';
    }

    if($this->post('rating')){
        $rating = $this->post('rating');
    }else{
        $rating = 0;
    }

    if($this->post('price')){
        $price = $this->post('price');
    }else{
        $price = "";
    }

    if($this->post('distance')){
        $distance_param = $this->post('distance');
    }else{
        $distance_param = "";
    }
    $page = $this->post('page');
    if($this->post('next_offset')){
      $next_offset = $this->post('next_offset') + 10;
    } else {
      $next_offset = 0;
    }
      //$page = $page + 1;

    if($this->post('keyword')){
          $keyword = $this->post('keyword');
    }else{
        $keyword = "";
    }

    $list = $this->RestaurantsList_model->getRestTypeFranchisee($location_type,$page,$keyword,$keyword_lang,$c_lat,$c_lng,$distance_param,$rating,$next_offset,$food_type,$favorite,$customer_id,$country_name,$added_by);
    $data = array();
    $page_count = 0;
    $j=0;

    foreach($list as $key => $item){
      /*
      * Check holiday and opening hours
      */
      $restaurant_options = !empty($item['options'])? unserialize($item['options']) : array();
      /*
      * Check holiday's
      */
      $is_holiday = 0;
      if(!empty($restaurant_options['opening_hours']['holidays_list'])){
        foreach($restaurant_options['opening_hours']['holidays_list'] as $key_option=>$value_option){
          if($value_option['date'] == date('Y-m-d')){
            $is_holiday = 1;
          }
        }
      }
      /*
      * Check opening hours
      */
      $is_opentime_not_reached  = 0;
      $is_closetime_passed      = 0;
      if($is_holiday == 0){
        if(!empty($restaurant_options['opening_hours']['flexible_hours'])){
          $day_of_week = date('w', strtotime(date('Y-m-d')));
          $day_of_week = $day_of_week == 0 ? 7 : $day_of_week;
          foreach($restaurant_options['opening_hours']['flexible_hours'] as $key_option=>$value_option){
            if($value_option['day'] == ($day_of_week - 1)){
              $open_time    = strtotime($value_option['open']);//date("H:i", strtotime($value_option['open']));
              $close_time   = strtotime($value_option['close']);//date("H:i", strtotime($value_option['close']));
              $current_time = strtotime(date('H:i'));//date("H:i", strtotime(date('Y-m-d H:i')));
              if($current_time < $open_time){
                $is_opentime_not_reached = 1;
              } else if($current_time > $close_time){
                $is_closetime_passed = 1;
              }
            }
          }
        }
      }

      $distance = round($this->distance($item['location_lat'],$item['location_lng'],$c_lat,$c_lng,'km'),1);

      // $overall_quality = round($this->RestaurantsList_model->getQualityRating($item['location_id']),2);
      // $overall_service = round($this->RestaurantsList_model->getServiceRating($item['location_id']),2);
      // $overall = round(($overall_quality + $overall_service) / 2,1);


      // if($overall >= 0 && $overall <= $rating){
      $minimum_price = $this->RestaurantsList_model->getminimumprice($item['location_id']);
      $item['location_id'] = $item['locationid'];
      if(isset($customer_id) && $customer_id!='0'){

        $dem =  array('customer_id' => $customer_id,
          'restaurant_id' => $item['location_id']
        );

        $fav = $this->Customers_model->GetTableFav('favorites',$dem);

        if(!empty($fav) && $fav!='0' && $fav!=''){
          $data[$j]['favorite'] = $fav['rating'];
        } else {
          $data[$j]['favorite'] = '0';
        }
      } else {
        $data[$j]['favorite'] = '0';
      }

      //Check opening time
      if($item['open_close_status'] == 1){
        $date_time = date("Y-m-d H:i:s");

        $opening_time = $this->Locations_model->getOpeningHourByDay($item['location_id'], date("Y-m-d"));
        //echo strtotime($time).'<br>',strtotime($opening_time['open']);exit;

        $select_time = strtotime($date_time);
        $open_time   = strtotime(date("Y-m-d").' '.$opening_time['open']);
        $close_time   = strtotime(date("Y-m-d").' '.$opening_time['close']);
        if($select_time < $open_time || $select_time > $close_time){
          $item['open_close_status'] = 0;
        }
      }

      $data[$j]['location_id'] = $item['location_id'];

      $data[$j]['is_holiday']              = $is_holiday;
      $data[$j]['is_opentime_not_reached'] = $is_opentime_not_reached;
      $data[$j]['is_closetime_passed']     = $is_closetime_passed;

      $data[$j]['location_name'] = $item['location_name'];
      $data[$j]['location_name_ar'] = $item['location_name_ar'];
      $data[$j]['location_email'] = $item['location_email'];
      $data[$j]['location_type'] = $location_type;
      $data[$j]['description'] = $item['description'];
      $data[$j]['description_ar'] = $item['description_ar'];
      $data[$j]['location_address_1'] = $item['location_address_1'];
      $data[$j]['location_address_1_ar'] = $item['location_address_1_ar'];
      $data[$j]['location_address_2'] = $item['location_address_2'];
      $data[$j]['location_address_2_ar'] = $item['location_address_2_ar'];
      $data[$j]['location_city'] = $item['location_city'];
      $data[$j]['location_city_ar'] = $item['location_city_ar'];
      $data[$j]['location_state'] = $item['location_state'];
      $data[$j]['location_state_ar'] = $item['location_state_ar'];
      $data[$j]['location_postcode'] = $item['location_postcode'];
      $data[$j]['location_country'] = $item['country_name'];
      $data[$j]['location_telephone'] = $item['location_telephone'];
      $data[$j]['location_lat'] = $item['location_lat'];
      $data[$j]['location_lng'] = $item['location_lng'];
      $data[$j]['location_ratings'] = $item['location_ratings'];
      $data[$j]['open_status'] = $item['open_close_status'];

      $image = '../assets/images/'.$item['location_image'];

      if(file_exists($image)){
        $imag = $item['location_image'];
      } else {
        $imag = 'data/no_img2.png';
      }

      $data[$j]['profile_image']= $imag;
      $data[$j]['offer_delivery']= $item['offer_delivery'];
      $data[$j]['delivery_time']= $item['delivery_time'];
      $data[$j]['delivery_boy_commission']= $item['delivery_boy_commission'];
      $data[$j]['delivery_fee'] = $item['delivery_fee'];
      $data[$j]['offer_collection']= $item['offer_collection'];
      //$data[$j]['distance'] = "$distance";
      $data[$j]['distance'] =  number_format($item['distance'],2, '.', '');
      $data[$j]['veg_type'] =  $item['veg_type'];

      if($item['location_status'] == 1)
      {
          $data[$j]['location_status'] = "Active";
      }else{
          $data[$j]['location_status'] = "In-Active";
      }
      $data[$j]['rewards_value'] = $item['rewards_value'];
      $data[$j]['reward_status'] = $item['reward_status'];
      $data[$j]['point_value'] = $item['point_value'];
      $data[$j]['point_price'] = $item['point_price'];
      $data[$j]['minimum_price'] = (int) $minimum_price;
      $data[$j]['rewards_method'] = $item['rewards_method'];
      $data[$j]['maximum_amount'] = $item['maximum_amount'];
      if($item['first_table_price'] != ""){
          $data[$j]['first_table_price'] = $item['first_table_price'];
      }else{
          $data[$j]['first_table_price'] = 0;
      }

      $data[$j]['additional_table_price'] = $item['additional_table_price'];
      $data[$j]['categories'] = $this->RestaurantsList_model->getCategories(NULL,"",$item['location_id']);
      $gallery = unserialize($item['options']);

      if(@$gallery['gallery']['images'] != ""){
          $i=0;
          foreach ($gallery['gallery']['images'] as $as => $value) {
              if($i == 0)
              {
                $data[$j]['gallery'][$i]["path"] = $imag;
                $data[$j]['gallery'][$i]["name"] = "";
                $data[$j]['gallery'][$i]["alt_text"] = "";
                $data[$j]['gallery'][$i]["status"] = "";
              }
              else
              {
                $data[$j]['gallery'][$i] = $value;
              }
              $i++;
          }
      }else{
        $data[$j]['gallery'] = array();
      }

      //Multi Tax options

      $taxes = [];
      $all_tax = 0;
      $tax_types = json_decode($item['tax_type']);
      $tax_perc  = json_decode($item['tax_perc']);
      $tax_status  = json_decode($item['tax_status']);
      for ($t=0;$t<count($tax_types);$t++)
      {
        if($tax_status[$t] == 1)
        {
        $all_tax += $tax_perc[$t];
        $taxes[$t]['tax_name']  = $tax_types[$t];
        $taxes[$t]['tax_value'] = $tax_perc[$t];
        }
      }

      $data[$j]['taxes'] = $taxes;
      $data[$j]['overall_tax'] = $all_tax;

      $ratings = $this->RestaurantsList_model->getReviews($item['location_id']);
      if($ratings == ""){
          $data[$j]['ratings'] = array();
      }else{
          $data[$j]['ratings'] = $ratings;
      }
      $data[$j]['tables'] = $this->RestaurantsList_model->getTables($item['location_id']);
      $data[$j]['payment_details'] = $this->RestaurantsList_model->getPaymentDetails($item['location_id']);
      /*$o_q = round($overall_quality,1);
      $o_s = round($overall_service,1);
      $data[$j]['overall_quality_ratings'] = "$o_q";
      $data[$j]['overall_service_ratings'] = "$o_s";
      $data[$j]['overall_ratings'] = "$overall";*/
      $page_count++;
      $j++;
      //$data['options'] =  unserialize($item['options']);
      }

      //}
      /*if($distance_param == "longest"){
        $this->array_sort_by_column($data, 'distance', SORT_DESC); // order by distance
      }
      else
      {
        $this->array_sort_by_column($data, 'distance', SORT_ASC); // order by distance
      }*/
      if($price == "high"){
        $this->array_sort_by_column($data, 'first_table_price', SORT_DESC);
      }
      if($price == "low"){
        $this->array_sort_by_column($data, 'first_table_price', SORT_ASC);
      }

      $pages = $page + 10;
      $next_offset = $next_offset + 10;
      $list = $this->RestaurantsList_model->getRestTypeCount($location_type,$pages,$keyword,$keyword_lang,$c_lat,$c_lng,$distance_param,$rating,$next_offset,$food_type,$favorite,$customer_id,$country_name);

      $response['result'] = $data;

      if($list!=0){
        $response['next_offset'] = $pages;
      } else {
        $response['next_offset'] = 0;
      }
      //$response['overall_count'] = $this->RestaurantsList_model->getOverallCount($location_type,$c_lat,$c_lng,$rating);
      $response['page_count'] = $page_count;
      $response['current_page_no'] = $page;
      $response['message'] = "Success";
      $this->response($response);
      // print_r($data);exit;
      if($rest_type){
        /*foreach($rest_type as  $row){
          $location_id = $row['location_id'];
          $location_id = $this->RestaurantsList_model->getReview($location_id);

          $review = $location_id;
          $option = $row['options'];
          $var1 = unserialize($option);
          $image =$var1['gallery'];
          if($images['images']){
              $gallery =$image['images'];
          }else{
              $gallery = array();
          }
          $count =count($gallery);
          for ($i=1; $i <= $count; $i++) {
            $images[] =$gallery["$i"];
          }

          $location_lat = $row['location_lat'];
          $location_lng = $row['location_lng'];
          $distance = $this->distance($location_lat,$location_lng,$c_lat,$c_lng,'km');

          if($distance < 15){

          $restaurant_list[] = array(
          'id' => $row['location_id'],
          'title' => $row['location_name'],
          'first_table_price' => $row['first_table_price'],
          'additional_table_price' => $row['additional_table_price'],
          'description' => $row['description'],
          'location_lat' => $row['location_lat'],
          'location_lng' => $row['location_lng'],
          'distance' => $distance,
          'review' => $review,
          'image' =>$images
          );

          $output = array('result'  => $restaurant_list,
                          'message' => 'success');
        }
      }
      $this->response($output);    */
    }
    else{
      $this->response("Restaurant Not Found", 404);
      exit;
    }
  }

  public function getNearByRestaurantsDetails_get(){
    $location_id = $this->get('location_id');
    $c_lat = '9.9208308';
    $c_lng = '78.0926804';
    if (!empty($location_id) && is_numeric($location_id)){
      $rest_Details = $this->RestaurantsList_model->getNearByRestaurantsDetails($c_lat,$c_lng,$location_id);

      if(!empty($rest_Details)){
        $ratings = $this->RestaurantsList_model->getReviews($location_id);
        $data =$rest_Details[0];
        if($ratings == ""){
          $data['ratings'] = array();
        }else{
            $data['ratings'] = $ratings;
        }
        $data['distance'] =  number_format($data['distance'],2, '.', '');
        $data['profile_image']=$data['location_image'];
        if($data['location_status'] == 1)
        {
            $data['location_status'] = "Active";
        }else{
            $data['location_status'] = "In-Active";
        }
        $data['categories'] = $this->RestaurantsList_model->getCategories(NULL,"",$location_id);
        $data['location_options'] =unserialize($data['options']);
        $gallery = unserialize($data['options']);

        if(@$gallery['gallery']['images'] != ""){
          $i=0;
          foreach ($gallery['gallery']['images'] as $as => $value) {
            if($i == 0){
              $data['gallery'][$i]["path"] = $imag;
              $data['gallery'][$i]["name"] = "";
              $data['gallery'][$i]["alt_text"] = "";
              $data['gallery'][$i]["status"] = "";
            }else{
              $data['gallery'][$i] = $value;
            }
            $i++;
          }
        }else{
          $data['gallery'] = array();
        }
        $taxes = [];
        $all_tax = 0;
        $tax_types = json_decode($data['tax_type']);
        $tax_perc  = json_decode($data['tax_perc']);
        $tax_status  = json_decode($data['tax_status']);
        for ($t=0;$t<count($tax_types);$t++)
        {
          if($tax_status[$t] == 1)
          {
          $all_tax += $tax_perc[$t];
          $taxes[$t]['tax_name']  = $tax_types[$t];
          $taxes[$t]['tax_value'] = $tax_perc[$t];
          }
        }

        $data['taxes'] = $taxes;
        $data['overall_tax'] = $all_tax;

        $output = array('result'  => $data, 'message' => 'Restaurants Details');
        echo json_encode($output);
      }else{
        $error_data = array('code'  => 401 ,'error' => 'Restaurant Not Found.');
        $output = array('message'  => $error_data);
        echo json_encode($output);
      }
    }else{
      $error_data = array('code'  => 401 ,
                          'error' => 'Invalid Params.');
      $output = array('message'  => $error_data);
      echo json_encode($output);
    }
  }

    public function getNotification_post() {

        $result['result'] = $this->Reservations_model->getNotification($this->post('customer_id'));
        $result['message'] = "Success";
        $this->response($result);

    }

    public function checkCoupon_post() {

       $location_id = $this->post('location_id');
       $coupon = $this->post('coupon');
       $customer_id = $this->post('customer_id');
       $total_amount = $this->post('total_amount');

       if($coupon == '' || $customer_id == '' || $location_id == '' || $total_amount == '')
       {
          $result['message'] = "Invalid Params";
          $this->response($result);
          return;
       }
       $vendor_id = $this->RestaurantsList_model->getVendorId($location_id);

       $data = $this->RestaurantsList_model->validateCoupon($coupon,$vendor_id,$total_amount,$customer_id);

       if($data != ""){
         $result['result'] = NULL;
         $result['message'] = $data;
       }else{
         $coupon_details = $this->RestaurantsList_model->getCouponDetails($coupon,$vendor_id);
         $result['result']['coupon_id'] =  $coupon_details['coupon_id'];
         if($coupon_details['type'] == 'P'){
            $discount_amount = $total_amount * ($coupon_details['discount'] / 100);
            $result['result']['discount'] = "$discount_amount";
            $result['result']['type'] = "Percentage";
            $result['result']['coupon'] = $coupon;
         }else if($coupon_details['type'] == 'F'){
            $result['result']['discount'] = $coupon_details['discount'];
            $result['result']['type'] = "Fixed Amount";
            $result['result']['coupon'] = $coupon;
         }

         $result['message'] = "Success";
       }

        $this->response($result);

    }

    public function getHelp_post() {

       $result['result'] = $this->Reservations_model->getFaq();
       $result['message'] = "Success";
       $this->response($result);
    }

    public function restaurantCancellation_post() {
      $this->load->model('Twilio_model');
       $cancellation_data = array();

       $reservation_id = $this->input->post('reservation_id');
       $language = $this->input->post('language');

       if(strtolower($language)=='english' || strtolower($language)=='en'){
        $lang = 'english';
       } else if(strtolower($language)=='arabic' || strtolower($language)=='ar'){
        $lang = 'arabic';
       } else {
        $lang = 'english';
       }

       $reserve  = $this->Reservations_model->getReservation($reservation_id);

       $location = $reserve['location_id'];
       $loc_stff = $this->Reservations_model->GetTable_all('locations','location_id = "'.$location.'"');
       $loc_stf = $loc_stff[0]['added_by'];

       $time_zone = $this->Reservations_model->GetTable('settings','item = "timezone"');

       date_default_timezone_set($time_zone);
       date_default_timezone_get();

       $staf_commission = $this->Reservations_model->GetTable_all('staffs_commission','reservation_id = "'.$reservation_id.'"');
       $staf_status     = $staf_commission[0]['status'];
       $staf_pay_status = $staf_commission[0]['payment_status'];


       $reservation_details = $this->Reservations_model->getReservationDetails($reservation_id);
       $reservation_details['cancellation_status'] = 0;

       $total_amount = $reserve['total_amount'] - $reserve['reward_used_amount'];


                    $refun = array(
                    'reservation_id' => $reservation_id,
                    'customer_id' => $reserve['customer_id'],
                    'refund_amount' =>$this->input->post('refund_amount'),
                    'type' => 'Requested',
                    'created_at' => date('Y-m-d H:i:s'),
                    'payment_type' => '2checkout',
                    'cancel_percent' => $this->input->post('cancel_percent'),
                    'staff_id' => $loc_stf
                   );
                   $this->db->insert('refund',$refun);
                  if($staf_pay_status=='paid') {
                     $this->db->set('status','17');
                     $this->db->set('payment_status','awaiting for refund');
                     $this->db->update('staffs_commission');
                  } else if($staf_pay_status=='confirmed') {
                     $this->db->set('status','17');
                     $this->db->set('payment_status','cancelled');
                    $this->db->update('staffs_commission');
                  }

       if($reservation_details['status'] != '17'){

          $cancellation_data['reservation_id'] = $reservation_details['reservation_id'];
          $cancellation_data['total_amount'] = $this->Reservations_model->getTotalAmount($reservation_id);

          $this->load->model('Extensions_model');
          $sms_status = $this->Extensions_model->getExtension('twilio_module');
          $status = $this->Extensions_model->getStatus('17');

          $mail_data = $this->Reservations_model->getMailData($reservation_id);

          $data = array('status' => 17,'status_comment' => 'Your table reservation has been canceled.');

         $cancel_status = $this->Reservations_model->updateReservation($reservation_id,$data);
         //$cancel_status =1;

          if($cancel_status) {

            if($reservation_id!=''){

             $table =  $this->Reservations_model->GetTable_all('pp_payments', 'order_id = "'.$reservation_id.'"');

              if($table) {

                $cancellation_process = explode('-',$reserve['cancellation_period']);
                $cancellation_period = json_decode($cancellation_process[0],true);
                $cancellation_time   = json_decode($cancellation_process[1],true);

                $cancellation_charge = json_decode($reserve['cancellation_charge'],true);

                $cancel_count       = count(json_decode($reserve['cancellation_charge'],true));



                // echo $count;exit;

              }
            }


            if($sms_status['status'] == 1)
            {
              // $current_lang = $this->session->userdata('lang');
              // if(!$current_lang) { $current_lang = "english"; }
              $sms_code = 'reservation_update_'.$lang;
              $sms_template = $this->Extensions_model->getTemplates($sms_code);
              $message = $sms_template['body'];
              $message = str_replace("{status}",$status['status_name'],$message);
              $message = str_replace("{reservation_number}",$mail_data['reservation_number'],$message);
              // $ctlObj = modules::load('twilio_module/twilio_module/');
              // echo $message;

              $sms_code_ven = 'reserve_update_location_'.$lang;
              $sms_template_ven = $this->Extensions_model->getTemplates($sms_code_ven);
              $message_ven = $sms_template_ven['body'];
              $message_ven = str_replace("{status}",$status['status_name'],$message_ven);
              $message_ven = str_replace("{reservation_number}",$mail_data['reservation_number'],$message_ven);

              if($mail_data['telephone']!=''){
                $client_msg = $this->Twilio_model->Sendsms($mail_data['telephone'],$message);
              }

              if($mail_data['staff_telephone']!=''){
               $vendor_msg=$this->Twilio_model->Sendsms($mail_data['staff_telephone'],$message_ven);
              }
            }
          }
          $this->load->helper('logactivity');
          log_activity($reserve['customer_id'], 'reservation cancelled', 'reservations','<a href="'.site_url().'admin/customers/edit?id='.$reserve['customer_id'].'">'.$reserve['first_name'] . '  ' . $reserve['last_name'].'</a> cancelled a <b>reservation</b> <a href="'.site_url().'admin/reservations/edit?id='.$reservation_id.'"><b>#'.$reservation_details['reservation_id'].'.</b></a>');
          $result['message'] = "Successfully cancelled.";
       }else{
          $result['message'] = "This reservation already cancelled.";
       }
       $this->response($result);
    }

    public function addReview_post() {
        $review_details = array();

        $review_details['sale_type'] = $this->post('sale_type');
        $review_details['sale_id'] = $this->post('sale_id');
        $review_details['location_id'] = $this->post('location_id');
        $review_details['customer_id'] = $this->post('customer_id');
        $review_details['author'] = $this->post('author');
        $review_details['rating']['quality'] = $this->post('rating_quality');
        $review_details['rating']['service'] = $this->post('rating_service');
        $review_details['rating']['delivery'] = $this->post('rating_delivery');
        $review_details['review_text'] = $this->post('review_text');


        $result['result']['review_id'] = $this->RestaurantsList_model->saveReview($review_details);
        $result['message'] = "Success";
        $this->RestaurantsList_model->updateOverallReview($this->post('location_id'));
        $this->response($result);

    }

    public function doCall($baseurl, $data=array(),$username,$password)
    {
        $url = $baseurl;
        $ch = curl_init($url);
        // $data['privateKey'] = '62BED47B-F3C8-4837-979E-87E2542EC6F7';
        $data = json_encode($data);
        $header = array("content-type:application/json","content-length:".strlen($data));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);

        if(curl_error($ch)!=''){
             $error_msg = curl_error($ch);
            return $error_msg;
            exit;
        }
        return $resp;
        curl_close($ch);
        exit;
    }

    public function changeNotificationStatus_post(){

     $customer_id = $this->post('customer_id');
     $notification_status = $this->post('notification_status');

     if(!$customer_id){

        $result['message'] = "Please enter customer_id..!";

        $this->response($result);

     }

     $msg = $this->RestaurantsList_model->changeNotificationStatus($customer_id,$notification_status);

        if($msg){
         $result['result']['current_notification_status'] = $notification_status;
         $result['message'] = "Success";
         $this->response($result);
         exit;
        }
        else{

         $result['result'] = array();
         $result['message'] = "Failed";
         $this->response($result);
         exit;
        }
    }

    public function reserveTable_post() {
       $this->load->model('Twilio_model');
        if ($this->post() AND $this->post('menu_details')) {

            $reserve = array();
            $cart_contents = array();

            $reservation_data = $this->post();
            $menu_details = json_decode($reservation_data['menu_details'],true);
           
            if (!empty($reservation_data)) {
                if (!empty($reservation_data['location_id'])) {
                    $reserve['location_id'] = (int)$reservation_data['location_id'];
                }
                $language = $this->post('language');
                  if(strtolower($language)=='english' || strtolower($language)=='en'){
                    $lang = 'english';
                   } else if(strtolower($language)=='arabic' || strtolower($language)=='ar'){
                    $lang = 'arabic';
                   } else {
                    $lang = 'english';
                   }
                /*if (!empty($reservation_data['table_found']) AND !empty($reservation_data['table_found']['table_id'])) {
                    $reserve['table_id'] = $reservation_data['table_found']['table_id'];
                }*/

                if (!empty($menu_details)) {
                  // echo 1;exit;
                    //$menu_ids = explode(',',$reservation_data['menu_id']);
                    //$qtys = explode(',',$reservation_data['qty']);

                    /*foreach ($menu_ids as $key => $value) {
                        $data = $this->Reservations_model->getMenuDetails($value);
                        $cart_contents[$key]['id'] = $value;
                        $cart_contents[$key]['name'] = $data['menu_name'];
                        $cart_contents[$key]['qty'] = $qtys[$key];
                        $cart_contents[$key]['price'] = $data['menu_price']=="0.0000" ? $this->Reservations_model->getOptionValuePrice($value) : $data['menu_price'];
                        $cart_contents[$key]['subtotal'] = $qtys[$key] * $data['menu_price']=="0.0000" ? $this->Reservations_model->getOptionValuePrice($value) : $data['menu_price'];
                        $cart_contents[$key]['comment'] = "";
                        $cart_contents[$key]['options'] = "";
                        $cart_contents[$key]['coupan'] = "";
                    }*/

                    foreach ($menu_details['menu_details'] as $key => $value1) {
                      $i=0;
                       //foreach ($value as $key => $value1) {
                       // print_r($value1);exit;

                        $data = $this->Reservations_model->getMenuDetails($value1['menu_id']);
                        $option_details = $this->getOptionDetailsData1($value1['option_id']);
                        // echo $value['option_id'];
                        // echo '<br>';

                        // exit;
                        $sub_option_details = $this->getOptionDetailsData($value1['option_value_id']);
                        $cart_contents[$key]['location_id'] = $value1['location_id'];
                        $cart_contents[$key]['id'] = $value1['menu_id'];
                        $cart_contents[$key]['name'] = $data['menu_name'];
                        $cart_contents[$key]['name_ar'] = $data['menu_name_ar'];
                        $cart_contents[$key]['qty'] = $value1['qty'];
                        //$cart_contents[$key]['price'] = $value->price;
                        $cart_contents[$key]['price'] = $value1['menu_price'];
                        $cart_contents[$key]['subtotal'] = $value1['qty'] * $value1['menu_price'];
                        $cart_contents[$key]['comment'] = $value1['comment'];
                        /*
                        * Value of menu options
                        */
                        if(!empty($value1['menu_options'])){
                          foreach ($value1['menu_options'] as $key_menu => $value_menu) {
                            $cart_contents[$key]['options'][$key_menu]['menu_option_id'] = $value_menu['menu_option_id'];
                            $cart_contents[$key]['options'][$key_menu]['menu_option_value_id'] = $value_menu['option_value_id'];
                          }
                        }
                        $cart_contents[$key]['option_name'] = $option_details['option_name'];
                        $cart_contents[$key]['option_value_name'] = $sub_option_details['value'];
                        // $cart_contents[$key]['options'][$key]['option_values'] = $value['option_values'];
                        //$cart_contents[$key]['options']['price'] = $value1['menu_price'];

                        /*
                        * Value of menu variants
                        */
                        if(!empty($value1['menu_variants'])){
                          foreach ($value1['menu_variants'] as $key_var => $value_var) {
                            $cart_contents[$key]['variants'][$key_var]['variant_type_id'] = $value_var['variant_type_id'];
                            $cart_contents[$key]['variants'][$key_var]['variant_type_name'] = $value_var['variant_type_name'];
                            $cart_contents[$key]['variants'][$key_var]['variant_type_value_id'] = $value_var['variant_type_value_id'];
                            $cart_contents[$key]['variants'][$key_var]['variant_type_value_name'] = $value_var['variant_type_value_name'];
                            $cart_contents[$key]['variants'][$key_var]['price'] = $value_var['price'];
                          }
                        }

                        $i++;
                      // }

                    }

                    $noti_data['notify_msg'] = 'New order received.';
                    $notify = $this->Reservations_model->addNotification($noti_data);

                    $cart_contents['order_total'] = $reservation_data['food_order_total'] + $reservation_data['table_booking_tax_amount'];

                    $cart_contents['cart_total'] = $reservation_data['food_cart_total'];

                    $cart_contents['total_items'] = $reservation_data['total_items'];

                    $cart_contents['taxes'] = $reservation_data['food_tax'] + $reservation_data['table_booking_tax_amount'];

                    $reserve['total_amount'] = $reservation_data['table_total_amount'] + $reservation_data['food_order_total'];

                    $reserve['booking_price'] = $reservation_data['table_booking_price'];

                    $reserve['order_price'] = $reservation_data['table_booking_tax_amount'] + $reservation_data['food_order_total'];

                    $reserve['booking_tax'] = 0;

                    $reserve['booking_tax_amount'] = 0;



                }else{

                   $reserve['booking_price'] = $reservation_data['table_booking_price'];

                   $reserve['booking_tax'] = $reservation_data['table_booking_tax'];

                   $reserve['booking_tax_amount'] = $reservation_data['table_booking_tax_amount'];

                   $reserve['total_amount'] = $reservation_data['table_total_amount'];

                    $reserve['order_price'] = 0;

                }

                $reserve['coupon_id'] = $reservation_data['coupon_id'];

                $reserve['coupon_code'] = $reservation_data['coupon_code'];
                $reserve['coupon_discount'] = $reservation_data['coupon_discount'];
                $reserve['coupon_type'] = $reservation_data['coupon_type'];
                
                $reserve['deviceid'] = $reservation_data['deviceid'];
                $coupon_details = array();

                if($reserve['coupon_id'] != 0){
                  $coupon_details['code'] = $reserve['coupon_code'];
                  $coupon_details['coupon_type'] = $reserve['coupon_type'];
                  $coupon_details['amount'] = $reserve['coupon_discount'];
                }

                $cart_contents['coupon'] = $coupon_details;

                $cart_contents['delivery_fee'] = $reservation_data['delivery_fee'];

                /*$cart_contents['pickup_fee'] = $reservation_data['pickup_fee'];

                $cart_contents['tips_value'] = $reservation_data['tips'];*/

                $cart_contents['taxes'] = json_decode($reservation_data['tax_details'],true);

                $reserve['table_booking_tax'] = $reservation_data['table_booking_tax'];

                $reserve['using_reward_points'] = $reservation_data['using_reward_points'];

                $reserve['using_reward_amount'] = $reservation_data['using_reward_amount'];
                //print_r($cart_contents);exit;

                if (!empty($reservation_data['guest_num'])) {
                    $reserve['guest_num'] = (int)$reservation_data['guest_num'];
                }

                if (!empty($reservation_data['guest_num'])) {
                    $reserve['guest_num'] = (int)$reservation_data['guest_num'];
                }

                if (!empty($reservation_data['reserve_date'])) {
                    $reserve['reserve_date'] = $reservation_data['reserve_date'];
                }

                $reserve['order_type'] = $reservation_data['order_type'];
                $reserve['address_id'] = $this->post('address_id');


                if (!empty($reservation_data['payment'])) {
                    $reserve['payment'] = $reservation_data['payment'];
                }

                if (!empty($reservation_data['pickup_time'])) {
                  $reserve['pickup_time'] = $reservation_data['pickup_time'];
                }

                if (!empty($reservation_data['card_details'])) {
                  $reserve['card_details'] = json_decode($reservation_data['card_details'],true);
                }

                if (!empty($reservation_data['stripe_charge_id'])) {
                  $reserve['stripe_charge_id'] = $reservation_data['stripe_charge_id'];
                  
                } 

                if (!empty($reservation_data['reserve_date'])) {
                    $reserve['reserve_date'] = $reservation_data['reserve_date'];
                    $reserve['order_date'] = $reservation_data['reserve_date'];
                }

                if (!empty($reservation_data['reserve_time'])) {
                    $reserve['reserve_time'] = $reservation_data['reserve_time'];
                    $reserve['order_time'] = $reservation_data['reserve_time'];
                }

                if (!empty($reservation_data['user_id'])) {
                    $reserve['customer_id'] = $reservation_data['user_id'];

                    $data = $this->Customers_model->getCustomer($reserve['customer_id']);

                    $reservation_data['name'] = $data['first_name'];
                    $reservation_data['email'] = $data['email'];
                    $reservation_data['phone'] = $data['telephone'];


                } else {
                    $reserve['customer_id'] = '0';
                    $reservation_data['name'] = 0;
                    $reservation_data['email'] = 0;
                    $reservation_data['phone'] = 0;
                }

                $reserve['first_name']  = $reservation_data['name'];
                $reserve['last_name']   = "";
                $reserve['email']       = $reservation_data['email'];
                $reserve['telephone']   = $reservation_data['phone'];

                $phone   = explode('-',$reservation_data['phone']);

                $reserve['comment']     = $reservation_data['comment'];
                $reserve['ip_address']  = $this->Reservations_model->getDeviceId($reserve['customer_id']);

                $reserve['user_agent']  = 0;

                $reserve_time = date('h:i:s',strtotime($reserve['reserve_time']));

                //print_r($cart_contents);exit;

                $available_table_id = $this->Reservations_model->checkReservationTable($reserve['guest_num'],$reserve['location_id'],$reserve['reserve_date'],$reserve_time);

                /*if(empty($available_table_id)){
                    $result['message'] = "Tables not available now";
                    $this->response($result);
                    exit;
                }*/

                $max_capacity = $this->Reservations_model->getMaxCapacity($available_table_id[0]);

                if($max_capacity < $reserve['guest_num']){
                    $total_tables = ceil($reserve['guest_num'] / $max_capacity);
                }else{
                    $total_tables = 1;
                }

                  /*count($available_table_id) < $total_tables*/
                if(false){
                  /*$result['message'] = "Tables not available now";
                  $this->response($result);
                  exit;*/
                }  else {

                  if(!empty($reservation_data['payment'])){

                    /*if($reservation_data['payment']!='cash' AND $reservation_data['payment']!='reward' && $reservation_data['payment']!='stripe'){
                      $this->load->model('Extensions_model');
                      //$checkout = $this->Extensions_model->getExtension('2checkout');
                      $checkout = $this->RestaurantsList_model->getPaymentDetails($reservation_data['location_id']);
                      if($checkout['payment_api_mode']=='sandbox'){
                        $prefix_url = 'sandbox';
                      } else {
                        $prefix_url = 'www';
                      }

                      $baseurl = "https://".$prefix_url.".2checkout.com/checkout/api/1/".$checkout['payment_seller_id']."/rs/authService";

                      $username  = $checkout['payment_username'];
                      $password  = $checkout['payment_password'];
                      $token     = $reservation_data['token'];
                      $sellerid  = $checkout['payment_password'];
                      $this->load->library('Currency');
                      $currency =  $this->currency->getCurrencyCode();

                      $data = array(
                                "sellerId" => $checkout['payment_seller_id'],
                                "privateKey" => $checkout['payment_private_key'],
                                "merchantOrderId" => 'ORD'.rand(0,99999),
                                "token" => $token,
                                "currency" => $currency,
                                "total" => $reservation_data['food_order_total'],
                                "billingAddr" => array(
                                    "name" => $reservation_data['name'],
                                    "addrLine1" => '123 test blvd',
                                    "city" => 'Columbus',
                                    "country" => $reservation_data['country'],
                                    "email" => $reservation_data['email'],
                                    "phoneNumber" => $phone[1]
                                )
                            );
                      $test = $this->doCall($baseurl,$data,$username,$password);
                      $status = json_decode($test);
                      $order_number = $status->response->orderNumber;
                      $reserve['payment_key'] = $order_number;
                      $httpStatus = $status->exception->errorCode;
                      $errorMsg = $status->exception->errorMsg;
                      $response  = $status->response->response;
                      $responsecode  = $status->response->responseCode;

                      if($responsecode!='APPROVED'){
                        $result['message'] = $errorMsg;
                        $this->response($result);
                        exit;
                      }
                    }*/
                  }
                }
              /*
               // $twilio_controller = 'twilio_module'.'/'.'twilio_module';

                $ctlObj = modules::load('twilio_module/twilio_module/');
                $reservation_module=$ctlObj->sendSms();

                //$CI->load->module($twilio_controller);
               // $CI->Twilio_module->sendSms();
                echo $reservation_module;exit;*/

                $pay_location = $this->Reservations_model->getLocationDetails($reserve['location_id']);


                /***********Reward Points***************/
                if($pay_location['reward_status'] == '1' && $reserve['using_reward_points'] != 0)
                  {
                    $rewards_value  =  $pay_location['rewards_value'];  // Rewards % value
                    $reward_point   =  $reserve['total_amount'] * ($rewards_value / 100);
                    $reserve['reward_points'] = $reward_point;

                  }
                /***********Reward Points***************/
                
                $reserve['reservation_id'] = $this->Reservations_model->generateReservationNumber($reserve['location_id']);

                $reserve['otp'] = $this->Reservations_model->generateOtp($reserve['location_id']);

                $reserve['order'] = $this->Reservations_model->addOrder($reserve,$cart_contents);
                $total_tables = 0;
                for($i=0;$i<$total_tables;$i++){
                    $reserve['table_id'] = $available_table_id[$i];
                    $this->Reservations_model->addReservation($reserve,$i);
                }
                $st_val_id = $this->Reservations_model->GetTable('settings','item = "default_reservation_status"');
                $this->Reservations_model->addReservationHistory($reserve['reservation_id'],$st_val_id);

                if($reserve['using_reward_points'] != 0){
                  $this->Reservations_model->addRewardHistory($reserve);
                }

                if($reserve['coupon_id'] != 0){

                   $coupon_id = $this->Reservations_model->addOrderCoupon($reserve['order']['order_id'],$reserve['customer_id'],$coupon_details);
                }

                // $message = 'Your Booking ID is  '.$reserve['reservation_id'].' Show this unique code - '.$reserve['otp'].' in the restaurant front desk.';

                // $current_lang = $this->session->userdata('lang');
                // if(!$current_lang) { $current_lang = "english"; }
                $sms_code = 'reservation_'.$lang;
                $sms_template = $this->Extensions_model->getTemplates($sms_code);
                $message = $sms_template['body'];
                $message = str_replace("{unique_code}",$reserve['otp'],$message);
                $message = str_replace("{reservation_number}",$reserve['reservation_id'],$message);

                if($reserve['telephone']!=''){
                  $this->Twilio_model->Sendsms($reserve['telephone'],$message);
                }

                if(isset($reservation_data['stripe_token']) && $reservation_data['stripe_token']!=''){
                   $payment_response = $this->Reservations_model->add2checkoutdetails($reservation_data['stripe_token'],$reserve['order']['order_id'],$reserve['customer_id'],serialize($reservation_data['stripe_response']),$reservation_data['payment']);
                }

                if(isset($reservation_data['paypal_token'])){
                   $payment_response = $this->Reservations_model->add2checkoutdetails($reservation_data['paypal_token'],$reserve['order']['order_id'],$reserve['customer_id'],serialize($reservation_data['paypal_token']),$reservation_data['payment']);
                }

                if($order_number)
                {
                  $payment_response = $this->Reservations_model->add2checkoutdetails($order_number,$reserve['reservation_id'],$reserve['customer_id'],serialize($status),$reserve['payment']);
                }

                $result['reservation_id'] = $reserve['reservation_id'];
                $result['order_id'] = $reserve['order']['order_id'];
                $result['order_date'] = date('d M, Y',strtotime($reserve['order']['order_date']));
                $result['order_time'] = date('h:i a',strtotime($reserve['order']['order_time']));

                $result['otp'] = $reserve['otp'];
                $result['message'] = "Success";

                $this->response($result);


                /*if ($reservation_id = $this->Reservations_model->addReservation($reserve)) {
                   // $this->session->set_tempdata('last_reservation_id', $reservation_id);
                     print_r($reservation_id);exit;
                    return TRUE;
                }*/

            }
        }else{

           $reservation_data = $this->post();
            $menu_data = explode(',',$reservation_data['menu_id']);
            $menu_qty = explode(',',$reservation_data['qty']);
            $menu_comments = explode(',',$reservation_data['comments']);
            $menu_price = explode(',',$reservation_data['price']);
            $menu_details = array();
            foreach ($menu_data as $key => $value) {
              $val_explode = explode('-',$value);
              $menu_details[$key]['menu_id'] = $val_explode[1];
              $menu_details[$key]['qty'] = $menu_qty[$key];
              $menu_details[$key]['comments'] = $menu_comments[$key];
              $menu_details[$key]['price'] = $menu_price[$key];
              if(count($val_explode) == 2){
                 $menu_details[$key]['options'] = array();
              }else if(count($val_explode) == 4){

                 //$menu_details[$key]['options']['menu_option_id'] = $val_explode['2'];
                //Android Changes

                /* $option_details = $this->Reservations_model->getOptionDetailsData($val_explode['3']);
                 $menu_details[$key]['options'][$val_explode['2']][0]['value_id'] = $val_explode['3'];
                 $menu_details[$key]['options'][$val_explode['2']][0]['value_name'] = $option_details['value'];
                 $menu_details[$key]['options'][$val_explode['2']][0]['value_price'] = $option_details['price'];*/

                 $menu_details[$key]['options']['menu_option_id'] = $val_explode['2'];
                 $menu_details[$key]['options']['option_values'] = array($val_explode['3']);
              }

            }

            $reserve = array();
            $cart_contents = array();



            if (!empty($reservation_data)) {
                if (!empty($reservation_data['location_id'])) {
                    $reserve['location_id'] = (int)$reservation_data['location_id'];
                }

                  if(strtolower($language)=='english' || strtolower($language)=='en'){
                    $lang = 'english';
                   } else if(strtolower($language)=='arabic' || strtolower($language)=='ar'){
                    $lang = 'arabic';
                   } else {
                    $lang = 'english';
                   }
                /*if (!empty($reservation_data['table_found']) AND !empty($reservation_data['table_found']['table_id'])) {
                    $reserve['table_id'] = $reservation_data['table_found']['table_id'];
                }*/

                if (!empty($reservation_data['menu_id']) AND !empty($reservation_data['qty'])) {

                    //$menu_ids = explode(',',$reservation_data['menu_id']);

                    //$qtys = explode(',',$reservation_data['qty']);

                    /*foreach ($menu_ids as $key => $value) {
                        $data = $this->Reservations_model->getMenuDetails($value);
                        $cart_contents[$key]['id'] = $value;
                        $cart_contents[$key]['name'] = $data['menu_name'];
                        $cart_contents[$key]['qty'] = $qtys[$key];
                        $cart_contents[$key]['price'] = $data['menu_price']=="0.0000" ? $this->Reservations_model->getOptionValuePrice($value) : $data['menu_price'];
                        $cart_contents[$key]['subtotal'] = $qtys[$key] * $data['menu_price']=="0.0000" ? $this->Reservations_model->getOptionValuePrice($value) : $data['menu_price'];
                        $cart_contents[$key]['comment'] = "";
                        $cart_contents[$key]['options'] = "";
                        $cart_contents[$key]['coupan'] = "";
                    }*/
                    foreach ($menu_details as $key => $value) {
                        $data = $this->Reservations_model->getMenuDetails($value['menu_id']);
                        $cart_contents[$key]['id'] = $value['menu_id'];
                        $cart_contents[$key]['name'] = $data['menu_name'];
                        $cart_contents[$key]['qty'] = $value['qty'];
                        $cart_contents[$key]['price'] = $value['price'];
                        $cart_contents[$key]['subtotal'] = $value['qty'] * $value['price'];
                        $cart_contents[$key]['comment'] = $value['comments'];
                        $cart_contents[$key]['options'] = $value['options'];
                        $cart_contents[$key]['coupan'] = "";
                    }

                    $coupon_details = array();

                    if($reserve['coupon_id'] != 0){

                      $coupon_details['code'] = $reserve['coupon_code'];
                      $coupon_details['amount'] = $reserve['coupon_discount'];
                    }

                    $cart_contents['coupon'] = $coupon_details;


                    $cart_contents['order_total'] = $reservation_data['food_order_total'] + $reservation_data['table_booking_tax_amount'];

                    $cart_contents['cart_total'] = $reservation_data['food_cart_total'];

                    $cart_contents['total_items'] = $reservation_data['total_items'];

                    $cart_contents['taxes'] = $reservation_data['food_tax'] + $reservation_data['table_booking_tax_amount'];

                    $reserve['total_amount'] = $reservation_data['table_total_amount'] + $reservation_data['food_order_total'];

                    $reserve['booking_price'] = $reservation_data['table_booking_price'];

                    $reserve['order_price'] = $reservation_data['table_booking_tax_amount'] + $reservation_data['food_order_total'];

                    $reserve['booking_tax'] = 0;

                    $reserve['booking_tax_amount'] = 0;

                }else{

                   $reserve['booking_price'] = $reservation_data['table_booking_price'];

                   $reserve['booking_tax'] = $reservation_data['table_booking_tax'];

                   $reserve['booking_tax_amount'] = $reservation_data['table_booking_tax_amount'];

                   $reserve['total_amount'] = $reservation_data['table_total_amount'];

                    $reserve['order_price'] = 0;

                }
                //print_r($cart_contents);exit;
                $reserve['coupon_id'] = $reservation_data['coupon_id'];

                $reserve['coupon_code'] = $reservation_data['coupon_code'];

                $reserve['coupon_discount'] = $reservation_data['coupon_discount'];


                $reserve['table_booking_tax'] = $reservation_data['table_booking_tax'];

                $reserve['using_reward_points'] = $reservation_data['using_reward_points'];

                $reserve['using_reward_amount'] = $reservation_data['using_reward_amount'];


                if (!empty($reservation_data['guest_num'])) {
                    $reserve['guest_num'] = (int)$reservation_data['guest_num'];
                }

                if (!empty($reservation_data['guest_num'])) {
                    $reserve['guest_num'] = (int)$reservation_data['guest_num'];
                }

                if (!empty($reservation_data['reserve_date'])) {
                    $reserve['reserve_date'] = $reservation_data['reserve_date'];
                }

                $reserve['order_type'] = $reservation_data['order_type'];
                $reserve['address_id'] = $this->post('address_id');


                if (!empty($reservation_data['payment'])) {
                    $reserve['payment'] = $reservation_data['payment'];

                }

                if (!empty($reservation_data['reserve_date'])) {
                    $reserve['reserve_date'] = $reservation_data['reserve_date'];
                    $reserve['order_date'] = $reservation_data['reserve_date'];
                }

                if (!empty($reservation_data['reserve_time'])) {
                    $reserve['reserve_time'] = $reservation_data['reserve_time'];
                    $reserve['order_time'] = $reservation_data['reserve_time'];
                }

                if (!empty($reservation_data['user_id'])) {
                    $reserve['customer_id'] = $reservation_data['user_id'];
                } else {
                    $reserve['customer_id'] = '0';
                }

                $reserve['first_name']  = $reservation_data['name'];
                $reserve['last_name']   = "";
                $reserve['email']       = $reservation_data['email'];
                $reserve['telephone']   = $reservation_data['phone'];

                $phone   = explode('-',$reservation_data['phone']);

                $reserve['comment']     = $reservation_data['comment'];
                $reserve['ip_address']  = $this->Reservations_model->getDeviceId($reserve['customer_id']);

                $reserve['user_agent']  = 0;

                $reserve_time = date('h:i:s',strtotime($reserve['reserve_time']));

                //print_r($cart_contents);exit;

                $available_table_id = $this->Reservations_model->checkReservationTable($reserve['guest_num'],$reserve['location_id'],$reserve['reserve_date'],$reserve_time);

                if(empty($available_table_id)){
                    $result['message'] = "Tables not available now";
                    $this->response($result);
                    exit;
                }

                $max_capacity = $this->Reservations_model->getMaxCapacity($available_table_id[0]);

                if($max_capacity < $reserve['guest_num']){
                    $total_tables = ceil($reserve['guest_num'] / $max_capacity);
                }else{
                    $total_tables = 1;
                }

                if(count($available_table_id) < $total_tables){
                  $result['message'] = "Tables not available now";
                  $this->response($result);
                  exit;
                }

                  if(!empty($reservation_data['payment'])){

                    /*if($reservation_data['payment']!='cash' AND $reservation_data['payment']!='reward'){
                      $this->load->model('Extensions_model');
                      //$checkout =  $this->Extensions_model->getExtension('2checkout');
                      $checkout = $this->RestaurantsList_model->getPaymentDetails($reservation_data['location_id']);
                      if($checkout['payment_api_mode']=='sandbox'){
                        $prefix_url = 'sandbox';
                      } else {
                        $prefix_url = 'www';
                      }

                      $baseurl = "https://".$prefix_url.".2checkout.com/checkout/api/1/".$checkout['payment_seller_id']."/rs/authService";

                      $username  = $checkout['payment_username'];
                      $password  = $checkout['payment_password'];
                      $token     = $reservation_data['token'];
                      $sellerid  = $checkout['payment_password'];
                      $this->load->library('Currency');
                      $currency =  $this->currency->getCurrencyCode();

                      $data = array(
                                "sellerId" => $checkout['payment_seller_id'],
                                "privateKey" => $checkout['payment_private_key'],
                                "merchantOrderId" => 'ORD'.rand(0,99999),
                                "token" => $token,
                                "currency" => $currency,
                                "total" => $reservation_data['order_total'],
                                "billingAddr" => array(
                                    "name" => $reservation_data['name'],
                                    "addrLine1" => '123 test blvd',
                                    "city" => 'Columbus',
                                    "country" => $reservation_data['country'],
                                    "email" => $reservation_data['email'],
                                    "phoneNumber" => $phone[1]
                                )
                            );
                      $test = $this->doCall($baseurl,$data,$username,$password);

                      $status = json_decode($test);
                      $order_number = $status->response->orderNumber;
                      $reserve['payment_key'] = $order_number;
                      $httpStatus = $status->exception->errorCode;
                      $errorMsg = $status->exception->errorMsg;
                      $response  = $status->response->response;
                      $responsecode  = $status->response->responseCode;

                      if($responsecode!='APPROVED'){
                        $result['message'] = $errorMsg;
                        $this->response($result);
                        exit;
                      }
                    }*/
                  }
                /*}*/
              /*
               // $twilio_controller = 'twilio_module'.'/'.'twilio_module';

                $ctlObj = modules::load('twilio_module/twilio_module/');
                $reservation_module=$ctlObj->sendSms();

                //$CI->load->module($twilio_controller);
               // $CI->Twilio_module->sendSms();
                echo $reservation_module;exit;*/

                $pay_location = $this->Reservations_model->getLocationDetails($reserve['location_id']);


                /***********Reward Points***************/
                if($pay_location['reward_status'] == '1' && $reserve['using_reward_points'] != 0)
                  {
                    $rewards_value  =  $pay_location['rewards_value'];  // Rewards % value
                    $reward_point   =  $reserve['total_amount'] * ($rewards_value / 100);
                    $reserve['reward_points'] = $reward_point;

                  }
                /***********Reward Points***************/

                $reserve['reservation_id'] = $this->Reservations_model->generateReservationNumber($reserve['location_id']);

                $reserve['otp'] = $this->Reservations_model->generateOtp($reserve['location_id']);

                $reserve['order'] = $this->Reservations_model->addOrder($reserve,$cart_contents);
                $reservation_auto_id = 0;
                //$total_tables = 0;
                for($i=0;$i<$total_tables;$i++){
                    $reserve['table_id'] = $available_table_id[$i];
                    $reservation_auto_id = $this->Reservations_model->addReservation($reserve,$i);
                }
                $st_val_id = $this->Reservations_model->GetTable('settings','item = "default_reservation_status"');
                $this->Reservations_model->addReservationHistory($reserve['reservation_id'],$st_val_id);

                if($reserve['using_reward_points'] != 0){
                  $this->Reservations_model->updatecustomerrewards($reserve['using_reward_points'],$reserve['customer_id']);
                  $this->Reservations_model->addRewardHistory($reserve);
                }

                if($reserve['coupon_id'] != 0){

                   $coupon_id = $this->Reservations_model->addOrderCoupon($reserve['order']['order_id'],$reserve['customer_id'],$coupon_details);
                }

                // $message = 'Your Booking ID is  '.$reserve['reservation_id'].' Show this unique code - '.$reserve['otp'].' in the restaurant front desk.';

                // $current_lang = $this->session->userdata('lang');
                // if(!$current_lang) { $current_lang = "english"; }
                $sms_code = 'reservation_'.$lang;
                $sms_template = $this->Extensions_model->getTemplates($sms_code);
                $message = $sms_template['body'];
                $message = str_replace("{unique_code}",$reserve['otp'],$message);
                $message = str_replace("{reservation_number}",$reserve['reservation_id'],$message);

                /*if($reserve['telephone']!=''){
                  $this->Twilio_model->Sendsms($reserve['telephone'],$message);
                }*/

                if(isset($reservation_data['stripe_token']) && $reservation_data['stripe_token']!=''){
                   $payment_response = $this->Reservations_model->add2checkoutdetails($reservation_data['stripe_token'],$reserve['order']['order_id'],$reserve['customer_id'],serialize($reservation_data['stripe_response']),$reservation_data['payment']);
                }
                if(isset($reservation_data['paypal_token'])){
                   $payment_response = $this->Reservations_model->add2checkoutdetails($reservation_data['paypal_token'],$reserve['order']['order_id'],$reserve['customer_id'],serialize($reservation_data['paypal_token']),$reservation_data['payment']);
                }

                if($order_number)
                {
                  $payment_response = $this->Reservations_model->add2checkoutdetails($order_number,$reserve['reservation_id'],$reserve['customer_id'],serialize($status),$reserve['payment']);
                }

                $result['reservation_id'] = $reserve['reservation_id'];
                $result['order_id'] = $reserve['order']['order_id'];
                $result['order_date'] = date('d M, Y',strtotime($reserve['order']['order_date']));
                $result['order_time'] = date('h:i a',strtotime($reserve['order']['order_time']));
                $result['otp'] = $reserve['otp'];
                $result['message'] = "Success";

                $this->response($result);


                /*if ($reservation_id = $this->Reservations_model->addReservation($reserve)) {
                   // $this->session->set_tempdata('last_reservation_id', $reservation_id);
                     print_r($reservation_id);exit;
                    return TRUE;
                }*/

            }
        }
    }
    public function cancellationAmountDetails_post() {

      $this->load->model('Reservations_model');
      $reservation_id = $this->input->post('reservation_id');

      if($reservation_id != "")
      {
        $reservation = $this->Reservations_model->getReservationDetails($reservation_id);
        if(isset($reservation['reservation_id']))
        {

          //$reservation['reserve_date']          = $reservation['reserve_date'];
          //$reservation['reserve_time']          = strtotime($reservation['reserve_time']);
          //echo $reservation['reserve_time'];exit;
          //print_r(count(json_decode($reservation['cancellation_charge'])));exit;
          //$def_can_time =  $reservation['cancellation_time']*60;

          $cancellation_period                  = explode('-',$reservation['cancellation_period']);
          $reservation['cancellation_period']   = json_decode($cancellation_period[0]);
          $reservation['cancellation_time']     = json_decode($cancellation_period[1]);
          $reservation['cancellation_charge']   = json_decode($reservation['cancellation_charge']);
          $reservation['cancel_count']          = count($reservation['cancellation_charge']);

          $order_price = $reservation['order_price'];
          $count = $reservation['cancel_count'];
          $total_amount = $reservation['total_amount'] - $reservation['reward_used_amount'];

          $date1 = date("Y-m-d H:i:s");
          $date2 = strtotime($reservation['reserve_date'].' '.$reservation['reserve_time']);
          $date2 = date("Y-m-d H:i:s" , $date2);
          //$date3 = strtotime($reservation['reserve_date'].' '.$reservation['reserve_time']) -  $def_can_time;
          if(strtotime($date2) > strtotime($date1))
          {
            $seconds = strtotime($date2) - strtotime($date1);

            /*$datetime1 = new DateTime($date1);
            $datetime2 = new DateTime($date2);
            $interval = $datetime1->diff($datetime2);
            print_r($interval);*/
            $cancel_hours = round($seconds / 60 / 60 , 2 );

            if($cancel_hours >= 24){
             $cancel_days = round($cancel_hours/24,2);
            }else{
              $cancel_days = 0;
             // echo $date1.'<br>';
            }
            if($order_price!='0'){
              if($reservation['refund_status']=='1'){

                if($cancel_days!='0'){
                  for ($i=0; $i <= $count ; $i++) {

                    $time[$i] = $reservation['cancellation_time'][$i];
                    $charge[$i] = $reservation['cancellation_charge'][$i];
                    $period[$i] = $reservation['cancellation_period'][$i];


                    if(($time[$i]=='day') && ($period[$i]<$cancel_days)){
                       $result['reservation_time'] = $date2;
                      $result['current_time'] = $date1;

                                if($period[$i]==''){
                                  $period[$i] = 0;
                                  $charge[$i] = $charge[$i];
                                }
                                 $result['cancellation_charge'] =  $charge[$i];
                                $result['cancellation_period'] =  $period[$i].' '.$reservation['cancellation_time'][$i];
                                $result['amount_paid'] =  number_format($total_amount,2);
                                $ref = $total_amount - ($total_amount * $charge[$i] / 100);
                                $result['refund_amount'] = number_format($ref, 2);
                                $i = $count+1;
                              }



                    if(($time[$i]=='day') && ($period[$i]>$cancel_days)){
                      $result['reservation_time'] = $date2;
                      $result['current_time'] = $date1;

                      if($period[$i-1]==''){
                        $period[$i-1] = 0;
                        $charge[$i-1] = $charge[$i];
                      }
                      $result['cancellation_charge'] =  $charge[$i-1];
                      $result['cancellation_period'] =  $period[$i-1].' '.$reservation['cancellation_time'][$i-1].' - '. $period[$i].' '.$reservation['cancellation_time'][$i];
                      $result['amount_paid'] =  number_format($total_amount,2);
                      $ref = $total_amount - ($total_amount * $charge[$i-1] / 100);
                      $result['refund_amount'] = number_format($ref, 2);
                      $i = $count+1;
                    }
                  }
                  $result['message'] = "Success";
                }else{

                  $cnt = 0;
                  for ($i=0; $i <= $count ; $i++) {
                    $time[$i] = $reservation['cancellation_time'][$i];
                    $charge[$i] = $reservation['cancellation_charge'][$i];
                    $period[$i] = $reservation['cancellation_period'][$i];
                    if($time[$i]=='hour'){
                      $cnt++;
                    }
                    if(($time[$i]=='hour') && ($period[$i]>=$cancel_hours)){
                      $result['reservation_time'] = $date2;
                      $result['current_time'] = $date1;

                      if($period[$i-1]==''){
                        $period[$i-1] = 0;
                        $charge[$i-1] = $charge[$i];
                      }
                      $result['cancellation_charge'] = $charge[$i-1];
                      $result['cancellation_period'] = $period[$i-1].' '.$reservation['cancellation_time'][$i-1].' - '.$period[$i].' '.$reservation['cancellation_time'][$i];
                      $result['amount_paid'] = number_format($total_amount,2);
                      $ref = $total_amount - ($total_amount * $charge[$i-1] / 100);
                      $result['refund_amount'] = number_format($ref, 2);
                      $i = $count+1;
                    }
                    else{
                      if($i==$cnt){
                       $result['reservation_time'] = $date2;
                       $result['current_time'] = $date1;

                      if($period[$i-1]==''){
                        $period[$i-1] = 0;
                        $charge[$i-1] = $charge[$i];
                      }
                      $result['cancellation_charge'] = $charge[$i-1];
                      $result['cancellation_period'] = $period[$i-1].' '.$reservation['cancellation_time'][$i-1].' - '.$period[$i].' '.$reservation['cancellation_time'][$i];
                      $result['amount_paid'] = number_format($total_amount,2);
                      $ref = $total_amount - ($total_amount * $charge[$i-1] / 100);
                      $result['refund_amount'] = number_format($ref, 2);
                      $i = $count+1;
                      }
                    }
                  }
                }
                $result['message'] = "Success";
               } else {
                $result['message'] = "Success";
                $result['refund_amount'] = $total_amount;
              }
            }else{

              $result['message'] = "Table Booking Will be cancelled! There is no Cancellation policy as there is no payment made.";
            }
          }
          else
          {
            $result['message'] = "Reservation time over.You can't cancel";
          }
        }
        else
        {
          $result['message'] = "Reservation Id not found.";
        }
      }
      else
      {
        $result['message'] = "Empty Params";


      }

      $this->response($result);
    }

    public function deliverCancel_post(){
      $deliver_id = $this->post('deliver_id');
      $order_id   = $this->post('order_id');
      $reason_id  = $this->post('reason_id');
      $comments   = $this->post('comments');

      $arr = array('reason_id' => $reason_id,'deliver_comments' => $comments,'status_id'=>'9');
      $this->db->where('order_id',$order_id);
      $this->db->where('delivery_id',$deliver_id);
      $this->db->update('orders',$arr);
      $result['message'] = 'success';
      $this->response($result);
    }
  public function getOptionDetailsData($id){
      $this->db->select('*');
    $this->db->from('option_values');
    $this->db->join('menu_option_values','menu_option_values.option_value_id = option_values.option_value_id');
    $this->db->where('menu_option_values.menu_option_value_id',$id);
    $query = $this->db->get();
    if(!empty($query->result_array()[0])){
      return $query->result_array()[0];
    }else{
      return array();
    }
  }

  public function getOptionDetailsData1($id=null){
    $this->db->select('*');
    $this->db->from('options');
    $this->db->where('option_id',$id);

    $query = $this->db->get();
    //echo $this->db->last_query();
    if($query->num_rows() > 0){
      $result = $query->row_array();
      //print_r($result);
      return $result;
    } else {
     return FALSE;
    }
  }

  public function paymentUrlGenerate_post(){
    $_POST = $this->post();
     $this->load->library('Currency');
    $currency =  $this->currency->getCurrencyCode();
    $enableSandbox = true;
    $paypalConfig = [
        'email' => 'arun.uplogic@gmail.com',
        'return_url' => site_url().'admin/login/success_post',
        'notify_url' => site_url().'admin/login/success_post'
    ];
    $paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
    $itemName = $_POST['customer_id'];
    $itemAmount = $_POST['amount'];
    $data = [];
      foreach ($_POST as $key => $value) {
          $data[$key] = stripslashes($value);
      }

      // Set the PayPal account.
      $data['business']       = $paypalConfig['email'];
      $data['cmd']            = '_xclick';
      $data['no_note']        = 1;
      $data['lc']             = 'UK';
      $data['bn']             = 'PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest';
      $data['item_number']    = '123456';
      $data['rm']             = 2;
      $data['return']         = $paypalConfig['return_url'];
      $data['notify_url']     = $paypalConfig['notify_url'];
      $data['item_name']      = $itemName;
      $data['currency_code']  = $currency;
      $queryString            = http_build_query($data);

      $result['payment_url']  = $paypalUrl . '?' . $queryString;
      $result['message'] = 'success';
      $this->response($result);

  }

  public function orders_get() {

    $location_id = $this->get('location_id');
    $customer_id = $this->get('customer_id');
    $status      = $this->get('status');
   
    if (!empty($location_id) && is_numeric($location_id)){
      $orders = $this->RestaurantsList_model->getRestaurantOrderHistory($location_id,$customer_id,$status);
      $output = array(
       'result'  => $orders, 'status'  => true,
        'message' => 'Order List',
      );
      echo json_encode($output);

    }else{
      $error_data = array('code'  => 401 ,'status'  => false,
                          'error' => 'Invalid Params.');
      $output = array('message'  => $error_data);
      echo json_encode($output);
    }
  }
  
  public function order_post(){
    $order_id = $this->post('order_id');
    $status = $this->post('status');
    if (!empty($order_id) && is_numeric($order_id)){
      $orders = $this->RestaurantsList_model->updateOrderStatusById($order_id,$status);      
      if($orders === true){
        $message = 'Successfully Order Update';
        /*
        * Check if the status = 0 , means to cancel order then alloow stripe refund process
        */   
        $output = array(
          'result'  => "success",
          'status'  => true,
           'message' => $message,
         );
         echo json_encode($output);
      }else{
        $error_data = array('code'  => 401 ,'status'  => false,
                          'error' => 'something wrong.');
        $output = array('message'  => $error_data);
        echo json_encode($output);
      }


    }else{
      $error_data = array('code'  => 401 ,'status'  => false,
                          'error' => 'Invalid Params.');
      $output = array('message'  => $error_data);
      echo json_encode($output);
    }
  }

  public function orderDetails_get() {
    $order_id = $this->get('order_id');
    if (!empty($order_id) && is_numeric($order_id)){
      $orders = $this->RestaurantsList_model->getOrderDetailsHistory($order_id);
      $output = array(
       'result'  => $orders,
        'message' => 'Order Details',
      );
      echo json_encode($output);

    }else{
      $error_data = array('code'  => 401 ,
                          'error' => 'Invalid Params.');
      $output = array('message'  => $error_data);
      echo json_encode($output);
    }

  }


  public function favouritesMenuList_get() {

    $location_id = $this->get('restaurant_id');
    $customer_id=$this->get('customer_id');
    $menu_id=$this->get('menu_id');
    if (!empty($location_id) && is_numeric($location_id)){
        $menu = $this->RestaurantsList_model->getFavouritesMenu($location_id,$customer_id,$menu_id);
        $output = array(
          'status'  => true,
         'result'  => $menu,
          'message' => 'Menu List',
        );
        echo json_encode($output);

    }else{
    $error_data = array('code'  => 401 ,'status'  => false,
                        'error' => 'Invalid Params.');
    $output = array('message'  => $error_data);
    echo json_encode($output);
    }
  }
  public function addFavouritesMenuItem_post() {

    $location_id = $this->post('restaurant_id');
    $customer_id=$this->post('customer_id');
    $menu_id=$this->post('menu_id');
    if (!empty($location_id) && is_numeric($location_id) && !empty($customer_id) && !empty($menu_id)){
        $menuItem = $this->RestaurantsList_model->addFavouritesMenu($location_id,$customer_id,$menu_id);
        if($menuItem === true){
          $output = array(
            'result'  => "success",
            'message' => 'Successfully Add to Favourites',
            'status'=>true
           );
           echo json_encode($output);
        }else{
          $error_data = array('code'  => 401 ,'error' => 'something wrong.');
          $output = array('message'  => $error_data,'status'=>false);
          echo json_encode($output);
        }
    }else{
      $error_data = array('code'  => 401 ,'status'=>false,
                          'error' => 'Invalid Params.');
      $output = array('message'  => $error_data);
      echo json_encode($output);
    }
  }
  public function removeFavouritesMenuItem_post() {
    $favourites_id = $this->post('favourites_id');
    if (!empty($favourites_id) && is_numeric($favourites_id)){
        $menuItem = $this->RestaurantsList_model->removeFavouritesMenu($favourites_id);
        if($menuItem == true){
          $output = array(
            'result'  => "success",
            'message' => 'Successfully Remove to Favourites item',
            'status'=>true
           );
           echo json_encode($output);
        }else{
          $error_data = array('code'  => 401 ,'error' => 'something wrong.');
          $output = array('message'  => $error_data,'status'=>false);
          echo json_encode($output);
        }
    }else{
      $error_data = array('code'  => 401 ,'status'=>false,
                          'error' => 'Invalid Params.');
      $output = array('message'  => $error_data);
      echo json_encode($output);
    }
  }

  public function getStaffProfile_get() {
    $location_id = $this->get('id');
    $Item = $this->RestaurantsList_model->getProfileStaff($location_id);
    if($Item && $location_id){
      $output = array(
        'result'  => $Item,
        'message' => 'Successfully get Profile',
        'status'=>true,
        );
        echo json_encode($output);
    }else{
      $error_data = array('code'  => 401 ,'error' => 'something wrong.');
      $output = array('message'  => $error_data,'status'=>false);
      echo json_encode($output);
    }
  }

  public function updateProfile_post() {
    $location_id = $this->post('location_id');
    $location = array();
    $location['staff_name'] = $this->post('staff_name');
    $location['location_telephone'] = $this->post('location_telephone');
    $location['location_id'] = $this->post('location_id');

    $Item = $this->RestaurantsList_model->updateRestaurant($location_id,$location);
    if($Item){
      $output = array(
        'result'  => "success",
        'message' => 'Successfully Update Profile',
        'status'=>true
        );
        echo json_encode($output);
    }else{
      $error_data = array('code'  => 401 ,'error' => 'something wrong.');
      $output = array('message'  => $error_data,'status'=>false);
      echo json_encode($output);
    }
  }
  public function passwordupdate_post() {
    $user_id   = $this->post('user_id');
    $old_password  = $this->post('old_pass');
    $new_password  = $this->post('new_pass');

    if (!empty($user_id) && is_numeric($user_id)){
      $rest_Details = $this->RestaurantsList_model->getRestaurant($user_id);
      if(empty($rest_Details)) {
        $result['message'] = "Invalid Restaurant Id";
        $this->response($result);
        exit;
      }
      $check = $this->RestaurantsList_model->checkPassword($user_id,$old_password);
      if(empty($check)){
        $result['message'] = "Old Password does not match";
        $this->response($result);
      } else {
        if($new_password!=''){
          $customer = $this->RestaurantsList_model->savePassword($user_id, $new_password);
          if($customer){
            $result['message'] = "Success";
            $result['content'] = "Password changed successfully";
            $this->response($result);
            exit;
          } else {
            $result['message'] = "Error";
            $this->response($result);
            exit;
          }
        } else {
            $result['message'] = "Password cannot be empty";
            $this->response($result);
            exit;
        }
      }
    }

  }
}