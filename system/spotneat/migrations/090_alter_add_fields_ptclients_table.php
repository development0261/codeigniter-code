<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Added new column is_deleted
 */
class Migration_Alter_Add_Fields_Ptclients_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_ptclients` ADD `is_deleted` TINYINT(1) DEFAULT 1 NULL COMMENT '0=Deleted, 1=Not Deleted' AFTER `status`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_ptclients` DROP COLUMN `is_deleted`;");
    }
}

/* End of file 090_alter_add_fields_ptclients_table.php */
/* Location: ./setup/migrations/090_alter_add_fields_ptclients_table.php */