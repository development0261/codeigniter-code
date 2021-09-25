<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Create_Eat_Right_Pdf_Table extends CI_Migration { 

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_eat_right_pdf` (
          `eat_right_pdf_id` INT(11) NOT NULL AUTO_INCREMENT,
          `pdf_title` VARCHAR(111) DEFAULT NULL,
          `pdf_image_name` VARCHAR(111) DEFAULT NULL,
          `date_added` datetime DEFAULT NULL,
          `is_active` TINYINT(1) DEFAULT NULL,

            PRIMARY KEY (`eat_right_pdf_id`)
           ) ENGINE=InnoDB;");
    }    

    public function down() {
        $this->dbforge->drop_table('eat_right_pdf');
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */