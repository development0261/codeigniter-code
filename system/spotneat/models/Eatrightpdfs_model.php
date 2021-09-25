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
 * Staff_groups Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Staff_groups_model.php
 * @link           http://docs.spotneat.com
 */
class Eatrightpdfs_model extends TI_Model {


	public function saveEatrightpdfs($eat_right_pdf_id, $save = array()) {
		
		if (empty($save)) return FALSE;
		$storyData = array();
		if(!empty($save['pdf_title'])){
			$storyData['pdf_title'] = $save['pdf_title'];
		}
		if(!empty($save['pdf_image_name'])){
			$storyData['pdf_image_name'] = $save['pdf_image_name'];
		}
		if(!empty($save['is_active'])){
			$storyData['is_active'] = $save['is_active'];
		}

		$storyData['date_added']=date('Y-m-d H:i:s');

		$query = $this->db->insert('eat_right_pdf',$storyData);
		$eat_right_pdf_id = $this->db->insert_id();
		
		return $eat_right_pdf_id;
	}

	/**
     * Update User data of the given $userId
     *
     * @param number $userId User id
     * @param array  $data   Update data
     *
     * @return boolean
     */
    public function update($eat_right_pdf_id, $is_active)
    {
        return $this->db->where('eat_right_pdf_id', $eat_right_pdf_id)->update('eat_right_pdf', $data);
    }

	public function getCount($filter = array()) {
		$this->db->from('stories');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
		
			
			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}
			$wherestory = array();			
			$this->db->where($wherestory);
			
			$query = $this->db->get('eat_right_pdf');

			$result = array();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }
            return $result;
			
		}
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