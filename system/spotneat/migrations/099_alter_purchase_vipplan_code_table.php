<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * change yvdnsddqu_purchase_vipplan_code
 */
class Migration_Alter_Purchase_Vipplan_Code_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_purchase_vipplan_code` CHANGE `code` `code` VARCHAR(255) DEFAULT NULL;");
    }    

    public function down() {
    }
}

/* End of file 099_alter_purchase_vipplan_code_table.php */
/* Location: ./setup/migrations/099_alter_purchase_vipplan_code_table.php */