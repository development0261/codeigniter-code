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
class Trainers_model extends CI_Model {

	public function __construct() {
        parent::__construct();

        //load database library
        $this->load->database();
    }
	/*
	* Get Trainers List
	*/
	public function getTrainersList()
	{
		$where = "status = '1'";
		if(!empty($added_by)){
			$where = "status = '1' AND added_by = $added_by ";
		}

		$this->db->select('trainer_id, first_name, last_name, trainer_short_info, profile_picture, main_image, followCount, rating');
		$this->db->from('trainers');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainer Details by ID
	*/
	public function getTrainerDetails($trainer_id = '')
	{
		$where = "status = '1'";
		if(!empty($trainer_id)){
			$where = "`status` = '1' AND `trainer_id` = $trainer_id ";
		}

		$this->db->select('trainer_id, first_name, last_name, email, telephone, skype, gender, country, city, device_time_zone, timezone, trainer_short_info, trainer_key_points, about_trainer, profile_picture, main_image, instagram_link, followCount, rating, vidoes, courses, instagram_link, facebook_link, business_type, business_name');
		$this->db->from('trainers');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainer Details by Email
	*/
	public function getTrainerDetailsByEmail($trainer_email = '')
	{
		$where = "status = '1'";
		if(!empty($trainer_email)){
			$where = "`status` = '1' AND `email` = '".$trainer_email."'";
		}

		$this->db->select('trainer_id, first_name, last_name, email, telephone, skype, gender, country, city, device_time_zone, timezone, trainer_short_info, trainer_key_points, about_trainer, profile_picture, main_image, instagram_link, followCount, rating, vidoes, courses, instagram_link, facebook_link');
		$this->db->from('trainers');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainer programs by trainer id
	*/
	public function getTrainerPrograms($trainer_id = '')
	{
		$where = "t.status = '1'";
		if(!empty($trainer_id)){
			$where = "t.status = '1' AND t.trainer_id = $trainer_id ";
		}
		$this->db->select('tp.*');
		$this->db->from('trainers t');
		$this->db->join('trainer_programs tp','t.trainer_id = tp.trainer_id','inner');
		$this->db->where($where);
		$this->db->order_by('tp.trainer_program_id','desc');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainer program details by trainer_program_id
	*/
	public function getTrainerProgramDetails($trainer_program_id = '')
	{
		$this->db->select('tp.*');
		$this->db->from('trainers t');
		$this->db->join('trainer_programs tp','t.trainer_id = tp.trainer_id','inner');
		$this->db->where("trainer_program_id = '".$trainer_program_id."'");
		$query = $this->db->get();
		if ($query->num_rows()) {
			$trainer_program = !empty($query->result_array()[0])? $query->result_array()[0] : array();
			// Fetch Types
			$trainer_program['program_types'] = $this->trainerProgramTypes($trainer_program_id);
			// Fetch Tags
			$trainer_program['program_tags'] = $this->trainerProgramTags($trainer_program_id);
			// Fetch Videos
			$trainer_program['program_videos'] = $this->trainerProgramVideos($trainer_program_id);
			return $trainer_program;
		}else{
			return array();
		}
	}

	/*
	* Get Trainer programs tags list by trainer_program_id
	*/
	public function trainerProgramTags($trainer_program_id = '')
	{
		$this->db->select('t.pt_trainer_program_tag_id, t.tag_name, parent_id');
		$this->db->from('pttrainer_program_tags t');
		$this->db->join('pttrainer_program_tags_relation tp','t.pt_trainer_program_tag_id = tp.pt_trainer_program_tag_id','inner');
		$this->db->where("tp.trainer_program_id = '".$trainer_program_id."'");
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainer programs types list by trainer_program_id
	*/
	public function trainerProgramTypes($trainer_program_id = '')
	{
		$this->db->select('t.pt_trainer_program_type_id, t.type_name');
		$this->db->from('pttrainer_program_types t');
		$this->db->join('pttrainer_program_types_relation tp','t.pt_trainer_program_type_id = tp.pt_trainer_program_type_id','inner');
		$this->db->where("tp.trainer_program_id = '".$trainer_program_id."'");
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainer programs videos list by trainer_program_id
	*/
	public function trainerProgramVideos($trainer_program_id = '')
	{
		$this->db->select('t.pt_trainer_program_video_id, t.title, t.video_url, image_url');
		$this->db->from('pttrainer_program_videos t');
		$this->db->where("trainer_program_id = '".$trainer_program_id."'");
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainer programs list by trainer_id
	*/
	public function getTrainerProgramsList($trainer_id = '')
	{
		$this->db->select('tp.*');
		$this->db->from('trainers t');
		$this->db->join('trainer_programs tp','t.trainer_id = tp.trainer_id','inner');
		$this->db->where("t.trainer_id = '".$trainer_id."'");
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
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

	/*
	* Check Email exists or not
	*/
	public function check_trainer_exists($trainer_id = '') {

		$this->db->from('trainers');
		$this->db->where('trainer_id', $trainer_id);
		$query = $this->db->get();
		return $query->num_rows();

	}
	/*
	* Save trainer data
	*/

	public function saveTrainer($trainer_id, $save = array()) {

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

		if (!empty($save['telephone'])) {
			$this->db->set('telephone', $save['telephone']);
		}

		if (!empty($save['date_added'])) {
			$this->db->set('date_added', $save['date_added']);
		}

		if (!empty($save['status'])) {
			$this->db->set('status', $save['status']);
		}

		if (!empty($save['trainer_short_info'])) {
			$this->db->set('trainer_short_info', $save['trainer_short_info']);
		}

		if (!empty($save['trainer_key_points'])) {
			$this->db->set('trainer_key_points', $save['trainer_key_points']);
		}

		if (!empty($save['about_trainer'])) {
			$this->db->set('about_trainer', $save['about_trainer']);
		}

		if (!empty($save['telephone'])) {
			$this->db->set('telephone', $save['telephone']);
		}

		if (!empty($save['skype'])) {
			$this->db->set('skype', $save['skype']);
		}

		if (!empty($save['gender'])) {
			$this->db->set('gender', $save['gender']);
		}

		if (!empty($save['country'])) {
			$this->db->set('country', $save['country']);
		}

		if (!empty($save['city'])) {
			$this->db->set('city', $save['city']);
		}

		if (!empty($save['device_time_zone'])) {
			$this->db->set('device_time_zone', $save['device_time_zone']);
		}

		if (!empty($save['timezone'])) {
			$this->db->set('timezone', $save['timezone']);
		}

		if (!empty($save['instagram_link'])) {
			$this->db->set('instagram_link', $save['instagram_link']);
		}

		if (!empty($save['facebook_link'])) {
			$this->db->set('facebook_link', $save['facebook_link']);
		}

		if (!empty($save['deviceid'])) {
			$this->db->set('deviceid', $save['deviceid']);
		}

		if (!empty($save['business_name'])) {
			$this->db->set('business_name', $save['business_name']);
		}
		if (!empty($save['business_type'])) {
			$this->db->set('business_type', $save['business_type']);
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

		return $customer_id;
	}

	/*
	* Update image
	*/

	public function updateImage($trainer_id, $save = array()) {

		if (empty($save)) return FALSE;

		if (isset($save['profile_picture'])) {
			$this->db->set('profile_picture', $save['profile_picture']);
		}

		if (isset($save['main_image'])) {
			$this->db->set('main_image', $save['main_image']);
		}

		if (is_numeric($trainer_id)) {
			$action = 'updated';
			$this->db->where('trainer_id', $trainer_id);
			$query = $this->db->update('trainers');
			return $trainer_id;
			exit;
		}

		return $trainer_id;
	}

	/*
	* Update trainer data
	*/

	public function saveTraingProgram($trainer_program_id = '', $save = array()) {

		if (empty($save)) return FALSE;

		if (!empty($save['trainer_id'])) {
			$this->db->set('trainer_id', $save['trainer_id']);
		}

		if (!empty($save['program_name'])) {
			$this->db->set('program_name', $save['program_name']);
		}

		if (!empty($save['program_short_description'])) {
			$this->db->set('program_short_description', $save['program_short_description']);
		}

		if (!empty($save['program_overview'])) {
			$this->db->set('program_overview', $save['program_overview']);
		}

		if (!!empty($save['program_price'])) {
			$this->db->set('program_price', $save['program_price']);
		}

		if (is_numeric($trainer_program_id)) {
			$action = 'updated';
			$this->db->where('trainer_program_id', $trainer_program_id);
			$query = $this->db->update('trainer_programs');
		} else {
			$this->db->set('date_added', date('Y-m-d H:i:s'));
			$this->db->set('status', '1');
			$this->db->set('added_by', $save['trainer_id']);

			$action = 'added';
			$query = $this->db->insert('trainer_programs');
			$trainer_program_id = $this->db->insert_id();
		}
		// Insert Program Types
		$this->addProgramTypes($trainer_program_id, $save['program_types']);

		// Insert Program Tags
		$this->addProgramTags($trainer_program_id, $save['program_tags']);

		return $trainer_program_id;
		exit;
	}
	// Insert Program Types
	public function addProgramTypes($trainer_program_id = '', $program_types = array()) {
    	if ( ! empty($trainer_program_id)) {
            $this->db->where('trainer_program_id', $trainer_program_id);
            $this->db->delete('pttrainer_program_types_relation');
			if(!empty($program_types)){
				foreach ($program_types as $key_menu => $value_menu) {
					$this->db->set('pt_trainer_program_type_id', $value_menu['type']);
					$this->db->set('trainer_program_id', $trainer_program_id);
					$this->db->set('date_added', date('Y-m-d H:i:s'));
					$this->db->set('status', '1');
					$this->db->insert('pttrainer_program_types_relation');
				}
			}
        }
    }

	// Insert Program Tags
	public function addProgramTags($trainer_program_id = '', $program_tags = array()) {

    	if ( ! empty($trainer_program_id)) {
            $this->db->where('trainer_program_id', $trainer_program_id);
            $this->db->delete('pttrainer_program_tags_relation');
			if(!empty($program_tags)){
				foreach ($program_tags as $key_menu => $value_menu) {
					$this->db->set('pt_trainer_program_tag_id', $value_menu['tag']);
					$this->db->set('trainer_program_id', $trainer_program_id);
					$this->db->set('date_added', date('Y-m-d H:i:s'));
					$this->db->set('status', '1');
					$this->db->insert('pttrainer_program_tags_relation');
				}
			}
        }
    }


	/*
	* Update trainer program videos
	*/

	public function saveTraingProgramVideos($pt_trainer_program_video_id = '', $save = array()) {

		if (empty($save)) return FALSE;

		if (!empty($save['trainer_id'])) {
			$this->db->set('trainer_id', $save['trainer_id']);
		}

		if (!empty($save['trainer_program_id'])) {
			$this->db->set('trainer_program_id', $save['trainer_program_id']);
		}

		if (!empty($save['video_url'])) {
			$this->db->set('video_url', $save['video_url']);
		}

		if (!empty($save['image_url'])) {
			$this->db->set('image_url', $save['image_url']);
		}

		if (!empty($save['title'])) {
			$this->db->set('title', $save['title']);
		}

		if (is_numeric($pt_trainer_program_video_id)) {
			$action = 'updated';
			$this->db->where('pt_trainer_program_video_id', $pt_trainer_program_video_id);
			$query = $this->db->update('pttrainer_program_videos');
			return true;
			exit;
		} else {
			$this->db->set('date_added', date('Y-m-d H:i:s'));
			$this->db->set('status', '1');
			$action = 'added';
			$query = $this->db->insert('pttrainer_program_videos');
			$pt_trainer_program_video_id = $this->db->insert_id();
			return $pt_trainer_program_video_id;
			exit;
		}
	}

	public function login($email, $password)
	{
		$return_array = array();

		$this->db->select('trainer_id, email');
		$this->db->from('trainers');
		$this->db->where('email', strtolower($email));
		$this->db->where('password', 'SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1("' . $password . '")))))', FALSE);
		$this->db->where('status', '1');
		$query = $this->db->get();

		if ($query->num_rows() === 1) {
			$result = $query->row_array();

			$return_array['trainer_id'] = $result['trainer_id'];
			$return_array['email'] = $result['email'];
		}
		return $return_array;
	}

	/*
	* Save contact messages
	*/

	public function saveContactMessages($save = array()) {

		if (empty($save)) return FALSE;

		if (isset($save['first_name'])) {
			$this->db->set('first_name', $save['first_name']);
		}

		if (isset($save['last_name'])) {
			$this->db->set('last_name', $save['last_name']);
		}

		if (isset($save['email'])) {
			$this->db->set('email', strtolower($save['email']));
		}
		$this->db->set('date_added', date('Y-m-d H:i:s'));

		$query = $this->db->insert('trainer_contact_messages');
		$contact_message_id = $this->db->insert_id();

		return $contact_message_id;
	}

	/*
	* Get All Types
	*/
	public function getAllTypes()
	{
		$this->db->select('*');
		$this->db->from('pttrainer_program_types');
		$this->db->order_by('type_name');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Check Trainer Program exists or not
	*/
	public function check_trainer_program_exists($trainer_id = '', $trainer_program_id = '') {

		$this->db->select('trainer_program_id');
		$this->db->from('trainer_programs');
		$this->db->where('trainer_id', $trainer_id);
		$this->db->where('trainer_program_id', $trainer_program_id);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}

	}

	/*
	* Check Trainer Program exists or not
	*/
	public function check_trainer_program_video_exists($trainer_id = '', $trainer_program_id = '', $pt_trainer_program_video_id = '') {

		$this->db->select('pt_trainer_program_video_id');
		$this->db->from('pttrainer_program_videos');
		$this->db->where('trainer_id', $trainer_id);
		$this->db->where('trainer_program_id', $trainer_program_id);
		$this->db->where('pt_trainer_program_video_id', $pt_trainer_program_video_id);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}

	}

	/*
	* Check Trainer Program exists or not
	*/
	public function getProgramTags($parent_id = '') {

		$this->db->select('*');
		$this->db->from('pttrainer_program_tags');
		$this->db->where('parent_id', $parent_id);
		$this->db->order_by('parent_id');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get Trainers Packages List
	*/
	public function getTrainersPackagesList()
	{
		$this->db->select('package_id, parent_id, package_name, package_price, package_duration, packag_client_limit, stripe_product_key, stripe_price_key');
		$this->db->from('trainer_packages');
		$this->db->where('status', '1');
		$this->db->order_by('display_order');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}
	/*
	* Get Customers Subscription plans details
	*/
	public function getCustomerSbscriptionCurrentPlan($cust_email = '')
	{
		$where = "p.is_active = '1'";
		if($cust_email != '')
		{
			$where .= " AND p.trainer_email = '$cust_email'";
		}
		$this->db->select('p.stripe_customer_id, p.package_price, p.txn_id, p.subscription_id, p.subscription_payment_iteration, p.date_added, p.is_active, p.trainer_email, tp.package_name, tp.package_duration, tp.stripe_product_key, tp.stripe_price_key, tp.packag_client_limit, p.package_purchase_id, p.subscription_end_date, p.subscription_start_date, p.package_id');
		$this->db->from('yvdnsddqu_trainer_package_purchases p');
		$this->db->join('yvdnsddqu_trainer_packages tp','tp.package_id = p.package_id','inner');
		$this->db->where($where);
		$this->db->order_by('p.package_purchase_id','desc');
		$query = $this->db->get();
		return $query;
	}

	/*
	* Get Customers Subscription plans details
	*/
	public function getCustomerSbscriptionPurchaseHistory($cust_email = '')
	{
		$where = "ph.is_active = '1'";
		if($cust_email != '')
		{
			$where = "ph.trainer_email = '$cust_email'";
		}
		$this->db->select('ph.stripe_customer_id, ph.package_price, ph.txn_id, ph.subscription_id, ph.subscription_payment_iteration, ph.date_added, ph.is_active, ph.trainer_email, tp.package_name, tp.package_duration, tp.stripe_product_key, tp.stripe_price_key, tp.packag_client_limit');
		$this->db->from('yvdnsddqu_trainer_package_purchases_history ph');
		$this->db->join('yvdnsddqu_trainer_packages tp','tp.package_id = ph.package_id','inner');
		$this->db->where($where);
		$this->db->order_by('ph.package_purchase_history_id','desc');
		$query = $this->db->get();
		return $query;
	}

	public function updateTraingPackage($save = array())
	{
		//	print_r($save);exit;
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

		$this->db->set('date_updated', date('Y-m-d H:i:s'));
		$this->db->where('stripe_customer_id', $save['stripe_customer_id']);
		$this->db->where('trainer_email', $save['trainer_email']);
		$query = $this->db->update('trainer_package_purchases');

		return true;


	}

	/*
	* Get Trainers Packages name
	*/
	public function getTrainersPackageName($package_id = '')
	{
		$this->db->select('package_name');
		$this->db->from('trainer_packages');
		$this->db->where('package_id', $package_id);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array()[0]['package_name'];
		}else{
			return array();
		}
	}

	public function getSubscriptionByEmail($email){

        $wherestory = array('trainer_email'=>$email,'is_active'=>1);
        $this->db->where($wherestory);
        $query =  $this->db->get('trainer_package_purchases');

        $this->db->last_query() ;
        //print_r($result);
        //die() ; 

        //$query = $this->db->get();
        if ($query->num_rows()) {
            //print_r($query->result_array()) ; 
            return $query->result_array();
        }else{
            return array();
        }
	}

	public function updateTrainerSubscription($package_purchase_id = '', $is_active = ''){     

		$this->db->set('is_active', $is_active);
		$this->db->where('package_purchase_id', (int) $package_purchase_id);
		$query = $this->db->update('trainer_package_purchases');
		return $this->db->affected_rows();
		//return $query;

	}

    /*
	* Get Trainers Packages details
	*/
	public function getTrainersPackageDetails($package_id = '')
	{
		$this->db->select('*');
		$this->db->from('trainer_packages');
		$this->db->where('package_id', $package_id);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->row();
		}else{
			return array();
		}
	}

	/*
	* Get active code details
	*/
	public function getActivePasscode()
	{
		$this->db->where('is_active', 1);
		
		$query = $this->db->get('purchase_vipplan_code');

		$result = array();

        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return $result;
	}

	
	/*
	* Update device info
	*/
	public function updateDeviceInfo($trainer_id, $deviceid = NULL, $deviceInfo = NULL)
	{
		if($deviceid!=NULL)
		{
			$this->db->set('deviceid', $deviceid);
		}
		if($deviceInfo!=NULL)
		{
			$this->db->set('deviceInfo', $deviceInfo);
		}
        $this->db->where('trainer_id', (int) $trainer_id);
        $query = $this->db->update('trainers');

        return $this->db->affected_rows();
    }

    /*
    * getStripeKey details
    */
    public function getStripeKey($mode) 
    {
      $this->db->select('public_key, secret_key, merchantId');
		$this->db->from('stripe_key_pttrainer');
		$this->db->where('mode',$mode);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}
    }

	/*
	* Get video seris by workout_video_id
	*/
	public function getWorkoutVideoSeries()
	{
		$this->db->select('rv.*');
		$this->db->from('workout_related_videos rv');
		$this->db->where("rv.status = '1'");
		$this->db->where("rv.is_paid = '1'");
		$this->db->order_by('rv.week','ASC');	
		$this->db->order_by('rv.day','ASC');		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}						
	}
}