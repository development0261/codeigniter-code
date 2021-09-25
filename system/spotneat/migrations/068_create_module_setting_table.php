<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_Create_Module_Setting_Table extends CI_Migration {

 

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_module_setting` (
            `id` int(11) NOT NULL AUTO_INCREMENT,

          `title` varchar(255) NOT NULL,
          `description` varchar(255) NOT NULL,
          `enabled` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1 = enabled , 0 = disabled',
          `created` datetime NOT NULL,
          `modified` datetime NOT NULL,

            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB;");


/*

        $this->db->insert('module_setting', array(
            'id'   => '1',
            'title'          => 'Shakes',
            'description'       => 'Shakes',
            'enabled'          => '1',
            'created'    => mdate('%Y-%m-%d', time()),
            'modified'  => mdate('%Y-%m-%d', time()),
        ));


        $this->db->insert('module_setting', array(
            'id'   => '2',
            'title'          => 'Lee Priest',
            'description'       => 'Lee Priest',
            'enabled'          => '1',
            'created'    => mdate('%Y-%m-%d', time()),
            'modified'  => mdate('%Y-%m-%d', time()),
        ));


        $this->db->insert('module_setting', array(
            'id'   => '3',
            'title'          => 'Personal Trainer',
            'description'       => 'Personal Trainer',
            'enabled'          => '1',
            'created'    => mdate('%Y-%m-%d', time()),
            'modified'  => mdate('%Y-%m-%d', time()),
        ));


*/










    }    



    public function down() {
        $this->dbforge->drop_table('module_setting');
    }


 
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */