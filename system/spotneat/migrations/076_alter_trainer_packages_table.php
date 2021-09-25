<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Trainer_Packages_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_packages` ADD `stripe_product_key` TEXT NULL AFTER `package_duration`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_packages` ADD `stripe_price_key` TEXT NULL AFTER `stripe_product_key`;");

        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `stripe_product_key` = 'prod_JsPW1QKiRcGHG3', `stripe_price_key` = 'price_1JEehuJpxyLWDkuoeZxQkB8v' WHERE `package_id` = '1' ");
        
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `stripe_product_key` = 'prod_JsPYsqhz0CJF9Y', `stripe_price_key` = 'price_1JEejcJpxyLWDkuo9IZZNcBJ' WHERE `package_id` = '2' ");

        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `stripe_product_key` = 'prod_JsPZa9bmKYgVA7', `stripe_price_key` = 'price_1JEekYJpxyLWDkuoWFjxEmF0' WHERE `package_id` = '3' ");
    }    

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_packages` DROP COLUMN `stripe_product_key`;");
        $this->db->query("ALTER TABLE `yvdnsddqu_trainer_packages` DROP COLUMN `stripe_price_key`;");
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */