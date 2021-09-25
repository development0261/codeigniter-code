<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Alter stripe_keys_fields_table
 */
class Migration_Alter_Schedule_Notifications_Table extends CI_Migration { 
 
    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_schedule_notifications` ADD `locationIds` varchar(255) NULL AFTER sent_to;");
         
    }    
    public function down() {
        
    }
}

/* End of file 111_alter_stripe_keys_fields_table */
/* Location: ./setup/migrations/111_alter_stripe_keys_fields_table */