<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');
require __DIR__.'/../../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class Local extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor

		$this->load->model('Locations_model');
		$this->load->model('Pages_model');
		$this->load->model('Reviews_model');
		$this->load->model('Orders_model');
		$this->load->model('Staffs_model');
		$this->load->model('Reservations_model');
		$this->load->model('Addresses_model');
		$this->load->model('Statuses_model');
		$this->load->library('location'); 														// load the location library
		$this->load->library('currency'); 														// load the currency library

		$this->lang->load('local');
	}

	public function index() {	

if(!$this->customer->islogged()){
	// $_SESSION['user_info']= "";
}
			// echo '<pre>';print_r($_SESSION);exit;
			// $_SESSION['user_info']="";

		if (!($location = $this->Locations_model->getLocation($this->input->get('location_id')))) {
			
			redirect('local/all');
		}

		$this->session->set_userdata('current_vendor_id',$location['added_by']);

		$this->location->setLocation($location['location_id']);

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'local/all');
		$this->template->setBreadcrumb($location['location_name']);

		$text_heading = sprintf($this->lang->line('text_local_heading'), lang_trans($location['location_name'],$location['location_name_ar']));
		$this->template->setTitle($text_heading);
		$this->template->setScriptTag('js/jquery.mixitup.js', 'jquery-mixitup-js', '100330');

		$filter = array();

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('menus_page_limit')) {
			$filter['limit'] = $this->config->item('menus_page_limit');
		}

		$filter['sort_by'] = 'menus.menu_priority';
		$filter['order_by'] = 'ASC';
		$filter['filter_status'] = '1';
		$filter['filter_category'] = (int) $this->input->get('category_id'); 									// retrieve 3rd uri segment else set FALSE if unavailable.

		$this->load->module('menus');
		$data['menu_list'] = $this->menus->getList($filter,array(),$location['location_id']);
		
		$data['menu_total']	= $this->Menus_model->getCount('',$location['location_id']);

		if (is_numeric($data['menu_total']) AND $data['menu_total'] < 150) {
			$filter['category_id'] = 0;
		}
		$data['location_name'] = $this->location->getName();
		$data['location_slug'] = $this->location->getSlug();
		$data['location_address_1'] = $this->location->getAddress();
		$data['location_name_ar'] = $this->location->getNameAR();
		$data['location_address_1_ar'] = $this->location->getAddressAR();
		$data['contact'] = $this->location->getTelephone();
		$data['email'] = $this->location->getEmail();
		$data['first_table_price'] = $this->location->getTableprice();
		$data['banner_image']  = site_url().'/assets/images/'.$location['location_image'];
		$data['local_info'] = $this->info();
		$data['location_ratings'] = $location['location_ratings'];
		$data['local_reviews'] = $this->reviews();

		$data['local_gallery'] = $this->gallery();

		$str = file_get_contents(site_url().'/assets/js/country_phone_code.json');

		$data['phone_code'] = json_decode($str);
		$data['delivery_address'] = $this->Addresses_model->getAddressesarr($this->customer->getId());
		
		$staff_details = $this->Staffs_model->getStaff($location['added_by']);
		$_SESSION['staff_id'] = $staff_details['staff_id'];
		$data['payment_details'] = unserialize($staff_details['payment_details']);

			//	print_r($this->input->post('location_id'));exit;

		if($this->input->post('feedback')){
	//print_r($this->input->post('feedback'));exit;
			$feedback_type = $this->input->post('feedback_type');
			$feedback_comment = $this->input->post('feedback_comment');
			$location_id = $location['location_id'];
			$this->load->library('customer');
			
			$add_feedback = $this->Locations_model->add_feedback($feedback_type,$feedback_comment,$location_id,$user_id);
			$this->session->set_userdata("feedback","true");
			redirect(site_url().'local/'.$this->location->getSlug().'?action=select_time&menu_page=true');
			if($add_feedback==1){
				if($data['feedback'] ==""){
				$data['feedback'] = 'True';
				}

								log_activity($user_id, $feedback_type, 'Suggestion/Complaints/Feedback',
				get_activity_message('activity_feedback_table',
					                                  array('{customer}', '{link}', '{feedback_type}','{feedback}'),
					                                  array($this->customer->getName(), admin_url('customers/edit?id='.$this->customer->getId()), $feedback_type),admin_url('feedback')
					             ));
			}
		}
		if($this->input->get('action') == 'find_table')
		{
			//echo current_url();
			$ur = explode('action',current_url());
			$ur1 = site_url().'local/'.$this->location->getName().'?action'.$ur[1];
			
			$this->session->set_userdata('checkout_back_url', $ur1);
		}

		if($this->input->get('action') == 'select_time')
		{

			//echo current_url();

			//$this->session->unset_userdata('reservation_data');
			$ur = explode('action',current_url());
			$ur1 = site_url().'local/'.$this->location->getName().'?action'.$ur[1];
			
			$this->session->set_userdata('confirm_back_url', $ur1);


            $taxes = [];
            $all_tax = 0;
            
            $tax_types = json_decode($location['tax_type']);
            $tax_perc  = json_decode($location['tax_perc']);
            $tax_status  = json_decode($location['tax_status']);
            $data['cart_total'] = $_SESSION['cart_contents']['cart_total'];
            for ($t=0;$t<count($tax_types);$t++)
            {
              if($tax_status[$t] == 1)
              {
               $all_tax += $tax_perc[$t];
               $taxes[$t]['tax_name']  = $tax_types[$t];
               $taxes[$t]['tax_value'] = $tax_perc[$t];  
               $taxes[$t]['price']	   =  ($data['cart_total'] * $tax_perc[$t]) /100 ;

              }
            }

            //$data['taxes'] = $taxes;
            $data['overall_tax'] = $all_tax;
            $data['overall_tax_price'] = ($data['cart_total'] * $all_tax)/100;            
            $data['overall_price'] = $data['overall_tax_price'] +$data['cart_total'] ;

           // $this->session->set_userdata('overall_price' ,$data['overall_price']);
           // $this->session->set_userdata('overall_tax' ,$data['overall_tax']);
           // $this->session->set_userdata('overall_tax_price' ,$data['overall_tax_price']);


            $cart_contents = array(
            	'cart_total' 		=> $data['cart_total'],
            	'total_items' 		=> $_SESSION['cart_contents']['total_items'],
            	'order_total'		=> $data['overall_price'],
            	'totals' => array(
            					'taxes' =>array(

	            					'priority' => 3,
				                    'amount' => $data['overall_tax_price'],
				                    'action' => 'add',
				                    'tax' =>   '( '.$data['overall_tax'].'% ) ',
				                    'percent' =>  $data['overall_tax'],
				                ),
            				),

            );
           // $this->session->set_userdata('cart_content' ,$cart_contents);
                
		}
		if($this->input->get('action') == 'checkout')
		{
			$this->load->library('customer');
			if($this->session->userdata('cart_contents'))
			{
				//$data['total_amount'] = ($this->session->userdata('cart_contents')['order_total'] + $this->session->userdata('reservation_data')['table_price']);
				if($this->session->userdata('cart_contents')['order_total']){
				$this->session->set_userdata('overall_price',$this->session->userdata('cart_contents')['order_total']);
				}
				$data['total_amount'] = ($this->session->userdata('overall_price') + $this->session->userdata('reservation_data')['table_price']);
			}
			else
			{
				//$data['tax_percentage'] = $this->config->item('tax_percentage');
				//$data['tax_percentage'] = $this->session->userdata('overall_tax');
				//$data['tax_percentage'] = 0;
				//$data['tax_amount'] = ($this->session->userdata('reservation_data')['table_price'] * ($tax_percentage / 100));
				//$data['tax_amount'] = $this->session->userdata('overall_tax_price');
				//$data['sess_amount'] = $this->session->userdata('reservation_data')['table_price'];
				//$data['total_amount'] = $data['sess_amount'] + $data['tax_amount'];
				//$data['total_amount'] = $this->session->userdata('overall_price');
			}
			$data['currency_code'] = $this->currency->getCurrencyCode();
            $data['currency_exch'] = $this->currency->getCurrencyExchange($data['currency_code']);
            $data['stripe_amount'] = $data['currency_exch'] * $data['total_amount'] * 100;
			/*
			if($data['sess_amount'] == 0){
				redirect('local/all');
			}*/

			if($this->customer->isLogged())
			{
				$data['cus_name']   = $this->customer->getFirstName();
				$data['cus_email']  = $this->customer->getEmail();
				$data['cus_mobile'] = explode('-',$this->customer->getTelephone());
				$data['cus_reward'] = $this->customer->getrewardpoints();

				if($data['cus_reward'] > $data['total_amount']) //check booking total amount with customer reward points
				{
					$reward_amount = $data['total_amount']; 
				}
				else
				{
					$reward_amount = $data['cus_reward'];
				}

				$rewards_details = $this->location->getrewarddetails();

				if(($rewards_details['minimum_price'] <= $data['total_amount']) && ($data['cus_reward'] > 0) && ($rewards_details['point_value'] > 0) && ($rewards_details['point_price'] > 0))
				{
					$data['reward_price_eligible']  = 1;
					$data['reward_point_value']		= $rewards_details['point_value'];
					$data['reward_point_price'] 	= $rewards_details['point_price'];
					$data['rewards_method'] 		= $rewards_details['rewards_method'];
					$data['reward_maximum_amount']  = $rewards_details['maximum_amount'];
					$data['rewards_enable']			= $rewards_details['rewards_enable'];
					if($data['rewards_method'] == 'custom')
					{
						if($reward_amount > $data['reward_maximum_amount'])
						{
							$reward_amount = $data['reward_maximum_amount'];
						}
					}
					else
					{
						$data['reward_maximum_amount'] = $reward_amount;
					}
					
					$data['reward_point'] = $reward_amount * $data['reward_point_value'];
					
					$data['reward_amount'] = $reward_amount;
					$data['total_reward_amount'] = $data['total_amount'] - $reward_amount;
					
				}
				else
				{
					$data['reward_price_eligible'] = 0;
				}
			}else{
				$current_url = site_url().'local/'.$this->location->getSlug().'?action=checkout&';
				$current_back_url = site_url().'local/'.$this->location->getSlug().'?action=select_time&menu_page=true';


				$this->session->set_userdata('redirect_url',$current_url );
				$this->session->set_userdata('redirect_back_url',$current_back_url );

				$this->alert->set('alert', $this->lang->line('alert_customer_not_logged'));
	  			redirect('account/login');	
			}

		}

		if($this->input->post('reserve'))
		{
			
			/*if($this->session->userdata('cart_contents') == '' && $_GET['total']==0){
				redirect('local/all');
			}*/

			$out = $this->reserve_order_insert($this->input->post());
			if($out != 'fail')
			{
				$data['reservation_id'] = $out['reservation_id'];
				$data['otp'] = $out['otp'];
				$data['status'] = 'success';
			}
			else
			{
				$data['status'] = 'fail';
				//redirect('local/all');
			}
		}
		if($this->input->post('paypal_submit'))
		{

			$enableSandbox = true;
			$paypalConfig = [
			    'email' => 'abdul.uplogics@gmail.com',
			    //'return_url' => 'http://example.com/payment-successful.html',
			    //'cancel_url' => 'http://example.com/payment-cancelled.html',
			    //'notify_url' => 'http://example.com/payments.php'
			];
			$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
			$itemName = 'Test Item';
			$itemAmount = 5.00;
			$data = [];
		    foreach ($_POST as $key => $value) {
		        $data[$key] = stripslashes($value);
		    }
		     // Set the PayPal account.
		    $data['business'] = $paypalConfig['email'];
		     $data['item_name'] = $itemName;
		    $data['amount'] = $itemAmount;
		    $data['currency_code'] = 'GBP';
		    $queryString = http_build_query($data);

		    // Redirect to paypal IPN
		    header('location:' . $paypalUrl . '?' . $queryString);
		    exit();

			
		}
		if($this->input->get('action') == ''){
			
			 $this->cart->destroy();
		
		}
		/*$payment_status = $this->Extensions_model->getExtension('2checkout');
		$data['payment_status']	= $payment_status['ext_data']['status'];
		$data['seller_id'] 		= $payment_status['ext_data']['seller_id'];
		$data['secret_token'] 	= $payment_status['ext_data']['secret_token'];
		$data['payment_method']	= $payment_status['ext_data']['api_mode'];*/
	//	$this->db->get_where('location',array('location_id'=>$this->location->getId()))->row();
		$result_options=$this->db->get_where('locations',array('location_id'=>$this->location->getId()))->row();
		$options=unserialize($result_options->options);
		//print_r($options['payments']);exit;
		$data['payments']=$options['payments'];
		$this->template->render('local', $data);
	}

	public function info($data = array()) {

		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		if ($this->config->item('maps_api_key')) {
			$map_key = '&key=' . $this->config->item('maps_api_key');
		} else {
			$map_key = '';
		}

		//$this->template->setScriptTag('https://maps.googleapis.com/maps/api/js?v=3' . $map_key .'&sensor=false&region=GB&libraries=geometry', 'google-maps-js', '104330');

		$data['has_delivery']       = $this->location->hasDelivery();
		$data['has_collection']     = $this->location->hasCollection();
		$data['opening_status']		= $this->location->workingStatus('opening');
		$data['delivery_status']	= $this->location->workingStatus('delivery');
		$data['collection_status']	= $this->location->workingStatus('collection');
		$data['last_order_time']    = mdate($time_format, strtotime($this->location->lastOrderTime()));
		$data['local_description']  = $this->location->getDescription();
		$data['local_description_ar']  = $this->location->getDescriptionAR();
		$data['map_address']        = $this->location->getAddress();                                        // retrieve local location data
		$data['location_telephone'] = $this->location->getTelephone();                                        // retrieve local location data

		$data['working_hours'] 		= $this->location->workingHours();                                //retrieve local restaurant opening hours from location library
		$data['working_type']      = $this->location->workingType();

		if (!$this->location->hasDelivery() OR empty($data['working_type']['delivery'])) {
			unset($data['working_hours']['delivery']);
		}

		if (!$this->location->hasCollection() OR empty($data['working_type']['collection'])) {
			unset($data['working_hours']['collection']);
		}

		$data['delivery_time'] = $this->location->deliveryTime();
		if ($data['delivery_status'] === 'closed') {
			$data['delivery_time'] = 'closed';
		} else if ($data['delivery_status'] === 'opening') {
			$data['delivery_time'] = $this->location->workingTime('delivery', 'open');
		}

		$data['collection_time'] = $this->location->collectionTime();
		if ($data['collection_status'] === 'closed') {
			$data['collection_time'] = 'closed';
		} else if ($data['collection_status'] === 'opening') {
			$data['collection_time'] = $this->location->workingTime('collection', 'open');
		}

		$local_payments = $this->location->payments();
		$payments = $this->extension->getAvailablePayments(FALSE);

		$payment_list = array();
		$i=0;
		foreach ($payments as $code => $payment) {
			if ( empty($local_payments) OR in_array($code, $local_payments)) {
				$payment_list[$i] = $payment['name'];
				$i++;
			}
		}

		$data['payments'] = implode(', ', $payment_list);

		$area_colors = array('#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040', '#F16745', '#FFC65D');
		$data['area_colors'] = $area_colors;

		$conditions = array(
			'all'   => $this->lang->line('text_delivery_all_orders'),
			'above' => $this->lang->line('text_delivery_above_total'),
			'below' => $this->lang->line('text_delivery_below_total'),
		);

		$data['delivery_areas'] = array();
		$delivery_areas = $this->location->deliveryAreas();
		foreach ($delivery_areas as $area_id => $area) {
			if (isset($area['charge']) AND is_string($area['charge'])) {
				$area['charge'] = array(array(
					'amount' => $area['charge'],
					'condition' => 'above',
					'total' => (isset($area['min_amount'])) ? $area['min_amount'] : '0',
				));
			}

			$text_condition = '';
			foreach ($area['condition'] as $condition) {
				$condition = explode('|', $condition);

				$delivery = (isset($condition[0]) AND $condition[0] > 0) ? $this->currency->format($condition[0]) : $this->lang->line('text_free_delivery');
				$con = (isset($condition[1])) ? $condition[1] : 'above';
				$total = (isset($condition[2]) AND $condition[2] > 0) ? $this->currency->format($condition[2]) : $this->lang->line('text_no_min_total');

				if ($con === 'all') {
					$text_condition .= sprintf($conditions['all'], $delivery);
				} else if ($con === 'above') {
					$text_condition .= sprintf($conditions[$con], $delivery, $total) . ', ';
				} else if ($con === 'below') {
					$text_condition .= sprintf($conditions[$con], $total) . ', ';
				}
			}

			$data['delivery_areas'][] = array(
				'area_id'       => $area['area_id'],
				'name'          => $area['name'],
				'type'			=> $area['type'],
				'color'			=> $area_colors[(int) $area_id - 1],
				'shape'			=> $area['shape'],
				'circle'		=> $area['circle'],
				'condition'     => trim($text_condition, ', '),
			);
		}

		$data['location_lat'] = $data['location_lng'] = '';
		if ($local_info = $this->location->local()) {                                                            //if local restaurant data is available
			$data['location_lat'] = $local_info['location_lat'];
			$data['location_lng'] = $local_info['location_lng'];
		}

		return $data;
	}

	public function gallery($data = array()) {
		$gallery = $this->location->getGallery();

		if (empty($gallery) OR empty($gallery['images'])) {
			return $data;
		}

		 

		$data['title'] = isset($gallery['title']) ? $gallery['title'] : '';
		$data['description'] = isset($gallery['description']) ? $gallery['description'] : '';

		foreach ($gallery['images'] as $key => $image) {
			if (isset($image['status']) AND $image['status'] !== '1') {
				$data['images'][$key] = array(
					'name'     => isset($image['name']) ? $image['name'] : '',
					'path'     => isset($image['path']) ? $image['path'] : '',
					'thumb'    => isset($image['path']) ? $this->Image_tool_model->resize($image['path']) : '',
					'alt_text' => isset($image['alt_text']) ? $image['alt_text'] : '',
					'status'   => $image['status'],
				);
			}
		}
		$this->template->setScriptTag('js/jquery.bsPhotoGallery.js', 'jquery-bsPhotoGallery-js', '100');
		return $data;
	}

	public function reviews($data = array()) {
		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';

		$url = '&';
		$filter = array();
		$filter['location_id'] = (int) $this->location->getId();

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		$filter['filter_status'] = '1';

		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		$data['reviews'] = array();
		$results = $this->Reviews_model->getList($filter);                
		// retrieve all customer reviews from getMainList method in Reviews model
		foreach ($results as $result) {
			$data['reviews'][] = array(                                                            // create array of customer reviews to pass to view
				'author'   => $result['author'],
				'city'     => $result['location_city'],
				'quality'  => $result['quality'],
				'delivery' => $result['delivery'],
				'service'  => $result['service'],
				'date'     => mdate($date_format, strtotime($result['date_added'])),
				'text'     => $result['review_text']
			);
		}

		$prefs['base_url'] = site_url('local?location_id='.$this->location->getId() . $url);
		$prefs['total_rows'] = $this->Reviews_model->getCount($filter);
		$prefs['per_page'] = $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'  => $this->pagination->create_infos(),
			'links' => $this->pagination->create_links()
		);

		return $data;
	}

	public function all() {
		$this->load->library('country');
		$this->load->library('pagination');
		$this->load->library('cart');	// load the cart library
		$this->load->library('permalink');
		$this->load->model('Image_tool_model');
		$this->load->model('Currencies_model');

		$url = '?';
		$filter = array();
		if ($this->input->get('search') == '') {
			$filter['filter_search'] = '';

			if($this->session->userdata('hotel_name')!='') {
				$keyword = $this->session->userdata('hotel_name');
				$this->session->unset_userdata('hotel_name');
			  	//$filter['keyword'] = $keyword;				
			  	$filter['keyword'] = "";				
			  	$urli='locations?search='.$filter['filter_search'].'&keyword='.$filter['keyword'];

			} else {
			   $urli = 'locations?search='.$filter['filter_search'];

			}
			//redirect($urli);
		}

		if ($this->input->get('search')) {
			$filter['filter_search'] = $this->input->get('search');
			$url .= 'search='.$filter['filter_search'].'&';
		}
		if ($this->input->get('keyword')) {
			$filter['keyword'] = str_replace("'", "\'", $this->input->get('keyword'));
			$this->session->set_userdata('hotel_name',$filter['keyword']);
			$url .= 'keyword='.$filter['keyword'].'&';
		} else {
			$this->session->unset_userdata('hotel_name',$filter['keyword']);
			$filter['keyword'] = '';
		}

		if ($this->input->get('type')) {
			$filter['type'] = $this->input->get('type');
			$url .= 'type='.$filter['type'].'&';
		} else {
			$filter['type'] = '';
		}
		if ($this->input->get('veg_type')) {
			// echo'sdfh';
			// exit;
			$filter['veg_type'] = $this->input->get('veg_type');
			$url .= 'veg_type='.$filter['veg_type'].'&';
		} else {
			$filter['veg_type'] = '';
		}
		if ($this->input->get('delivery_fee')) {
			
			$filter['delivery_fee'] = $this->input->get('delivery_fee');
			$url .= 'delivery_fee='.$filter['delivery_fee'].'&';
		} else {
			$filter['delivery_fee'] = '';
		}

		if ($this->input->get('offer_collection')) {
			
			$filter['offer_collection'] = $this->input->get('offer_collection');
			$url .= 'offer_collection='.$filter['offer_collection'].'&';
		} else {
			$filter['offer_collection'] = '';
		}

		if ($this->input->get('rating')) {
			$filter['rating'] = $this->input->get('rating');
			$url .= 'rating='.$filter['rating'].'&';
		} else {
			$filter['rating'] = '';
		}
		
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '0';
		}

		if ($this->config->item('menus_page_limit')) {
			$filter['limit'] = $this->config->item('menus_page_limit');
		}

		$filter['filter_status'] = '1';
		$filter['order_by'] = 'ASC';

		

		if ($this->input->get('sort_by')) {
			$sort_by = $this->input->get('sort_by');

			if ($sort_by === 'newest') {
				$filter['sort_by'] = 'location_id';
				$filter['order_by'] = 'DESC';
			} else if ($sort_by === 'name') {
				$filter['sort_by'] = 'location_name';
			} else if ($sort_by === 'low_high') {
				$filter['sort_by'] = 'first_table_price';
			} else if ($sort_by === 'high_low') {
				$filter['sort_by'] = 'first_table_price';
				$filter['order_by'] = 'DESC';
			}

			$url .= 'sort_by=' . $sort_by . '&';
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'local/all');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$review_totals = $this->Reviews_model->getTotalsbyId(FALSE,$filter['rating']); // retrieve all customer reviews from getMainList method in Reviews model

		$data['locations'] = array();
		$latitude = null;
		$longitude = null;
		/*******GET lat & long from search address**********/
		if ($this->input->get('search')) {
		$prepAddr = str_replace(' ','+',$filter['filter_search']);
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key=' . $this->config->item('maps_api_key').'&sensor=false');
				

		$output= json_decode($geocode);
		
		$latitude = $output->results[0]->geometry->location->lat;
		
		$longitude = $output->results[0]->geometry->location->lng;
		
		}
		$data['currency_symbol'] = $this->currency->getCurrencySymbol();
        // $location['currency_exch'] = $this->currency->getCurrencyExchange($location['currency_code']);

		$locations = $this->Locations_model->getLocalRestaurant($latitude,$longitude,$filter);
		// echo '<pre>';
		// print_r($locations);
		// exit;
		//echo '<pre>';print_r($locations);exit;
		/*******GET lat & long from search address**********/
		//$locations = $this->Locations_model->getList($filter);
		$currency_info = $this->Currencies_model->getCurrency($this->config->item('currency_id'));
		$curr_symbol = $currency_info['currency_symbol'];
		$curr_code = $currency_info['currency_code'];
		if ($locations) {
			foreach ($locations as $location) {
				$this->location->setLocation($location['location_id'], FALSE);

				$opening_status = $this->location->workingStatus('opening');
				$delivery_status = $this->location->workingStatus('delivery');
				$collection_status = $this->location->workingStatus('collection');

				$delivery_time = $this->location->deliveryTime();
				if ($delivery_status === 'closed') {
					$delivery_time = 'closed';
				} else if ($delivery_status === 'opening') {
					$delivery_time = $this->location->workingTime('delivery', 'open');
				}

				$collection_time = $this->location->collectionTime();
				if ($collection_status === 'closed') {
					$collection_time = 'closed';
				} else if ($collection_status === 'opening') {
					$collection_time = $this->location->workingTime('collection', 'open');
				}
				
				$location['loc_rating'] = $this->Locations_model->getLocation_rating($location['location_id']);
				$review_totals = isset($review_totals[$location['location_id']]) ? $review_totals[$location['location_id']] : 0;
				$permalink = $this->permalink->getPermalink('location_id='.$location['location_id']);
				$data['locations'][] = array(                                                        // create array of menu data to be sent to view
					'location_id'       => $location['location_id'],
					'location_name'     => $location['location_name'],
					'veg_type'     => $location['veg_type'],
					'delivery_fee'     => $location['delivery_fee'],
					'location_name_ar'     => $location['location_name_ar'],
					'description'       => (strlen($location['description']) > 120) ? substr($location['description'], 0, 120) . '...' : $location['description'],
					'description_ar'       => (strlen($location['description_ar']) > 120) ? substr($location['description_ar'], 0, 120) . '...' : $location['description_ar'],
					'address'           => $location['location_address_1'].','.$location['location_address_2'].',<br>'.$location['location_city'].','.$location['location_state'].',<br>'.$location['location_postcode'],//$this->location->getAddress(TRUE),
					'address_ar'           => $location['location_address_1_ar'].','.$location['location_address_2_ar'].',<br>'.$location['location_city_ar'].','.$location['location_state_ar'].',<br>'.$location['location_postcode_ar'],//$this->location->getAddress(TRUE),
					'total_reviews'     => $review_totals,
					'location_ratings'  => $location['loc_rating'],
					'location_image'    => site_url()."assets/images/".$location['location_image'],					
					'is_opened'         => $this->location->isOpened(),
					'is_closed'         => $this->location->isClosed(),
					'opening_status'    => $opening_status,
					'delivery_status'   => $delivery_status,
					'collection_status' => $collection_status,
					'delivery_time'     => $delivery_time,
					'collection_time'   => $collection_time,
					'opening_time'      => $this->location->openingTime(),
					'closing_time'      => $this->location->closingTime(),
					'min_total'         => $this->location->minimumOrder($this->cart->total()),
					'delivery_charge'   => $this->location->deliveryCharge($this->cart->total()),
					'has_delivery'      => $this->location->hasDelivery(),
					'has_collection'    => $this->location->hasCollection(),
					'last_order_time'   => $this->location->lastOrderTime(),
					'distance'   		=> round($this->location->checkDistance()),
					'distance_unit'   	=> $this->config->item('distance_unit') === 'km' ? $this->lang->line('text_kilometers') : $this->lang->line('text_miles'),
					'href'              => site_url('local?location_id=' . $location['location_id']),
					'first_table_price' => $location['first_table_price'],
					'additional_table_price'=> $location['additional_table_price'],
					'currency_symbol'  => $curr_symbol,
					'currency_code'    => $curr_code,
					'permalink' 		=> $permalink
				);
			}
		}
		if (!empty($sort_by) AND $sort_by === 'distance') {
			$data['locations'] = sort_array($data['locations'], 'distance');
		} else if (!empty($sort_by) AND $sort_by === 'rating') {
			$data['locations'] = sort_array($data['locations'], 'total_reviews');
		}


		$config['base_url'] 		= site_url('local/all'.$url);
		$config['total_rows'] 		= count($locations);
		// $config['total_rows'] 		= $this->Locations_model->getLocalRestaurant_count($latitude,$longitude,$filter);
		$config['per_page'] 		= $filter['limit'];
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->location->initialize();

		$data['locations_filter'] = $this->filter($url);
		$this->template->render('local_all', $data);
	}

	public function filter() {
		$url = '';

		$data['search'] = '';
		if ($this->input->get('search')) {
			$data['search'] = $this->input->get('search');
			$url .= 'search='.$this->input->get('search').'&';
		}
		if ($this->input->get('keyword')) {
			$data['keyword'] = $this->input->get('keyword');
			$url .= 'keyword='.$data['keyword'].'&';
		} else {
			$data['keyword'] = '';
		}
		if ($this->input->get('type')) {
			$data['type'] = $this->input->get('type');
			$url .= 'type='.$data['type'].'&';
		} else {
			$data['type'] = '';
		}
		if ($this->input->get('rating')) {
			$data['rating'] = $this->input->get('rating');
			$url .= 'rating='.$data['rating'].'&';
		} else {
			$data['rating'] = '';
		}
		
		if ($this->input->get('veg_type')) {
			// echo'sdfh';
			// exit;
			$data['veg_type'] = $this->input->get('veg_type');
			$url .= 'veg_type='.$data['veg_type'].'&';
		} else {
			$data['veg_type'] = '';
		}
		if ($this->input->get('delivery_fee')) {
			
			$data['delivery_fee'] = $this->input->get('delivery_fee');
			$url .= 'delivery_fee='.$data['delivery_fee'].'&';
		} else {
			$data['delivery_fee'] = '';
		}

		if ($this->input->get('offer_collection')) {
			
			$data['offer_collection'] = $this->input->get('offer_collection');
			$url .= 'offer_collection='.$data['offer_collection'].'&';
		} else {
			$data['offer_collection'] = '';
		}

		$filters['distance']['name'] = lang('text_filter_distance');
		$filters['distance']['href'] = site_url('local/all?'.$url.'sort_by=distance');

		$filters['newest']['name'] = lang('text_filter_newest');
		$filters['newest']['href'] = site_url('local/all?'.$url.'sort_by=newest');

		$filters['rating']['name'] = lang('text_filter_rating');
		$filters['rating']['href'] = site_url('local/all?'.$url.'sort_by=rating');

		$filters['name']['name'] = lang('text_filter_name');
		$filters['name']['href'] = site_url('local/all?'.$url.'sort_by=name');

		$data['sort_by'] = '';
		if ($this->input->get('sort_by')) {
			$data['sort_by'] = $this->input->get('sort_by');
			$url .= 'sort_by=' . $data['sort_by'];
		}

		$data['filters'] = $filters;

		$url = (!empty($url)) ? '?'.$url : '';
		$data['search_action'] = site_url('local/all'.$url);

		return $data;
	}




	public function reserve_order_insert1() {

		    $token  = $_POST['stripeToken'];
			$email  = $_POST['stripeEmail'];
			$card_holder_name = $_POST['card_holder_name'];
			$method = $this->input->get('method');	 

			//set api key
		    $stripe = array(
		      "secret_key"      => "vEOIKxQFikObB0lIChnN5ZroyJw0xIJB",
		      "publishable_key" => "pk_OdzKa0uhabislEGTUfAPxCdTNPS2A"
		    );
    
   			
			$token = $_POST['stripeToken'];
			$data  = array('amount' => str_replace('.','',$_POST['li_0_price']),
			  'currency' => $_POST['currency_code'],
			  'source' => $token,
			 );

			$apiurl = 'https://api.stripe.com/v1/charges'; // create transaction 
			// $apiurl = 'https://api.stripe.com/v1/refunds'; // create refund
			$ch = curl_init($apiurl);
			$data = http_build_query($data);	
			$header = array("content-type:application/x-www-form-urlencoded");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, "vEOIKxQFikObB0lIChnN5ZroyJw0xIJB".":");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$dt = curl_exec($ch);
			curl_close($ch);
			$dt = json_decode($dt,true);
			echo '<pre>';
			print_r($dt);
			exit;

			  
	}

	public function reserve_order_insert() {
		
		if($_POST['payment_type'] == 'paypal')
		{
			if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {
			$enableSandbox = true;
			$paypalConfig = [
			    'email' => 'abdul.uplogics@gmail.com',
			    'return_url' => site_url().'account/orders',
			    'notify_url' => site_url().'Local/reserve_order_insert'
			];
			$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
			$itemName = 'Test Item';
			$itemAmount = $_POST['amount'];
			$data = [];
		    foreach ($_POST as $key => $value) {
		        $data[$key] = stripslashes($value);
		    }
		    
		     // Set the PayPal account.
		    //$data['business'] = $paypalConfig['email'];
		    $data['return_url'] = $paypalConfig['return_url'];
		    $data['notify_url'] = $paypalConfig['notify_url'];
		    $data['item_name'] = $itemName;
		    $data['amount'] = $itemAmount;
		    $data['currency_code'] = $_POST['currency_code'];
		    $queryString = http_build_query($data);

		    // Redirect to paypal IPN
		    header('location:' . $paypalUrl . '?' . $queryString);
		    exit();
			}
		}
	  	$method = $_POST['method'];	

	  	$pay_location = $this->Locations_model->getLocation($this->session->userdata('local_info')['location_id']);
	  	$staff_details = $this->Staffs_model->getStaff($pay_location['added_by']);
		$payment_status = unserialize($staff_details['payment_details']);
	  	$hashkey  = $_POST['key'];
		$sellerid = $_POST['sid'];
		$total 	  = $_POST['total'];
		$using_reward_points 	= $_POST['using_reward_points'];
		$using_reward_amount 	= $_POST['using_reward_amount'];
		$used_reward_point 		= $_POST['reward_point'];

		if($_POST['demo'] == "Y")
		{
			$order_number = '1'; // for demo order
		}
		else
		{
			$order_number = $_POST['order_number']; // for live order
		}

		if($this->session->userdata('reservation_data'))
		{
			$_POST['payment_type'] = 'cash';
		}
		
		//$SecretWord = $payment_status['payment_secret_token']; //2Checkout Secret Word
		//$hashSid = $sellerid; //2Checkout account number
		//$hashTotal = $total; //Sale total to validate against
		//$hashOrder = $order_number; //2Checkout Order Number
		//$StringToHash = strtoupper(md5($SecretWord . $hashSid . $hashOrder . $hashTotal));
		
		//echo '<pre>';print_r($this->session->userdata('reservation_data'));exit;

		// exit;
		//if($StringToHash==$hashkey || $method == 'book_table') {
		if($_POST['payment_type'] == 'stripe' || $_POST['payment_type'] == 'cash' || isset($_POST["txn_id"])) {
			

			if($_POST["txn_id"]) { $_POST['payment_type'] = "paypal_express";}

		   if ($this->session->userdata('reservation_data')){
		   	$post = $_POST;
			
		   	$reserve = array();
			$order_data = array();
			$reserve['payment_method'] = "cash";
			$reservation_data = $this->session->userdata('reservation_data');
			
			if (!empty($reservation_data)) {
				if (!empty($reservation_data['location'])) {
					$reserve['location_id'] = (int)$reservation_data['location'];
				}
				$client_number = $this->Locations_model->getvendormobile($reserve['location_id']);

				if (!empty($reservation_data['table_found']) AND !empty($reservation_data['table_found']['table_id'])) {
					$reserve['table_id'] = $reservation_data['table_found']['table_id'];
				}

				if (!empty($reservation_data['guest_num'])) {
					$reserve['guest_num'] = (int)$reservation_data['guest_num'];
				}

                if (!empty($reservation_data['reserve_date'])) {
					$reserve['reserve_date'] = $reservation_data['reserve_date'];
				}

				if (!empty($reservation_data['selected_time'])) {
					$reserve['reserve_time'] = date('H:i:s',strtotime($reservation_data['reserve_time']));
				}

				if ($this->customer->getId()) {
					$reserve['customer_id'] = $this->customer->getId();
					$order_data['customer_id'] = $this->customer->getId();
				} else {
					$reserve['customer_id'] = '0';
					$order_data['customer_id'] = '0';
				}

				$first_name =  $_POST['card_holder_name'];
				$email = $_POST['email'];
				$telephone = $_POST['country_code'].'-'.$_POST['mobile'];

				if($first_name == ''){
					$first_name =  $this->input->post('card_holder_name');
					$email = $this->input->post('email') ;
					$telephone = $this->input->post('country_code').'-'.$this->input->post('mobile');
				}


				$reserve['first_name']  = $first_name;
				$reserve['email'] 		= $email;
				$reserve['telephone'] 	= $telephone;
				$reserve['ip_address']  = $this->input->ip_address();
				$reserve['user_agent']  = $this->input->user_agent();

				$available_table_id = $this->Reservations_model->checkReservationTable($reserve['guest_num'],$reserve['location_id'],$reserve['reserve_date'],$reserve['reserve_time']);

				$reserve['reservation_id'] = $this->Locations_model->generateReservationNumber($reserve['location_id']);

                $reserve['otp'] = $this->Locations_model->generateOtp($reserve['location_id']);

               	$reserve['booking_price'] = $reservation_data['table_price'];

               	/*$reserve['booking_tax'] = $this->config->item('tax_percentage');

                $reserve['booking_tax_amount'] = round($reservation_data['table_price'] * ($this->config->item('tax_percentage') / 100),2);*/

                $reserve['booking_tax'] 		= 0;
				$reserve['booking_tax_amount']  = 0;

                $reserve['total_amount'] = $reservation_data['table_price'] + $reserve['booking_tax_amount'];

                
                $reserve['used_reward_point'] = $used_reward_point;
                if($used_reward_point == 0){
                $reserve['using_reward_points'] = 0;
                $reserve['using_reward_amount'] = 0;
                }else{
                $reserve['using_reward_points'] = $using_reward_points;
                $reserve['using_reward_amount'] = $using_reward_amount;
            	}
                $reserve['payment_key'] = $order_number;
               	if($this->session->userdata('cart_contents'))
                {

                $order_data['location_id']  = $reservation_data['location'];
                $order_data['first_name']   = $_POST['card_holder_name'];
            	$order_data['email'] 		= $_POST['email'];
				$order_data['telephone'] 	= $_POST['country_code'].'-'.$_POST['mobile'];
				$order_data['order_date']   = $reservation_data['reserve_date'];
				$order_data['order_time']   = $reservation_data['selected_time'];
				$order_data['payment']   	= $_POST['payment_type'];
				$order_data['status']   	= '21';
				// $order_data['payment']   	= $_POST['payment_type'];
				$order_data['comment']   	= $_POST['comment'];
				$order_data['table_price'] 	= $reservation_data['table_price'];
				
				$reserve['order_id'] 	    = $this->Orders_model->addOrder($order_data, $this->session->userdata('cart_contents'));
				 $this->load->model('Coupons_model');
                    $this->Coupons_model->redeemCoupon($reserve['order_id']);

				$reserve['order_price'] = $this->session->userdata('overall_price');

				$reserve['total_amount'] = $this->session->userdata('overall_price') + $reservation_data['table_price'];
				$reserve['booking_tax'] 		= 0;
				$reserve['booking_tax_amount']  = 0;
				$reserve['payment_method'] = $_POST['payment_type'];

				}
				/***********Reward Points***************/
				if($pay_location['reward_status'] == '1' && $reserve['using_reward_points'] == 0 && $reserve['customer_id'] != 0)
		   		{
		   			$rewards_value  =  $pay_location['rewards_value'];  // Rewards % value
		   			$reward_point   =  $reserve['total_amount'] * ($rewards_value / 100);
		   			$reserve['reward_points'] = $reward_point;

		   		}
		   		/***********Reward Points***************/

		   		//print_r($reserve);exit;
                $total_tables = $reservation_data['tables'];
               
					for($i=0;$i<$total_tables;$i++)
					{
						$reserve['table_id'] = $available_table_id[$i];
                    	$reservation_id = $this->Reservations_model->addReservation($reserve);

                    }
                   
                    if($reserve['using_reward_points'] != 0){
                  		$this->Reservations_model->addRewardHistory($reserve);
                  		$this->Reservations_model->updatecustomerrewards($used_reward_point,$this->customer->getId());

                	}
                	$sms_status = $this->Extensions_model->getExtension('twilio_module');                	
					if($sms_status['ext_data']['status'] == 1)
					{
	                	$current_lang = $this->session->userdata('lang');
						if(!$current_lang) { $current_lang = "english";}
						$this->load->model('Extensions_model');

						//For Customers

						$sms_code = 'reservation_'.$current_lang;						
						$sms_template = $this->Extensions_model->getTemplates($sms_code);
						$message = str_replace("Â","",$sms_template['body']);
						$message = str_replace("{unique_code}",$reserve['otp'],$message);
						$message = str_replace("{reservation_number}",$reserve['reservation_id'],$message);
	                	
						//For Vendors
						
	                	$sms_code_ven = 'reservation_location_'.$current_lang;						
						$sms_template_ven = $this->Extensions_model->getTemplates($sms_code_ven);
						$message_ven = str_replace("Â","",$sms_template_ven['body']);
						$message_ven = str_replace("{unique_code}",$reserve['otp'],$message_ven);
						$message_ven = str_replace("{reservation_number}",$reserve['reservation_id'],$message_ven);


	                	$this->session->set_tempdata('last_reservation_id', $reservation_id);
	                	$ctlObj = modules::load('twilio_module/twilio_module/');


	                	$customer_msg	= $ctlObj->sendSms($reserve['telephone'],$message);
	                	$vendor_msg		= $ctlObj->sendSms($client_number,$message_ven);
                	}

    				//$this->session->unset_userdata('reservation_data');
    				$this->cart->destroy();
    				$out['res_id'] = $reservation_id;
    				$out['reservation_id'] = $reserve['reservation_id'];
					$out['otp'] = $reserve['otp'];
					$out['status'] = 'success';
    				//echo $reserve['reservation_id'].'&'.$reserve['otp'];exit;
            	}
            	
	        }
	        else if($this->session->userdata('cart_contents'))
            {
            	if(isset($_POST["txn_id"]))
				{
					$_POST['card_holder_name'] =  $_POST['first_name'];
					$_POST['email'] =  $_POST['payer_email'];
					$email =  $_POST['payer_email'];
				}
            	$local_info 				= $this->session->userdata('local_info');
	            $order_data['location_id']  = $local_info['location_id'];
	            $order_data['first_name']   = $_POST['card_holder_name'];
	        	$order_data['email'] 		= $_POST['email'];
				$order_data['telephone'] 	= $_POST['country_code'].'-'.$_POST['mobile'];
				$order_data['order_date']   = date("Y-m-d");
				$order_data['order_time']   = date("H:i:s");
				$reservation_data = $this->session->userdata('reservation_data');
				//print_r($reservation_data);exit;
				if(!empty($reservation_data)){
					$order_data['booking_type']   = 'reservation';
				}else{
					$order_data['booking_type']   = 'order';
				}

				$order_data['order_type'] 	= $local_info['order_type'];

				$order_data['payment']   	= $_POST['payment_type'];
				$add_id = $_POST['delivery_address'];
				if($add_id=='add_new_addr'){

					$address['address_1']		= $_POST['address']['address_1'];
					$address['address_2']		= $_POST['address']['address_2'];
					$address['city']			= $_POST['address']['city'];
					$address['state']			= $_POST['address']['state'];
					$country 					= $this->Locations_model->getCountryID($_POST['address']['country']);
					$address['country']			= $country[0]['country_id'];
					$address['postcode']		= $_POST['address']['postcode'];
					$address['clatitude']		= $_POST['address']['location_lat'];
					$address['clongitude']		= $_POST['address']['location_lng'];
					$address['customer_id']		= $this->customer->getId();
					$address['default_address'] = 'off';


					$this->Addresses_model->saveAddress($address['customer_id'], $address_id = FALSE, $address);
					$order_data['address_id']   = $this->db->insert_id();
					/*echo '<pre>';
					print_r($address);exit;*/
				}else{
					$order_data['address_id']   = $add_id;
				}
				$order_data['used_reward_point'] = $used_reward_point;
                if($used_reward_point == 0){
                $order_data['using_reward_points'] = 0;
                $order_data['using_reward_amount'] = 0;
                }else{
                $order_data['using_reward_points'] = $using_reward_points;
                $order_data['using_reward_amount'] = $using_reward_amount;
            	}
				
				//$order_data['table_price'] 	= $reservation_data['table_price'];
				$reserve['customer_id'] = $this->customer->getId();
				$order_data['customer_id'] = $this->customer->getId();	
				$order_data['total_amount'] = $this->session->userdata('overall_price');
				/***********Reward Points***************/
				if($pay_location['reward_status'] == '1' && $order_data['using_reward_points'] == 0 && $order_data['customer_id'] != 0)
		   		{
		   			$rewards_value  =  $pay_location['rewards_value'];  // Rewards % value
		   			$reward_point   =  $order_data['total_amount'] * ($rewards_value / 100);
		   			$order_data['reward_points'] = $reward_point;

		   		}
		   		/***********Reward Points***************/
		  //  		echo '<pre>';
		  //  		echo print_r($this->session->userdata('overall_price'));
		  //  		echo print_r($order_data);
				// exit;
				$reserve['order_id'] 	    = $this->Orders_model->addOrder($order_data, $this->session->userdata('cart_content'),$this->session->userdata('cart_contents'),$_POST);

				$status_update['object_id']    = (int) $reserve['order_id'];
                $status_update['status_id']    = 1;
                $status_update['comment']      = 'Your Order is Pending';
                $status_update['notify']       = 0;
                $status_update['date_added']   = mdate('%Y-%m-%d %H:%i:%s', time());

                $this->Statuses_model->addStatusHistory('order', $status_update);
				$this->load->model('Coupons_model');
	            $this->Coupons_model->redeemCoupon($reserve['order_id']);

				$reserve['order_price'] = $this->session->userdata('overall_price');

				$reserve['total_amount'] = $this->session->userdata('overall_price')+ $reservation_data['table_price'];
				$reserve['booking_tax'] 		= 0;
				$reserve['booking_tax_amount']  = 0;
				$reserve['payment_method'] = $_POST['payment_type'];
				
				//echo '<pre>';
            	//print_r($this->session->userdata('cart_contents'));exit;

            	$url = __DIR__.'/../../firebase.json';			
				$project_id = json_decode(file_get_contents($url));
				$db = 'https://'.$project_id->project_id.'.firebaseio.com/';
				$serviceAccount = ServiceAccount::fromJsonFile($url);
				$firebase = (new Factory)
							->withServiceAccount($serviceAccount)
							->withDatabaseUri($db)
							->create();
				$database = $firebase->getDatabase();
				$time_format = 'h:i a';
				$date_format = 'd M, Y';
				$datac['delivery_partner']  = '';
				
				
			    $datac['date'] 				=  date($date_format, strtotime($order_data['order_date']));
			    $datac['location_id']		=  $local_info['location_id'];
			    $datac['location_name'] 	=  $this->Locations_model->getLocationName($local_info['location_id']);
			    $datac['location_image'] 	=  $this->Locations_model->getLocationImage($local_info['location_id']);
			    $datac['order_id'] 			=  $reserve['order_id'] ;			   
			    $datac['time'] 				=  date($time_format, strtotime($order_data['order_time']));
				$datac['status'] 			=  'Pending';
				$datac['status_id'] 		=  1;
				$datac['price'] 			=  $this->currency->format($reserve['order_price']);		
				
				$newpost2 = $database->getReference('customer_pendings/'.$this->customer->getId().'/'.$datac['order_id'])->set($datac);
		            $notify = $this->Orders_model->sendConfirmationMail($reserve['order_id']);

            	$this->cart->destroy();
				$out['order_id'] = $reserve['order_id'];
				$out['order']  = 'Order';
				$out['status'] = 'success';
			}
	        else
	        {

	        	//echo "hai";exit;
	        	$out['status'] = 'fail';
	        	
	        }
    	} else {
    		//echo "hai1";exit;
	   		$out['status'] = 'Error';
	   		
		}

		if($_POST['payment_type']=='stripe'){

			$token  = $_POST['stripeToken'];
			$email  = $_POST['stripeEmail'];
			$card_holder_name = $_POST['card_holder_name'];
			$method = $_POST['method'];	 
    
   			
			$token = $_POST['stripeToken'];
			$data  = array('amount' => str_replace('.','',$_POST['li_0_price']),
			  'currency' => $_POST['currency_code'],
			  'source' => $token,
			 );

			$apiurl = 'https://api.stripe.com/v1/charges'; // create transaction 
			// $apiurl = 'https://api.stripe.com/v1/refunds'; // create refund
			$ch = curl_init($apiurl);
			$data = http_build_query($data);	
			$header = array("content-type:application/x-www-form-urlencoded");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, "vEOIKxQFikObB0lIChnN5ZroyJw0xIJB".":");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$dt = curl_exec($ch);
			curl_close($ch);
			$dt = json_decode($dt,true);
			
			if($dt['id']==''){
				$out['status'] = 'Error';
			}else{
			$payment_response = $this->Reservations_model->add2checkoutdetails($token,$reserve['order_id'],$reserve['customer_id'],serialize($dt ),$_POST['payment_type']);
			}
		}else if($_POST['payment_type']=='cash'){
			$payment_response = $this->Reservations_model->add2checkoutdetails('cash',$reserve['order_id'],$reserve['customer_id'],serialize($dt),$_POST['payment_type']);
		}else if($_POST['payment_type']=='instant'){
			$payment_response = $this->Reservations_model->add2checkoutdetails($_POST['txn_id'],$reserve['order_id'],$reserve['customer_id'],serialize($_POST),'paypal');
		}


		
		$this->load->library('session');
	  	$this->session->unset_userdata('reservation_data');
	  	$this->session->unset_userdata('__ci_vars');
	  	$this->session->unset_userdata('redirect_url');
	  	$this->session->unset_userdata('checkout_back_url');
	  	$this->session->unset_userdata('confirm_back_url');
        //$this->success($out);

        $this->template->render('success_payment', $out);
    }
    public function success($out=array()) {
    	
    	$this->template->render('success_payment', $out);
	}
}

/* End of file local.php */
/* Location: ./main/controllers/local.php */