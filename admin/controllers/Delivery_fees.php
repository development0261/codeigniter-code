<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Delivery_fees extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Categories');

        $this->load->model('Delivery_fees_model'); // load the menus model
        $this->load->model('Categories_model'); // load the menus model
        $this->load->model('Image_tool_model');
        $this->load->library('pagination');
        $this->lang->load('delivery_fees');
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

	
	public function update_fees() {
		$this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('delivery'), 'title' => 'Back'));

		$results = $this->Delivery_fees_model->getList($filter);
		
		if($results) {
			foreach ($results as $result) {
				if($result['item'] == 'standard_fee') {
					$data['standard_fee'] = $result['value'];
				}
				if($result['item'] == 'premium_fee') {
					$data['premium_fee'] = $result['value'];
				}
					
				// $result['item'] == 'premium_fee' ? $data['premium_fee'] = $result['value'] : $data['premium_fee'] = 0;
				// $result['item'] == 'standard_fee' ? $data['standard_fee'] = $result['value'] : $data['standard_fee'] = 0;
				// }
			
			}
		}
		if ($this->input->post() AND $update = $this->_saveDelivery()) {
			
			if($update['standard_fee'] && $update['premium_fee']) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Fees Updated'));
			}

			if ($this->input->post('save_close') === '1') {
				redirect('delivery_fees/update_fees');
			}

			redirect('delivery_fees/update_fees');
		}
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->template->render('delivery_fees', $data);
	}
	


	private function _saveDelivery() {		
		
    	if ($this->validateForm() === TRUE) {
    		$input =$this->input->post(); 
    		$update = $this->Delivery_fees_model->deliveryFees();
    		return $update;
		}
	}

    private function validateForm() {
    	$input =$this->input->post();
		//$this->form_validation->set_rules('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('standard_fee', 'lang:standard_fee', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('premium_fee', 'lang:premium_fee', 'xss_clean|trim|required|numeric');
		
		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file categories.php */
/* Location: ./admin/controllers/categories.php */