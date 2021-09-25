<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Countries_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_countries` CHANGE `country_name` `country_name` VARCHAR(121) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
        ");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_countries` CHANGE `country_name` `country_name` VARCHAR(125) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
        ");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */