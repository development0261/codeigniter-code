<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * add yvdnsddqu_trainers (deviceInfo)
 */
class Migration_Update_packages_plan_details_table extends CI_Migration { 

    public function up() {
        $this->db->query("UPDATE yvdnsddqu_trainer_packages SET `stripe_product_key` = 'prod_JvL0xlGHy0dRQo', `stripe_price_key` = 'price_1JHUK6KCqIz4jCDx1TVezFXw' WHERE package_id = 2");
    }    

    public function down() {
    }
}

/* End of file 103_update_packages_plan_details_table.php */
/* Location: ./setup/migrations/103_update_packages_plan_details_table.php */