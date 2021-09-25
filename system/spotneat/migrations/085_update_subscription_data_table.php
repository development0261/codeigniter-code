<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Update_Subscription_Data_Table extends CI_Migration { 

    public function up() {
        $this->db->query("UPDATE `yvdnsddqu_trainer_package_purchases` SET `trainer_email` = 'test21@gmail.com' WHERE package_purchase_id = 1");
        $this->db->query("UPDATE `yvdnsddqu_trainer_package_purchases_history` SET `trainer_email` = 'test21@gmail.com' WHERE package_purchase_history_id IN (1,2,3) ");
    }    

    public function down() {
    }
 
}

/* End of file 085_update_subscription_data_table.php */
/* Location: ./setup/migrations/085_update_subscription_data_table.php */