<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Refund_report extends Admin_Controller {
	
	 public function __construct() {
		parent::__construct(); //  calls the constructor

       
        $this->user->restrict('Admin.Payments');

        $this->load->model('Settings_model'); // load the settings model
        $this->load->model('Payments_report_model'); // load the payments model
        $this->load->model('Tables_model');
        $this->load->model('Countries_model');
        $this->load->model('Extensions_model');
		$this->load->library('currency');
        $this->load->library('permalink');
        $this->load->library('pagination');

        $this->lang->load('refund_report');	
	}

		public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));   
   	
    	$type = 'refunded';
        $results = $this->Payments_report_model->getrefundstatus($type);
        
        foreach ($results as $result) {

            $data['reports'][] = array(
                'id'             => $result['id'],
                'reservation_id' => $result['reservation_id'],
                'total_amount'   => $result['total_amount'],
                'refund_amount'  => $result['refund_amount'],
                'payment_status' => $result['payment_status'],
                'customer_name'  => $result['first_name'].' '.$result['last_name'],                
                'email'          => $result['email'],
                'payment_status' => $result['payment_status'],
                'updated_at'     => $result['updated_at']
            );
        }         
        $this->template->render('refund_report', $data);
    }
    public function payments_report_detail(){
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));   

         $receipt_id = $this->input->get('receipt');

         $results = $this->Payments_report_model->getDetailList($receipt_id);

         foreach ($results as $result) {           

            $data['reports'][] = array(
                'id'             => $result['id'],
                'reservation_id' => $result['reservation_id'],
                'payment_date'   => $result['payment_date'],
                'receipt_no'     => $result['receipt_no'],
                'table_amount'   => $result['table_amount'],
                'table_tax'      => $result['table_tax']
                      
                
            );
         
        }         

        $this->template->render('payments_report_detail', $data);
    }
}