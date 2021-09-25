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
class Trainerpackagepurchase_model extends TI_Model {

	public function savePlanPurchase($package_purchase_id = '', $save = array()) 
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

			if (isset($save['txn_id'])) {
				$this->db->set('txn_id', $save['txn_id']);
			}

			if (isset($save['subscription_start_date'])) {
				$this->db->set('subscription_start_date', $save['subscription_start_date']);
			}

			if (isset($save['subscription_end_date'])) {
				$this->db->set('subscription_end_date', $save['subscription_end_date']);
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

				if (isset($save['txn_id'])) {
					$this->db->set('txn_id', $save['txn_id']);
				}

				if (isset($save['txn_id'])) {
					$this->db->set('txn_id', $save['txn_id']);
				}

				if (isset($save['subscription_start_date'])) {
					$this->db->set('subscription_start_date', $save['subscription_start_date']);
				}
	
				if (isset($save['subscription_end_date'])) {
					$this->db->set('subscription_end_date', $save['subscription_end_date']);
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

	/*
	* Package customer info
	*/
	public function recordByPackageCustomer($customer_id = '', $package_id = '') 
	{
		$this->db->select('tp.package_duration, tp.package_price');
		$this->db->from('trainer_packages tp');	
		if(!empty($customer_id)){
			$this->db->select('tpp.*');
			$this->db->join('trainer_package_purchases tpp','tpp.package_id = tp.package_id');	
			$this->db->where('tpp.stripe_customer_id', $customer_id);	
		}
		if(!empty($package_id)){
			$this->db->where('tp.package_id',$package_id);		
		}		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array()[0];
		}else{
			return array();
		}
	}

	// Update purchase record
	public function updatePurchaseRecord($save = array()) 
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

				if (isset($save['txn_id'])) {
					$this->db->set('txn_id', $save['txn_id']);
				}

				if (isset($save['subscription_start_date'])) {
					$this->db->set('subscription_start_date', $save['subscription_start_date']);
				}

				if (isset($save['subscription_end_date'])) {
					$this->db->set('subscription_end_date', $save['subscription_end_date']);
				}
		
				if (!empty($save['stripe_customer_id'])) {		
					$this->db->set('date_updated', date('Y-m-d H:i:s'));
					$this->db->where('stripe_customer_id', $save['stripe_customer_id']);
					$query = $this->db->update('trainer_package_purchases');	
				} else {
					$this->db->set('date_added', date('Y-m-d H:i:s'));
					$this->db->set('subscription_payment_iteration', '1');
					$query = $this->db->insert('trainer_package_purchases');
					$package_purchase_history_id = $this->db->insert_id();
				}
				
				return $package_purchase_history_id;
		
				
	}


}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */