<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Added new column is_deleted
 */
class Migration_Add_Field_Expirydate_Package_Purchases_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` ADD `expiry_date` DATE NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases_history` ADD `expiry_date` DATE NULL;");
    }    

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases` DROP COLUMN `expiry_date`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_package_purchases_history` DROP COLUMN `expiry_date`;");
    }
}

/* End of file 093_add_field_expirydate_package_purchases_table.php */
/* Location: ./setup/migrations/093_add_field_expirydate_package_purchases_table.php */