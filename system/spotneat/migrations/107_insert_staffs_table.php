<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * update details as daily basis yvdnsddqu_trainer_packages
 */
class Migration_Insert_Staffs_Table extends CI_Migration { 

    public function up() {
        $this->db->query("INSERT INTO `yvdnsddqu_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_telephone`, `staff_group_id`, `staff_location_id`, `commission`, `delivery_commission`, `timezone`, `language_id`, `staff_permissions`, `payment_details`, `opening_hours`, `holidays_list`, `date_added`, `staff_status`, `tax_id`) VALUES
        (59, 'Fitness Cartel Aspley', 'aspley@technowand.com', '+61-07 5479 2034', 12, 0, 0, 0.00, '', 0, 'a:21:{s:10:\"Categories\";s:2:\"on\";s:7:\"Coupons\";s:2:\"on\";s:9:\"Customers\";s:2:\"on\";s:15:\"CustomersOnline\";s:2:\"on\";s:12:\"MediaManager\";s:2:\"on\";s:9:\"Locations\";s:2:\"on\";s:11:\"MenuOptions\";s:2:\"on\";s:5:\"Menus\";s:2:\"on\";s:8:\"Messages\";s:2:\"on\";s:6:\"Orders\";s:2:\"on\";s:8:\"Payments\";s:2:\"on\";s:11:\"Permissions\";s:2:\"on\";s:7:\"Ratings\";s:2:\"on\";s:12:\"Reservations\";s:2:\"on\";s:7:\"Reviews\";s:2:\"on\";s:6:\"Staffs\";s:2:\"on\";s:6:\"Tables\";s:2:\"on\";s:8:\"Feedback\";s:2:\"on\";s:8:\"Delivery\";s:2:\"on\";s:14:\"DeliveryOnline\";s:2:\"on\";s:7:\"Stories\";s:2:\"on\";}', 'a:5:{s:12:\"payment_type\";s:1:\"1\";s:16:\"payment_username\";s:0:\"\";s:16:\"payment_password\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:11:\"payment_key\";s:0:\"\";}', 'a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"10:00 PM\";s:5:\"close\";s:7:\"7:59 PM\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"10:00 PM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}}', 'a:2:{i:0;a:2:{s:4:\"date\";s:10:\"2021-04-10\";s:11:\"description\";s:10:\"New item 1\";}i:1;a:2:{s:4:\"date\";s:10:\"2021-04-11\";s:11:\"description\";s:10:\"New item 2\";}}', '2021-02-10', 1, NULL);");
    }    

    public function down() {
    }
}

/* End of file 104_update_packages_plan_as_daily_table.php */
/* Location: ./setup/migrations/104_update_packages_plan_as_daily_table.php */