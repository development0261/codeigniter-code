<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Pttrainer_Program_Tags_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_pttrainer_program_tags` (
            `pt_trainer_program_tag_id` int(11) NOT NULL AUTO_INCREMENT,
            `tag_name` VARCHAR(111) DEFAULT NULL,
            `parent_id` int(11) DEFAULT NULL,            
            `date_added` datetime DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`pt_trainer_program_tag_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('pttrainer_program_tags');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */