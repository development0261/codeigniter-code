<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reservations_model extends CI_Model {

	public function getCount($filter = array()) {
		if (APPDIR === ADMINDIR) {
			if ( ! empty($filter['filter_search'])) {
				$this->db->like('reservation_id', $filter['filter_search']);
				$this->db->or_like('LCASE(location_name)', strtolower($filter['filter_search']));
				$this->db->or_like('LCASE(first_name)', strtolower($filter['filter_search']));
				$this->db->or_like('LCASE(last_name)', strtolower($filter['filter_search']));
				$this->db->or_like('LCASE(table_name)', strtolower($filter['filter_search']));
				$this->db->or_like('LCASE(staff_name)', strtolower($filter['filter_search']));
			}

			if ( ! empty($filter['filter_status'])) {
				$this->db->where('reservations.status', $filter['filter_status']);
			}

			if ( ! empty($filter['filter_location'])) {
				$this->db->where('reservations.location_id', $filter['filter_location']);
			}

			if ( ! empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(reserve_date)', $date[0]);
				$this->db->where('MONTH(reserve_date)', $date[1]);

				if (isset($date[2])) {
					$this->db->where('DAY(reserve_date)', $date[2]);
				}
			} else if ( ! empty($filter['filter_year']) AND ! empty($filter['filter_month']) AND ! empty($filter['filter_day'])) {
				$this->db->where('YEAR(reserve_date)', $filter['filter_year']);
				$this->db->where('MONTH(reserve_date)', $filter['filter_month']);
				$this->db->where('DAY(reserve_date)', $filter['filter_day']);
			} else if ( ! empty($filter['filter_year']) AND ! empty($filter['filter_month'])) {
				$this->db->where('YEAR(reserve_date)', $filter['filter_year']);
				$this->db->where('MONTH(reserve_date)', $filter['filter_month']);
			}

			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('staffs', 'staffs.staff_id = reservations.assignee_id', 'left');
		} else if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$this->db->where('customer_id', $filter['customer_id']);
		}

		$this->db->from('reservations');

		return $this->db->count_all_results();
	}

	public function getDeviceId($id) {

		$this->db->select('deviceid');
		$this->db->from('customers');
		$this->db->where('customer_id', $id);

		$query = $this->db->get();

		$row = "";
		if ($query->num_rows() === 1) {
			$row = $query->result_array()[0]['deviceid'];
			
		}

		return $row;
	}

	public function getReservationDetails($reservation_id) {
		
		$this->db->select('*,locations.refund_status,locations.cancellation_time');
		$this->db->from('reservations');
		$this->db->join('orders', 'orders.order_id = reservations.order_id', 'left');
		$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
		$this->db->where('reservation_id', $reservation_id);
		$this->db->group_by('reservation_id');
		$query = $this->db->get();

		$row = "";
		if ($query->num_rows() === 1) {
			$row = $query->result_array()[0];
			
		}
		
		return $row;
	}

	public function getTotalAmount($reservation_id) {

		$this->db->select('order_menus.subtotal');
		$this->db->from('reservations');
		$this->db->join('order_menus', 'order_menus.order_id = reservations.order_id');
		$this->db->where('reservations.reservation_id', $reservation_id);
		$query = $this->db->get();

		$total_amount = 0;

		if ($query->num_rows() === 1) {
			foreach($query->result_array() as $value){
				$total_amount += $value['subtotal'];		
			}
		}
		// echo $total_amount;exit;
		return $total_amount;
	}

	public function updateCancellationDetails($reservation_id) {
		// $this->db->set('cancellation_status', 1);
		$this->db->set('status', 17);
		$this->db->where('reservation_id',$reservation_id);
		$this->db->update('reservations');
		return TRUE;
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('reservations');
			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
			$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');

			if (APPDIR === ADMINDIR) {
				$this->db->join('staffs', 'staffs.staff_id = reservations.assignee_id', 'left');

				if ( ! empty($filter['filter_search'])) {
					$this->db->like('reservation_id', $filter['filter_search']);
					$this->db->or_like('LCASE(location_name)', strtolower($filter['filter_search']));
					$this->db->or_like('LCASE(first_name)', strtolower($filter['filter_search']));
					$this->db->or_like('LCASE(last_name)', strtolower($filter['filter_search']));
					$this->db->or_like('LCASE(table_name)', strtolower($filter['filter_search']));
					$this->db->or_like('LCASE(staff_name)', strtolower($filter['filter_search']));
				}

				if ( ! empty($filter['filter_status'])) {
					$this->db->where('reservations.status', $filter['filter_status']);
				}

				if ( ! empty($filter['filter_location'])) {
					$this->db->where('reservations.location_id', $filter['filter_location']);
				}

				if ( ! empty($filter['filter_date'])) {
					$date = explode('-', $filter['filter_date']);
					$this->db->where('YEAR(reserve_date)', $date[0]);
					$this->db->where('MONTH(reserve_date)', $date[1]);

					if (isset($date[2])) {
						$this->db->where('DAY(reserve_date)', (int) $date[2]);
					}
				} else if ( ! empty($filter['filter_year']) AND ! empty($filter['filter_month']) AND ! empty($filter['filter_day'])) {
					$this->db->where('YEAR(reserve_date)', $filter['filter_year']);
					$this->db->where('MONTH(reserve_date)', $filter['filter_month']);
					$this->db->where('DAY(reserve_date)', $filter['filter_day']);
				} else if ( ! empty($filter['filter_year']) AND ! empty($filter['filter_month'])) {
					$this->db->where('YEAR(reserve_date)', $filter['filter_year']);
					$this->db->where('MONTH(reserve_date)', $filter['filter_month']);
				}
			} else if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
				$this->db->where('customer_id', $filter['customer_id']);
			}

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}


	public function getReservationsNew($customer_id) {
		if (is_numeric($customer_id)) {
			$this->db->from('reservations');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->result_array();
			}
		}
	}

	public function getReservations() {
		$this->db->from('reservations');
		$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
		$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');
		$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
		$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');
		$this->db->order_by('reservation_id', 'ASC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function checkReservationTable($guest,$location_id,$reserve_date,$reserve_time){

		$this->db->select('table_id');
		$this->db->from('reservations');
		$this->db->where('location_id', $location_id);
		$this->db->where('reserve_date', $reserve_date);
		$this->db->where('reserve_time', $reserve_time);
		$query = $this->db->get();
		$table_ids = array();
		foreach ($query->result_array() as $key => $value) {
			$table_ids[$key] = $value['table_id'];
		}
		
		$this->db->select('table_id');
		$this->db->from('location_tables');
		$this->db->where('location_id', $location_id);
		if(!empty($table_ids))
			$this->db->where_not_in('table_id', $table_ids);
		$query = $this->db->get();

		$available_tables = array();
		foreach ($query->result_array() as $key => $value) {
			$available_tables[$key] = $value['table_id'];
		}
		return $available_tables;
	}

	public function getReservation($reservation_id = FALSE, $customer_id = FALSE) {

		if ($reservation_id !== FALSE) {
			
			$this->db->select('*, reservations.date_added, reservations.date_modified, reservations.status, tables.table_id, staffs.staff_id, locations.location_id');
				$this->db->join('staffs', 'staffs.staff_id = reservations.assignee_id', 'left');
			// $this->db->select('reservation_id, table_name, reservations.location_id, location_name, location_address_1, location_address_2, location_city, location_postcode, location_country_id, table_name, min_capacity, max_capacity, guest_num, occasion_id, customer_id, first_name, last_name, telephone, email, reserve_time, reserve_date, status_name, reservations.date_added, reservations.date_modified, reservations.status, comment, notify, ip_address, user_agent');
			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('statuses', 'statuses.status_id = reservations.status', 'left');
			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');
			$this->db->join('countries', 'countries.country_id = locations.location_country_id', 'left');

			$this->db->from('reservations');
			$this->db->where('reservation_id', $reservation_id);

			// if (APPDIR === MAINDIR) {
			// 	if ($customer_id !== FALSE) {
			// 		$this->db->where('customer_id', $customer_id);
			// 	}
			// }
			$query = $this->db->get();
			// echo $this->db->last_query();exit;

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getReservationDates() {
		$this->db->select('reserve_date, MONTH(reserve_date) as month, YEAR(reserve_date) as year');
		$this->db->from('reservations');
		$this->db->group_by('MONTH(reserve_date)');
		$this->db->group_by('YEAR(reserve_date)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getMaxCapacity($id) {
		$this->db->select('max_capacity');
		$this->db->from('tables');
		$this->db->where('table_id',$id);
		$query = $this->db->get();
		$result = "";

		if ($query->num_rows() > 0) {
			$result = $query->result_array()[0]['max_capacity'];
		}

		return $result;
	}

	public function getTotalCapacityByLocation($location_id = FALSE) {
		$result = 0;

		$this->db->select_sum('tables.max_capacity', 'total_seats');

		if ( ! empty($location_id)) {
			$this->db->where('location_id', $location_id);
		}

		$this->db->from('location_tables');
		$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$result = $row['total_seats'];
		}

		return $result;
	}

	public function getTotalGuestsByLocation($location_id = FALSE, $date = FALSE) {
		$result = 0;

		$this->db->select_sum('reservations.guest_num', 'total_guest');
		//$this->db->where('status', (int)$this->config->item('default_reservation_status'));

		if ( ! empty($location_id)) {
			$this->db->where('location_id', $location_id);
		}

		if ( ! empty($date)) {
			$this->db->where('DATE(reserve_date)', $date);
		}

		$this->db->group_by('DAY(reserve_date)');
		$this->db->from('reservations');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$result = $row['total_guest'];
		}

		return $result;
	}

	public function getLocationTablesByMinCapacity($location_id, $guest_num) {

		$tables = array();

		if (isset($location_id, $guest_num)) {
			$this->db->from('location_tables');
			$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');

			$this->db->where('location_id', $location_id);
			$this->db->where('table_status', '1');

			$this->db->group_start();
			$this->db->where('min_capacity <=', $guest_num);
			$this->db->where('max_capacity >=', $guest_num);
			$this->db->group_end();

			$this->db->order_by('min_capacity', 'ASC');

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$tables[$row['table_id']] = $row;
				}
			}
		}

		return $tables;
	}

	public function findATable($find = array()) {

		//ini_set('memory_limit', '-1');

		if ( ! isset($find['location']) OR ! isset($find['guest_num']) OR empty($find['reserve_date']) OR empty($find['reserve_time']) OR empty($find['time_interval'])) {
			return 'NO_ARGUMENTS';
		}

		if ( ! ($available_tables = $this->getLocationTablesByMinCapacity($find['location'], $find['guest_num']))) {
			return 'NO_TABLE';
		}

		$find['reserve_date_time'] = strtotime($find['reserve_date'] . ' ' . $find['reserve_time']);
		$find['unix_start_time'] = strtotime('-' . ($find['time_interval'] * 2) . ' mins', $find['reserve_date_time']);
		$find['unix_end_time'] = strtotime('+' . ($find['time_interval'] * 2) . ' mins', $find['reserve_date_time']);

		$time_slots = $this->time_range(mdate('%H:%i', $find['unix_start_time']), mdate('%H:%i', $find['unix_end_time']),
		                         $find['time_interval'], '%H:%i');
		$reserve_time_slot = array_flip($time_slots);

		$reserved_tables = $this->getReservedTableByDate($find, array_keys($available_tables));

		foreach ($reserved_tables as $reserved) {
			// remove available table if already reserved
			if (isset($available_tables[$reserved['table_id']])) {
				unset($available_tables[$reserved['table_id']]);
			}

			// remove reserve time slot if already reserved
			$reserve_time = mdate('%H:%i', strtotime($reserved['reserve_date'] . ' ' . $reserved['reserve_time']));
			if (isset($reserve_time_slot[$reserve_time])) {
				unset($reserve_time_slot[$reserve_time]);
			}
		}

		if (empty($available_tables) OR empty($reserve_time_slot)) {
			return 'FULLY_BOOKED';
		}

		return array('table_found' => $available_tables, 'time_slots' => array_flip($reserve_time_slot));
	}



	function time_range($unix_start, $unix_end, $interval, $time_format = '%H:%i') {
        if ($unix_start == '' OR $unix_end == '' OR $interval == '') {
            return FALSE;
        }

        $interval = ctype_digit($interval) ? $interval . ' mins' : $interval;

        $start_time = strtotime($unix_start);
        $end_time   = strtotime($unix_end);

        $current    = time();
        $add_time   = strtotime('+'.$interval, $current);
        $diff       = $add_time-$current;

        $times = array();
        while ($start_time < $end_time) {
            $times[] = mdate($time_format, $start_time);
            $start_time += $diff;
        }
        $times[] = mdate($time_format, $start_time);
        return $times;
    }

	public function getReservedTableByDate($find = array(), $table_id, $group = FALSE) {
		if ( ! isset($find['location']) OR ! is_numeric($find['location']) OR empty($find['reserve_date']) OR empty($table_id)) {
			return FALSE;
		}

		is_array($table_id) OR $table_id = array($table_id);

		$this->db->from('reservations');
		$this->db->where('location_id', $find['location']);

		if ( ! empty($table_id)) {
			$this->db->where_in('table_id', $table_id);
		}

		$this->db->group_start();
		$this->db->where('ADDTIME(reserve_date, reserve_time) >=',
		                 mdate('%Y-%m-%d %H:%i:%s', $find['unix_start_time']));
		$this->db->where('ADDTIME(reserve_date, reserve_time) <=', mdate('%Y-%m-%d %H:%i:%s', $find['unix_end_time']));
		$this->db->group_end();

		$query = $this->db->get();

		$results = array();
		if ($query->num_rows() > 0) {
			if ($group) {
				foreach ($query->result_array() as $row) {
					$results[$row['table_id']][] = $row;
				}
			} else {
				$results = $query->result_array();
			}
		}

		return $results;
	}

	public function getTotalSeats($location_id) {
		$this->db->select_sum('tables.max_capacity', 'total_seats');
		$this->db->where('location_id', $location_id);
		$this->db->from('location_tables');
		$this->db->join('tables', 'tables.table_id = location_tables.table_id', 'left');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			return $row['total_seats'];
		}
	}

	public function updateReservation($reservation_id, $update = array()) {
		if (empty($update)) return FALSE;

		if (isset($update['status'])) {
			$this->db->set('status', $update['status']);
		}

		if (isset($update['assignee_id'])) {
			$this->db->set('assignee_id', $update['assignee_id']);
		}

		if (isset($update['date_modified'])) {
			$this->db->set('date_modified', mdate('%Y-%m-%d', time()));
		}

		if ($reservation_id) {
			$this->db->where('reservation_id', $reservation_id);
			$query = $this->db->update('reservations');
			$status = $this->Extensions_model->getStatus($update['status']);

			 // if (isset($update['notify']) AND $update['notify'] === '1') {
				$mail_data = $this->getMailData($reservation_id);

				$mail_data['status_name'] = $status['status_name'];
				$mail_data['status_comment'] = !empty($update['status_comment']) ? $update['status_comment'] : $this->lang->line('text_no_comment');

				$this->load->model('Mail_templates_model');
				$lang = $this->input->post('language');
				if($lang=='arabic'){
						$registration = 'reservation_update_ar';
					}else{
						$registration = 'reservation_update';
					}
				$mail_template = $this->Mail_templates_model->getTemplateData($this->GetTable('settings','item = "mail_template_id"'), $reservation_update);
				$update['notify'] = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
			 // }
			// AND (int) $update['old_status_id'] !== (int) $update['status']
			if ($query) { 
				$id = $this->getReservationid($reservation_id);
				$update['object_id'] = $id->id;

				// $update['staff_id'] = $this->user->getStaffId();
				$update['status_id'] = (int) $update['status'];
				$update['comment'] = $update['status_comment'];
				$update['date_added'] = mdate('%Y-%m-%d %H:%i:%s', time());
				$this->addStatusHistory('reserve', $update);
				// echo $this->db->last_query();exit;
				$this->db->set('status_id',19);
				$this->db->where('order_id',$id->order_id);
				$this->db->update('orders');

				$update['status_id'] = 19;
				$update['comment'] = 'Your order has been cancelled.';
				$update['date_added'] = mdate('%Y-%m-%d %H:%i:%s', time());
				$this->addStatusHistory('order', $update);
			}
		}

		return $query;
	}

	public function addStatusHistory($for = '', $add = array()) {
		$query = FALSE;

		if (isset($add['staff_id'])) {
			$this->db->set('staff_id', $add['staff_id']);
		}

		if (isset($add['assignee_id'])) {
			$this->db->set('assignee_id', $add['assignee_id']);
		}

		if (isset($add['object_id'])) {
			$this->db->set('object_id', $add['object_id']);
		}

		if (isset($add['status_id'])) {
			$this->db->set('status_id', $add['status_id']);
		}

		if ($for !== '') {
			$this->db->set('status_for', $for);
		}

		if (isset($add['notify']) AND $add['notify'] === '1') {
			$this->db->set('notify', $add['notify']);
		} else {
			$this->db->set('notify', '0');
		}

		if (isset($add['comment'])) {
			$this->db->set('comment', $add['comment']);
		}

		if (isset($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}

		if ( ! empty($add)) {
			if ($this->db->insert('status_history')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}


	public function addReservation($add = array(),$ch) {
		if (empty($add)) return FALSE;
		
		if (isset($add['reservation_id'])) {
			$this->db->set('reservation_id', $add['reservation_id']);
		}

		if (isset($add['location_id'])) {
			$this->db->set('location_id', $add['location_id']);
		}

		if (isset($add['table_id'])) {
			$this->db->set('table_id', $add['table_id']);
		}

		if (isset($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (isset($add['guest_num'])) {
			$this->db->set('guest_num', $add['guest_num']);
		}

		if (isset($add['total_amount'])) {
			$this->db->set('total_amount', $add['total_amount']);
		}

		if (isset($add['order_price'])) {
			$this->db->set('order_price', $add['order_price']);
		}

		if (isset($add['booking_price'])) {
			$this->db->set('booking_price', $add['booking_price']);
		}

		if (isset($add['booking_tax'])) {
			$this->db->set('booking_tax', $add['booking_tax']);
		}

		if (isset($add['booking_tax_amount'])) {
			$this->db->set('booking_tax_amount', $add['booking_tax_amount']);
		}
		
		if (isset($add['payment_key'])) {
			$this->db->set('payment_key', $add['payment_key']);
		}
		if (isset($add['total_amount'])) {
			$this->db->set('total_amount', $add['total_amount']);
		}

		if (isset($add['reward_points'])) {
			$this->db->set('reward_points', $add['reward_points']);
		}

		if (isset($add['otp'])) {
			$this->db->set('otp', $add['otp']);
		}

		if (isset($add['order_id'])) {
			$this->db->set('order_id', $add['order_id']);
		}

		if (isset($add['using_reward_points'])) {
			$this->db->set('reward_using_status', 1);
		}

		if (isset($add['reserve_date'])) {
			$this->db->set('reserve_date', mdate('%Y-%m-%d', strtotime($add['reserve_date'])));
		}

		if (isset($add['reserve_time'])) {
			$this->db->set('reserve_time', date('H:i:s', strtotime($add['reserve_time'])));
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
			$this->db->set('date_modified', mdate('%Y-%m-%d', time()));
		}

		if (isset($add['occasion_id'])) {
			$this->db->set('occasion_id', $add['occasion_id']);
		}

		if (isset($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (isset($add['first_name'])) {
			$this->db->set('first_name', $add['first_name']);
		}

		if (isset($add['last_name'])) {
			$this->db->set('last_name', $add['last_name']);
		}

		if (isset($add['payment'])) {
			$this->db->set('payment_method', $add['payment']);

			if($add['payment'] == "cash"){
				$this->db->set('paid_status', 'paid');
			}else{
				$this->db->set('paid_status', 'pending');
			}
		}

		if (isset($add['email'])) {
			$this->db->set('email', $add['email']);
		}

		if (isset($add['telephone'])) {
			$this->db->set('telephone', $add['telephone']);
		}

		if (isset($add['comment'])) {
			$this->db->set('comment', $add['comment']);
		}

		if (isset($add['user_agent'])) {
			$this->db->set('user_agent', $add['user_agent']);
		}

		if (isset($add['ip_address'])) {
			$this->db->set('ip_address', $add['ip_address']);
		}

		$default_status = $this->GetTable('settings','item = "default_reservation_status"');
       
		$this->db->set('status', $default_status);

		$reservation_id = 0;

		if ( ! empty($add)) {
			if ($this->db->insert('reservations') AND $ch == 0) {

				

				$reservation_id = $this->db->insert_id();
				//$this->db->insert();

				if (APPDIR === MAINDIR) {
					log_activity($add['customer_id'], 'reserved', 'reservations',
					             get_activity_message('activity_reserved_table',
					                                  array('{customer}', '{link}', '{reservation_id}'),
					                                  array($add['first_name'] . ' ' . $add['last_name'], admin_url('reservations/edit?id=' . $reservation_id), $reservation_id)
					             ));
				}else{
					$this->load->helper('logactivity');
					log_activity($add['customer_id'], 'reserved', 'reservations','<a href="'.site_url().'admin/customers/edit?id='.$add['customer_id'].'">'.$add['first_name'] . ' ' . $add['last_name'].'</a> made a new <b>reservation</b> <a href="'.site_url().'admin/reservations/edit?id='.$reservation_id.'"><b>#'.$reservation_id.'.</b></a>');
				}
				
				$this->load->model('Mail_templates_model');
				$mail_data = $this->getMailData($add['reservation_id']);
				$reservation_email = unserialize($this->GetTable('settings','item = "reservation_email"'));

				$config_reservation_email = is_array($reservation_email) ? $reservation_email : array();

				$notify = '0';
				if ($this->GetTable('settings','item = "customer_reserve_email"') === '1' OR in_array('customer', $config_reservation_email)) {
					$lang = $this->input->post('language');
					if($lang=='arabic'){
						$registration = 'reservation_ar';
					}else{
						$registration = 'reservation';
					}
					$mail_template = $this->Mail_templates_model->getTemplateData($this->GetTable('settings','item = "mail_template_id"'), $reservation);
					$notify = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
				}

				if ($this->location->getEmail() AND ($this->GetTable('settings','item = "location_reserve_email"') === '1' OR in_array('location', $config_reservation_email))) {
					$lang = $this->input->post('language');
					if($lang=='arabic'){
						$registration = 'reservation_alert_ar';
					}else{
						$registration = 'reservation_alert';
					}
					$mail_template = $this->Mail_templates_model->getTemplateData($this->GetTable('settings','item = "mail_template_id"'), $reservation_alert);
					$this->sendMail($this->location->getEmail(), $mail_template, $mail_data);
				}

				if (in_array('admin', $config_reservation_email)) {
					$lang = $this->input->post('language');
					if($lang=='arabic'){
						$registration = 'reservation_alert_ar';
					}else{
						$registration = 'reservation_alert';
					}
					$mail_template = $this->Mail_templates_model->getTemplateData($this->GetTable('settings','item = "mail_template_id"'), $reservation_alert);
					$this->sendMail($this->GetTable('settings','item = "site_email"'), $mail_template, $mail_data);
				}

				$this->db->set('notify', $notify);

				$this->db->set('status', $this->config->item('default_reservation_status'));
				$this->db->where('reservation_id', $reservation_id);

				if ($this->db->update('reservations')) {
					$this->load->model('Statuses_model');
					$status = $this->Statuses_model->getStatus($default_status);

					if($status['status_id'] == 16)
					{

						$sellerid = $this->Locations_model->getLocation($add['location_id']);
						$sellerid = $sellerid['added_by'];

	                	if($sellerid == '11') {
	                		$sellerid = $stf_id;
	                	}
	                	$percentage =  $this->Locations_model->getSellerCommission($sellerid);
	                	$commission_percentage = $percentage[0]['commission'];

	               		$amt = $this->Locations_model->getReserveDetails($add['reservation_id']);
	               		
	               		$status_detail = $this->Statuses_model->getStatus($status['status_id']);
	               		
	               		//$total_amount = round($amount,2);

						$this->Locations_model->applyCommission($sellerid,$add['location_id'],$amt,$commission_percentage,$add['reservation_id'],$status['status_name'],$status['status_id']);
					}
					
					$reserve_history = array(
						'object_id'  => $reservation_id,
						'status_id'  => $status['status_id'],
						'notify'     => $notify,
						'comment'    => $status['status_comment'],
						'date_added' => mdate('%Y-%m-%d %H:%i:%s', time()),
					);

					//$this->Statuses_model->addStatusHistory('reserve', $reserve_history);
				}

				$query = $reservation_id;
			}
		}

		return $reservation_id;
	}

	public function add2checkoutdetails($sale_id, $reservation_id, $customer_id, $response_data,$method) {
		$query = FALSE;
		if (!empty($reservation_id)) {
			$this->db->set('order_id', $reservation_id);
		}

		if (!empty($customer_id)) {
			$this->db->set('customer_id', $customer_id);
		}

		if (!empty($response_data)) {
			$this->db->set('serialized', $response_data);
		}

		if (!empty($method)) {
			$this->db->set('method', $method);
		}

		if (!empty($sale_id)) {
			$this->db->set('transaction_id', $sale_id);

			if ($this->db->insert('pp_payments')) {
				$query = $this->db->insert_id();
			}
		}
		return $query;
	}

	public function addRewardHistory($data){

		$this->db->set('reservation_id',$data['reservation_id']);
		$this->db->set('customer_id',$data['customer_id']);
		$this->db->set('total_amount',$data['total_amount']);
		$this->db->set('reward_points',$data['using_reward_points']);
		$this->db->set('reward_amount',$data['using_reward_amount']);
		$this->db->set('status',1);
		$this->db->insert('reward_histories');
		return TRUE;

	}

	public function addNotification($data){

		$this->db->set('order_count',0);
		$this->db->set('view_status',0);
		$this->db->set('notify_msg',$data['notify_msg']);
		$this->db->insert('notifications');
		return TRUE;

	}

	public function getTemplateId($status_id){

		$this->db->select('template_id');
		$this->db->from('statuses');
		$this->db->where('status_id',$status_id);
		$query = $this->db->get();
		return $query->result_array()[0]['template_id'];

	}

	public function getLocationDetails($location_id){

		$this->db->select('*');
		$this->db->from('locations');
		$this->db->where('location_id',$location_id);
		$query = $this->db->get();
		return $query->result_array()[0];

	}

	public function getPlayerId($customer_id){

		$this->db->select('deviceid');
		$this->db->from('customers');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get();
		return $query->result_array()[0]['deviceid'];

	}

	public function sendMessage($template_id,$player_id){
    /*$content = array(
      "template_id" => "97b86275-1376-4982-9c24-488b08e69867"
      );*/
    
    $fields = array(
      'app_id' => "5cbfa8e1-656b-4616-aa00-2d26b9759690",
      //'included_segments' => array('All'),
      'include_player_ids' => array($player_id),
            'data' => array("foo" => "bar"),
      //'contents' => $content
      "template_id" => $template_id
    );
    
    $fields = json_encode($fields);
    //print("\nJSON sent:\n");
    //print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                           'Authorization: Basic YWIxMDc2ZjgtZTkxMS00YjRmLTkwNDEtNDZhYjMxN2Y3NTZk'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
  }

  public function updatecustomerrewards($reward_points,$customer_id){
		$sql = " UPDATE {$this->db->dbprefix('customers')} SET `reward_points` = `reward_points` - ".$reward_points." WHERE `customer_id` = ".$customer_id;
		$this->db->query($sql);
		return TRUE;
	}
	
	public function getNotification($id){

		$this->db->select('status_history.object_id,status_history.comment,status_history.status_for,reservations.otp');
		$this->db->from('status_history');
		$this->db->join('reservations', 'reservations.reservation_id = status_history.object_id','left');
		
		$this->db->where('reservations.customer_id',$id);

		$this->db->group_by('status_history_id');
		$this->db->order_by('status_history_id','desc');
		$query = $this->db->get();

		return $query->result_array();



	}

	public function addOrder($order_info = array(), $cart_contents = array()) {		

        if (empty($order_info) OR empty($cart_contents)) return FALSE;

        if (isset($order_info['location_id'])) {
            $this->db->set('location_id', $order_info['location_id']);
        }

        if (isset($order_info['customer_id'])) {
            $this->db->set('customer_id', $order_info['customer_id']);
        } else {
            $this->db->set('customer_id', '0');
        }

        if (isset($order_info['first_name'])) {
            $this->db->set('first_name', $order_info['first_name']);
        }

        if (isset($order_info['last_name'])) {
            $this->db->set('last_name', $order_info['last_name']);
        }

        if (isset($order_info['email'])) {
            $this->db->set('email', $order_info['email']);
        }

        if (isset($order_info['telephone'])) {
            $this->db->set('telephone', $order_info['telephone']);
        }

        if (isset($order_info['order_type'])) {
            $this->db->set('order_type', $order_info['order_type']);
        }

		if (isset($order_info['coupon_code'])) {
            $this->db->set('coupon_code', $order_info['coupon_code']);
        }

		if (isset($order_info['coupon_discount'])) {
            $this->db->set('coupon_discount', $order_info['coupon_discount']);
        }

		if (isset($order_info['coupon_type'])) {
            $this->db->set('coupon_type', $order_info['coupon_type']);
        }

		if (isset($order_info['deviceid'])) {
            $this->db->set('deviceid', $order_info['deviceid']);
        }

		if (isset($order_info['pickup_time'])) {
            $this->db->set('pickup_time', $order_info['pickup_time']);
        }

        if (isset($order_info['order_time'])) {
            $current_time = time();
            $order_time = (strtotime($order_info['order_time']) < strtotime($current_time)) ? $current_time : $order_info['order_time'];
            $this->db->set('order_time', mdate('%H:%i', strtotime($order_info['order_time'])));
            $this->db->set('order_date', mdate('%Y-%m-%d', strtotime($order_info['order_date'])));
            $this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $current_time));
            $this->db->set('date_modified', mdate('%Y-%m-%d', $current_time));
            $this->db->set('ip_address', $this->input->ip_address());
            $this->db->set('user_agent', $this->input->user_agent());
        } else {
        	$this->db->set('order_time', date('H:i:s'));
            $this->db->set('order_date', date('Y-m-d'));
            $this->db->set('date_added', date('Y-m-d H:i:s'));
            $this->db->set('date_modified', date('Y-m-d'));
            $this->db->set('ip_address', $this->input->ip_address());
            $this->db->set('user_agent', $this->input->user_agent());
        }

        if (isset($order_info['address_id'])) {
            $this->db->set('address_id', $order_info['address_id']);
        }

        if (isset($order_info['payment'])) {
            $this->db->set('payment', $order_info['payment']);
        }

        if (isset($order_info['comment'])) {
            $this->db->set('comment', $order_info['comment']);
        }

        if (isset($order_info['total_amount'])) {
            $this->db->set('order_total', $cart_contents['order_total']);
        }

         if (isset($order_info['address_id'])) {
            $this->db->set('status_id', 1);
        } else {
        	$this->db->set('status_id', 12);
        }

        if (isset($cart_contents['total_items'])) {
            $this->db->set('total_items', $cart_contents['total_items']);
        }
        

        if ( ! empty($order_info)) {
            if (isset($order_info['order_id'])) {
                $_action = 'updated';
                $this->db->where('order_id', $order_info['order_id']);
                $query = $this->db->update('orders');
                $reserve['order_id'] = $order_info['order_id'];
                $reserve['order_time'] = date('H:i:s');
                $reserve['order_date'] = date('Y-m-d');
                $order_id = $order_info['order_id'];
            } else {
                $_action = 'added';
                $query = $this->db->insert('orders');
                $reserve['order_id'] = $this->db->insert_id();
                $order_id = $this->db->insert_id();
                $reserve['order_time'] = date('H:i:s');
                $reserve['order_date'] = date('Y-m-d');
            }

            if ($query AND $order_id) {
                if (isset($order_info['address_id'])) {
                    $this->load->model('Addresses_model');
                    $this->Addresses_model->updateDefault($order_info['customer_id'], $order_info['address_id']);
                }

                $this->addOrderMenus($order_id, $cart_contents);

                $this->addOrderTotals_api($order_id, $cart_contents, $order_info['table_booking_tax']);

                $this->addOrderHistory($order_id);

                if ( ! empty($cart_contents['coupon'])) {
                    $this->addOrderCoupon($order_id, $order_info['customer_id'], $cart_contents['coupon']);
                }
				/*
				* Update card details
				*/
				if ( ! empty($order_info['card_details'])) {
                    $this->addCardInfo($order_info['card_details'], $order_info['email']);
                }

				/*
				* Send mail to admin
				*/
				$this->sendMailAdmin($order_info, $cart_contents, $order_id);

				/*
				* Send restaurant push
				*/
				$this->sendRestaurantPush($order_info['location_id']);

                return $reserve;
            }
        }
    }

	/*
    * Send push to restaurant
    */
    public function sendMailAdmin($order_info = array(), $cart_contents = array(), $order_id = NULL){
		
		$email = !empty($order_info['location_id']) && $order_info['location_id'] == 29 ? $this->config->item('tweedhead_order_admin_email') : $this->config->item('aspley_order_admin_email');

        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{         
                $config = array(
                    'protocol'  => $this->config->item('protocol'),
                    'smtp_host' => $this->config->item('smtp_host'),
                    'smtp_port' => $this->config->item('smtp_port'),
                    'smtp_user' => $this->config->item('smtp_user'),
                    'smtp_pass' => $this->config->item('smtp_pass'),
                    'mailtype'  => $this->config->item('mailtype'),
                    'charset'   => $this->config->item('charset'),
                );
    
                $this->load->library('email', $config);            
                $to_email = $email;
                $from_email_address = $this->config->item('from_email_address');
                $from_email_name    = $this->config->item('from_email_name'); 

                $subject_data = 'Order has been placed successfully';     
                $message_data = 'Order placed by '.$order_info['email'];
    			$mail_body = '';
    			$mail_body = $this->mailContent($order_info['location_id'],$order_info['customer_id'],$order_id);
    			if($mail_body == '')
    			{
                	$mail_body = '<!DOCTYPE html><html><head><title></title></head><body>'.$message_data.'</body></html>';
    			}
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= "From: ".$from_email_name."<".$from_email_address.">\r\n";
				$headers .= 'Cc: '. $this->config->item('cc_order_admin_email') . "\r\n";

				//echo $headers;

                @mail($to_email, $subject_data, $mail_body, $headers);

			}
	}

	/*
    * mailContent
    */
	public function mailContent($location_id,$customer_id,$order_id = NULL){
		$orders = $this->getRestaurantOrderHistory($location_id,$customer_id,$order_id);
	    $orderID    = '';
	    $orderDate  = '';
	    $orderTime  = '';
		$pickup_time  = '';
		$comment  = '';
	    $customerTelephone = '';
	    $customerName      = '';
	    $customerEmail     = "developement0261@gmail.com";
	    $paymentMethod     = '';
	    $paymentStatus     = '';
	    $order_total       = 0;
	    $totalGST          = 0;
		$grand_total       = 0;
	    $menuItems  = [];
	    if(count($orders)>0)
	    {
	      $orderID    = $orders[0]['order_id'];
	      $orderDate  = date('d-m-Y',strtotime($orders[0]['order_date']));
	      $orderTime  = $orders[0]['order_time'];
		  $pickup_time  = $orders[0]['pickup_time'];
		  $comment  	= wordwrap($orders[0]['comment'],30,"<br>\n");
	      $customerTelephone = $orders[0]['telephone'];
	      $customerName  = $orders[0]['first_name']." ".$orders[0]['last_name'];
	      $customerEmail = $orders[0]['email'];
	      $paymentMethod     = $orders[0]['payment'];
	      $paymentStatus     = $orders[0]['status_name'];
	      $menuItems         = $orders[0]['menuItems'];
	      $order_total       = $orders[0]['order_total'];
	      $orderTotals       = $orders[0]['orderTotals'];
	      // echo $orderTotals[0]['code']."--".$orderTotals[1]['code']."---".$orderTotals[2]['code'];
	      foreach ($orderTotals as $totakOrderKey => $totalOrderVal)
	      {
	        if(isset($orderTotals[$totakOrderKey]['code']) && $orderTotals[$totakOrderKey]['code'] == 'taxes')
	        {
	          $totalGST = $orderTotals[$totakOrderKey]['value'];
	        }
	      }
		  $grand_total = $order_total + $totalGST;
	    }
	    $message_data = 'Order placed by '.$customerEmail;
	    $mail_body = '<!DOCTYPE html><html><head><title></title></head><body>
	          '.$message_data.'</body></html>';
	    $logo_url = base_url().'/admin/views/themes/spotneat-blue/images/sidemenu-logo.png';
	    $content  = '';
	    $content .= ' <table style="border:1px solid #999999;">
			<tr>
				<td><strong>Below are the new order details</strong></td>
			</tr>
			<tr>
				<td align="left">
					Order No: #
					'.$orderID.'
				</td>
			</tr>
			<tr>
				<td align="left">
					Name:
					'.$customerName.'
				</td>
			</tr>
			<tr>
				<td align="left">
					Phone:
					'.$customerTelephone.'
				</td>
			</tr>   
			<tr>
				<td align="left">
					Pickup Time:<br>
					'.$pickup_time.'
				</td>
			</tr>
			<tr>
				<td align="left"> Pickup Date:<br>
				'.$orderDate.'
				</td>
			</tr>    
			<tr>
				<td align="left" style="padding-bottom:10px;border-bottom:1px solid #999999;"> Note:<br />
				'.$comment.'
				</td>
			</tr>
			<tr>
				<td align="left" style="padding-top:10px;border-bottom:1px solid #999999;">Item Details</td>
			</tr>
			<tr>
				<td>
					<table>';
						if(count($menuItems)>0) 
						{
							foreach($menuItems as $menuItemsval)
							{                 
								$content .= '<tr>
											<td>
												<table>
													<tr>
														<td align="left" width="10%" style="vertical-align:top;"><strong>
															'.$menuItemsval['quantity'].'</strong>
														</td>
														<td align="left" width="90%"><strong>
															'.$menuItemsval['name'].'</strong>
														</td>
													</tr>';
													if(isset($menuItemsval['menu_variants'])){
														$content .= '<tr style="background-color:#FFF;"><td colspan="2"  style="color:#000" align="left">Variants:-</td></tr>';
														foreach ($menuItemsval['menu_variants'] as $variantsVal)
														{
														$content .= '<tr style="background-color:#FFF;"><td colspan="2"  style="color:#000;" align="left">'.$variantsVal['variant_type_value'].'</td></tr>';
														}
													}
													if(isset($menuItemsval['menu_options'])){
														$content .= '<tr style="background-color:#FFF;"><td colspan="2"  style="color:#000;" align="left">Add Ons:-</td></tr>';
														foreach ($menuItemsval['menu_options'] as $menuOptions)
														{
														$content .= '<tr style="background-color:#FFF;"><td colspan="2"  style="color:#000;"  align="left">'.$menuOptions['option_value_name'].'</td></tr>';
														}
													}
								$content .= '</table>
											</td>
										</tr>'; 
							}
						}
				$content .= '</table>
				</td>
			</tr>
		
			<tr>
				<td align="left" style="border-top:solid 1px #d6d6d6;">Total:&nbsp;
					$'.number_format($order_total,2).'
				</td>
			</tr>    			

		</table>';

    	return $content;
	}
	public function getRestaurantOrderHistory($location_id,$customer_id,$order_id = NULL){
      if($location_id){
        $this->db->select('orders.*,statuses.*,customers.email,customers.telephone,customers.first_name,customers.last_name');
        $this->db->from('orders');
        $this->db->join('statuses', 'statuses.status_code = orders.status_id');
        $this->db->join('customers', 'customers.customer_id = orders.customer_id');

        // if(!empty($location_id) && is_numeric($location_id)){
          $this->db->where('orders.location_id',$location_id);
        // }
        if(!empty($customer_id) && is_numeric($customer_id)){
          $this->db->where('orders.customer_id',$customer_id);
        }
        if(!empty($order_id) && is_numeric($order_id)){
          $this->db->where('orders.order_id',$order_id);
        }
        
        // $this->db->group_by('order_menus.order_id');
        $this->db->order_by('date_added','desc');

        $query = $this->db->get();
        $result = array();
        if(!$query->num_rows())
        {
          return array();
        }else{
          $i = 0;
          foreach ($query->result_array() as $key => $value) {
            if(floatval($value['coupon_discount']) > 0){
              $discounted_total = floatval($value['order_total']) - floatval($value['coupon_discount']);
              $value['order_total'] = sprintf("%.2f", $discounted_total);
            }
            $this->db->select('order_menus.*,menus.*');
            $this->db->from('order_menus');
            $this->db->join('menus', 'menus.menu_id = order_menus.menu_id');
            $this->db->where('order_menus.order_id',$value['order_id']);
            $query=$this->db->get();
            $menuItems = $query->result_array();                      

            if(!empty($menuItems))
            {
              foreach ($menuItems as $key_menuItems => $value_menuItems)
              {
                /*
                * Order menus
                */
                $this->db->select('order_options.menu_id,order_options.menu_option_value_id, order_options.menu_option_value_id as option_value_id, order_options.order_menu_option_id as menu_option_id, order_options.menu_option_value_id as option_value_id, "Add Ons" as option_name, order_options.order_option_name as option_value_name,order_options.order_option_price as price');
                $this->db->from('order_options');
                $this->db->join('order_menus', 'order_options.order_menu_id = order_menus.order_menu_id');
                $this->db->where('order_options.order_menu_id',$value_menuItems['order_menu_id']);
                $this->db->where('order_options.order_id',$value_menuItems['order_id']);
                $orderquery   = $this->db->get();
                if($orderquery->num_rows()){
                  $orderOptions = $orderquery->result_array();
                  $menuItems[$key_menuItems]['menu_options'] = $orderOptions;
                }
                /*
                * Order variants
                */
                $this->db->select('order_variants.variant_type_id, order_variants.variant_type_value_id, order_variants.variant_type_name as variant_type, order_variants.variant_type_value_name as variant_type_value ,order_variants.price');
                $this->db->from('order_variants');
                $this->db->join('order_menus', 'order_variants.order_menu_id = order_menus.order_menu_id');
                $this->db->where('order_variants.order_menu_id',$value_menuItems['order_menu_id']);
                $this->db->where('order_variants.order_id',$value_menuItems['order_id']);
                $orderquery   = $this->db->get();
                if($orderquery->num_rows()){
                  $orderVariants = $orderquery->result_array();
                  $menuItems[$key_menuItems]['menu_variants'] = $orderVariants;
                }
              }
            }


            $result[$i]=$value;
            /*
            * Order totals
            */
            $this->db->select('code,value');
            $this->db->from('order_totals');
            $this->db->where('order_id',$value['order_id']);
            $orderQuery=$this->db->get();
            $orderTotals = $orderQuery->result_array();
            $result[$i]['orderTotals'] = $orderTotals;
            $result[$i]['menuItems'] = $menuItems;
            $i++;
          }
        }
        return $result;

      }else{
        return [];
      }

    }
 	/*
    * Send push to restaurant
    */
    public function sendRestaurantPush($location_id = ''){
		/*
		*  Get token from location
		*/
		$deviceId = '';
		$deviceInfo = array();
		$recordinfo = $this->restaurantDeviceId($location_id);
		if(!empty($recordinfo)){
			$deviceId = $recordinfo['deviceid'];
			$deviceInfo = json_decode($recordinfo['deviceInfo'], true);			
		}		
		//$token = $this->post('token');
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		//$token = $token;
		$title = 'New order notification!';
		$message = 'New order has been placed!';

		if ($deviceInfo['platform'] == 'Android' || $deviceInfo['platform'] == 'android' || $deviceInfo['platform'] == 'ANDROID') {
			$fields = array(
				'registration_ids' => array($deviceId),
				'priority' => "high",
				'notification'=>
						array(
							'title' => $title,
							'body' =>  $message ,
							'sound'=>'Default',
							'image'=> '',
							"icon"=>"fcm_push_icon",
							'page_url' => '',
							'web_url'=> '',
							'notification_id'=> ''
					)
			);
		} elseif ($deviceInfo['platform'] == 'iOS' || $deviceInfo['platform'] == 'IOS' || $deviceInfo['platform'] == 'ios') {
			$fields = array(
				'registration_ids' => array($deviceId),
				'priority' => "high",
				'notification' => array(
					'title' => $title,
					'body' =>  $message ,
					'sound'=>'Default',
					'image'=> '',
					"icon"=>"fcm_push_icon"
				),
				'data'=>
						array(
							'page_url' => '',
							'web_url'=> '',
							'notification_id'=> ''
					)
			);
		} 
		// $fields = array(
		//   'registration_ids' => array($deviceId),
		//   'priority' => "high",
		//   "notification" => array(
		// 		'title' => 'New order notification!',
		// 		'body' => 'New order has been placed!',
		// 		'sound'=>'Default',
		// 		"icon"=>"fcm_push_icon"
		//   )
		// );
  
		$headers = [
			'Authorization: key='.FCM_API_KEY,
			'Content-Type: application/json'
		];
  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$fcmUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	/*
    * Get restaurat device id by location
    */
    public function restaurantDeviceId($location_id = ''){
		$this->db->select('users.deviceid, users.deviceInfo');
		$this->db->from('users');
		$this->db->join('locations', 'locations.restaurant_by = users.staff_id');
		$this->db->where('locations.location_id',$location_id);
		$query = $this->db->get();
		
		$result = '';
		if($query->num_rows()){
			$result = !empty($query->result_array()[0])?$query->result_array()[0]:'';
		}		
		return $result;
	}

    public function addOrderCoupon($order_id, $customer_id, $coupon) {
       
        if (is_array($coupon) AND is_numeric($coupon['amount'])) {
           
            $this->db->where('order_id', $order_id);
            $this->db->delete('coupons_history');

            //$this->load->model('Coupons_model');
            $temp_coupon = $this->getCouponByCode($coupon['code']);

            $this->db->set('order_id', $order_id);
            $this->db->set('customer_id', empty($customer_id) ? '0' : $customer_id);
            $this->db->set('coupon_id', $temp_coupon['coupon_id']);
            $this->db->set('code', $temp_coupon['code']);
            $this->db->set('amount', '-' . $coupon['amount']);
            $this->db->set('date_used', mdate('%Y-%m-%d %H:%i:%s', time()));

            if ($this->db->insert('coupons_history')) {
                return $this->db->insert_id();
            }
        }
    }

    public function getCouponByCode($code) {
		$this->db->from('coupons');
		$this->db->where('code', $code);

		$query = $this->db->get();

		return $query->row_array();
	}


    public function addOrderTotals_api($order_id, $cart_contents , $tax){

     if($cart_contents['cart_total'] != ""){

    	$this->db->set('order_id', $order_id);
        $this->db->set('code', 'cart_total');
        $this->db->set('title', 'Sub Total');
        $this->db->set('priority', 1);
		$this->db->set('value', $cart_contents['cart_total']);
        $this->db->insert('order_totals');
    }

    if(!empty($cart_contents['coupon'])){

    	$this->db->set('order_id', $order_id);
        $this->db->set('code', 'coupon');
        $this->db->set('title', 'Coupon '.$cart_contents['coupon']['code']);
        $this->db->set('priority',2);
		$this->db->set('value', '-'.$cart_contents['coupon']['amount']);
        $this->db->insert('order_totals');
    }

    if(!empty($cart_contents['delivery_fee'])  && $cart_contents['delivery_fee'] > 0){

    	$this->db->set('order_id', $order_id);
        $this->db->set('code', 'delivery');
       	$this->db->set('title', 'Delivery Charge');
        $this->db->set('priority',3);
		$this->db->set('value', $cart_contents['delivery_fee']);
        $this->db->insert('order_totals');
    }

    if($cart_contents['taxes'] != ""){

    	foreach ($cart_contents['taxes']['tax_details'] as $key => $value) {
    		$this->db->set('order_id', $order_id);
	        $this->db->set('code', 'taxes');
	        $this->db->set('title', $value['tax_name'].' ('.$value['percentage'].'%)');
	        $this->db->set('priority', 4);
			$this->db->set('value', $value['tax_amount']);
	        $this->db->insert('order_totals');
    	}
    }

    if($cart_contents['order_total'] != ""){

    	$this->db->set('order_id', $order_id);
        $this->db->set('code', 'order_total');
        $this->db->set('title', 'Order Total');
        $this->db->set('priority',5);
		$this->db->set('value', $cart_contents['order_total']);
        $this->db->insert('order_totals');
    }

    /*if($cart_contents['tips_value'] != ""  && $cart_contents['tips_value'] > 0){

    	$this->db->set('order_id', $order_id);
        $this->db->set('code', 'tip');
        $this->db->set('title', 'Tip for Rider');
        $this->db->set('priority',6);
		$this->db->set('value', $cart_contents['tips_value']);
        $this->db->insert('order_totals');
    }

    if(!empty($cart_contents['pickup_fee']) && $cart_contents['pickup_fee'] > 0){

    	$this->db->set('order_id', $order_id);
        $this->db->set('code', 'pickup');
       	$this->db->set('title', 'Pickup Charge');
        $this->db->set('priority',7);
		$this->db->set('value', $cart_contents['pickup_fee']);
        $this->db->insert('order_totals');
    }*/
    	

    }

    public function addOrderHistory($object_id){

    	$this->db->set('object_id', $object_id);
    	$this->db->set('staff_id', 11);
    	$this->db->set('assignee_id', 11);
    	$this->db->set('status_id', 1);
    	$this->db->set('notify', 1);
    	$this->db->set('status_for', 'order');
    	$this->db->set('comment', 'Your order has been received.');
    	$this->db->set('date_added', date('Y-m-d h:i:s'));
    	$this->db->insert('status_history');
    
    }

    public function addReservationHistory($object_id,$id){
		$this->load->model('Statuses_model');

    	$status = $this->Statuses_model->getStatus($id);
    	$template_id = $this->getTemplateId($id);
        $player_id = $this->getPlayerId($add['customer_id']);
        $this->sendMessage($template_id,$player_id);

    	$this->db->set('object_id', $object_id);
    	$this->db->set('staff_id', 11);
    	$this->db->set('assignee_id', 11);
    	$this->db->set('status_id', $id);
    	$this->db->set('notify', 1);
    	$this->db->set('status_for', 'reserve');
    	$this->db->set('comment', $status['status_comment']);
    	$this->db->set('date_added', date('Y-m-d h:i:s'));
    	$this->db->insert('status_history');
    
    }

    public function addOrderMenus($order_id, $cart_contents = array()) {
    	
    	if (is_array($cart_contents) AND ! empty($cart_contents) AND $order_id) {
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_menus');
            foreach ($cart_contents as $key => $item) {

				
                if (is_array($item) AND $item['id'] > 0) {
                	$this->db->set('stock_qty', 'stock_qty-'.$item["qty"],FALSE);
					$this->db->where('menu_id',$item['id']);
					$this->db->update('menus');
					
                	//$item['price'] = $item['price']=="0.0000" ? $this->getOptionValuePrice($item['id']) : $item['price'] ;

                    if (isset($item['id'])) {
                        $this->db->set('menu_id', $item['id']);
                    }

                    if (isset($item['location_id'])) {
                        $this->db->set('location_id', $item['location_id']);
                    }

                    if (isset($item['name'])) {
                        $this->db->set('name', $item['name']);
                    }
                     if (isset($item['option_name'])) {
                        $this->db->set('option_name', $item['option_name']);
                    }

                    if (isset($item['option_value_name'])) {
                        $this->db->set('option_value_name', $item['option_value_name']);
                    }

                     if (isset($item['name_ar'])) {
                        $this->db->set('name_arabic', $item['name_ar']);
                    }

                    if (isset($item['qty'])) {
                        $this->db->set('quantity', $item['qty']);
                    }

                    if (isset($item['price'])) {
                        $this->db->set('price', $item['price']);
                    }

                    if (isset($item['subtotal'])) {
                        $this->db->set('subtotal', $item['subtotal']);
                    }

                    if (isset($item['comment'])) {
                        $this->db->set('comment', $item['comment']);
                    }

                    if ( ! empty($item['options'])) {
                        $this->db->set('option_values', serialize($item['options']));
                    }

                    $this->db->set('order_id', $order_id);

                    if ($query = $this->db->insert('order_menus')) {
                        $order_menu_id = $this->db->insert_id();
                        
                        //if ( ! empty($item['options']['menu_option_value_id'])) {
						if ( ! empty($item['options'])) {
                        	$this->addOrderMenuOptionsApi($order_menu_id, $order_id, $item['id'], $item['options']);
                        }
						if ( ! empty($item['variants'])) {
                        	$this->addOrderMenuVariantsApi($order_menu_id, $order_id, $item['id'], $item['variants']);
                        }
                    }
                }
            }
            
            
            return TRUE;
        }
    }

	public function addCardInfo($card_info = array(), $customer_email = ''){		

		if(!empty($card_info)){
			$this->db->set('customer_email', $customer_email);
			$this->db->set('stripe_card_token', $card_info['stripe_card_token']);
			$this->db->set('card_number', $card_info['card_number']);
			$this->db->set('card_exp_month', $card_info['card_exp_month']);
			$this->db->set('card_exp_year', $card_info['card_exp_year']);
			$this->db->set('card_name', $card_info['card_name']);
			$this->db->set('brand_name', $card_info['brand_name']);
			$this->db->set('date_added', date('Y-m-d h:i:s'));
			$this->db->set('status', '1');

			$this->db->insert('customer_credit_cards');
		}    
    }

    public function getOptionValuePrice($menu_id){

      $this->db->select('option_id');
      $this->db->from('menu_options');
      $this->db->where('menu_id',$menu_id);
      $query = $this->db->get();
      $option_id = $query->result_array()[0]['option_id'];
      if($query->num_rows() > 0)
      {
        $this->db->select('new_price');
        $this->db->from('menu_option_values');
        $this->db->where('option_id',$option_id);
        $this->db->where('menu_id',$menu_id);
        $query = $this->db->get();
        return $query->result_array()[0]['new_price'];
        
      }else{
        return "0.0000";
      }

  }
  
    public function addOrderTotals($order_id, $cart_contents) {
        if (is_numeric($order_id) AND ! empty($cart_contents['totals'])) {
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_totals');

            $this->load->model('cart_module/Cart_model');
            $order_totals = $this->Cart_model->getTotals();

            $cart_contents['totals']['cart_total']['amount'] = (isset($cart_contents['cart_total'])) ? $cart_contents['cart_total'] : '';
            $cart_contents['totals']['order_total']['amount'] = (isset($cart_contents['order_total'])) ? $cart_contents['order_total'] : '';

            foreach ($cart_contents['totals'] as $name => $total) {
                foreach ($order_totals as $total_name => $order_total) {
                    if ($name === $total_name AND is_numeric($total['amount'])) {
                        $total['title'] = empty($total['title']) ? $order_total['title'] : $total['title'];

                        if (isset($total['code'])) {
                            $total['title'] = str_replace('{coupon}', $total['code'], $total['title']);
                        } else if (isset($total['tax'])) {
                            $total['title'] = str_replace('{tax}', $total['tax'], $total['title']);
                        }

                        $this->db->set('order_id', $order_id);
                        $this->db->set('code', $name);
                        $this->db->set('title', htmlspecialchars($total['title']));
                        $this->db->set('priority', $order_total['priority']);

                        if ($name === 'coupon') {
                            $this->db->set('value', 0 - $total['amount']);
                        } else {
                            $this->db->set('value', $total['amount']);
                        }

                        $this->db->insert('order_totals');
                    }
                }
            }

            return TRUE;
        }
    }

    public function addOrderMenuOptions($order_menu_id, $order_id, $menu_id, $menu_options) {
        if ( ! empty($order_id) AND ! empty($menu_id) AND ! empty($menu_options)) {
            $this->db->where('order_menu_id', $order_menu_id);
            $this->db->where('order_id', $order_id);
            $this->db->where('menu_id', $menu_id);
            $this->db->delete('order_options');

            foreach ($menu_options as $menu_option_id => $options) {
                foreach ($options as $option) {
                    $this->db->set('order_menu_option_id', $menu_option_id);
                    $this->db->set('order_menu_id', $order_menu_id);
                    $this->db->set('order_id', $order_id);
                    $this->db->set('menu_id', $menu_id);
                    $this->db->set('menu_option_value_id', $option['value_id']);
                    $this->db->set('order_option_name', $option['value_name']);
                    $this->db->set('order_option_price', $option['value_price']);

                    $this->db->insert('order_options');
                }
            }
        }
    }

    public function addOrderMenuOptionsApi($order_menu_id, $order_id, $menu_id, $menu_options) {
		
    	if ( ! empty($order_id) AND ! empty($menu_id) AND ! empty($menu_options)) {
        	
            $this->db->where('order_menu_id', $order_menu_id);
            $this->db->where('order_id', $order_id);
            $this->db->where('menu_id', $menu_id);
            $this->db->delete('order_options');
			
			foreach ($menu_options as $key_menu => $value_menu) {
				$option_details = $this->getOptionDetailsData($value_menu['menu_option_value_id']);
				$sub_option_details = $this->getOptionDetailsData($value_menu['menu_option_value_id']);
				
				$this->db->set('order_menu_option_id', $value_menu['menu_option_id']);
				$this->db->set('order_menu_id', $order_menu_id);
				$this->db->set('order_id', $order_id);
				$this->db->set('menu_id', $menu_id);
				$this->db->set('menu_option_value_id', $value_menu['menu_option_value_id']);
				if(!empty($option_details)){
					$this->db->set('order_option_name', $option_details['value']);
					$this->db->set('order_sub_option_name', $sub_option_details['value']);
					$this->db->set('order_option_price', $option_details['new_price']);
				}
				$this->db->insert('order_options');
			}
            /*foreach ($menu_options as $key => $options) {
                foreach ($options['option_values'] as $key1 => $option) {
                	
                }
            }*/
        }
    }

	public function addOrderMenuVariantsApi($order_menu_id, $order_id, $menu_id, $menu_variants) {
		
    	if ( ! empty($order_id) AND ! empty($menu_id) AND ! empty($menu_variants)) {        	
            $this->db->where('order_id', $order_id);
            $this->db->where('menu_id', $menu_id);
			$this->db->where('order_menu_id', $order_menu_id);
            $this->db->delete('order_variants');
			
			if(!empty($menu_variants)){
				foreach ($menu_variants as $key_menu => $value_menu) {
					$this->db->set('order_id', $order_id);
					$this->db->set('menu_id', $menu_id);
					$this->db->set('order_menu_id', $order_menu_id);
					$this->db->set('variant_type_id', $value_menu['variant_type_id']);
					$this->db->set('variant_type_value_id', $value_menu['variant_type_value_id']);
					$this->db->set('variant_type_name', $value_menu['variant_type_name']);
					$this->db->set('variant_type_value_name', $value_menu['variant_type_value_name']);
					$this->db->set('price', $value_menu['price']);
	
					$this->db->insert('order_variants');
				}
			}			
        }
    }

    public function getOptionDetailsData($id){

    	$this->db->select('*');
		$this->db->from('option_values');
		$this->db->join('menu_option_values','menu_option_values.option_value_id = option_values.option_value_id');
		$this->db->where('option_values.option_value_id',$id);
		$query = $this->db->get();
		if(!empty($query->result_array()[0])){
			return $query->result_array()[0];
		}else{
			return array();
		}
    }

	public function generateReservationNumber($location_id){
		
		$this->db->select('location_name');
		$this->db->from('locations');
		$this->db->where('location_id',$location_id);
		$query = $this->db->get();
		$name = $query->result_array()[0]['location_name'];

		$last_id = $this->db->query('SELECT MAX(id) AS `maxid` FROM `yvdnsddqu_reservations`')->row()->maxid;		

		$this->db->select('reservation_id');
		$this->db->from('reservations');
		$this->db->where('id',$last_id);
		$query = $this->db->get();
		$last_code = $query->result_array()[0]['reservation_id'];
		if(strlen($last_code) >= 11){
			$maxid = (int) substr($last_code,4,7) + 1;
		}else{
			$maxid = $last_code + 1;
		}
		$split = str_split($name,3);
		$prefix = strtoupper($split[0]);
		$reservation_id = $prefix.'-'.str_pad($maxid,7,"0",STR_PAD_LEFT);
		return $reservation_id;


	}

	public function generateOtp($location_id){
		
		$this->db->select('location_name');
		$this->db->from('locations');
		$this->db->where('location_id',$location_id);
		$query = $this->db->get();
		$name = $query->result_array()[0]['location_name'];

		$split = str_split($name,3);
		$prefix = strtoupper($split[0]);
		$i=1;
		$j=1;
		while($i==$j){
			$otp = $prefix.rand(111111,999999);

			$this->db->select('otp');
			$this->db->from('reservations');
			$this->db->where('otp',$otp);
			$query = $this->db->get();
			if($query->num_rows() == 0) {
				$j=2;
			}
		}
		return $otp;


	}

	public function getMailData($reservation_id) {
		$data = array();

		$result = $this->getReservation($reservation_id);

			if ($result) {
			// $this->load->library('country');

			$data['reservation_number'] = $result['reservation_id'];
			$data['reservation_view_url'] = $this->config->base_url('main/reservations?id=' . $result['reservation_id']);
			$data['reservation_time'] = mdate('%H:%i', strtotime($result['reserve_time']));
			$data['reservation_date'] = mdate('%l, %F %j, %Y', strtotime($result['reserve_date']));
			$data['reservation_guest_no'] = $result['guest_num'];
			$data['first_name'] = $result['first_name'];
			$data['last_name'] = $result['last_name'];
			$data['email'] = $result['email'];
			$data['otp'] = $result['otp'];
			$data['telephone'] = $result['telephone'];
			$data['location_name'] = $result['location_name'];
			$data['reservation_comment'] = $result['comment'];
			$data['staff_telephone'] = $result['staff_telephone'];
		}

		return $data;
	}

	public function sendMail($email, $mail_template = array(), $mail_data = array()) {
		if (empty($mail_template) OR !isset($mail_template['subject'], $mail_template['body']) OR empty($mail_data)) {
			return FALSE;
		}

		$this->load->library('email');

		$this->email->initialize();

		if (!empty($mail_data['status_comment'])) {
			$mail_data['status_comment'] = $this->email->parse_template($mail_data['status_comment'], $mail_data);
		}
		$this->email->from($this->GetTable('settings','item = "site_email"'), $this->GetTable('settings','item = "site_name"'));

		$this->email->to(strtolower($email));
		$this->email->subject($mail_template['subject'], $mail_data);
		$this->email->message($mail_template['body'], $mail_data);

		if ( ! $this->email->send()) {
			log_message('debug', $this->email->print_debugger(array('headers')));
			$notify = '0';
		} else {
			$notify = '1';
		}

		return $notify;
	}

	public function getMenuDetails($id) {
		
		$this->db->select('*');
		$this->db->from('menus');
		$this->db->where('menu_id', $id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array()[0];
		}else{
			return array();
		}
		
	}

	public function validateReservation($reservation_id) {
		if ( ! empty($reservation_id)) {
			$this->db->from('reservations');
			$this->db->where('reservation_id', $reservation_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}


	public function check_reservation_exists($customer_id) {

    $this->db->from('reservations');
    $this->db->where('customer_id', $customer_id);
    $query = $this->db->get();
    return $query->num_rows();
    
    }


	public function deleteReservation($reservation_id) {
		if (is_numeric($reservation_id)) $reservation_id = array($reservation_id);

		if ( ! empty($reservation_id) AND ctype_digit(implode('', $reservation_id))) {
			$this->db->where_in('reservation_id', $reservation_id);
			$this->db->delete('reservations');

			return $this->db->affected_rows();
		}
	}

	public function getReservationid($reservation_id) {
		$this->db->select('id,order_id');
		$this->db->from('reservations');
		$this->db->where('reservation_id', $reservation_id);
		$query = $this->db->get();
		$id = $query->row(); 
		return $id;
	}

	public function getFaq(){

		
		$this->db->from('faq');
		$query = $this->db->get();

		return $query->result_array();



	}

	public function GetTable($tablename,$condition=''){
 
		$this->db->select('*');
		$this->db->from($tablename);
		if($condition!="") {
			$this->db->where($condition);
		}	
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			return $result[0]['value'];
			//print_r($result);
			//return $result;
		} else {
		 return FALSE;
		}
	}

	public function GetTable_all($tablename,$condition=''){
 
		$this->db->select('*');
		$this->db->from($tablename);
		if($condition!="") {
			$this->db->where($condition);
		}	
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			//print_r($result);
			return $result;
		} else {
		 return FALSE;
		}
	}
	public function admincommissioninsert($total_booking_amount,$total_amount_received,$order_no,$transaction_id){
		$payment_date = date("Y-m-d H:i:s");
		$this->db->set('total_booking_amount', $total_booking_amount);
		$this->db->set('total_amount_received', $total_amount_received);
		$this->db->set('payment_date', $payment_date);
		$this->db->set('payment_transaction_id', $transaction_id);
		$this->db->set('receipt_no', $order_no);
		$this->db->insert('admin_payments');
		return true;
	}

	public function getLocation($id=null){
		$this->db->select('*');
		$this->db->from('locations');
		
			$this->db->where('location_id',$id);
			
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->row_array();
			//print_r($result);
			return $result;
		} else {
		 return FALSE;
		}
	}

	public function getOrderMenu($id=null){
		$this->db->select('*');
		$this->db->from('order_menus');
		
		$this->db->where('order_id',$id);
			
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			//print_r($result);
			return $result;
		} else {
		 return FALSE;
		}
	}

	public function getstaff($id){
		$this->db->select('*');
		$this->db->from('staffs');
		
		$this->db->where('staff_id',$id);
			
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$result = $query->result_array()[0];
			//print_r($result);
			return $result;
		} else {
		 return FALSE;
		}
	}
	
}

/* End of file reservations_model.php */
