<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Workout_Video_Purchases_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_workout_video_purchases` ADD `subscription_id` varchar(111) NULL AFTER `charge_id`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_workout_video_purchases` ADD `is_active` TINYINT(1) NULL AFTER `message`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_workout_video_purchases` ADD `subscription_payment_iteration` INT(5) NULL AFTER `is_active`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_workout_video_purchases` DROP COLUMN `is_active`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_workout_video_purchases` DROP COLUMN `subscription_payment_iteration`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */