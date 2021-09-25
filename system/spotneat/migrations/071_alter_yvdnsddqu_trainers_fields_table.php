<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_yvdnsddqu_trainers_fields_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `business_name` VARCHAR(255) NULL AFTER `courses`, ADD `business_type` VARCHAR(255) NULL AFTER `business_name`, ADD `user_type` ENUM('Trainer','PersonalTrainer') DEFAULT 'Trainer' AFTER `business_type`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `business_name`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `business_type`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `user_type`;");
    }
}

/* End of file 071_alter_yvdnsddqu_trainers_fields_table.php */
/* Location: ./setup/migrations/071_alter_yvdnsddqu_trainers_fields_table.php */