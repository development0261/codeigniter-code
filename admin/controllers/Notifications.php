<?php if (!defined('BASEPATH')) {
    exit('No direct access allowed');
}

// ini_set('display_errors','on');
// error_reporting(E_ALL);
class Notifications extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct(); //  calls the constructor
        $this->user->restrict('Site.Stories');

        $this->load->model('Notifications_model');
        $this->load->model('Permissions_model');
        $this->load->model('Locations_model'); // load the locations model
        $this->load->library('pagination');
        $this->lang->load('stories');

    }

    public function index() {
        
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
            $filter['sort_by'] = $data['sort_by'] = 'schedule_notification_id';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') . ' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = '';
        }

        $this->template->setTitle('Push');
        $this->template->setHeading('Push Notification');
        $this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/add_edit'));
        //$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

        if ($this->input->post('delete') and $this->_deleteStories() === true) {
            redirect('notifications');
        }

        //load stories data into array
        $data['notificationsSql'] = $this->Notifications_model->getList($filter);        
        
        if ($this->input->get('sort_by') and $this->input->get('order_by')) {
            $url .= '&sort_by=' . $filter['sort_by'] . '&';
            $url .= '&order_by=' . $filter['order_by'] . '&';
        }

        $config['base_url'] = site_url('notifications' . $url);
        $config['total_rows'] = $this->Notifications_model->getCount($filter);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info' => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links(),
        );

        $this->template->render('notifications', $data);
    }

    public function add_edit()
    {    
      
        $storiesid = 0;
        $data['_action'] = site_url('notifications/add_edit');        

        $title = (isset($stories_info['title'])) ? $stories_info['title'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf('Notifications', $title));
        $this->template->setHeading(sprintf('Notifications', $title));
        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('notifications'), 'title' => 'Back'));

        if ($this->input->post() and $storiesid = $this->_saveNotifications()) {
            if ($this->input->post('save_close') === '1') {
                redirect('notifications');
            }

            redirect('notifications');
        }
        //load stories data into array
        $data['timeZoneList'] = $this->Notifications_model->geTimeZonetList();        
        $data['locationList'] = $this->Notifications_model->getLocationList();        
        
        $this->template->render('notifications_add_edit', $data);
    }

    private function _saveNotifications()
    {
        if ($this->validateForm() === true) {
            $save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
            if ($schedule_notification_id = $this->Notifications_model->saveNotifications(NULL, $this->input->post())) { // calls model to save data to SQL
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Notification ' . $save_type));

                // Send push notification
                if(!empty($this->input->post('schedule_type')) && $this->input->post('schedule_type') == 'NOW'){
                    $this->send_schedule_notifications($schedule_notification_id, $this->input->post());                
                }                
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
            }

            return $schedule_notification_id;
        }
    }

    private function validateForm()
    {
        $this->form_validation->set_rules('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('message', 'lang:label_story_content', 'xss_clean|trim|required');

        if ($this->form_validation->run() === true) {
            return true;
        } else {
            return false;
        }
    }

    // Send push notificartion
    function send_schedule_notifications($schedule_notification_id = '', $post_data = array()){
        // $now = date('Y-m-d H:i:s');

        $now = date('Y-m-d H:i');
        $condition_array = array(
                                    'schedule_notification_id='=>$schedule_notification_id,
                                    "DATE_FORMAT(schedule_date ,'%Y-%m-%d %H:%i')<="=>$now,
                                    'sent'=>'No'
                                );        
        $get_notification_info = $this->Notifications_model->notificationData($condition_array);
        
        // Send message to users 
        if(!empty($get_notification_info)){
            foreach ($get_notification_info as $keyn => $notice) {
                $array = array('sent'=>'Inprocess') ;
                $this->Notifications_model->update($notice->schedule_notification_id,$array);

                $post = array();  
                                
                $post['message'] = $notice->message; 
                $post['title'] = $notice->title; 
                $post['page_url'] = $notice->page_url;
                $post['web_url'] = $notice->web_url;
                $post['schedule_notification_id'] = $notice->schedule_notification_id;
                $scheduleType = $notice->schedule_type; //gradweek or default                               

                $all_devices =$this->Notifications_model->getDeviceInfo(trim($notice->sent_to),$notice->locationIds); 
                
                $token_array  = array();
                $deviceInfo_array  = array();

                // foreach ($all_devices as $key => $value) {
                //     $deviceInfo_array[] = $value['deviceid']; 
                // }

                $this->load->library('Push_Notification');    
                $push_notification = new Push_Notification;
                
                $result = $push_notification->sendPushNotification($post['message'],$post['title'],$post['web_url'],$post['schedule_notification_id'],$all_devices, $post['page_url']);

                $result_array = json_decode($result) ;
                if($result_array->success>=1){
                    $array = array('sent'=>'Yes') ;
                }else{
                    $array = array('sent'=>'No') ;
                }
                //Now update the notification status
                $get_notification_info = $this->Notifications_model->update($notice->schedule_notification_id,$array);
            }    
        }
}
}

/* End of file stories.php */
/* Location: ./admin/controllers/stories.php */
