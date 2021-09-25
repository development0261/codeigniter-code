<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Workout_Video_Purchases_Fixed_Entries_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_workout_video_purchases_onetime_payments` (
            `fixed_payment_id` int(11) NOT NULL AUTO_INCREMENT,
            `email` VARCHAR(51) DEFAULT NULL,
            `txn_id` VARCHAR(111) DEFAULT NULL,            
            `charge_id` VARCHAR(111) DEFAULT NULL,
            `purchase_date` datetime DEFAULT NULL,
            PRIMARY KEY (`fixed_payment_id`)
           ) ENGINE=InnoDB;");
    }   
    
    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_workout_video_purchases_onetime_payments');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */