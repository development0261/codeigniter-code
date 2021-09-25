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
class Workout_videos_model extends CI_Model {

	public function __construct() {
        parent::__construct();

        //load database library
        $this->load->database();
    }
	/*
	* Get workout videos categories list
	*/
	public function getCategoriesList()
    {
        $where = "status = '1'";

		$this->db->select('*');
		$this->db->from('workout_videos_categories');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}

    }

	/*
	* Get Workout videos with/without video category id
	*/
	public function getVideosList($workout_video_categoryid = '')
	{
		$where = "v.status = '1' AND vc.status = '1'";
		if(!empty($workout_video_categoryid)){
			$where .= " AND vc.workout_video_categoryid = $workout_video_categoryid ";
		}
		$this->db->select('v.workout_video_id, v.name, v.rating, v.banner_image, vc.category_name as category');
		$this->db->from('workout_videos v');
		$this->db->join('workout_videos_categories vc','v.workout_video_categoryid = vc.workout_video_categoryid','inner');
		$this->db->where($where);
		$this->db->order_by('v.workout_video_id','desc');
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
	public function getWorkoutVideoDetails($workout_video_id = '')
	{
		$this->db->select('v.*, vc.category_name as category');
		$this->db->from('workout_videos v');
		$this->db->join('workout_videos_categories vc','v.workout_video_categoryid = vc.workout_video_categoryid','inner');
		$this->db->where("workout_video_id = '".$workout_video_id."'");
		$this->db->where("v.status = '1' AND vc.status = '1'");
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}
	}

	/*
	* Get video seris by workout_video_id
	*/
	public function getWorkoutVideoSeries($workout_video_id = '', $email = '', $is_paid = '1')
	{
		// $this->db->select('rv.*, vm.module_name, vm.module_image');
		// $this->db->from('workout_related_videos rv');
		// $this->db->join('workout_video_purchases v','v.workout_video_id = rv.workout_video_id','inner');
		// $this->db->join('workout_video_modules vm','vm.workout_video_module_id = rv.workout_video_module_id','inner');
		// $this->db->where("rv.status = '1'");
		// $this->db->where("rv.is_paid = '1'");
		// $this->db->where("rv.workout_video_schedule_id <= v.subscription_payment_iteration");
		// $this->db->where("v.workout_video_id = '".$workout_video_id."'");
		// $this->db->where("v.email = '".$email."'");				
		// $this->db->order_by('rv.week','ASC');	
		// $this->db->order_by('rv.day','ASC');		
		// $query = $this->db->get();
		
		$result = $this->db->query("SELECT `rv`.*, `vm`.`module_name`, `vm`.`module_image`, v.is_active
						  FROM `yvdnsddqu_workout_related_videos` `rv` 
						  INNER JOIN (SELECT * FROM `yvdnsddqu_workout_video_purchases` WHERE `email` = '".$email."' ORDER BY video_purchase_id DESC LIMIT 1) AS `v` ON `v`.`workout_video_id` = `rv`.`workout_video_id` 
						  INNER JOIN `yvdnsddqu_workout_video_modules` `vm` ON `vm`.`workout_video_module_id` = `rv`.`workout_video_module_id` 
						  WHERE `rv`.`status` = '1'
						  AND `rv`.`is_paid` = '".$is_paid."' 
						  AND `rv`.`workout_video_schedule_id` <= `v`.`subscription_payment_iteration` 
						  AND `v`.`workout_video_id` = '".$workout_video_id."' 
						  AND `v`.`email` = '".$email."' 
						  ORDER BY `rv`.`week` ASC, `rv`.`day` ASC"
						  )->result_array();	
		
		if (count($result) > 0) {
			return $result;
		}else{
			return array();
		}						
	}

	/*
	* Get workout free videos
	*/
	public function getWorkoutFreeVideos($workout_video_id = '')
	{
		$this->db->select('rv.*, vm.module_name, vm.module_image');
		$this->db->from('workout_related_videos rv');
		$this->db->join('workout_video_modules vm','vm.workout_video_module_id = rv.workout_video_module_id','inner');
		$this->db->where("rv.status = '1'");
		$this->db->where("rv.is_paid = '0'");
		$this->db->where("rv.workout_video_id = '".$workout_video_id."'");
		$query = $this->db->get();		
		
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}						
	}

	/*
	* Get modules by workout_video_id
	*/
	public function getWorkoutVideoModules($workout_video_id = '')
	{
		$this->db->select('vm.workout_video_module_id, vm.workout_video_id, vm.module_name, vm.module_image, vm.description');
		$this->db->from('workout_video_modules vm');
		$this->db->join('workout_related_videos wwu','wwu.workout_video_module_id = vm.workout_video_module_id','inner');
		$this->db->where("vm.workout_video_id = '".$workout_video_id."'");
		$this->db->where("vm.status = '1'");
		$this->db->group_by('wwu.workout_video_module_id');
		$query = $this->db->get();		
		
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}						
	}

	
	/*
	* Get Schedules by workout_video_id
	*/
	public function getWorkoutVideoSchedules($workout_video_id = '')
	{
		$this->db->select('workout_video_schedule_id, workout_video_id, schedule_name, schedule_image, description');
		$this->db->from('workout_video_schedules vs');
		$this->db->where("vs.workout_video_id = '".$workout_video_id."'");
		$query = $this->db->get();		
		
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}						
	}


	/*
	* Verify onboarding customer 
	*/
	public function checkCustomer($customer_id)
    {
		$this->db->select('customer_id');
		$this->db->from('customers');
		$this->db->where("customer_id = '".$customer_id."'");
		$query = $this->db->get();
		return $query->num_rows();
    }

	/*
	* Verify onboarding customer 
	*/
	public function checkOnboard($onboarding_id)
    {
		$this->db->select('onboarding_id');
		$this->db->from('workout_onboarding_process');
		$this->db->where("onboarding_id = '".$onboarding_id."'");
		$query = $this->db->get();
		return $query->num_rows();
    }

	/*
	* Save on-boarding process
	*/
	public function saveOnboardingProcess($onboarding_id = '',$save = array()) {

		if (empty($save)) return FALSE;

		if (isset($save['customer_id'])) {
			$this->db->set('customer_id', $save['customer_id']);
		}

		if (isset($save['weight'])) {
			$this->db->set('weight', $save['weight']);
		}

		if (isset($save['height'])) {
			$this->db->set('height', $save['height']);
		}

		if (isset($save['body_fat'])) {
			$this->db->set('body_fat', $save['body_fat']);
		}		

		if (isset($save['body_fat'])) {
			$this->db->set('body_fat', $save['body_fat']);
		}

		if (isset($save['activity_level'])) {
			$this->db->set('activity_level', strtolower($save['activity_level']));
		}		

		if (isset($save['exercise_location_preference'])) {
			$this->db->set('exercise_location_preference', $save['exercise_location_preference']);
		}

		if (isset($save['experience_level'])) {
			$this->db->set('experience_level', $save['experience_level']);
		}

		if (isset($save['injuries'])) {
			$this->db->set('injuries', json_encode($save['injuries']));
		}
		
		if (isset($save['workout_days_per_week'])) {
			$this->db->set('workout_days_per_week', $save['workout_days_per_week']);
		}

		if (isset($save['workout_goal'])) {
			$this->db->set('workout_goal', $save['workout_goal']);
		}

		if (isset($save['workout_session_duration'])) {
			$this->db->set('workout_session_duration', $save['workout_session_duration']);
		}

		if (isset($save['shoulders_size'])) {
			$this->db->set('shoulders_size', $save['shoulders_size']);
		}

		if (isset($save['arms_size'])) {
			$this->db->set('arms_size', $save['arms_size']);
		}

		if (isset($save['chest_size'])) {
			$this->db->set('chest_size', $save['chest_size']);
		}

		if (isset($save['waist_size'])) {
			$this->db->set('waist_size', $save['waist_size']);
		}

		if (isset($save['hips_size'])) {
			$this->db->set('hips_size', $save['hips_size']);
		}

		if (isset($save['legs_size'])) {
			$this->db->set('legs_size', $save['legs_size']);
		}

		if (isset($save['calves_size'])) {
			$this->db->set('calves_size', $save['calves_size']);
		}

		if (isset($save['ip_address'])) {
			$this->db->set('ip_address', $save['ip_address']);
		}

		if (is_numeric($onboarding_id)) {
			$action = 'updated';
			$this->db->where('onboarding_id', $onboarding_id);
			$query = $this->db->update('workout_onboarding_process');	
		} else {
			$action = 'added';
			$this->db->set('date_added', date("Y-m-d H:i:s"));
			$query = $this->db->insert('workout_onboarding_process');
			$onboarding_id = $this->db->insert_id();		
		}
		
		return $onboarding_id;
	}

	/*
	* Update on-boarding process
	*/
	public function updateOnboardingProcess($save = array(), $onboarding_id = '') {

		if (empty($save)) return FALSE;

		if (isset($save['customer_id'])) {
			$this->db->set('customer_id', $save['customer_id']);
		}

		if (isset($save['weight'])) {
			$this->db->set('weight', $save['weight']);
		}

		if (isset($save['height'])) {
			$this->db->set('height', $save['height']);
		}

		if (isset($save['body_fat'])) {
			$this->db->set('body_fat', $save['body_fat']);
		}		

		if (isset($save['body_fat'])) {
			$this->db->set('body_fat', $save['body_fat']);
		}

		if (isset($save['activity_level'])) {
			$this->db->set('activity_level', strtolower($save['activity_level']));
		}		

		if (isset($save['exercise_location_preference'])) {
			$this->db->set('exercise_location_preference', $save['exercise_location_preference']);
		}

		if (isset($save['experience_level'])) {
			$this->db->set('experience_level', $save['experience_level']);
		}

		if (isset($save['injuries'])) {
			$this->db->set('injuries', json_encode($save['injuries']));
		}
		
		if (isset($save['workout_days_per_week'])) {
			$this->db->set('workout_days_per_week', $save['workout_days_per_week']);
		}

		if (isset($save['workout_goal'])) {
			$this->db->set('workout_goal', $save['workout_goal']);
		}

		if (isset($save['workout_session_duration'])) {
			$this->db->set('workout_session_duration', $save['workout_session_duration']);
		}

		if (isset($save['shoulders_size'])) {
			$this->db->set('shoulders_size', $save['shoulders_size']);
		}

		if (isset($save['arms_size'])) {
			$this->db->set('arms_size', $save['arms_size']);
		}

		if (isset($save['chest_size'])) {
			$this->db->set('chest_size', $save['chest_size']);
		}

		if (isset($save['waist_size'])) {
			$this->db->set('waist_size', $save['waist_size']);
		}

		if (isset($save['hips_size'])) {
			$this->db->set('hips_size', $save['hips_size']);
		}

		if (isset($save['legs_size'])) {
			$this->db->set('legs_size', $save['legs_size']);
		}

		if (isset($save['calves_size'])) {
			$this->db->set('calves_size', $save['calves_size']);
		}

		if (isset($save['ip_address'])) {
			$this->db->set('ip_address', $save['ip_address']);
		}
		
		$this->db->where('onboarding_id', $onboarding_id);
		$query = $this->db->update('workout_onboarding_process');	

		return $this->db->affected_rows();
	}

	/*
	* Get Onboarding details by ID
	*/
	public function onboardingdetails($customer_id = '')
	{
		$this->db->select('*');
		$this->db->from('workout_onboarding_process');		
		$this->db->where("customer_id = '".$customer_id."' ORDER BY onboarding_id DESC LIMIT 1");

		$query = $this->db->get();		
		if ($query->num_rows()) {
			return $query->result_array();
		}else{
			return array();
		}						
	}

	/*
	* Insert into related video table
	*/
	public function importRelatedVideoData($save = array()) {

		if (empty($save)) return FALSE;

		if (isset($save['workout_video_id'])) {
			$this->db->set('workout_video_id', $save['workout_video_id']);
		}

		if (isset($save['image'])) {
			$this->db->set('image', $save['image']);
		}

		if (isset($save['title'])) {
			$this->db->set('title', $save['title']);
		}

		if (isset($save['description'])) {
			$this->db->set('description', $save['description']);
		}		

		if (isset($save['video_url'])) {
			$this->db->set('video_url', $save['video_url']);
		}

		if (isset($save['workout_video_module_id'])) {
			$this->db->set('workout_video_module_id', $save['workout_video_module_id']);
		}		

		if (isset($save['workout_video_schedule_id'])) {
			$this->db->set('workout_video_schedule_id', $save['workout_video_schedule_id']);
		}

		if (isset($save['week'])) {
			$this->db->set('week', $save['week']);
		}

		if (isset($save['day'])) {
			$this->db->set('day', $save['day']);
		}
		
		if (isset($save['sets'])) {
			$this->db->set('sets', $save['sets']);
		}

		if (isset($save['reps'])) {
			$this->db->set('reps', $save['reps']);
		}

		if (isset($save['filename'])) {
			$this->db->set('filename', $save['filename']);
		}

		if (isset($save['duration'])) {
			$this->db->set('duration', $save['duration']);
		}

		if (isset($save['status'])) {
			$this->db->set('status', $save['status']);
		}

		if (isset($save['is_paid'])) {
			$this->db->set('is_paid', $save['is_paid']);
		}
		
		$query = $this->db->insert('workout_related_videos');
		$workout_related_video_id = $this->db->insert_id();
		
		return $workout_related_video_id;
	}

	/*
	* Get subscription details by email id
	*/
	public function getSubscriptionDetails($email = '')
	{
		$this->db->select("first_name, last_name, email, purchase_type, purchase_date, DATE_ADD(`purchase_date`, INTERVAL `subscription_payment_iteration` WEEK) as end_date, currency, unit_amount as amount, is_active, subscription_payment_iteration");
		$this->db->from('workout_video_purchases');
		$this->db->where("email = '".$email."'");	
		$this->db->order_by("video_purchase_id", "DESC");	
		$this->db->limit("1");	
		$query = $this->db->get();		
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return array();
		}						
	}

}