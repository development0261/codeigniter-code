<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RestaurantsList_model extends CI_Model
{

	function __construct()
	{
		$this->load->database();
		$this->load->library('location');
    set_timezone();
	}




	public function getLatLng($location_lat,$location_lng)
  {
    		$this->db->select('*');
    		$this->db->from('location');
    		$this->db->where('location_id',$location_id);
    		$query = $this->db->get();

    		if($query->num_rows() == 1){
    			return  $query->result_array();
    		}else{
    			return 0;
    		}
  }

  public function updateFavorite($cus_id,$loc_id,$favorite){

    $this->db->select('*');
    $this->db->from('favorites');
    $this->db->where('customer_id',$cus_id);
    $this->db->where('restaurant_id',$loc_id);
    $query = $this->db->get();
    if($query->num_rows() == 1){
       $data = array(
        'rating' => $favorite
      );
      $this->db->where('customer_id',$cus_id);
      $this->db->where('restaurant_id',$loc_id);
      $this->db->update('favorites', $data);
    }else{
      $data = array('customer_id'=>$cus_id,
        'restaurant_id'=>$loc_id,
        'rating' => $favorite
      );
      $this->db->insert('favorites', $data);
    }
    return true;
  }


  public function getPolicy()
  {
        $this->db->select('*');
        $this->db->from('pages');
        $this->db->where('name','Policy');
        $query = $this->db->get();
        if($query->num_rows() == 1){
          return  $query->result_array()[0];
        }else{
          return array();
        }

  }
  public function getTerms()
  {
        $this->db->select('*');
        $this->db->from('pages');
        $this->db->where('name','Terms & Condition');
        $query = $this->db->get();
        if($query->num_rows() == 1){
          return  $query->result_array()[0];
        }else{
          return array();
        }

  }
  public function getCancellation()
  {
        $this->db->select('*');
        $this->db->from('pages');
        $this->db->where('name','Cancellation');
        $query = $this->db->get();
        if($query->num_rows() == 1){
          return  $query->result_array()[0];
        }else{
          return array();
        }

  }
  public function checkTime($location_id,$date,$time)
  {
        $this->db->select('id');
        $this->db->from('reservations');
        $this->db->where('location_id',$location_id);
        $this->db->where('reserve_date',date('Y-m-d',strtotime($date)));
        $this->db->where('reserve_time',date('H:i:s',strtotime($time)));
        $query = $this->db->get();

        if($query->num_rows() == 1){
          return  1;
        }else{
          return 0;
        }

  }


  public function getRestType($location_type,$page,$keyword,$keyword_lang = 'english',$lat,$lng,$distance_param,$rating,$next_offset,$food_type,$favorite,$customer_id,$country_name)
  {
           $this->db->select('*,locations.location_id as locationid, 111.111 *
          DEGREES(ACOS(LEAST(COS(RADIANS('.$lat.'))
         * COS(RADIANS(location_lat))
         * COS(RADIANS('.$lng.' - location_lng ))
         + SIN(RADIANS('.$lat.'))
         * SIN(RADIANS(location_lat)), 1.0))) AS distance ');
        if ($this->config->item('distance_unit') === 'km') {
          $sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
        } else {
          $sql = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
        }

        $sql .= "cos( radians( A.location_lng ) - radians(?) ) + sin( radians(?) ) *";
        $sql .= "sin( radians( A.location_lat ) ) ) ) AS distance ";
        $this->db->from('locations');
        $this->db->join('countries', 'countries.country_id = locations.location_country_id','INNER');
        $this->db->join('menus', 'menus.location_id = locations.location_id','LEFT');

        if($favorite!='' && $favorite!='0'  && $customer_id!='' && $customer_id!='0'){
            $this->db->join('favorites', 'locations.location_id = favorites.restaurant_id','INNER');
            $this->db->where('favorites.customer_id',$customer_id);
            $this->db->where('favorites.rating !=','0');
        }

        if($location_type != "both"){
          $this->db->where_in('location_type', array($location_type,'both'));
        }

        if($food_type!='both' && $food_type!=''){
          $this->db->where('veg_type',$food_type);
        }
        $this->db->where('countries.country_name',$country_name);
        $this->db->where('location_status','1');
        if($keyword != ""){
          if($keyword_lang == 'arabic')
          {
            $this->db->group_start();
            $this->db->like('location_name_ar',urldecode($keyword),array('restaurant','cafe','both'));
            $this->db->or_like('menu_name',urldecode($keyword));
                $this->db->group_end();

          }
          else
          {
            $this->db->group_start();
             $this->db->like('location_name',$keyword,array('restaurant','cafe','both'));
              $this->db->or_like('menu_name',urldecode($keyword));
            $this->db->group_end();

          }
        }

        $this->db->group_by('locations.location_id');

        if($next_offset!='0'){
          $this->db->limit($next_offset,$page);
        } else {
          $this->db->limit(10,$page);
        }
        // $this->db->having('distance < ',20);
        if($rating!='0'){
           $this->db->where('location_ratings >=',$rating);
           // $this->db->order_by('location_ratings','ASC');
        } //else {
          if($distance_param == 'longest'){
            $this->db->order_by('distance','DESC');
          } else {
            $this->db->order_by('distance','ASC');
          }
        //}
        $query = $this->db->get();
         //echo $this->db->last_query();exit;
        if(!$query->num_rows())
        {
          return array();
        }
        else
        {
          return $query->result_array();
        }
  }


  public function getRestTypeFranchisee($location_type,$page,$keyword,$keyword_lang = 'english',$lat,$lng,$distance_param,$rating,$next_offset,$food_type,$favorite,$customer_id,$country_name,$added_by = '')
  {
           $this->db->select('*,locations.location_id as locationid, 111.111 *
          DEGREES(ACOS(LEAST(COS(RADIANS('.$lat.'))
         * COS(RADIANS(location_lat))
         * COS(RADIANS('.$lng.' - location_lng ))
         + SIN(RADIANS('.$lat.'))
         * SIN(RADIANS(location_lat)), 1.0))) AS distance ');
        if ($this->config->item('distance_unit') === 'km') {
          $sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
        } else {
          $sql = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
        }
        $sql .= "cos( radians( A.location_lng ) - radians(?) ) + sin( radians(?) ) *";
        $sql .= "sin( radians( A.location_lat ) ) ) ) AS distance ";
        $this->db->from('locations');
        $this->db->join('countries', 'countries.country_id = locations.location_country_id','INNER');
        $this->db->join('menus', 'menus.location_id = locations.location_id','LEFT');
        if($favorite!='' && $favorite!='0'  && $customer_id!='' && $customer_id!='0'){
            $this->db->join('favorites', 'locations.location_id = favorites.restaurant_id','INNER');
            $this->db->where('favorites.customer_id',$customer_id);
            $this->db->where('favorites.rating !=','0');
        }
        if($location_type != "both"){
          $this->db->where_in('location_type', array($location_type,'both'));
        }
        // echo $added_by;
        // exit;
        if($added_by != ""){
         $this->db->where_in('locations.added_by', $added_by);
        }
        if($food_type!='both' && $food_type!=''){
          $this->db->where('veg_type',$food_type);
        }
       // $this->db->where('countries.country_name',$country_name);
        $this->db->where('location_status','1');
        if($keyword != ""){
          if($keyword_lang == 'arabic')
          {
            $this->db->group_start();
            $this->db->like('location_name_ar',urldecode($keyword),array('restaurant','cafe','both'));
            $this->db->or_like('menu_name',urldecode($keyword));
                $this->db->group_end();
          }
          else
          {
            $this->db->group_start();
             $this->db->like('location_name',$keyword,array('restaurant','cafe','both'));
              $this->db->or_like('menu_name',urldecode($keyword));
            $this->db->group_end();
          }
        }
       $this->db->group_by('locations.location_id');
        if($next_offset!='0'){
          $this->db->limit($next_offset,$page);
        } else {
          $this->db->limit(10,$page);
        }
        // $this->db->having('distance < ',20);
        if($rating!='0'){
           $this->db->where('location_ratings >=',$rating);
           // $this->db->order_by('location_ratings','ASC');
        } //else {
          if($distance_param == 'longest'){
            $this->db->order_by('distance','DESC');
          } else {
            $this->db->order_by('distance','ASC');
          }
        //}
        $query = $this->db->get();
         //echo $this->db->last_query();exit;
        if(!$query->num_rows())
        {
          return array();
        }
        else
        {
          return $query->result_array();
        }
  }

  public function getRestTypeFranchisee1($location_type,$page,$keyword,$keyword_lang = 'english',$lat,$lng,$distance_param,$rating,$next_offset,$food_type,$favorite,$customer_id,$country_name,$added_by = '')
	{
           $this->db->select('*,locations.location_id as locationid, 111.111 *
          DEGREES(ACOS(LEAST(COS(RADIANS('.$lat.'))
         * COS(RADIANS(location_lat))
         * COS(RADIANS('.$lng.' - location_lng ))
         + SIN(RADIANS('.$lat.'))
         * SIN(RADIANS(location_lat)), 1.0))) AS distance ');
        if ($this->config->item('distance_unit') === 'km') {
          $sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
        } else {
          $sql = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
        }
        $sql .= "cos( radians( A.location_lng ) - radians(?) ) + sin( radians(?) ) *";
        $sql .= "sin( radians( A.location_lat ) ) ) ) AS distance ";
        $this->db->from('locations');
        $this->db->join('countries', 'countries.country_id = locations.location_country_id','INNER');
        $this->db->join('menus', 'menus.location_id = locations.location_id','LEFT');
        if($favorite!='' && $favorite!='0'  && $customer_id!='' && $customer_id!='0'){
            $this->db->join('favorites', 'locations.location_id = favorites.restaurant_id','INNER');
            $this->db->where('favorites.customer_id',$customer_id);
            $this->db->where('favorites.rating !=','0');
        }
        if($location_type != "both"){
          $this->db->where_in('location_type', array($location_type,'both'));
        }
        // echo $added_by;
        // exit;
        if($added_by != ""){
         $this->db->where_in('locations.added_by', $added_by);
        }
        if($food_type!='both' && $food_type!=''){
          $this->db->where('veg_type',$food_type);
        }
        $this->db->where('countries.country_name',$country_name);
        $this->db->where('location_status','1');
        if($keyword != ""){
          if($keyword_lang == 'arabic')
          {
            $this->db->group_start();
            $this->db->like('location_name_ar',urldecode($keyword),array('restaurant','cafe','both'));
            $this->db->or_like('menu_name',urldecode($keyword));
                $this->db->group_end();
          }
          else
          {
            $this->db->group_start();
             $this->db->like('location_name',$keyword,array('restaurant','cafe','both'));
              $this->db->or_like('menu_name',urldecode($keyword));
            $this->db->group_end();
          }
        }
       $this->db->group_by('locations.location_id');
        if($next_offset!='0'){
          $this->db->limit($next_offset,$page);
        } else {
          $this->db->limit(10,$page);
        }
        // $this->db->having('distance < ',20);
        if($rating!='0'){
           $this->db->where('location_ratings >=',$rating);
           // $this->db->order_by('location_ratings','ASC');
        } //else {
          if($distance_param == 'longest'){
            $this->db->order_by('distance','DESC');
          } else {
            $this->db->order_by('distance','ASC');
          }
        //}
        $query = $this->db->get();
         //echo $this->db->last_query();exit;
        if(!$query->num_rows())
        {
          return array();
        }
        else
        {
          return $query->result_array();
        }
  }



  public function getRestTypeCount($location_type,$page,$keyword,$keyword_lang = 'english',$lat,$lng,$distance_param,$rating,$next_offset,$food_type,$favorite,$customer_id,$country_name)
  {
           $this->db->select('*,locations.location_id as locationid, 111.111 *
          DEGREES(ACOS(LEAST(COS(RADIANS('.$lat.'))
         * COS(RADIANS(location_lat))
         * COS(RADIANS('.$lng.' - location_lng ))
         + SIN(RADIANS('.$lat.'))
         * SIN(RADIANS(location_lat)), 1.0))) AS distance ');
        if ($this->config->item('distance_unit') === 'km') {
          $sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
        } else {
          $sql = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
        }

        $sql .= "cos( radians( A.location_lng ) - radians(?) ) + sin( radians(?) ) *";
        $sql .= "sin( radians( A.location_lat ) ) ) ) AS distance ";
        $this->db->from('locations');
        $this->db->join('countries', 'countries.country_id = locations.location_country_id');
        $this->db->join('menus', 'menus.location_id = locations.location_id','LEFT');

        if($favorite!='' && $favorite!='0'  && $customer_id!='' && $customer_id!='0'){
            $this->db->join('favorites', 'locations.location_id = favorites.restaurant_id','INNER');
            $this->db->where('favorites.customer_id',$customer_id);
            $this->db->where('favorites.rating !=','0');
        }

        if($location_type != "both"){
          $this->db->where_in('location_type', array($location_type,'both'));
        }

        if($food_type!='both' && $food_type!=''){
          $this->db->where('veg_type',$food_type);
        }
        $this->db->where('countries.country_name',$country_name);
        $this->db->where('location_status','1');
        if($keyword != ""){
          if($keyword_lang == 'arabic')
          {
            $this->db->group_start();
            $this->db->like('location_name_ar',urldecode($keyword),array('restaurant','cafe','both'));
            $this->db->or_like('menu_name',urldecode($keyword));
            $this->db->group_end();

          }
          else
          {
            $this->db->group_start();
            $this->db->like('location_name',$keyword,array('restaurant','cafe','both'));
            $this->db->or_like('menu_name',urldecode($keyword));
            $this->db->group_end();

          }
        }

        $this->db->group_by('locations.location_id');
        $this->db->limit($next_offset,$page);
        // $this->db->having('distance < ',20);

        if($rating!=''){
           $this->db->where('location_ratings >=',$rating);
            $this->db->order_by('location_ratings','ASC');
        }else{
          if($distance_param == 'longest')
        {
          $this->db->order_by('distance','DESC');
        }
        else
        {
          $this->db->order_by('distance','ASC');
        }
        }
        $query = $this->db->get();
        return $query->num_rows();
  }

	public function findReservedLocation($date,$time,$location_id)
	{
		$this->db->select('reservation_id');
        $this->db->from('reservations');
        $this->db->where('location_id',$location_id);
        $this->db->where('reserve_date',$date);
        $this->db->where('reserve_time',$time);
		    $query = $this->db->get();
        if($query->num_rows() == 0)
        {
            return 0;
        }
        else
        {
           	return $query->result_array();
        }

	}

	public function getReviews($location_id)
	{
		$this->db->select('reviews.review_id,customers.first_name,reviews.date_added,reviews.quality,reviews.service,reviews.review_text,reviews.date_added,reviews.location_id');
        $this->db->from('reviews');
        $this->db->join('customers', 'customers.customer_id = reviews.customer_id');
		$this->db->where('reviews.location_id',$location_id);
    $this->db->where('review_status',1);
		$query = $this->db->get();
		if(!$query->num_rows())
           {
               return 0;
           }
           else
           {
           	 $result = array();
           	 $i=0;
           	 foreach ($query->result_array() as $row) {
           	 	$overall = round(($row['quality'] + $row['service']) / 2,1);
				$data[$i] = $row;
				$data[$i]['overall'] = "$overall";
				$data[$i]['date_added'] = date('d M,y',strtotime($row['date_added']));
			 	$i++;
			 }

			 return $data;

          }

	}

	public function getTables($location_id)
	{
		$this->db->select('tables.table_id,tables.table_name,tables.min_capacity,tables.max_capacity,tables.table_status');
        $this->db->from('location_tables');
        $this->db->join('tables', 'tables.table_id = location_tables.table_id');
		$this->db->where('location_tables.location_id',$location_id);
		$query = $this->db->get();
		if(!$query->num_rows())
           {
               return array();
           }
           else
           {
           	 return $query->result_array();

          }

	}

  public function getOrderHistory($customer_id,$status,$page='',$order_id='',$reservation_id='')
  {


    if($order_id!=''){
          $this->db->select('orders.*,statuses.*,reservations.reservation_id');
          $this->db->from('orders');
          $this->db->join('reservations', 'reservations.order_id = orders.order_id','LEFT');
          $this->db->join('statuses', 'statuses.status_code = orders.status_id');
          $this->db->where('orders.customer_id',$customer_id);
          $this->db->where('orders.order_id',$order_id);
    }
    if($reservation_id!=''){
          $this->db->select('statuses.*,reservations.reservation_id');
          $this->db->from('reservations');
          $this->db->join('statuses', 'statuses.status_code = reservations.status');
          $this->db->where('reservations.customer_id',$customer_id);
          $this->db->where('reservations.reservation_id',$reservation_id);
    }
    if($status != "all"){
      $this->db->where('status_name',ucfirst($status));
      if($reservation_id!=''){
        $this->db->where('status_for','reserve');
      }
      if($order_id!=''){
        $this->db->where('status_for','order');
      }
    }
    if($page != ''){
      $this->db->limit(10,$page);
    }
    $query = $this->db->get();

    if(!$query->num_rows())
    {
      return array();
    }
    else
    {
      return $query->result_array();

    }

  }

  public function getReservationHistory($customer_id,$status,$page='')
  {

    $this->db->from('reservations');
    $this->db->join('statuses', 'statuses.status_id = reservations.status');
    $this->db->where('customer_id',$customer_id);
    if($status != "all"){
      $this->db->where('status_name',ucfirst($status));
      $this->db->where('status_for','reserve');
    }
     $this->db->group_by('reservation_id');
     $this->db->order_by('id','desc');
    if($page != ''){
      $this->db->limit(10,$page);
    }
    $query = $this->db->get();

    if(!$query->num_rows())
    {
      return array();
    }
    else
    {
      return $query->result_array();

    }

  }

  public function getminimumprice($location_id)
  {

    $query_sel = "select menu.menu_id,menu.menu_price,options.menu_option_value_id,options.new_price,(IF((menu.menu_price + options.new_price is NULL), menu.menu_price , menu.menu_price + options.new_price)) as min from yvdnsddqu_menus as menu left join yvdnsddqu_menu_option_values as options on menu.menu_id = options.menu_id where menu.location_id='".$location_id."' order by min asc limit 1";
    $query = $this->db->query($query_sel);

    $result = $query->result_array();
    return $result[0]['min'];
  }

  public function getReservationDetails($order_id){
    $this->db->select('reservations.location_id,reservations.booking_price,reservations.guest_num,reservations.reservation_id,reservations.reserve_date,reservations.reserve_time,reservations.total_amount,orders.order_total,locations.location_name,locations.location_name_ar,orders.date_added,reservations.paid_status,statuses.status_name,locations.cancellation_period,locations.cancellation_charge,reservations.payment_method,reservations.order_id,orders.status_id as order_status,orders.order_total,reservations.review_status,locations.cancellation_time,orders.order_type');
    $this->db->from('reservations');
    $this->db->join('orders', 'orders.order_id = reservations.order_id','left');
    $this->db->join('statuses', 'statuses.status_code = reservations.status','left');
    $this->db->join('locations', 'locations.location_id = reservations.location_id','left');
    $this->db->where('reservations.reservation_id',$order_id);
    $this->db->group_by('reservations.reservation_id');
    $query = $this->db->get();
    $result = array();

    $result['reservation_id'] = $query->result_array()[0]['reservation_id'];
    $result['location_id'] = $query->result_array()[0]['location_id'];
    $result['location_name'] = $query->result_array()[0]['location_name'];
    if($query->result_array()[0]['location_name_ar'] == ""){
      $result['location_name_ar'] = $query->result_array()[0]['location_name'];
    }else{
      $result['location_name_ar'] = $query->result_array()[0]['location_name_ar'];
    }

    $result['order_date'] = date('d M, Y',strtotime($query->result_array()[0]['date_added']));
    $result['order_time'] = date('h:i a',strtotime($query->result_array()[0]['date_added']));
    $result['guest'] = $query->result_array()[0]['guest_num'];
    $result['total_tables'] = (string) $this->getTableCount($order_id);
    $result['date'] = date('d M, Y',strtotime($query->result_array()[0]['reserve_date']));
    $result['time'] = date('h:i a',strtotime($query->result_array()[0]['reserve_time']));
    $result['paid'] = $query->result_array()[0]['paid_status'];
    $result['status'] = $query->result_array()[0]['status_name'];
    $result['order_status'] = $this->getStatusName($query->result_array()[0]['order_status']);
    $result['payment_method'] = $query->result_array()[0]['payment_method'];

    $current_time = date("Y-m-d H:i:s");
    $reserve_time = date("Y-m-d H:i:s",strtotime($query->result_array()[0]['reserve_date'].' '.$query->result_array()[0]['reserve_time']));
    $cancel_time =  $query->result_array()[0]['cancellation_time']*60;
    if((strtotime($reserve_time) - $cancel_time) <= strtotime($current_time)){
       $result['show'] = "false";
    }else{
      $result['show'] = "true";
    }
    //$result['cancellation_period'] = $query->result_array()[0]['cancellation_period'];
    //$result['cancellation_charge'] = $query->result_array()[0]['cancellation_charge'];

    $result['total_amount']        = $query->result_array()[0]['total_amount'];
    $result['review_status']      = $query->result_array()[0]['review_status'];
    $result['table_amount']      = $query->result_array()[0]['booking_price'];

    $result['location_address_1']  = $query->result_array()[0]['location_address_1'];

    $result['location_address_2']  = $query->result_array()[0]['location_address_2'];

    $result['location_city']  = $query->result_array()[0]['location_city'];

    $result['location_state']  = $query->result_array()[0]['location_state'];

    $result['location_postcode']  = $query->result_array()[0]['location_postcode'];

    $result['order_type']  = $query->result_array()[0]['order_type'];

    $result['sub_total']        = $this->getSubTotal($query->result_array()[0]['order_id']);
    $result['vat']        = $this->getVat($query->result_array()[0]['order_id']);
    $result['coupon_code']= $this->getCouponCode($query->result_array()[0]['order_id']);
    $result['coupon_value']= $this->getCouponValue($query->result_array()[0]['order_id']);
    $result['vat_percentage']  = $this->getVat_perc($query->result_array()[0]['order_id']);
    $result['order_total']        = $query->result_array()[0]['order_total'];
    $result['order_id']        = $query->result_array()[0]['order_id'];
    $result['ordered_items'] = $this->getOrderItems($result['order_id']);
    $cancellation_explode = explode("-",str_replace(array('[',']','"'),'',$query->result_array()[0]['cancellation_period']));
    $cancellation_type = explode(",",$cancellation_explode[1]);
    $cancellation_duration = explode(",",$cancellation_explode[0]);
    $cancellation_charge  = explode(",",str_replace(array('[',']','"'),'',$query->result_array()[0]['cancellation_charge']));
    //$result['cancellation_policy'] = array();
    //print_r($cancellation_duration);exit;
    for($c = 0;$c < count($cancellation_charge);$c++)
    {
      $result['cancellation_policy'][$c]['type'] = trim($cancellation_type[$c]);
      $result['cancellation_policy'][$c]['duartion'] = trim($cancellation_duration[$c]);
      $result['cancellation_policy'][$c]['charge'] = trim($cancellation_charge[$c]);
    }
    return $result;

  }

  public function getReservationOrderDetails($order_id){
    $this->db->select('*','locations.location_id,reservations.booking_price,reservations.guest_num,reservations.reservation_id,reservations.reserve_date,reservations.reserve_time,reservations.total_amount,orders.order_id,orders.order_total,locations.location_name,locations.location_name_ar,orders.date_added,reservations.paid_status,statuses.status_name,locations.cancellation_period,locations.cancellation_charge,reservations.payment_method,reservations.order_id,orders.status_id as order_status,orders.order_total,reservations.review_status,locations.cancellation_time,orders.order_date,orders.order_time,orders.order_type');
    $this->db->from('orders');
    $this->db->join('reservations', 'reservations.order_id = orders.order_id','left');
    $this->db->join('statuses', 'statuses.status_id = orders.status_id','left');
    $this->db->join('locations', 'locations.location_id = orders.location_id','left');
    $this->db->where('orders.order_id',$order_id);
    // $this->db->group_by('reservations.reservation_id');
    $query = $this->db->get();

    $rating = $this->getReviewByOrder($order_id);

    $result = array();

    $result['reservation_id'] = $query->result_array()[0]['reservation_id'];
    $result['location_id'] = $query->result_array()[0]['location_id'];
    $result['location_name'] = $query->result_array()[0]['location_name'];
    if($query->result_array()[0]['location_name_ar'] == ""){
      $result['location_name_ar'] = $query->result_array()[0]['location_name'];
    }else{
      $result['location_name_ar'] = $query->result_array()[0]['location_name_ar'];
    }

    $result['order_date'] = date('d M, Y',strtotime($query->result_array()[0]['order_date']));
    $result['order_time'] = date('h:i a',strtotime($query->result_array()[0]['date_added']));
    $result['guest'] = $query->result_array()[0]['guest_num'];
    $result['total_tables'] = (string) $this->getTableCount($order_id);
    $result['date'] = date('d M, Y',strtotime($query->result_array()[0]['order_date']));
    $result['time'] = date('h:i a',strtotime($query->result_array()[0]['order_time']));
    $result['paid'] = $query->result_array()[0]['paid_status'];
    $result['status'] = $query->result_array()[0]['status_name'];
    $result['order_status'] = $this->getStatusName($query->result_array()[0]['order_status']);
    $result['payment_method'] = $query->result_array()[0]['payment'];

    $result['quality_rating']= $rating['quality'] ? $rating['quality'] : '0';
    $result['delivery_rating']= $rating['delivery'] ? $rating['delivery'] : '0';
    $result['service_rating'] = $rating['service'] ? $rating['service'] : '0' ;
    $result['review_text'] = $rating['review_text'] ? $rating['review_text'] : '';
    $result['review_status'] = $rating['review_status'];
     $result['order_type'] = $query->result_array()[0]['order_type'];

    $current_time = date("Y-m-d H:i:s");
    $reserve_time = date("Y-m-d H:i:s",strtotime($query->result_array()[0]['reserve_date'].' '.$query->result_array()[0]['reserve_time']));
    $cancel_time =  $query->result_array()[0]['cancellation_time']*60;
    if((strtotime($reserve_time) - $cancel_time) <= strtotime($current_time)){
       $result['show'] = "false";
    }else{
      $result['show'] = "true";
    }

    $result['total_amount']  = $query->result_array()[0]['total_amount'];
    //$result['review_status'] = $query->result_array()[0]['review_status'];
    $result['table_amount']  = $query->result_array()[0]['booking_price'];

    $result['location_address_1']  = $query->result_array()[0]['location_address_1'];

    $result['location_address_2']  = $query->result_array()[0]['location_address_2'];

    $result['location_city']  = $query->result_array()[0]['location_city'];

    $result['location_state']  = $query->result_array()[0]['location_state'];

    $result['location_telephone']  = $query->result_array()[0]['location_telephone'];

    $result['location_postcode']  = $query->result_array()[0]['location_postcode'];

    $result['sub_total']    = $this->getSubTotal($order_id);
    $result['vat']   = $this->getVat($order_id);
    $result['coupon_code']= $this->getCouponCode($order_id);
    $result['coupon_value']= $this->getCouponValue($order_id);
    $result['vat_percentage'] = $this->getVat_perc($order_id);
    $result['order_total']  = $query->result_array()[0]['order_total'];

    $tax = $result['order_total'] - $result['sub_total'];
    $result['tax_amount'] = (string) $tax;

    $result['order_id']   = $order_id;
    $result['ordered_items'] = $this->getOrderItems($result['order_id']);
    $cancellation_explode = explode("-",str_replace(array('[',']','"'),'',$query->result_array()[0]['cancellation_period']));
    $cancellation_type = explode(",",$cancellation_explode[1]);
    $cancellation_duration = explode(",",$cancellation_explode[0]);
    $cancellation_charge  = explode(",",str_replace(array('[',']','"'),'',$query->result_array()[0]['cancellation_charge']));

    for($c = 0;$c < count($cancellation_charge);$c++)
    {
      $result['cancellation_policy'][$c]['type'] = trim($cancellation_type[$c]);
      $result['cancellation_policy'][$c]['duartion'] = trim($cancellation_duration[$c]);
      $result['cancellation_policy'][$c]['charge'] = trim($cancellation_charge[$c]);
    }
    return $result;
  }

  public function getSubTotal($order_id){

     $this->db->from('order_totals');
     $this->db->where('order_id',$order_id);
     $this->db->where('code','cart_total');
     $query = $this->db->get();

     return $query->result_array()[0]['value'];

  }

  public function getVat($order_id){

     $this->db->from('order_totals');
     $this->db->where('order_id',$order_id);
     $this->db->where('code','taxes');
     $query = $this->db->get();

     return $query->result_array()[0]['value'];

  }

  public function getVat_perc($order_id){

     $this->db->from('order_totals');
     $this->db->where('order_id',$order_id);
     $this->db->where('code','taxes');
     $query = $this->db->get();
     return $query->result_array()[0]['title'];

  }

   public function getCouponCode($order_id){

     $this->db->from('order_totals');
     $this->db->where('order_id',$order_id);
     $this->db->where('code','coupon');
     $query = $this->db->get();

     if($query->result_array()[0]['title']){
        return $query->result_array()[0]['title'];
     }else{
        return "";
     }


  }

   public function getCouponValue($order_id){

     $this->db->from('order_totals');
     $this->db->where('order_id',$order_id);
     $this->db->where('code','coupon');
     $query = $this->db->get();

     if($query->result_array()[0]['value']){
        return $query->result_array()[0]['value'];
     }else{
        return "";
     }

  }

  public function getTableCount($order_id){

     $this->db->from('reservations');
     $this->db->where('reservation_id',$order_id);
     $query = $this->db->get();

     return $query->num_rows();
  }

  public function getStatusName($status_id){
     $this->db->select('status_name');
     $this->db->from('statuses');
     $this->db->where('status_id',$status_id);
     $query = $this->db->get();

     return $query->result_array()[0]['status_name'];
  }

  public function getOrderItems($order_id){
     $this->db->select('order_menus.*,menus.menu_price');
     $this->db->from('order_menus');
     $this->db->join('menus','menus.menu_id = order_menus.menu_id','left');
     $this->db->where('order_id',$order_id);
     $query = $this->db->get();
     if($query->num_rows() > 0){
      $data = $query->result_array();
      $i=0;
      foreach ($data as $key => $value) {
         $unseria_value = unserialize($value['option_values']);
         //print_r($unseria_value);
         $data[$i]['option_values'] = array();
         foreach($unseria_value as $ser_key => $ser_value)
          {
            //print_r($ser_value);
            $data[$i]['option_values'] = array_merge($data[$i]['option_values'],$ser_value);
            //$data[$i]['option_values'] = $ser_value;
          }
        $i++;
      }
      return $data;
    }else{
      return array();
    }

  }

    public function getOrderItems_new($order_id){
     $this->db->select('order_menus.*');
     $this->db->from('order_menus');
     // $this->db->join('menus','menus.menu_id = order_menus.menu_id','left');
     $this->db->where('order_id',$order_id);
     $query = $this->db->get();
     if($query->num_rows() > 0){
      $data = $query->result_array();
      $i=0;
      foreach ($data as $key => $value) {
         $unseria_value = unserialize($value['option_values']);
         //print_r($unseria_value);
         //$data[$i]['price'] = $data[$i]['price'];
         //$data[$i]['menu_price'] = $data[$i]['quantity'] * $data[$i]['price'];
         $data[$i]['menu_price'] = $data[$i]['price']; // Show Menu price + Option Price
         $data[$i]['price'] = $this->getMenuPrice($data[$i]['menu_id']);  // Show Menu Price
         $data[$i]['option_values'] = array();
         foreach($unseria_value as $ser_key => $ser_value)
          {
            //print_r($ser_value);
            $data[$i]['option_values'] = array_merge($data[$i]['option_values'],$ser_value);
            //$data[$i]['option_values'] = $ser_value;
          }
        $i++;
      }
      return $data;
    }else{
      return array();
    }

  }

  public function getMenuPrice($menu_id){
     $this->db->select('menu_price');
     $this->db->from('menus');
    $this->db->where('menu_id',$menu_id);
    $query = $this->db->get();
    $menu_price = $query->result_array()[0]['menu_price'];
    return $menu_price;
  }
	public function getCategories($parent = NULL,$added_by='',$location_id='') {

		$sql = "SELECT cat1.category_id, cat1.name,cat1.name_ar,cat1.description_ar, cat1.description, cat1.image, ";
		$sql .= "cat1.priority, cat1.status ";
		$sql .= "FROM {$this->db->dbprefix('categories')} AS cat1 ";
		$sql .= "LEFT JOIN {$this->db->dbprefix('menus')} AS menus ON menus.menu_category_id = cat1.category_id ";



		$sql .= "WHERE cat1.status = 1 ";

    $sql .= "AND menus.location_id = '".$location_id."' GROUP BY cat1.category_id";



		$query = $this->db->query($sql, $parent);

		$result = array();
    //print_r($query->result_array());exit;
		$i=0;
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$i] = $row;
        $unique_id = $row['category_id'];
        $result[$i]['name_ar'] = $result[$i]['name_ar']=="" ? $result[$i]['name'] : $result[$i]['name_ar'] ;


        $result[$i]['description_ar'] = $result[$i]['description_ar']=="" ? $result[$i]['description'] : $result[$i]['description_ar'] ;

				$result[$i]['menu_items'] = $this->getMenus($row['category_id'],$location_id,$unique_id);
				$i++;
			}
		}

		return $result;
	}

	public function getMenus($cat_id,$location_id,$unique_id='')
	{
		$this->db->select('*');
        $this->db->from('menus');
		$this->db->where('menu_category_id',$cat_id);
    $this->db->where('location_id',$location_id);
    //$this->db->where('menu_status = 1');
		$query = $this->db->get();
    $result = array();
		if(!$query->num_rows())
           {
               return array();
           }
           else
           {
             $i=0;
           	 foreach($query->result_array() as $row){
                $result[$i] = $row;
                //$result[$i]['menu_price'] = $result[$i]['menu_price']=="0.0000" ? $this->getOptionValuePrice($result[$i]['menu_id']) : $result[$i]['menu_price'] ;

                if($result[$i]['menu_price'] > 0){
                  $pric = number_format($result[$i]['menu_price'],2);
                } else {
                  $result[$i]['unique_id'] = $unique_id.$row['menu_id'];
                  $result[$i]['explode_id'] = $unique_id.'-'.$row['menu_id'];
                  $options = $this->getMenusOptions($row['menu_id'],$result[$i]['unique_id'],$result[$i]['explode_id']);
                  if(!empty($options) && !empty($options[0]['option_values'])){
                    $pric = number_format($options[0]['option_values'][0]['price'],2);
                  } else {
                    $pric = '0.00';
                  }
                }
                $result[$i]['qty'] = 0;
                $result[$i]['menu_price'] = number_format($result[$i]['menu_price'],2);
                $result[$i]['first_option_price'] = $pric;
                $result[$i]['unique_id'] = $unique_id.$row['menu_id'];
                $result[$i]['explode_id'] = $unique_id.'-'.$row['menu_id'];
                $result[$i]['menu_name_ar'] = $result[$i]['menu_name_ar']=="" ? $result[$i]['menu_name'] : $result[$i]['menu_name_ar'] ;
                $result[$i]['menu_description_ar'] = $result[$i]['menu_description_ar']=="" ? $result[$i]['menu_description'] : $result[$i]['menu_description_ar'] ;
                $result[$i]['menus_options'] = $this->getMenusOptions($row['menu_id'],$result[$i]['unique_id'],$result[$i]['explode_id']);
                $result[$i]['menus_variants'] = $this->getMenusVariants($row['menu_id'],$location_id);

                $i++;
             }

             return $result;

          }

	}

  public function getOptionValuePrice($menu_id){

      $this->db->select('option_id');
      $this->db->from('menu_options');
      $this->db->where('menu_id',$menu_id);
      $query = $this->db->get();
      $option_id = $query->result_array()[0]['option_id'];
      if($query->num_rows() > 0)
      {
        $this->db->select('new_price');
        $this->db->from('menu_option_values');
        $this->db->where('option_id',$option_id);
        $this->db->where('menu_id',$menu_id);
        $query = $this->db->get();
        return $query->result_array()[0]['new_price'];

      }else{
        return "0.0000";
      }

  }

  public function getMenusOptions($id,$unique_id='',$explode_id='')
  {
    $this->db->select('*');
    $this->db->from('menu_options');
    $this->db->where('menu_id',$id);
    $query = $this->db->get();
    $result = array();
    if(!$query->num_rows())
    {
      return array();
    }
    else
    {

       foreach ($query->result_array() as $key => $value) {

         $unique_id = $unique_id.$value['option_id'];
         $explode_id = $explode_id.'-'.$value['option_id'];
         //$result[$key] = $value;
         $result[$key]['menu_option_id'] = $value['menu_option_id'];
         $result[$key]['unique_id'] = $unique_id;
         $result[$key]['explode_id'] = $explode_id;
         $result[$key]['menu_id'] = $value['menu_id'];
         $result[$key]['required'] = $value['required'];
         $option_details = $this->getOptionDetails($value['option_id']);
         if(!empty($option_details)){
           $result[$key]['option_name'] = $option_details[0]['option_name'];
           $result[$key]['option_name_ar'] = $option_details[0]['option_name'];
           $result[$key]['display_type'] = $option_details[0]['display_type'];
           $result[$key]['priority'] = $option_details[0]['priority'];
           $result[$key]['added_by'] = $option_details[0]['added_by'];
         }else{
           $result[$key]['option_name'] = "";
           $result[$key]['option_name_ar'] = "";
           $result[$key]['display_type'] = "";
           $result[$key]['priority'] = 0;
           $result[$key]['added_by'] = 0;
         }

         //$result[$key]['option_details'] = $option_details;
         $data = unserialize($value['option_values']);
         $i=0;
         $options = array();
         foreach ($data as $value1) {

          $value1['price'] = number_format($value1['price'],2);
          $options[$i] = $value1;
           $options[$i]['menu_option_id'] = $value['menu_option_id'];
           $options[$i]['unique_id'] = $unique_id.$value1['option_value_id'];
           $options[$i]['explode_id'] = $explode_id.'-'.$value1['option_value_id'];
           $options[$i]['menu_id'] = $value['menu_id'];
           $options[$i]['option_value_name'] = $this->getOptionValueName($value1['option_value_id']);
            $options[$i]['option_value_name_ar'] = $this->getOptionValueName($value1['option_value_id']);
           $i++;
         }
         $result[$key]['option_values'] = $options;
       }

       return $result;
    }

  }

  public function getMenusVariants($id = '', $location_id = '')
  {
    $this->db->select('*');
    $this->db->from('menu_variant_types');
    $this->db->where('menu_id',$id);
    $this->db->where('location_id',$location_id);
    $query = $this->db->get();
    $result = array();
    if(!$query->num_rows())
    {
      return array();
    }
    else
    {

       foreach ($query->result_array() as $key => $value) {
         //$result[$key] = $value;
         $result[$key]['menu_variant_type_id'] = $value['menu_variant_type_id'];
         $result[$key]['menu_id'] = $value['menu_id'];
         $result[$key]['variant_type_name'] = $value['variant_type_name'];
         $result[$key]['location_id'] = $value['location_id'];
         $result[$key]['status'] = $value['status'];

         $option_details = $this->getVariantTypesValues($value['menu_variant_type_id']);         
         $i=0;
         $options = array();
         foreach ($option_details as $value1) 
         {
           $options[$i]['menu_variant_type_value_id'] = $value1['menu_variant_type_value_id'];
           $options[$i]['type_value_name'] = $value1['type_value_name'];
           $options[$i]['type_value_price'] = number_format($value1['type_value_price'],2);
           $options[$i]['is_default'] = $value1['is_default'];
           $options[$i]['status'] = $value1['status'];
           $i++;
         }
         $result[$key]['variant_values'] = $options;
       }

       return $result;
    }

  }


  public function getOptionValueName($id){

    $this->db->select('value');
    $this->db->from('option_values');
    $this->db->where('option_value_id',$id);
    $query = $this->db->get();
    return $query->result_array()[0]['value'];
  }
  public function getOptionValues($order_id,$order_menu_id,$qty){

    $this->db->select('*');
    $this->db->from('order_options');
    $this->db->where('order_id',$order_id);
    $this->db->where('order_menu_id',$order_menu_id);
    $query = $this->db->get();
    $result = array();
    foreach($query->result_array() as $key => $value){
      $result[$key] = $value;
      $result[$key]['order_option_qty_price'] = $value['order_option_price'] * $qty;
    }
    return $result;
  }
  public function getOptionDetails($id){

    $this->db->select('*');
    $this->db->from('options');
    $this->db->where('option_id',$id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getVariantTypesValues($id = ''){

    $this->db->select('*');
    $this->db->from('menu_variant_type_values');
    $this->db->where('menu_variant_type_id',$id);
    $this->db->where('status','1');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getFeedback()
  {
		$this->db->select('data,status');
        $this->db->from('extensions');
		$this->db->where('name','feedback_module');
		$query = $this->db->get();
		$result = array();
		if(!$query->num_rows())
           {
               return "";
           }
           else
           {
           	 $result['data'] = $query->result_array()[0]['data'];
           	 $result['status'] = $query->result_array()[0]['status'];
           	 return $result;

          }

	}

	public function getQualityRating($location_id)
	{
		$this->db->select('AVG(quality) quality');
        $this->db->from('reviews');
        $this->db->join('customers', 'customers.customer_id = reviews.customer_id');
		$this->db->where('location_id',$location_id);
    $this->db->where('review_status', 1);
		$query = $this->db->get();
		if(!$query->num_rows())
           {
               return 0;
           }
           else
           {
           	 return $query->result_array()[0]['quality'];

          }

	}

	public function getServiceRating($location_id)
	{
		$this->db->select('AVG(service) service');
        $this->db->from('reviews');
        $this->db->join('customers', 'customers.customer_id = reviews.customer_id');
		$this->db->where('location_id',$location_id);
    $this->db->where('review_status', 1);
		$query = $this->db->get();
		if(!$query->num_rows())
           {
               return 0;
           }
           else
           {
           	 return $query->result_array()[0]['service'];

          }

	}

	public function getOverallCount($location_type,$lat,$lan,$rating)
	{

		$this->db->select('*');
        $this->db->from('locations');
        $this->db->join('countries', 'countries.country_id = locations.location_country_id');
        if($location_type != "both"){
        	$this->db->where('location_type',$location_type);
        }
		$query = $this->db->get();

		if(!$query->num_rows())
        {
               return 0;
        }
        $count = 0;
        foreach($query->result_array() as $value){
        	if($this->distance($value['location_lat'],$value['location_lng'],$lat,$lan,'km') <= 20 && $this->getOverallRating($value['location_id']) <= $rating){
        		$count++;
        	}
        }
        return $count;
	}

	function getOverallRating($location_id) {
 		$quality = round($this->getQualityRating($location_id),2);
 		$service = round($this->getServiceRating($location_id),2);
 		return round(($quality + $service) / 2,1);
    }

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

	public function getReview($location_id)
	{
		  $this->db->select('quality');
           $this->db->from('reviews');
           $this->db->where('location_id',$location_id);
           $this->db->limit(10);
		$query = $this->db->get();
		if(!$query->num_rows())
           {
               return 0;
           }
           else
           {
           	 return $query->result_array();

          }

	}

	public function getNearByRestaurants2($restaurant_type,$page) {

                $query = $this->db->query("SELECT * FROM `tyehnd0gd_locations` WHERE `restaurant_type`='$restaurant_type' LIMIT $page ");

                if ($query->num_rows() > 0) {

                	foreach ($query->result_array() as $loc_id=>$location) {
						$location_id = $location['location_id'];
		                $query1 = $this->db->query("SELECT * FROM `tyehnd0gd_reviews` WHERE `location_id`='$location_id'");

				return $query1->result_array();

	        }
	    }else{

        	return 0;

        }
        return $result;
    }

  public function changeNotificationStatus($customer_id,$notification_status) {

    $this->db->set('notification_status', $notification_status);
    $this->db->where('customer_id', $customer_id);
    $query = $this->db->update('customers');
    return $query;
  }

	public function addOrder($order_info = array(), $cart_contents = array()) {
        if (empty($order_info) OR empty($cart_contents)) return FALSE;

        if (isset($order_info['location_id'])) {
            $this->db->set('location_id', $order_info['location_id']);
        }

        if (isset($order_info['customer_id'])) {
            $this->db->set('customer_id', $order_info['customer_id']);
        } else {
            $this->db->set('customer_id', '0');
        }

        if (isset($order_info['first_name'])) {
            $this->db->set('first_name', $order_info['first_name']);
        }

        if (isset($order_info['last_name'])) {
            $this->db->set('last_name', $order_info['last_name']);
        }

        if (isset($order_info['email'])) {
            $this->db->set('email', $order_info['email']);
        }

        if (isset($order_info['telephone'])) {
            $this->db->set('telephone', $order_info['telephone']);
        }

        if (isset($order_info['order_type'])) {
            $this->db->set('order_type', $order_info['order_type']);
        }

        if (isset($order_info['order_time'])) {
            $current_time = time();
            $order_time = (strtotime($order_info['order_time']) < strtotime($current_time)) ? $current_time : $order_info['order_time'];
            $this->db->set('order_time', mdate('%H:%i', strtotime($order_time)));
            $this->db->set('order_date', mdate('%Y-%m-%d', strtotime($order_time)));
            $this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $current_time));
            $this->db->set('date_modified', mdate('%Y-%m-%d', $current_time));
            $this->db->set('ip_address', $this->input->ip_address());
            $this->db->set('user_agent', $this->input->user_agent());
        }

        if (isset($order_info['address_id'])) {
            $this->db->set('address_id', $order_info['address_id']);
        }

        if (isset($order_info['payment'])) {
            $this->db->set('payment', $order_info['payment']);
        }

        if (isset($order_info['comment'])) {
            $this->db->set('comment', $order_info['comment']);
        }

        if (isset($cart_contents['order_total'])) {
            $this->db->set('order_total', $cart_contents['order_total']);
        }

        if (isset($cart_contents['total_items'])) {
            $this->db->set('total_items', $cart_contents['total_items']);
        }

        if ( ! empty($order_info)) {
            if (isset($order_info['order_id'])) {
                $_action = 'updated';
                $this->db->where('order_id', $order_info['order_id']);
                $query = $this->db->update('orders');
                $order_id = $order_info['order_id'];
            } else {
                $_action = 'added';
                $query = $this->db->insert('orders');
                $order_id = $this->db->insert_id();
            }

            if ($query AND $order_id) {
                if (isset($order_info['address_id'])) {
                    $this->load->model('Addresses_model');
                    $this->Addresses_model->updateDefault($order_info['customer_id'], $order_info['address_id']);
                }

                $this->addOrderMenus($order_id, $cart_contents);

                $this->addOrderTotals($order_id, $cart_contents);

                if ( ! empty($cart_contents['coupon'])) {
                    $this->addOrderCoupon($order_id, $order_info['customer_id'], $cart_contents['coupon']);
                }

                return $order_id;
            }
        }
    }

    public function addOrderMenus($order_id, $cart_contents = array()) {
        if (is_array($cart_contents) AND ! empty($cart_contents) AND $order_id) {
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_menus');

            foreach ($cart_contents as $key => $item) {
                if (is_array($item) AND isset($item['rowid']) AND $key === $item['rowid']) {

                    if (isset($item['id'])) {
                        $this->db->set('menu_id', $item['id']);
                    }

                    if (isset($item['name'])) {
                        $this->db->set('name', $item['name']);
                    }

                    if (isset($item['qty'])) {
                        $this->db->set('quantity', $item['qty']);
                    }

                    if (isset($item['price'])) {
                        $this->db->set('price', $item['price']);
                    }

                    if (isset($item['subtotal'])) {
                        $this->db->set('subtotal', $item['subtotal']);
                    }

                    if (isset($item['comment'])) {
                        $this->db->set('comment', $item['comment']);
                    }

                    if ( ! empty($item['options'])) {
                        $this->db->set('option_values', serialize($item['options']));
                    }

                    $this->db->set('order_id', $order_id);

                    if ($query = $this->db->insert('order_menus')) {
                        $order_menu_id = $this->db->insert_id();

                        if ( ! empty($item['options'])) {
                            $this->addOrderMenuOptions($order_menu_id, $order_id, $item['id'], $item['options']);
                        }
                    }
                }
            }

            return TRUE;
        }
    }

    public function addOrderTotals($order_id, $cart_contents) {
        if (is_numeric($order_id) AND ! empty($cart_contents['totals'])) {
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_totals');

            $this->load->model('cart_module/Cart_model');
            $order_totals = $this->Cart_model->getTotals();

            $cart_contents['totals']['cart_total']['amount'] = (isset($cart_contents['cart_total'])) ? $cart_contents['cart_total'] : '';
            $cart_contents['totals']['order_total']['amount'] = (isset($cart_contents['order_total'])) ? $cart_contents['order_total'] : '';

            foreach ($cart_contents['totals'] as $name => $total) {
                foreach ($order_totals as $total_name => $order_total) {
                    if ($name === $total_name AND is_numeric($total['amount'])) {
                        $total['title'] = empty($total['title']) ? $order_total['title'] : $total['title'];

                        if (isset($total['code'])) {
                            $total['title'] = str_replace('{coupon}', $total['code'], $total['title']);
                        } else if (isset($total['tax'])) {
                            $total['title'] = str_replace('{tax}', $total['tax'], $total['title']);
                        }

                        $this->db->set('order_id', $order_id);
                        $this->db->set('code', $name);
                        $this->db->set('title', htmlspecialchars($total['title']));
                        $this->db->set('priority', $order_total['priority']);

                        if ($name === 'coupon') {
                            $this->db->set('value', 0 - $total['amount']);
                        } else {
                            $this->db->set('value', $total['amount']);
                        }

                        $this->db->insert('order_totals');
                    }
                }
            }

            return TRUE;
        }
    }

    public function addOrderMenuOptions($order_menu_id, $order_id, $menu_id, $menu_options) {
        if ( ! empty($order_id) AND ! empty($menu_id) AND ! empty($menu_options)) {
            $this->db->where('order_menu_id', $order_menu_id);
            $this->db->where('order_id', $order_id);
            $this->db->where('menu_id', $menu_id);
            $this->db->delete('order_options');

            foreach ($menu_options as $menu_option_id => $options) {
                foreach ($options as $option) {
                    $this->db->set('order_menu_option_id', $menu_option_id);
                    $this->db->set('order_menu_id', $order_menu_id);
                    $this->db->set('order_id', $order_id);
                    $this->db->set('menu_id', $menu_id);
                    $this->db->set('menu_option_value_id', $option['value_id']);
                    $this->db->set('order_option_name', $option['value_name']);
                    $this->db->set('order_option_price', $option['value_price']);

                    $this->db->insert('order_options');
                }
            }
        }
    }


    public function getNearByRestaurants($restaurant_type,$page){
		$page = $page * 10;
		$query_sel = "SELECT `l`.`location_name`,`l`.`location_id`,`l`.`description`,`l`.`location_image`,`l`.`location_lat`,`l`.`location_lng`,`r`.`quality` FROM tyehnd0gd_locations as l INNER JOIN tyehnd0gd_reviews as r ON l.location_id=r.location_id WHERE `restaurant_type` = '$restaurant_type' LIMIT $page,10 ";

		$query = $this->db->query($query_sel);

		 return $query->result_array();

			/*if($query->num_rows() >0){
				foreach ($query->result_array() as $locat => $location){
					$quality = $location['quality'];

				}
			}*/

    }


    public function getNearByRestaurants5($restaurant_type,$page){
		$page = $page * 10;
		$query_sel = "SELECT `l`.`location_name`,`l`.`location_id`,`l`.`description`,`l`.`location_image`,`l`.`location_lat`,`l`.`location_lng`,`r`.`quality` FROM tyehnd0gd_locations as l INNER JOIN tyehnd0gd_reviews as r ON l.location_id=r.location_id WHERE `restaurant_type` = '$restaurant_type' LIMIT $page,10 ";

		$query = $this->db->query($query_sel);

		 return $query->result_array();

			/*if($query->num_rows() >0){
				foreach ($query->result_array() as $locat => $location){
					$quality = $location['quality'];

				}
			}*/

    }

    public function insertFeedback($user_id,$location_id,$feedback_type,$feedback_message){
    	 $data = array(
        	'user_id'=>$user_id,
        	'location_id'=>$location_id,
        	'feedback_type'=>$feedback_type,
        	'feedback_message'=>$feedback_message,
    	);

    	$this->db->insert('feedback',$data);
      $this->load->helper('logactivity');
       log_activity($user_id, 'feedback', 'feedback','New <a href="'.site_url().'admin/feedback"><b>Feedback</b></a>');

    	return TRUE;
    }

    public function saveReview($save = array()) {

      if (empty($save)) return FALSE;

      if (isset($save['sale_type'])) {
        $this->db->set('sale_type', $save['sale_type']);
      }

      if (isset($save['sale_id'])) {
        $this->db->set('sale_id', $save['sale_id']);
      }

      if (isset($save['location_id'])) {
        $this->db->set('location_id', $save['location_id']);
      }

      if (isset($save['customer_id'])) {
        $this->db->set('customer_id', $save['customer_id']);
      }

      if (isset($save['author'])) {
        $this->db->set('author', $save['author']);
      }

      if (isset($save['rating'])) {
        if (isset($save['rating']['quality'])) {
          $this->db->set('quality', $save['rating']['quality']);
        }

        if (isset($save['rating']['delivery'])) {
          $this->db->set('delivery', $save['rating']['delivery']);
        }

        if (isset($save['rating']['service'])) {
          $this->db->set('service', $save['rating']['service']);
        }
      }

      if (isset($save['review_text'])) {
        $this->db->set('review_text', $save['review_text']);
      }


        $this->db->set('review_status', '0');


        $this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
        $query = $this->db->insert('reviews');
        $review_id = $this->db->insert_id();
        $this->load->helper('logactivity');
        log_activity($save['customer_id'], 'review', 'review','<b>Review has been added</b> <a href="'.site_url().'admin/reviews/edit?id='.$review_id.'"><b>#'.$review_id.'.</b></a>');
        $this->db->set('review_status', 1);
        $this->db->where('reservation_id', $save['sale_id']);
        $this->db->update('reservations');






      return $review_id;
    }

    public function getPaymentDetails($location_id)
    {
        $this->db->select('staffs.payment_details');
    $this->db->from('staffs');
    $this->db->join('locations', 'locations.added_by = staffs.staff_id');
    $this->db->where('locations.location_id',$location_id);
    $query = $this->db->get();

    if(!$query->num_rows())
           {
               return array();
           }
           else
           {
            $result = unserialize($query->result_array()[0]['payment_details']);
            //$result['payment_private_key'] = $result['payment_publishable_key'];
            return $result;
          }
    }

    public function updateOverallReview($location_id) {

      $this->db->select('AVG(quality) q,AVG(service) s');
      $this->db->where('location_id', $location_id);
      $result=$this->db->get('reviews')->row();
      $overall = round(($result->q + $result->s) / 2,1);

      if($overall >= 0){
        $this->db->set('location_ratings', $overall);
        $this->db->where('location_id', $location_id);
        $this->db->update('locations');
      }

      return TRUE;
      exit;

    }

  public function sendMessage($template_id,$player_id){
    /*$content = array(
      "template_id" => "97b86275-1376-4982-9c24-488b08e69867"
      );*/

    $fields = array(
      'app_id' => "5cbfa8e1-656b-4616-aa00-2d26b9759690",
      //'included_segments' => array('All'),
      'include_player_ids' => array($player_id),
            'data' => array("foo" => "bar"),
      //'contents' => $content
      "template_id" => $template_id
    );

    $fields = json_encode($fields);
    //print("\nJSON sent:\n");
    //print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                           'Authorization: Basic YWIxMDc2ZjgtZTkxMS00YjRmLTkwNDEtNDZhYjMxN2Y3NTZk'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }
  public function getVendorId($location_id) {

    $this->db->select('added_by');
    $this->db->from('locations');
    $this->db->where('location_id', $location_id);
    $query=$this->db->get();
    return $query->result_array()[0]['added_by'];
    exit;

  }
  public function validateCoupon($code = '',$vendor_id,$total_amount,$customer_id) {
        $error = '';
        $coupon = $this->checkCoupon($code,$vendor_id);

        if ($code === NULL) {
            return TRUE;
        } else if (empty($code) || $coupon == "Invalid Coupon" ) {
            $error = "Invalid Coupon";           // display error message
        } else if (!$coupon && $coupon != "Invalid Coupon") {
            $error = "Coupon Expired";               // display error message
        } else {
            /*if (!empty($coupon['order_restriction'])) {
                $order_type = ($coupon['order_restriction'] === '1') ? $this->CI->lang->line('text_delivery') : $this->CI->lang->line('text_collection');
                $error = sprintf($this->CI->lang->line('alert_coupon_order_restriction'), strtolower($order_type));
            }*/

            if ($coupon['min_total'] > $total_amount) {
                $error = "Your coupon can not be applied to orders below ".$coupon['min_total'];
            }

            $used = $this->checkCouponHistory($coupon['coupon_id']);

            if (!empty($coupon['redemptions']) AND ($coupon['redemptions']) <= ($used)) {
                $error = "Maximum number of redemption for the coupon has been reached.";
            }

            if ($coupon['customer_redemptions'] === '1' AND $customer_id) {

                $customer_used = $this->checkCustomerCouponHistory($coupon['coupon_id'], $customer_id);

                if ($coupon['customer_redemptions'] <= $customer_used) {
                    $error = "Maximum number of redemption for the coupon has been reached.";
                }
            }

            /*if ($error === '') {
                $this->CI->cart->add_coupon(array('code' => $coupon['code'], 'type' => $coupon['type'], 'discount' => $coupon['discount']));
                return TRUE;
            }*/
        }

        /*if (!empty($code)) {
            $this->CI->cart->remove_coupon($code);
        }*/

        return $error;
    }

    public function checkCustomerCouponHistory($coupon_id, $customer_id) {
        if (!empty($coupon_id)) {
            $this->db->where('coupon_id', $coupon_id);
            $this->db->where('customer_id', $customer_id);
            $this->db->where('status', '1');
            $this->db->from('coupons_history');

            return $this->db->count_all_results();
        }
    }

    public function checkCouponHistory($coupon_id) {
        if (!empty($coupon_id)) {
            $this->db->where('coupon_id', $coupon_id);
            $this->db->where('status', '1');
            $this->db->from('coupons_history');

            return $this->db->count_all_results();
        }
    }

    public function checkCoupon($code,$vendor_id) {
        $result = FALSE;

        if (!empty($code)) {
            $this->db->from('coupons');
            $this->db->where('code', $code)->where("(added_by='$vendor_id' OR added_by='11')");
            $this->db->where('status', '1');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                if ($row['validity'] === 'forever') {
                    $result = $row;
                } else if ($row['validity'] === 'fixed') {
                    $fixed_date = mdate('%Y-%m-%d', strtotime($row['fixed_date']));
                    $fixed_from_time = mdate('%H:%i', strtotime($row['fixed_from_time']));
                    $fixed_to_time = mdate('%H:%i', strtotime($row['fixed_to_time']));
                    $current_date = mdate('%Y-%m-%d', time());
                    $current_time = mdate('%H:%i', time());

                    if ($fixed_date === $current_date AND ($fixed_from_time <= $current_time AND $fixed_to_time >= $current_time)) {
                        $result = $row;
                    }
                } else if ($row['validity'] === 'period') {
                    $period_start_date = mdate('%Y-%m-%d', strtotime($row['period_start_date']));
                    $period_end_date = mdate('%Y-%m-%d', strtotime($row['period_end_date']));
                    $current_date = mdate('%Y-%m-%d', time());

                    if ($period_start_date <= $current_date AND $period_end_date >= $current_date) {
                        $result = $row;
                    }
                } else if ($row['validity'] === 'recurring') {
                    $weekdays = array_flip(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'));
                    $current_day = date('l');
                    $weekday = $weekdays[$current_day];
                    $recurring_every = explode(', ', $row['recurring_every']);
                    $recurring_from_time = mdate('%H:%i', strtotime($row['recurring_from_time']));
                    $recurring_to_time = mdate('%H:%i', strtotime($row['recurring_to_time']));
                    $current_time = mdate('%H:%i', time());

                    if (in_array($weekday, $recurring_every) AND ($recurring_from_time <= $current_time AND $recurring_to_time >= $current_time)) {
                        $result = $row;
                    }
                }
            }
            else
            {
              $result = "Invalid Coupon";
            }

        }

        return $result;
    }

    public function getCouponDetails($coupon,$vendor_id){

       $this->db->select('*');
       $this->db->from('coupons');
       $this->db->where('code', $coupon);
       $this->db->where("(added_by='$vendor_id' OR added_by='11')");
       $query=$this->db->get();
       return $query->result_array()[0];
    }

    public function getReviewByOrder($order_id){
       $this->db->select('*');
       $this->db->from('reviews');
       $this->db->where('sale_id', $order_id);
       $query=$this->db->get();
       return $query->result_array()[0];
    }

    public function getRestaurantOrderHistory($location_id = '',$customer_id = '', $status = ''){
      if($location_id){
        $this->db->select('orders.*,statuses.*,customers.email,customers.telephone,customers.first_name,customers.last_name');
        $this->db->from('orders');
        $this->db->join('statuses', 'statuses.status_code = orders.status_id');
        $this->db->join('customers', 'customers.customer_id = orders.customer_id');

        // if(!empty($location_id) && is_numeric($location_id)){
          $this->db->where('orders.location_id',$location_id);
        // }
        if(!empty($customer_id) && is_numeric($customer_id)){
          $this->db->where('orders.customer_id',$customer_id);
        }
        if(!empty($status)){
          if(strtolower(trim($status)) == 'completed'){
            $this->db->where('orders.status_id IN (0,20)');
          } else if(strtolower(trim($status)) == 'pending'){
            $this->db->where('orders.status_id NOT IN (0,20)');
          }          
        }
        // $this->db->group_by('order_menus.order_id');
        $this->db->order_by('date_added','desc');

        $query = $this->db->get();
        $result = array();
        if(!$query->num_rows())
        {
          return array();
        }else{
          $i = 0;
          foreach ($query->result_array() as $key => $value) {
            if(floatval($value['coupon_discount']) > 0){
              $discounted_total = floatval($value['order_total']) - floatval($value['coupon_discount']);
              $value['order_total'] = sprintf("%.2f", $discounted_total);
            }
            $this->db->select('order_menus.*,menus.*');
            $this->db->from('order_menus');
            $this->db->join('menus', 'menus.menu_id = order_menus.menu_id');
            $this->db->where('order_menus.order_id',$value['order_id']);
            $query=$this->db->get();
            $menuItems = $query->result_array();                      

            if(!empty($menuItems))
            {
              foreach ($menuItems as $key_menuItems => $value_menuItems)
              {
                /*
                * Order menus
                */
                $this->db->select('order_options.menu_id,order_options.menu_option_value_id, order_options.menu_option_value_id as option_value_id, order_options.order_menu_option_id as menu_option_id, order_options.menu_option_value_id as option_value_id, "Add Ons" as option_name, order_options.order_option_name as option_value_name,order_options.order_option_price as price');
                $this->db->from('order_options');
                $this->db->join('order_menus', 'order_options.order_menu_id = order_menus.order_menu_id');
                $this->db->where('order_options.order_menu_id',$value_menuItems['order_menu_id']);
                $this->db->where('order_options.order_id',$value_menuItems['order_id']);
                $orderquery   = $this->db->get();
                if($orderquery->num_rows()){
                  $orderOptions = $orderquery->result_array();
                  $menuItems[$key_menuItems]['menu_options'] = $orderOptions;
                }
                /*
                * Order variants
                */
                $this->db->select('order_variants.variant_type_id, order_variants.variant_type_value_id, order_variants.variant_type_name as variant_type, order_variants.variant_type_value_name as variant_type_value ,order_variants.price');
                $this->db->from('order_variants');
                $this->db->join('order_menus', 'order_variants.order_menu_id = order_menus.order_menu_id');
                $this->db->where('order_variants.order_menu_id',$value_menuItems['order_menu_id']);
                $this->db->where('order_variants.order_id',$value_menuItems['order_id']);
                $orderquery   = $this->db->get();
                if($orderquery->num_rows()){
                  $orderVariants = $orderquery->result_array();
                  $menuItems[$key_menuItems]['menu_variants'] = $orderVariants;
                }
              }
            }
            $result[$i]=$value;
            $result[$i]['menuItems'] = $menuItems;
            $i++;
          }
        }
        return $result;

      }else{
        return [];
      }

    }
    public function updateOrderStatusById($order_id,$status){
      if($order_id){
        $query = FALSE;
        $this->db->set('status_id', $status);
        $this->db->set('date_modified', mdate('%Y-%m-%d', time()));
        $this->db->set('invoice_date', date('Y-m-d H:i:s'));
        $this->db->where('order_id', $order_id);
        $query = $this->db->update('orders');
        if ($query === TRUE) {
          $query = true;
        }
       return $query;
      }
    }
    public function getOrderDetailsHistory($order_id){
      if($order_id){
            $this->db->select('orders.*,statuses.*,order_menus.*');
            $this->db->from('orders');
            $this->db->join('statuses', 'statuses.status_code = orders.status_id');
            $this->db->join('order_menus', 'order_menus.order_id = orders.order_id');
            $this->db->where('orders.order_id',$order_id);

      }
      $query = $this->db->get();
      if(!$query->num_rows())
      {
        return $query->result_array();
      }
      else
      {
        return $query->result_array();
      }

    }

    public function getNearByRestaurantsDetails($lat,$lng,$location_id)
    {
      $this->db->select('*,locations.location_id as locationid, 111.111 *
        DEGREES(ACOS(LEAST(COS(RADIANS('.$lat.'))
        * COS(RADIANS(location_lat))
        * COS(RADIANS('.$lng.' - location_lng ))
        + SIN(RADIANS('.$lat.'))
        * SIN(RADIANS(location_lat)), 1.0))) AS distance '
      );
      if ($this->config->item('distance_unit') === 'km') {
        $sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
      } else {
        $sql = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
      }
      $sql .= "cos( radians( A.location_lng ) - radians(?) ) + sin( radians(?) ) *";
      $sql .= "sin( radians( A.location_lat ) ) ) ) AS distance ";
      $this->db->from('locations');
      $this->db->where('locations.location_id',$location_id);
      $query = $this->db->get();
        //echo $this->db->last_query();exit;
      if(!$query->num_rows())
      {
        return array();
      }
      else
      {
        return $query->result_array();
      }
    }

    public function getFavouritesMenu($location_id,$customer_id,$menu_id){
		  if($location_id){
            $this->db->select('favourites_menu.*,menus.*');
            $this->db->from('favourites_menu');
            $this->db->join('menus', 'menus.menu_id = favourites_menu.menu_id');
            $this->db->where('favourites_menu.restaurant_id',$location_id);
            if(!empty($customer_id) && is_numeric($customer_id)){
              $this->db->where('favourites_menu.customer_id',$customer_id);
            }
            if(!empty($menu_id) && is_numeric($menu_id)){
              $this->db->where('favourites_menu.menu_id',$menu_id);
            }
            $this->db->order_by('date_added','desc');
      }
      $query = $this->db->get();
      if(!$query->num_rows())
      {
        return $query->result_array();
      }
      else
      {
        return $query->result_array();
      }
    }
    public function addFavouritesMenu($location_id,$customer_id,$menu_id){
		  if($location_id && $customer_id){
        $this->db->from('favourites_menu');
        $this->db->where('favourites_menu.menu_id',$menu_id);
        $this->db->where('favourites_menu.customer_id',$customer_id);
        $query = $this->db->get();
        if(!$query->num_rows())
        {
          $this->db->from('favourites_menu');
          $this->db->set('restaurant_id', $location_id);
          $this->db->set('customer_id', $customer_id);
          $this->db->set('menu_id', $menu_id);

          if ($query = $this->db->insert('favourites_menu')) {
            return true;
          }
          return false;
        }else{
          return true;
        }
      }else{
        return false;
      }
    }
    public function removeFavouritesMenu($favourites_id){
		  if($favourites_id){
        $this->db->where('favourites_id', $favourites_id);
        $this->db->delete('favourites_menu');
        return true;
      }else{
        return false;
      }
    }

    public function getRestaurant($user_id) {
      if (is_numeric($user_id)) {
        $this->db->from('users');
        $this->db->where('staff_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
          return $query->result_array()[0];
        }
      }
    }

    public function checkPassword($user_id,$old_password){
      if (is_numeric($user_id)) {
        $this->db->from('users');
        $this->db->where('staff_id', $user_id);
        $this->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $old_password . '")))))', FALSE);
		    $query = $this->db->get();
        if ($query->num_rows() === 1) {
          return TRUE;
        } else {
          return FAlSE;
        }
      }
    }
    public function savePassword($user_id,$password){
      if (is_numeric($user_id)) {
        if (isset($password)) {
          $this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
          $this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
        }
        $this->db->where('staff_id', $user_id);
        $query = $this->db->update('users');
        if ($query->num_rows() == 1) {
          return TRUE;
        } else {
          return FAlSE;
        }
      }
    }

  public function getProfileStaff($staff_id){
    $this->db->from('staffs');
    $this->db->where('staff_id', $staff_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result_array()[0];
    }else{
      return null;
    }

  }


	public function updateRestaurant($restaurant_id, $save = array()) {
		if (empty($save) AND ! is_array($save)) return FALSE;
		if (isset($save['location_telephone'])) {
			$this->db->set('staff_telephone', $save['location_telephone']);
		}
		if (isset($save['staff_name'])) {
			$this->db->set('staff_name', $save['staff_name']);
		}

		if (is_numeric($restaurant_id)) {
			$this->db->where('staff_id', (int) $restaurant_id);
			$query = $this->db->update('staffs');
		}
		if ($query === TRUE AND is_numeric($restaurant_id)) {
			return $restaurant_id;
		}else{
			return null;
		}
	}

  public function get_stripe_charge_id($order_id = ''){
    $this->db->select('stripe_charge_id');
    $this->db->from('orders');
    $this->db->where('order_id', $order_id);
    $query=$this->db->get();
    return !empty($query->result_array()[0]['stripe_charge_id'])?$query->result_array()[0]['stripe_charge_id']:'';
 }

 public function updateStripeRefund($order_id, $stripe_refund_id, $stripe_refund_timestamp){
  if($order_id){
    $query = FALSE;
    $this->db->set('stripe_refund_id', $stripe_refund_id);
    $this->db->set('stripe_refund_timestamp', $stripe_refund_timestamp);
    $this->db->where('order_id', $order_id);
    $query = $this->db->update('orders');
    if ($query === TRUE) {
      $query = true;
    }
   return $query;
  }
}
}