<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_update_settings_table extends CI_Migration {

    public function up() {

        $this->db->query("UPDATE `yvdnsddqu_settings` SET `sort` = 'config' WHERE `yvdnsddqu_settings`.`item` = 'EAT_RIGHT_PDF';");
    }   
    
    public function down() {
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */