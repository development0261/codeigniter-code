<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_update_duration_of_existing_packages_Table extends CI_Migration { 

    public function up() {
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `package_duration` = 'Day' WHERE `package_id` = '1' ");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `package_duration` = 'Day' WHERE `package_id` = '2' ");
        $this->db->query("UPDATE `yvdnsddqu_trainer_packages` SET `package_duration` = 'Day' WHERE `package_id` = '3' ");
    }    

    public function down() {
    }
}

/* End of file 079_update_duration_of_existing_packages_table.php */
/* Location: ./setup/migrations/079_update_duration_of_existing_packages_table.php */