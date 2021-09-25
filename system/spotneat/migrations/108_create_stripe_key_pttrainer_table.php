<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * create stripe_key_pttrainer_table
 */
class Migration_Create_Stripe_Key_Pttrainer_Table extends CI_Migration { 

    public function up() {
        $this->db->query("CREATE TABLE `yvdnsddqu_stripe_key_pttrainer` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `public_key` text DEFAULT NULL,
            `secret_key` text DEFAULT NULL,
            `mode` text DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB;");

        $this->db->query("INSERT INTO `yvdnsddqu_stripe_key_pttrainer` (`id` ,`public_key`, `secret_key`, `mode`, `date_added`) VALUES (NULL, 'pk_test_51JHnCVLUoBTSju5Wffx70IJVqRjvIgvXlsofmVdTe92L4aSTXA7iYjXQBTJ6SqK1IyBzvPVfbf6rR1E6KVFM0XYp00pyiqRWOv', 'sk_test_51JHnCVLUoBTSju5WMQIQeXKTHCbkxErnFF8913qH8kiFCuG6sRIKFRZfs12WaGlKeB60VoYotkJxa214qvsVr1Qz00Ap84dVcV', 'TEST', '".date('Y-m-d H:i:s')."');");
        $this->db->query("INSERT INTO `yvdnsddqu_stripe_key_pttrainer` (`id` ,`public_key`, `secret_key`, `mode`, `date_added`) VALUES (NULL, 'pk_live_51JHnCVLUoBTSju5W1LBHPfOYUcLXhO0BQl8ICwZ9G4lH4y0rlmboyr0Ipjkn4FdMJrxUpEo9utG8KbtXn6wRMwuH00x1rKLjcr', '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', 'LIVE', '".date('Y-m-d H:i:s')."');");
        // exit();
    }    

    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_stripe_key_pttrainer');
    }
}

/* End of file 108_create_stripe_key_pttrainer_table.php */
/* Location: ./setup/migrations/108_create_stripe_key_pttrainer_table.php */