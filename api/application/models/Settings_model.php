<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings_model extends CI_Model {


	public function __construct() {
        parent::__construct();
        
        //load database library
        $this->load->database();
    }

	public function getAll() {
		$this->db->from('settings');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCurrencyId() {
		
		$this->db->select('value');
		$this->db->from('settings');
		$this->db->where('item','currency_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0]['value'];
		}else{
			return "";
		}
		
	
	}

	public function getDistanceUnit() {
		
		$this->db->select('value');
		$this->db->from('settings');
		$this->db->where('item','distance_unit');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0]['value'];
		}else{
			return "";
		}
		
	
	}

	public function updateSettings($sort, $update = array(), $flush = FALSE) {
		if ( ! empty($update) && ! empty($sort)) {
			if ($flush === TRUE) {
				$this->db->where('sort', $sort);
				$this->db->delete('settings');
			}

			foreach ($update as $item => $value) {
				if ( ! empty($item)) {
					if ($flush === FALSE) {
						$this->db->where('sort', $sort);
						$this->db->where('item', $item);
						$this->db->delete('settings');
					}

					if (isset($value)) {
						$serialized = '0';
						if (is_array($value)) {
							$value = serialize($value);
							$serialized = '1';
						}

						$this->db->set('sort', $sort);
						$this->db->set('item', $item);
						$this->db->set('value', $value);
						$this->db->set('serialized', $serialized);
						$this->db->insert('settings');
					}
				}
			}

			return TRUE;
		}
	}

	public function addSetting($sort, $item, $value, $serialized = '0') {
		$query = FALSE;

		if (isset($sort, $item, $value, $serialized)) {
			$this->db->where('sort', $sort);
			$this->db->where('item', $item);
			$this->db->delete('settings');

			$this->db->set('sort', $sort);
			$this->db->set('item', $item);

			if (is_array($value)) {
				$this->db->set('value', serialize($value));
			} else {
				$this->db->set('value', $value);
			}

			$this->db->set('serialized', $serialized);
			if ($this->db->insert('settings')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function deleteSettings($sort, $item) {
		if ( ! empty($sort) AND ! empty($item)) {
			$this->db->where('sort', $sort);
			$this->db->where('item', $item);
			$this->db->delete('settings');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function getCurrencyCode($id) {
		$this->db->select('currency_code');
		$this->db->from('currencies');
		$this->db->where('currency_id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0]['currency_code'];
		}else{
			return "";
		}
		
	}

	public function getBanners() {
		$this->db->select('image_code');
		$this->db->from('banners');
		$this->db->where('banner_id', 1);
		$query = $this->db->get();
		$res = $query->row_array();
		$results = unserialize($res['image_code']);
		$count = count($results['paths']);
		$i = 0;
		for($i=0;$i<$count;$i++){
			$result[$i]['name'] =  '';
			$result[$i]['image_src'] =  $results['paths'][$i];
			$result[$i]['caption'] =  '';			
		}
		return $result;
		exit;
	}

	public function getTaxDetails() {
		$tax_details = array();

		$tax_details['tax_mode'] = $this->getTaxMode();
		if($tax_details['tax_mode'] == "Active"){
			$tax_details['tax_percentage'] = $this->getTaxPercentage();
			$tax_details['tax_percentage'] = $this->getTaxPercentage();
			$tax_details['tax_menu_price'] = $this->getTaxMenuPrice();
			$tax_details['tax_delivery_charge'] = $this->getTaxDeliveryCharge();
			
		}
		return $tax_details;
	}

	public function getTaxMode() {
		$this->db->select('value');
		$this->db->from('settings');
		$this->db->where('item','tax_mode');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array()[0]['value'];
		}

		if($result == 1){
			return "Active";
		}else{
			return "In-Active";
		}
	}

	public function getTaxPercentage() {
		$this->db->select('value');
		$this->db->from('settings');
		$this->db->where('item','tax_percentage');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array()[0]['value'];
		}
		
		return $result;
	}

	public function getTaxMenuPrice() {
		$this->db->select('value');
		$this->db->from('settings');
		$this->db->where('item','tax_menu_price');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array()[0]['value'];
		}

		if($result == 1){
			return "Apply tax on top of my menu price";
		}else{
			return "Menu price already include tax";
		}
	}

	public function getTaxDeliveryCharge() {
		$this->db->select('value');
		$this->db->from('settings');
		$this->db->where('item','tax_delivery_charge');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array()[0]['value'];
		}

		if($result == 1){
			return "YES";
		}else{
			return "NO";
		}
	}

	public function getlanguage() {
		$this->db->select('value');
		$this->db->from('settings');
		$this->db->where('item','language_id');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array()[0]['value'];
		}
		
		return $result;
	}

	public function getCoupons($location_id = '') {
		$this->db->select('coupon_id, name, code, type, is_all_menus_discount, is_one_time_discount');
		$this->db->from('coupons');
		$this->db->where('status',1);
		$this->db->where('location_id',$location_id);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
		exit;
	}

	public function getpolicies() {
		$this->db->select('*');
		$this->db->from('pages');
		$this->db->where('status',1);
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
		exit;
	}

	public function getMapKey() {
		
		$this->db->select('value');
		$this->db->from('settings');
		$this->db->where('item','maps_api_key');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0]['value'];
		}else{
			return "";
		}
		
	
	}
	/*
	* Customer coupons list
	*/
	public function getCouponList($used_coupons = '', $coupon_type = array(), $menu_ids = '') 
	{
		$this->db->select('C.coupon_id, C.name, C.code, C.type, C.discount, min_total, 0 as menu_ids, C.is_all_menus_discount, C.is_one_time_discount, is_fd_type_percent, C.is_public_access');
		$this->db->from('coupons C');	
		if(!empty($menu_ids)){
			$this->db->join('coupon_menus_association CMA','C.coupon_id = CMA.coupon_id');	
			$this->db->where('CMA.menu_id IN ('.$menu_ids.')');	
		}
		$this->db->where('C.status','1');	
			
		$this->db->where("C.period_start_date <= '".date('Y-m-d')."' and C.period_end_date >= '".date('Y-m-d')."'");
		if(!empty($used_coupons)){
			$used_coupons = explode(",", $used_coupons);
			$this->db->where_not_in('code',$used_coupons);
		}		
		if(!empty($coupon_type)){
			$this->db->where_in('type',$coupon_type);
		}
		$query = $this->db->get();		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Customer coupons list for FD (Full Discount) coupon
	*/
	public function getCouponList_fd($used_coupons = '', $coupon_type = '', $location_id = '', $return_all_codes = 0) 
	{
		$this->db->select('C.coupon_id, C.name, C.code, C.type, C.discount, C.min_total, 0 as menu_ids, C.is_all_menus_discount, C.is_one_time_discount, is_fd_type_percent');
		$this->db->from('coupons C');		
		$this->db->where('C.status','1');

		$this->db->where("C.period_start_date <= '".date('Y-m-d')."' and C.period_end_date >= '".date('Y-m-d')."'");
		if(!empty($used_coupons)){
			$used_coupons = explode(",", $used_coupons);
			$this->db->where_not_in('code',$used_coupons);
		}

		$this->db->where(" type = 'FD' ");	
		// Below condition to return all codes
		if(!empty($return_all_codes)){
			$this->db->select('C.is_public_access');
			$this->db->or_where(" (is_public_access = 0 AND location_id = '".$location_id."' )");
		}		

		$query = $this->db->get();	
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Customer coupons list for others coupon (except FD)
	*/
	public function getCouponList_others($used_coupons = '', $coupon_type = '', $menu_ids = '') 
	{
		$this->db->select('C.coupon_id, name, code, type, discount, min_total, GROUP_CONCAT(CMA.menu_id) as menu_ids, is_all_menus_discount, is_one_time_discount, is_fd_type_percent, C.is_public_access');
		$this->db->from('coupons C');
		if(!empty($menu_ids)){
			$this->db->join('coupon_menus_association CMA','C.coupon_id = CMA.coupon_id');	
			$this->db->where('CMA.menu_id IN ('.$menu_ids.')');	
		}
		$this->db->where('C.status','1');

		$this->db->where("C.period_start_date <= '".date('Y-m-d')."' and C.period_end_date >= '".date('Y-m-d')."'");
		if(!empty($used_coupons)){
			$this->db->where('code',$used_coupons);
		}		
		$this->db->where(" type != 'FD' "); 
		$this->db->group_by('CMA.coupon_id');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0];
		}else{
			return array();
		}
	}

	/*
	* Check Coupon used for customer or not
	*/
	public function check_coupon_used_or_not($emailid = '', $deviceid = '', $coupon_type = '') 
	{		
		$this->db->select('GROUP_CONCAT(DISTINCT coupon_code) as coupon_code');
		$this->db->from('orders');
		if(!empty($emailid) && !empty($deviceid)){
			$this->db->where(" (email = '".$emailid."' OR deviceid = '".$deviceid."') ");
		} else if(!empty($emailid) && empty($deviceid)){
			$this->db->where(" email = '".$emailid."' ");
		}
		if(!empty($coupon_type) && $coupon_type == 'FD'){
			$this->db->where(" coupon_type = 'FD' ");
		} else {
			$this->db->where(" coupon_type != 'FD' ");
		}
		
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0]['coupon_code'];
		} else{
			return '';
		}
	}
	/*
	* Restaurant coupons list by location id
	*/
	public function getRestaurantCoupons($location_id = '') 
	{
		$this->db->select('coupon_id, location_id, name, code, type, discount, min_total, period_start_date, period_end_date, status, is_all_menus_discount, is_one_time_discount, is_fd_type_percent');
		$this->db->from('coupons');
		$this->db->where('status','1');
		$this->db->where('location_id',$location_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}
	}
	/*
	* Restaurant menus of coupon
	*/
	public function getCouponMenus($coupon_id = '', $location_id='') 
	{
		$this->db->select('menus.menu_id, menu_name, menu_price');
		$this->db->from('coupon_menus_association');
		$this->db->join('menus','coupon_menus_association.menu_id = menus.menu_id');
		$this->db->where('coupon_menus_association.coupon_id',$coupon_id);
		$this->db->where('coupon_menus_association.location_id',$location_id);
		$query = $this->db->get();
		if(!empty($query->result_array())){
			return $query->result_array();
		}else{
			return array();
		}
	}
	/*
	* Check Email exists or not
	*/
	public function check_coupon_status($location_id, $coupon_id) 
	{		
		$this->db->from('coupons');
		$this->db->where('location_id', $location_id);
		$this->db->where('coupon_id', $coupon_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	/*
	* 
	*/
	public function update_coupon($post = array())
	{
		extract($post);
		$this->db->set('name', $name);
		$this->db->set('code', $code);
		$this->db->set('type', $type);
		$this->db->set('discount', $discount);
		$this->db->set('min_total', $min_total);
		$this->db->set('period_start_date', $period_start_date);
		$this->db->set('period_end_date', $period_end_date);
		$this->db->set('status', $status);
		$this->db->set('is_one_time_discount', $is_one_time_discount);
		$this->db->set('is_all_menus_discount', $is_all_menus_discount);
		
		$this->db->where('location_id', $location_id);
		$this->db->where('coupon_id', $coupon_id);
		$query = $this->db->update('coupons');
		/*
		* Associate coupon with menu
		*/
		if(!empty($associated_menu_ids) && !empty($associated_menu_ids['menu_ids'])){
			// delete associated menu IDs
			$delete = $this->db->delete('coupon_menus_association',array('coupon_id'=>$coupon_id, 'location_id'=>$location_id));
			// Insert into table
			foreach($associated_menu_ids['menu_ids'] as $key=>$value){		
				$this->db->set('coupon_id', $coupon_id);
				$this->db->set('menu_id', $value['id']);
				$this->db->set('location_id', $location_id);
				$this->db->set('date_added',date('Y-m-d H:i:s'));
				$this->db->set('status', '1');
				$query = $this->db->insert('coupon_menus_association');		
			}
		}
		return $query;
	}

	/*
	* Check menu exists or not
	*/
	public function check_menu_exists_or_not($menu_id = '', $location_id = '') 
	{		
		$this->db->from('menus');
		$this->db->where('menu_id', $menu_id);
		$this->db->where('location_id', $location_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	/*
	* Check variant type exists or not
	*/
	public function check_variant_type_exists_or_not($menu_variant_type_id = '') 
	{		
		$this->db->from('menu_variant_types');
		$this->db->where('menu_variant_type_id', $menu_variant_type_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	/*
	* Insert menu variant
	*/
	public function add_menu_variant_type($post = array())
	{
		extract($post);
		$this->db->set('menu_id', $menu_id);
		$this->db->set('variant_type_name', $variant_type_name);
		$this->db->set('location_id', $location_id);
		$this->db->set('status', $status);
		$this->db->set('date_added', date('Y-m-d H:i:s'));		
		$query = $this->db->insert('menu_variant_types');
		return $query;
	}

	/*
	* Insert menu variant type
	*/
	public function add_menu_variant_type_value($post = array())
	{
		extract($post);
		$this->db->set('menu_variant_type_id', $menu_variant_type_id);
		$this->db->set('type_value_name', $type_value_name);
		$this->db->set('type_value_price', $type_value_price);
		$this->db->set('is_default', $is_default);
		$this->db->set('status', $status);
		$this->db->set('date_added', date('Y-m-d H:i:s'));		
		$query = $this->db->insert('menu_variant_type_values');
		return $query;
	}

	/*
	* Delete menu variant type
	*/
	public function delete_menu_variant_type($menu_variant_type_id = '')
	{
		$this->db->where('menu_variant_type_id', $menu_variant_type_id);
		$query = $this->db->delete('menu_variant_types');
		return $this->db->affected_rows();;
	}

	/*
	* Delete menu variant type value
	*/
	public function delete_menu_variant_type_value($menu_variant_type_value_id = '')
	{
		$this->db->where('menu_variant_type_value_id', $menu_variant_type_value_id);
		$query = $this->db->delete('menu_variant_type_values');
		return $this->db->affected_rows();;
	}

	/*
	* Insert user confirmation to continue subscription
	*/
	public function add_user_confirmation($post = array())
	{
		extract($post);
		$this->db->set('email', $email);
		$this->db->set('purchase_type', $purchase_type);
		$this->db->set('is_agreed_to_continue', $is_agreed_to_continue);
		$this->db->set('date_created', date('Y-m-d H:i:s'));		
		$query = $this->db->insert('workout_video_purchases_user_confirmations');
		return $query;
	}

	/*
	* Lee priest stripe keys
	*/
	public function getleePrieStstripeKeys() 
	{
		$this->db->select('item, value');
		$this->db->from('settings');
		$this->db->where('sort','leepriest');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Lee priest
	*/
	public function getEatrightpdf() 
	{
		$this->db->select('*');
		$this->db->from('eat_right_pdf');
		$this->db->where('is_active','1');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Restaurant coupons list by location id
	*/
	public function getHomeBanner($banner_id = '') 
	{
		$this->db->select('*');
		$this->db->from('banners');
		$this->db->where('status','1');
		$this->db->where('banner_id',$banner_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0];
		}else{
			return array();
		}
	}

	/*
	* Validate coupon
	*/
	public function validate_coupon($location_id, $coupon_code) 
	{		
		$this->db->from('coupons');
		$this->db->where('location_id', $location_id);
		$this->db->where('code', $coupon_code);
		$this->db->where('CURDATE() BETWEEN period_start_date AND period_end_date');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0];
		}else{
			return array();
		}
	}

	/*
	* Get customer cards
	*/
	public function get_customer_cards($customer_email = '', $stripe_card_token = '') 
	{
		$this->db->select('*');
		$this->db->from('customer_credit_cards');
		if(!empty($customer_email)){
			$this->db->where('customer_email',$customer_email);
		}
		if(!empty($stripe_card_token)){
			$this->db->where('stripe_card_token',$stripe_card_token);
		}	
		$query = $this->db->get();
		if(!empty($query->result_array())){
			return $query->result_array();
		}else{
			return array();
		}
	}

}

/* End of file settings_model.php */
