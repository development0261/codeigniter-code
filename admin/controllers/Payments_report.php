<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Payments_report extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Payments');

        $this->load->model('Settings_model'); // load the settings model
        $this->load->model('Payments_report_model'); // load the payments model
        $this->load->model('Tables_model');
        $this->load->model('Countries_model');
        $this->load->model('Extensions_model');

        $this->load->library('permalink');
        $this->load->library('pagination');

        $this->lang->load('payments_report');
    }

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));   
         if($this->input->post()){
            $post = $this->input->post();
          
            $data = $this->Payments_report_model->updateCommission($post);
            header('Location: '.site_url().'payments_report');
         }

         $results = $this->Payments_report_model->getList();

         foreach ($results as $result) {           

            $data['reports'][] = array(
                'id'                    => $result['id'],
                'receipt_no'            => $result['receipt_no'],
                'total_booking_amount'  => $result['total_booking_amount'],
                'total_amount_received' => $result['total_amount_received'],
                'payment_date'          => $result['payment_date'],
                'description'           => $result['description'],                
                'no_of_orders'          => $result['no_of_orders']             
                
            );
         
        }         
         $this->template->render('payments_report', $data);

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
/* End of file Payments_report.php */
/* Location: ./admin/controllers/payments_report.php */