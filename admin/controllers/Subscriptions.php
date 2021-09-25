<?php if (!defined('BASEPATH')) {
    exit('No direct access allowed');
}

 //ini_set('display_errors','on');
 //error_reporting(E_ALL);

class Subscriptions extends Admin_Controller
{

    public function __construct()
    {
         
        parent::__construct(); //  calls the constructor
        $this->user->restrict('Site.Stories');

        $this->load->model('Subscriptions_model');
        $this->load->library('pagination');
    }
    /*
    * Get list of posts
    */
    public function index()
    {
        
         
        // echo "<pre>";print_r($_SESSION);exit();
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

        if ($this->input->get('sort_by')) {
            $filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
        } else {
            $filter['sort_by'] = $data['sort_by'] = 'video_purchase_id';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') . ' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = '';
        }

        $this->template->setTitle('Subscriptions');
        $this->template->setHeading('Subscriptions');        
        //$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

        if ($this->input->post('delete') and $this->_deleteTrainers() === true) {
            redirect('subscriptions');
        }

        //load stories data into array
        $data['subscriptionsRec'] = $this->Subscriptions_model->getList($filter);
        // echo 'subscriptionsRec<pre>';
        // print_r($data['subscriptionsRec']);
        // exit;
        //print_r($data['subscriptionsRec']);
        
        if ($this->input->get('sort_by') and $this->input->get('order_by')) {
            $url .= '&sort_by=' . $filter['sort_by'] . '&';
            $url .= '&order_by=' . $filter['order_by'] . '&';
        }

        $config['base_url'] = site_url('subscriptions' . $url);
        $config['total_rows'] = $this->Subscriptions_model->getCount($filter);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info' => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links(),
        );

         

        $this->template->render('subscriptions', $data);
    }

    function updateWeek(){
        if(!empty($_POST['value'])){
            $data['subscription_payment_iteration'] =  $_POST['value']; 
            unset($data['video_purchase_id']) ;  
    
            $this->Subscriptions_model->updateWeek($_POST['video_purchase_id'],$data);
            $data['error_message'] = '' ; 
            $data['error'] = 0;
            echo json_encode($data);
        }
        
        exit();
    } 


  }