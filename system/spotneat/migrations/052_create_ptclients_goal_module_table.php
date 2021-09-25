<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Ptclients_Goal_Module_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_ptclients_goal_module` (
            `pt_client_goal_module_id` int(11) NOT NULL AUTO_INCREMENT,
            `pt_client_id` int(11) DEFAULT NULL,
            `trainer_id` int(11) DEFAULT NULL,
            `title` VARCHAR(555) DEFAULT NULL, 
            `order` int(5) DEFAULT NULL,
            `progress_percent` int(5) DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            PRIMARY KEY (`pt_client_goal_module_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('ptclients_goal_module');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */