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
 * @package        api_v1\Application\Models\Stripe_model.php
 * @link           http://docs.spotneat.com
 */
class Stripe_model extends CI_Model {

	

	
	public function getStripeBasedOnLocation($location_id)
	{
		
		return $this->db->select('id, status, location_id, publishable_test_key, secret_test_key, publishable_key, secret_key,apple_merchant_id')
				->where(array('location_id'=>$location_id,'status'=>'1'))
				->order_by('id','desc')
				->get('restaurant_stripe_details');
	}
}


/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */