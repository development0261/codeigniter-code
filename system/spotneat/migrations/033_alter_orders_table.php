<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Orders_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_orders` ADD `coupon_type` CHAR(2) NULL AFTER `coupon_code`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_orders` DROP COLUMN `coupon_type`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */