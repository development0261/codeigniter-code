<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Vippasscode extends Admin_Controller {

	public function __construct()
    {
        parent::__construct(); //  calls the constructor
        $this->user->restrict('Site.Stories');

        $this->load->model('Vippasscode_model');
        $this->load->model('Permissions_model');
        $this->load->model('Locations_model'); // load the locations model
        $this->load->library('pagination');
        $this->lang->load('stories');

    }

    public function index()
    {
        $storiesid = 0;
        $data['_action'] = site_url('vippasscode/index');
        $data['default_code'] = $this->Vippasscode_model->getPasscode();
        // echo "<pre>";print_r($data);exit();

        $title = (isset($stories_info['title'])) ? $stories_info['title'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf('VIP Pass code', $title));
        $this->template->setHeading(sprintf('VIP Pass code', $title));
        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('vippasscode'), 'title' => 'Back'));

        if ($this->input->post() and $storiesid = $this->_savePasscode()) {
            if ($this->input->post('save_close') === '1') {
                redirect('vippasscode');
            }

            redirect('vippasscode');
        }     
        
        $this->template->render('vippasscode_add_edit', $data);
    }

    private function _savePasscode()
    {
        if ($this->validateForm() === true) {            
            $save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

            $update['passcode']  = $this->input->post('passcode');
            $update['is_active'] = '1';

            if ($vippasscode_id = $this->Vippasscode_model->savePasscode(NULL, $update)) { // calls model to save data to SQL
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Vippasscode ' . $save_type));
           
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
            }

            return $vippasscode_id;
        }
    }

    private function validateForm()
    {
        $this->form_validation->set_rules('passcode', 'Code', 'xss_clean|trim|required|min_length[2]|max_length[100]');        
        if ($this->form_validation->run() === true) {
                return true;
            
        } else {
            return false;
        }
    }

}

/* End of file Vippasscode.php */
/* Location: ./admin/controllers/Vippasscode.php */