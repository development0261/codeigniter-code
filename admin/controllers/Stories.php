<?php if (!defined('BASEPATH')) {
    exit('No direct access allowed');
}

// ini_set('display_errors','on');
// error_reporting(E_ALL);
class Stories extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct(); //  calls the constructor
        $this->user->restrict('Site.Stories');

        $this->load->model('Stories_model');
        $this->load->model('Permissions_model');
        $this->load->model('Locations_model'); // load the locations model
        $this->load->library('pagination');
        $this->lang->load('stories');

    }

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
            $filter['sort_by'] = $data['sort_by'] = 'id';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') . ' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = '';
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/add_edit'));
        $this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

        if ($this->input->post('delete') and $this->_deleteStories() === true) {
            redirect('stories');
        }

        //load stories data into array
        if ($this->session->user_info['staff_group_id'] == 11) {
            $data['storiesSql'] = $this->Stories_model->getList($filter);
        } else if ($this->session->user_info['staff_group_id'] == 13) {
            $data['storiesSql'] = $this->Stories_model->getList($filter);
            $location_Info = $this->Locations_model->getRestaurantStaffsDetails('staff_email', $this->session->user_info['email']);
            $location_Ids = $this->Locations_model->getRestaurantsForFranchisee('added_by', $location_Info['staff_id']);
            $data['storiesSql'] = $this->Stories_model->getStoryBasedOnLocation($filter, $this->session->user_info['user_id'], $location_Ids);
        } else {
            $location_Info = $this->Locations_model->getRestaurantLocationDetails('location_email', $this->session->user_info['email']);
            $location_Ids = $this->Locations_model->getRestaurantsForFranchisee('added_by', $location_Info['added_by']);
            $data['storiesSql'] = $this->Stories_model->getStoryBasedOnLocation($filter, $this->session->user_info['user_id'], $location_Ids);
        }

        if ($this->input->get('sort_by') and $this->input->get('order_by')) {
            $url .= '&sort_by=' . $filter['sort_by'] . '&';
            $url .= '&order_by=' . $filter['order_by'] . '&';
        }

        $config['base_url'] = site_url('stories' . $url);
        $config['total_rows'] = $this->Stories_model->getCount($filter);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info' => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links(),
        );

        $this->template->render('stories', $data);
    }

    public function add_edit()
    {
        $stories_info_sql = $this->Stories_model->getStories((int) $this->input->get('id'));

        if ($stories_info_sql->num_rows() > 0) {
            $stories_info = $stories_info_sql->row_array();
            $storiesid = $stories_info['id'];
            $data['_action'] = site_url('stories/add_edit?id=' . $storiesid);
        } else {
            $storiesid = 0;
            $data['_action'] = site_url('stories/add_edit');
        }

        $title = (isset($stories_info['title'])) ? $stories_info['title'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('stories'), 'title' => 'Back'));

        if ($this->input->post() and $storiesid = $this->_saveStories()) {
            if ($this->input->post('save_close') === '1') {
                redirect('stories');
            }

            redirect('stories/add_edit?id=' . $storiesid);
        }

        if (isset($this->input->post['title'])) {
            $data['title'] = $this->input->post['title'];
        } else if (isset($stories_info['title'])) {
            $data['title'] = $stories_info['title'];
        } else {
            $data['title'] = '';
        }

        if (isset($this->input->post['content'])) {
            $data['content'] = $this->input->post['content'];
        } else if (isset($stories_info['content'])) {
            $data['content'] = $stories_info['content'];
        } else {
            $data['content'] = '';
        }

        if (isset($this->input->post['status'])) {
            $data['status'] = $this->input->post['status'];
        } else if (isset($stories_info['status'])) {
            $data['status'] = $stories_info['status'];
        } else {
            $data['status'] = '';
        }
        if (isset($_FILES['story_image'])) {
            $data['story_image'] = $_FILES['story_image'];
        } else if (isset($stories_info['story_image'])) {
            $data['story_image'] = $stories_info['story_image'];
        } else {
            $data['story_image'] = '';
        }
        if (isset($stories_info['added_by'])) {
            $data['story_added_by'] = $stories_info['added_by'];
        } else {
            $data['story_added_by'] = '';
        }

        $data['display_story_settings'] = false;
        if ($this->user->hasPermission('Site.Stories.Manage')) {
            $data['display_story_settings'] = true;
        }
        $data['story_location_id'] = $this->Stories_model->getStoryLocation($storiesid);
        // echo $this->user->getStaffId();exit();
        if ($this->session->user_info['user_id'] == 11) {
            $results = $this->Locations_model->getLocations();
        } else {
            $locationID =$this->user->getStaffId();
            $location_Info = $this->Locations_model->getRestaurantLocationDetails('restaurant_by', $this->user->getStaffId());
            if($location_Info['added_by'])  $locationID = $location_Info['added_by'];
            $results = $this->Locations_model->getRestaurant($locationID);
        }

        // echo "<pre>";print_r($_SESSION);exit();  // echo  $this->db->last_query();

        $location_option = array('0' => '--please select--');
        if (count($results)) {
            foreach ($results as $result) {
                $location_option[$result['location_id']] = $result['location_name'];
            }
        }
        $data['locations'] = $location_option;
        $this->template->render('stories_add_edit', $data);
    }

    private function _saveStories()
    {

        if ($this->validateForm() === true) {
            $save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

            if ($staff_group_id = $this->Stories_model->saveStories($this->input->get('id'), $this->input->post())) { // calls model to save data to SQL
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Stories ' . $save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
            }

            return $staff_group_id;
        }
    }

    private function _deleteStories()
    {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Stories_model->deleteStories($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Stories' : 'Story';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return true;
        }
    }

    private function validateForm()
    {
        $this->form_validation->set_rules('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[42]');
        $this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');
        $this->form_validation->set_rules('content', 'lang:label_story_content', 'xss_clean|trim|required');
        $this->form_validation->set_rules('story_image', 'lang:label_stories_images', 'callback_file_check');

        if ($this->form_validation->run() === true) {
            return true;
        } else {
            return false;
        }
    }

    public function file_check()
    {
        $allowed_mime_type_arr = array('gif', 'jpeg', 'pjpeg', 'png', 'x-png', 'jpg');
        $mime = pathinfo($_FILES["story_image"]["name"], PATHINFO_EXTENSION);

        if (isset($_FILES['story_image']['name']) && $_FILES['story_image']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {

                $config['upload_path'] = './views/themes/spotneat-blue/images/stories/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 1024;
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                //upload file to directory
                if ($this->upload->do_upload('story_image')) {
                    $uploadData = $this->upload->data();
                    $this->session->set_userdata('storyImageName', '/views/themes/spotneat-blue/images/stories/' . $uploadData['file_name']);
                } else {
                    $this->form_validation->set_message('file_check', $this->upload->display_errors());
                    return false;
                }
                return true;
            } else {
                $this->form_validation->set_message('file_check', 'Please select only gif/jpg/png file.');
                return false;
            }
        } else {
            if (is_numeric($this->input->get('id'))) {
                return true;
            }
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }

}

/* End of file stories.php */
/* Location: ./admin/controllers/stories.php */
