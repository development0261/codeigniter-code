<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reservation extends Main_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->load->model('Reservations_model');
        $this->load->model('Pages_model');

		$this->lang->load('reservation');

		if ($this->config->item('reservation_mode') !== '1') {
			$this->alert->set('alert', $this->lang->line('alert_reservation_disabled'));
			redirect('home');
		}
	}

	public function index() {
		$prepend = '?redirect=' . current_url();

        if ($this->input->post() AND $this->_reserveTable() === TRUE) {
            redirect('reservation/success');
        }

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'reservation');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['text_login_register']		= ($this->customer->isLogged()) ? sprintf($this->lang->line('text_logout'), $this->customer->getName(), site_url('account/logout'.$prepend)) : sprintf($this->lang->line('text_login'), site_url('account/login'.$prepend));

		$data['reset_url'] 			        = site_url('reservation');

		if ($this->input->post('first_name')) {
			$data['first_name'] = $this->input->post('first_name');
		} else if ($this->customer->getFirstName()) {
			$data['first_name'] = $this->customer->getFirstName(); 								// retrieve customer first name from customer library
		} else {
			$data['first_name'] = '';
		}

		if ($this->input->post('last_name')) {
			$data['last_name'] = $this->input->post('last_name');
		} else if ($this->customer->getLastName()) {
			$data['last_name'] = $this->customer->getLastName(); 								// retrieve customer last name from customer library
		} else {
			$data['last_name'] = '';
		}

		if ($this->input->post('email')) {
			$data['email'] = $this->input->post('email');
		} else if ($this->customer->getEmail()) {
			$data['email'] = $this->customer->getEmail(); 										// retrieve customer email address from customer library
		} else {
			$data['email'] = '';
		}

		if ($this->input->post('telephone')) {
			$data['telephone'] = $this->input->post('telephone');
		} else if ($this->customer->getTelephone()) {
			$data['telephone'] = $this->customer->getTelephone(); 								// retrieve customer telephone from customer library
		} else {
			$data['telephone'] = '';
		}

		if ($this->input->post('comment')) {
			$data['comment'] = $this->input->post('comment');
		} else {
			$data['comment'] = '';
		}

		$item = $this->Locations_model->getLocation($this->input->post('location'));
		    
           
            $data['location_id'] = $item['location_id'];
            $data['location_name'] = $item['location_name'];
            $data['location_name_ar'] = $item['location_name_ar'];
            $data['location_email'] = $item['location_email'];
            $data['location_type'] = $location_type;
            $data['overall_rating'] = "10";
            $data['description'] = $item['description'];
            $data['description_ar'] = $item['description_ar'];
            $data['location_address_1'] = $item['location_address_1'];
            $data['location_address_1_ar'] = $item['location_address_1_ar'];
            $data['location_address_2'] = $item['location_address_2'];
            $data['location_address_2_ar'] = $item['location_address_2_ar'];
            $data['location_city'] = $item['location_city'];
            $data['location_city_ar'] = $item['location_city_ar'];
            $data['location_state'] = $item['location_state'];
            $data['location_state_ar'] = $item['location_state_ar'];
            $data['location_postcode'] = $item['location_postcode'];
            $data['location_country'] = $item['country_name'];
            $data['location_telephone'] = $item['location_telephone'];
            $data['location_lat'] = $item['location_lat'];
            $data['location_lng'] = $item['location_lng'];
            $data['profile_image']= $item['location_image'];
            $data['distance'] = "$distance";
            if($item['location_status'] == 1)
            {
                $data['location_status'] = "Active";
            }else{
                $data['location_status'] = "In-Active";
            }
            $data['rewards_value'] = $item['rewards_value'];
            $data['reward_status'] = $item['reward_status'];
            $data['point_value'] = $item['point_value'];
            $data['point_price'] = $item['point_price'];
            $data['minimum_price'] = $item['minimum_price'];
            if($item['first_table_price'] != ""){
                $data['first_table_price'] = $item['first_table_price'];
            }else{
                $data['first_table_price'] = 0;
            }
            
            $gallery = unserialize($item['options']);

            if(@$gallery['gallery']['images'] != ""){
                $i=0;
                foreach ($gallery['gallery']['images'] as $as => $value) {
                    $data['gallery'][$i] = $value;
                    $i++;
                }
            }else{
               $data['gallery'] = array();
            }
            
           
        $data['captcha'] = $this->createCaptcha();
        //echo '<pre>';print_r($data);exit;
		$this->template->render('reservation', $data);
	}

	public function success() {
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'reservation');
		$this->template->setBreadcrumb($this->lang->line('text_success_heading'), 'reservation/success');

		$this->template->setTitle($this->lang->line('text_success_heading'));
		$this->template->setHeading($this->lang->line('text_success_heading'));

		$result = $this->Reservations_model->getReservation($this->session->tempdata('last_reservation_id'), $this->customer->getId());

		if (empty($result) OR empty($result['reservation_id']) OR empty($result['status']) OR $result['status'] <= 0) {															// check if customer_id is set in uri string
			redirect('reservation');
		}

		$guest_num = $result['guest_num'] .' person(s)';

        $time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['text_success'] 	= sprintf($this->lang->line('text_success'), $result['location_name'], $guest_num, mdate('%l, %F %j, %Y', strtotime($result['reserve_date'])), mdate($time_format, strtotime($result['reserve_time'])));
		$data['text_greetings'] = sprintf($this->lang->line('text_greetings'), $result['first_name'] .' '. $result['last_name']);
		$data['text_signature'] = sprintf($this->lang->line('text_signature'), $this->config->item('site_name'));
		$this->session->unset_userdata('reservation');

		$this->template->render('reservation_success', $data);
	}

	private function _reserveTable() {

		if ($this->session->userdata('reservation_data') AND $this->validateForm() === TRUE) {
			$reserve = array();

			$reservation_data = $this->session->userdata('reservation_data');
			if (!empty($reservation_data)) {
				if (!empty($reservation_data['location'])) {
					$reserve['location_id'] = (int)$reservation_data['location'];
				}

				if (!empty($reservation_data['table_found']) AND !empty($reservation_data['table_found']['table_id'])) {
					$reserve['table_id'] = $reservation_data['table_found']['table_id'];
				}

				if (!empty($reservation_data['guest_num'])) {
					$reserve['guest_num'] = (int)$reservation_data['guest_num'];
				}

                if (!empty($reservation_data['reserve_date'])) {
					$reserve['reserve_date'] = $reservation_data['reserve_date'];
				}

				if (!empty($reservation_data['selected_time'])) {
					$reserve['reserve_time'] = $reservation_data['selected_time'];
				}

				if ($this->customer->getId()) {
					$reserve['customer_id'] = $this->customer->getId();
				} else {
					$reserve['customer_id'] = '0';
				}

				$reserve['first_name']  = $this->input->post('first_name');
				$reserve['last_name'] 	= $this->input->post('last_name');
				$reserve['email'] 		= $this->input->post('email');
				$reserve['telephone'] 	= $this->input->post('telephone');
				$reserve['comment'] 	= $this->input->post('comment');
				$reserve['ip_address']  = $this->input->ip_address();
				$reserve['user_agent']  = $this->input->user_agent();

                if ($reservation_id = $this->Reservations_model->addReservation($reserve)) {
    				$this->session->set_tempdata('last_reservation_id', $reservation_id);
    				return TRUE;
    			}

            }
        }
    }

	private function validateForm() {
		$this->form_validation->set_rules('first_name', 'lang:label_first_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('last_name', 'lang:label_last_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'lang:label_email', 'xss_clean|trim|required|valid_email');
		$this->form_validation->set_rules('confirm_email', 'lang:label_confirm_email', 'xss_clean|trim|required|valid_email|matches[email]');
		$this->form_validation->set_rules('telephone', 'lang:label_telephone', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('comment', 'lang:label_comment', 'xss_clean|trim|max_length[520]');
		$this->form_validation->set_rules('captcha', 'lang:label_captcha', 'xss_clean|trim|required|callback__validate_captcha');

        if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
            return FALSE;
		}
	}

    public function _validate_captcha($word) {
		$session_caption = $this->session->tempdata('captcha');

        if (strtolower($word) !== strtolower($session_caption['word'])) {
            $this->form_validation->set_message('_validate_captcha', $this->lang->line('error_captcha'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

	private function createCaptcha() {
        $this->load->helper('captcha');

        $captcha = create_captcha();
        $this->session->set_tempdata('captcha', array('word' => $captcha['word'], 'image' => $captcha['time'].'.jpg')); //set data to session for compare
        return $captcha;
    }

    function get_table_details() {
    	$searched_count = $this->input->post('value');

    	$filter = $this->input->post('location_id');
    	$results = $this->Locations_model->getLocationtable($filter);
    	if($results['table_name'])
    	{
	    	$table_name   			= $results['table_name'];
	    	$min_capacity 			= $results['min_capacity'];
	    	$max_capacity 			= $results['max_capacity'];
	    	$first_table_price 		= $results['first_table_price'];
	    	$additional_table_price = $results['additional_table_price'];
	    	if($max_capacity < $searched_count)
	    	{

	    		$total_tables = ceil($searched_count / $max_capacity);
	    		$table_price = (($total_tables - 1) * $additional_table_price) + $first_table_price; 
	    	}
	    	else
	    	{
	    		$total_tables = 1;
	    		$table_price = $first_table_price;
	    	}

	    	echo $total_tables.'&'.$table_price;
	    }	
	    else
	    {
	    	echo '0';
	    }
    }
}

/* End of file reservation.php */
/* Location: ./main/controllers/reservation.php */