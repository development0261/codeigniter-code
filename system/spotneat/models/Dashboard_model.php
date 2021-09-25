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
 * Dashboard Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Dashboard_model.php
 * @link           http://docs.spotneat.com
 */
class Dashboard_model extends TI_Model {

	public function getStatistics($stat_range = '',$loggedID, $locationIDs ) {

		$results = $range_query = array();

		if ($stat_range === '') return $results;

		if ($stat_range === 'today') {
			$range_query = array('DATE(date_added)' => date('Y-m-d'));
		} else if ($stat_range === 'week') {
			$range_query = 'week';
		} else if ($stat_range === 'month') {
			$range_query = array('MONTH(date_added)' => date('m'));
		} else if ($stat_range === 'year') {
			$range_query = array('YEAR(date_added)' => date('Y'));
		}

		$results['sales'] = $this->getTotalSales($range_query,$locationIDs);
		// $results['lost_sales'] = $this->getTotalLostSales($range_query,$locationIDs);
		$results['customers'] = $this->getTotalDashboardCustomers($range_query,$locationIDs);
		$results['orders'] = $this->getTotalOrders($range_query,$locationIDs);
		// $results['orders_completed'] = $this->getTotalOrdersCompleted($range_query,$locationIDs);
		// $results['delivery_orders'] = $this->getTotalDeliveryOrders($range_query,$locationIDs);
		// $results['collection_orders'] = $this->getTotalCollectionOrders($range_query,$locationIDs);
		// $results['tables_reserved'] = $this->getTotalTablesReserved($range_query,$locationIDs);
		$results['cash_payments'] = $this->getTotalCashPayments($range_query,$locationIDs);
		return $results;
	}

	public function getTotalMenus() {
		return $this->db->count_all('menus');
	}

	public function getTotalSales($range_query,$locationIDs) {
		$total_sales = 0;
		// print_r($range_query);
		// exit;
		if (is_array($range_query) || $range_query == 'week' AND ! empty($range_query)) {
			$this->db->select_sum('order_total', 'total_sales');
			//$this->db->where('status_id >', '0');
			if($range_query == 'week') {
				$cr_date = date('Y-m-d');
				$bt_date = date('Y-m-d', strtotime('-7 days'));
				$dd = "date_added BETWEEN '".$bt_date."' AND '". $cr_date."'";
				$range_query1 = array('date_added BETWEEN' => $dd);
				$this->db->where($dd);
			} else {
				$this->db->where($range_query);	
			}
			
			if($locationIDs != ''){
				$this->db->where_in('location_id', $locationIDs);	
			}
			$query = $this->db->get('orders');
			// print_r($this->db->last_query());
			// print_r($query->row_array());
			// exit;
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$total_sales = $row['total_sales'] != '' ? $row['total_sales'] : '0';
			} else {
				$total_sales = '0';
			}
		}

		return $total_sales;
	}

	public function getTotalLostSales($range_query,$locationIDs) {
		$total_lost_sales = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->select_sum('order_total', 'total_lost_sales');
			if($range_query == 'week') {
				$cr_date = date('Y-m-d');
				$bt_date = date('Y-m-d', strtotime('-7 days'));
				$dd = "date_added BETWEEN '".$bt_date."' AND '". $cr_date."'";
				$range_query1 = array('date_added BETWEEN' => $dd);
				$this->db->where($dd);
			} else {
				$this->db->where($range_query);	
			}
			// $this->db->where($range_query);
			if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
			$this->db->group_start();
			$this->db->where('status_id <=', '0');
			$this->db->or_where('status_id', $this->config->item('canceled_order_status'));
			$this->db->group_end();

			$query = $this->db->get('orders');
			// print_r($this->db->last_query());
			// exit;
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$total_lost_sales = $row['total_lost_sales'] > '0' ? $row['total_lost_sales'] : '0';
			} else {
				$total_lost_sales = 0;
			}
		}

		return $total_lost_sales;
	}

	public function getTotalCashPayments($range_query = '',$locationIDs) {
		$cash_payments = 0;

		if (is_array($range_query) || $range_query == 'week' AND ! empty($range_query)) {
			$this->db->select_sum('order_total', 'cash_payments');
			$this->db->where('status_id >', '0');
			$this->db->where('payment', 'cash');
			// $this->db->where($range_query);
			if($range_query == 'week') {
				$cr_date = date('Y-m-d');
				$bt_date = date('Y-m-d', strtotime('-7 days'));
				$dd = "date_added BETWEEN '".$bt_date."' AND '". $cr_date."'";
				$range_query1 = array('date_added BETWEEN' => $dd);
				$this->db->where($dd);
			} else {
				$this->db->where($range_query);	
			}
			if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
			$query = $this->db->get('orders');
			// print_r($this->db->last_query());
			// exit;
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$cash_payments = $row['cash_payments'] != '' ? $row['cash_payments'] : '0' ;
			} else {
				$cash_payments = '0';
			}
		}

		return $cash_payments;
	}

	public function getTotalDashboardCustomers($range_query,$locationIDs) {
		$total_customers = 0;
		if (is_array($range_query) || $range_query == 'week' AND ! empty($range_query)) {
			if($range_query == 'week') {
				$cr_date = date('Y-m-d');
				$bt_date = date('Y-m-d', strtotime('-7 days'));
				$dd = "date_added BETWEEN '".$bt_date."' AND '". $cr_date."'";
				$range_query1 = array('date_added BETWEEN' => $dd);
				$this->db->where($dd);				

			} else {
				$key =  array_keys($range_query) ;
				$value =  array_values($range_query) ;
				$getVal = $this->db->dbprefix('customers'); 
				$keyReplace = str_replace('date_added',"$getVal.date_added",$key[0]) ; 
				$newArr[$keyReplace] = $value[0];
				$this->db->where($newArr);	
			}
			//$this->db->where_in('location_id',$locationIDs);
			$this->db->distinct();
			$this->db->select('customer_id');
			$this->db->from('customers');		
			
			$query = $this->db->get();
			$total_customers = $query->num_rows() > 0 ? $query->num_rows() : '0';
		}else{
			if($locationIDs){
				//$this->db->where_in('location_id',$locationIDs);
			}
			
			$this->db->distinct();
			$this->db->select('customer_id');
			$this->db->from('customers');	
			$query = $this->db->get();
			$total_customers = $query->num_rows() > 0 ? $query->num_rows() : '0';

		}
		return $total_customers;
	}

	public function getTotalCustomers($range_query,$locationIDs) {
		$total_customers = 0;
		
		if (is_array($range_query) || $range_query == 'week' AND ! empty($range_query)) {

			if($range_query == 'week') {
				$cr_date = date('Y-m-d');
				$bt_date = date('Y-m-d', strtotime('-7 days'));
				$dd = "date_added BETWEEN '".$bt_date."' AND '". $cr_date."'";
				$range_query1 = array('date_added BETWEEN' => $dd);
				$this->db->where($dd);
			} else {
				$key =  array_keys($range_query) ;
				$value =  array_values($range_query) ;
				$getVal = $this->db->dbprefix('customers'); 
				$keyReplace = str_replace('date_added',"$getVal.date_added",$key[0]) ; 
				$newArr[$keyReplace] = $value[0];
				$this->db->where($newArr);				
			}
			
			
			$this->db->from('customers');
			
			// if($locationIDs != ''){
			// $this->db->join('reservations', 'reservations.customer_id = customers.customer_id', 'left');	
			// $this->db->where_in('reservations.location_id', $locationIDs);	
			// $this->db->group_by('reservations.customer_id');
			// }
			$query = $this->db->get();
			// print_r($this->db->last_query());
			// exit;
			// print_r($this->db->last_query());
			// exit;
			$total_customers = $query->num_rows() > 0 ? $query->num_rows() : '0';
		}
	
		return $total_customers;
	}

	public function getTotalOrders($range_query,$locationIDs) {
		$total_orders = 0;

		if (is_array($range_query) || $range_query == 'week' AND ! empty($range_query)) {
			// $this->db->where($range_query);
			if($range_query == 'week') {
				$cr_date = date('Y-m-d');
				$bt_date = date('Y-m-d', strtotime('-7 days'));
				$dd = "date_added BETWEEN '".$bt_date."' AND '". $cr_date."'";
				$range_query1 = array('date_added BETWEEN' => $dd);
				$this->db->where($dd);
			} else {
				$this->db->where($range_query);	
			}

			$this->db->from('orders');
			if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
			// print_r($this->db->last_query());
			// print_r($query->row_array());
			// exit;
			$cn = $this->db->count_all_results();			
			$total_orders = $cn > 0 ? $cn : '0';
		}

		return $total_orders;
	}

	public function getTotalOrdersCompleted($range_query = '',$locationIDs) {
		$total_orders_completed = 0;
		if (is_array($range_query)) {
			
			$this->db->where($range_query);
			$this->db->where_in('status_id', (array) $this->config->item('completed_order_status'));
			$this->db->from('orders');
			if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
			$query = $this->db->get();
			// print_r($this->db->last_query());
			// $cn = $query->num_rows();
			// print_r($query);
			// $cn = $this->db->count_all_results();

			$total_orders_completed = !empty($query)  &&  $query->num_rows() > 0 ? $query->num_rows() : '0';
		}

		return $total_orders_completed;
	}

	public function getTotalDeliveryOrders($range_query = '',$locationIDs) {
		$total_delivery_orders = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->where('order_type', '1');
			$this->db->from('orders');
			if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
			$cn = $this->db->count_all_results();
			$total_delivery_orders = $cn > 0 ? $cn : '0';
		}

		return $total_delivery_orders;
	}

	public function getTotalCollectionOrders($range_query = '',$locationIDs) {
		$total_collection_orders = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->where('order_type', '2');
			$this->db->from('orders');
			if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
			$cn = $this->db->count_all_results();
			$total_collection_orders = $cn > 0 ? $cn : '0';
		}

		return $total_collection_orders;
	}

	public function getTotalTables() {
		return $this->db->count_all_results('tables');
	}

	public function getTotalTablesReserved($range_query = '',$locationIDs) {
		$total_tables_reserved = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->where('status >', '0');
			$this->db->from('reservations');
			if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
			$cn = $this->db->count_all_results();
			$total_tables_reserved = $cn > 0 ? $cn : '0';
		}

		return $total_tables_reserved;
	}

	public function getTodayChart($hour = FALSE, $locationIDs ) {
		$result = array();
		$getCusPre = $this->db->dbprefix('customers'); 
		$this->db->where("DATE($getCusPre.date_added)", 'DATE(NOW())');
		$this->db->where("HOUR($getCusPre.date_added)", $hour);
		if($locationIDs != ''){
			$this->db->join('reservations', 'reservations.customer_id = customers.customer_id', 'left');	
			$this->db->where_in('reservations.location_id', $locationIDs);	
			$this->db->group_by('reservations.customer_id');
			}

		$this->db->order_by("$getCusPre.date_added", 'ASC');
		if ($this->db->from('customers')) {
			$query = $this->db->get();
			$result['customers'] = $query->num_rows();
		}

		$this->db->where('status_id >', '0');
		$this->db->where('DATE(date_added)', 'DATE(NOW())', FALSE);
		$this->db->where('HOUR(order_time)', $hour);
		if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
		$this->db->group_by('HOUR(order_time)');
		$this->db->order_by('date_added', 'ASC');
		if ($this->db->from('orders')) {
			$result['orders'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}

		$this->db->where('status >', '0');
		$this->db->where('DATE(reserve_date)', 'DATE(NOW())', FALSE);
		$this->db->where('HOUR(reserve_time)', $hour);
		if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
		$this->db->group_by('HOUR(reserve_time)');
		$this->db->order_by('reserve_date', 'ASC');
		if ($this->db->from('reservations')) {
			$result['reservations'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}

		$this->db->where('DATE(date_added)', 'DATE(NOW())', FALSE);
		$this->db->where('HOUR(date_added)', $hour);
		$this->db->order_by('date_added', 'ASC');
		if ($this->db->from('reviews')) {
			$result['reviews'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}

		return $result;
	}

	public function getDateChart($date = FALSE, $locationIDs ) {
		
		$result = array();
		$getCusPre = $this->db->dbprefix('customers'); 
		$this->db->where("DATE($getCusPre.date_added)", $date);
		// if($locationIDs != ''){
		// 	$this->db->join('reservations', 'reservations.customer_id = customers.customer_id', 'left');	
		// 	$this->db->where_in('reservations.location_id', $locationIDs);
		// 	$this->db->group_by('reservations.customer_id');	
		// 	}
		//$this->db->group_by("DAY($getCusPre.date_added)");
		
		if ($this->db->from('customers')) {
			$query = $this->db->get();
			$result['customers'] = $query->num_rows() > 0 ? $query->num_rows() : '0';
		}

		$this->db->where('status_id >', '0');
		$this->db->where('DATE(date_added)', $date);
		if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
		//$this->db->group_by('DAY(date_added)');
		if ($this->db->from('orders')) {
			$query = $this->db->get();
			$result['orders'] = $query->num_rows() > 0 ? $query->num_rows() : '0';
		}

		$this->db->where('status >', '0');
		$this->db->where('DATE(reserve_date)', $date);
		if($locationIDs != ''){
			$this->db->where_in('location_id', $locationIDs);	
			}
		$this->db->group_by('DAY(reserve_date)');
		if ($this->db->from('reservations')) {
			$result['reservations'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}
		//echo "<pre>"; echo($this->db->last_query()); 
		$this->db->where('DATE(date_added)', $date);
		$this->db->group_by('DAY(date_added)');
		if ($this->db->from('reviews')) {
			$result['reviews'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}
		return $result;
	}

	public function getYearChart($year = FALSE, $month = FALSE) {
		$result = array();
		
		$this->db->where('YEAR(date_added)', (int) $year);
		$this->db->where('MONTH(date_added)', (int) $month);
		$this->db->group_by('MONTH(date_added)');
		if ($this->db->from('customers')) {
			$result['customers'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}

		$this->db->where('status_id >', '0');
		$this->db->where('YEAR(date_added)', (int) $year);
		$this->db->where('MONTH(date_added)', (int) $month);
		$this->db->group_by('MONTH(date_added)');
		if ($this->db->from('orders')) {
			$result['orders'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}

		$this->db->where('status >', '0');
		$this->db->where('YEAR(reserve_date)', (int) $year);
		$this->db->where('MONTH(reserve_date)', (int) $month);
		$this->db->group_by('MONTH(reserve_date)');
		if ($this->db->from('reservations')) {
			$result['reservations'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}

		$this->db->where('YEAR(date_added)', (int) $year);
		$this->db->where('MONTH(date_added)', (int) $month);
		$this->db->group_by('MONTH(date_added)');
		if ($this->db->from('reviews')) {
			$result['reviews'] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
		}

		return $result;
	}

	public function getReviewChart($rating_id, $menu_id) {
		$total_ratings = 0;
		$this->db->where('menu_id', $menu_id);
		$this->db->where('rating_id', $rating_id);
		$this->db->from('reviews');
		$total_ratings = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';

		return $total_ratings;
	}

	public function getTopCustomers($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('customers.customer_id, customers.first_name, customers.last_name, COUNT(order_id) AS total_orders');
			$this->db->select_sum('order_total', 'total_sale');
			$this->db->from('customers');
			$this->db->join('orders', 'orders.customer_id = customers.customer_id', 'left');
			$this->db->group_by('customer_id');
			$this->db->order_by('total_orders', 'DESC');

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getNewsFeed($number = 5, $expiry = 3) {
		$this->load->library('feed_parser');

		$this->feed_parser->set_feed_url('http://feeds.feedburner.com/Spotneat');
		$this->feed_parser->set_cache_life($expiry);

		return $this->feed_parser->getFeed($number);
	}

	public function getLocationStatus($location_id){

		$this->db->select('location_status');
		$this->db->where('location_id', $location_id);
		$this->db->from('locations');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$location_status = $row['location_status'];
		}
		return $location_status;
	}
	public function updateLocationStatus($location_id,$location_status){

		$this->db->set('location_status', $location_status);
		$this->db->where('location_id', $location_id);
		$this->db->update('locations');
		$query = $this->db->get();
		
		return TRUE;
	}

	public function getNewCustomerDateChart($date = FALSE, $locationIDs ) {
		$result = array();
		foreach ($locationIDs as $loc_id) {
			$getCusPre = $this->db->dbprefix('customers');
			$this->db->where("DATE($getCusPre.date_added)", $date);
			$this->db->join('orders', 'orders.customer_id = customers.customer_id', 'left');
			$this->db->where('orders.location_id', $loc_id);
			$this->db->group_by('orders.customer_id');		
			$this->db->group_by("DAY($getCusPre.date_added)"); 
			$this->db->from('customers');
			$query = $this->db->get();	
			$result[$loc_id] = $query->num_rows() > 0 ? $query->num_rows() : '0';			
        }
		return $result;
	}
	public function getSalesOrderDateChart($date = FALSE, $locationIDs ) {
		$result = array();
		foreach ($locationIDs as $loc_id) {
			$this->db->select_sum('order_total');
			$this->db->where('DATE(date_added)', $date);
			$this->db->where('location_id', $loc_id);	
			//$this->db->group_by('DAY(date_added)');
			$this->db->from('orders');
			$query=$this->db->get();
			$result[$loc_id] = $query->row()->order_total;
			//$result[$loc_id] = $this->db->count_all_results() > 0 ? $this->db->count_all_results() : '0';
			
        }
		return $result;
	}
	public function getTopSalesMenus($filter = array(),$locationIDs) {
		if ($this->db->limit($filter['limit'])) {
			$this->db->select('menus.menu_id, menus.menu_name,menus.location_id,menus.menu_photo, menus.menu_price, COUNT(order_menu_id) AS total_orders');
			//$this->db->select_sum('order_total', 'total_sale');
			$this->db->from('menus');
			// $this->db->where_in('menus.location_id', $locationIDs);
			$this->db->where('menus.location_id', $locationIDs);
			$this->db->join('order_menus', 'order_menus.menu_id = menus.menu_id', 'left');
			$this->db->group_by('menu_id');
			$this->db->order_by('total_orders', 'DESC');

			$query = $this->db->get();
			$result = array();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
			return $result;
		}
	}

	public function getNumberOrder(){
		
	}
}

/* End of file dashboard_model.php */
/* Location: ./system/spotneat/models/dashboard_model.php */