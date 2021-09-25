<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * update details as daily basis yvdnsddqu_trainer_packages
 */
class Migration_Insert_Restaurant_Stripe_Details_Table extends CI_Migration { 

    public function up() {
        $this->db->query("INSERT INTO `yvdnsddqu_restaurant_stripe_details` (`id`, `status`, `location_id`, `publishable_test_key`, `secret_test_key`, `publishable_key`, `secret_key`, `apple_merchant_id`) VALUES (NULL, '1', '33', 'pk_test_51JGFmGGyDIXnnXZvoqn8pZApIFLauqNpBM1hxozjGxoZrz2smCp5IkVG9rvEm48DUvohCMClgFyLAnaTokP39eta00ZVLkPsr5', 'sk_test_51JGFmGGyDIXnnXZveLLLyrkYUi1n7sxjoDdPAAFUJx3mcGACQ7rz7Y7oBIUFCjJCsD6uFXldVlX2lIO8B52Na5OX00mDP429X5', 'pk_live_51JGFmGGyDIXnnXZvMTTe4ZO6183RXpu3hVXqaIjIcxsjoAovo99UmTaCS4FRZ1U9HzNPDVqdYf135fAINn8mM7dY00korbuuJ4', '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', 'merchant.com.technowand.gym');");
    }    

    public function down() {
    }
}

/* End of file 104_update_packages_plan_as_daily_table.php */
/* Location: ./setup/migrations/104_update_packages_plan_as_daily_table.php */