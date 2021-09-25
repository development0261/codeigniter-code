<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Update pro plan status
 */
class Migration_Alter_Plan_Package_Table extends CI_Migration { 

    public function up() {
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `status` = 1 WHERE `package_id` = '2'");
    }    

    public function down() {
        
    }
}

/* End of file 094_alter_plan_package_table.php */
/* Location: ./setup/migrations/094_alter_plan_package_table.php */