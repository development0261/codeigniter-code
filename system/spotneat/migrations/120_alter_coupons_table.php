<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add column coupons to the order_restriction table
 * Add unique index code to the coupons table
 */
class Migration_alter_coupons_table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons')." DROP INDEX `code`;");
    }

    public function down() {
    }
}

/* End of file 011_add_column_order_restriction_to_coupons_table.php */
/* Location: ./setup/migrations/011_add_column_order_restriction_to_coupons_table.php */