<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Workout_Video_Purchases_User_Confirmations_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_workout_video_purchases_user_confirmations` (
            `user_confirmation_id` int(11) NOT NULL AUTO_INCREMENT,
            `email` VARCHAR(51) DEFAULT NULL,
            `purchase_type` VARCHAR(21) DEFAULT NULL,            
            `is_agreed_to_continue` TINYINT(1) DEFAULT NULL,
            `date_created` datetime DEFAULT NULL,
            PRIMARY KEY (`user_confirmation_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_workout_video_purchases_user_confirmations');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */