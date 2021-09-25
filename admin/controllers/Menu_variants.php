<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menu_variants extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.MenuOptions');

        $this->load->model('Menu_options_model'); // load the menus model

        $this->load->library('pagination');
        $this->load->library('currency'); // load the currency library

        $this->lang->load('menu_options');
	}

	public function index() {

		$id=$this->input->get('id');

		if(!$this->input->get('id') != "" && $this->user->getStaffId() == 11){
			return redirect('vendor/menu_options');
		}else if($this->input->get('id') != "" && $this->user->getStaffId() == 11){
			$edit_link = "edit?vendor_id=".$id;
		}
		else{
			$edit_link = "edit";

		}
		//ic($this->input)	

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

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}

		if ($this->input->get('filter_display_type')) {
			$filter['filter_display_type'] = $data['filter_display_type'] = $this->input->get('filter_display_type');
			$url .= 'filter_display_type='.$filter['filter_display_type'].'&';
		} else {
			$filter['filter_display_type'] = $data['filter_display_type'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'priority';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC';
		}

		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		$data['filter_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
		$data['vendor_id'] = $id;

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

        $this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/'.$edit_link));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteMenuOption() === TRUE) {
			redirect('menu_options');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('menu_options'.$url.'sort_by=option_name&order_by='.$order_by);
		$data['sort_priority'] 		= site_url('menu_options'.$url.'sort_by=priority&order_by='.$order_by);
		$data['sort_display_type'] 	= site_url('menu_options'.$url.'sort_by=display_type&order_by='.$order_by);
		$data['sort_id'] 			= site_url('menu_options'.$url.'sort_by=option_id&order_by='.$order_by);

		$data['menu_options'] = array();
		$results = $this->Menu_options_model->getList($filter,$id);
		foreach ($results as $result) {
			$data['menu_options'][] = array(
				'option_id' 	=> $result['option_id'],
				'option_name' 	=> $result['option_name'],
				'priority' 		=> $result['priority'],
				'display_type' 	=> ucwords($result['display_type']),
				'edit' 			=> site_url('menu_options/edit?id=' . $result['option_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= '&sort_by='.$filter['sort_by'].'&';
			$url .= '&order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('menu_options'.$url);
		$config['total_rows'] 		= $this->Menu_options_model->getCount($filter,$id);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('menu_options', $data);
	}

	public function edit() {

		$menu_id 		 = $this->input->get('menu_id');
		$vendor_id 		 = $this->input->get('vendor_id');
		$location_id 	 = $this->input->get('location_id');
		$variant_type_id = $this->input->get('variant_type_id');
		$variant_type_value_id = $this->input->get('variant_type_value_id');

		$option_info = $this->Menu_options_model->getEditVariants((int) $variant_type_id, (int) $variant_type_value_id);

		if(!empty($option_info)){
			$data['method'] = 'Edit';
		} else {
			$data['method'] = 'Add';
		}
		
		$title = (isset($option_info['variant_name'])) ? $option_info['variant_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf('Menu Variant', $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('menu_options'), 'title' => 'Back'));

		$this->template->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

		if($this->input->get('vendor_id') != ""){
			$added_by = $this->input->get('vendor_id');
		}else{
			$added_by = $option_info['added_by'];
		}

		if ($this->input->post() AND $option_id = $this->_saveVariant()){
			if ($this->input->post('save_close') === '1') {
				redirect('menus/edit/?id='.$menu_id.'&vendor_id='. $vendor_id);
			}	

			redirect('menus/edit?id='. $menu_id.'&vendor_id='. $vendor_id);
		}

		
		$data['added_by'] 				= $added_by;
		$data['menu_id'] 				= $menu_id;
		$data['vendor_id'] 				= $vendor_id;
		$data['location_id'] 			= $location_id;
		$data['variant_type_id'] 		= $variant_type_id;
		$data['variant_type_value_id'] 	= $variant_type_value_id;
		
		$data['values'] = array();
		foreach ($option_info as $value) {

			$data['variant_name'] 		= $value['variant_type_name'];
			$data['values'][] = array(
				'value'				=> $value['type_value_name'],
				'price'				=> $value['type_value_price'],
				'status'			=> $value['status'],
				'is_default'		=> $value['is_default']
			);
		}
		$this->template->render('menu_variants_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if($this->input->get('vendor_id') != ""){
			$added_by = $this->input->get('vendor_id');
		}else{
			$added_by = $this->user->getStaffId();
		}
		if ($this->input->get('term')) {
			$filter = array(
				'option_name' => $this->input->get('term'),
				'added_by' => $added_by
			);

			$results = $this->Menu_options_model->getAutoComplete($filter);
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 				=> $result['option_id'],
						'text' 				=> utf8_encode($result['option_name']),
						'display_type' 		=> utf8_encode($result['display_type']),
						'priority' 			=> $result['priority'],
						'option_values' 	=> $result['option_values']
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}

		$this->output->set_output(json_encode($json));
	}

	private function _saveVariant() {
    	if ($this->validateForm() === TRUE) {	
            $save_type = (! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
            
			if ($option_id = $this->Menu_options_model->saveVariant($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Variant updated'));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $option_id;
		}
	}

	private function _deleteMenuOption() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Menu_options_model->deleteOption($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Menu options': 'Menu option';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('variant_name', 'lang:label_option_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');		
		if ($this->input->post('variant_values')) {
			foreach ($this->input->post('variant_values') as $key => $value) {
				$this->form_validation->set_rules('variant_values['.$key.'][value]', 'lang:label_option_value', 'xss_clean|trim|required|min_length[2]|max_length[128]');				
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file menu_options.php */
/* Location: ./admin/controllers/menu_options.php */