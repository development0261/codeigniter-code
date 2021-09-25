<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * add yvdnsddqu_trainers (deviceInfo)
 */
class Migration_Update_packages_data_duration_table extends CI_Migration { 

    public function up() {
        $this->db->query("UPDATE yvdnsddqu_trainer_packages SET `package_duration` = 'Weekly' WHERE package_id = 2");
    }    

    public function down() {
    }
}

/* End of file 102_update_packages_data_duration_table.php */
/* Location: ./setup/migrations/102_update_packages_data_duration_table.php */