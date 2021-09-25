<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Alter stripe_keys_fields_table
 */
class Migration_Alter_Stripe_Keys_Fields_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_stripe_key_pttrainer` ADD `merchantId` text NULL AFTER mode;");
        $this->db->query("UPDATE `yvdnsddqu_stripe_key_pttrainer` SET `merchantId`='merchant.com.technowandpt.gym'");
    }    

    public function down() {
        
    }
}

/* End of file 111_alter_stripe_keys_fields_table */
/* Location: ./setup/migrations/111_alter_stripe_keys_fields_table */