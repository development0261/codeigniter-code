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
class Subscriptions_model extends CI_Model {

    
    public function __construct() {
        parent::__construct();

        //load database library
        $this->load->database();
    }

    public function getDiscontinueSubscriberList(){

        $wherestory = array('is_agreed_to_continue'=>'0');
        $this->db->where($wherestory);
        $query =  $this->db->get('workout_video_purchases_user_confirmations');

       // $this->db->last_query() ;
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


    public function getSubscriptionByEmail($email){

        $wherestory = array('email'=>$email,'is_active'=>1,'purchase_type'=>'subscription');
        $this->db->where($wherestory);
        $query =  $this->db->get('workout_video_purchases');

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

    function updateSubscription($video_purchase_id,$is_active){


      
        $this->db->set('is_active', $is_active);
        $this->db->where('video_purchase_id', (int) $video_purchase_id);
        $query = $this->db->update('workout_video_purchases');
        return $this->db->affected_rows();
        //return $query;

    }

    function updateSubscriptionRecord($email,$subscription_id){


      
        $this->db->set('is_active', 0);
        //$this->db->set('is_active', $is_active);
 
        $wherestory = array('email'=>$email,'is_active'=>1,'subscription_id'=>$subscription_id);
        $this->db->where($wherestory);

        
        $query = $this->db->update('workout_video_purchases_subscription_records');
        return $this->db->affected_rows();
        //return $query;

    }


 
    

    public function getModuleList(){

         
        $query =  $this->db->get('module_setting');
            
       // $this->db->last_query() ;
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

    /*
    * Get subscription details by email id
    */
    public function getSubscriptionDetails($email = '')
    {
        $this->db->select("first_name, last_name, email, purchase_type, purchase_date, DATE_ADD(`purchase_date`, INTERVAL `subscription_payment_iteration` WEEK) as end_date, currency, unit_amount as amount, is_active, subscription_payment_iteration");
        $this->db->from('workout_video_purchases');
        $this->db->where("email = '".$email."'");   
        $this->db->where("is_active", "1"); 
        $query = $this->db->get();      
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return array();
        }                       
    }
     



    public function getCalculatorList(){

         
        $query =  $this->db->get('webcalculators');
        if ($query->num_rows()) {
            //print_r($query->result_array()) ; 
            return $query->result_array();
        }else{
            return array();
        }

    }

    /*
    * Get Customers Subscription plans details
    */
    public function getCustomerSbscriptionCurrentPlan($cust_email = '', $package_id = '')
    {
        $where = "p.is_active = '1'";
        if($cust_email != '')
        {
            $where .= " AND p.trainer_email = '$cust_email'";
        }
        if($package_id != '')
        {
            $where .= " AND p.package_id = ".$package_id;
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
    * Deactivate plan
    */
    function cancelSubscription($package_purchase_id, $is_active, $trainer_id = null){
        // $this->db->query("UPDATE yvdnsddqu_trainer_package_purchases_history SET is_active = 0 WHERE trainer_id = '$trainer_id' ORDER BY package_purchase_history_id DESC LIMIT 1");
        
        
        /*deactivate the clients*/
        $this->db->query("UPDATE yvdnsddqu_ptclients SET status = 0 WHERE trainer_id = $trainer_id");
        // echo $this->db->last_query();exit();

        $this->db->set('is_active', $is_active);
        $this->db->where('package_purchase_id', (int) $package_purchase_id);
        $query = $this->db->update('trainer_package_purchases');

        return $this->db->affected_rows();
    }

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
}

 