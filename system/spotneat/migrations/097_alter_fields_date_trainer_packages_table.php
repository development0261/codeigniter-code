<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * change field packag_client_limit type trainer packages table
 */
class Migration_Alter_Fields_Date_Trainer_Packages_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` CHANGE `expiry_date` `subscription_end_date` DATE DEFAULT NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` ADD `subscription_start_date` DATE NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` ADD `subscription_code` DATE NULL;");

        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases_history` CHANGE `expiry_date` `subscription_end_date` DATE DEFAULT NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases_history` ADD `subscription_start_date` DATE NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases_history` ADD `subscription_code` DATE NULL;");
        

        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `package_duration` = '30 days' WHERE `package_id` = 14");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `package_duration` = 'Unlimited' WHERE `package_id` = 15");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `package_duration` = 'Unlimited' WHERE `package_id` = 18");
    }    

    public function down() {
        
    }
}

/* End of file 097_alter_fields_date_trainer_packages_table.php */
/* Location: ./setup/migrations/097_alter_fields_date_trainer_packages_table.php */