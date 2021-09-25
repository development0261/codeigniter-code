<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Create_Trainer_Packages_Table extends CI_Migration {

 

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_trainer_packages` (
          `package_id` int(11) NOT NULL AUTO_INCREMENT,
          `package_name` varchar(51) DEFAULT NULL,
          `package_price` FLOAT(10,2) DEFAULT NULL,
          `package_duration` varchar(21) DEFAULT NULL,
          `packag_client_limit` int(5) DEFAULT NULL,
          `date_added` datetime DEFAULT NULL,
          `status` TINYINT(1) DEFAULT NULL,

            PRIMARY KEY (`package_id`)
           ) ENGINE=InnoDB;");

    }    

    public function down() {
        $this->dbforge->drop_table('trainer_packages');
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */