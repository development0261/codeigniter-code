<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Trainers_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` CHANGE `instagram_link` `instagram_link` TEXT DEFAULT NULL;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `facebook_link` TEXT DEFAULT NULL AFTER `instagram_link`;");
    }    

    public function down() {
    }
 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */