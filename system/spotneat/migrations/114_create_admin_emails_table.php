<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * update details as daily basis yvdnsddqu_trainer_packages
 */
class Migration_Create_Admin_Emails_Table extends CI_Migration { 

    public function up() {

        $this->db->query("CREATE TABLE `yvdnsddqu_admin_emails` (
            `admin_email_id` int(11) NOT NULL AUTO_INCREMENT,
            `location_name` varchar(111) NOT NULL,
            `location_id` int(5) DEFAULT NULL,
            `admin_to_email` varchar(55) DEFAULT NULL,
            `admin_cc_email` varchar(55) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,            
            `status` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`admin_email_id`)
           ) ENGINE=InnoDB;");

        $this->db->query("INSERT INTO `yvdnsddqu_admin_emails` (`admin_email_id` ,`location_name`, `location_id`, `admin_to_email`, `admin_cc_email`, `date_added`, `status`) VALUES (NULL, 'Fitness Cartel Tweed Heads', '29', 'reception@tweed.fitnesscartel.com.au', 'nathan@fitnesscartel.com.au', '".date('Y-m-d H:i:s')."', '1');");

        $this->db->query("INSERT INTO `yvdnsddqu_admin_emails` (`admin_email_id` ,`location_name`, `location_id`, `admin_to_email`, `admin_cc_email`, `date_added`, `status`) VALUES (NULL, 'Fitness Cartel Aspley', '33', 'reception@aspley.fitnesscartel.com.au', 'nathan@fitnesscartel.com.au', '".date('Y-m-d H:i:s')."', '1');");

        $this->db->query("INSERT INTO `yvdnsddqu_admin_emails` (`admin_email_id` ,`location_name`, `location_id`, `admin_to_email`, `admin_cc_email`, `date_added`, `status`) VALUES (NULL, 'Fitness Cartel Maroochydore', '34', 'reception@maroochydore.fitnesscartel.com.au', 'nathan@fitnesscartel.com.au', '".date('Y-m-d H:i:s')."', '1');");

    }    

    public function down() {
    }
}

/* End of file 104_update_packages_plan_as_daily_table.php */
/* Location: ./setup/migrations/104_update_packages_plan_as_daily_table.php */