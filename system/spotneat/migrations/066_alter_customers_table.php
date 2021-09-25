<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Customers_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_customers` ADD `deviceInfo` TEXT NULL AFTER `deviceid`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_customers` DROP COLUMN `yvdnsddqu_customers`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */