<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Dashboard extends Admin_Controller {
	// public static $chartNewCustomerData = array();
	// public static $chartSalesData = array();
	// public static $chartTop10MenuData = array();
	
	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->model('Dashboard_model');
        $this->load->model('Locations_model');
        $this->load->model('Themes_model');
        $this->load->model('Updates_model');

        $this->load->library('currency'); // load the currency library

		$this->lang->load('dashboard');
		$this->load->helper('user');
		$this->hello = array();
	}

	public function index() {
		
		// $location_id = $this->user->getLocationId();
		$logged_userID = $this->user->getStaffId();
		if($this->input->post('location_status')!=''){
			$loc_status = $this->input->post('location_status');
			$this->Dashboard_model->updateLocationStatus($location_id,$loc_status);
			
		}
		
		$data['location_status'] = $this->Dashboard_model->getLocationStatus($location_id);

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		//$this->template->setButton($this->lang->line('button_check_updates'), array('class' => 'btn btn-default', 'href' => site_url('updates')));

        $this->template->setStyleTag(assets_url('js/daterange/daterangepicker-bs3.css'), 'daterangepicker-css', '100400');
        $this->template->setScriptTag(assets_url('js/daterange/moment.min.js'), 'daterange-moment-js', '1000451');
        $this->template->setScriptTag(assets_url('js/daterange/daterangepicker.js'), 'daterangepicker-js', '1000452');
        $this->template->setStyleTag(assets_url('js/morris/morris.css'), 'chart-css', '100500');
        $this->template->setScriptTag(assets_url('js/morris/raphael-min.js'), 'raphael-min-js', '1000453');
        $this->template->setScriptTag(assets_url('js/morris/morris.min.js'), 'morris-min-js', '1000454');

		$data['total_menus'] 		    = $this->Dashboard_model->getTotalMenus();
		$data['current_month'] 			= mdate('%Y-%m', time());

		$data['months'] = array();
		$pastMonth = date('Y-m-d', strtotime(date('Y-m-01') .' -3 months'));
		$futureMonth = date('Y-m-d', strtotime(date('Y-m-01') .' +3 months'));
		for ($i = $pastMonth; $i <= $futureMonth; $i = date('Y-m-d', strtotime($i .' +1 months'))) {
			$data['months'][mdate('%Y-%m', strtotime($i))] = mdate('%F', strtotime($i));
		}

		//$data['default_location_id'] = $this->config->item('default_location_id');
		
		/* Unused hided for now
		$data['locations'] = array();
		if($logged_userID ==11){
		$results = $this->Locations_model->getLocations();
		}else{
		$results = $this->Locations_model->getLocationAddedBy($logged_userID,'array');	
		}
		foreach ($results as $result) {
			$data['locations'][] = array( 
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}*/
		$data['staff_group_id']  = $this->session->user_info['staff_group_id'];
        $filter = array();
        $filter['page'] = '1';
        $filter['limit'] = '5';
        if($logged_userID == 11){
        $data['activities'] = array();
        $this->load->model('Activities_model');
        $results = $this->Activities_model->getList($filter);
        foreach ($results as $result) {
            $data['activities'][] = array(
                'activity_id'	    => $result['activity_id'],
                'icon'			    => 'fa fa-tasks',
                'message'			=> $result['message'],
                'time'		        => mdate('%h:%i %A', strtotime($result['date_added'])),
                'time_elapsed'		=> time_elapsed($result['date_added']),
                'state'			    => $result['status'] === '1' ? 'read' : 'unread',
            );
          }
    	}

        $data['top_customers'] = array();
		$filter['limit'] = 6;
		$results = $this->Dashboard_model->getTopCustomers($filter);
        foreach ($results as $result) {
            $data['top_customers'][] = array(
                'first_name'	    => $result['first_name'],
                'last_name'	    	=> $result['last_name'],
                'total_orders'		=> $result['total_orders'],
                'total_sale'		=> $this->currency->format($result['total_sale']),
            );
        }

        $filter = array();
		$filter['page'] = '1';
		$filter['limit'] = 10;
		$filter['sort_by'] = 'orders.date_added';
		$filter['order_by'] = 'DESC';
		$data['order_by_active'] = 'DESC';

		// if ($this->user->isStrictLocation()) {
		// 	$filter['filter_location'] = $this->user->getLocationId();
		// }

		/*$data['orders'] = array();
        $this->load->model('Orders_model');
        $results = $this->Orders_model->getList($filter,"",isAdminID($logged_userID));
        //echo $this->db->last_query(); 
		foreach ($results as $result) {
			$current_date = mdate('%d-%m-%Y', time());
			$date_added = mdate('%d-%m-%Y', strtotime($result['date_added']));

			if ($current_date === $date_added) {
				$date_added = $this->lang->line('text_today');
			} else {
				$date_added = mdate('%d %M %y', strtotime($date_added));
			}

			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
                'order_status'		=> $result['status_name'],
                'status_color'		=> $result['status_color'],
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_type' 		=> ($result['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection'),
				'date_added'		=> $date_added,
				'edit' 				=> site_url('orders/edit?id=' . $result['order_id'])
			);
		}*/

		$data['news_feed'] = ''; //$this->Dashboard_model->getNewsFeed();  // Get four items from the feed

		if ($this->config->item('auto_update_currency_rates') === '1') {
			$this->load->model('Currencies_model');
			if ($this->Currencies_model->updateRates()) {
				$this->alert->set('success_now', $this->lang->line('alert_rates_updated'));
			}
		}


		$e = $this->user->getRestaurant($this->user->getStaffId());
		$l_id =$location_id;
		
		$c =$this->db->group_by('customer_id')->get_where('orders',array('location_id'=>$l_id))->num_rows();
		$c1 =$this->db->get_where('customers',array('location_id'=>$l_id))->num_rows();
		
		if ($data['staff_group_id'] != 11) {
			$locationGroup=array();
			if($data['staff_group_id'] == 12){
				$locationGroup [] =$this->session->location_id;
			}else{
				$data['LocationList']=$this->Locations_model->getLocationAddedByFranchisee(isAdminID($logged_userID),'loc_id');
				$data['Location_id']=$data['LocationList'][0]['location_id'];
				$data['Location_name']=$data['LocationList'][0]['location_name'];
				foreach ($data['LocationList'] as $loc) {
					$locationGroup [] =$loc['location_id'];			
				}
			}
			//$this->db->select('COUNT(customer_id) AS total_customer', FALSE);
			
				
			$data['customers_all']=$this->Dashboard_model->getTotalDashboardCustomers('',$locationGroup);
			$data['customers']=$data['customers_all'];
			
			$this->db->select('SUM(order_total) AS total_sales,COUNT(order_id) AS total_order', FALSE);
			$this->db->where_in('location_id',$locationGroup);
			$query = $this->db->get('orders');
			$result = $query->row_array();
			
			$data['orders_all'] =number_format($result['total_order'],2);
			$data['orders']=$data['orders_all'];
			$data['sales_all'] = $this->currency->getCurrencySymbol().' '.number_format($result['total_sales'],2);
			$data['sales'] = $data['sales_all']; 
			
		}else{
			$data['customers_all'] = $this->Dashboard_model->getTotalDashboardCustomers('','');
			$data['orders_all']    = $this->db->get('orders')->num_rows();
			$data['customers']=$data['customers_all'];
			$data['orders']=$data['orders_all'];

			$this->db->select('SUM(order_total) AS total_sales', FALSE);
			$query = $this->db->get('orders');
			$result = $query->row_array();
			$data['sales_all'] = $this->currency->getCurrencySymbol().' '.number_format($result['total_sales'],2);
			$data['sales'] = $data['sales_all'] ;
		}

		
		if($logged_userID!='11' && $logged_userID!=''){
			$this->template->render('dashboard', $data);
		}else{
			$this->template->render('dashboard', $data);
		}
	}

	public function statistics() {
		$json = array();

		// $stat_range = 'today';
		if ($this->input->get('stat_range')) {
			$stat_range = $this->input->get('stat_range');
		}else{
			$stat_range ="year";
		}

		$logged_userID = $this->user->getStaffId();
		// echo $logged_userID;
		$data['staff_group_id']  = $this->session->user_info['staff_group_id'];
		$getUserLocs = $this->Locations_model->getLocationAddedBy(isAdminID($logged_userID),'loc_id');
		
		if($data['staff_group_id'] != 11){
			if($data['staff_group_id'] == 12){
				$getUserLocs [] =$this->session->location_id;
			}else{
				$data['LocationList']=$this->Locations_model->getLocationAddedByFranchisee(isAdminID($logged_userID),'loc_id');
				$data['Location_id']=$data['LocationList'][0]['location_id'];
				$data['Location_name']=$data['LocationList'][0]['location_name'];
				foreach ($data['LocationList'] as $loc) {
					$getUserLocs [] =$loc['location_id'];			
				}
			}
		}

		//print_r($getUserLocs);
		// exit;

		$result = $this->Dashboard_model->getStatistics($stat_range,isAdminID($logged_userID),$getUserLocs );
		$json['sales'] 				= (empty($result['sales'])) ? $this->currency->format('0.00') : $this->currency->format($result['sales']);
		$json['lost_sales'] 		= (empty($result['lost_sales'])) ? $this->currency->format('0.00') : $this->currency->format($result['lost_sales']);
		$json['cash_payments'] 		= (empty($result['cash_payments'])) ? $this->currency->format('0.00') : $this->currency->format($result['cash_payments']);
		$json['customers'] 			= (empty($result['customers'])) ? '0' : $result['customers'];
		$json['orders'] 			= (empty($result['orders'])) ? '0' : $result['orders'];
		$json['orders_completed'] 	= (empty($result['orders_completed'])) ? '0' : $result['orders_completed'];
		$json['delivery_orders'] 	= (empty($result['delivery_orders'])) ? '0' : $result['delivery_orders'];
		$json['collection_orders'] 	= (empty($result['collection_orders'])) ? '0' : $result['collection_orders'];
		$json['tables_reserved'] 	= (empty($result['tables_reserved'])) ? '0' : $result['tables_reserved'];
		$json['result'] =$result;
		// print_r($getUserLocs);
		// exit;
		$this->output->set_output(json_encode($json));
	}

	public function chart() {
		$json = array();
		$results = array();

        $json['labels'] = array('Total Customers', 'Total Orders', 'Total Reservations', 'Total Reviews');
        $json['colors'] = array('#63ADD0', '#5CB85C', '#337AB7', '#D9534F');

        $dateRanges = '1';
        if ($this->input->get('start_date') AND $this->input->get('start_date') !== 'undefined') {
            if ($this->input->get('end_date') AND $this->input->get('end_date') !== 'undefined') {
                $dateRanges = $this->getDatesFromRange($this->input->get('start_date'), $this->input->get('end_date'));
            }
        }

        $timestamp = strtotime($this->input->get('start_date'));

        $logged_userID = $this->user->getStaffId();

		$getUserLocs = $this->Locations_model->getLocationRestaurantBy(isAdminID($logged_userID),'loc_id');
		
        if (count($dateRanges) <= 1) {
            for ($i = 0; $i < 24; $i++) {
                $data = $this->Dashboard_model->getTodayChart($i,$getUserLocs);
                $data['time'] = mdate('%H:%i', mktime($i, 0, 0, date('n', $timestamp), date('j', $timestamp), date('Y', $timestamp)));
                $results[] = $data;
            }
        } else {
            for ($i = 0; $i < count($dateRanges); $i++) {
                $data = $this->Dashboard_model->getDateChart($dateRanges[$i],$getUserLocs);
                $data['time'] = mdate('%d %M', strtotime($dateRanges[$i]));
                $results[] = $data;
            }
        }

		if (!empty($results)) {
            foreach ($results as $key => $value) {
                $json['data'][] = $value;
			}
			$_SESSION['chartReportAll']=$json['data'];
        }

		$this->output->set_output(json_encode($json));
	}


	public function chartCustomer() {
		$json = array();
		$results = array();
		$getUserLocs =array();
        $json['colors'] = array('#63ADD0', '#5CB85C', '#337AB7', '#D9534F');

		$dateRanges = '1';
		$logged_userID = $this->user->getStaffId();
		$getLocationList = $this->Locations_model->getLocationAddedByFranchisee(isAdminID($logged_userID),'loc_id');
		foreach ($getLocationList as $loc) {
			$json['labels'][] = $loc['location_name'];
			$json['ykeys'][] = $loc['location_id'];
			$getUserLocs[] =$loc['location_id'];
			
		}

		$timestamp = strtotime($this->input->get('start_date'));
        if ($this->input->get('start_date') AND $this->input->get('start_date') !== 'undefined') {
            if ($this->input->get('end_date') AND $this->input->get('end_date') !== 'undefined') {
                $dateRanges = $this->getDatesFromRange($this->input->get('start_date'), $this->input->get('end_date'));
            }
        }
		
		for ($i = 0; $i < count($dateRanges); $i++) {
			$data = $this->Dashboard_model->getNewCustomerDateChart($dateRanges[$i],$getUserLocs);
			$data['time'] = mdate('%d %M', strtotime($dateRanges[$i]));
			$results[] = $data;
		}
		if (!empty($results)) {
            foreach ($results as $key => $value) {
                $json['data'][] = $value;
			}
			$_SESSION['chartNewCustomerData']=$json['data'];
        }

		$this->output->set_output(json_encode($json));
	}
	public function chartSalesOrder() {
		$json = array();
		$results = array();
		$getUserLocs =array();
		$json['colors'] = array('#63ADD0', '#5CB85C', '#337AB7', '#D9534F');
		$dateRanges = '1';
		$logged_userID = $this->user->getStaffId();

		$getLocationList = $this->Locations_model->getLocationAddedByFranchisee(isAdminID($logged_userID),'loc_id');
		foreach ($getLocationList as $loc) {
			$json['labels'][] = $loc['location_name'];
			$json['ykeys'][] = $loc['location_id'];
			$getUserLocs[] =$loc['location_id'];			
		}

		$timestamp = strtotime($this->input->get('start_date'));
        if ($this->input->get('start_date') AND $this->input->get('start_date') !== 'undefined') {
            if ($this->input->get('end_date') AND $this->input->get('end_date') !== 'undefined') {
                $dateRanges = $this->getDatesFromRange($this->input->get('start_date'), $this->input->get('end_date'));
            }
        }
		for ($i = 0; $i < count($dateRanges); $i++) {
			$data = $this->Dashboard_model->getSalesOrderDateChart($dateRanges[$i],$getUserLocs);
			$data['time'] = mdate('%d %M', strtotime($dateRanges[$i]));
			$results[] = $data;
		}
		if (!empty($results)) {
            foreach ($results as $key => $value) {
                $json['data'][] = $value;
			}
			$_SESSION['chartSalesData']=$json['data'];
        }

		$this->output->set_output(json_encode($json));
	}
	public function chartTopMenuItem() {
		$json = array();
		$results = array();
		$logged_userID = $this->user->getStaffId();
		$location_id = $this->input->get('locationId');
		$getUserLocs = $this->Locations_model->getLocationAddedBy(isAdminID($logged_userID),'loc_id');
        $json['colors'] = array('#63ADD0', '#5CB85C', '#337AB7', '#D9534F');

		$filter['page'] = '1';
		$filter['limit'] = '10';
		$data['Location_id']="xyz";
		$menulist = $this->Dashboard_model->getTopSalesMenus($filter,$location_id);
		if (!empty($menulist)) {
			foreach ($menulist as $menu) {
				$json['data'][] = array(
					'menu_id'		=> $menu['menu_id'],
					'menu_name' 	=> $menu['menu_name'],
					'total_orders'	=> $menu['total_orders'],
					'menu_price'	=> $menu['menu_price']
					// 'menu_photo'=> $menu['menu_photo'],
				);		
			}
			$_SESSION['chartTop10MenuData']=$json['data'];
		}
		$this->output->set_output(json_encode($json));		
	}

    private function getDatesFromRange($start, $end) {
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(
            new DateTime($start),
            $interval,
            $realEnd
        );

        foreach($period as $date) {
            $array[] = $date->format('Y-m-d');
        }

        return $array;
    }

    public function admin() {
		$this->index();
	}
	public function change_lang(){
		if($_POST['lang'] == 'عربى'){	 
			$_SESSION['admin_lang'] = 'arabic';
			$lang = 'arabic';
			$_SESSION['dir'] = 'rtl';
			$GLOBALS['admin_lan'] =  'arabic';
			
		}
		else if($_POST['lang'] == 'spanish'){	 
			$_SESSION['admin_lang'] = 'spanish';
			$lang = 'spanish';
			$_SESSION['dir'] = 'ltr';
			$GLOBALS['admin_lan'] =  'spanish';
			
		}
		else {
			$_SESSION['admin_lang'] = 'english';
			$_SESSION['dir'] = 'ltr';
			$lang = 'english';
			$GLOBALS['admin_lan'] =  'english';
		}   
	}

	public function exports_data1(){
		$reportBy = $this->input->get('reportBy') ?$this->input->get('reportBy') : 'chartTop10MenuData';
		$list =$_SESSION[$reportBy];
		$json = array();
		$filename = 'franchisee_'.date('Ymd').'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/csv; "); 
		$file = fopen('php://output', 'w');

		foreach ($list as $line){
		 //fputcsv($file,$line);
		}
		fclose($file);
		// exit;
		$this->output->set_output(json_encode($list));	
	}
	public function exports_data(){
		$reportBy = $this->input->get('reportBy') ?$this->input->get('reportBy') : 'chartTop10MenuData';
		$list =$_SESSION[$reportBy];
		$json = array();
		$json['list'] =$list;
		$logged_userID = $this->user->getStaffId();
		$getLocationList = $this->Locations_model->getLocationAddedByFranchisee(isAdminID($logged_userID),'loc_id');
		
		$filename = 'franchisee_'.date('Ymd').'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/csv; "); 
		$file = fopen('php://output', 'w');
		$header = array();
		if($reportBy == "chartReportAll"){
			$header = array("customers","orders","reservations","reviews","Date");
		}else if($reportBy =="chartNewCustomerData"){
			foreach ($getLocationList as $loc) {
				$header[] = $loc['location_name'];
			}
			$header[]='Date';
		}
		else if($reportBy =="chartSalesData"){
			foreach ($getLocationList as $loc) {
				$header[] = $loc['location_name'];
			}
			$header[]='Date';
		}else{
			$header = array("menu_id","menu_name","total_orders","menu_price"); 
		}
		fputcsv($file, $header);
		foreach ($list as $line){
		 fputcsv($file,$line);
		}
		fclose($file);
		exit;
		// $this->output->set_output(json_encode($json));	
	}
}

/* End of file dashboard.php */
/* Location: ./admin/controllers/dashboard.php */