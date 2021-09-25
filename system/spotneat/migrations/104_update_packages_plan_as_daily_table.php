<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * update details as daily basis yvdnsddqu_trainer_packages
 */
class Migration_Update_Packages_Plan_As_Daily_Table extends CI_Migration { 

    public function up() {
        $this->db->query("UPDATE yvdnsddqu_trainer_packages SET `stripe_product_key` = 'prod_JvaQ1siP4YdD6R', `stripe_price_key` = 'price_1JHjFBKCqIz4jCDxzVbm6ITa', `package_duration` = 'Day' WHERE package_id = 2");
        $this->db->query("UPDATE yvdnsddqu_trainer_packages SET `stripe_product_key` = 'prod_JvaRK2wQeB1Vps', `stripe_price_key` = 'price_1JHjGLKCqIz4jCDx3ZvgfMSc', `package_duration` = 'Day' WHERE package_id = 16");
        $this->db->query("UPDATE yvdnsddqu_trainer_packages SET `stripe_product_key` = 'prod_JvaS7CDdvoaZ22', `stripe_price_key` = 'price_1JHjHJKCqIz4jCDxnpwgug56', `package_duration` = 'Day' WHERE package_id = 17");
    }    

    public function down() {
    }
}

/* End of file 104_update_packages_plan_as_daily_table.php */
/* Location: ./setup/migrations/104_update_packages_plan_as_daily_table.php */