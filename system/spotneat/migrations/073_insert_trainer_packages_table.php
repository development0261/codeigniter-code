<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_Insert_Trainer_Packages_table extends CI_Migration {

    public function up() {
      
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `package_price`, `package_duration`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Grow', '5', 'Month', '2', '".date('Y-m-d H:i:s')."', '1');");
        
        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `package_price`, `package_duration`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Pro', '20', 'Month', '5', '".date('Y-m-d H:i:s')."', '1');");

        $this->db->query("INSERT INTO `yvdnsddqu_trainer_packages` (`package_id`, `package_name`, `package_price`, `package_duration`, `packag_client_limit`, `date_added`, `status`) VALUES (NULL, 'Studio', '250', 'Month', '500', '".date('Y-m-d H:i:s')."', '1');");
    }   
    
    public function down() {
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */