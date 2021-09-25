<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Delivery_payout extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Categories');
        $this->user->restrict('Admin.Orders');

        $this->load->model('Delivery_payout_model'); // load the menus model
        $this->load->model('Categories_model'); // load the menus model
        $this->load->model('Image_tool_model');
        $this->load->library('pagination');
        $this->lang->load('delivery_payout');

	}

	public function index() {
		
		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 0;
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

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = "cusotmers.".$this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'delivery.date_added';
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
		

		$results = $this->Delivery_payout_model->getList($filter);
		// print_r($results);
		// exit;

		$data['payout'] = array();
		foreach ($results as $result) {
			$pending = $this->Delivery_payout_model->getPendinghistory($result['delivery_id']);
			// print_r($pending);
			// exit;
			if($pending) {
				$pending_amount = $pending['amount'];
			} else {
				$pending_amount = '';
			}
			// echo $pending_amount;
			// exit;
			//load categories data into array
			$data['payout'][] = array(
				'delivery_id'	 		=> $result['delivery_id'],
				'bank_name'	 			=> $result['bank_name'],
				'account_number'	 	=> $result['account_number'],
				'routing_number'	 	=> $result['routing_number'],
                'first_name' 			=> $result['first_name'],
                'email' 				=> $result['email'],
                'status' 				=> $result['status'],
                'last_name' 			=> $result['last_name'],
                'wallet' 			    => $result['wallet'],
                'pending_amount' 		=> $pending_amount
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= '&sort_by='.$filter['sort_by'].'&';
			$url .= '&order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('delivery_payout'.$url);
		$config['total_rows'] 		= $this->Delivery_payout_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('delivery_payout', $data);
	}

	public function approve() {
		$history_id = $this->input->get('id');
		$deliver_id = $this->input->get('deliver_id');
		$up_data = [
            'status' => 'completed',
            'date' => date('Y-m-d H:i:s')
        	];

        	
        	$update = $this->Delivery_payout_model->updateHistory($history_id,$up_data);
        	if ($update) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Delivery Partner Payout withdrawn '));                
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			redirect('delivery_payout/pending?id='.$deliver_id);
	}

	public function reject() {
		$history_id = $this->input->get('id');
		$deliver_id = $this->input->get('deliver_id');
		$history = $this->Delivery_payout_model->selectHistory($history_id);
		$amount = $history['amount'];
		$deliver = $this->Delivery_payout_model->getUser($deliver_id);

		$wallet = $deliver['wallet'];
		$new_wallet = $wallet + $amount;
		// echo '<pre>';
		// print_r($deliver);
		// print_r($new_wallet);
		// print_r($wallet);
		// print_r($amount);
		// exit();

			$up_data = [
            'status' => 'rejected',
            'date' => date('Y-m-d H:i:s')
        	];
        	
        	$update = $this->Delivery_payout_model->updateHistory($history_id,$up_data);

        	$up_deliver = [
            'wallet' => $new_wallet
        	];
        	
        	$del_update = $this->Delivery_payout_model->updateDelivery($deliver_id,$up_deliver);
        	if ($update && $del_update) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Delivery Partner Payout rejected '));                
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			redirect('delivery_payout/pending?id='.$deliver_id);
	}
	public function pending() {
		// echo $this->input->get('filter_search');
		// exit;
		$url = '?';
		$id = $this->input->get('id');
		$url .= 'id='.$id;
		$filter = array();
		if ($this->input->get('page')) {
			// echo 'kfjsd';
			// exit;
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 0;
		}
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

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = "cusotmers.".$this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'delivery.date_added';
		}
		$filter['deliver_id'] = $id;
		$results = $this->Delivery_payout_model->getPendinglist($filter);

		$user = $this->Delivery_payout_model->getPayouts((int)$this->input->get('id'));
		$this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		// echo '<pre>';
		// print_r($results);
		// exit;
		$data['username'] = $user['first_name'];
		$data['url'] = $url;
		$data['deliver_id'] = $id;
		$data['payout'] = array();
		if($results) {
			foreach ($results as $result) {
				$data['payout'][] = array(
					'history_id'	 		=> $result['id'],
	                'invoice_id' 			=> $result['invoice_id'],
	                'deliver_id' 			=> $result['deliver_id'],
	                'amount' 				=> $result['amount'],
	                'status' 				=> $result['status'],
	                'date' 					=> $result['date']
				);
			}
		}
		// echo $url;
		// exit;
		$config['base_url'] 		= site_url('delivery_payout/pending'.$url);
		$config['total_rows'] 		= $this->Delivery_payout_model->getPendingCount($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('pending_history', $data);
	}

	public function completed() {

		$url = '?';
		$id = $this->input->get('id');
		$url .= 'id='.$id;
		$filter = array();
		if ($this->input->get('page')) {
			// echo 'kfjsd';
			// exit;
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 0;
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

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if ($this->input->get('filter_status')) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = "cusotmers.".$this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'delivery.date_added';
		}
		$filter['deliver_id'] = $id;
		 $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));

		$results = $this->Delivery_payout_model->getCompletedlist($filter);

		$user = $this->Delivery_payout_model->getPayouts((int)$this->input->get('id'));
		// echo '<pre>';
		// print_r($results);
		// exit;
		$data['username'] = $user['first_name'];
		$data['deliver_id'] = $id;
		// print_r($results);
		// exit;
		$data['payout'] = array();
		if($results) {
			foreach ($results as $result) {
				
				// echo $pending_amount;
				// exit;
				//load categories data into array
				$data['payout'][] = array(
					'history_id'	 		=> $result['id'],
	                'invoice_id' 			=> $result['invoice_id'],
	                'deliver_id' 			=> $result['deliver_id'],
	                'amount' 				=> $result['amount'],
	                'status' 				=> $result['status'],
	                'date' 					=> $result['date']
				);
			}
		}
		$config['base_url'] 		= site_url('delivery_payout/completed'.$url);
		$config['total_rows'] 		= $this->Delivery_payout_model->getCompletedCount($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('completed_history', $data);
	}
	public function pay_to_bank() {

		$delivery_info = $this->Delivery_payout_model->getPayouts((int)$this->input->get('id'));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('delivery_payout'), 'title' => 'Back'));
		
		if ($delivery_info) {	

		    $delivery_id = $delivery_info['delivery_id'];
			$data['_action']	= site_url('delivery_payout/pay_to_bank?id='. $delivery_id);
			$data['first_name'] 		= $delivery_info['first_name'];
			$data['last_name'] 			= $delivery_info['last_name'];
			$data['wallet'] 			= $delivery_info['wallet'];
			$data['delivery_id'] 		= $delivery_info['delivery_id'];
		} 
		

		if ($this->input->post() AND $delivery_id = $this->_saveDelivery($delivery_info['wallet'])) {
			
			if ($this->input->post('save_close') === '1') {
				redirect('delivery_payout');
			}



			redirect('delivery_payout/pay_to_bank?id='. $delivery_id);
		}

		$this->template->render('pay_to_bank', $data);
	}

	private function _saveDelivery($wallet) {
		
		
    	if ($this->validateForm($wallet) === TRUE) {
    		$input =$this->input->post(); 
    		$history_id = $this->Delivery_payout_model->getHistoryid()+1;
			$a = sprintf("%06d", $history_id);
			$invoice_id = 'INV'.$a;
			$delivery_info = $this->Delivery_payout_model->getPayouts((int)$input['delivery_id']);
			$new_wallet = $delivery_info['wallet'] - $input['wallet'];

			$data = [
            'invoice_id' => $invoice_id,
            'deliver_id' => $input['delivery_id'],
            'payment_type' => 'cash',            
            'date' => date('Y-m-d H:i:s'),
            'status' => 'completed',
            'amount' => $input['wallet'],
        	];

        	$up_data = [
            'wallet' => $new_wallet
        	];

        	$insert = $this->Delivery_payout_model->insertHistory($data);
        	$update = $this->Delivery_payout_model->updateDelivery($input['delivery_id'],$up_data);

			if ($insert && $update) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Delivery Partner Payout withdrawn'));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $input['delivery_id'];
		}
	}

    private function validateForm($wallet) {
    	$input =$this->input->post();
		//$this->form_validation->set_rules('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('wallet', 'lang:label_amount', 'less_than_equal_to['.$wallet.']|'.'xss_clean|trim|required|greater_than[0]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file categories.php */
/* Location: ./admin/controllers/categories.php */