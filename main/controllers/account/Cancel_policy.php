<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cancel_Policy extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

		/*if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}*/
       								
        $this->load->model('Cancel_policy_model');												

        $this->lang->load('account/cancel_policy');
         $this->lang->load('default');
	}

	public function index() {

		$loc_id = $this->input->get('loc_id');
		$data = $this->Cancel_policy_model->getPolicy($loc_id);		
		/*echo '<pre>';
		print_r($data);*/
		$this->template->render('account/cancel_policy', $data);
	}
}

/* End of file cancel_policy.php */
/* Location: ./main/controllers/cancel_policy.php */