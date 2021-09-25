<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_twilio_module extends Admin_Controller {

	public function index($module = array()) {

		$this->lang->load('twilio_module/twilio_module');

		$this->user->restrict('Module.Twilio');

		$this->load->model('Statuses_model');
		$this->load->model('Twilio_model');

		$title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

		$this->template->setTitle('Module: ' . $title);
		$this->template->setHeading('Module: ' . $title);
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions'), 'title' => 'Back'));

		/*$this->template->setStyleTag(assets_url('js/summernote/summernote.css'), 'summernote-css');
		$this->template->setScriptTag(assets_url('js/summernote/summernote.min.js'), 'summernote-js');*/

		$ext_data = array();
		if ( ! empty($module['ext_data']) AND is_array($module['ext_data'])) {
			$ext_data = $module['ext_data'];
		}

		if (isset($this->input->post['title'])) {
			$data['title'] = $this->input->post('title');
		} else if (isset($ext_data['title'])) {
			$data['title'] = $ext_data['title'];
		} else {
			$data['title'] = $title;
		}

		if (isset($this->input->post['account_sid'])) {
			$data['account_sid'] = $this->input->post('account_sid');
		} else if (isset($ext_data['account_sid'])) {
			$data['account_sid'] = $ext_data['account_sid'];
		} else {
			$data['account_sid'] = '';
		}

		if (isset($this->input->post['api_version'])) {
			$data['api_version'] = $this->input->post('api_version');
		} else if (isset($ext_data['api_version'])) {
			$data['api_version'] = $ext_data['api_version'];
		} else {
			$data['api_version'] = '';
		}

		if (isset($this->input->post['auth_token'])) {
			$data['auth_token'] = $this->input->post('auth_token');
		} else if (isset($ext_data['auth_token'])) {
			$data['auth_token'] = $ext_data['auth_token'];
		} else {
			$data['auth_token'] = '';
		}

		if (isset($this->input->post['api_mode'])) {
			$data['api_mode'] = $this->input->post('api_mode');
		} else if (isset($ext_data['api_mode'])) {
			$data['api_mode'] = $ext_data['api_mode'];
		} else {
			$data['api_mode'] = '';
		}

		if (isset($ext_data['account_number'])) {
			$data['account_number'] = $ext_data['account_number'];
		} else {
			$data['account_number'] = '';
		}

		if (isset($this->input->post['status'])) {
			$data['status'] = $this->input->post('status');
		} else if (isset($ext_data['status'])) {
			$data['status'] = $ext_data['status'];
		} else {
			$data['status'] = '';
		}

		if ($this->input->post() AND $this->_updatetwiliomodule() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('extensions');
			}

			redirect('extensions/edit/module/twilio_module');

		}

		/***************SMS Content******************/

		$titles = array(
			'reservation_arabic'						=> $this->lang->line('text_reservation_arabic'),
			'reservation_update_arabic'	  				=> $this->lang->line('text_reservation_update_arabic'),
			'reservation_english'						=> $this->lang->line('text_reservation_english'),
			'reservation_update_english'	  			=> $this->lang->line('text_reservation_update_english'),
			'reservation_location_arabic'				=> $this->lang->line('text_reservation_location_arabic'),
			'reserve_update_location_arabic'	  	=> $this->lang->line('text_reservation_location_update_arabic'),
			'reservation_location_english'				=> $this->lang->line('text_reservation_location_english'),
			'reserve_update_location_english'	  	=> $this->lang->line('text_reservation_location_update_english'),
			'register_english'		=> $this->lang->line('text_register_english'),
			'register_arabic'	  	=> $this->lang->line('text_register_arabic'),
			'resend_english'		=> $this->lang->line('text_resend_english'),
			'resend_arabic'	  	=> $this->lang->line('text_resend_arabic'),

		);
		$data['template_data'] = array();
		$template_data = $this->Twilio_model->getTemplates();
		foreach ($titles as $key => $value) { 
			foreach ($template_data as $tpl_data) {
				if ($key === $tpl_data['code']) {
					$data['template_data'][] = array(
						'template_data_id' => $tpl_data['template_data_id'],
						'code'             => $tpl_data['code'],
						'title'            => $value,
						'body'             => html_entity_decode($tpl_data['body']),
						'date_added'       => mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_added'])),
						'date_updated'     => mdate('%d %M %y - %H:%i', strtotime($tpl_data['date_updated'])),
					);
				}
			}
		}
		/***************SMS Content******************/
		
		return $this->load->view('twilio_module/admin_twilio_module', $data, TRUE);
	}



	private function _saveTemplate() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($template_id = $this->Mail_templates_model->saveTemplate($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Mail Template '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $template_id;
		}
	}

	private function _updatetwiliomodule() {
		$this->user->restrict('Module.TwilioModule.Manage');

		if ($this->input->post() AND $this->validateForm() === TRUE) {
			$this->Twilio_model->updateTemplateData($this->input->post('templates'));
			if ($this->Extensions_model->updateExtension('module', 'twilio_module', $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title') . ' module ' . $this->lang->line('text_updated')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('title', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('account_sid', 'lang:label_account_sid', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_version', 'lang:label_api_version', 'xss_clean|trim|required');
		$this->form_validation->set_rules('auth_token', 'lang:label_auth_token', 'xss_clean|trim|required');
		$this->form_validation->set_rules('api_mode', 'lang:label_api_mode', 'xss_clean|trim|required');
		$this->form_validation->set_rules('account_number', 'lang:label_account_number', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');
		 if ($this->input->post('templates')) {
            foreach ($this->input->post('templates') as $key => $value) {
                $this->form_validation->set_rules('templates[' . $key . '][code]', 'lang:label_code', 'xss_clean|trim|required');
                $this->form_validation->set_rules('templates[' . $key . '][body]', 'lang:label_body', 'required|min_length[3]');
            }
        }


		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file twilio.php */
/* Location: ./extensions/paypal_express/controllers/paypal_express.php */