<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Refund extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Refund');
        $this->load->model('Refund_model');
        $this->load->model('Reservations_model');
        $this->load->library('pagination');
        $this->load->library('currency');
		$this->load->library('session');
        $this->lang->load('refund');
        $this->load->model('Extensions_model');
		
	}

	public function index() {

		if($this->input->post('delete')!='') 
		{	
			$delete = $this->input->post('delete');
			foreach($delete as $key => $value) {
				$this->bulkpay($value,$key);						
			}
			$this->alert->set('success','Requested data refund successfully');
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
		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		//$this->template->setButton($this->lang->line('text_pay_button'), array('class' => 'btn btn-info', 'onclick' => 'confirmpay();'));;

		$this->template->setButton($this->lang->line('menu_refund_report'), array('class' => 'btn btn-primary', 'href' => site_url('refund_report')));

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_reservation_id'] = site_url('refund'.$url.'sort_by=reservation_id&order_by='.$order_by);
		$data['sort_cust_fname'] 	 = site_url('refund'.$url.'sort_by=cust_fname&order_by='.$order_by);
		$data['sort_cust_lname'] 	 = site_url('refund'.$url.'sort_by=cust_lname&order_by='.$order_by);
		$data['sort_cust_email'] 	 = site_url('refund'.$url.'sort_by=cust_email&order_by='.$order_by);
		$data['sort_refund_amount']  = site_url('refund'.$url.'sort_by=refund_amount&order_by='.$order_by);

		$data['tables'] = array();
		$type = 'requested';
		$results = $this->Refund_model->getList($filter,$type);

		foreach ($results as $result) {
			$data['tables'][] = array(
				'reservation_id'	=> $result['reservation_id'],
				'cust_fname'		=> $result['first_name'],
				'cust_email'		=> $result['email'],
				'refund_amount'		=> $result['refund_amount'],
				'staff_id'          => $result['staff_id'],
				'type'		        => $result['type'],
				'table_status'		=> ($result['type'] == 'Requested') ? $this->lang->line('text_requested') : $this->lang->line('text_paid'),
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= '&sort_by='.$filter['sort_by'].'&';
			$url .= '&order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('refund'.$url);
		$type = 'requested';
		$config['total_rows'] 		= $this->Refund_model->getCount($filter,$type);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);
		$this->template->render('refund', $data);
	}

	public function edit() {
		$table_info = $this->Refund_model->getTable((int) $this->input->get('id'));

		if ($table_info) {
			$table_id = $table_info['table_id'];
			$data['_action']	= site_url('tables/edit?id='. $table_id);
		} else {
		    $table_id = 0;
			$data['_action']	= site_url('tables/edit');
		}

		$title = (isset($table_info['table_name'])) ? $table_info['table_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('tables'), 'title' => 'Back'));

		if ($this->input->post() AND $table_id = $this->_saveTable()) {
			if ($this->input->post('save_close') === '1') {
				redirect('tables');
			}

			redirect('tables/edit?id='. $table_id);
		}

		$data['table_id'] 			= $table_info['table_id'];
		$data['table_name'] 		= $table_info['table_name'];
		$data['min_capacity'] 		= $table_info['min_capacity'];
		$data['max_capacity'] 		= $table_info['max_capacity'];
		$data['table_status'] 		= $table_info['table_status'];
		$data['additional_charge'] 	= $table_info['additional_charge'];
		$data['total_price'] 		= $table_info['total_price'];

		$this->template->render('tables_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$filter = array(
				'table_name' => $this->input->get('term')
			);

			$results = $this->Refund_model->getAutoComplete($filter);

			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 		=> $result['table_id'],
						'text' 		=> utf8_encode($result['table_name']),
						'min' 		=> $result['min_capacity'],
						'max' 		=> $result['max_capacity']
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}

		$this->output->set_output(json_encode($json));
	}

	public function stat() {
	  $reserve_id = $this->input->post('sid');
	  $vendor_id  = $this->input->post('vid');

	  $getstaff  = $this->load->model('Staffs_model');

	  $getpayment = $this->Staffs_model->getStaff($vendor_id);
	  $payment = unserialize($getpayment['payment_details']);

	 // print_r($payment);exit;

	  if($payment['payment_api_mode']=='sandbox'){
	  	$urlprefix = 'sandbox';
	  } else {
	  	$urlprefix = 'www';
	  }
	  $baseurl    = "https://".$urlprefix.".2checkout.com/api/sales/refund_invoice";
	  $username   = $payment['payment_api_username'];
	  $password   = $payment['payment_api_password'];
	  $pp_payment = $this->Staffs_model->pp_payment('pp_payments',$reserve_id,'order_id');
	  $p_pay = unserialize($pp_payment[0]['serialized']);
	  $slid = $p_pay['order_number'];
	  $pp_refund = $this->Staffs_model->pp_payment('refund',$reserve_id,'reservation_id');
	  $data = array(
    	'sale_id' => $slid,
    	'category' => '10',
    	'comment' => 'Cancellation',
    	'amount' =>  $pp_refund[0]['refund_amount'],
    	'currency' => 'vendor'
	  );
	  $retsuccess =  $this->doCall($baseurl,$data,$username,$password);

	  if($retsuccess) {
	  	$statuscheck = json_decode($retsuccess);

	  	if(isset($statuscheck->errors) && isset($statuscheck->errors[0])){
	  		if($statuscheck->errors[0]->message!=''){
	  		  echo $statuscheck->errors[0]->message;	
	  		} else {
	  		  echo $statuscheck['response_message'];
	  		}
	  		$updat = array(
	  	 		'response' => $retsuccess,
	  	 		'updated_at' => date('Y-m-d H:i:s')
	  	    );
	  	   $this->db->where('reservation_id',$reserve_id);
	  	   $this->db->update('refund',$updat);
	  	   $this->alert->set('warning','Request Cannot be processed');
	  	   exit;
	  	}
	  	else {

	  		 if(isset($statuscheck->response_code) && $statuscheck->response_code == 'OK')
	  		 { 
	  			$updat = array(
	  			'response' => $retsuccess,
	  			'type' => 'paid',
	  			'updated_at' => date('Y-m-d H:i:s')
	  			);
	  			$this->db->where('reservation_id',$reserve_id);
	  			$this->db->update('refund',$updat);

				$updat = array(
	  			'payment_status' => 'refunded',
	  			);
	  			$this->db->where('reservation_id',$reserve_id);
	  			$this->db->update('staffs_commission',$updat);	  			

	  			$sms_status = $this->Extensions_model->getExtension('twilio_module');

	  			if($sms_status['ext_data']['status']=='1') {

	  			  $current_lang = $this->session->userdata('admin_lang');
        		  if(!$current_lang) { $current_lang = "english"; }
                  $sms_code = 'refund_'.$lang;
                  $sms_template = $this->Extensions_model->getTemplates($sms_code);
                  $message = $sms_template['body'];
                  $message = str_replace("{reserve}",$reserve_id,$message);
                  $message = str_replace("{refund}",$pp_refund[0]['refund_amount'],$message);
                  $message = str_replace("{date}",date('Y-m-d H:i:s'),$message);
                  if($mail_data['telephone']!=''){
                    $client_msg = $this->Twilio_model->Sendsms($mail_data['telephone'],$message);
                  }
                  if($mail_data['staff_telephone']!=''){
                    $vendor_msg=$this->Twilio_model->Sendsms($mail_data['staff_telephone'],$message);
                  }
                }
	  	  		echo 'success';
	  	  		$this->alert->set('success','Requested data refund successfully');
	  	  		exit;
	  		} else {
	  			if($statuscheck->errors[0]->message!='') {
	  		  		echo $statuscheck->errors[0]->message;	
	  			} else {
	  		  		echo $statuscheck->response_message;
	  			}
	  			$updat = array(
	  	 		'response' => $retsuccess,
	  	 		'updated_at' => date('Y-m-d H:i:s')
	  	    	);
	  	    	$this->alert->set('warning','Request Cannot be processed');
	  	   	    $this->db->where('reservation_id',$reserve_id);
	  	   	    $this->db->update('refund',$updat);
	  	   	    exit;
	  	    }  	
	  	}
	  }
	}


	public function bulkpay($sid,$vid) {
	  $reserve_id = $sid;
	  $vendor_id  = $vid;

	  $getstaff  = $this->load->model('Staffs_model');

	  $getpayment = $this->Staffs_model->getStaff($vendor_id);
	  $payment = unserialize($getpayment['payment_details']);

	  if($payment['payment_api_mode']=='sandbox') {
	  	$urlprefix = 'sandbox';
	  } else {
	  	$urlprefix = 'www';
	  }
	  $baseurl    = "https://".$urlprefix.".2checkout.com/api/sales/refund_invoice";
	  $username   = $payment['payment_username'];
	  $password   = $payment['payment_password'];
	  $pp_payment = $this->Staffs_model->pp_payment('pp_payments',$reserve_id,'order_id');
	  $p_pay = unserialize($pp_payment[0]['serialized']);
	  $slid = $p_pay['order_number'];
	  $pp_refund = $this->Staffs_model->pp_payment('refund',$reserve_id,'reservation_id');
	  $data = array(
    	'sale_id' => $slid,
    	'category' => '10',
    	'comment' => 'Cancellation',
    	'amount' => $pp_refund[0]['refund_amount'],
    	'currency' => 'vendor'
	  );
  
	  $customer  = $this->Staffs_model->GetreserveCustomer($reserve_id);
	  $mail = $this->Reservations_model->reservemail($reserve_id,$this->currency->format($pp_refund[0]['refund_amount']));
	  
	  $cust_name = $customer->first_name.' '.$customer->last_name;
	  $telephone = $customer->telephone;
	  $retsuccess =  $this->doCall($baseurl,$data,$username,$password);
	  if($retsuccess) {
	  	$statuscheck = json_decode($retsuccess);
	  	if($statuscheck->errors[0]){
	  		if($statuscheck->errors[0]->message!='') {
	  		  echo $statuscheck->errors[0]->message;	
	  		} else {
	  		  echo $statuscheck['response_message'];
	  		}
	  		$updat = array(
	  	 	'response' => $retsuccess,
	  	 	'updated_at' => date('Y-m-d H:i:s')
	  	    );
	  	   $this->db->where('reservation_id',$reserve_id);
	  	   $this->db->update('refund',$updat);
	  	}
	  	else {
	  		 if(isset($statuscheck->response_code) && $statuscheck->response_code == 'OK'){
	  			$updat = array(
	  			'response' => $retsuccess,
	  			'type' => 'paid',
	  			'updated_at' => date('Y-m-d H:i:s')
	  			);
	  			$this->db->where('reservation_id',$reserve_id);
	  			$this->db->update('refund',$updat);

	  			$updat = array(
	  			'payment_status' => 'refunded',
	  			);
	  			$this->db->where('reservation_id',$reserve_id);
	  			$this->db->update('staffs_commission',$updat);	  			


	  			if($sms_status['ext_data']['status']=='1') {

	  			  $current_lang = $this->session->userdata('admin_lang');
        		  if(!$current_lang) { $current_lang = "english"; }
                  $sms_code = 'refund_'.$lang;
                  $sms_template = $this->Extensions_model->getTemplates($sms_code);
                  $message = $sms_template['body'];

                  $message = str_replace("{user}",$cust_name,$message);
                  $message = str_replace("{reserve}",$reserve_id,$message);
                  $message = str_replace("{refund}",$pp_refund[0]['refund_amount'],$message);
                  $message = str_replace("{date}",date('Y-m-d H:i:s'),$message);
                  if($telephone!='') {
                    $client_msg = $this->Twilio_model->Sendsms($telephone,$message);
                  }
                }	  			

	  		} else {
	  			if($statuscheck->errors[0]->message!=''){
	  		  	echo $statuscheck->errors[0]->message;	
	  			} else {
	  		  	echo $statuscheck->response_message;
	  			}
	  			$updat = array(
	  	 		'response' => $retsuccess,
	  	 		'updated_at' => date('Y-m-d H:i:s')
	  	    	);
	  	   	$this->db->where('reservation_id',$reserve_id);
	  	   	$this->db->update('refund',$updat);
	  	  }  	
	  	}
	  }
	}	

	private function _saveTable() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($table_id = $this->Refund_model->saveTable($this->input->get('id'), $this->input->post())) {
                log_activity($this->user->getStaffId(), $save_type, 'tables', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), $save_type, 'table', current_url(), $this->input->post('table_name'))
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Table '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $table_id;
		}
	}

	private function _deleteTable() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Refund_model->deleteTable($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Tables': 'Table';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('table_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('min_capacity', 'lang:label_min_capacity', 'xss_clean|trim|required|integer|greater_than[1]');
		$this->form_validation->set_rules('max_capacity', 'lang:label_capacity', 'xss_clean|trim|required|integer|greater_than[1]|callback__check_capacity');
		$this->form_validation->set_rules('table_status', 'lang:label_status', 'xss_clean|trim|required|integer');
		//$this->form_validation->set_rules('additional_charge', 'lang:label_additional_charge', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('total_price', 'lang:label_total_price', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _check_capacity($str) {
    	if ($str < $_POST['min_capacity']) {
			$this->form_validation->set_message('_check_capacity', $this->lang->line('error_capacity'));
			return FALSE;
		}

		return TRUE;
	}

	function doCall($baseurl, $data=array(),$username,$password)
    {
        $ch = curl_init($baseurl);  
        $header = array("Accept:application/json");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, "2Checkout PHP/0.1.0%s");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);

        if(curl_error($ch)!=''){
             $error_msg = curl_error($ch);
            return $error_msg;
            exit;
        }
        curl_close($ch);
        return $resp;
        exit;
    }


}

/* End of file tables.php */
/* Location: ./admin/controllers/tables.php */