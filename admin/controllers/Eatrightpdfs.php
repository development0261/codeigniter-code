<?php if (!defined('BASEPATH')) {
    exit('No direct access allowed');
}

// ini_set('display_errors','on');
// error_reporting(E_ALL);
class Eatrightpdfs extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct(); //  calls the constructor
        $this->user->restrict('Site.Stories');

        $this->load->model('Eatrightpdfs_model');
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
            $filter['sort_by'] = $data['sort_by'] = 'eat_right_pdf_id';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') . ' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'DESC';
            $data['order_by_active'] = '';
        }

        $this->template->setTitle('Eat Right');
        $this->template->setHeading('Eat Right');
        $this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/add_edit'));

        //load stories data into array
        $data['eatrightpdfsSql'] = $this->Eatrightpdfs_model->getList($filter);        
        
        if ($this->input->get('sort_by') and $this->input->get('order_by')) {
            $url .= '&sort_by=' . $filter['sort_by'] . '&';
            $url .= '&order_by=' . $filter['order_by'] . '&';
        }

        $config['base_url'] = site_url('eatrightpdfs' . $url);
        $config['total_rows'] = $this->Eatrightpdfs_model->getCount($filter);
        $config['per_page'] = $filter['limit'];

        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info' => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links(),
        );

        $this->template->render('eatrightpdfs', $data);
    }

    public function add_edit()
    {       

        $storiesid = 0;
        $data['_action'] = site_url('eatrightpdfs/add_edit');        

        $title = (isset($stories_info['title'])) ? $stories_info['title'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf('Eatrightpdfs', $title));
        $this->template->setHeading(sprintf('Eatrightpdfs', $title));
        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('eatrightpdfs'), 'title' => 'Back'));

        if ($this->input->post() and $storiesid = $this->_saveEatrightpdfs()) {
            if ($this->input->post('save_close') === '1') {
                redirect('eatrightpdfs');
            }

            redirect('eatrightpdfs');
        }     
        
        $this->template->render('eatrightpdfs_add_edit', $data);
    }

    private function _saveEatrightpdfs()
    {
        if ($this->validateForm() === true) {            
            $save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

            $update['pdf_title'] = $this->input->post('pdf_title');
            $update['is_active'] = $this->input->post('is_active');
            // Upload PDF 
            if(!empty($_FILES['pdf_image_name']['tmp_name'])){
				$file_name  = pathinfo($_FILES['pdf_image_name']['name'], PATHINFO_FILENAME);
				$file_name  = preg_replace('/[^A-Za-z0-9\-]/', '-', $file_name).'-'.str_pad(rand(0, pow(10, 5)-1), 5, '0', STR_PAD_LEFT);
				
				$file_ext  = pathinfo($_FILES['pdf_image_name']['name'], PATHINFO_EXTENSION);
				$image_name= $file_name.'.'.$file_ext;

				$target_dir = '../admin/views/uploads/trainers/eat_right_pdf/'.$image_name;
				move_uploaded_file($_FILES['pdf_image_name']['tmp_name'], $target_dir);
				// Update Settings
				$update['pdf_image_name'] = $image_name;
			}

            if ($eat_right_pdf_id = $this->Eatrightpdfs_model->saveEatrightpdfs(NULL, $update)) { // calls model to save data to SQL
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Eatrightpdf ' . $save_type));
           
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
            }

            return $eat_right_pdf_id;
        }
    }

    private function validateForm()
    {
        $this->form_validation->set_rules('pdf_title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[100]');        
        if ($this->form_validation->run() === true) {
            if(!empty($_FILES['pdf_image_name']['tmp_name'])){
                return true;
            } else {
                return false;
            }
            
        } else {
            return false;
        }
    }

    public function makeinactive($eat_right_pdf_id = '') {
        $rec = $this->Eatrightpdfs_model->changeStatus($eat_right_pdf_id, '0');
        redirect('eatrightpdfs');       
	}

    public function makeactive($eat_right_pdf_id = '') {        
        $rec = $this->Eatrightpdfs_model->changeStatus($eat_right_pdf_id, '1');
        redirect('eatrightpdfs');       
	}
    
}

/* End of file stories.php */
/* Location: ./admin/controllers/stories.php */
