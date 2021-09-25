<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Trainers_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `skype` VARCHAR(51) NULL AFTER `telephone`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `gender` VARCHAR(11) NULL AFTER `skype`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `country` VARCHAR(51) NULL AFTER `gender`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `city` VARCHAR(51) NULL AFTER `country`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `device_time_zone` VARCHAR(111) NULL AFTER `city`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `timezone` VARCHAR(111) NULL AFTER `device_time_zone`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `skype`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `gender`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `country`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `city`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `device_time_zone`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` DROP COLUMN `timezone`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */