<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Alter stripe_keys_fields_table
 */
class Migration_Update_Stripe_Keys_Devdetails_Fields_Table extends CI_Migration { 

    public function up() {
        $this->db->query("UPDATE `yvdnsddqu_stripe_key_pttrainer` SET `public_key` = 'pk_test_51JElSfKCqIz4jCDxNglIbNfepZBtBiuMLVLJDZvQlZrhuSnsgVOKGPYQxZY12rls5EVpJMenxvoHgHR2bKajYMVr00wGmpzf3q', `secret_key` = 'sk_test_51JElSfKCqIz4jCDxMPBDodXGrPTQ0WIbHmHpDB5494FIXqhbuKbQ88Do5JdasAmJt8jk4dtHXacn7ApHzfgpTAcu005upfvl1L' WHERE `id` = 1 ");
    }    

    public function down() {
        
    }
}

/* End of file 112_update_stripe_keys_devdetails_fields_table */
/* Location: ./setup/migrations/112_update_stripe_keys_devdetails_fields_table */