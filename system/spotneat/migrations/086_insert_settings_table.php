<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_insert_settings_table extends CI_Migration {

    public function up() {

        $this->db->query("INSERT INTO `yvdnsddqu_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES (NULL, 'EAT_RIGHT_PDF', 'EAT_RIGHT_PDF', 'sample.pdf', '0');");
    }   
    
    public function down() {
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */