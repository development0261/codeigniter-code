<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reservations extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

        if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
            redirect('account/login');
        }

		$this->load->library('currency'); 														// load the currency library

        $this->load->model('Reservations_model');	
        $this->load->model('Locations_model');	
        $this->load->model('Statuses_model');													// load orders model

        $this->lang->load('account/reservations');

		if ($this->config->item('reservation_mode') !== '1') {
			$this->alert->set('alert', $this->lang->line('alert_reservation_disabled'));
			redirect('account/account');
		}
	}

	public function index() {

		$url = '?';
		$filter = array();
		$filter['customer_id'] = (int) $this->customer->getId();
		$customer_id = $filter['customer_id'];
		if ($this->input->post()) {	

			$res_id = $this->input->post('reservation_id');	
			$refund_amount = $this->input->post('refund_amount');	
			$curren_status = $this->input->post('curren_status');
			$cancel_percent	 = $this->input->post('cancel_percent');
			 $before_status_name = $this->input->post('before_status_name');
			if($before_status_name == 'Pending'){

					$cancel_data = $this->Reservations_model->getReservationDetails($res_id,$customer_id);
					
					$location_id = $cancel_data['location_id'];
                	$sellerid = $cancel_data['staff_id'];
                	
                	$percentage =  $this->Locations_model->getSellerCommission($sellerid);
                	$commission_percentage = $percentage[0]['commission'];
               		$amt = $this->Locations_model->getReserveDetails($res_id);
               		$status_detail = $this->Statuses_model->getStatus('16');
               		if($curren_status==''){
               			$curren_status = $status_detail['status_name'];
               		}
               		$total_amount = round($amount,2);

				$this->Locations_model->applyCommission($sellerid,$location_id,$amt,$commission_percentage,$res_id,$status_detail['status_name'],$status_id);
		
				$this->Locations_model->updateStatus($res_id,'17',$curren_status);		

			}

		 $poss = array(
		 	'X-API-KEY:RfTjWnZr4u7x!A-D',
		 	);
		
		 $pass_data = array(
		    'reservation_id' => $res_id ,
		    'refund_amount'  => $refund_amount,
		    'curren_status'  => $curren_status,
		    'cancel_percent' => $cancel_percent

		  );
		  $curl = curl_init();
		  
		  // We POST the data
		  curl_setopt($curl, CURLOPT_POST, 1);
		  // Set the url path we want to call
		  curl_setopt($curl, CURLOPT_URL, site_url().'api/RestaurantsList/restaurantCancellation');  
		  // Make it so the data coming back is put into a string
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  // Insert the data
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $pass_data);
		  curl_setopt($curl, CURLOPT_HTTPHEADER, $poss);

		  $result = curl_exec($curl);
		  // Get some cURL session information back
		  $info = curl_getinfo($curl);  
		  //print_r($result);exit;
		  // Free up the resources $curl is using
		  curl_close($curl);


			
		}

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

        $filter['sort_by'] = 'id';
        $filter['order_by'] = 'DESC';

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'),'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'),'account/reservations');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['back_url'] 			  = site_url('account/account');
		$data['new_reservation_url']  = site_url('reservation');

		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';
		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['reservations'] = array();
		$results = $this->Reservations_model->getList($filter);			
		
		// retrieve customer reservations based on customer id from getMainReservations method in Reservations model
		foreach ($results as $result) {
			$cancellation_period = explode('-',$result['cancellation_period']);
			$data['reservations'][] = array(													// create array of customer reservations to pass to view
				'reservation_id' 		=> $result['reservation_id'],
				'location_name' 		=> $result['location_name'],
				'location_name_ar' 		=> $result['location_name_ar'],
				'location_id'			=> $result['location_id'],
				'status_name' 			=> $result['status_name'],
				'status' 			    => $result['status'],
				'reserve_date' 			=> day_elapsed($result['reserve_date']),
				'reserve_time'			=> mdate($time_format, strtotime($result['reserve_time'])),
				'refund_status'         => $result['refund_status'],
				'review_status'         => $result['review_status'],
				'guest_num'				=> $result['guest_num'],
				'table_name' 			=> $result['table_name'],
				'order_price'			=> $result['order_price'],
				'reward_used_amount'	=> $result['reward_used_amount'],
				'total_amount'			=> $result['total_amount'],
				'cancellation_period' 	=> json_decode($cancellation_period[0]),
				'cancellation_time' 	=> json_decode($cancellation_period[1]),
				'cancellation_charge' 	=> json_decode($result['cancellation_charge']),
				'cancel_count'			=> count(json_decode($result['cancellation_charge'])),
				'view' 					=> site_url('account/reservations/view/' . $result['id']),
				'leave_review' 			=> site_url('account/reviews/add/reservation/'. $result['reservation_id'] .'/'. $result['location_id'])
			);
		}

		$prefs['base_url'] 			= site_url('account/reservations'.$url);
		$prefs['total_rows'] 		= $this->Reservations_model->getListCount($filter);
		$prefs['per_page'] 			= $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('account/reservations', $data);
	}

	public function view() {
		$this->load->library('country');
		$this->load->model('Locations_model');		// load locations model
		$this->load->model('Cancel_policy_model');	

		$result = $this->Reservations_model->getReservation($this->uri->rsegment(3), $this->customer->getId());
		
		if (empty($result) OR empty($result['reservation_id']) OR empty($result['status']) OR $result['status'] <= 0) {															// check if customer_id is set in uri string
  			redirect('account/reservations');
		}
		
			
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reservations');
		$this->template->setBreadcrumb($this->lang->line('text_view_heading'), 'account/reservations/view');

		$this->template->setTitle($this->lang->line('text_view_heading'));
		$this->template->setHeading($this->lang->line('text_view_heading'));

		$data['back_url'] 				= site_url('account/reservations');

		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';
		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party'
		);
		$data['res_id'] 			= $result['id'];
		$data['reservation_id'] 	= $result['reservation_id'];
        $data['order_id'] 			= $result['order_id'];
        $data['location_id'] 		= $result['location_id'];
        $data['status'] 			= $result['status_name'];
        $data['refund_status'] 		= $result['type'];
        $data['refund_amount'] 		= $result['refund_amount'];
        $data['reward_amount'] 		= $result['reward_amount'];
        $data['total_amount']		= $result['total_amount'];
        $data['otp'] 				= $result['otp'];
        $data['cancel_percent'] 	= $result['cancel_percent'];
        $data['cancellation_time']	= date("h:i a jS F Y", strtotime($result['created_at']));
        $data['guest_num'] 			= $result['guest_num'] . ' ' . lang('person');
        $data['reserve_date'] 		= date("jS F Y", strtotime($result['reserve_date']));
        $data['reserve_time'] 		= date("h:i a",strtotime($result['reserve_time']));
        $data['occasion_id'] 		= $result['occasion_id'];
        $data['status_name'] 		= $result['status_name'];
        $data['table_name'] 		= $result['table_name'];
        $data['table_price'] 		= $result['booking_price'];
        $data['first_name'] 		= $result['first_name'];
        $data['last_name'] 			= $result['last_name'];
        $data['email'] 				= $result['email'];
        $data['telephone'] 			= $result['telephone'];
        $data['comment'] 			= $result['comment'];

        $location_address = $this->Locations_model->getAddress($result['location_id']);        
        $data['location_name'] = $location_address['location_name'];
        $data['location_name_ar'] = $location_address['location_name_ar'];
        $data['location_address'] = $this->country->addressFormat($location_address);
        $data['location_address_ar'] = $this->country->addressFormatAR($location_address);
        $data['cancel_policy'] = $this->Cancel_policy_model->getPolicy($result['location_id']);	
		$this->template->render('account/reservations_view', $data);
	}
}

/* End of file reservations.php */
/* Location: ./main/controllers/reservations.php */