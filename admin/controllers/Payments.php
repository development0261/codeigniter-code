<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Payments extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Payments');

        $this->load->model('Settings_model'); // load the settings model
        $this->load->model('Payments_model'); // load the payments model
        $this->load->model('Tables_model');
        $this->load->model('Countries_model');
        $this->load->model('Extensions_model');

        $this->load->library('permalink');
        $this->load->library('pagination');

        $this->lang->load('payments');
    }

	public function index() {
      
       	$vendor_id = $this->user->getStaffId();

       	if($vendor_id == '11' || $vendor_id == ''){

		$lc_id = $this->input->post('lc_id');
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));      

        $data['payments'] = array();
        if($lc_id==''){
        	$results = $this->Payments_model->getList();   
        	foreach ($results as $result) {           

            $data['payments'][] = array(
				'id'					=> $result['id'],
				'staff_id'   			=> $result['staff_name'],
				'loc_id'				=> $result['location_id'],
				'location_id'			=> $result['location_name'],
				'reservation_id'		=> $result['reservation_id'],
				'percentage'			=> $result['percentage'],
				'total_amount'			=> round($result['total_amount'],2),
				'table_amount'			=> round($result['table_amount'],2),
				//'commission_amount'		=> round($result['com_total'],2),
				'date'					=> $result['date']				
				
			);
        }        
	    }else{
	    	$results = $this->Payments_model->getFullList($lc_id);  
	    	foreach ($results as $result) {           

            $data['payments'][] = array(
				'id'					=> $result['id'],
				'staff_id'   			=> $result['staff_name'],
				'loc_id'				=> $result['location_id'],
				'location_id'			=> $result['location_name'],
				'reservation_id'		=> $result['reservation_id'],
				'percentage'			=> $result['percentage'],
				'total_amount'			=> round($result['total_amount'],2),
				'table_amount'			=> round($result['table_amount'],2),
				//'commission_amount'		=> round($result['commission_amount'],2),
				'date'					=> $result['date']				
				
			);
        }     
	    }
           
       
	}
	else{

		$lc_id = $this->input->post('lc_id');
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));      

        $data['payments'] = array();
        if($lc_id==''){
        	$results = $this->Payments_model->getList($vendor_id);   
        	foreach ($results as $result) {           

            $data['payments'][] = array(
				'id'					=> $result['id'],
				'staff_id'   			=> $result['staff_name'],
				'loc_id'				=> $result['location_id'],
				'location_id'			=> $result['location_name'],
				'reservation_id'		=> $result['reservation_id'],
				'percentage'			=> $result['percentage'],
				'total_amount'			=> round($result['total_amount'],2),
				'table_amount'			=> round($result['table_amount'],2),
				//'vendor_commission_amount' => round($result['total_amount'],2) - round($result['com_total'],2),
				//'commission_amount'		=> round($result['com_total'],2),
				'date'					=> $result['date']				
				
			);
        }        
	    }else{
	    	$results = $this->Payments_model->getFullList($lc_id,$vendor_id);  
	    	foreach ($results as $result) {           

            $data['payments'][] = array(
				'id'					=> $result['id'],
				'staff_id'   			=> $result['staff_name'],
				'loc_id'				=> $result['location_id'],
				'location_id'			=> $result['location_name'],
				'reservation_id'		=> $result['reservation_id'],
				'percentage'			=> $result['percentage'],
				'total_amount'			=> round($result['total_amount'],2),
				'table_amount'			=> round($result['table_amount'],2),
				//'vendor_commission_amount' => round($result['total_amount'],2) - round($result['commission_amount'],2),
				//'commission_amount'		=> round($result['commission_amount'],2),
				'date'					=> $result['date']				
				
			);
        }     
	    }

	}

	if($lc_id!=''){
		$data['loc_id'] = $lc_id;
	}
		$data['vendor_id'] = $vendor_id;
        $this->template->render('payments', $data);
    }   
	
}

/* End of file Payments.php */
/* Location: ./admin/controllers/payments.php */