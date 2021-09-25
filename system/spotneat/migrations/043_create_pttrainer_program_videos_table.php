<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Pttrainer_Program_Videos_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_pttrainer_program_videos` (
            `pt_trainer_program_video_id` int(11) NOT NULL AUTO_INCREMENT,
            `trainer_program_id` int(11) DEFAULT NULL,
            `trainer_id` int(11) DEFAULT NULL,
            `title` VARCHAR(111) DEFAULT NULL,
            `video_url` TEXT DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`pt_trainer_program_video_id`)
           ) ENGINE=InnoDB;");
    }    

    public function down() {
        $this->dbforge->drop_table('pttrainer_program_videos');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */