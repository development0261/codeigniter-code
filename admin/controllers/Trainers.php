<?php if (!defined('BASEPATH')) {
    exit('No direct access allowed');
}

// ini_set('display_errors','on');
// error_reporting(E_ALL);
class Trainers extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct(); //  calls the constructor
        $this->user->restrict('Site.Stories');

        $this->load->model('Trainers_model');
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
            $filter['sort_by'] = $data['sort_by'] = 'trainer_id';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') . ' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = '';
        }

        $this->template->setTitle('Trainers');
        $this->template->setHeading('Trainers');        
        $this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

        if ($this->input->post('delete') and $this->_deleteTrainers() === true) {
            redirect('trainers');
        }

        //load stories data into array
        $data['trainersRec'] = $this->Trainers_model->getList($filter);
        
        if ($this->input->get('sort_by') and $this->input->get('order_by')) {
            $url .= '&sort_by=' . $filter['sort_by'] . '&';
            $url .= '&order_by=' . $filter['order_by'] . '&';
        }

        $config['base_url'] = site_url('trainers' . $url);
        $config['total_rows'] = $this->Trainers_model->getCount($filter);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info' => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links(),
        );

        $this->template->render('trainers', $data);
    }

    /*
    * Add/Edit of posts
    */
    public function add_edit()
    {
        $trainers_info = array();
        $trainers_info_sql = $this->Trainers_model->getTrainers((int) $this->input->get('id'));

        if ($trainers_info_sql->num_rows() > 0) {
            $trainers_info = $trainers_info_sql->row_array();
            $trainerid = (int) $this->input->get('id');
            $data['_action'] = site_url('trainers/add_edit?id=' . $trainerid);
        } else {
            $trainersid = 0;
            $data['_action'] = site_url('trainers/add_edit');
        }
        
        $first_name = (isset($trainers_info['first_name'])) ? $trainers_info['first_name']: $this->lang->line('text_new');  
        $last_name  = (isset($trainers_info['last_name'])) ? $trainers_info['last_name'] : $this->lang->line('text_new');

        $this->template->setTitle(sprintf('Trainer : %s', $first_name.' '.$last_name));
        $this->template->setHeading(sprintf('Trainer : %s', $first_name.' '.$last_name));
        $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('trainers'), 'title' => 'Back'));

        if ($this->input->post() and $trainersid = $this->_saveTrainers()) {
            if ($this->input->post('save_close') === '1') {
                redirect('trainers');
            }

            redirect('trainers/add_edit?id=' . $storiesid);
        }

        if (isset($this->input->post['first_name'])) {
            $data['first_name'] = $this->input->post['first_name'];
        } else if (isset($trainers_info['first_name'])) {
            $data['first_name'] = $trainers_info['first_name'];
        } else {
            $data['first_name'] = '';
        }

        if (isset($this->input->post['last_name'])) {
            $data['last_name'] = $this->input->post['last_name'];
        } else if (isset($trainers_info['last_name'])) {
            $data['last_name'] = $trainers_info['last_name'];
        } else {
            $data['last_name'] = '';
        }

        if (isset($this->input->post['email'])) {
            $data['email'] = $this->input->post['email'];
        } else if (isset($trainers_info['email'])) {
            $data['email'] = $trainers_info['email'];
        } else {
            $data['email'] = '';
        }

        if (isset($this->input->post['telephone'])) {
            $data['telephone'] = $this->input->post['telephone'];
        } else if (isset($trainers_info['telephone'])) {
            $data['telephone'] = $trainers_info['telephone'];
        } else {
            $data['telephone'] = '';
        }
        
        if (isset($this->input->post['telephone'])) {
            $data['telephone'] = $this->input->post['telephone'];
        } else if (isset($trainers_info['telephone'])) {
            $data['telephone'] = $trainers_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if (isset($this->input->post['about_trainer'])) {
            $data['about_trainer'] = $this->input->post['about_trainer'];
        } else if (isset($trainers_info['about_trainer'])) {
            $data['about_trainer'] = $trainers_info['about_trainer'];
        } else {
            $data['about_trainer'] = '';
        }

        if (isset($this->input->post['trainer_short_info'])) {
            $data['trainer_short_info'] = $this->input->post['trainer_short_info'];
        } else if (isset($trainers_info['trainer_short_info'])) {
            $data['trainer_short_info'] = $trainers_info['trainer_short_info'];
        } else {
            $data['trainer_short_info'] = '';
        }

        if (isset($this->input->post['trainer_key_points'])) {
            $data['trainer_key_points'] = $this->input->post['trainer_key_points'];
        } else if (isset($trainers_info['trainer_key_points'])) {
            $data['trainer_key_points'] = $trainers_info['trainer_key_points'];
        } else {
            $data['trainer_key_points'] = '';
        }

        if (isset($this->input->post['instagram_link'])) {
            $data['instagram_link'] = $this->input->post['instagram_link'];
        } else if (isset($trainers_info['instagram_link'])) {
            $data['instagram_link'] = $trainers_info['instagram_link'];
        } else {
            $data['instagram_link'] = '';
        }

        if (isset($this->input->post['date_added'])) {
            $data['date_added'] = $this->input->post['date_added'];
        } else if (isset($trainers_info['date_added'])) {
            $data['date_added'] = $trainers_info['date_added'];
        } else {
            $data['date_added'] = '';
        }

        if (isset($this->input->post['status'])) {
            $data['status'] = $this->input->post['status'];
        } else if (isset($trainers_info['status'])) {
            $data['status'] = $trainers_info['status'];
        } else {
            $data['status'] = '';
        }
        
        $this->template->render('trainers_add_edit', $data);
    }
    /*
    * save trainers
    */
    private function _saveTrainers()
    {
        if ($this->validateForm() === true) {
            $save_type = 'updated';

            if ($trainer_id = $this->Trainers_model->saveTrainers($this->input->get('id'), $this->input->post())) { // calls model to save data to SQL
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'trainers ' . $save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
            }

            return $trainer_id;
        }
    }
    /*
    * Form validation
    */

    private function validateForm()
    {
        $this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');
        if ($this->form_validation->run() === true) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * Delete tyrainer 
    */

    private function _deleteTrainers()
    {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Trainers_model->deleteTrainers($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Trainers' : 'Trainer';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return true;
        }
    }


}

/* End of file stories.php */
/* Location: ./admin/controllers/stories.php */
