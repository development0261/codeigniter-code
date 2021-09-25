<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Alter_Ptclients_Program_Relation_Table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `yvdnsddqu_ptclients_program_relation` ADD `pt_client_program_category_id` INT(11) NULL AFTER `trainer_program_id`;");
    }

    public function down() {
        $this->db->query("ALTER TABLE `yvdnsddqu_ptclients_program_relation` DROP COLUMN `pt_client_program_category_id`;");
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */