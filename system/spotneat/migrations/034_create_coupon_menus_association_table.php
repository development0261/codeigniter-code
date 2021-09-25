<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_Coupon_Menus_Association_table extends CI_Migration {

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_coupon_menus_association` (
            `association_id` int(11) NOT NULL AUTO_INCREMENT,
            `coupon_id` int(11) DEFAULT NULL,
            `menu_id` int(11) DEFAULT NULL,
            `location_id` int(11) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`association_id`)
           ) ENGINE=InnoDB;");
    }

    public function down() {
        $this->dbforge->drop_table('coupon_menus_association');
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */