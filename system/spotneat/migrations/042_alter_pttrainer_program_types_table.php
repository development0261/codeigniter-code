<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Pttrainer_Program_Types_Table extends CI_Migration {

    public function up() {
        $this->db->query("CREATE TABLE `yvdnsddqu_pttrainer_program_types` (
            `pt_trainer_program_type_id` int(11) NOT NULL AUTO_INCREMENT,
            `type_name` VARCHAR(111) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            `status` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`pt_trainer_program_type_id`)
           ) ENGINE=InnoDB;");
   }

    /*
    * pt_trainer_program_type_id
    * type_name
    */

    public function down() {
        $this->dbforge->drop_table('pttrainer_program_types');
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */