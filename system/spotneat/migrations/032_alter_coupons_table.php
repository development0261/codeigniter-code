<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Coupons_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_coupons` ADD `is_all_menus_discount` TINYINT(1) NOT NULL DEFAULT '0' AFTER `order_restriction`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_coupons` ADD `is_one_time_discount` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_all_menus_discount`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_coupons` DROP COLUMN `is_all_menus_discount`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_coupons` DROP COLUMN `is_one_time_discount`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */