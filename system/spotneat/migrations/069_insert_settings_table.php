<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_insert_settings_table extends CI_Migration {

    public function up() {

        $this->db->query("INSERT INTO `yvdnsddqu_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES (NULL, 'leepriest', 'lee_priest_stripe_secrect_key', 'sk_test_51GxRVFJpxyLWDkuo0rVAU4nxTR0eyPLidiQ92igKB3MsUuK2R5uhEbH2LEGIszV7sTLrGDNWLyt8yNDlufBioYNG00A3K8ZAuY', '0');");

        $this->db->query("INSERT INTO `yvdnsddqu_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES (NULL, 'leepriest', 'lee_priest_stripe_public_key', 'pk_test_51GxRVFJpxyLWDkuoqxOXPQps0gkYoN0W65Vi29MwRh2ULzbgfgsqGzwp1JKg8UPPf0tr0SDXmop7E3YddULxeK7V00WkDXvk0d', '0');");

        $this->db->query("INSERT INTO `yvdnsddqu_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES (NULL, 'leepriest', 'lee_priest_stripe_session_string', 'fidkdWxOYHwnPyd1blpxYHZxWjA0Qn1XU0NPdX18SVJBbnBqdH1KXVVUdXY1Ym5caks1UjMwU2w3PEhyV203UEl%2FZ2JjYnZ0Qn9ydTRPTmI9UFVVYzVxdzVWQV1oanUyQDZcYWFQSX1gTjJTNTVSbkFdc241YScpJ2hsYXYnP34nYnBsYSc%2FJzI9ZzJgZGEzKDAzM2MoMWBkYyhkMWBnKDE0PGRnMzJhPDM8MWQwPTNjNCcpJ2hwbGEnPyc8PDM3YD1nYSgyPWc9KDE9Mj0oZGcyMyg9ZjA2MzBnYTQ9ZzMyYzVgNDAnKSd2bGEnPyc8NjI8MD0zNigxZDRjKDEzNzUoPWM9MCg0NDw0YTUxMjA2PDQyN2YyNDYneCknZ2BxZHYnP15YKSdpZHxqcHFRfHVgJz8ndmxrYmlgWmxxYGgnKSd3YGNgd3dgd0p3bGJsayc%2FJ21xcXU%2FKip2cmBgcWdscXYrZmpoK2RwJ3gl', '0');");
    }   
    
    public function down() {
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */