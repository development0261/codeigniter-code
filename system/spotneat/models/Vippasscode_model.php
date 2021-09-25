<?php
/**
 * SpotnEat
 *
 * 
 *
 * @package   SpotnEat
 * @author    Sp
 * @copyright SpotnEat
 * @link      http://spotneat.com
 * @license   http://spotneat.com
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Vippasscode Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Staff_groups_model.php
 * @link           http://docs.spotneat.com
 */
class Vippasscode_model extends TI_Model {


	public function savePasscode($passcode_id, $save = array()) {
		
		if (empty($save)) return FALSE;
		$storyData = array();
		if(!empty($save['passcode'])){
			$storyData['code'] = $save['passcode'];
		}
		if(!empty($save['is_active'])){
			$storyData['is_active'] = $save['is_active'];
		}

		$storyData['date_added']=date('Y-m-d H:i:s');

		/*UPDATE OTHER CODES AS DEACTIVE*/
		$data['is_active'] = 0;
		$updatecodestatus = $this->db->update('purchase_vipplan_code', $data);

		$query = $this->db->insert('purchase_vipplan_code',$storyData);

		$vippasscode_id = $this->db->insert_id();

		
		return $vippasscode_id;
	}

	/**
     * Update User data of the given $userId
     *
     * @param number $userId User id
     * @param array  $data   Update data
     *
     * @return boolean
     */

	public function getPasscode() {
		$this->db->where('is_active', 1);
		
		$query = $this->db->get('purchase_vipplan_code');

		$result = array();

        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return $result;
	}

	public function changeStatus($eat_right_pdf_id = '', $is_active = '1')
    {
		$this->db->set('is_active', $is_active);
		$this->db->where('eat_right_pdf_id', $eat_right_pdf_id);
		$query = $this->db->update('eat_right_pdf');		

		return $eat_right_pdf_id;
    }

}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */