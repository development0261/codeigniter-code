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
 * Menu_options Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Menu_options_model.php
 * @link           http://docs.spotneat.com
 */
class Menu_options_model extends TI_Model {

	public function getCount($filter = array(),$id='') {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('option_name', $filter['filter_search']);
		}

		$this->db->from('options');

		if($this->user->getStaffId() != 11)
				$this->db->where('added_by',$this->user->getId());
			else
				$this->db->where('added_by',$id);
		return $this->db->count_all_results();
	}

	public function getList($filter = array(),$id='') {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('options');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('option_name', $filter['filter_search']);
			}

			if ( ! empty($filter['filter_display_type'])) {
				$this->db->where('display_type', $filter['filter_display_type']);
			}

			/*** User wise filter apply ***/
			if($this->user->getStaffId() != 11)

				$this->db->where('added_by',$this->user->getStaffId());
			else
				$this->db->where('added_by',$id);

			$query = $this->db->get();

			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getOptionValues($option_id = FALSE) {
		$result = array();

		$this->db->from('option_values');
		$this->db->order_by('priority', 'ASC');

		if ($option_id !== FALSE) {
			$this->db->where('option_id', $option_id);
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getOption($option_id) {
		$this->db->from('options');
		$this->db->where('option_id', $option_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getEditVariants($variant_type_id = '', $variant_type_value_id = '') {
		$results = array();

		$this->db->select('menu_variant_type_values.*, menu_variant_types.variant_type_name');
		$this->db->from('menu_variant_type_values');
		$this->db->join('menu_variant_types', 'menu_variant_types.menu_variant_type_id = menu_variant_type_values.menu_variant_type_id');

		$this->db->where('menu_variant_types.menu_variant_type_id', $variant_type_id);
		$this->db->where('menu_variant_type_values.menu_variant_type_value_id', $variant_type_value_id);
		$this->db->limit(1, 0);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$results[] = array(
					'menu_variant_type_value_id'=> $row['menu_variant_type_value_id'],
					'menu_variant_type_id'   	=> $row['menu_variant_type_id'],
					'type_value_name'           => $row['type_value_name'],
					'type_value_price'          => $row['type_value_price'],
					'menu_id'          			=> $row['menu_id'],
					'is_default'                => $row['is_default'],
					'status'     			    => $row['status'],
					'variant_type_name'         => $row['variant_type_name']
				);
			}
		}
		return $results;
	}


	public function getMenuOptions($menu_id = FALSE) {
		$results = array();

		$this->db->select('*, menu_options.menu_id, menu_options.option_id');
		$this->db->from('menu_options');
		$this->db->join('options', 'options.option_id = menu_options.option_id', 'left');

		if ($menu_id !== FALSE) {
			$this->db->where('menu_options.menu_id', $menu_id);
		}

		$this->db->order_by('options.priority', 'ASC');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$results[] = array(
					'menu_option_id'   => $row['menu_option_id'],
					'menu_id'          => $row['menu_id'],
					'option_id'        => $row['option_id'],
					'option_name'      => $row['option_name'],
					'display_type'     => $row['display_type'],
					'required'         => $row['required'],
					'default_value_id' => $row['default_value_id'],
					'priority'         => $row['priority'],
					'option_values'    => $this->getMenuOptionValues($row['menu_option_id'], $row['option_id']),
				);
			}
		}

		return $results;
	}

	public function getMenuOptionValues($menu_option_id = FALSE, $option_id = FALSE) {
		$result = array();

		if ($menu_option_id !== FALSE AND $option_id !== FALSE) {
			$this->db->select('*, menu_option_values.option_id, option_values.option_value_id');
			$this->db->from('menu_option_values');
			$this->db->join('option_values', 'option_values.option_value_id = menu_option_values.option_value_id',
			                'left');

			$this->db->order_by('option_values.priority', 'ASC');
			$this->db->where('menu_option_values.menu_option_id', $menu_option_id);
			$this->db->where('menu_option_values.option_id', $option_id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		}

		return $result;
	}

	public function getMenuVariants($menu_id = '', $menu_variant_type_id = '') {
		$results = array();

		$this->db->select('menu_variant_type_values.*, menu_variant_types.variant_type_name');
		$this->db->from('menu_variant_type_values');
		$this->db->join('menu_variant_types', 'menu_variant_types.menu_variant_type_id = menu_variant_type_values.menu_variant_type_id');

		if ($menu_id != '') {
			$this->db->where('menu_variant_types.menu_id', $menu_id);
		}

		if ($menu_variant_type_id != '') {
			$this->db->where('menu_variant_types.menu_variant_type_id', $menu_variant_type_id);
		}

		$this->db->order_by('menu_variant_type_values.menu_variant_type_id ', 'DESC');
		$query = $this->db->get();
		// echo 'menu_variant_type_id='.$menu_variant_type_id;
		// echo 'mm='.$this->db->last_query();
		// exit;
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$results[] = array(
					'menu_variant_type_value_id'=> $row['menu_variant_type_value_id'],
					'menu_variant_type_id'   	=> $row['menu_variant_type_id'],
					'type_value_name'           => $row['type_value_name'],
					'type_value_price'          => $row['type_value_price'],
					'menu_id'          			=> $row['menu_id'],
					'is_default'                => $row['is_default'],
					'status'     			    => $row['status'],
					'variant_type_name'         => $row['variant_type_name']
				);
			}
		}
		return $results;
	}

	public function getVariantTypes($menu_id = FALSE) {
		$results = array();

		$this->db->select('menu_variant_types.*');
		$this->db->from('menu_variant_types');

		if ($menu_id !== FALSE) {
			$this->db->where('menu_variant_types.menu_id', $menu_id);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$results[] = array(
					'menu_variant_type_id'   	=> $row['menu_variant_type_id'],
					'variant_type_name'         => $row['variant_type_name']
				);
			}
		}
		return $results;
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) AND ! empty($filter_data)) {
			$this->db->from('options');

			if ( ! empty($filter_data['option_name'])) {
				$this->db->like('option_name', $filter_data['option_name']);
			}

			if ( ! empty($filter_data['added_by'])) {
				$this->db->like('added_by', $filter_data['added_by']);
			}
			else{
				$this->db->like('added_by',$this->user->getStaffId() );
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$result[] = array(
						'option_id'     => $row['option_id'],
						'option_name'   => $row['option_name'],
						'display_type'  => $row['display_type'],
						'priority'      => $row['priority'],
						'option_values' => $this->getOptionValues($row['option_id']),
					);
				}
			}

			return $result;
		}
	}

	public function saveOption($option_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['option_name'])) {
			$this->db->set('option_name', $save['option_name']);
		}

		if (isset($save['option_name_arabic'])) {
			$this->db->set('option_name_arabic', $save['option_name_arabic']);
		}

		if ($save['added_by'] == "") {
			$this->db->set('added_by', $this->user->getStaffId());
		}else{
			$this->db->set('added_by', $save['added_by']);
		}

		if (isset($save['display_type'])) {
			$this->db->set('display_type', $save['display_type']);
		}

		if (isset($save['priority'])) {
			$this->db->set('priority', $save['priority']);
		}

		if (is_numeric($option_id)) {
			$this->db->where('option_id', $option_id);
			$query = $this->db->update('options');
		} else {
			$query = $this->db->insert('options');
			$option_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($option_id)) {
			$this->addOptionValues($option_id, $save['option_values']);

			return $option_id;
		}
	}

	public function saveVariant($option_id, $save = array()) {
		if (empty($save)) return FALSE;

		$method = $save['method'];
		$variant_type_id = $save['variant_type_id'];
		$variant_type_value_id = $save['variant_type_value_id'];

		if (isset($save['variant_name'])) {
			$this->db->set('variant_type_name', $save['variant_name']);
		}

		if (isset($save['menu_id'])) {
			$this->db->set('menu_id', $save['menu_id']);
		}

		if (isset($save['location_id'])) {
			$this->db->set('location_id', $save['location_id']);
		}
		
		$this->db->set('status', '1');
		$this->db->set('date_added', date('Y-m-d H:i:s'));

		if (is_numeric($variant_type_id) && $method=='Edit') {			
			$this->db->where('menu_variant_type_id', $variant_type_id);
			$query = $this->db->update('menu_variant_types');
			$option_id = $variant_type_id;
		} else {
			$query = $this->db->insert('menu_variant_types');
			$option_id = $this->db->insert_id();
		}

		if ($method=='Add') {
			$this->addVariantValues($option_id, $save['variant_values']);
		} else {
			$this->updateVariantValues($variant_type_id, $variant_type_value_id, $save['variant_values']);
		}
		
		return $option_id;
	}


	public function addOptionValues($option_id = FALSE, $option_values = array()) {
		$query = FALSE;

		if ($option_id !== FALSE AND ! empty($option_values) AND is_array($option_values)) {
			$this->db->where('option_id', $option_id);
			$this->db->delete('option_values');

			$priority = 1;
			foreach ($option_values as $key => $value) {
				if (isset($value['value'])) {
					$this->db->set('value', $value['value']);
				}
				if (isset($value['arabic_value'])) {
					$this->db->set('arabic_value', $value['arabic_value']);
				}

				if (isset($value['price'])) {
					$this->db->set('price', $value['price']);
				}

				if (isset($value['option_value_id'])) {
					$this->db->set('option_value_id', $value['option_value_id']);
				}

				$this->db->set('priority', $priority);

				$this->db->set('option_id', $option_id);
				$query = $this->db->insert('option_values');

				$priority ++;
			}
		}

		return $query;
	}

	public function addMenuOption($menu_id = FALSE, $menu_options = array()) {
		$query = FALSE;

		if ($menu_id !== FALSE) {
			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menu_options');

			$this->db->where('menu_id', $menu_id);
			$this->db->delete('menu_option_values');

			if ( ! empty($menu_options)) {
				foreach ($menu_options as $option) {
					$this->db->set('menu_id', $menu_id);
					$this->db->set('option_id', $option['option_id']);
					$this->db->set('required', $option['required']);
					$this->db->set('default_value_id', empty($option['default_value_id']) ? '0' : $option['default_value_id']);
					$this->db->set('option_values', serialize($option['option_values']));

					if (isset($option['menu_option_id'])) {
						$this->db->set('menu_option_id', $option['menu_option_id']);
					}

					if ($query = $this->db->insert('menu_options')) {
						$menu_option_id = $this->db->insert_id();
						$this->addMenuOptionValues($menu_option_id, $menu_id, $option['option_id'], $option['option_values']);
					}
				}
			}
		}

		return $query;
	}

	public function addMenuOptionValues($menu_option_id = FALSE, $menu_id = FALSE, $option_id = FALSE, $option_values = array()) {
		if ($menu_option_id !== FALSE AND $menu_id !== FALSE AND $option_id !== FALSE AND ! empty($option_values)) {
			foreach ($option_values as $value) {
				$this->db->set('menu_option_id', $menu_option_id);
				$this->db->set('menu_id', $menu_id);
				$this->db->set('option_id', $option_id);
				$this->db->set('option_value_id', $value['option_value_id']);
				$this->db->set('new_price', $value['price']);
				$this->db->set('quantity', $value['quantity']);
				$this->db->set('subtract_stock', $value['subtract_stock']);

				if ( ! empty($value['menu_option_value_id'])) {
					$this->db->set('menu_option_value_id', $value['menu_option_value_id']);
				}

				$query = $this->db->insert('menu_option_values');
			}
		}
	}

	public function deleteOption($option_id) {
		if (is_numeric($option_id)) $option_id = array($option_id);

		if ( ! empty($option_id) AND ctype_digit(implode('', $option_id))) {
			$this->db->where_in('option_id', $option_id);
			$this->db->delete('options');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('option_id', $option_id);
				$this->db->delete('option_values');

				$this->db->where_in('option_id', $option_id);
				$this->db->delete('menu_options');

				$this->db->where_in('option_id', $option_id);
				$this->db->delete('menu_option_values');

				return $affected_rows;
			}
		}
	}

	public function deleteMenuOption($menu_id) {
		if (is_numeric($menu_id)) $menu_id = array($menu_id);

		if ( ! empty($menu_id) AND ctype_digit(implode('', $menu_id))) {
			$this->db->where_in('menu_id', $menu_id);
			$this->db->delete('menu_options');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('menu_id', $menu_id);
				$this->db->delete('menu_option_values');

				return $affected_rows;
			}
		}
	}	

	public function addVariantValues($option_id = FALSE, $variant_values = array()) {
		$query = FALSE;

		if ($option_id !== FALSE AND ! empty($variant_values) AND is_array($variant_values)) {
			$this->db->where('menu_variant_type_id', $option_id);
			$this->db->delete('menu_variant_type_values');

			$priority = 1;
			foreach ($variant_values as $key => $value) {
				if (isset($value['value'])) {
					$this->db->set('type_value_name', $value['value']);
				}

				if (isset($value['price'])) {
					$this->db->set('type_value_price', $value['price']);
				}

				if (isset($option_id)) {
					$this->db->set('menu_variant_type_id', $option_id);
				}
				$this->db->set('is_default', $value['is_default']);
				$this->db->set('status', $value['status']);

				$this->db->set('date_added', date('Y-m-d H:i:s'));

				$query = $this->db->insert('menu_variant_type_values');
 
			}
		}

		return $query;
	}

	public function updateVariantValues($option_id = '', $variant_type_value_id = '', $variant_values = array()) {
		$query = FALSE;		
		if ($option_id !== FALSE AND ! empty($variant_values) AND is_array($variant_values)) {
			$priority = 1;
			foreach ($variant_values as $key => $value) {
				if (isset($value['value'])) {
					$this->db->set('type_value_name', $value['value']);
				}

				if (isset($value['price'])) {
					$this->db->set('type_value_price', $value['price']);
				}

				if (isset($option_id)) {
					$this->db->set('menu_variant_type_id', $option_id);
				}
				$this->db->set('is_default', $value['is_default']);
				$this->db->set('status', $value['status']);

				$this->db->where('menu_variant_type_value_id', $variant_type_value_id);
				$query = $this->db->update('menu_variant_type_values');				
			}
		}

		return $query;
	}
}

/* End of file menu_options_model.php */
/* Location: ./system/spotneat/models/menu_options_model.php */