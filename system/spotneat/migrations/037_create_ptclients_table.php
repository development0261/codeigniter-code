<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Ptclients_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_ptclients` (
            `pt_client_id` int(11) NOT NULL AUTO_INCREMENT,
            `first_name` VARCHAR(51) DEFAULT NULL,
            `last_name` VARCHAR(51) DEFAULT NULL,
            `phone` VARCHAR(21) DEFAULT NULL,
            `trainer_id` int(11) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`pt_client_id`)
           ) ENGINE=InnoDB;");
    }

    public function down() {
        $this->dbforge->drop_table('ptclients');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */