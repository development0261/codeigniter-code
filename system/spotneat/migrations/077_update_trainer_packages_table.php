<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Update_Trainer_Packages_Table extends CI_Migration { 

    public function up() {

        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `stripe_product_key` = 'prod_JsWiOuIAGvcRtk', `stripe_price_key` = 'price_1JElfCKCqIz4jCDxcTe2Czua' WHERE `package_id` = '1' ");
        
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `stripe_product_key` = 'prod_JsWlGKxGYGK6Yh', `stripe_price_key` = 'price_1JElhqKCqIz4jCDxyy8ErVdR' WHERE `package_id` = '2' ");

        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `stripe_product_key` = 'prod_JsWmeywvlp7p2P', `stripe_price_key` = 'price_1JElj1KCqIz4jCDxhDSrzk4t' WHERE `package_id` = '3' ");
    }    

    public function down() {
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */