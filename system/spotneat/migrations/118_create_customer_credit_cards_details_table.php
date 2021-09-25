<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * create stripe_key_pttrainer_table
 */
class Migration_Create_Customer_Credit_Cards_Details_Table extends CI_Migration { 

    public function up() {
        $this->db->query("CREATE TABLE `yvdnsddqu_customer_credit_cards` (
            `customer_credit_card_id` int(11) NOT NULL AUTO_INCREMENT,
            `customer_email` VARCHAR(51) DEFAULT NULL,
            `stripe_card_token` VARCHAR(255) DEFAULT NULL,
            `card_number` VARCHAR(51) DEFAULT NULL,
            `card_exp_month` VARCHAR(11) DEFAULT NULL,
            `card_exp_year` VARCHAR(11) DEFAULT NULL,
            `card_name` VARCHAR(51) DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            `status` TINYINT(1) DEFAULT NULL,
            PRIMARY KEY (`customer_credit_card_id`)
           ) ENGINE=InnoDB;");
    }    

    public function down() {
        $this->dbforge->drop_table('yvdnsddqu_customer_credit_cards');
    }
}

/* End of file 108_create_stripe_key_pttrainer_table.php */
/* Location: ./setup/migrations/108_create_stripe_key_pttrainer_table.php */