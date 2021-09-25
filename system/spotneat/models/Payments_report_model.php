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
 * Locations Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Locations_model.php
 * @link           http://docs.spotneat.com
 */
class Payments_report_model extends TI_Model {



	public function getList() {
			$this->db->select('*');						
			$this->db->from('admin_payments');
			$this->db->order_by("id", "desc");			
			$query = $this->db->get();

			$result = array();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
			return $result;

	}

	public function getDetailList($receipt_id){
		$this->db->select('*');						
		$this->db->from('staffs_commission');
		$this->db->where("receipt_no", $receipt_id);	
		$this->db->order_by("id", "desc");			
		$query = $this->db->get();

		$result = array();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		return $result;
	}

	public function getrefundstatus($type) {

		$this->db->select('*,refund.refund_amount');
		$this->db->from('staffs_commission');
		$this->db->join('refund','refund.reservation_id=staffs_commission.reservation_id','left');
		$this->db->join('customers','customers.customer_id=refund.customer_id','left');
		$this->db->where('staffs_commission.staff_id',$this->user->getId());
		$this->db->where("payment_status", $type);
		$this->db->order_by("staffs_commission.id", "desc");	
		$query = $this->db->get();
		$result = array();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		return $result;
	}

	public function updateCommission($post){
		$total_booking_amount = $post['total_booking_amount'];
		$total_amount_received = $post['total_amount_received'];
		$payment_date = date('Y-m-d H:i:s', strtotime($post['payment_date']) );		
		$receipt_no = $post['receipt_no'];
		$description = $post['description'];
		$no_of_orders = 0;
		$reserve_id = $post['reserve_id'];
		$res_count = count($reserve_id);		
		for ($i=0; $i < $res_count; $i++) { 
			$res = 'checkbox'.$reserve_id[$i];
			if($post[$res]!=''){			
			$this->db->set('payment_status', 'paid');
			$this->db->set('payment_date', $payment_date);
			$this->db->set('receipt_no', $receipt_no);
			$this->db->where('reservation_id', $reserve_id[$i]);
			$this->db->update('staffs_commission');
			$no_of_orders++;
			}
		}		
		$this->db->set('total_booking_amount', $total_booking_amount);
		$this->db->set('total_amount_received', $total_amount_received);
		$this->db->set('payment_date', $payment_date);
		$this->db->set('receipt_no', $receipt_no);
		$this->db->set('description', $description);
		$this->db->set('no_of_orders', $no_of_orders);
		$this->db->insert('admin_payments');
		return true;
	}


}