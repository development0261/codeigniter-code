<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Pttrainer_Program_Videos_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_pttrainer_program_videos` ADD `image_url` TEXT NULL AFTER `video_url`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_pttrainer_program_videos` DROP COLUMN `image_url`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */