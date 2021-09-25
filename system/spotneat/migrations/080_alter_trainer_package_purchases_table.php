<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Trainer_Package_Purchases_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` CHANGE `trainer_id` `stripe_customer_id` VARCHAR(111) NULL DEFAULT NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` ADD `trainer_email` TEXT NULL AFTER `stripe_customer_id`;");
    }    

    public function down() {
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */