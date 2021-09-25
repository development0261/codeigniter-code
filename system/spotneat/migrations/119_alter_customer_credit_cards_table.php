<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Alter stripe_keys_fields_table
 */
class Migration_Alter_Customer_Credit_Cards_Table extends CI_Migration { 
 
    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_customer_credit_cards` ADD `brand_name` VARCHAR(55) NULL AFTER `card_name`;");         
    }    

    public function down() {
        
    }
}

/* End of file 111_alter_stripe_keys_fields_table */
/* Location: ./setup/migrations/111_alter_stripe_keys_fields_table */