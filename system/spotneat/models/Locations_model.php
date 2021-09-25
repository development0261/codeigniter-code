<?php
/**
 * SpotnEat
 *
 * 
 *
 * @package   SpotnEat
 * @author    Sp
 * @copyright SpotnEat
 * @link      http://spotneat.com
 * @license   http://spotneat.com
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Locations Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Locations_model.php
 * @link           http://docs.spotneat.com
 */
class Locations_model extends TI_Model {

	public function getCount($filter = array(),$user='') {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('location_name', $filter['filter_search']);
			$this->db->or_like('location_city', $filter['filter_search']);
			$this->db->or_like('location_state', $filter['filter_search']);
			$this->db->or_like('location_postcode', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('location_status', $filter['filter_status']);
		}

		/*** User wise filter apply ***/
		if($user != ''){
			if($this->user->getStaffId() != 11)
			$this->db->where('added_by',$this->user->getId());
		}


		$this->db->from('locations');

		return $this->db->count_all_results();
	}

	public function getOTPStatus($customer_id)
	{
			$this->db->select('verified_status');
			$this->db->from('customers');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			$row = $query->row_array();
			
			return $row['verified_status'];
		
	}
	public function getOTP($customer_id)
	{
			$this->db->select('verify_otp');
			$this->db->from('customers');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			$row = $query->row_array();
			
			return $row['verify_otp'];
		
	}

	public function updateOTP($customer_id,$otp=''){

		$this->db->set('verify_otp',$otp);		
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customers');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return TRUE;

	}

	public function updateVerifyStatus($customer_id=''){

		$this->db->set('verified_status', 1);		
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customers');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return TRUE;

	}

	public function updatePhone($customer_id,$mob){

		$this->db->set('telephone', $mob);		
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customers');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return TRUE;

	}

	public function getList($filter = array(),$user='') {

		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('locations');
			$this->db->join('staffs','locations.location_id = staffs.staff_location_id','left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('location_name', $filter['filter_search']);
				$this->db->or_like('location_city', $filter['filter_search']);
				$this->db->or_like('location_state', $filter['filter_search']);
				$this->db->or_like('location_postcode', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('location_status', $filter['filter_status']);
			}

			/*** User wise filter apply ***/
			if($user != ''){
				if($this->user->getStaffId() != 11)
				$this->db->where('added_by',$this->user->getStaffId());
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getLocations() {
		$this->db->from('locations');

		$this->db->where('location_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getRestaurant($staff_id='') {
		$this->db->from('locations');
		$this->db->where('added_by', $staff_id);
		$this->db->where('location_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getLocationName($location_id) {
		$this->db->select('location_name');
		$this->db->from('locations');
		$this->db->where('location_id', $location_id);
		$query = $this->db->get();
		$row = $query->row_array();
			
		return $row['location_name'];		
	}
	public function getRestaurantLocationDetails($key,$value) {
		if ($value) {
			$this->db->from('locations');
			$this->db->where($key, $value);
			$query = $this->db->get();
			$result = array();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result=$result[0];
			}
			return $result;
		}
	}
	public function getRestaurantStaffsDetails($key,$value) {
		if ($value) {
			$this->db->from('staffs');
			$this->db->where($key, $value);
			$query = $this->db->get();
			$result = array();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result=$result[0];
			}
			return $result;
		}
	}

	public function getRestaurantsForFranchisee($key,$value) {
		if ($value) {
			$this->db->from('locations');
			$this->db->where($key, $value);
			$query = $this->db->get();
			$result = array();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
			$location_ids = array();
            foreach ($result as $res) {
                array_push($location_ids,  $res['location_id']);
			}
			return $location_ids;
		}
	}

	public function getLocationImage($location_id) {
		$this->db->select('location_image');
		$this->db->from('locations');
		$this->db->where('location_id', $location_id);
		$query = $this->db->get();
		$row = $query->row_array();
			
		return $row['location_image'];		
	}

	public function getLocationETA($location_id) {
		$this->db->select('delivery_time');
		$this->db->from('locations');
		$this->db->where('location_id', $location_id);
		$query = $this->db->get();
		$row = $query->row_array();
			
		return $row['delivery_time'];		
	}

	public function getLocation($location_id) {

		if (is_numeric($location_id)) {
			$this->db->from('locations');
			$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');
			//$this->db->join('working_hours', 'working_hours.location_id = locations.location_id', 'left');

			$this->db->where('location_id', $location_id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getWorkingHours($location_id = FALSE) {
		$result = array();

		$this->db->from('working_hours');

		if (is_numeric($location_id)) {
			$this->db->where('location_id', $location_id);
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getAddress($location_id) {
		$address_data = array();

		if ($location_id !== 0) {
			$this->db->from('locations');
			$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');

			$this->db->where('location_id', $location_id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				$address_data = array(
					'location_id'   => $row['location_id'],
					'location_name' => $row['location_name'],
					'location_name_ar' => $row['location_name_ar'],
					'address_1'     => $row['location_address_1'],
					'address_2'     => $row['location_address_2'],
					'city'          => $row['location_city'],
					'state'         => $row['location_state'],
					'postcode'      => $row['location_postcode'],
					'country_id'    => $row['location_country_id'],
					'country'       => $row['country_name'],
					'address_1_ar'     => $row['location_address_1_ar'],
					'address_2_ar'     => $row['location_address_2_ar'],
					'city_ar'          => $row['location_city_ar'],
					'state_ar'         => $row['location_state_ar'],
					'postcode_ar'      => $row['location_postcode_ar'],					
					'country_ar'       => $row['country_name'],
					'iso_code_2'    => $row['iso_code_2'],
					'iso_code_3'    => $row['iso_code_3'],
					'location_lat'  => $row['location_lat'],
					'location_lng'  => $row['location_lng'],
					'format'        => $row['format'],
				);
			}
		}

		return $address_data;
	}

	public function getOpeningHourByDay($location_id = FALSE, $day = FALSE) {
		$weekdays = array('Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6);

		$day = ( ! isset($weekdays[$day])) ? date('l', strtotime($day)) : $day;

		$hour = array('open' => '00:00:00', 'close' => '00:00:00', 'status' => '0');

		$this->db->from('working_hours');
		$this->db->where('location_id', $location_id);
		$this->db->where('weekday', $weekdays[$day]);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$hour['open'] = $row['opening_time'];
			$hour['close'] = $row['closing_time'];
			$hour['status'] = $row['status'];
		}

		return $hour;
	}
	public function getLocalRestaurant_count($lat = FALSE, $lng = FALSE, $filter = FALSE) {

		if ($this->config->item('distance_unit') === 'km') {
			$sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
		} else {
			$sql = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
		}

		$sql .= "cos( radians( A.location_lng ) - radians(?) ) + sin( radians(?) ) *";
		$sql .= "sin( radians( A.location_lat ) ) ) ) AS distance ";
		$sql .= "FROM {$this->db->dbprefix('locations')} as A left join {$this->db->dbprefix('menus')} as B on A.location_id = B.location_id WHERE A.location_status = 1";
		if ( ! empty($filter['type'])) {
				if($filter['type'] != 'both')
				{
					$sql .= " and (A.location_type = '".$filter['type']."' or A.location_type = 'both') ";
				}
							
			}
		if ( ! empty($filter['keyword'])) {
				$sql .= " and ( A.location_name like '%".$filter['keyword']."%' OR B.menu_name like '%".$filter['keyword']."%')";
			}
			
			if ( ! empty($filter['rating'])) {
				$sql .= " and location_ratings >=".$filter['rating'];
			}
			$sql .= " Group By A.location_id";
			$sql .= " Having distance < 20";
			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$sql .= " ORDER BY A.".$filter['sort_by']." ".$filter['order_by']; 
			}
			else
			{
				$sql .= " ORDER BY distance ASC"; 
			}
			
			if ( ! empty($lat) && ! empty($lng)) {
				$query = $this->db->query($sql, array($lat, $lng, $lat));
			}else{
				$sql = "SELECT * FROM {$this->db->dbprefix('locations')} where location_status = 1" ;
				$query = $this->db->query($sql);
			}
			//echo $this->db->last_query();exit;
			$local_info = array();
			return $query->num_rows();
	}

	public function getLocalRestaurant($lat = FALSE, $lng = FALSE, $filter = FALSE) {
 
		if ($this->config->item('distance_unit') === 'km') {
			$sql = "SELECT A.*,B.`menu_name`,B.`menu_id`, ( 6371 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
		} else {
			$sql = "SELECT A.*,B.`menu_name`,B.`menu_id`, ( 3959 * acos( cos( radians(?) ) * cos( radians( A.location_lat ) ) *";
		}

		$sql .= "cos( radians( A.location_lng ) - radians(?) ) + sin( radians(?) ) *";
		$sql .= "sin( radians( A.location_lat ) ) ) ) AS distance ";
		$sql .= "FROM {$this->db->dbprefix('locations')} as A left join {$this->db->dbprefix('menus')} as B on A.location_id = B.location_id WHERE A.location_status = 1";
		if ( ! empty($filter['type'])) {
				if($filter['type'] != 'both')
				{
					$sql .= " and (A.location_type = '".$filter['type']."' or A.location_type = 'both') ";
				}
			}

		
		if ( ! empty($filter['keyword'])) {
				$sql .= " and ( A.location_name like '%".$filter['keyword']."%' OR B.menu_name like '%".$filter['keyword']."%')";
			}
			
			if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
				$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
			}
			if ( ! empty($filter['rating'])) {
				$sql .= " and location_ratings >=".$filter['rating'];
			}else{
				$filter['rating']=0;
			}
			$sql .= " Group By A.location_id";
			$sql .= " Having distance < 20";
			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$sql .= " ORDER BY A.".$filter['sort_by']." ".$filter['order_by']; 
			}
			else
			{
				if ( ! empty($filter['rating'])) {
					$sql .= " ORDER BY A.location_ratings ASC LIMIT ".$filter['limit']." OFFSET ".$filter['page']; 
				}else{
					$sql .= " ORDER BY distance ASC LIMIT ".$filter['limit']." OFFSET ".$filter['page']; 
				}
			}
			if ( ! empty($lat) && ! empty($lng)) {
				$query = $this->db->query($sql, array($lat, $lng, $lat));
			}else{
					// echo 'fhjk';
					// exit;
				$sql = "SELECT * FROM {$this->db->dbprefix('locations')} WHERE location_status = 1 and location_ratings >=".$filter['rating'];
				if($filter['type']!=""){
					$sql.= " and (location_type = '".$filter['type']."') ";
				}else{
					$sql.= " and (location_type = '".$filter['type']."' or location_type = 'both') ";

				}
				if ( ! empty($filter['veg_type'])) {
					if($filter['veg_type'] != 'both')
					{
						$sql .= " and (veg_type = '".$filter['veg_type']."') ";
						// echo $sql;
						// exit;
					}
				}

				if ( ! empty($filter['delivery_fee'])) {
					// echo 'sdkjfddgh';
					// exit;
					if($filter['delivery_fee'] != '' & $filter['delivery_fee'] == 'free' )
					{
						$sql .= " and (delivery_fee = '0') ";
						// echo $sql;
						// exit;
					}
				}

				if ( ! empty($filter['offer_collection'])) {
					// echo 'sdkjfddgh';
					// exit;
					if($filter['offer_collection'] != '' & $filter['offer_collection'] == 'pickup' )
					{
						$sql .= " and (offer_collection = '1') ";
						// echo $sql;
						// exit;
					}
				}

				if($filter['sort_by']!=""){
					$sql.= " ORDER BY ".$filter['sort_by']." ".$filter['order_by'];
				}
				// print_r($sql);
				// exit();
				$query = $this->db->query($sql);
			}
			$local_info = array();
			
			if ($query->num_rows() > 0) {

				$result = $query->first_row('array');

				if ( ! empty($result['location_radius'])) {
					$search_radius = $result['location_radius'];
				} else {
					$search_radius = (int) $this->config->item('search_radius');
				}
// print_r($this->db->last_query());exit();
				return $query->result_array();
			}

		return FALSE;
	}

	public function updateDefault($address = array()) {
		$query = FALSE;

		if (empty($address) AND ! is_array($address)) {
			return $query;
		}

		if (isset($address['address_1'])) {
			$this->db->set('location_address_1', $address['address_1']);
		}

		if (isset($address['address_2'])) {
			$this->db->set('location_address_2', $address['address_2']);
		}

		if (isset($address['city'])) {
			$this->db->set('location_city', $address['city']);
		}

		if (isset($address['state'])) {
			$this->db->set('location_state', $address['state']);
		}

		if (isset($address['postcode'])) {
			$this->db->set('location_postcode', $address['postcode']);
		}

		if (isset($address['country_id'])) {
			$this->db->set('location_country_id', $address['country_id']);
		}

		if (isset($address['location_lat'])) {
			$this->db->set('location_lat', $address['location_lat']);
		}

		if (isset($address['location_lng'])) {
			$this->db->set('location_lng', $address['location_lng']);
		}

		$this->db->set('location_status', '1');

		$location_id = (isset($address['location_id']) AND is_numeric($address['location_id'])) ? (int) $address['location_id'] : $this->config->item('default_location_id');

		if (is_numeric($location_id)) {
			$this->db->where('location_id', $location_id);
			$query = $this->db->update('locations');
		} else {
			if ($query = $this->db->insert('locations')) {
				$location_id = (int) $this->db->insert_id();
			}
		}

		if (is_numeric($location_id) AND $default_address = $this->getAddress($location_id)) {
			$this->Settings_model->addSetting('prefs', 'main_address', $default_address, '1');
			$this->Settings_model->addSetting('prefs', 'default_location_id', $location_id, '0');
		}

		return $query;
	}

	public function getCountryID($country){
		$this->db->from('countries');

		$this->db->where('country_name', $country);

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
	public function getCountryName($country){
		$this->db->from('countries');
		$this->db->where('country_id', $country);

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function saveLocation($location_id, $save = array()) {
		//echo '<pre>';print_r($save);exit;
		if (empty($save)) return FALSE;

		if (isset($save['location_name'])) {
			$this->db->set('location_name', $save['location_name']);
		}
		if (isset($save['location_type'])) {
			$this->db->set('location_type', $save['location_type']);
		}
		if (isset($save['veg_type'])) {
			$this->db->set('veg_type', $save['veg_type']);
		}
		if (isset($save['arabic_location_name'])) {
			$this->db->set('location_name_ar', $save['arabic_location_name']);
		}
		if (isset($save['address']['address_1'])) {
			$this->db->set('location_address_1', $save['address']['address_1']);
		}
		if (isset($save['arabic_address']['address_1_ar'])) {
			$this->db->set('location_address_1_ar', $save['arabic_address']['address_1_ar']);
		}
		if (isset($save['address']['address_2'])) {
			$this->db->set('location_address_2', $save['address']['address_2']);
		}
		if (isset($save['arabic_address']['address_2_ar'])) {
			$this->db->set('location_address_2_ar', $save['arabic_address']['address_2_ar']);
		}
		if (isset($save['address']['city'])) {
			$this->db->set('location_city', $save['address']['city']);
		}
		if (isset($save['arabic_address']['city_ar'])) {
			$this->db->set('location_city_ar', $save['arabic_address']['city_ar']);
		}
		if (isset($save['address']['state'])) {
			$this->db->set('location_state', $save['address']['state']);
		}
		if (isset($save['arabic_address']['state_ar'])) {
			$this->db->set('location_state_ar', $save['arabic_address']['state_ar']);
		}

		if (isset($save['address']['postcode'])) {
			$this->db->set('location_postcode', $save['address']['postcode']);
		}

		if (isset($save['address']['country'])) {
			$country =  $save['address']['country'];
			$country_id = $this->getCountryID($country);//print_r($country_id);exit;
			$save['address']['country'] = $country_id[0]['country_id'];
			$this->db->set('location_country_id',$save['address']['country'] );
		}

		if (isset($save['address']['location_lat'])) {
			$this->db->set('location_lat', $save['address']['location_lat']);
		}

		if (isset($save['address']['location_lng'])) {
			$this->db->set('location_lng', $save['address']['location_lng']);
		}

		if (isset($save['email'])) {
			$this->db->set('location_email', $save['email']);
		}

		if (isset($save['first_table_price'])) {
			$this->db->set('first_table_price', $save['first_table_price']);
		}

		if (isset($save['additional_table_price'])) {
			$this->db->set('additional_table_price', $save['additional_table_price']);
		}

		if (isset($save['telephone'])) {
			$this->db->set('location_telephone', $save['country_code'].'-'.$save['telephone']);
		}

		if (isset($save['description'])) {
			$this->db->set('description', $save['description']);
		}
		if (isset($save['arabic_description'])) {
			$this->db->set('description_ar', $save['arabic_description']);
		}

		if (isset($save['location_image'])) {
			$this->db->set('location_image', $save['location_image']);
		}

		if ($save['added_by'] == "") {
			$this->db->set('added_by', $this->user->getId());
		}

		if (isset($save['open_close_status'])) {
			$this->db->set('open_close_status', $save['open_close_status']);
		}

		if ($save['offer_delivery'] === '1') {
			$this->db->set('offer_delivery', $save['offer_delivery']);
		} else {
			$this->db->set('offer_delivery', '0');
		}

		if ($save['offer_collection'] === '1') {
			$this->db->set('offer_collection', $save['offer_collection']);
		} else {
			$this->db->set('offer_collection', '0');
		}

		if (isset($save['delivery_boy_commission'])) {
			$this->db->set('delivery_boy_commission', $save['delivery_boy_commission']);
		} else {
			$this->db->set('delivery_boy_commission', '0');
		}

		if (isset($save['delivery_time'])) {
			$this->db->set('delivery_time', $save['delivery_time']);
		} else {
			$this->db->set('delivery_time', '0');
		}

		if (isset($save['collection_time'])) {
			$this->db->set('collection_time', $save['collection_time']);
		} else {
			$this->db->set('collection_time', '0');
		}

		if (isset($save['last_order_time'])) {
			$this->db->set('last_order_time', $save['last_order_time']);
		} else {
			$this->db->set('last_order_time', '0');
		}

		if (isset($save['reservation_time_interval'])) {
			$this->db->set('reservation_time_interval', $save['reservation_time_interval']);
		} else {
			$this->db->set('reservation_time_interval', '0');
		}

		if (isset($save['reservation_stay_time'])) {
			$this->db->set('reservation_stay_time', $save['reservation_stay_time']);
		} else {
			$this->db->set('reservation_stay_time', '0');
		}

		$options = array();
		if (isset($save['auto_lat_lng'])) {
			$options['auto_lat_lng'] = $save['auto_lat_lng'];
		}

		if (isset($save['opening_type'])) {
			$options['opening_hours']['opening_type'] = $save['opening_type'];
		}

		if (isset($save['daily_days'])) {
			$options['opening_hours']['daily_days'] = $save['daily_days'];
		}

		if (isset($save['daily_hours'])) {
			$options['opening_hours']['daily_hours'] = $save['daily_hours'];
		}

		if (isset($save['flexible_hours'])) {
			$options['opening_hours']['flexible_hours'] = $save['flexible_hours'];
		}

		if (isset($save['delivery_type'])) {
			$options['opening_hours']['delivery_type'] = $save['delivery_type'];
		}

		if (isset($save['delivery_days'])) {
			$options['opening_hours']['delivery_days'] = $save['delivery_days'];
		}

		if (isset($save['delivery_hours'])) {
			$options['opening_hours']['delivery_hours'] = $save['delivery_hours'];
		}

		if (isset($save['collection_type'])) {
			$options['opening_hours']['collection_type'] = $save['collection_type'];
		}

		if (isset($save['collection_days'])) {
			$options['opening_hours']['collection_days'] = $save['collection_days'];
		}

		if (isset($save['collection_hours'])) {
			$options['opening_hours']['collection_hours'] = $save['collection_hours'];
		}

		if (isset($save['future_orders'])) {
			$options['future_orders'] = $save['future_orders'];
		}

		if (isset($save['future_order_days'])) {
			$options['future_order_days'] = $save['future_order_days'];
		}

		if (isset($save['payments'])) {
			$options['payments'] = $save['payments'];
		}

		if (isset($save['delivery_areas'])) {
			$options['delivery_areas'] = $save['delivery_areas'];
		}

		if (isset($save['gallery'])) {
			$options['gallery'] = $save['gallery'];
		}

		$this->db->set('options', serialize($options));

		if ($save['location_status'] === '1') {
			$this->db->set('location_status', $save['location_status']);
		} else {
			$this->db->set('location_status', '0');
		}

		if ($save['rewards_value'] != '') {
			$this->db->set('rewards_value', $save['rewards_value']);
		} else {
			$this->db->set('rewards_value', '0');
		}

		if ($save['rewards_enable'] != '') {
			$this->db->set('rewards_enable', $save['rewards_enable']);
		} else {
			$this->db->set('rewards_enable', '1');
		}

		if ($save['point_value'] != '') {
			$this->db->set('point_value', $save['point_value']);
		} else {
			$this->db->set('point_value', '0');
		}
		if ($save['point_price'] != '') {
			$this->db->set('point_price', $save['point_price']);
		} else {
			$this->db->set('point_price', '0');
		}
		if ($save['minimum_price'] != '') {
			$this->db->set('minimum_price', $save['minimum_price']);
		} else {
			$this->db->set('minimum_price', '0');
		}
		if ($save['cancellation_type'] != '' && $save['cancellation_period'] != '') {
			$this->db->set('cancellation_period', json_encode($save['cancellation_period']).'-'.json_encode($save['cancellation_type']));
		} else {
			$this->db->set('cancellation_period', '');
		}
		if ($save['cancellation_charge'] != '') {
			$this->db->set('cancellation_charge', json_encode($save['cancellation_charge']));
		} else {
			$this->db->set('cancellation_charge', '0');
		}
		if ($save['refund_status'] != '') {
			$this->db->set('refund_status', $save['refund_status']);
		} else {
			$this->db->set('refund_status', '0');
		}
		if ($save['tax_type'] != '') {
			$this->db->set('tax_type', json_encode($save['tax_type']));
		} else {
			$this->db->set('tax_type', '');
		}
		if ($save['tax_perc'] != '') {
			$this->db->set('tax_perc', json_encode($save['tax_perc']));
		} else {
			$this->db->set('tax_perc', '');
		}
		if ($save['tax_status'] != '') {
			$this->db->set('tax_status', json_encode($save['tax_status']));
		} else {
			$this->db->set('tax_status', '');
		}
		if ($save['reward_status'] != '') {
			$this->db->set('reward_status', $save['reward_status']);
		} else {
			$this->db->set('reward_status', '0');
		}
		if ($save['rewards_method'] != '') {
			$this->db->set('rewards_method', $save['rewards_method']);
		} else {
			$this->db->set('rewards_method', '0');
		}
		if ($save['maximum_amount'] != '') {
			$this->db->set('maximum_amount', $save['maximum_amount']);
		} else {
			$this->db->set('maximum_amount', '0');
		}

		if ($save['delivery_fee'] != '') {
			$this->db->set('delivery_fee', $save['delivery_fee']);
		} else {
			$this->db->set('delivery_fee', '0');
		}

		if (is_numeric($location_id)) {
			$this->db->where('location_id', $location_id);
			$query = $this->db->update('locations');
		} else {
			$query = $this->db->insert('locations');

			$location_id = $this->db->insert_id();
		}
		//echo $this->db->last_query();exit;
		if ($query === TRUE AND is_numeric($location_id)) {
			if ($location_id === $this->config->item('default_location_id')) {
				$this->Settings_model->addSetting('prefs', 'main_address', $this->getAddress($location_id), '1');
			}

			if ( ! empty($options['opening_hours'])) {
				$this->addOpeningHours($location_id, $options['opening_hours']);
			}

			if ( ! empty($save['tables'])) {
				$this->addLocationTables($location_id, $save['tables']);
			}

			if ( ! empty($save['permalink'])) {
				$this->permalink->savePermalink('local', $save['permalink'], 'location_id=' . $location_id);
			}

			//$this->changeOpeningHoursStatus($location_id,$save['open_close_status']);
			return $location_id;
		}
	}

	public function addOpeningHours($location_id, $data = array()) {
		$this->db->where('location_id', $location_id);
		$this->db->delete('working_hours');

		$hours = array();

		if ( ! empty($data['opening_type'])) {
			if ($data['opening_type'] === '24_7') {
				for ($day = 0; $day <= 6; $day ++) {
					$hours['opening'][] = array('day' => $day, 'open' => '00:00', 'close' => '23:59', 'status' => '1');
				}
			} else if ($data['opening_type'] === 'daily') {
				for ($day = 0; $day <= 6; $day ++) {
					if ( ! empty($data['daily_days']) AND in_array($day, $data['daily_days'])) {
						$hours['opening'][] = array('day' => $day, 'open' => $data['daily_hours']['open'], 'close' => $data['daily_hours']['close'], 'status' => '1');
					} else {
						$hours['opening'][] = array('day' => $day, 'open' => $data['daily_hours']['open'], 'close' => $data['daily_hours']['close'], 'status' => '0');
					}
				}
			} else if ($data['opening_type'] === 'flexible' AND ! empty($data['flexible_hours'])) {
				$hours['opening'] = $data['flexible_hours'];
			}

			$hours['delivery'] = empty($data['delivery_type']) ? $hours['opening'] : $this->_createWorkingHours('delivery', $data);
			$hours['collection'] = empty($data['collection_type']) ? $hours['opening'] : $this->_createWorkingHours('collection', $data);

			if (is_numeric($location_id) AND ! empty($hours) AND is_array($hours)) {
				foreach ($hours as $type => $hr) {
					foreach ($hr as $hour) {
						$this->db->set('location_id', $location_id);
						$this->db->set('weekday', $hour['day']);
						$this->db->set('type', $type);
						$this->db->set('opening_time', mdate('%H:%i', strtotime($hour['open'])));
						$this->db->set('closing_time', mdate('%H:%i', strtotime($hour['close'])));
						$this->db->set('status', $hour['status']);
						$this->db->insert('working_hours');
					}
				}
			}
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addLocationTables($location_id, $tables = array()) {
		$this->db->where('location_id', $location_id);
		$this->db->delete('location_tables');

		if (is_array($tables) && ! empty($tables)) {
			foreach ($tables as $key => $value) {

				$this->db->set('location_id', $location_id);
				$this->db->set('table_id', $value);
				$this->db->insert('location_tables');
			}
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteLocation($location_id) {
		if (is_numeric($location_id)) $location_id = array($location_id);

		if ( ! empty($location_id) AND ctype_digit(implode('', $location_id))) {
			$this->db->where_in('location_id', $location_id);
			$this->db->delete('locations');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('location_id', $location_id);
				$this->db->delete('location_tables');

				$this->db->where_in('location_id', $location_id);
				$this->db->delete('working_hours');

				foreach ($location_id as $id) {
					$this->permalink->deletePermalink('local', 'location_id=' . $id);
				}

				return $affected_rows;
			}
		}
	}

	public function validateLocation($location_id) {
		if ( ! empty($location_id)) {
			$this->db->from('locations');
			$this->db->where('location_id', $location_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}

	private function _createWorkingHours($type, $data) {
		$days = (empty($data["{$type}_days"])) ? array() : $data["{$type}_days"];
		$hours = (empty($data["{$type}_hours"])) ? array('open' => '00:00', 'close' => '23:59') : $data["{$type}_hours"];

		$working_hours = array();

		for ($day = 0; $day <= 6; $day ++) {
			$status = in_array($day, $days) ? '1' : '0';
			$working_hours[] = array('day' => $day, 'open' => $hours['open'], 'close' => $hours['close'], 'status' => $status);
		}

		return $working_hours;
	}

	public function findReservations($location_id,$table_id) {
		$this->db->from('reservations');
		$this->db->where('location_id', $location_id);
		$this->db->where('table_id', $table_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function deleteTable($location_id,$table_id) {

		$this->db->where('location_id', $location_id);
		$this->db->where('table_id', $table_id);
   		$this->db->delete('location_tables'); 
   		
		return TRUE;
	}

	public function changeOpeningHoursStatus1($location_id,$status,$open,$close,$day){
		
		if($status == 1){
			$this->db->set('status', 1);
			$this->db->set('open', $open);
			$this->db->set('close', $close);
			$this->db->where('location_id', $location_id);
			$this->db->where('weekday', $day);
			$this->db->update('working_hours');
		}else{
			$this->db->set('status', 0);
			$this->db->set('open', $open);
			$this->db->set('close', $close);
			$this->db->where('location_id', $location_id);
			$this->db->where('weekday', $day);
			$this->db->update('working_hours');
		}
		
	}

	public function changeOpeningHoursStatus($location_id,$status){
		
		if($status == 1){
			$this->db->set('status', 1);
			$this->db->where('location_id', $location_id);
			$this->db->update('working_hours');
		}else{
			$this->db->set('status', 0);
			$this->db->where('location_id', $location_id);
			$this->db->update('working_hours');
		}
		
	}

	public function getLocationWithVendorId($added_by,$loc_id='') {
		
		$this->db->from('locations');

		$this->db->where('location_status', '1');
		if($added_by != "")
		{
			$this->db->where('added_by', $added_by);
		}else{
			$this->db->where('added_by', $this->user->getId());
		}

		if($loc_id != "")
		{
			$this->db->where('location_id', $loc_id);
		}
		

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getLocationWithVendors($added_by,$loc_id='') {
		
		$this->db->from('locations');
		$this->db->where('location_status', '1');
		if($this->session->user_info['staff_group_id']==13){
			$this->db->where('added_by', $this->user->getStaffId());
			$this->db->or_where('restaurant_by',$this->user->getStaffId());
	
		}else if($this->session->user_info['staff_group_id']==12){
			$this->db->where('location_id', $loc_id);
		}else{
				
		}
	
		if($loc_id != "")
		{
			$this->db->where('location_id', $loc_id);
		}
	
	
		$query = $this->db->get();
		$result = array();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		return $result;
	}

	public function getLocationtable($location_id) {

		if (is_numeric($location_id)) {
			$this->db->from('locations');
			$this->db->join('location_tables', 'location_tables.location_id = locations.location_id', 'left');
			$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');
			$this->db->where('locations.location_id', $location_id);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}
	public function getLocationtables($location_id) {
			$this->db->select('tables.table_id,tables.table_name');		
			$this->db->from('tables');
			$this->db->join('location_tables', 'location_tables.table_id = tables.table_id', 'left');								
			$this->db->where('location_tables.location_id', $location_id);

			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			return $query->result_array();
		
	}
	public function generateReservationNumber($location_id){
		
		$this->db->select('location_name');
		$this->db->from('locations');
		$this->db->where('location_id',$location_id);
		$query = $this->db->get();
		$name = $query->result_array()[0]['location_name'];

		$this->db->select('MAX(id) as maxid');
		$this->db->from('reservations');
		$query = $this->db->get();
		$last_id = $query->result_array()[0]['maxid'];

		

		$this->db->select('reservation_id');
		$this->db->from('reservations');
		$this->db->where('id',$last_id);
		$query = $this->db->get();
		$last_code = $query->result_array()[0]['reservation_id'];
		if(strlen($last_code) >= 11){
			$maxid = (int) substr($last_code,4,7) + 1;
		}else{
			$maxid = $last_code + 1;
		}
		$split = str_split($name,3);
		$prefix = strtoupper($split[0]);
		$reservation_id = $prefix.'-'.str_pad($maxid,7,"0",STR_PAD_LEFT);
		return $reservation_id;


	}

	public function generateOtp($location_id){
		
		$this->db->select('location_name');
		$this->db->from('locations');
		$this->db->where('location_id',$location_id);
		$query = $this->db->get();
		$name = $query->result_array()[0]['location_name'];

		$split = str_split($name,3);
		$prefix = strtoupper($split[0]);
		$i=1;
		$j=1;
		while($i==$j){
			$otp = $prefix.rand(111111,999999);

			$this->db->select('otp');
			$this->db->from('reservations');
			$this->db->where('otp',$otp);
			$query = $this->db->get();
			if($query->num_rows() == 0) {
				$j=2;
			}
		}
		return $otp;


	}
	public function getvendormobile($location_id) {

		if (is_numeric($location_id)) {
			$this->db->select('staff_telephone');
			$this->db->from('locations');
			$this->db->join('staffs', 'staffs.staff_id = locations.added_by', 'inner');
			//$this->db->join('working_hours', 'working_hours.location_id = locations.location_id', 'left');

			$this->db->where('location_id', $location_id);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if ($query->num_rows() > 0) {
				return $query->result_array()[0]['staff_telephone'];
			}

		}
	}

	public function getLocationAddedBy($added_by,$format ='array') {

		if (is_numeric($added_by)) {

			$this->db->from('locations');
			if($added_by != "0"){
			$this->db->where('added_by', $added_by);
			}
			$query = $this->db->get();
			
			if ($query->num_rows() > 0) {
				if($format == 'array'){
				$ret_arry = $query->row_array();
				}else{
					$ret_arry = array();
					foreach ($query->result_array() as $loc_id) {
						array_push($ret_arry, $loc_id['location_id']);
					}					
				}
				return $ret_arry;
			}
		}

	}

	public function getLocationRestaurantBy($added_by,$format ='array') {

		if (is_numeric($added_by)) {

			$this->db->from('locations');
			if($added_by != "0"){
			$this->db->where('restaurant_by', $added_by);
			}
			$query = $this->db->get();
			
			if ($query->num_rows() > 0) {
				if($format == 'array'){
				$ret_arry = $query->row_array();
				}else{
					$ret_arry = array();
					foreach ($query->result_array() as $loc_id) {
						array_push($ret_arry, $loc_id['location_id']);
					}					
				}
				return $ret_arry;
			}
		}
	}

	public function getLocationAddedByFranchisee($added_by,$format ='array') {

		if (is_numeric($added_by)) {
			$this->db->select('location_id,location_name');
			$this->db->from('locations');
			$this->db->where('added_by', $added_by);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				if($format == 'array'){
				$ret_arry = $query->row_array();
				}else{
					$ret_arry = array();
					foreach ($query->result_array() as $loc_id) {
						array_push($ret_arry, $loc_id);
					}					
				}
				return $ret_arry;
			}else{
				return array();
			}
		}

	}


	public function add_feedback($type,$comment,$location_id,$user_id){
						$user_id=$this->customer->getId();
						$this->db->set('location_id', $location_id);
						$this->db->set('user_id', $user_id);
						$this->db->set('feedback_type', $type);
						$this->db->set('feedback_message', $comment);
						$this->db->insert('feedback');

						//print_r($this->db->last_query());exit;
						return true;

	}

	public function getSellerCommission($sellerid) {

						$this->db->select('commission');						
						$this->db->from('staffs');
						$this->db->where('staff_id', $sellerid);						
						$query = $this->db->get();
						//print_r($query->result_array());exit;
						return $query->result_array();
	}
	public function applyCommission($sellerid,$location_id,$amt,$commission_percentage,$reservation_id,$payment_status,$status=''){

						
						//$commission = round(($total_amount * $commission_percentage / 100),2);
						$date = date("Y-m-d h:i:s");
						$this->db->set('id', '');	
						$this->db->set('staff_id', $sellerid);	
						$this->db->set('location_id', $location_id);						
						//$this->db->set('percentage', $commission_percentage);
						$this->db->set('total_amount', $amt[0]['total_amount']);
						$this->db->set('table_amount', $amt[0]['booking_price']);
						$this->db->set('order_amount', $amt[0]['order_price']);
						$this->db->set('table_tax', $amt[0]['booking_tax']);
						$this->db->set('order_tax', $amt[0]['booking_tax_amount']);
						if($status!=''){
							$this->db->set('status', $status);	
						}
						//$this->db->set('commission_amount', $commission);
						$this->db->set('reservation_id', $reservation_id);
						$this->db->set('payment_status', $payment_status);
						$this->db->set('date', $date);	
						$this->db->insert('staffs_commission');
						
						return true;

	}
	public function updateStatus($res_id , $status,$payment_status){

						$this->db->set('status', $status);
						$this->db->set('payment_status', $payment_status);
						$this->db->where('reservation_id', $res_id);
						$this->db->update('staffs_commission');
						return true;
	}
	public function getReserveDetails($res_id){
						$this->db->select('*');						
						$this->db->from('reservations');
						$this->db->where('reservation_id', $res_id);						
						$query = $this->db->get();
						
						return $query->result_array();
	}
	public function getLocationId($location_name){
		//echo $location_id ;exit;
						$this->db->select('location_id');						
						$this->db->from('locations');
						$this->db->where('location_name', $location_name);						
						$query = $this->db->get();
						
						return $query->result_array();
	}
	public function getLocation_rating($location_id){
		
						$this->db->select('sum(quality) as quality_total ,sum(service) as service_total,count(quality) as count');						
						$this->db->from('reviews');
						$this->db->where('location_id', $location_id);
						$this->db->where('review_status', 1);						
						$query = $this->db->get();
						//echo $this->db->last_query();
						if ($query->num_rows() > 0) {
						$quality_total = $query->result_array()[0]['quality_total'];
						$service_total = $query->result_array()[0]['service_total'];
						$count =  $query->result_array()[0]['count'];
							if($count!=0){
								$rating = round(($quality_total + $service_total) / ($count * 2),1);
							}else{
								$rating = 0;
							}
						}else{
							$rating = 0;
						}						

						//print_r($this->db->last_query());exit;
						return $rating;
	
	}

}

/* End of file locations_model.php */
/* Location: ./system/spotneat/models/locations_model.php */