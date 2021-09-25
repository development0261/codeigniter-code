<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Ptclients_Program_Categories_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_ptclients_program_categories` (
            `pt_client_program_category_id` int(11) NOT NULL AUTO_INCREMENT,
            `category_name` VARCHAR(51) DEFAULT NULL, 
            `status` tinyint(1) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            PRIMARY KEY (`pt_client_program_category_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('ptclients_program_categories');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */