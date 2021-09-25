<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * change field packag_client_limit type trainer packages table
 */
class Migration_Alter_Packag_Client_Limit_Field_Trainer_Packages_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_packages` CHANGE `packag_client_limit` `packag_client_limit` TEXT DEFAULT NULL;");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `packag_client_limit` = 'Unlimited' WHERE `package_id` IN (14,17,18)");
    }    

    public function down() {
        
    }
}

/* End of file 096_alter_packag_client_limit_field_trainer_packages_table.php */
/* Location: ./setup/migrations/096_alter_packag_client_limit_field_trainer_packages_table.php */