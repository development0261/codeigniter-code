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
 * Trainer Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Staff_groups_model.php
 * @link           http://docs.spotneat.com
 */
class PersonalTrainers_model extends CI_Model {

	public function __construct() {
        parent::__construct();

        //load database library
        $this->load->database();
    }
	/*
	* Check Email exists or not
	*/
	public function check_email_exists($email = '', $trainer_id = '') {

		$this->db->select('trainer_id');
		$this->db->from('trainers');
		$this->db->where('email', $email);
		$this->db->where('trainer_id !=', $trainer_id);
		$query = $this->db->get();
		return $query->num_rows();

	}

	/*Save personal trainer details*/
	public function savePersonalTrainer($trainer_id, $save = array()) {

		if (empty($save)) return FALSE;

		if (!empty($save['first_name'])) {
			$this->db->set('first_name', $save['first_name']);
		}

		if (!empty($save['last_name'])) {
			$this->db->set('last_name', $save['last_name']);
		}

		if (!empty($save['email'])) {
			$this->db->set('email', strtolower($save['email']));
		}

		if (!empty($save['password'])) {
			$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
			$this->db->set('password', sha1($salt . sha1($salt . sha1($save['password']))));
		}

		if (!empty($save['date_added'])) {
			$this->db->set('date_added', $save['date_added']);
		}

		if (!empty($save['about_trainer'])) {
			$this->db->set('about_trainer', $save['about_trainer']);
		}

		// if (!empty($save['device_time_zone'])) {
		// 	$this->db->set('device_time_zone', $save['device_time_zone']);
		// }

		if (!empty($save['business_type'])) {
			$this->db->set('business_type', $save['business_type']);
		}
		if (!empty($save['business_name'])) {
			$this->db->set('business_name', $save['business_name']);
		}
		if (!empty($save['about_trainer'])) {
			$this->db->set('about_trainer', $save['about_trainer']);
		}
		if (!empty($save['country'])) {
			$this->db->set('country', $save['country']);
		}
		if (!empty($save['city'])) {
			$this->db->set('city', $save['city']);
		}
		if (isset($save['profile_picture'])) {
			$this->db->set('profile_picture', $save['profile_picture']);
		}
		if (isset($save['main_image'])) {
			$this->db->set('main_image', $save['main_image']);
		}
		if (isset($save['status'])) {
			$this->db->set('status', $save['status']);
		}
		if (isset($save['user_type'])) {
			$this->db->set('user_type', $save['user_type']);
		}
		if (isset($save['timezone'])) {
			$this->db->set('timezone', $save['timezone']);
		}
		if (isset($save['deviceid'])) {
			$this->db->set('deviceid', $save['deviceid']);
		}
		if (isset($save['deviceInfo'])) {
			$this->db->set('deviceInfo', $save['deviceInfo']);
		}
		if (is_numeric($trainer_id)) {
			$action = 'updated';
			$this->db->where('trainer_id', $trainer_id);
			$query = $this->db->update('trainers');
			return $trainer_id;
			exit;
		} else {
			$action = 'added';
			$query = $this->db->insert('trainers');
			$customer_id = $this->db->insert_id();
			return $customer_id;
			exit;
		}

	}

	/*
	* Check Email exists or not
	*/
	public function check_trainer_exists($trainer_id = '') {
		$this->db->from('trainers');
		$this->db->where('trainer_id', $trainer_id);
		$this->db->where('user_type', 'PersonalTrainer');
		$query = $this->db->get();
		return $query->num_rows();
	}

	/* timezones list */
	public function time_zones()
	{
		$this->db->from('time_zones');
		$query = $this->db->get();
		return $query->result();
	}

	/* profile details */
	public function personal_trainer_profile_details($trainer_id = '')
	{
		$this->db->from('trainers');
		$this->db->where('trainer_id', $trainer_id);
		$this->db->where('user_type', 'PersonalTrainer');
		$query = $this->db->get();
		return $query->row_array();
	}

	/*trial plan add entry*/
	public function savePlanPurchase($package_purchase_id = '', $save = array())
	{
		if (empty($save)) return FALSE;

		if (isset($save['stripe_customer_id'])) {
			$this->db->set('stripe_customer_id', $save['stripe_customer_id']);
		}

		if (isset($save['trainer_email'])) {
			$this->db->set('trainer_email', $save['trainer_email']);
		}

		if (isset($save['subscription_id'])) {
			$this->db->set('subscription_id', $save['subscription_id']);
		}	

		if (isset($save['is_active'])) {
			$this->db->set('is_active', $save['is_active']);
		}

		if (isset($save['package_id'])) {
			$this->db->set('package_id', $save['package_id']);
		}	

		if (isset($save['package_price'])) {
			$this->db->set('package_price', $save['package_price']);
		}

		if (isset($save['subscription_end_date'])) {
			$this->db->set('subscription_end_date', $save['subscription_end_date']);
		}

		if (isset($save['subscription_start_date'])) {
			$this->db->set('subscription_start_date', $save['subscription_start_date']);
		}

		if (isset($save['subscription_code'])) {
			$this->db->set('subscription_code', $save['subscription_code']);
		}

		if (is_numeric($package_purchase_id)) {	
			$this->db->where('package_purchase_id', $package_purchase_id);
			$query = $this->db->update('trainer_package_purchases');
		} else {
			$this->db->set('date_added', date('Y-m-d H:i:s'));
			$this->db->set('subscription_payment_iteration', '1');
			$query = $this->db->insert('trainer_package_purchases');
			$package_purchase_id = $this->db->insert_id();
		}
		
		return $package_purchase_id;
	}

	public function savePlanPurchaseHistory($package_purchase_history_id = '', $save = array())
	{
		if (empty($save)) return FALSE;

		if (isset($save['stripe_customer_id'])) {
			$this->db->set('stripe_customer_id', $save['stripe_customer_id']);
		}

		if (isset($save['trainer_email'])) {
			$this->db->set('trainer_email', $save['trainer_email']);
		}

		if (isset($save['subscription_id'])) {
			$this->db->set('subscription_id', $save['subscription_id']);
		}	

		if (isset($save['is_active'])) {
			$this->db->set('is_active', $save['is_active']);
		}

		if (isset($save['package_id'])) {
			$this->db->set('package_id', $save['package_id']);
		}	

		if (isset($save['package_price'])) {
			$this->db->set('package_price', $save['package_price']);
		}

		if (isset($save['subscription_end_date'])) {
			$this->db->set('subscription_end_date', $save['subscription_end_date']);
		}

		if (isset($save['subscription_start_date'])) {
			$this->db->set('subscription_start_date', $save['subscription_start_date']);
		}

		if (isset($save['subscription_code'])) {
			$this->db->set('subscription_code', $save['subscription_code']);
		}

		if (is_numeric($package_purchase_history_id)) {		
			$this->db->where('package_purchase_history_id', $package_purchase_history_id);
			$query = $this->db->update('trainer_package_purchases_history');	
		} else {
			$this->db->set('date_added', date('Y-m-d H:i:s'));
			$this->db->set('subscription_payment_iteration', '1');
			$query = $this->db->insert('trainer_package_purchases_history');
			$package_purchase_history_id = $this->db->insert_id();
		}
		
		return $package_purchase_history_id;
	}
}