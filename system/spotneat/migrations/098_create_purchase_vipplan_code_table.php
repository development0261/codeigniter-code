<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * change field packag_client_limit type trainer packages table
 */
class Migration_Create_Purchase_Vipplan_Code_Table extends CI_Migration { 

    public function up() {
        $this->db->query("CREATE TABLE `yvdnsddqu_purchase_vipplan_code` (
            `passcode_id` int(11) NOT NULL AUTO_INCREMENT,
            `code` int(11) DEFAULT NULL,
            `is_active` int(11) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            PRIMARY KEY (`passcode_id`)
           ) ENGINE=InnoDB;");
    }    

    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_purchase_vipplan_code');
    }
}

/* End of file 098_create_purchase_vipplan_code_table.php */
/* Location: ./setup/migrations/098_create_purchase_vipplan_code_table.php */