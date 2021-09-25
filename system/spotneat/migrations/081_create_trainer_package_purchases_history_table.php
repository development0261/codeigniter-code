<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Create_Trainer_Package_Purchases_History_Table extends CI_Migration { 

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_trainer_package_purchases_history` (
          `package_purchase_history_id` INT(11) NOT NULL AUTO_INCREMENT,
          `stripe_customer_id` VARCHAR(111) DEFAULT NULL,
          `trainer_email` TEXT DEFAULT NULL,
          `package_id` INT(11) DEFAULT NULL,
          `package_price` FLOAT(10,2) DEFAULT NULL,
          `txn_id` VARCHAR(111) DEFAULT NULL,
          `subscription_id` VARCHAR(111) DEFAULT NULL,
          `subscription_payment_iteration` INT(5) DEFAULT NULL,
          `date_added` datetime DEFAULT NULL,
          `is_active` TINYINT(1) DEFAULT NULL,

            PRIMARY KEY (`package_purchase_history_id`)
           ) ENGINE=InnoDB;");

        /*history table data 1*/

        $this->db->query("INSERT INTO `yvdnsddqu_trainer_package_purchases_history` (`package_purchase_history_id`, `stripe_customer_id`, `trainer_email`, `package_id`, `package_price`, `txn_id`, `subscription_id`, `subscription_payment_iteration`, `date_added`, `is_active`) VALUES (NULL, 'cus_JsEEwySokAiLcw', 'development0261+12@gmail.com', '4', '20', 'JsdTNoxuL82zaK', 'sub_JsZvNMblB3dsFo', '1', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_package_purchases_history` (`package_purchase_history_id`, `stripe_customer_id`, `trainer_email`, `package_id`, `package_price`, `txn_id`, `subscription_id`, `subscription_payment_iteration`, `date_added`, `is_active`) VALUES (NULL, 'cus_JsEEwySokAiLcw', 'development0261+12@gmail.com', '5', '40', 'JsdTNoxuL82zbn', 'sub_JoX2qSt0NaTt4J', '2', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_package_purchases_history` (`package_purchase_history_id`, `stripe_customer_id`, `trainer_email`, `package_id`, `package_price`, `txn_id`, `subscription_id`, `subscription_payment_iteration`, `date_added`, `is_active`) VALUES (NULL, 'cus_JsEEwySokAiLcw', 'development0261+12@gmail.com', '6', '60', 'JseTNoxuL87saK', 'sub_JoYbEIyBfNpAMh', '3', '".date('Y-m-d H:i:s')."', '1');");

        /*history table data 2*/

        $this->db->query("INSERT INTO `yvdnsddqu_trainer_package_purchases_history` (`package_purchase_history_id`, `stripe_customer_id`, `trainer_email`, `package_id`, `package_price`, `txn_id`, `subscription_id`, `subscription_payment_iteration`, `date_added`, `is_active`) VALUES (NULL, 'cus_JsEEwySokAiLOw', 'development0261+10@gmail.com', '5', '40', 'JsdTNoxuL10zaK', 'sub_JsZvNMblB3dsFo', '1', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_package_purchases_history` (`package_purchase_history_id`, `stripe_customer_id`, `trainer_email`, `package_id`, `package_price`, `txn_id`, `subscription_id`, `subscription_payment_iteration`, `date_added`, `is_active`) VALUES (NULL, 'cus_JsEEwySokAiLOw', 'development0261+10@gmail.com', '6', '60', 'JsdTNoxuL82ion', 'sub_JoX2qSt0NaTt4J', '2', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_package_purchases_history` (`package_purchase_history_id`, `stripe_customer_id`, `trainer_email`, `package_id`, `package_price`, `txn_id`, `subscription_id`, `subscription_payment_iteration`, `date_added`, `is_active`) VALUES (NULL, 'cus_JsEEwySokAiLOw', 'development0261+10@gmail.com', '7', '90', 'JseTNoxuL89saK', 'sub_JoZbEIyBfNpAMh', '3', '".date('Y-m-d H:i:s')."', '1');");
    }    

    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_trainer_package_purchases_history');
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */