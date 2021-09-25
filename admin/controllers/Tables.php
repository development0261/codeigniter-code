<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Tables extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Tables');

        $this->load->model('Tables_model');

        $this->load->model('Locations_model');

        $this->load->library('pagination');

        $this->lang->load('tables');
	}

	public function index() {
		$id = $this->input->get('id');
		if(!$this->input->get('id') != "" && $this->user->getStaffId() == 11){
			return redirect('vendor/tables');
		}else if($this->input->get('id') != "" && $this->user->getStaffId() == 11){
			$edit_link = "edit?vendor_id=".$id;
		}else{
			$edit_link = "edit";
		}
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

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'table_id';
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

		if ($this->input->post('delete') AND $this->_deleteTable() === TRUE) {
			redirect('tables');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('tables'.$url.'sort_by=table_name&order_by='.$order_by);
		$data['sort_min'] 			= site_url('tables'.$url.'sort_by=min_capacity&order_by='.$order_by);
		$data['sort_cap'] 			= site_url('tables'.$url.'sort_by=max_capacity&order_by='.$order_by);
		$data['sort_id'] 			= site_url('tables'.$url.'sort_by=table_id&order_by='.$order_by);

		$data['tables'] = array();

		if($data['vendor_id']!=""){
			$results = $this->Tables_model->getList($filter,$data['vendor_id']);
		}
		else{
			$results = $this->Tables_model->getList($filter,$this->user->getStaffId());
		}	
		foreach ($results as $result) {
			$data['tables'][] = array(
				'table_id'			=> $result['table_id'],
				'table_name'		=> $result['table_name'],
				'min_capacity'		=> $result['min_capacity'],
				'max_capacity'		=> $result['max_capacity'],
				'table_status'		=> ($result['table_status'] == '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit'             => site_url('tables/edit?id=' . $result['table_id'].'&vendor_id='.$this->input->get('id')),
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= '&sort_by='.$filter['sort_by'].'&';
			$url .= '&order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('tables'.$url."id=".$this->input->get('id'));
		$config['total_rows'] 		= $this->Tables_model->getCount($filter,'',$data['vendor_id']);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('tables', $data);
	}

	public function edit() {
		$table_info = $this->Tables_model->getTable((int) $this->input->get('id'));

		if ($table_info) {
			$table_id = $table_info['table_id'];
			$data['_action']	= site_url('tables/edit?id='. $table_id);
		} else {
		    $table_id = 0;
			$data['_action']	= site_url('tables/edit');
		}

		if($this->input->get('vendor_id') != ""){
			$data['added_by'] = $this->input->get('vendor_id');
		}else if(!empty($menu_info['added_by'])){
			$data['added_by'] = $menu_info['added_by'];
		}else{
			$data['added_by'] = $this->user->getStaffId();
		}

		$title = (isset($table_info['table_name'])) ? $table_info['table_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('tables'), 'title' => 'Back'));

		if ($this->input->post() AND $table_id = $this->_saveTable()) {
			if ($this->input->post('save_close') === '1') {
				redirect('tables');
			}

			redirect('tables/edit?id='. $table_id .'&vendor_id='.$this->input->post('added_by'));
		}

		$data['table_id'] 			= $table_info['table_id'];
		$data['table_name'] 		= $table_info['table_name'];
		$data['min_capacity'] 		= $table_info['min_capacity'];
		$data['max_capacity'] 		= $table_info['max_capacity'];
		$data['table_status'] 		= $table_info['table_status'];
		$data['additional_charge'] 	= $table_info['additional_charge'];
		$data['total_price'] 		= $table_info['total_price'];
		
		$data['locations'] = array();
		$results = $this->Locations_model->getLocationWithVendorId($data['added_by'],$this->input->get('loc_id'));
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'   => $result['location_id'],
				'location_name' => $result['location_name'],
			);
		}

		$this->template->render('tables_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		//if ($this->input->get('term')) {
			$filter = array(
				'table_name' => $this->input->get('term'),
				'loc_id' => $this->input->get('loc_id')
			);

			$results = $this->Tables_model->getAutoComplete($filter);

			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 		=> $result['table_id'],
						'text' 		=> utf8_encode($result['table_name']),
						'min' 		=> $result['min_capacity'],
						'max' 		=> $result['max_capacity']
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		//}

		$this->output->set_output(json_encode($json));
	}

	private function _saveTable() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($table_id = $this->Tables_model->saveTable($this->input->get('id'), $this->input->post())) {
                log_activity($this->user->getStaffId(), $save_type, 'tables', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), $save_type, 'table', current_url(), $this->input->post('table_name'))
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Table '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $table_id;
		}
	}

	private function _deleteTable() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Tables_model->deleteTable($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Tables': 'Table';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('table_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('min_capacity', 'lang:label_min_capacity', 'xss_clean|trim|required|integer|greater_than[1]');
		$this->form_validation->set_rules('max_capacity', 'lang:label_capacity', 'xss_clean|trim|required|integer|greater_than[1]|callback__check_capacity');
		$this->form_validation->set_rules('table_status', 'lang:label_status', 'xss_clean|trim|required|integer');
		//$this->form_validation->set_rules('additional_charge', 'lang:label_additional_charge', 'xss_clean|trim|required|integer');
		//$this->form_validation->set_rules('total_price', 'lang:label_total_price', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _check_capacity($str) {
    	if ($str < $_POST['min_capacity']) {
			$this->form_validation->set_message('_check_capacity', $this->lang->line('error_capacity'));
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file tables.php */
/* Location: ./admin/controllers/tables.php */