<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Create_Webcalculators_Table extends CI_Migration {

 

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_webcalculators` (
            `id` int(11) NOT NULL AUTO_INCREMENT,

          `url` varchar(255) NOT NULL,
          `description` varchar(255) NOT NULL,
         
          `created` datetime NOT NULL,
         

            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB;");

 






    }    



    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_webcalculators');
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */