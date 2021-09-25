<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');
require __DIR__.'/../../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class Delivery_online extends Admin_Controller {

	public function __construct() {
		parent::__construct();

        $this->user->restrict('Admin.DeliveryOnline');

        $this->load->model('Delivery_online_model');
        $this->load->model('Delivery_model');

        $this->load->library('pagination');

        $this->lang->load('delivery_online');
	}

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_option'), array('class' => 'btn btn-default pull-right', 'href' => site_url('settings#system')));

        $filter = array();
        $online_time_out = ($this->config->item('delivery_online_time_out') > 120) ? $this->config->item('delivery_online_time_out') : 120;
        $filter['time_out'] = mdate('%Y-%m-%d %H:%i:%s', time() - $online_time_out);
        $filter['filter_type'] = $data['filter_type'] = 'online';

        $data = $this->getList($data, $filter);

		$this->template->render('delivery_online', $data);
	}

	

    private function getList($data, $filter) {
        $url = '?';
        if ($this->input->get('page')) {
            $filter['page'] = (int) $this->input->get('page');
        } else {
            $filter['page'] = 1;
        }

        if ($this->config->item('page_limit')) {
            $filter['limit'] = $this->config->item('page_limit');
        } else {
            $filter['limit'] = '';
        }

        $getStaffId = $this->user->getStaffId();

        $url = BASEPATH.'/../firebase.json';         
        $project_id = json_decode(file_get_contents($url));
        $db = 'https://'.$project_id->project_id.'.firebaseio.com/';
        $serviceAccount = ServiceAccount::fromJsonFile($url);
        $firebase = (new Factory)
                    ->withServiceAccount($serviceAccount)
                    ->withDatabaseUri($db)
                    ->create();
        $database = $firebase->getDatabase();

        

        if($getStaffId==11){

            $delivery_boy = $this->Delivery_model->getDelivery();

            foreach ($delivery_boy as $delivery) {  
                $stat_upd = $database->getReference('delivery_partners'.'/'.$delivery['delivery_id']);
                $stat_up = $stat_upd->getValue('status');
                
                if($stat_up['status']!=0){
                    $deliver =  $this->Delivery_model->getDeliveries($stat_up['delivery_id']);
                    
                    $data['delivery_boy'][] = array(
                        'delivery_id'   => $deliver['delivery_id'],
                        'first_name'    => $deliver['first_name'],
                        'last_name' => $deliver['last_name'],
                        'email' => $deliver['email'],
                        'telephone' => $deliver['telephone']
                    );
                }
            }            
        }else{
            $delivery_boy = $this->Delivery_model->getDelivery1($getStaffId);
            foreach ($delivery_boy as $delivery) {  
                $stat_upd = $database->getReference('delivery_partners'.'/'.$delivery['delivery_id']);
                $stat_up = $stat_upd->getValue('status');
                $stat_up1 = $stat_upd->getValue('added_by');
                
                if($stat_up['status']!=0 && $stat_up1['added_by'] == $getStaffId){
                    $deliver =  $this->Delivery_model->getDeliveries($stat_up['delivery_id']);
                    
                    $data['delivery_boy'][] = array(
                        'delivery_id'   => $deliver['delivery_id'],
                        'first_name'    => $deliver['first_name'],
                        'last_name' => $deliver['last_name'],
                        'email' => $deliver['email'],
                        'telephone' => $deliver['telephone']
                    );
                }
            }            
        }
         $delivery_online = $data['delivery_boy'];
        //$delivery_online = $this->Delivery_online_model->getDeliveryOnlin($getStaffId);

        $data['delivery_online'] = array();
        foreach ($delivery_online as $online) {
           
            $data['delivery_online'][] = array(
                'delivery_id' => $online['delivery_id'],
                'delivery_name' => $online['first_name'].' '.$online['last_name'],
                'email' => $online['email'],
                'telephone' => $online['telephone']
                
            );
        }
       
        $config['base_url'] = page_url() . $url;
        $config['total_rows'] = $this->Delivery_online_model->getDeliveryCount($getStaffId);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info'  => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links()
        );

        return $data;
    }
}

/* End of file delivery_online.php */
/* Location: ./admin/controllers/delivery_online.php */