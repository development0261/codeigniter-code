<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Update 'Site.Themes' rule to include 'Add' action
 */
class Migration_update_Workout_Video_Purchases_table extends CI_Migration {

	public function up() {
		$this->db->query("UPDATE `yvdnsddqu_workout_video_purchases` SET `subscription_payment_iteration` = '4' where `purchase_type` = 'fixed'");
	}

	public function down() {
	}
}

/* End of file 022_insert_site_updates_rule_to_permission_table.php */
/* Location: ./setup/migrations/022_insert_site_updates_rule_to_permission_table.php */