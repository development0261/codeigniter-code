<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Time_Zones_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_time_zones` (
            `time_zone_id` int(11) NOT NULL AUTO_INCREMENT,
            `time_zone_name` VARCHAR(51) DEFAULT NULL,
            PRIMARY KEY (`time_zone_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_time_zones');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */