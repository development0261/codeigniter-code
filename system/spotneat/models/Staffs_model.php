<?php
/**
 * SpotnEat
 *
 * 
 *
 * @package   SpotnEat
 * @author    Sp
 * @copyright SpotnEat
 * @link      http://spotneat.com
 * @license   http://spotneat.com
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Staffs Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Staffs_model.php
 * @link           http://docs.spotneat.com
 */
class Staffs_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('staff_name', $filter['filter_search']);
			$this->db->or_like('location_name', $filter['filter_search']);
			$this->db->or_like('staff_email', $filter['filter_search']);
		}

		if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
			$this->db->where('staff_group_id', $filter['filter_group']);
		}

		if ( ! empty($filter['filter_location'])) {
			$this->db->where('staffs.staff_location_id', $filter['filter_location']);
		}

		if ( ! empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('staff_status', $filter['filter_status']);
		}

		$this->db->from('staffs');
		$this->db->join('locations', 'locations.location_id = staffs.staff_location_id', 'left');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('staffs.staff_id, staff_name, staff_email, staff_telephone, staff_group_name, location_name,date_added, staff_status');
			$this->db->from('staffs');
			$this->db->join('users', 'users.staff_id = staffs.staff_id', 'left');
			$this->db->join('staff_groups', 'staff_groups.staff_group_id = staffs.staff_group_id', 'left');
			$this->db->join('locations', 'locations.location_id = staffs.staff_location_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('staff_name', $filter['filter_search']);
				$this->db->or_like('location_name', $filter['filter_search']);
				$this->db->or_like('staff_email', $filter['filter_search']);
			}

			if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
				$this->db->where('staffs.staff_group_id', $filter['filter_group']);
			}

			if ( ! empty($filter['filter_location'])) {
				$this->db->where('staffs.staff_location_id', $filter['filter_location']);
			}

			if ( ! empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('staff_status', $filter['filter_status']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
			return $result;
		}
	}

	public function getStaffs() {
		$this->db->from('staffs');
		$this->db->where('staff_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStaffLocation($data = array()) {
		$this->db->from('staffs');
		$this->db->where('staff_location_id', $data['staff_location_id']);
		$this->db->where('staff_id !=', $data['staff_id']);

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStaff($staff_id = FALSE) {
		$this->db->from('staffs');

		$this->db->where('staff_id', $staff_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getStaffUser($staff_id = FALSE) {
		$this->db->from('users');

		$this->db->where('staff_id', $staff_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getStaffDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('staffs');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStaffsForMessages($type) {
		$this->db->select('staff_id, staff_email, staff_status');
		$this->db->from('staffs');
		$this->db->where('staff_status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)
				$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
		}

		return $result;
	}

	public function getStaffForMessages($type, $staff_id = FALSE) {
		if ( ! empty($staff_id) AND is_array($staff_id)) {
			$this->db->select('staff_id, staff_email, staff_status');
			$this->db->from('staffs');
			$this->db->where_in('staff_id', $staff_id);
			$this->db->where('staff_status', '1');

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
			}

			return $result;
		}
	}

	public function getStaffsByGroupIdForMessages($type, $staff_group_id = FALSE) {
		if (is_numeric($staff_group_id)) {
			$this->db->select('staff_id, staff_email, staff_group_id, staff_status');
			$this->db->from('staffs');
			$this->db->where('staff_group_id', $staff_group_id);
			$this->db->where('staff_status', '1');

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
					$result[] = ($type === 'email') ? $row['staff_email'] : $row['staff_id'];
			}

			return $result;
		}
	}

	public function getAutoComplete($filter = array()) {
		if (is_array($filter) AND ! empty($filter)) {
			$this->db->from('staffs');

			if ( ! empty($filter['staff_name'])) {
				$this->db->like('staff_name', $filter['staff_name']);
			}

			if ( ! empty($filter_data['staff_id'])) {
				$this->db->where('staff_id', $filter_data['staff_id']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function saveStaff($staff_id, $save = array(),$save1 = array()) {


		//echo "<pre/>";print_r($save);exit;
		if (empty($save)) return FALSE;

		$staff_permissions = array();

		foreach($save['permission_name'] as $val){
			$staff_permissions[$val] = $save[$val.'_view'];
		}

		$this->db->set('staff_permissions', serialize($staff_permissions));

		require_once(BASEPATH.'libraries/stripe/init.php');
		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
		\Stripe\Stripe::setApiVersion($this->config->item('stripe_version'));
		$this->load->model('Image_tool_model');
		$file1 = new stdClass();
		$file2 = new stdClass();
		if($this->input->post('front_doc') != '') {
			$data['menu_image'] = $this->input->post('front_doc');
			$data['image_name'] = basename($this->input->post('front_doc'));
			$data['menu_image_url'] = $this->Image_tool_model->resize($this->input->post('front_doc'));
			$fp1 = fopen(IMAGEPATH.'data/'.$data['image_name'], 'r');
			$fp2 = fopen(IMAGEPATH.'data/'.$data['image_name'], 'r');
			$file1 = \Stripe\File::create([
				'purpose' => 'identity_document',
				'file' => $fp1
			]);
			$file2 = \Stripe\File::create([
				'purpose' => 'identity_document',
				'file' => $fp2
			]);	
		} else {

			$file1->id = $this->input->post('frontdoc_hi');
			$file2->id = $this->input->post('backdoc_hi');
		}
		
		
		if($this->input->post('stripe_business_type') == 1 && $this->input->post('account_id') == '' ) {
			try{
			$acc = \Stripe\Account::create([
		  "type" => "custom",
		  "country" => "US",
		  "email" => $this->input->post('staff_email'),
		  "requested_capabilities" => ["card_payments", "transfers"],
		  'business_type' => 'individual',
		  'business_profile' => [
				'url' => $this->input->post('business_url'),
				'mcc' => $this->input->post('business_mcc')
			],
			'individual' => [						
				  		'address' => [
				  		'city' => $this->input->post('city'),
				  		'country' => 'US',
				  		//'country' => $this->input->post('country'),
				  		'line1' => $this->input->post('line1'),
				  		'postal_code' => $this->input->post('postal_code'),
				  		'state' => $this->input->post('state'),
				  		],
				  		'dob' => [
							'day' => $this->input->post('dob_day'),
							'month' => $this->input->post('dob_month'),
							'year' => $this->input->post('dob_year')
							],
						'email' => $this->input->post('staff_email'),
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'gender' => $this->input->post('gender'),
						'ssn_last_4' => $this->input->post('last_4_ssn'),
						'phone' => $this->input->post('telephone'),
						'verification' => [
					  		'document' => [
					  			'back' => $file1->id,
					  			'front' => $file2->id
					  		]
				  		]
					  ],
			'external_account' => [
				'object' => 'bank_account',
				'country' => 'US',
				'currency' => 'USD',
				'routing_number' => $this->input->post('routing_number'),
				'account_number' => $this->input->post('account_number')
			], 
			'tos_acceptance' => [
		      'date' => time(),
		      'ip' => $_SERVER['REMOTE_ADDR']
		    ]
		]);
		$acc_id = $acc->id;	
		$save1['stripe_account_id'] = $acc->id;
		$save1['stripe_response_data'] = serialize($acc->toJSON());
		$save1['stripe_business_type'] = '1';
		}  catch (\Stripe\Exception\InvalidRequestException $e) {
			
			 $body = $e->getJsonBody();
  			$this->alert->set('error', sprintf($body['error']['message']));
  			return FALSE;
			}
		} elseif($this->input->post('stripe_business_type') == 2 && $this->input->post('account_id') == ''){
			try {
				$acc = \Stripe\Account::create([
		  "type" => "custom",
		  "country" => "US",
		  "email" => $this->input->post('staff_email'),
		  "requested_capabilities" => ["card_payments", "transfers"],
		  'business_type' => 'company',
		  	'business_profile' => [
				'mcc' => $this->input->post('business_mcc'),
				'url' => $this->input->post('business_url')
			],  
			'company' => [
						'name' => $this->input->post('first_name'),
						'phone' => $this->input->post('telephone'),
						'tax_id' => $this->input->post('tax_id'),
				  		'address' => [
				  		'city' => $this->input->post('city'),
				  		'country' => 'US',
				  		// 'country' => $this->input->post('country'),
				  		'line1' => $this->input->post('line1'),
				  		'postal_code' => $this->input->post('postal_code'),
				  		'state' => $this->input->post('state')					
				  		]
					  ],  
				  	
		  	'external_account' => [
				'object' => 'bank_account',
				'country' => 'US',
				'currency' => 'USD',
				'routing_number' => $this->input->post('routing_number'),
				'account_number' => $this->input->post('account_number')
			], 
			'tos_acceptance' => [
		      'date' => time(),
		      'ip' => $_SERVER['REMOTE_ADDR']
		    ]
		]);
		$acc_id = $acc->id;
		$save1['stripe_account_id'] = $acc->id;
		$save1['stripe_response_data'] = serialize($acc);
		$save1['stripe_business_type'] = '2';
		$aa1 = \Stripe\Account::createPerson(
			  $acc_id,
			  [
			    'first_name' => $this->input->post('first_name'),
			    'last_name' => $this->input->post('last_name'),
			    'ssn_last_4' => $this->input->post('last_4_ssn'),
				'email' => $this->input->post('staff_email'),
				'phone' => $this->input->post('telephone'),
			    'relationship' => [	
				'account_opener' => true,
				'director' => true,
				'executive' => true,
				'owner' => true,
				'percent_ownership' => '100',
				'title' => 'Owner'
				], 
				'dob' => [
					'day' => $this->input->post('dob_day'),
					'month' => $this->input->post('dob_month'),
					'year' => $this->input->post('dob_year')
					],
				'email' => $this->input->post('staff_email'),
				'phone' => $this->input->post('telephone'),
				'address' => [
				  		'city' => $this->input->post('city'),
				  		'country' => 'US',
				  		// 'country' => $this->input->post('country'),
				  		'line1' => $this->input->post('line1'),
				  		'postal_code' => $this->input->post('postal_code'),
				  		'state' => $this->input->post('state')					
				  		],
				  		'verification' => [
		  		'document' => [
		  			'back' => $file1->id,
		  			'front' => $file2->id
		  		]
		  	]
			]);
		$acc_id = $acc->id;	
		$save1['stripe_account_id'] = $acc->id;
		$save1['stripe_response_data'] = serialize($acc->toJSON());
		$save1['stripe_business_type'] = '2';
		$save1['tax_id'] = $save['tax_id'];
		}catch (\Stripe\Exception\InvalidRequestException $e) {
			
			 $body = $e->getJsonBody();
  			$this->alert->set('error', sprintf($body['error']['message']));
  			return FALSE;
			}
		}

		if($this->input->post('stripe_business_type') == 1 && $this->input->post('account_id') != '' ) {
			try {
			$acc = \Stripe\Account::update(
			$this->input->post('account_id'),
			[[
				'business_profile' => [
				'url' => $this->input->post('business_url'),
				'mcc' => $this->input->post('business_mcc')
					],
					'individual' => [						
				  		'address' => [
				  		'city' => $this->input->post('city'),
				  		'country' => 'US',
				  		//'country' => $this->input->post('country'),
				  		'line1' => $this->input->post('line1'),
				  		'postal_code' => $this->input->post('postal_code'),
				  		'state' => $this->input->post('state'),
				  		],
				  		'dob' => [
							'day' => $this->input->post('dob_day'),
							'month' => $this->input->post('dob_month'),
							'year' => $this->input->post('dob_year')
							],
						'email' => $this->input->post('staff_email'),
						// 'first_name' => $this->input->post('first_name'),
						// 'last_name' => $this->input->post('last_name'),
						'gender' => $this->input->post('gender'),
						// 'ssn_last_4' => $this->input->post('last_4_ssn'),
						'phone' => $this->input->post('telephone'),
						// 'verification' => [
					 //  		'document' => [
					 //  			'back' => $file1->id,
					 //  			'front' => $file2->id
					 //  		]
				  // 		]
					  ],
			'external_account' => [
				'object' => 'bank_account',
				'country' => 'US',
				'currency' => 'USD',
				'routing_number' => $this->input->post('routing_number'),
				'account_number' => $this->input->post('account_number')
			],
		  	]]);
		$acc_id = $acc->id;	
		// echo $acc_id;
		// 	exit;
		$save1['stripe_account_id'] = $acc->id;
		$save1['stripe_response_data'] = serialize($acc->toJSON());
		$save1['stripe_business_type'] = '1';
		} catch (\Stripe\Exception\InvalidRequestException $e) {
			
			 $body = $e->getJsonBody();
  			$this->alert->set('error', sprintf($body['error']['message']));
  			return FALSE;
			}
		} elseif($this->input->post('stripe_business_type') == 2 && $this->input->post('account_id') != '' ) {
			try {
				$acc = \Stripe\Account::update(
				$this->input->post('account_id'),
				[[

		  	'business_profile' => [
				'mcc' => $this->input->post('business_mcc'),
				'url' => $this->input->post('business_url')
			],  
			'company' => [
						'name' => $this->input->post('first_name'),
						'phone' => $this->input->post('telephone'),
						//'tax_id' => $this->input->post('tax_id'),
				  		'address' => [
				  		'city' => $this->input->post('city'),
				  		'country' => 'US',
				  		// 'country' => $this->input->post('country'),
				  		'line1' => $this->input->post('line1'),
				  		'postal_code' => $this->input->post('postal_code'),
				  		'state' => $this->input->post('state')					
				  		]
					  ],  
				  	
		  	'external_account' => [
				'object' => 'bank_account',
				'country' => 'US',
				'currency' => 'USD',
				'routing_number' => $this->input->post('routing_number'),
				'account_number' => $this->input->post('account_number')
			], 
			]]);

			$per=\Stripe\Account::updatePerson(
			  $this->input->post('account_id'),
			  $this->input->post('person_id'),
			  [[
			    'first_name' => $this->input->post('first_name'),
			    'last_name' => $this->input->post('last_name'),
			    'ssn_last_4' => $this->input->post('last_4_ssn'),
				'email' => $this->input->post('staff_email'),
				'phone' => $this->input->post('telephone'),
			    'relationship' => [	
				'account_opener' => true,
				'director' => true,
				'executive' => true,
				'owner' => true,
				'percent_ownership' => '100',
				'title' => 'Owner'
				], 
				'dob' => [
					'day' => $this->input->post('dob_day'),
					'month' => $this->input->post('dob_month'),
					'year' => $this->input->post('dob_year')
					],
				'email' => $this->input->post('staff_email'),
				'phone' => $this->input->post('telephone'),
				'address' => [
				  		'city' => $this->input->post('city'),
				  		'country' => 'US',
				  		// 'country' => $this->input->post('country'),
				  		'line1' => $this->input->post('line1'),
				  		'postal_code' => $this->input->post('postal_code'),
				  		'state' => $this->input->post('state')					
				  		],
				// 'verification' => [
		  // 		'document' => [
		  // 			'back' => $file1->id,
		  // 			'front' => $file2->id
		  // 		]
		  // 	]
			]]);

		$acc_id = $acc->id;	
		$save1['stripe_account_id'] = $acc->id;
		$save1['stripe_response_data'] = serialize($acc->toJSON());
		$save1['stripe_business_type'] = '2';
		$save1['tax_id'] = $save['tax_id'];
		}catch (\Stripe\Exception\InvalidRequestException $e) {
			
			 $body = $e->getJsonBody();
  			$this->alert->set('error', sprintf($body['error']['message']));
  			return FALSE;
			}
		}
		// echo '<pre>';
		// print_r($acc);
		// exit;
		if (isset($save['staff_name'])) {
			$this->db->set('staff_name', $save['staff_name']);
		}

		if (isset($save['staff_email'])) {
			$this->db->set('staff_email', strtolower($save['staff_email']));
		}

		if (isset($save['telephone'])) {
			$this->db->set('staff_telephone', $save['country_code'].'-'.$save['telephone']);
		}

		if (isset($save['telephone'])) {
			$this->db->set('staff_telephone', $save['country_code'].'-'.$save['telephone']);
		}

		if (isset($save['staff_group_id'])) {
			$this->db->set('staff_group_id', $save['staff_group_id']);
		}

		if (isset($save['staff_location_id'])) {
			$this->db->set('staff_location_id', $save['staff_location_id']);
		}

		if (isset($save1['stripe_business_type'])) {
			$this->db->set('stripe_business_type', $save1['stripe_business_type']);
		}

		if (isset($save1['tax_id'])) {
			$this->db->set('tax_id', $save1['tax_id']);
		}

		if (isset($save1['stripe_account_id'])) {
			$this->db->set('stripe_account_id', $save1['stripe_account_id']);
		}

		if (isset($save1['stripe_response_data'])) {
			$this->db->set('stripe_response_data', $save1['stripe_response_data']);
		}

		if (isset($save['last_4_ssn'])) {
			$this->db->set('last4_ssn', $save['last_4_ssn']);
		}

		if (isset($save['routing_number'])) {
			$this->db->set('routing_number', $save['routing_number']);
		}

		if (isset($save['account_number'])) {
			$this->db->set('account_number', $save['account_number']);
		}

		if (isset($save['commission'])) {
			$this->db->set('commission', $save['commission']);
		}

		if (isset($save['delivery_commission'])) {
			$this->db->set('delivery_commission', $save['delivery_commission']);
		}

		if (isset($save['staff_status']) AND $save['staff_status'] === '1') {
			$this->db->set('staff_status', $save['staff_status']);
		} else {
			$this->db->set('staff_status', '0');
		}
		
		$payment['payment_type'] 			= $save['payment_type'];
		$payment['payment_username'] 		= $save['payment_username'];
		$payment['payment_password'] 		= $save['payment_password'];
		$payment['merchant_id'] 			= $save['merchant_id'];
		$payment['payment_key'] 			= $save['payment_key'];
		
		if ($payment != '') {
			$this->db->set('payment_details', serialize($payment));
		} else {
			$this->db->set('payment_details', '');
		}

		if (is_numeric($staff_id)) {
			$_action = 'updated';
			$this->db->where('staff_id', $staff_id);
			$query = $this->db->update('staffs');
			//print_r($this->db->last_query());exit;


		} else {

			$_action = 'added';
			$this->db->set('date_added', mdate('%Y-%m-%d', time()));
			$query = $this->db->insert('staffs');
			$staff_id = $this->db->insert_id();
		}
		/*$this->db->set('added_by',$staff_id  );
		$this->db->where('location_id', $save['staff_location_id']);
		$query = $this->db->update('locations');*/

		if ($query === TRUE AND is_numeric($staff_id)) {
			if ( ! empty($save['password'])) {
				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($save['password']))));
			}
				if ($_action === 'added' AND ! empty($save['username'])) {
					$this->db->set('username', strtolower($save['username']));
					$this->db->set('staff_id', $staff_id);
					$query = $this->db->insert('users');
				} else {
					$this->db->set('username', strtolower($save['username']));
					$this->db->where('staff_id', $staff_id);
					$query = $this->db->update('users');
				}
				
				$dataToThemes=array(
					'site_color'=>$save['site_color'],
					'added_by'=>$this->session->user_info['user_id']
			   );
			   if($this->session->site_logoname){
				$dataToThemes['logo']=$this->session->site_logoname;
			   }
			   $isThemeSql=$this->db->get_where('theme_color',array('staff_id'=>$this->input->get('id')));
			   if($isThemeSql->num_rows()>0){
			 	$this->db->update('theme_color',$dataToThemes,array('staff_id'=>$this->input->get('id')));
			   }else{
				    $dataToThemes['staff_id']=$this->input->get('id');
					$this->db->insert('theme_color',$dataToThemes);
				}
				$this->session->unset_userdata('site_logoname');
				
			return ($query === TRUE AND is_numeric($staff_id)) ? $staff_id : FALSE;
		}
	}

	public function resetPassword($user_email = NULL) {
		if ( ! empty($user_email)) {
			$this->db->select('staffs.staff_id, staffs.staff_email, staffs.staff_name, users.username');
			$this->db->from('staffs');
			$this->db->join('users', 'users.staff_id = staffs.staff_id', 'left');
			$this->db->where('staffs.staff_email', $user_email);
			$this->db->or_where('users.username', $user_email);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				//Randome Password
				$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
				$pass = array();
				for ($i = 0; $i < 8; $i ++) {
					$n = rand(0, strlen($alphabet) - 1);
					$pass[$i] = $alphabet[$n];
				}

				$password = implode('', $pass);
				$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
				$this->db->set('password', sha1($salt . sha1($salt . sha1($password))));
				$this->db->where('staff_id', $row['staff_id']);

				if ($this->db->update('users') AND $this->db->affected_rows() > 0) {
					$mail_data['staff_name'] = $row['staff_name'];
					$mail_data['staff_username'] = $row['username'];
					$mail_data['created_password'] = $password;

					$this->load->model('Mail_templates_model');
					$mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'),
					                                                              'password_reset_alert');

					if ($this->sendMail($row['staff_email'], $mail_template, $mail_data)) {
						return TRUE;
					}
				}
			}
		}

		return FALSE;
	}

	public function deleteStaff($staff_id) {
		if (is_numeric($staff_id)) $staff_id = array($staff_id);

		if ( ! empty($staff_id) AND ctype_digit(implode('', $staff_id))) {
			$this->db->where_in('staff_id', $staff_id);
			$this->db->delete('staffs');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('staff_id', $staff_id);
				$this->db->delete('users');

				return $affected_rows;
			}
		}
	}

	public function sendMail($email, $template, $data = array()) {
		$this->load->library('email');

		$this->email->initialize();

		$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
		$this->email->to(strtolower($email));
		$this->email->subject($template['subject'], $data);
		$this->email->message($template['body'], $data);

		if ($this->email->send()) {
			return TRUE;
		} else {
			log_message('debug', $this->email->print_debugger(array('headers')));
		}
	}

	public function validateStaff($customer_id = NULL) {
		if (!empty($customer_id)) {
			$this->db->from('staffs');

			if (is_numeric($customer_id)) {
				$this->db->where('staff_id', $customer_id);
			} else {
				$this->db->where('staff_email', $customer_id);
			}

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}

	public function pp_payment($tablename,$order_id = NULL,$name) {
		 if (!empty($order_id)) {
			$this->db->from($tablename);
			$this->db->where($name, $order_id);
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}
		 }

		return FALSE;
	}

	public function GetreserveCustomer($reservation_id) {
		$this->db->select('*','customers.first_name');
		$this->db->from('reservations');
		$this->db->join('customers','customers.customer_id = reservations.customer_id','left');
		$this->db->where('reservation_id',$reservation_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->row();
		}
	}
	public function getThemesBasedOnUsers($staff_id)
	{
		return $this->db->select('staff_id,logo,site_color,added_date')
				->get_where('theme_color',array('staff_id'=>$staff_id));
	}
}

/* End of file staffs_model.php */
/* Location: ./system/spotneat/models/staffs_model.php */