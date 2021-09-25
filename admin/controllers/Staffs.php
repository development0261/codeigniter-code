<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Staffs extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->load->model('Staffs_model');
        $this->load->model('Locations_model'); // load the locations model
        $this->load->model('Staff_groups_model');
        $this->load->model('Countries_model');

        $this->load->library('pagination');

        $this->lang->load('staffs');
    }

    public function vendor() {
    	return redirect('staffs/edit?id='.$this->user->getId());
    }
	public function index() {
        $this->user->restrict('Admin.Staffs');

        if($this->user->getStaffId() != 11){
        	return redirect('staffs/edit?id='.$this->user->getId());
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

		if ($this->input->get('filter_group')) {
			$filter['filter_group'] = $data['filter_group'] = $this->input->get('filter_group');
			$url .= 'filter_group='.$filter['filter_group'].'&';
		} else {
			$filter['filter_group'] = $data['filter_group'] = '';
		}

    	if (is_numeric($this->input->get('filter_location'))) {
			$filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else {
			$filter['filter_location'] = $data['filter_location'] = '';
		}

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
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
			$filter['sort_by'] = $data['sort_by'] = 'staffs.date_added';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		// $this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

		// if ($this->input->post('delete') AND $this->_deleteStaff() === TRUE) {
		// 	redirect('staffs');
		// }

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('staffs'.$url.'sort_by=staff_name&order_by='.$order_by);
		$data['sort_group']			= site_url('staffs'.$url.'sort_by=staff_group_name&order_by='.$order_by);
		$data['sort_location'] 		= site_url('staffs'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_date'] 			= site_url('staffs'.$url.'sort_by=date_added&order_by='.$order_by);
		$data['sort_id'] 			= site_url('staffs'.$url.'sort_by=staff_id&order_by='.$order_by);

		$data['staffs'] = array();
		$results = $this->Staffs_model->getList($filter);
		    
        
		foreach ($results as $result) {

			$location_name = '';
			$restaurant_by=null;
			if($result['staff_id'] != '11') {
				$staff_locations=$this->db->select('location_name')->get_where('locations',array('added_by'=>$result['staff_id']))->result_array();
				$restaurant_client=$this->db->select('location_name')->get_where('locations',array('restaurant_by'=>$result['staff_id']))->result_array();
				
				foreach ($staff_locations as $locations) {
					$location_name .= $locations['location_name'].',';
				}
				foreach ($restaurant_client as $restaurant) {
					$restaurant_by .= $restaurant['location_name'].',';
				}
			} 
			if($location_name != '') {
				$location_name = rtrim($location_name,',');
			} else {
				// $location_name = 'admin';
			}
			
			$data['staffs'][] = array(
				'staff_id' 				=> $result['staff_id'],
				'restaurant_by'			=>	$restaurant_by,
				'staff_name' 			=> $result['staff_name'],
				'staff_email' 			=> $result['staff_email'],
				'staff_telephone' 		=> $result['staff_telephone'],
				'staff_group_name' 		=> $result['staff_group_name'],
				'commission' 			=> $result['commission'],
				'delivery_commission' 	=> $result['delivery_commission'],
				// 'location_name' 		=> $result['location_name'],
				'location_name' 		=> $location_name,
				'date_added' 			=> day_elapsed($result['date_added']),
				'staff_status' 			=> ($result['staff_status'] === '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit' 					=> site_url('staffs/edit?id=' . $result['staff_id'])
			);
			
		}

		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'	=>	$result['staff_group_id'],
				'staff_group_name'	=>	$result['staff_group_name']
			);
		}
		 // $staff_location_id=$this->db->select('location_id')->get_where('locations',array('added_by'=>$staff_id))->result();

		//     print_r($this->db->last_query());
		//      print_r($staff_location_id);exit;

		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
				'restaurant_by'	=>	$result['restaurant_by'],
			);
		}

		$data['staff_dates'] = array();
		$staff_dates = $this->Staffs_model->getStaffDates();
		foreach ($staff_dates as $staff_date) {
			$month_year = $staff_date['year'].'-'.$staff_date['month'];
			$data['staff_dates'][$month_year] = mdate('%F %Y', strtotime($staff_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= '&sort_by='.$filter['sort_by'].'&';
			$url .= '&order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('staffs'.$url);
		$config['total_rows'] 		= $this->Staffs_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('staffs', $data);
	}

	public function edit() {
		$data['vendor'] = ""; 
        if ($this->user->getStaffId() !== $this->input->get('id')) {
            $this->user->restrict('Admin.Staffs');
        }

        if($this->user->getStaffId() != 11 && $this->input->get('id') != $this->user->getId()){
        	return redirect('staffs/edit?id='.$this->user->getId());
        }
        $str = file_get_contents('../assets/js/country_phone_code.json');

		$data['phone_code'] = json_decode($str);
        $staff_info = $this->Staffs_model->getStaff((int) $this->input->get('id'));

		if ($staff_info) {
			$staff_id = $staff_info['staff_id'];
			$data['_action']	= site_url('staffs/edit?id='. $staff_id);
		} else {
		    $staff_id = 0;
			$data['_action']	= site_url('staffs/edit');
		}

		$user_info = $this->Staffs_model->getStaffUser($staff_id);

		$title = (isset($staff_info['staff_name'])) ? $staff_info['staff_name'] : $this->lang->line('text_new');
		if($this->user->getStaffId() == 11){
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
    	}else{
    		$this->template->setTitle(sprintf($this->lang->line('vendor_edit_heading'), $title));
        	$this->template->setHeading(sprintf($this->lang->line('vendor_edit_heading'), $title));
    	}
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		if($this->user->getStaffId() == 11){
		if ($this->user->hasPermission('Admin.Staffs.Access')) {
			$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		}

		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('staffs'), 'title' => 'Back'));
		}
		
		if ($this->input->post() AND $staff_id = $this->_saveStaff($staff_info['staff_email'], $user_info['username'])) {
			if ($this->input->post('save_close') === '1') {
				redirect('staffs');
			}

			redirect('staffs/edit?id='. $staff_id);
		}

		$data['display_staff_group'] = TRUE;
        if ($this->user->hasPermission('Admin.StaffGroups.Manage')) {
            $data['display_staff_group'] = TRUE;
        }

        $staff_location_id=$this->db->select('location_id')->get_where('locations',array('added_by'=>$staff_id))->result();
		
		$restaurant_by=$this->db->select('location_id')->get_where('locations',array('restaurant_by'=>$staff_id))->result();
       // print_r($this->db->last_query());
       //  print_r($staff_location_id);exit;
	   
        $data['staff_name'] 		= $staff_info['staff_name'];
		$data['staff_email'] 		= $staff_info['staff_email'];
		$data['staff_telephone'] 	= explode('-',$staff_info['staff_telephone']);
		$data['staff_group_id'] 	= $staff_info['staff_group_id'];
		$data['staff_location_id'] 	=  $data['staff_group_id'] == '12' ? $restaurant_by: $staff_location_id;
		$data['commission'] 		= $staff_info['commission'];
		$data['delivery_commission']= $staff_info['delivery_commission'];
		$data['staff_status'] 		= $staff_info['staff_status'];
		$data['username'] 			= $user_info['username'];
		$data['payment_details'] 	= unserialize($staff_info['payment_details']);

		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'	=>	$result['staff_group_id'],
				'staff_group_name'	=>	$result['staff_group_name']
			);
		}
		//echo $data['staff_group_id'];
		//print_r ($data['staff_groups']); exit;
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		//echo '<pre/>';print_r($results);exit;
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}
		if($this->user->getStaffId() != 11){
			$data['vendor'] = "yes";
		}


		//$results = 
		//print_r($permission);exit;
		if($staff_info['staff_permissions'] != ""){
			$default_permission = "";
		}else{
			$staff_info['staff_permissions'] = $this->Staff_groups_model->getStaffGroupsPermissions();
			$default_permission = "yes";
		}
		//print_r($staff_info['staff_permissions']);exit;
		$data['default_permission'] = $default_permission;
		$data['permissions'] = unserialize($staff_info['staff_permissions']);
		
		// echo "<pre>";
		// print_r($data['permissions']);exit;
	
		if($default_permission == "yes"){
			foreach ($data['permissions'] as $key => $permission) {

				$data['permissions'][$key]['name'] = $this->Staff_groups_model->getPermissionName($key);

			}
		}
		$data['country_id'] = $this->config->item('country_id');
		
		$resul = $this->Countries_model->getCountry($data['country_id']);
		$data['default_country_code'] = $resul['iso_code_2'];
		
       /*foreach ($results as $domain => $permissions) {

            foreach ($permissions as $permission) {

                $data['permissions_list'][$domain][] = array(
                    'permission_id'     => $permission['permission_id'],
                    'name'              => $permission['name'],
                    'domain'            => $permission['domain'],
                    'controller'        => $permission['controller'],
                    'description'       => $permission['description'],
                    'action'            => $permission['action'],
                    'group_permissions' => (!empty($group_permissions[$permission['permission_id']])) ? $group_permissions[$permission['permission_id']] : array(),
                    'status'            => $permission['status']
                );
            }
		}*/
		$data['site_color']='';
		$data['logo']='';
		if($staff_id){
			$themeSql=$this->Staffs_model->getThemesBasedOnUsers($staff_id);
			if($themeSql->num_rows() >0){
				$resultTheme=$themeSql->row();
				$data['site_color']=$resultTheme->site_color;
				$data['logo']=$resultTheme->logo;
			}
		}
		$this->template->render('staffs_edit', $data);
	}

	public function autocomplete() {
		$json = array();

		if ($this->input->get('term')) {
			$filter['staff_name'] = $this->input->get('term');
			$filter['staff_id'] = $this->input->get('staff_id');

			$results = $this->Staffs_model->getAutoComplete($filter);
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = array(
						'id' 		=> $result['staff_id'],
						'text' 		=> utf8_encode($result['staff_name'])
					);
				}
			} else {
				$json['results'] = array('id' => '0', 'text' => $this->lang->line('text_no_match'));
			}
		}

		$this->output->set_output(json_encode($json));
	}

	private function _saveStaff($staff_email, $username) {
        if ($this->validateForm($staff_email, $username, $this->user->getStaffId()) === TRUE) {
    		// echo '<pre>';
    		// print_r($this->input->post('site_color'));
    		// print_r($_FILES);
    		// print_r($_SESSION);
    		// exit;
   			// $this->db->set('added_by', 11);
			// $this->db->where('added_by',$this->input->get('id'));
			// $loc = $this->db->update('locations');
    		
				// print_r($this->db->last_query());exit;
        	// echo $this->user->getStaffId();
        	// exit;
			
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
            $this->db->set('added_by', 11);
			$this->db->where('added_by','0');
			$query = $this->db->update('locations');

			$saves=	$this->input->post();
			//echo "<pre/>";print_r($saves);exit;

				$saves['staff_location_id']=$staf_loc['staff_location_id'][0];
			//print_r($saves);exit;

            if ($staff_id = $this->Staffs_model->saveStaff($this->input->get('id'),$saves)) {
            	
				$userType = $this->input->post('staff_group_id');
				if($this->input->get('id') != '') {
					//print_r($this->input->post('staff_location_id'));
					// echo $userType;
					// exit;
					if(count($this->input->post('staff_location_id')) > 0) {
						$list_ids = implode(',', $this->input->post('staff_location_id'));
						// exit;

						// $this->db->where('added_by!=', $this->input->get('id'));
						// $this->db->where('added_by!=',11);
						// $this->db->where_in('location_id', $list_ids, FALSE);					
						// $location=$this->db->get('locations')->num_rows();
						
						if($userType == '12'){
							$this->db->where('restaurant_by', $this->input->get('id'));
							$this->db->where('location_id!=', $this->input->post('staff_location_id')[0]);
						}else{
							$this->db->where('added_by!=', $this->input->get('id'));
						}
						$location=$this->db->get('locations')->num_rows();
						//echo $location;
						//exit;
						$this->db->where('added_by!=',11);
						$this->db->where_in('location_id', $list_ids, FALSE);
						
						if($location > 0 ) {
							$this->alert->set('warning', sprintf($this->lang->line('alert_error'), 'Restaurant name already added to another vendor'));
							return false;

						} else {
							
							$this->db->set('added_by', 11);
							$this->db->where('added_by',$this->input->get('id'));
							$loc = $this->db->update('locations');
							$loca_id = $this->input->post('staff_location_id');
							foreach ($loca_id as $key => $loc_id) {
								if($userType == '12'){
										$this->db->set('restaurant_by', $this->input->get('id'));
								}else{
									$this->db->set('added_by', $this->input->get('id'));
								}
								// $this->db->where('added_by!=','11');
								$this->db->where('location_id', $loc_id);	
								$loc = $this->db->update('locations');
							}
							
								// print_r($this->db->last_query());exit;
						}
					} else {
						$this->db->set('added_by', 11);
						$this->db->where('added_by',$this->input->get('id'));
						$loc = $this->db->update('locations');
					}
				} else {
					$list_ids = implode(',', $this->input->post('staff_location_id'));
					
					$this->db->where('added_by!=',11);
					$this->db->where_in('location_id', $list_ids, FALSE);					
					$location=$this->db->get('locations')->num_rows();
					

					if($location > 0) {
						$this->alert->set('warning', sprintf($this->lang->line('alert_error'), 'Restaurant name already added to another vendor'));
						return false;

					} else {
						// echo 'afkjhj';
						// exit;
						$this->db->set('added_by', 11);
						$this->db->where('added_by',$staff_id);
						$loc = $this->db->update('locations');
						
						$loca_id = $this->input->post('staff_location_id');
						foreach ($loca_id as $key => $loc_id) {
							// if($userType == '12'){
							// 	$this->db->set('restaurant_by', $staff_id);
							// }else{
								$this->db->set('added_by', $staff_id);
							// }
							
							// $this->db->where('added_by!=','11');
							$this->db->where('location_id', $loc_id);	
							$loc = $this->db->update('locations');
						}
						
							// print_r($this->db->last_query());exit;
					}
					
				}
                $action = ($this->input->get('id') === $this->user->getStaffId()) ? $save_type.' their' : $save_type;
                $message_lang = ($this->input->get('id') === $this->user->getStaffId()) ? 'activity_custom_no_link' : 'activity_custom';
                $item = ($this->input->get('id') === $this->user->getStaffId()) ? 'details' : $this->input->post('staff_name');

                log_activity($this->user->getStaffId(), $action, 'staffs', get_activity_message($message_lang,
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), $action, 'staff', current_url(), $item)
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Staff '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $staff_id;
		}
	}

	private function _deleteStaff() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Staffs_model->deleteStaff($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Staffs': 'Staff';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm($staff_email = FALSE, $username = FALSE, $staff_group_id) {

		if($staff_group_id == 11){
	
		$this->form_validation->set_rules('staff_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($staff_email !== $this->input->post('staff_email')) {
			$this->form_validation->set_rules('staff_email', 'lang:label_email', 'xss_clean|trim|required|max_length[96]|valid_email|is_unique[staffs.staff_email]');
		}

		if ($username !== $this->input->post('username')) {
			$this->form_validation->set_rules('username', 'lang:label_username', 'xss_clean|trim|required|is_unique[users.username]|min_length[2]|max_length[32]');
		}
		$this->form_validation->set_rules('telephone', 'lang:label_telephone', 'xss_clean|trim|required');
		$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|min_length[6]|max_length[32]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'lang:label_confirm_password', 'xss_clean|trim');

		if (!$this->input->get('id')) {
			$this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'lang:label_confirm_password', 'xss_clean|trim|required');
		}

		if ($this->user->hasPermission('Admin.StaffGroups.Manage')) {
			$this->form_validation->set_rules('staff_group_id', 'lang:label_group', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('staff_location_id[]', 'lang:label_location', 'xss_clean|trim|integer');
		}

		$this->form_validation->set_rules('staff_status', 'lang:label_status', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('site_color', 'lang:label_site_color', 'xss_clean|trim');
		$this->form_validation->set_rules('logo', 'lang:label_logo', 'callback_file_check');
		}
		
		/*$this->form_validation->set_rules('payment_username', 'lang:label_payment_username', 'xss_clean|trim|required');

		$this->form_validation->set_rules('payment_password', 'lang:label_payment_password', 'xss_clean|trim|required');

		$this->form_validation->set_rules('merchant_id', 'lang:label_merchant_id', 'xss_clean|trim|required');

		$this->form_validation->set_rules('payment_key', 'lang:label_payment_key', 'xss_clean|trim|required');*/

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function file_check(){
        $allowed_mime_type_arr = array('gif','jpeg','pjpeg','png','x-png','jpg');
         $mime =pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        
        if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){

                $config['upload_path']   = './views/themes/spotneat-blue/images/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']      = 500;
                $config['encrypt_name']  = true;
                $this->load->library('upload', $config);
                //upload file to directory
                if($this->upload->do_upload('logo')){
                    $uploadData = $this->upload->data();
                    $this->session->set_userdata('site_logoname','views/themes/spotneat-blue/images/'.$uploadData['file_name']);
                }else{
                    $this->form_validation->set_message('file_check', $this->upload->display_errors());
                    return false;
                }
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only jpg/png file.');
                return false;
            }
        }else{
            if(is_numeric($this->input->get('id'))){
                return true;
            }
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }
}

/* End of file staffs.php */
/* Location: ./admin/controllers/staffs.php */