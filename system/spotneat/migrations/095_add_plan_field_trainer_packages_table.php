<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add plan field trainer packages table
 */
class Migration_Add_Plan_Field_Trainer_Packages_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_packages` ADD `display_order` TINYINT(1) NULL COMMENT 'Plan display order to view' AFTER `status`;");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `display_order` = 1 WHERE `package_id` = '14'");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `display_order` = 2 WHERE `package_id` = '15'");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `display_order` = 3 WHERE `package_id` = '16'");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `display_order` = 4 WHERE `package_id` = '2'");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `display_order` = 5 WHERE `package_id` = '17'");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `display_order` = 6 WHERE `package_id` = '18'");
    }    

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_packages` DROP COLUMN `display_order`;");
    }
}

/* End of file 095_add_plan_field_trainer_packages_table.php */
/* Location: ./setup/migrations/095_add_plan_field_trainer_packages_table.php */