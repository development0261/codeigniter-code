<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Schedule_Notifications_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` ADD `page_url` VARCHAR(51) NULL AFTER `sent_to`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` DROP COLUMN `page_url`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */