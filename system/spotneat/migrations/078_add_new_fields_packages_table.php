<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_add_new_fields_packages_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_packages` ADD `parent_id` INT NULL AFTER `package_name`;");
        /*pro*/
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Up to 5 Clients', 2, '20', 'Day', 'prod_JsdTNoxuL82zaK', 'price_1JEsCCKCqIz4jCDx40E63U5z', '5', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Up to 15 Clients', 2, '40', 'Day', 'prod_JsdTBMJIyiSmWq', 'price_1JEsCoKCqIz4jCDxN920hZ6T', '15', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Up to 30 Clients', 2, '60', 'Day', 'prod_JsdUkVTduOrEA3', 'price_1JEsDCKCqIz4jCDx2AhEliPG', '30', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Up to 50 Clients', 2, '90', 'Day', 'prod_JsdUIOdXWBIXQm', 'price_1JEsDcKCqIz4jCDxP6U3pvus', '50', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Up to 75 Clients', 2, '125', 'Day', 'prod_JsdVIm2Ydc8T1I', 'price_1JEsE1KCqIz4jCDxXneJceRI', '75', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Up to 100 Clients', 2, '160', 'Day', 'prod_JsdVcGEeVkoz8q', 'price_1JEsELKCqIz4jCDxhWn4cAgV', '100', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Up to 200 Clients', 2, '200', 'Day', 'prod_JsdVKM5l9sA9AY', 'price_1JEsEkKCqIz4jCDxKpylkDD4', '200', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Unlimited Clients', 2, '300', 'Day', 'prod_JsdTNoxuL82zaK', 'price_1JEsCCKCqIz4jCDx40E63U5z', '', '".date('Y-m-d H:i:s')."', '1');");

        /*Studio*/
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Up to 500 Clients', 3, '250', 'Day', 'prod_JsdW2lgM414Wja', 'price_1JEsFYKCqIz4jCDxYrYMSapA', '500', '".date('Y-m-d H:i:s')."', '1');");
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `parent_id`, `package_price`, `package_duration`, `stripe_product_key`, `stripe_price_key`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Unlimited Clients', 3, '350', 'Day', 'prod_JsdWSLFHTMSqWI', 'price_1JEsFwKCqIz4jCDxKxlejQ4Q', '', '".date('Y-m-d H:i:s')."', '1');");
    }    

    public function down() {
    }


 
}

/* End of file 078_add_new_fields_packages_table.php */
/* Location: ./setup/migrations/078_add_new_fields_packages_table.php */