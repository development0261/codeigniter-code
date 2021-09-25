<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * update details as daily basis yvdnsddqu_trainer_packages
 */
class Migration_Insert_Users_Table extends CI_Migration { 

    public function up() {
        $this->db->query("INSERT INTO `yvdnsddqu_users` (`user_id`, `staff_id`, `username`, `password`, `deviceid`, `deviceInfo`, `salt`) VALUES
        (NULL, 59, 'aspley', '950d12400cd13c75a947d991daff53d76c89bb7e', 'dUdSoHzcSUGurAjm7LDlwM:APA91bGSeMso-NGK5d1y76sbbN-ApIYTOQSqjfgqv6JcfX7YpXJeE0bEKiJJa6k0Sw0qbxdk70_USa1lspOtZDdo27EDj7kU8wnwk3DpxdxZLc91dNEQGKCU8tDqWgZ7LOnqcZwl6guh', '{\"model\":\"RMX2170\",\"platform\":\"android\",\"version\":\"11\",\"cordova\":\"\",\"uuid\":\"\",\"manufacturer\":\"realme\",\"isVirtual\":false,\"serial\":\"unknown\"}', 'd6384e0f8');");
    }    

    public function down() {
    }
}

/* End of file 104_update_packages_plan_as_daily_table.php */
/* Location: ./setup/migrations/104_update_packages_plan_as_daily_table.php */