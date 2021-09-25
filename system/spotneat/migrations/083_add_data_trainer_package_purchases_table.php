<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_add_data_trainer_package_purchases_Table extends CI_Migration { 

    public function up() {

        /*parent table data 1*/
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_package_purchases` (`package_purchase_id`, `stripe_customer_id`, `trainer_email`, `package_id`, `package_price`, `txn_id`, `subscription_id`, `subscription_payment_iteration`, `date_added`, `is_active`) VALUES (NULL, 'cus_JsEEwySokAiLcw', 'development0261+12@gmail.com', '6', '60', 'JseTNoxuL87saK', 'sub_JoYbEIyBfNpAMh', '3', '".date('Y-m-d H:i:s')."', '1');");

        /*parent table data 2*/
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_package_purchases` (`package_purchase_id`, `stripe_customer_id`, `trainer_email`, `package_id`, `package_price`, `txn_id`, `subscription_id`, `subscription_payment_iteration`, `date_added`, `is_active`) VALUES (NULL, 'cus_JsEEwySokAiLOw', 'development0261+10@gmail.com', '7', '90', 'JseTNoxuL89saK', 'sub_JoZbEIyBfNpAMh', '3', '".date('Y-m-d H:i:s')."', '1');");
    }    

    public function down() {
    }


 
}

/* End of file 083_add_data_trainer_package_purchases_table.php */
/* Location: ./setup/migrations/083_add_data_trainer_package_purchases_table.php */