<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Alter stripe_keys_fields_table
 */
class Migration_Alter_Coupons_Table extends CI_Migration { 
 
    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_coupons` ADD `is_public_access` TINYINT(1) NULL AFTER `order_restriction`;");  
               
        $this->db->query("UPDATE `yvdnsddqu_coupons` SET `is_public_access` = '1';"); 
    }    

    public function down() {
        
    }
}

/* End of file 111_alter_stripe_keys_fields_table */
/* Location: ./setup/migrations/111_alter_stripe_keys_fields_table */