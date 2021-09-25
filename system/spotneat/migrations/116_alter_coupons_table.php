<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Alter stripe_keys_fields_table
 */
class Migration_Alter_Coupons_Table extends CI_Migration { 
 
    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_coupons` ADD `is_fd_type_percent` TINYINT(1) NULL AFTER `discount`;");         
    }    

    public function down() {
        
    }
}

/* End of file 111_alter_stripe_keys_fields_table */
/* Location: ./setup/migrations/111_alter_stripe_keys_fields_table */