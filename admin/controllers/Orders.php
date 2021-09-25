<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

require __DIR__.'/../../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Orders extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Orders');

        $this->load->model('Customers_model');
        $this->load->model('Addresses_model');
        $this->load->model('Locations_model');
        $this->load->model('Orders_model');
        $this->load->model('Delivery_model');
        $this->load->model('Reservations_model');
        $this->load->model('Statuses_model');
        $this->load->model('Staffs_model');
        $this->load->model('Countries_model');

        $this->load->library('pagination');
        $this->load->library('currency'); // load the currency library

        $this->lang->load('orders');
    }

	public function index() {

		// echo '<pre>';
		// print_r($_SESSION);
		// exit;

		// $user_id = $_SESSION['user_info']['user_id'];
		// if($user_id != '') {

		// }

		$id = $this->input->get('id');
		if ($id == '') {
			$qr_str = $_SERVER['QUERY_STRING'];
			
			$idr = 'id='.$this->user->getStaffId();
			$id1 = str_replace("id=",$idr,$qr_str);
			// header('Refresh: 1; url='.$idr);
			header('Location: orders?'.$id1);
			
			// exit;
		}
		$reservation_id = $this->input->get('id');
		$OrderCount = $this->Orders_model->getOrderCount();	
		// echo $OrderCount;
		// exit;
		//print_r($this->input->get('filter_search'));
		//exit;
		if(!$this->input->get('id') != "" && $this->user->getStaffId() == 11  && $this->input->get('show')=='' ){
			return redirect('vendor/orders');
		}else if($this->input->get('id') != "" && $this->user->getStaffId() == 11){
			$edit_link = "edit?vendor_id=".$id;
		}else{
			$edit_link = "edit";
		}

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

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else { 
			$data['filter_search'] = '';
		}

		if ($data['user_strict_location'] = $this->user->isStrictLocation()) {
			$filter['filter_location'] = $data['filter_location'] = $_SESSION['location_id'];
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else if (is_numeric($this->input->get('filter_location'))) {
			$filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else {
			$filter['filter_location'] = $data['filter_location'] = '';
		}

		if (is_numeric($this->input->get('filter_status')) || $this->input->get('filter_status') == "all") {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = 1;
			$data['filter_status'] = '';
		}

		if (is_numeric($this->input->get('filter_type'))) {
			$filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
			$url .= 'filter_type='.$filter['filter_type'].'&';
		} else {
			$filter['filter_type'] = $data['filter_type'] = '';
		}

		if ($this->input->get('filter_payment')) {
			$filter['filter_payment'] = $data['filter_payment'] = $this->input->get('filter_payment');
			$url .= 'filter_payment='.$filter['filter_payment'].'&';
		} else {
			$filter['filter_payment'] = $data['filter_payment'] = '';
		}

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'date_added';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

		if ($this->input->post('delete') AND $this->_deleteOrder() === TRUE) {
			
			redirect('orders?show=all&filter_status=all');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_id'] 			= site_url('orders'.$url.'&id=&sort_by=order_id&show=all&order_by='.$order_by);
		$data['sort_location'] 		= site_url('orders'.$url.'&id=&sort_by=location_name&show=all&order_by='.$order_by);
		$data['sort_customer'] 		= site_url('orders'.$url.'&id=&sort_by=first_name&show=all&order_by='.$order_by);
		$data['sort_status'] 		= site_url('orders'.$url.'&id=&sort_by=status_name&show=all&order_by='.$order_by);
		$data['sort_code'] 			= site_url('orders'.$url.'&id=&sort_by=status_code&show=all&order_by='.$order_by);
		$data['sort_type'] 			= site_url('orders'.$url.'&id=&sort_by=order_type&show=all&order_by='.$order_by);
		$data['sort_payment'] 		= site_url('orders'.$url.'&id=&sort_by=payment&show=all&order_by='.$order_by);
		$data['sort_total'] 		= site_url('orders'.$url.'&id=&sort_by=order_total&show=all&order_by='.$order_by);
		$data['sort_time']			= site_url('orders'.$url.'&id=&sort_by=order_time&show=all&order_by='.$order_by);
		$data['sort_date'] 			= site_url('orders'.$url.'&id=&sort_by=date_added&show=all&order_by='.$order_by);
		
	
		if($this->input->get("show") == 'all' ){
		$url .= "show=all";
		$data['show'] = 'all';
		$results = $this->Orders_model->getList($filter);	
		// echo '<pre>';
		// print_r($results);
		// exit;
		
		$config['total_rows'] 		= $this->Orders_model->getCount($filter);
		}else{
		$url .= "id=".$id;		
		$results = $this->Orders_model->getList($filter,$id,"YES");
		$config['total_rows'] 		= $this->Orders_model->getCount($filter,$id,"YES");
		// echo '<pre>';
		// print_r($results);
		// exit;
		}
		
		$data['orders'] = array();
		foreach ($results as $result) {
			$payment_title = '--';
			if ($payment = $this->extension->getPayment($result['payment'])) {
				$payment_title = !empty($payment['ext_data']['title']) ? $payment['ext_data']['title']: $payment['title'];
			}

			$reservation_details = $this->Orders_model->getReservationdetails($result['order_id']);

			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'order_type' 		=> ($result['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection'),
				'payment'			=> $payment_title,
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_date'		=> day_elapsed($result['order_date']),
				'order_status'		=> $result['status_name'],
				'order_status_code'	=> $result['status_code'],
				'status_color'		=> $result['status_color'],
				'order_total'		=> $this->currency->format($result['order_total'] - $result['coupon_discount']),
				'coupon_discount'	=> $this->currency->format($result['coupon_discount']),
				'date_added'		=> day_elapsed($result['date_added']),
				'reservation_id'	=> isset($reservation_details['reservation_id']) ? $reservation_details['reservation_id'] : '-',
				'unique_code'		=> isset($reservation_details['otp']) ? $reservation_details['otp'] : '-',
				'delivery_id'		=> $reservation_details['delivery_id'],
				'edit' 				=> site_url('orders/edit?id=' . $result['order_id'].'&res_id='.$reservation_id)
			);
		}

		// echo '<pre>';
		// print_r($data['orders']);
		// exit;
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$data['statuses'] = array();
		$statuses = $this->Statuses_model->getStatuses('order');
		foreach ($statuses as $statuses) {
			$data['statuses'][] = array(
				'status_id'			=> $statuses['status_code'],
				'status_name'		=> $statuses['status_name'],
				'status_code'		=> $statuses['status_code']
			);
		}
		$data['delivery_boy'] = array();
		$delivery_boy = $this->Delivery_model->getOnlineDelivery();
		foreach ($delivery_boy as $delivery) {
			$data['delivery_boy'][] = array(
				'delivery_id'	=> $delivery['delivery_id'],
				'first_name'	=> $delivery['first_name'],
				'last_name'	=> $delivery['last_name'],
				'email'	=> $delivery['email'],
				'telephone' => $delivery['telephone']
			);
		}

		$data['payments'] = array();
		$payments = $this->extension->getPayments();
		foreach ($payments as $payment) {
			$data['payments'][] = array(
				'name'  => $payment['name'],
				'title' => $payment['title'],
			);
		}

		$data['order_dates'] = array();
		$order_dates = $this->Orders_model->getOrderDates();
		foreach ($order_dates as $order_date) {
			$month_year = $order_date['year'].'-'.$order_date['month'];
			$data['order_dates'][$month_year] = mdate('%F %Y', strtotime($order_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= '&sort_by='.$filter['sort_by'].'&';
			$url .= '&order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('orders'.$url);
		
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('orders', $data);
	}

	public function edit() {
		$order_info = $this->Orders_model->getOrder((int) $this->input->get('id'));
		$user_id = $this->user->getStaffId();
		$bc_url = $user_id == '11' ? 'orders?show=all&id=11&filter_search=&filter_location=&filter_status=all&filter_payment=&filter_date' : 'orders?id=&filter_search=&filter_status=all&filter_payment=&filter_date=';

		if ($order_info) {
			$order_id = $order_info['order_id'];
			$locations = explode(',',$order_info['location_id']);
			// print_r($locations);
			// exit;
			$data['location_id'] 		= $order_info['location_id'];
			foreach ($locations as $key => $location_id) {				
				$location = $this->Orders_model->getLocation($location_id);
				$orders['locations'][$location_id]['location_lat'] = $location['location_lat'];				
			}
			// print_r($orders);
			// exit;
			$data['_action']	= site_url('orders/edit?id='. $order_id.'&res_id='.$reservation_id);
		} else {
		    $order_id = 0;
			//$data['_action']	= site_url('orders/edit');
			redirect('orders');
		}
		$data1 = $this->Orders_model->getRewardAmount($reservation_id,$order_id);
		$data['reward_amount'] = $data1['reward_used_amount'];

		$title = (isset($order_info['order_id'])) ? $order_info['order_id'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url($bc_url), 'title' => 'Back'));

		


		if ($this->input->post() AND $this->_updateOrder() === TRUE) {
			// echo $this->input->get('id');
			// exit;
			// echo '<pre>';
			// print_r($_POST);
			// exit;
			// echo $reserve['location_id'];
                
                // echo '<pre>';
                // print_r($this->input->post('delivery_id'));
                // exit;
			$url = BASEPATH.'/../firebase.json';
			$uid = $this->input->post('delivery_id');
			$project_id = json_decode(file_get_contents($url));
			$db = 'https://'.$project_id->project_id.'.firebaseio.com/';
			// echo $db;
			// exit;
			$serviceAccount = ServiceAccount::fromJsonFile($url);
			$firebase = (new Factory)
						->withServiceAccount($serviceAccount)
						->withDatabaseUri($db)
						->create();
			$database = $firebase->getDatabase();
			// echo '<pre>';
			// print_r($database);
			// exit();

			$prev_id = $this->input->post('prev_del_id');			
			$input = [
				'delivery_partners/'.$prev_id.'/status' => 1,
				'delivery_partners/'.$prev_id.'/order_id' => "",
			    'delivery_partners/'.$uid.'/status' => 2,
			    'delivery_partners/'.$uid.'/order_id' => $order_id,
			];
			$deliv = $this->Delivery_model->getDeliveries($uid);
		    $cust = $this->Addresses_model->getAddress($order_info['customer_id'],$order_info['address_id']);
		    $ord = $this->Orders_model->getOrderMenus($order_id);
			$datas['amount'] 					= $this->currency->format($order_info['order_total']);
			$datas['customer_id'] 				= $order_info['customer_id'];
			$datas['customer_lat'] 				= floatval($cust['clatitude']);
			$datas['customer_lng'] 				= floatval($cust['clongitude']);
			$datas['customer_name'] 			= $order_info['first_name'].' '.$order_info['last_name'];
			$datas['customer_phone'] 			= $order_info['telephone'];
			$datas['date'] 						= date('d-M-Y',strtotime($order_info['order_date'])).' '.date('h:i a',strtotime($order_info['order_time']));
			$datas['delivery_partner_phone'] 	= $deliv['telephone'];
			$datas['drop_lat'] 					= floatval($cust['clatitude']);
			$datas['drop_lng'] 					= floatval($cust['clongitude']);
			$datas['eta']['text']	 			= 'estimating';
			$datas['id'] 						= $order_id;
			$datas['order_id'] 					= '#'.str_pad($order_id, 6, '0', STR_PAD_LEFT);;
			$datas['restaurant_address']		= $order_info['location_address_1'].', '.$order_info['location_address_2'].', '.$order_info['location_city'];
			$datas['restaurant_lat'] 			= floatval($order_info['location_lat']);
			$datas['restaurant_lng'] 			= floatval($order_info['location_lng']);
			$datas['restaurant_name'] 			= $order_info['location_name'];
			$datas['restaurant_phone'] 			= $order_info['location_telephone'];
			$datas['res_img']		 			= $order_info['location_image'];
			$stat = $this->Statuses_model->getStatuscode($order_info['status_id']);
			$datas['status'] 					= $_POST['order_status'];
			$statu_name = $this->Statuses_model->getStatuscode($_POST['order_status']);
			$stat_name = $statu_name['status_name'] ;
			$datas['status_name'] 				= $stat_name;
			if($order_info['payment'] == 'cash'){
				$datas['mode_of_payment']		= 'cash';
			}else{
				$datas['mode_of_payment']		= 'card';
			}
			$datas['ETA']						= $this->Locations_model->getLocationETA($local_info['location_id']);
			$datas['id_proof']					= $order_info['id_proof'];
			$datas['items'] 					= $ord;
			$datas['is_view'] 					= 0;
			$datas['mode_of_payment']			= $datas['mode_of_payment'];

			$order_input = [
				'orders/'.$uid.'/'.$order_id => $datas,
				
			];

			if($prev_id != $uid){
				$order_input2 = [
					'orders/'.$prev_id.'/'.$order_id .'/status_name'=> "Delivery boy canceled",
					'orders/'.$prev_id.'/'.$order_id .'/status'=> 8,
			];

			$newpost5 = $database->getReference() 
				->update($order_input2);

			}

			$datac['delivery_partner'] = $uid;
			$statu_name = $this->Statuses_model->getStatuscode($_POST['order_status']);
			$datac['status'] = $statu_name['status_name'] ;
			$datac['status_id'] =  $_POST['order_status'];
			
			$customer_input =[
				'customer_pendings/'.$order_info['customer_id'].'/'.$order_id => $datac,
			];

			
			if($uid!=''){
			$newpost = $database->getReference() 
				->update($input);
			$newpost1 = $database->getReference() 
				->update($order_input);
			$newpost3 = $database->getReference('orders/'.$prev_id.'/'.$order_id) 
				->remove();
			}

			$locations = explode(",",$this->input->post('location_id'));               
			// print_r($locations);
			// exit;
                foreach ($locations as $key => $loc_id) {
                  $location = $this->Reservations_model->getLocation($loc_id);
                  if(isset($location)) {
                  	// echo $loc_id;
                  	
                   // $order_id = $reserve['order']['order_id'];
                    $firebase1['shop'][$key]['restaurant_lat'] = floatval($location['location_lat']);
                    $firebase1['shop'][$key]['restaurant_lng'] = floatval($location['location_lng']);
                    $firebase1['shop'][$key]['restaurant_name'] = $location['location_name'];
                    $firebase1['shop'][$key]['checked'] = 0;
                    $firebase1['shop'][$key]['restaurant_phone'] = $location['location_telephone'];
                    $firebase1['shop'][$key]['restaurant_address'] = $location['location_name'].' '.$location['location_city'];
                    $firebase1['shop'][$key]['res_img'] = $location['location_image'];
                    $menu_order = $this->Reservations_model->getOrderMenu($this->input->get('id'),$key);
                    
                    // print_r($menu_order);
                    // exit;
                    foreach ($menu_order as $men_key => $menu) {
                      $menu_id = $menu['menu_id'];
                       $firebase1['shop'][$key]['items'][$men_key]['name'] = $menu['name'];
                      $firebase1['shop'][$key]['items'][$men_key]['option_name'] = $menu['option_name'];
                      $firebase1['shop'][$key]['items'][$men_key]['option_value_name'] = $menu['option_value_name'];
                      $firebase1['shop'][$key]['items'][$men_key]['quantity'] = $menu['quantity'];
                      $firebase1['shop'][$key]['items'][$men_key]['subtotal'] = $menu['subtotal'];
                      $firebase1['shop'][$key]['items'][$men_key]['price'] = $menu['price'];

                      // $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['name'] = $menu['name'];
                      // $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['option_name'] = $menu['option_name'];
                      // $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['option_value_name'] = $menu['option_value_name'];
                      // $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['quantity'] = $menu['quantity'];
                      // $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['subtotal'] = $menu['subtotal'];
                      // $firebase1['shop'][$loc_id]['items'][$menu['menu_id']]['price'] = $menu['price'];
                    }
                    
                  }
                }
                // echo $this->input->post('delivery_id');
                // exit;
                // echo '<pre>';
                // print_r($firebase1);
                // exit;
                $url = BASEPATH.'/../firebase.json'; 
                // echo $url;
                // exit;        
                $project_id = json_decode(file_get_contents($url));
                $db = 'https://'.$project_id->project_id.'.firebaseio.com/';
                $serviceAccount = ServiceAccount::fromJsonFile($url);
                // print_r($firebase1);
                // exit();
                $firebase = (new Factory)
                            ->withServiceAccount($serviceAccount)
                            ->withDatabaseUri($db)
                            ->create();
                $database = $firebase->getDatabase();
                if(isset($firebase1)) {                 
                $newpost5 = $database->getReference('orders/'.$this->input->post('delivery_id').'/'.$this->input->get('id').'/') 
                  ->update($firebase1);
                }
			$newpost2 = $database->getReference('customer_pendings/'.$order_info['customer_id'].'/'.$order_id) 
				->update($datac);
			if($stat['status_code']=='3'){
				$message = "New Order Placed and preparing";
				$token = $deliv['deviceid'];
			$fcm = $this->Orders_model->fxmsend_post($message,$token);

			}
			
			if ($status_id = $this->Statuses_model->saveStatus($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Status '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}
			if ($this->input->post('save_close') === '1') {
				redirect('orders');
			}

			redirect('orders/edit?id='. $order_id.'&res_id='.$reservation_id);
		}

		$reservation_details = $this->Orders_model->getReservationdetails($order_info['order_id']);

		$data['order_id'] 			= $order_info['order_id'];
		$data['invoice_no'] 		= !empty($order_info['invoice_no']) ? $order_info['invoice_prefix'].$order_info['invoice_no'] : '';
		$data['customer_id'] 		= $order_info['customer_id'];
		$data['customer_edit'] 		= site_url('customers/edit?id=' . $order_info['customer_id']);
		$data['first_name'] 		= $order_info['first_name'];
		$data['last_name'] 			= $order_info['last_name'];
		$data['email'] 				= $order_info['email'];
		$data['delivery_id'] 		= $order_info['delivery_id'];
		$data['telephone'] 			= $order_info['telephone'];
		$data['date_added'] 		= mdate('%d %M %y - %H:%i', strtotime($order_info['date_added']));
		$data['date_modified'] 		= mdate('%d %M %y', strtotime($order_info['date_modified']));
		$data['order_time'] 		= mdate('%H:%i', strtotime($order_info['order_time']));
		$data['order_type'] 		= ($order_info['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection');
		$data['status_id'] 			= $order_info['status_id'];
		$data['status_code'] 			= $order_info['status_code'];
		$data['status_name'] 	    = $order_info['status_name'];
		$data['status_order'] 	    = $order_info['status_order'];
		$data['assignee_id'] 		= $order_info['assignee_id'];
		$data['comment'] 			= $order_info['comment'];
		$data['notify'] 			= $order_info['notify'];
		$data['ip_address'] 		= $order_info['ip_address'];
		$data['user_agent'] 		= $order_info['user_agent'];
		$data['id_proof'] 	    	= $order_info['id_proof'];
		$data['check_order_type'] 	= $order_info['order_type'];
		$data['reser_id']			= $reservation_details['id'];
		$data['booking_price']		= $reservation_details['booking_price'];
		$data['delivery_boy'] = array();

		$data['paypal_details'] = array();
		if ($payment = $this->extension->getPayment($order_info['payment'])) {
			if ($payment['name'] === 'paypal_express') {
				$this->load->model('paypal_express/Paypal_model');
				$data['paypal_details'] = (isset($this->Paypal_model)) ? $this->Paypal_model->getPaypalDetails($order_info['order_id'], $order_info['customer_id']) : array();
			}

			$data['payment'] = !empty($payment['ext_data']['title']) ? $payment['ext_data']['title']: $payment['title'];
		} else {
			/*$data['payment'] = $this->lang->line('text_no_payment');*/
						$data['payment'] = 'Cash on Hand';

		}

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();
		foreach ($results as $result) {
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$permissionStaffID= '';
		if($this->session->user_info['staff_group_id'] == 13){
			$permissionStaffID=$this->input->get('res_id');
		}else{
			$location_staff_Info = $this->Locations_model->getRestaurantLocationDetails('location_id',$order_info['location_id']);
			if($location_staff_Info['added_by']){
				$location_staff_Info =$location_staff_Info['added_by'];
			}
			$permissionStaffID=$location_staff_Info;
		}
		$staffsPermission = $this->Staffs_model->getStaff($permissionStaffID);
		$staffsPermission=unserialize($staffsPermission['staff_permissions']);

		$data['staffs'] = array();
		$staffs = $this->Staffs_model->getStaffs();
		foreach ($staffs as $staff) {
			$data['staffs'][] = array(
				'staff_id'		=> $staff['staff_id'],
				'staff_name'	=> $staff['staff_name']
			);
		}
		
		$data['statuses'] = array();
		$statuses = array();
		if(!$staffsPermission['Delivery']){
			$statuses = $this->Statuses_model->getStatusesByFilter('order','delivery');
			//print_r ($statuses); 
		}else{
			$statuses = $this->Statuses_model->getStatuses('order',$order_info['order_type']);
			// print_r ($statuses); 
		}
		$activeOrderStatus= "0";
		
		if($order_info['status_code'] == 1) $activeOrderStatus= "2";
		if($order_info['status_code'] == 2) $activeOrderStatus= "28";
		if($order_info['status_code'] == 28) $activeOrderStatus= "20";
		foreach ($statuses as $statuses) {
			if(!$staffsPermission['Delivery'] && $statuses['status_name']=='Delivered'){
				$statuses['status_name'] = "Completed";
			}
			if($statuses['status_code'] == "0" || $statuses['status_code'] == $activeOrderStatus){
				$data['statuses'][] = array(
					'status_id'			=> $statuses['status_id'],
					'status_name'		=>  $statuses['status_name'],
					'status_code'		=> $statuses['status_code'],
					'notify'			=> $statuses['notify_customer'],
					'status_comment'	=> nl2br($statuses['status_comment'])
				);
			}
			// if($statuses['status_name'] !='Pending'){
			// 	$data['statuses'][] = array(
			// 		'status_id'			=> $statuses['status_id'],
			// 		'status_name'		=>  $statuses['status_name'],
			// 		'status_code'		=> $statuses['status_code'],
			// 		'notify'			=> $statuses['notify_customer'],
			// 		'status_comment'	=> nl2br($statuses['status_comment'])
			// 	);
			// }
			 
			
		}
		
		
		$getStaffId = $this->user->getStaffId();
		$url = BASEPATH.'/../firebase.json';         
        $project_id = json_decode(file_get_contents($url));
		$db = 'https://'.$project_id->project_id.'.firebaseio.com/';
        $serviceAccount = ServiceAccount::fromJsonFile($url);
        $firebase = (new Factory)
                    ->withServiceAccount($serviceAccount)
                    ->withDatabaseUri($db)
                    ->create();
        $database = $firebase->getDatabase();

        if($getStaffId==11){

            $delivery_boy = $this->Delivery_model->getDelivery();
            foreach ($delivery_boy as $delivery) {  
                $stat_upd = $database->getReference('delivery_partners'.'/'.$delivery['delivery_id']);
                $stat_up = $stat_upd->getValue('status');
                

                if($stat_up['status']!=0){
                    $deliver =  $this->Delivery_model->getDeliveries($stat_up['delivery_id']);
                    
                    $data['delivery_boy'][] = array(
                        'delivery_id'   => $deliver['delivery_id'],
                        'first_name'    => $deliver['first_name'],
                        'last_name' => $deliver['last_name'],
                        'email' => $deliver['email'],
                        'telephone' => $deliver['telephone']
                    );
                }

            }            
        }else{
            $delivery_boy = $this->Delivery_model->getDelivery1($getStaffId);
            foreach ($delivery_boy as $delivery) {  
                $stat_upd = $database->getReference('delivery_partners'.'/'.$delivery['delivery_id']);
                $stat_up = $stat_upd->getValue('status');
                $stat_up1 = $stat_upd->getValue('added_by');
                
                if($stat_up['status']!=0 && $stat_up1['added_by'] == $getStaffId){
                    $deliver =  $this->Delivery_model->getDeliveries($stat_up['delivery_id']);
                    
                    $data['delivery_boy'][] = array(
                        'delivery_id'   => $deliver['delivery_id'],
                        'first_name'    => $deliver['first_name'],
                        'last_name' => $deliver['last_name'],
                        'email' => $deliver['email'],
                        'telephone' => $deliver['telephone']
                    );
                }
            }            
        }
        $delivery_online = $data['delivery_boy'];

		$data['status_history'] = array();
		$status_history = $this->Statuses_model->getStatusHistories('order', $order_id);
		foreach ($status_history as $history) {
			$data['status_history'][] = array(
				'history_id'	=> $history['status_history_id'],
				'date_time'		=> mdate('%d %M %y - %H:%i', strtotime($history['date_added'])),
				'staff_name'	=> $history['staff_name'],
				'assignee_id'	=> $history['assignee_id'],
				'status_id'		=> $history['status_id'],
				'status_name'	=> $history['status_name'],
				'status_code'	=> $history['status_code'],
				'status_color'	=> $history['status_color'],
				'notify'		=> $history['notify'],
				'comment'		=> nl2br($history['comment'])
			);
		}
		// echo '<pre>';
		// print_r($data['status_history']);
		// exit;
		$this->load->library('country');
		$data['location_name'] = $data['location_address'] = '';
		if (!empty($order_info['location_id'])) {
			$location_address = $this->Locations_model->getAddress($order_info['location_id']);
			if ($location_address) {
				$data['location_name'] = $location_address['location_name'];
				$data['location_address'] = $this->country->addressFormat($location_address);
			}
		}

		$data['customer_address'] = '';
		if (!empty($order_info['customer_id'])) {
			$customer_address = $this->Addresses_model->getAddress($order_info['customer_id'], $order_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		} else if (!empty($order_info['address_id'])) {
			$customer_address = $this->Addresses_model->getGuestAddress($order_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		}

		$data['cart_items'] = array();
		$cart_items = $this->Orders_model->getOrderMenus($order_info['order_id']);
        $menu_options = $this->Orders_model->getOrderMenuOptions($order_info['order_id']);
        		
		foreach ($cart_items as $cart_item) {
			$option_data = array();

			if (!empty($menu_options)) {
				foreach ($menu_options as $menu_option) {
					if ($cart_item['order_menu_id'] === $menu_option['order_menu_id']) {
						$option_data[] = $menu_option['order_option_name'] . $this->lang->line('text_equals') . $this->currency->format($menu_option['order_option_price']);
					}
				}
			}

			$data['cart_items'][] = array(
				'id' 			=> $cart_item['menu_id'],
				'name' 			=> $cart_item['name'].' - '. $this->currency->format($cart_item['menu_price']),
				'qty' 			=> $cart_item['quantity'],
				'price' 		=> $this->currency->format($cart_item['price']),
				'subtotal' 		=> $this->currency->format($cart_item['subtotal']),
				'comment' 		=> $cart_item['comment'],
				'options'		=> implode('<br /> ', $option_data)
			);
		}

		$data['totals'] = array();
		$order_totals = $this->Orders_model->getOrderTotals($order_info['order_id']);
		foreach ($order_totals as $total) {
			if ($order_info['order_type'] === '2' AND $total['code'] == 'delivery') {
				continue;
			}
			if($total['code'] == 'cart_total' || $total['code'] == 'order_total')
			{
				$total['value'] += $reservation_details['booking_price'] - $data['reward_amount'];
			}
			$data['totals'][] = array(
				'code'  => $total['code'],
				'title' => htmlspecialchars_decode($total['title']),
				'value' => $this->currency->format($total['value']),
				'priority' => $total['priority'],
			);
		}

		$data['order_total'] 		= $this->currency->format($order_info['order_total']);
		$data['total_items']		= $order_info['total_items'];


		$this->template->render('orders_edit', $data);
	}

	public function create_invoice() {
		$json = array();

		if (is_numeric($this->input->post('order_id'))) {
			$json['invoice_no'] = $this->Orders_model->createInvoiceNo($this->input->post('order_id'));

			if ($json['invoice_no'] === TRUE) {
				$this->alert->set('warning', $this->lang->line('alert_order_not_completed'));
			} else if (!empty($json['invoice_no'])) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Invoice generated'));
			} else {
				$this->alert->set('error', sprintf($this->lang->line('alert_error_nothing'), 'generated'));
			}

			$json['redirect'] = site_url('orders/edit?id='.$this->input->post('order_id'));
		}

		$this->output->set_output(json_encode($json));
	}

	public function invoice() {
		$this->output->enable_profiler(FALSE);
		$action = $this->uri->rsegment('3');

		$this->template->setStyleTag('css/bootstrap.min.css', 'bootstrap-css', '1');
		$this->template->setStyleTag('css/fonts.css', 'fonts-css', '2');

		$this->load->model('Image_tool_model');
		$data['invoice_logo'] 		= $this->Image_tool_model->resize($this->config->item('site_logo'));

		$invoice_info = $this->Orders_model->getInvoice($this->uri->rsegment('4'));

		$data['order_id'] = $invoice_info['order_id'];
		$data['invoice_no'] = $invoice_info['invoice_prefix'] . $invoice_info['invoice_no'];
		$data['customer_id'] = $invoice_info['customer_id'];
		$data['first_name'] = $invoice_info['first_name'];
		$data['last_name'] = $invoice_info['last_name'];
		$data['email'] = $invoice_info['email'];
		$data['telephone'] = $invoice_info['telephone'];
		$data['date_added'] = mdate('%F %d, %Y', strtotime($invoice_info['date_added']));
		$data['invoice_date'] = mdate('%F %d, %Y', strtotime($invoice_info['invoice_date']));
		$data['date_modified'] = mdate('%d %M %y', strtotime($invoice_info['date_modified']));
		$data['order_time'] = mdate('%H:%i', strtotime($invoice_info['order_time']));
		$data['order_type'] = ($invoice_info['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection');
		$data['comment'] = $invoice_info['comment'];
		$data['check_order_type'] = $invoice_info['order_type'];

		if ($payment = $this->extension->getPayment($invoice_info['payment'])) {
			if ($payment['name'] === 'paypal_express') {
				$this->load->model('paypal_express/Paypal_model');
				$data['paypal_details'] = (isset($this->Paypal_model)) ? $this->Paypal_model->getPaypalDetails($invoice_info['order_id'], $invoice_info['customer_id']) : '';
			}

			$data['payment'] = ! empty($payment['ext_data']['title']) ? $payment['ext_data']['title'] : $payment['title'];
		} else {
			$data['payment'] = 'No Payment';
		}

		$this->load->library('country');
		$data['location_name'] = $data['location_address'] = '';
		if ( ! empty($invoice_info['location_id'])) {
			$location_address = $this->Locations_model->getAddress($invoice_info['location_id']);
			if ($location_address) {
				$data['location_name'] = $location_address['location_name'];
				$data['location_address'] = $this->country->addressFormat($location_address);
			}
		}

		$data['customer_address'] = '';
		if ( ! empty($invoice_info['customer_id'])) {
			$customer_address = $this->Addresses_model->getAddress($invoice_info['customer_id'], $invoice_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		} else if ( ! empty($invoice_info['address_id'])) {
			$customer_address = $this->Addresses_model->getGuestAddress($invoice_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		}

		$data['cart_items'] = array();
		$cart_items = $this->Orders_model->getOrderMenus($invoice_info['order_id']);
		$menu_options = $this->Orders_model->getOrderMenuOptions($invoice_info['order_id']);
		foreach ($cart_items as $cart_item) {
			$option_data = array();

			if ( ! empty($menu_options)) {
				foreach ($menu_options as $menu_option) {
					if ($cart_item['order_menu_id'] === $menu_option['order_menu_id']) {
						$option_data[] = $menu_option['order_option_name'] . $this->lang->line('text_equals') . $this->currency->format($menu_option['order_option_price']);
					}
				}
			}

			$data['cart_items'][] = array(
				'id'       => $cart_item['menu_id'],
				'name'     => $cart_item['name'],
				'qty'      => $cart_item['quantity'],
				'price'    => $this->currency->format($cart_item['price']),
				'subtotal' => $this->currency->format($cart_item['subtotal']),
				'comment'  => $cart_item['comment'],
				'options'  => implode(', ', $option_data)
			);
		}

		$data['totals'] = array();
		$order_totals = $this->Orders_model->getOrderTotals($invoice_info['order_id']);
		foreach ($order_totals as $name => $total) {
			if ($total['code'] == 'delivery' AND $invoice_info['order_type'] === '2') {
				continue;
			}

			$data['totals'][] = array(
				'code'  => $total['code'],
				'title' => htmlspecialchars_decode($total['title']),
				'value' => $this->currency->format($total['value']),
				'priority' => $total['priority'],
			);
		}

		$data['order_total'] = $this->currency->format($invoice_info['order_total']);

		if ($action === 'view') {
			$this->load->view($this->config->item(ADMINDIR, 'default_themes').'orders_invoice', $data);
		}
	}

	private function _updateOrder() {
		if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$status_id = $this->input->post('order_status'); 
			$staff_id= '';
			
			if($this->session->user_info['staff_group_id'] == 13){
				$staff_id=$this->input->get('res_id');
			}else{
				$location_id = $this->Locations_model->getRestaurantLocationDetails('location_id',$this->input->post('location_id'));
				if($location_id['added_by']){
					$location_id =$location_id['added_by'];
				}
				// print_r ($location_id);
				// exit;
				$staff_id=$location_id;
			}
			$staffsPermission = $this->Staffs_model->getStaff($staff_id);
			$staffsPermission=unserialize($staffsPermission['staff_permissions']);

			if($status_id>=3 && $staffsPermission['Delivery']){
				$status_id = $this->input->post('order_status'); 
				if($this->input->post('order_type') === 'Delivery'){
					$delivery_id = $this->input->post('delivery_id');
					if($delivery_id==''){
						$this->alert->set('danger', sprintf('Assign delivery boy on Preparation Status', 'updated'));
						return FALSE;
					}
				}
			}
			
			if ($this->Orders_model->updateOrder($this->input->get('id'), $this->input->post())) {
                log_activity($this->user->getStaffId(), 'updated', 'orders', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), 'updated', 'order', current_url(), '#'.$this->input->get('id'))
                ));

                if ($this->input->post('assignee_id') AND $this->input->post('old_assignee_id') !== $this->input->post('assignee_id')) {
                    $staff = $this->Staffs_model->getStaff($this->input->post('assignee_id'));
	                $staff_assignee = site_url('staffs/edit?id='.$staff['staff_id']);

	                log_activity($this->user->getStaffId(), 'assigned', 'orders', get_activity_message('activity_assigned',
                        array('{staff}', '{action}', '{context}', '{link}', '{item}', '{assignee}'),
                        array($this->user->getStaffName(), 'assigned', 'order', current_url(), '#'.$this->input->get('id'), "<a href=\"{$staff_assignee}\">{$staff['staff_name']}</a>")
                    ));
                }

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Order updated'));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return TRUE;
		}
	}

	private function _deleteOrder() {
		$url = BASEPATH.'/../firebase.json';
			$uid = $this->input->post('delete');
			$project_id = json_decode(file_get_contents($url));
			$db = 'https://'.$project_id->project_id.'.firebaseio.com/';
			// $newpost = $db->getReference('drivers_location/'.$id)->remove();
			// $newpost = $db->getReference('orders/6');
			// $database = $db->getDatabase();
			$url = BASEPATH.'/../firebase.json';         
	        $project_id = json_decode(file_get_contents($url));
	        $db = 'https://'.$project_id->project_id.'.firebaseio.com/';
	        $serviceAccount = ServiceAccount::fromJsonFile($url);
	        $firebase = (new Factory)
	                    ->withServiceAccount($serviceAccount)
	                    ->withDatabaseUri($db)
	                    ->create();
	        $database = $firebase->getDatabase();
	       	//$stat_upd = $database->getReference('orders/6');
               
               
        if ($this->input->post('delete')) {
        	$del_arr = $this->input->post('delete');
			foreach ($del_arr as  $order_id) {
				
				$order = $this->Orders_model->getOrderDel($order_id);
				$delivery_id = $order['delivery_id'];
				if ($delivery_id > 0) {
					$newpost = $database->getReference('orders/'.$delivery_id.'/'.$order_id)->remove();
				}
				
				// echo '<br>';
				// print_r($order);
				// exit;
			}

			
            $deleted_rows = $this->Orders_model->deleteOrder($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Orders': 'Order';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('order_status', 'lang:label_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('assignee_id', 'lang:label_assign_staff', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function check_or_status() {
		// echo $order_id;
		$order_id = $this->input->post('order_id');
		$history_count = $this->input->post('history_count');
		// echo $history_count;
		// exit;
		$status_history = $this->Statuses_model->getStatusHistories('order', $order_id);
		
		if(count($status_history) != $history_count) {
			$return['status'] = 1;
			$return['msg'] = 'success';
		} else {
			$return['status'] = 0;
			$return['msg'] = 'failure';
		}
		print_r(json_encode($return));
		exit;
	}

	public function check_or_count() {
		$or_count = $this->input->post('or_count');
		$OrderCount = $this->Orders_model->getOrderCount();	
		$notify = $this->Orders_model->notificationCount();	
		if($or_count < $notify['count']) {
			// $return['or_count'] = $OrderCount;
			$return['or_count'] = $notify['count'];
			$return['status'] = 1;
			ob_start();
			?>
			<a class="dropdown-toggle messages" data-toggle="dropdown">
				<i class="fa fa-envelope"></i>
                <span class="label label-danger unread"><?= $notify['count']; ?></span>
			</a>
			<ul class="dropdown-menu dropdown-messages notify">
				
				<?php
				if($notify['count'] > 0) {
				foreach ($notify['notify'] as $key => $value) { ?>
					<li class="menu-body text-center"><?= $value['notify_msg']?></li>
				<?php } ?>
				 <li class="menu-footer">
                    <a class="text-center" id="mark_all_read" href="javascript:void(0)"><?php echo lang('text_mark_all_read'); ?></a>
                </li>
				<?php } else { 
					$return['status'] = 0; ?>
					<li class="menu-body text-center">Notifications Not found.</li>
				<?php } ?>
               
            </ul>		
			
			<?php
			$return['unread_html'] = ob_get_clean();
			// $return['msg'] = 'New order received';
		} else {
			$return['status'] = 0;
			$return['msg'] = 'failure';
		}
		print_r(json_encode($return));
		exit;
	}

	public function check_first_count() {
		// echo $order_id;
		$or_count = $this->input->post('or_count');
		// echo $or_count;
		// exit;
		$OrderCount = $this->Orders_model->getOrderCount();	
		$notify = $this->Orders_model->notificationCount();	
		// print_r($notify);
		// exit;
		if($notify['count'] > 0) {
			$return['status'] = 1;			
			$return['unread'] = $notify['count'];
		}
		ob_start();
			?>

			<span class="label label-danger unread"><?= $notify['count']; ?></span>
			
			<?php
		$return['html'] = ob_get_clean();
		$return['order_count'] = $OrderCount;
		
		print_r(json_encode($return));
		exit;
	}

	public function mark_all_read() {
		$all_read = $this->input->post('all_read');
		if ($all_read == 1) {
			# code...
			$notify = $this->Orders_model->updateNotify();
			$notify = $this->Orders_model->notificationCount();		
			ob_start();
			?>
			<a class="dropdown-toggle messages" data-toggle="dropdown">
				<i class="fa fa-envelope"></i>
                <span class="label label-danger unread"><?= $notify['count']; ?></span>
			</a>
			<ul class="dropdown-menu dropdown-messages notify">
			<?php
				if($notify['count'] > 0) {
				foreach ($notify['notify'] as $key => $value) { ?>
					<li class="menu-body text-center"><?= $value['notify_msg']?></li>
				<?php } ?>
				 <li class="menu-footer">
                    <a class="text-center" id="mark_all_read" href="javascript:void(0)"><?php echo lang('text_mark_all_read'); ?></a>
                </li>
				<?php } else { 
					 ?>
					<li class="menu-body text-center">Notifications Not found.</li>
				<?php } ?>
			</ul>
				<?php
				$return['status'] = 1;
			$return['unread_html'] = ob_get_clean();
			
		}
		print_r(json_encode($return));
		exit;

	}
}

/* End of file orders.php */
/* Location: ./admin/controllers/orders.php */