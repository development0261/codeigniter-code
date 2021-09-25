<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Schedule_Notifications_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` ADD `recurring_start_date` datetime NULL AFTER `schedule_date`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` ADD `recurring_end_date` datetime NULL AFTER `recurring_start_date`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` ADD `recurring_type` VARCHAR(21) NULL AFTER `schedule_type`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` DROP COLUMN `recurring_start_date`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` DROP COLUMN `recurring_end_date`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` DROP COLUMN `recurring_type`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */