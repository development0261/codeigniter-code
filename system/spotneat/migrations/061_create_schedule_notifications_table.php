<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Schedule_Notifications_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_schedule_notifications` (
            `schedule_notification_id` int(11) NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) DEFAULT NULL,
            `message` TEXT DEFAULT NULL,    
            `schedule_date` datetime DEFAULT NULL,
            `schedule_type` VARCHAR(21) DEFAULT NULL,
            `sent` enum('Yes','No','Failed','Inprocess') DEFAULT NULL,  
            `sent_to` VARCHAR(51) DEFAULT NULL,          
            `web_url` VARCHAR(255) DEFAULT NULL,            
            `date_created` datetime DEFAULT NULL,
            PRIMARY KEY (`schedule_notification_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_schedule_notifications');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */