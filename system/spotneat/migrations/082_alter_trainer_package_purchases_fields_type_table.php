<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_alter_trainer_package_purchases_fields_type_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` CHANGE `txn_id` `txn_id` VARCHAR(111) DEFAULT NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` CHANGE `subscription_id` `subscription_id` VARCHAR(111) DEFAULT NULL;");
    }    

    public function down() {
    }

}

/* End of file 082_add_data_trainer_package_purchases_table.php */
/* Location: ./setup/migrations/082_add_data_trainer_package_purchases_table.php */