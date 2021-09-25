<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Menus_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_menus` ADD `is_shake_of_the_month` TINYINT(1) NULL AFTER `location_id`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_menus` ADD `resturant_owner_comment` VARCHAR(111) NULL AFTER `is_shake_of_the_month`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_menus` DROP COLUMN `is_shake_of_the_month`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_menus` DROP COLUMN `resturant_owner_comment`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */