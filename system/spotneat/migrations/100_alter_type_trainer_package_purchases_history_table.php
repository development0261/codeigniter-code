<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * change yvdnsddqu_purchase_vipplan_code
 */
class Migration_Alter_type_trainer_package_purchases_history_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` CHANGE `subscription_code` `subscription_code` VARCHAR(255) DEFAULT NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases_history` CHANGE `subscription_code` `subscription_code` VARCHAR(255) DEFAULT NULL;");
    }    

    public function down() {
    }
}

/* End of file 100_alter_type_trainer_package_purchases_history_table.php */
/* Location: ./setup/migrations/100_alter_type_trainer_package_purchases_history_table.php */