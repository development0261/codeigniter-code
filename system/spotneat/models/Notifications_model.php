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
 * Staff_groups Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Staff_groups_model.php
 * @link           http://docs.spotneat.com
 */
class Notifications_model extends TI_Model {


	public function saveNotifications($schedule_notification_id, $save = array()) {
		
		if (empty($save)) return FALSE;		
		
		// echo "<pre>";print_r($save );exit();
		$schedule_date_later  = '';
		$recurring_start_date = '';
		$recurring_end_date   = '';
		$db_time_zone         = date_default_timezone_get();
		if($save['schedule_type']=='LATER')
		{
			$new_date = new DateTime($save['schedule_date'], new DateTimeZone($save['time_zone']));
			$new_date->setTimezone(new DateTimeZone($db_time_zone));
			$schedule_date_later = $new_date->format('Y-m-d H:i');			
		}
		if($save['schedule_type']=='RECURRING')
		{
			$new_date = new DateTime($save['recurring_start_date'], new DateTimeZone($save['time_zone']));
			$new_date->setTimezone(new DateTimeZone($db_time_zone));
			$recurring_start_date = $new_date->format('Y-m-d H:i');
			
			$new_date = new DateTime($save['recurring_end_date'], new DateTimeZone($save['time_zone']));
			$new_date->setTimezone(new DateTimeZone($db_time_zone));
			$recurring_end_date = $new_date->format('Y-m-d H:i');	
		}

		$query     = FALSE;
		 

		if(!empty($save['locationIds']) and $save['sent_to']=='ALL_USER'){
				$locations = implode(',',$save['locationIds']);
		}else{
				$locations = '' ;
		}

		$storyData = array
		(
			'title'=>$save['title'],
			'message'=>$save['message'],
			'sent_to'=>$save['sent_to'],
			'locationIds'=>$locations,
			'sent'=>'No',
			'page_url'=>$save['page_url'],
			'web_url'=>$save['web_url'],
			'schedule_date'=> !empty($save['schedule_type']) && $save['schedule_type']=='NOW'?date('Y-m-d H:i:s'):($save['schedule_type']=='LATER' ? $schedule_date_later : ''),
			'recurring_start_date'=> !empty($save['schedule_type']) && ($save['schedule_type']=='NOW' || $save['schedule_type']=='LATER')?'':$recurring_start_date,
			'recurring_end_date'=> !empty($save['schedule_type']) && ($save['schedule_type']=='NOW' || $save['schedule_type']=='LATER')?'':$recurring_end_date,
			'schedule_type'=>$save['schedule_type'],
			'recurring_type'=>!empty($save['schedule_type']) && ($save['schedule_type']=='NOW' || $save['schedule_type']=='LATER')?'':$save['recurring_type'],
		);
		
		//print_r($storyData);
		$storyData['date_created']=date('Y-m-d H:i:s');
		$query = $this->db->insert('schedule_notifications',$storyData);
		$schedule_notification_id = $this->db->insert_id();
		
		return ($query === TRUE AND is_numeric($schedule_notification_id)) ? $schedule_notification_id : FALSE;
	}

	public function notificationData($array = [])
    {
        $this->db->select('*');
        foreach ($array as $key => $value) {
            $this->db->where($key, $value);
        }        
        $this->db->order_by('schedule_date','DESC');
        $result  =  $this->db->get('schedule_notifications')->result();        
        return $result ; 
    }

	public function getDeviceInfo($type = '',$locations='')
    {
		$this->db->from('customers');		
		$this->db->distinct();
        //$this->db->select('customers.email, deviceid, deviceInfo');
        $this->db->select(' customers.email, customers.deviceid, customers.deviceInfo');  
        if($type == 'LEE_PRIEST_USER') {			
			$this->db->join('workout_video_purchases', 'customers.email = workout_video_purchases.email AND workout_video_purchases.is_active = 1');
        } else if($type == 'LEE_PRIEST_USER_14_DAYS_AGO') {			
			$this->db->join('workout_video_purchases', 'customers.email = workout_video_purchases.email AND workout_video_purchases.is_active = 1');
            $this->db->where('DATEDIFF(CURDATE(), purchase_date) = 14');
        }else if($type == 'ALL_USER') {	 
			$this->db->join('orders', 'customers.email = orders.email');
			if(!empty($locations)){
				//$this->db->where('DATEDIFF(CURDATE(), purchase_date) = 14'); 				 
				$locations_array = explode(',',$locations);
				$this->db->where_in('orders.location_id', $locations_array);    

			}
			

        }	
		$query = $this->db->get();
		//echo $this->db->last_query() ; die() ; 		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return array();
		}

    }


	/**
     * Update User data of the given $userId
     *
     * @param number $userId User id
     * @param array  $data   Update data
     *
     * @return boolean
     */
    public function update($schedule_notification_id, $data)
    {
        return $this->db->where('schedule_notification_id', $schedule_notification_id)->update('schedule_notifications', $data);
    }

	public function getCount($filter = array()) {
		$this->db->from('stories');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
		
			
			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}
			$wherestory = array();			
			$this->db->where($wherestory);
			$query = $this->db->get('schedule_notifications');

			$result = array();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }

            return $result;
			
		}
	}

	public function geTimeZonetList() {

		$wherestory = array();		
		$query = $this->db->get('time_zones');

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		} else{
			$result = array();
		}

		return $result;
		
	}


	public function getLocationList() {
 

 		$this->db->where('location_status', 1);		
		$query = $this->db->get('locations');

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		} else{
			$result = array();
		}

		return $result;
		
	}







}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */