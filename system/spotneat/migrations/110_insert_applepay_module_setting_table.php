<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * create 110_insert_applepay_module_setting_table
 */
class Migration_Insert_Applepay_Module_Setting_Table extends CI_Migration { 

    public function up() {

        $this->db->query("INSERT INTO `yvdnsddqu_module_setting` (`id` ,`title`, `description`, `enabled`, `created`, `modified`) VALUES (NULL, 'PersonalTrainerApplePay', 'PersonalTrainerApplePay', '1', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');");
    }    

    public function down() {
        
    }
}

/* End of file 110_insert_applepay_module_setting_table */
/* Location: ./setup/migrations/110_insert_applepay_module_setting_table */