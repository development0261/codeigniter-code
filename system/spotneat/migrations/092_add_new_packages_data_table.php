<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Add_new_packages_data_Table extends CI_Migration { 

    public function up() {
        /*Update existing plan to deactivate*/
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `status` = 0");
        /*update pro plan with new data*/
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `package_price` = 25, `packag_client_limit` = 30 WHERE `package_id` = '2'");

        /*Add new plans with duration*/

        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (14, 'Trial plan', 0, '', 'Weekly', '', '', '', '".date('Y-m-d H:i:s')."', '1');");

        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (15, 'Free', 0, '', 'Weekly', '', '', '1', '".date('Y-m-d H:i:s')."', '1');");

        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (16, 'Let\'s Go', 0, 7, 'Weekly', 'prod_Ju8UnAbbC6ZKKD', 'price_1JGKDwKCqIz4jCDxamEMrL5D', '10', '".date('Y-m-d H:i:s')."', '1');");

        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (17, 'Ultimate', 0, 99, 'Weekly', 'prod_Ju8WdJJP72KQzl', 'price_1JGKFDKCqIz4jCDxRxAUNH1o', '', '".date('Y-m-d H:i:s')."', '1');");

        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (18, 'VIP Pass', 0, '', 'Weekly', '', '', '', '".date('Y-m-d H:i:s')."', '1');");
    }    

    public function down() {
    }
}

/* End of file 092_add_new_packages_data_table.php */
/* Location: ./setup/migrations/092_add_new_packages_data_table.php */