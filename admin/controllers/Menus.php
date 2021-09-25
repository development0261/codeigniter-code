<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menus extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Menus');

		$this->load->model('Menus_model'); // load the menus model
		$this->load->model('Categories_model'); // load the categories model
		$this->load->model('Menu_options_model'); // load the menu options model
		$this->load->model('Mealtimes_model'); // load the mealtimes model
		$this->load->model('Locations_model'); // load the location model
		$this->load->library('pagination');
		$this->load->library('currency'); // load the currency library

		$this->lang->load('menus');
	}

	public function index() {

		$id = $this->input->get('id');
		$restaurant = $this->user->getRestaurant($this->user->getStaffId());
		// print_r($restaurant);
		// unset($_SESSION['location_id']);
		if(!$this->input->get('id') != "" && $this->user->getStaffId() == 11){
			return redirect('vendor/menus');
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
		$location_restaurant_id = '';
		if(isset($_SESSION['location_id']) && $_SESSION['location_id'] != '') {
	    	$_SESSION['location_id'] = $_SESSION['location_id'];
	    } else {
	    	$_SESSION['location_id'] = $restaurant[0]['location_id'];
	    }
	   
		if (isset($_SESSION['location_id']) && $_SESSION['location_id'] != '') {
			$filter['location_id'] = $_SESSION['location_id'];
		} else {
			$filter['location_id'] = '';
			$location_Info = $this->Locations_model->getRestaurantLocationDetails('location_email',$this->session->user_info['email']);
			if($location_Info['location_id']){
				$location_restaurant_id =$location_Info['location_id'];
			}
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search=' . $filter['filter_search'] . '&';
		} else {
			$data['filter_search'] = '';
		}

		if ($this->input->get('filter_category')) {
			$filter['filter_category'] = $data['category_id'] = (int) $this->input->get('filter_category');
			$url .= 'filter_category=' . $filter['filter_category'] . '&';
		} else {
			$data['category_id'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status=' . $filter['filter_status'] . '&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'menus.menu_id';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') . ' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC active';
		}
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		$data['filter_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
		$data['vendor_id'] = $id;

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/'.$edit_link));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteMenu() === TRUE) {
			redirect('menus');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] = site_url('menus' . $url . 'sort_by=menu_name&order_by=' . $order_by);
		$data['sort_price'] = site_url('menus' . $url . 'sort_by=menu_price&order_by=' . $order_by);
		$data['sort_stock'] = site_url('menus' . $url . 'sort_by=stock_qty&order_by=' . $order_by);
		$data['sort_id'] = site_url('menus' . $url . 'sort_by=menus.menu_id&order_by=' . $order_by);

		$this->load->model('Image_tool_model');

		$data['menus'] = array();

		if($data['vendor_id']!=""){
			$location_id = $this->Locations_model->getRestaurantLocationDetails('restaurant_by',$data['vendor_id']);
			$locId= '';
			if($location_id['location_id']){
				$locId =$location_id['location_id'];
			}
			$results = $this->Menus_model->getList($filter,$data['vendor_id'],$locId);
		}
		else{
			if($this->session->user_info['staff_group_id']=='12'){
				$results = $this->Menus_model->getList($filter,$location_restaurant_id ? $location_restaurant_id:$this->user->getStaffId());
			}else{
				$results = $this->Menus_model->getList($filter,$this->user->getStaffId());
			}
		}
		foreach ($results as $result) {

			$price = ($result['special_status'] === '1' AND $result['is_special'] === '1') ? $result['special_price'] : $result['menu_price'];

			$data['menus'][] = array(
				'menu_id'          => $result['menu_id'],
				'menu_name'        => $result['menu_name'],
				'menu_description' => $result['menu_description'],
				'menu_name_ar'        => $result['menu_name_ar'],
				'menu_description_ar' => $result['menu_description_ar'],
				'category_name'    => $result['name'],
				'menu_price'       => $this->currency->format($price),
				'menu_photo'       => $result['menu_photo'],
				'stock_qty'        => $result['stock_qty'],
				'special_status'   => $result['special_status'],
				'is_special'       => $result['is_special'],
				'menu_status'      => ($result['menu_status'] === '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit'             => site_url('menus/edit?id=' . $result['menu_id'].'&vendor_id='.$this->input->get('id')),
			);
		}

		//load category data into array
		$data['categories'] = array();
		$categories = $this->Categories_model->getCategories();
		foreach ($categories as $category) {
			$data['categories'][] = array(
				'category_id'   => $category['category_id'],
				'category_name' => $category['name'],
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= '&sort_by=' . $filter['sort_by'] . '&';
			$url .= '&order_by=' . $filter['order_by'] . '&';
		}

		$config['base_url'] = site_url('menus' .$url."id=".$this->input->get('id'));
		$config['total_rows'] = $this->Menus_model->getCount($filter,'',$data['vendor_id']);
		$config['per_page'] = $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'  => $this->pagination->create_infos(),
			'links' => $this->pagination->create_links(),
		);

		$this->template->render('menus', $data);
	}

	public function edit() {
		$menu_info = $this->Menus_model->getMenu((int) $this->input->get('id'));
		$menu_id = $this->input->get('id');
		if ($menu_info) {
			$vendor_id = $this->input->get('vendor_id');	
			// echo 'menu_variant_type_id='.$menu_variant_type_id;
			$data['_action'] = site_url('menus/edit?id='.$menu_id.'&vendor_id=' . $vendor_id);
		} else {
			// $menu_id = 0;
			$vendor_id = $this->input->get('vendor_id');
			//$menu_id = $this->input->get('vendor_id');
			$data['_action'] = site_url('menus/edit?vendor_id=' . $vendor_id);
		}
		$data['vendor_id'] = $vendor_id;		
		$data['menu_variant_type_id'] = !empty($this->input->get('menu_variant_type_id'))?$this->input->get('menu_variant_type_id'):'';		

		$title = (isset($menu_info['menu_name'])) ? $menu_info['menu_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('menus'), 'title' => 'Back'));

		$this->template->setStyleTag(assets_url('js/datepicker/datepicker.css'), 'datepicker-css');
		$this->template->setScriptTag(assets_url("js/datepicker/bootstrap-datepicker.js"), 'bootstrap-datepicker-js');
		// echo $menu_id;
		// 	exit;
		
		if ($this->input->post() AND $menu_id = $this->_saveMenu()) {
			// echo '<pre>';
			// print_r($this->input->post());
			// exit;
			if ($this->input->post('save_close') === '1') {
				redirect('menus?id='.$this->input->post('added_by'));
			}

			// redirect('menus/edit?id=' . $menu_id);
			redirect('menus/edit?id=' . $menu_id.'&vendor_id='.$this->input->get('vendor_id'));
		}

		if($this->input->get('vendor_id') != ""){
			$added_by = $this->input->get('vendor_id');
		}else if(!empty($menu_info['added_by'])){
			$added_by = $menu_info['added_by'];
		}else{
			$added_by =$this->user->getStaffId();
		}

		$this->load->model('Image_tool_model');
		if ($this->input->post('menu_photo')) {
			$data['menu_image'] = $this->input->post('menu_photo');
			$data['image_name'] = basename($this->input->post('menu_photo'));
			$data['menu_image_url'] = $this->Image_tool_model->resize($this->input->post('menu_photo'));
		} else if ( ! empty($menu_info['menu_photo'])) {
			$data['menu_image'] = $menu_info['menu_photo'];
			$data['image_name'] = basename($menu_info['menu_photo']);
			$data['menu_image_url'] = $this->Image_tool_model->resize($menu_info['menu_photo']);
		} else {
			$data['menu_image'] = '';
			$data['image_name'] = '';
			$data['menu_image_url'] = $this->Image_tool_model->resize('data/no_photo.png');
		}

		$data['added_by'] = $added_by;
		$data['menu_id'] = $menu_info['menu_id'];
		$data['location_id'] = $menu_info['location_id'];
		$data['menu_name'] = $menu_info['menu_name'];
		$data['menu_description'] = $menu_info['menu_description'];
		$data['menu_name_ar'] = $menu_info['menu_name_ar'];
		$data['menu_description_ar'] = $menu_info['menu_description_ar'];
		$data['menu_price'] = isset($menu_info['menu_price']) ? $menu_info['menu_price'] : '';
		$data['menu_type'] = $menu_info['menu_type'];
		$data['menu_category'] = $menu_info['category_id'];
		$data['stock_qty'] = $menu_info['stock_qty'];
		$data['minimum_qty'] = (isset($menu_info['minimum_qty'])) ? $menu_info['minimum_qty'] : '1';
		$data['subtract_stock'] = $menu_info['subtract_stock'];
		$data['special_id'] = $menu_info['special_id'];
		$data['start_date'] = (isset($menu_info['start_date']) AND $menu_info['start_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($menu_info['start_date'])) : '';
		$data['end_date'] = (isset($menu_info['end_date']) AND $menu_info['end_date'] !== '0000-00-00') ? mdate('%d-%m-%Y', strtotime($menu_info['end_date'])) : '';
		$data['special_price'] = (isset($menu_info['special_price']) AND $menu_info['special_price'] == '0.00') ? '' : $menu_info['special_price'];
		$data['special_status'] = ($this->input->post('special_status')) ? $this->input->post('special_status') : $menu_info['special_status'];
		$data['menu_status'] = isset($menu_info['menu_status']) ? $menu_info['menu_status'] : '1';
		$data['mealtime_id'] = $menu_info['mealtime_id'];
		$data['menu_priority'] = $menu_info['menu_priority'];
		$data['no_photo'] = $this->Image_tool_model->resize('data/no_photo.png');

		$data['categories'] = array();
		$results = $this->Categories_model->getCategories(NULL,$added_by);
		// echo $this->db->last_query();exit; // print_r($results);exit;
		if($this->input->get('vendor_id') !==""){
			if(empty($results)){
				$location_id = $this->Locations_model->getRestaurantLocationDetails('restaurant_by',$this->input->get('vendor_id'));
				if($location_id['location_id']){
					$results = $this->Categories_model->getCategories(NULL,$location_id['added_by']);
					
				}
			}
		}
		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id'   => $result['category_id'],
				'category_name' => $result['name'],
			);
		}

		$results = $this->Locations_model->getLocationWithVendors($added_by);
		if($this->input->get('vendor_id') !==""){
			if(empty($results)){
				$location_id = $this->Locations_model->getRestaurantLocationDetails('restaurant_by',$this->input->get('vendor_id'));
				if($location_id['location_id']){
					$results =array($location_id);

				}
			}
		}
		
		$data['locations'] = array();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'   => $result['location_id'],
				'location_name' => $result['location_name'],
			);
		}
		
		$data['mealtimes'] = array();
		$results = $this->Mealtimes_model->getMealtimes();
		foreach ($results as $result) {
			$start_time = mdate('%H:%i', strtotime($result['start_time']));
			$end_time = mdate('%H:%i', strtotime($result['end_time']));

			$data['mealtimes'][] = array(
				'mealtime_id'   => $result['mealtime_id'],
				'mealtime_name' => $result['mealtime_name'],
				'label' => "({$start_time} - {$end_time})",
			);
		}

		if ($this->input->post('menu_options')) {
			$menu_options = $this->input->post('menu_options');
		} else {
			$menu_options = $this->Menu_options_model->getMenuOptions($menu_id);
		}
		
		$data['menu_variants_types'] = array();
		$data['menu_variants'] = array();
		if ($this->input->post('menu_variants')) {
			$menu_variants = $this->input->post('menu_variants');
		} else {
			$menu_variants_types = $this->Menu_options_model->getVariantTypes($menu_id);			
			$menu_variants = $this->Menu_options_model->getMenuVariants($menu_id, $data['menu_variant_type_id']);

			$data['menu_variants_types'] = $menu_variants_types;
			$data['menu_variants'] = $menu_variants;
		}

		$data['menu_options'] = array();
		foreach ($menu_options as $option) {
			$option_values = array();
			foreach ($option['option_values'] as $value) {
				$option_values[] = array(
					'menu_option_value_id' => $value['menu_option_value_id'],
					'option_value_id'      => $value['option_value_id'],
					'price'                => (empty($value['new_price']) OR $value['new_price'] == '0.00') ? '' : $value['new_price'],
					'quantity'             => $value['quantity'],
					'subtract_stock'       => $value['subtract_stock'],
				);
			}

			$data['menu_options'][] = array(
				'menu_option_id'    => $option['menu_option_id'],
				'option_id'         => $option['option_id'],
				'option_name'       => $option['option_name'],
				'display_type'      => $option['display_type'],
				'required'          => $option['required'],
				'default_value_id'  => isset($option['default_value_id']) ? $option['default_value_id'] : 0,
				'priority'          => $option['priority'],
				'option_values'     => $option_values,
			);
		}

		$data['option_values'] = array();
		foreach ($menu_options as $option) {
			if ( ! isset($data['option_values'][$option['option_id']])) {
				$data['option_values'][$option['option_id']] = $this->Menu_options_model->getOptionValues($option['option_id']);
			}
		}
		$this->template->render('menus_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$filter = array(
				'menu_name' => $this->input->get('term'),
			);

			$results = $this->Menus_model->getAutoComplete($filter);
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id'   => $result['menu_id'],
						'text' => utf8_encode($result['menu_name']),
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}

		$this->output->set_output(json_encode($json));
	}

	private function _saveMenu() {
		// echo '<pre>';
		// print_r($_POST);
		// exit();
		if ($this->validateForm() === TRUE) {
			$save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($menu_id = $this->Menus_model->saveMenu($this->input->get('id'), $this->input->post())) {
				log_activity($this->user->getStaffId(), $save_type, 'menus', get_activity_message('activity_custom',
					array('{staff}', '{action}', '{context}', '{link}', '{item}'),
					array($this->user->getStaffName(), $save_type, 'menu item', site_url('menus/edit?id=' . $menu_id), $this->input->post('menu_name'))
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Menu ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}
			
			// redirect('menus/edit?id=' . $menu_id.'&vendor_id='.$this->input->get('vendor_id'));
			return $menu_id;
		}
	}

	private function _deleteMenu() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Menus_model->deleteMenu($this->input->post('delete'));

			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Menus' : 'Menu';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	public function delete_variant() {
		$menu_id 		 = $this->input->get('menu_id');
		$vendor_id 		 = $this->input->get('vendor_id');
		$location_id 	 = $this->input->get('location_id');
		$variant_type_id = $this->input->get('variant_type_id');
		$variant_type_value_id = $this->input->get('variant_type_value_id');
		
		$deleted_rows = $this->Menus_model->deleteVariant($variant_type_id, $variant_type_value_id);

		redirect('menus/edit?id=' . $menu_id.'&vendor_id='.$vendor_id."#menu-variants");
		
	}

	private function validateForm() {
		$this->form_validation->set_rules('menu_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('menu_description', 'lang:label_description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('menu_price', 'lang:label_price', 'xss_clean|trim|required|greater_than[0]');
		$this->form_validation->set_rules('menu_category', 'lang:label_category', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('menu_photo', 'lang:label_photo', 'xss_clean|trim');
		$this->form_validation->set_rules('stock_qty', 'lang:label_stock_qty', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('minimum_qty', 'lang:label_minimum_qty', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('location_id', 'lang:label_location', 'xss_clean|trim|required');
		$this->form_validation->set_rules('subtract_stock', 'lang:label_subtract_stock', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('menu_status', 'lang:label_status', 'xss_clean|trim|required|integer');
		//$this->form_validation->set_rules('mealtime_id', 'lang:label_mealtime', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('menu_priority', 'lang:label_menu_priority', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('special_status', 'lang:label_special_status', 'xss_clean|trim|required|integer');

		if ($this->input->post('menu_options')) {
			$mi_arr= array();
			// echo '<pre>';
			// print_r($this->input->post('menu_options'));
			// exit();
			foreach ($this->input->post('menu_options') as $key => $value) {
				// echo $key;
				$this->form_validation->set_rules('menu_options[' . $key . '][menu_option_id]', 'lang:label_option', 'xss_clean|trim|integer');
				$this->form_validation->set_rules('menu_options[' . $key . '][option_id]', 'lang:label_option_id', 'xss_clean|trim|required|integer');
				$this->form_validation->set_rules('menu_options[' . $key . '][option_name]', 'lang:label_option_name', 'xss_clean|trim|required');
				$this->form_validation->set_rules('menu_options[' . $key . '][display_type]', 'lang:label_option_display_type', 'xss_clean|trim|required');
				$this->form_validation->set_rules('menu_options[' . $key . '][default_value_id]', 'lang:label_default_value_id', 'xss_clean|trim|integer');
				$this->form_validation->set_rules('menu_options[' . $key . '][priority]', 'lang:label_option_id', 'xss_clean|trim|required|integer');
				$this->form_validation->set_rules('menu_options[' . $key . '][required]', 'lang:label_option_required', 'xss_clean|trim|required|integer');

				foreach ($value['option_values'] as $option => $option_value) {
					$mi_arr[$key][] = $option_value['option_value_id'];
					
					$this->form_validation->set_rules('menu_options[' . $key . '][option_values][' . $option . '][option_value_id]', 'lang:label_option_value', 'xss_clean|trim|required|integer');
					$this->form_validation->set_rules('menu_options[' . $key . '][option_values][' . $option . '][price]', 'lang:label_option_price', 'xss_clean|trim|numeric|required|greater_than[0]');
					// $this->form_validation->set_rules('menu_options[' . $key . '][option_values][' . $option . '][quantity]', 'lang:label_option_qty', 'xss_clean|trim|integer|required|greater_than[0]');
					$this->form_validation->set_rules('menu_options[' . $key . '][option_values][' . $option . '][subtract_stock]', 'lang:label_option_subtract_stock', 'xss_clean|trim|numeric');
					$this->form_validation->set_rules('menu_options[' . $key . '][option_values][' . $option . '][menu_option_value_id]', 'lang:label_option_value_id', 'xss_clean|trim|numeric');
				}
			}
			foreach ($mi_arr as $mi) {
				
				if(count($mi) > count(array_unique($mi))) {
				$this->alert->set('error', sprintf('You have selected same product option multiple times please remove.'));
				return false;	
			}
			}
			// exit;
			// print_r($mi_arr);
			// exit;
		}

		if ($this->input->post('special_status') === '1') {
			$this->form_validation->set_rules('start_date', 'lang:label_start_date', 'xss_clean|trim|required');
			$this->form_validation->set_rules('end_date', 'lang:label_end_date', 'xss_clean|trim|required');
			$this->form_validation->set_rules('special_price', 'lang:label_special_price', 'xss_clean|trim|required|numeric');
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function changelocation() {
		// print_r($_SESSION);
		$_SESSION['location_id'] = $_POST['id'];
		$return['msg'] = 'success';
		echo json_encode($return);
	}

	// 
	function addvariantvalue(){
		if ($this->validateFormVariant() === TRUE) {
			 $data =  $_POST;   
			 $this->Menus_model->addVariantValues($data);
			 $data['error_message'] = '' ; 
			 $data['error'] = 0;
			 echo json_encode($data);
			 exit();		  
	  }
	  else{
		  $data['error_message'] = validation_errors() ; 
		  $data['error'] = 1;		  
	  }    
	  echo json_encode($data);
	  exit();
  } 

  // Validate variant form
  private function validateFormVariant() {
	//print_r($_POST);
	$this->form_validation->set_rules('variant_value', 'Variant Value ', 'xss_clean|trim|required');
	$this->form_validation->set_rules('variant_price', 'Variant Price', 'xss_clean|trim|required');

	if ($this->form_validation->run() === TRUE) {
		return TRUE;
	} else {
		return FALSE;
	}
}

}

/* End of file menus.php */
/* Location: ./admin/controllers/menus.php */