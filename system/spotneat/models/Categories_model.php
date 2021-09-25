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
 * Categories Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Categories_model.php
 * @link           http://docs.spotneat.com
 */
class Categories_model extends TI_Model {

	public function getCount($filter = array(),$id,$staffid) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('name', $filter['filter_search']);
		}

		if (is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		/*** User wise filter apply ***/
		if($this->user->getStaffId() != 11)
			$this->db->where('added_by',$this->user->getId());
		else
			$this->db->where('added_by',$id);

		$this->db->from('categories');

		return $this->db->count_all_results();
	}

	public function getList($filter = array(),$id='',$staffid='') {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('categories');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}


			if ( ! empty($filter['filter_search'])) {
				$this->db->like('name', $filter['filter_search']);
			}
			$this->db->where('added_by',$this->user->getStaffId());
			if($this->user->getStaffId() != 11){
				$this->db->or_where('added_by', $id);
			}else{
				//echo $this->user->getStaffId();
				//exit;
				$this->db->or_where('added_by', $id);
				$this->db->or_where('added_by', $staffid);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getCategories($parent = NULL,$added_by='',$location_id='') {
		$this->load->library('User');
		$sql = "SELECT cat1.category_id, cat1.name,cat1.parent_id,cat1.name_ar, cat1.description, cat1.image, ";
		$sql .= "cat1.priority, cat1.status, child.category_id as child_id, sibling.category_id as sibling_id ";
		$sql .= "FROM {$this->db->dbprefix('categories')} AS cat1 ";
		$sql .= "LEFT JOIN {$this->db->dbprefix('categories')} AS child ON child.parent_id = cat1.category_id ";
		$sql .= "LEFT JOIN {$this->db->dbprefix('categories')} AS sibling ON sibling.parent_id = child.category_id ";
		$sql .= "LEFT JOIN {$this->db->dbprefix('menus')} AS menus ON menus.menu_category_id = cat1.category_id ";

		if ($parent === NULL) {
			$sql .= "WHERE cat1.parent_id >= 0 ";
		} else if (empty($parent)) {
			$sql .= "WHERE cat1.parent_id = 0 ";
		} else {
			$sql .= "WHERE cat1.parent_id = ? ";
		}

		if (APPDIR === MAINDIR) {
			$sql .= "AND cat1.status = 1 ";
		}
		if($location_id == ""){
			if ($added_by != ''){
				$sql .= "AND cat1.added_by = '$added_by' ";
			}else{
				 $sql .= "AND cat1.added_by = '".$this->user->getStaffId()."'";
			}
		}else{
			$sql .= "AND menus.location_id = '".$location_id."'";
		}
		

		$query = $this->db->query($sql, $parent);

		$result = array();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['category_id']] = $row;
			}
		}

		return $result;
	}

	public function getCategoriesByVendor($added_by) {
		$sql = "SELECT cat1.category_id, cat1.name,cat1.name_ar, cat1.description, cat1.image, ";
		$sql .= "cat1.priority, cat1.status, child.category_id as child_id, sibling.category_id as sibling_id ";
		$sql .= "FROM {$this->db->dbprefix('categories')} AS cat1 ";
		$sql .= "LEFT JOIN {$this->db->dbprefix('categories')} AS child ON child.parent_id = cat1.category_id ";
		$sql .= "LEFT JOIN {$this->db->dbprefix('categories')} AS sibling ON sibling.parent_id = child.category_id ";

		if ($parent === NULL) {
			$sql .= "WHERE cat1.parent_id >= 0 ";
		} else if (empty($parent)) {
			$sql .= "WHERE cat1.parent_id = 0 ";
		} else {
			$sql .= "WHERE cat1.parent_id = ? ";
		}

		if (APPDIR === MAINDIR) {
			$sql .= "AND cat1.status = 1 ";
		}

		$query = $this->db->query($sql, $parent);

		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['category_id']] = $row;
			}
		}

		return $result;
	}

	public function getCategory($category_id) {
		if (is_numeric($category_id)) {
			$this->db->from('categories');
			$this->db->where('category_id', $category_id);

			if (APPDIR === MAINDIR) {
				$this->db->where('status', '1');
			}

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function checkCategory($post,$id=null) {
		if($id != '') {
			$this->db->from('categories');
			$this->db->where('category_id', $id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$category =  $query->row_array();
				if($category['name'] == $post['name']) {
					return 0;
				} else {
					$this->db->from('categories');
					$this->db->where('name', $post['name']);
					$this->db->where('added_by', $post['added_by']);
					$query1 = $this->db->get();
					if ($query1->num_rows() > 0) {
						return 1;	
					}
				}
			}
		} else {
			$this->db->from('categories');
			$this->db->where('name', $post['name']);
			$this->db->where('added_by', $post['added_by']);
			$query1 = $this->db->get();
			if ($query1->num_rows() > 0) {
				return 1;	
			}
		}
	}

	public function saveCategory($category_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['name'])) {
			$this->db->set('name', ucfirst($save['name']));
		}

		if (isset($save['name_ar'])) {
			$this->db->set('name_ar', ucfirst($save['name_ar']));
		}

		if (isset($save['description'])) {
			$this->db->set('description', $save['description']);
		}

		if (isset($save['description_ar'])) {
			$this->db->set('description_ar', $save['description_ar']);
		}

		if (isset($save['parent_id'])) {
			$this->db->set('parent_id', $save['parent_id']);
		}

		if (isset($save['image'])) {
			$this->db->set('image', $save['image']);
		}

		//echo $save['added_by'];exit;
		if ($save['added_by'] == "") {
			$this->db->set('added_by', $this->user->getStaffId());
		}else{
			$this->db->set('added_by', $save['added_by']);
		}

		if (isset($save['priority'])) {
			$this->db->set('priority', $save['priority']);
		}

		if (isset($save['status']) AND $save['status'] === '1') {
			$this->db->set('status', $save['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (isset($save['alcohol_status']) AND $save['alcohol_status'] === '1') {
			$this->db->set('alcohol_status', $save['alcohol_status']);
		} else {
			$this->db->set('alcohol_status', '0');
		}
		
		if (is_numeric($category_id)) {
			$this->db->where('category_id', $category_id);
			$query = $this->db->update('categories');
		} else {
			$query = $this->db->insert('categories');
			$category_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($category_id)) {
			if ( ! empty($save['permalink'])) {
				$this->permalink->savePermalink('menus', $save['permalink'], 'category_id=' . $category_id);
			}

			return $category_id;
		}
	}

	public function deleteCategory($category_id) {
		if (is_numeric($category_id)) $category_id = array($category_id);

		if ( ! empty($category_id) AND ctype_digit(implode('', $category_id))) {
			$this->db->where_in('category_id', $category_id);
			$this->db->delete('categories');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				foreach ($category_id as $id) {
					$this->permalink->deletePermalink('menus', 'category_id=' . $id);
				}

				return $affected_rows;
			}
		}
	}
}

/* End of file categories_model.php */
/* Location: ./system/spotneat/models/categories_model.php */