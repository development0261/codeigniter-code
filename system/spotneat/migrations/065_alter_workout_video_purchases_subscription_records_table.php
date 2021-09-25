<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Workout_Video_Purchases_Subscription_Records_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_workout_video_purchases_subscription_records` ADD `is_active` TINYINT(1) NULL AFTER `subscription_id`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_workout_video_purchases_subscription_records` DROP COLUMN `is_active`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */