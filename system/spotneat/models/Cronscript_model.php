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
class Cronscript_model extends TI_Model {

	public function getList() {
		
		$this->db->select('*');
		$this->db->where('schedule_type','LATER');
		$this->db->or_where('schedule_type','RECURRING');
		$this->db->order_by('schedule_notification_id','DESC');
		$query = $this->db->get('schedule_notifications');

		$result = array();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		return $result;		
	}

	public function getSubscriptionsRecords($sent_to = '') {
		
		$this->db->select('deviceid, deviceInfo');
		$this->db->from('customers');	
        
		if($sent_to == 'LEE_PRIEST_USER_14_DAYS_AGO'){			
			$this->db->join('workout_video_purchases', 'customers.email = workout_video_purchases.email');	
			$this->db->where('DATEDIFF(CURDATE(), purchase_date) = 14');
			$this->db->where('is_active', '1');
		} else if($sent_to == 'LEE_PRIEST_USER'){
			$this->db->join('workout_video_purchases', 'customers.email = workout_video_purchases.email');
			$this->db->where('is_active', '1');
		} 
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return array();
		}
	}

	public function getTotalReportList($location_id = '') {
		
		$this->db->select('COUNT(order_id) as total_order_count, SUM(order_total) as total_order_amount, SUM(TIMESTAMPDIFF(MINUTE, date_added, invoice_date)) AS time_difference');
		$this->db->where('status_id','20');
		$this->db->where('location_id', $location_id); 
		$query = $this->db->get('orders');
		
		$result = array();
		if ($query->num_rows() > 0 && !empty($query->result_array()[0]['total_order_count'])) {
			$result = $query->result_array()[0];
		}
		return $result;		
	}

	public function getWeeklyReportList($location_id = '') {
		
		$this->db->select('COUNT(order_id) as total_order_count, SUM(order_total) as total_order_amount, SUM(TIMESTAMPDIFF(MINUTE, date_added, invoice_date)) AS time_difference');
		$this->db->where('status_id','20');
		$this->db->where('location_id', $location_id);		
		$this->db->where("DATEDIFF(CURDATE(), str_to_date(date_added, '%Y-%m-%d')) <= 7");  
		$query = $this->db->get('orders');
		
		$result = array();
		if ($query->num_rows() > 0 && !empty($query->result_array()[0]['total_order_count'])) {
			$result = $query->result_array()[0];
		}
		return $result;		
	}

	
	public function getAdminEmailList() {
		
		$this->db->select('*');
		$this->db->where('status','1');
		$query = $this->db->get('admin_emails');
		
		$result = array();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		return $result;		
	}

	public function getPendingOrdersList(){
		
		$this->db->select('orders.order_id, orders.order_id, orders.pickup_time, orders.order_date, orders.order_time, orders.status_id');
		$this->db->from('orders');
		$this->db->join('statuses', 'statuses.status_code = orders.status_id');
		
		$this->db->where('orders.status_id NOT IN (20)');		
		$this->db->order_by('orders.order_id','DESC');

		$query = $this->db->get();
		$result = array();
		if($query->num_rows())
      	{
        	$result = $query->result_array();
      	}
		return $result;
  
		
  
	  }

	  public function updateOrderStatus($order_id = ''){		  
		$this->db->set('status_id', '20');
		$this->db->where('order_id',$order_id);
		$this->db->update('orders');
		return;
	  }

}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */