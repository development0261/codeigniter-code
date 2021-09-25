<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Ptclients_Program_Schedule_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_ptclients_program_schedule` (
            `clients_program_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
            `clients_program_id` int(11) DEFAULT NULL,
            `pt_client_id` int(11) DEFAULT NULL,
            `trainer_program_id` int(11) DEFAULT NULL,
            `pt_client_program_category_id` int(11) DEFAULT NULL,            
            `schedule_date` DATE DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            PRIMARY KEY (`clients_program_schedule_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_ptclients_program_schedule');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */