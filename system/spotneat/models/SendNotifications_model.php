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
 * @package        SpotnEat\Models\SendNotifications_model.php
 * @link           http://docs.spotneat.com
 */
class SendNotifications_model extends TI_Model {


	public function getCustomerSbscriptionCurrentPlan()
    {
        $where = "p.is_active = '1'";
		$this->db->select('p.package_purchase_id, p.stripe_customer_id, p.package_price, p.txn_id, p.subscription_id, p.subscription_payment_iteration, p.date_added, p.is_active, p.trainer_email, tp.package_name, tp.package_duration, tp.stripe_product_key, tp.stripe_price_key, tp.packag_client_limit, p.subscription_end_date, p.subscription_start_date, p.package_id, tr.deviceid, tr.deviceInfo, tr.trainer_id');
		$this->db->from('yvdnsddqu_trainer_package_purchases p');
		$this->db->join('yvdnsddqu_trainer_packages tp','tp.package_id = p.package_id','inner');
		$this->db->join('trainers tr','tr.email = p.trainer_email','inner');
		$this->db->where($where);
		$this->db->order_by('p.package_purchase_id','desc');
		$query = $this->db->get();
		return $query;
    }

    public function getCustomerDetails()
    {
        $where = "p.is_active = '1'";
		$this->db->select('tr.deviceid, tr.deviceInfo');
		$this->db->from('yvdnsddqu_trainer_package_purchases p');
		$this->db->join('yvdnsddqu_trainer_packages tp','tp.package_id = p.package_id','inner');
		$this->db->join('trainers tr','tr.email = p.trainer_email','inner');
		$this->db->where($where);
		$this->db->order_by('p.package_purchase_id','desc');
		$query = $this->db->get();
		return $query->result_array();
    }


}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */