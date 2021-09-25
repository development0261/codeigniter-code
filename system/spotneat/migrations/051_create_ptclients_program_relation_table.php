<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Ptclients_Program_Relation_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_ptclients_program_relation` (
            `clients_program_id` int(11) NOT NULL AUTO_INCREMENT,
            `pt_client_id` int(11) DEFAULT NULL,
            `trainer_program_id` int(11) DEFAULT NULL,            
            `custom_values` TEXT DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            PRIMARY KEY (`clients_program_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_ptclients_program_relation');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */