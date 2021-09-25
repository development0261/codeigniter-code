<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Ptservices_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_ptservices` (
            `pt_service_id` int(11) NOT NULL AUTO_INCREMENT,
            `service_name` VARCHAR(111) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`pt_service_id`)
           ) ENGINE=InnoDB;");
    }    

    public function down() {
        $this->dbforge->drop_table('ptservices');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */