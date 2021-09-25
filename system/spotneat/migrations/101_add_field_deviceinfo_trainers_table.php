<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * add yvdnsddqu_trainers (deviceInfo)
 */
class Migration_Add_Field_Deviceinfo_Trainers_Table extends CI_Migration { 

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_trainers` ADD `deviceInfo` text NULL AFTER deviceid;");
    }    

    public function down() {
    }
}

/* End of file 101_add_field_deviceinfo_trainers_table.php */
/* Location: ./setup/migrations/101_add_field_deviceinfo_trainers_table.php */