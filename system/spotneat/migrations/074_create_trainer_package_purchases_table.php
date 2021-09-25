<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Create_Trainer_Package_Purchases_Table extends CI_Migration { 

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_trainer_package_purchases` (
          `package_purchase_id` INT(11) NOT NULL AUTO_INCREMENT,
          `trainer_id` INT(11) DEFAULT NULL,
          `package_id` INT(11) DEFAULT NULL,
          `package_price` FLOAT(10,2) DEFAULT NULL,
          `txn_id` INT(11) DEFAULT NULL,
          `subscription_id` INT(11) DEFAULT NULL,
          `subscription_payment_iteration` INT(5) DEFAULT NULL,
          `date_added` datetime DEFAULT NULL,
          `is_active` TINYINT(1) DEFAULT NULL,

            PRIMARY KEY (`package_purchase_id`)
           ) ENGINE=InnoDB;");
    }    

    public function down() {
        $this->dbforge->drop_table('trainer_package_purchases');
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */