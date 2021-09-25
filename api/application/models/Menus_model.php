<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menus_model extends CI_Model {

	public function getCount($filter = array()) {
		if (APPDIR === ADMINDIR) {
			if ( ! empty($filter['filter_search'])) {
				$this->db->like('menu_name', $filter['filter_search']);
				$this->db->or_like('menu_price', $filter['filter_search']);
				$this->db->or_like('stock_qty', $filter['filter_search']);
			}

			if (is_numeric($filter['filter_status'])) {
				$this->db->where('menu_status', $filter['filter_status']);
			}
		}

		if ( ! empty($filter['filter_category'])) {
			$this->db->where('menu_category_id', $filter['filter_category']);
		}

		$this->db->from('menus');

		return $this->db->count_all_results();
	}


	public function getListNew($search_data) {

     $query = $this->db->query("SELECT a.menu_id, a.menu_name, a.menu_description, a.menu_name_ar, a.menu_description_ar, a.menu_photo, a.menu_price, a.minimum_qty,a.menu_category_id, a.menu_priority,b.name,c.special_status,c.start_date as sd,c.end_date as ed,d.mealtime_id,d.mealtime_name,d.start_time as st,d.end_time as et,IF(c.start_date <= CURRENT_DATE(),IF(c.end_date >= CURRENT_DATE(), '1', '0'), '0') as is_special,IF(d.start_time <= CURRENT_TIME(),IF(d.end_time >= CURRENT_TIME(), '1', '0'), '0') as is_mealtime FROM `tyehnd0gd_menus` a LEFT JOIN `tyehnd0gd_categories` b ON a.menu_category_id=b.category_id LEFT JOIN `tyehnd0gd_menus_specials` c ON c.menu_id=a.menu_id LEFT JOIN `tyehnd0gd_mealtimes` d ON d.mealtime_id=a.mealtime_id WHERE (a.menu_name LIKE '%$search_data%' || a.menu_description LIKE '%$search_data%' || a.menu_price LIKE '%$search_data%' || a.stock_qty LIKE '%$search_data%' || a.minimum_qty LIKE '%$search_data%' || b.name LIKE '%$search_data%' || c.start_date LIKE '%$search_data%'|| c.end_date LIKE '%$search_data%' || c.special_price LIKE '%$search_data%' || d.mealtime_name LIKE '%$search_data%' || d.start_time LIKE '%$search_data%' || d.end_time LIKE '%$search_data%')");

           if ($query->num_rows() > 0) {

           	$result = $query->result_array();

            $this->load->model('Image_tool_model');

			$results = array();

			$show_menu_images = (is_numeric($this->config->item('show_menu_images'))) ? $this->config->item('show_menu_images') : '';
			$menu_images_h = (is_numeric($this->config->item('menu_images_h'))) ? $this->config->item('menu_images_h') : '50';
			$menu_images_w = (is_numeric($this->config->item('menu_images_w'))) ? $this->config->item('menu_images_w') : '50';

            $i=0;

            

			foreach ($result as $row) { 

             $menu_photo_src = '';
				if ($show_menu_images === '1') {
					if ( ! empty($row['menu_photo'])) {
						$menu_photo_src = $this->Image_tool_model->resize($row['menu_photo'], $menu_images_w, $menu_images_h);
					}
				}

			 $start_date = $end_date = $end_days = '';
			 $price = $row['menu_price'];
			 
			 if ($row['special_status'] === '1' AND $row['is_special'] === '1') {
					$price = $row['special_price'];
					$daydiff = floor((strtotime($row['end_date']) - time()) / 86400);
					$start_date = $row['start_date'];
					$end_date = mdate('%d %M', strtotime($row['end_date']));

					if (($daydiff < 0)) {
						$end_days = sprintf($this->lang->line('text_end_today'));
					} else {
						$end_days = sprintf($this->lang->line('text_end_days'), $end_date, $daydiff);
					}
			}

            $this->load->helper('date');
            $results[$i][] = array(                                                            
					'menu_id'          => $row['menu_id'],
					'menu_name'        => (strlen($row['menu_name']) > 80) ? strtolower(substr($row['menu_name'], 0, 80)) . '...' : strtolower($row['menu_name']),
					'menu_description' => (strlen($row['menu_description']) > 120) ? substr($row['menu_description'], 0, 120) . '...' : $row['menu_description'],
					'category_name'    => $row['name'],
					'category_id'      => $row['menu_category_id'],
					'minimum_qty'      => ! empty($row['minimum_qty']) ? $row['minimum_qty'] : '1',
					'menu_priority'    => $row['menu_priority'],
                    'mealtime_name'    => $row['mealtime_name'],
					'start_time'  	   => $row['st'],
					'end_time'         => $row['et'],
					'is_mealtime'      => $row['is_mealtime'],
					'mealtime_status'  => (!empty($row['mealtime_id']) AND !empty($row['mealtime_status'])) ? '1' : '0',
					'special_status'   => $row['special_status'],
					'is_special'       => $row['is_special'],
					'start_date'       => $row['sd'],
					'end_days'         => $row['ed'],
					'menu_price'       => $this->currency->format($price),        
					'menu_photo'       => $menu_photo_src,

					
				);

            $i++;

            }
           }else{

            return 0;

           }
           return $results;
    }

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			if (APPDIR === ADMINDIR) {
				$this->db->select('*, menus.menu_id');
				$this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), "1", "0"), "0") AS is_special', FALSE);
			} else {
				$this->db->select('menus.menu_id, menu_name, menu_description, menu_description_ar, menu_photo, menu_price, minimum_qty,
					menu_category_id, menu_priority, categories.name AS category_name, special_status, start_date, end_date, special_price,
					menus.mealtime_id, mealtimes.mealtime_name, mealtimes.start_time, mealtimes.end_time, mealtime_status');
				$this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), "1", "0"), "0") AS is_special', FALSE);
				$this->db->select('IF(start_time <= CURRENT_TIME(), IF(end_time >= CURRENT_TIME(), "1", "0"), "0") AS is_mealtime', FALSE);
			}

			$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
			$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
			$this->db->join('mealtimes', 'mealtimes.mealtime_id = menus.mealtime_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('menu_name', $filter['filter_search']);
				$this->db->or_like('menu_price', $filter['filter_search']);
				$this->db->or_like('stock_qty', $filter['filter_search']);
			}

			if ( ! empty($filter['filter_category'])) {
				$this->db->where('menu_category_id', $filter['filter_category']);
			}

			if (is_numeric($filter['filter_status'])) {
				$this->db->where('menu_status', $filter['filter_status']);
			}

			$query = $this->db->get('menus');

			$result = array();

            

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			if (APPDIR === ADMINDIR) {
				
				return $result;
			}

			$this->load->model('Image_tool_model');

			$results = array();

			$show_menu_images = (is_numeric($this->config->item('show_menu_images'))) ? $this->config->item('show_menu_images') : '';
			$menu_images_h = (is_numeric($this->config->item('menu_images_h'))) ? $this->config->item('menu_images_h') : '50';
			$menu_images_w = (is_numeric($this->config->item('menu_images_w'))) ? $this->config->item('menu_images_w') : '50';

			

			foreach ($result as $row) {                                                            // loop through menus array
				$menu_photo_src = '';
				if ($show_menu_images === '1') {
					if ( ! empty($row['menu_photo'])) {
						$menu_photo_src = $this->Image_tool_model->resize($row['menu_photo'], $menu_images_w, $menu_images_h);
					}
				}

				$start_date = $end_date = $end_days = '';
				$price = $row['menu_price'];
				if ($row['special_status'] === '1' AND $row['is_special'] === '1') {
					$price = $row['special_price'];
					$daydiff = floor((strtotime($row['end_date']) - time()) / 86400);
					$start_date = $row['start_date'];
					$end_date = mdate('%d %M', strtotime($row['end_date']));

					if (($daydiff < 0)) {
						$end_days = sprintf($this->lang->line('text_end_today'));
					} else {
						$end_days = sprintf($this->lang->line('text_end_days'), $end_date, $daydiff);
					}
				}

				$results[$row['menu_category_id']][] = array(                                                            // create array of menu data to be sent to view
					'menu_id'          => $row['menu_id'],
					'menu_name'        => (strlen($row['menu_name']) > 80) ? strtolower(substr($row['menu_name'], 0, 80)) . '...' : strtolower($row['menu_name']),
					'menu_description' => (strlen($row['menu_description']) > 120) ? substr($row['menu_description'], 0, 120) . '...' : $row['menu_description'],
					'menu_description_ar' => (strlen($row['menu_description_ar']) > 120) ? substr($row['menu_description_ar'], 0, 120) . '...' : $row['menu_description_ar'],
					'category_name'    => $row['category_name'],
					'category_id'      => $row['menu_category_id'],
					'minimum_qty'      => ! empty($row['minimum_qty']) ? $row['minimum_qty'] : '1',
					'menu_priority'    => $row['menu_priority'],
					'mealtime_name'    => $row['mealtime_name'],
					'start_time'  	   => mdate($this->config->item('time_format'), strtotime($row['start_time'])),
					'end_time'         => mdate($this->config->item('time_format'), strtotime($row['end_time'])),
					'is_mealtime'      => $row['is_mealtime'],
					'mealtime_status'  => (!empty($row['mealtime_id']) AND !empty($row['mealtime_status'])) ? '1' : '0',
					'special_status'   => $row['special_status'],
					'is_special'       => $row['is_special'],
					'start_date'       => $start_date,
					'end_days'         => $end_days,
					'menu_price'       => $this->currency->format($price),        //add currency symbol and format price to two decimal places
					'menu_photo'       => $menu_photo_src,
				);
			}

			return $results;
		}
	}

	public function getMenu($menu_id) {
		//$this->db->select('menus.menu_id, *');
		$this->db->select('menus.menu_id, menu_name, menu_name_ar, menu_description, menu_description_ar, menu_price, menu_photo, menu_category_id, stock_qty,
			minimum_qty, subtract_stock, menu_status, menu_priority, category_id, categories.name, description, special_id, start_date,
			end_date, special_price, special_status, menus.mealtime_id, mealtimes.mealtime_name, mealtimes.start_time, mealtimes.end_time, mealtime_status');
		$this->db->from('menus');
		$this->db->join('categories', 'categories.category_id = menus.menu_category_id', 'left');
		$this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
		$this->db->join('mealtimes', 'mealtimes.mealtime_id = menus.mealtime_id', 'left');
		$this->db->where('menus.menu_id', $menu_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function updateStock($menu_id, $quantity = 0, $action = 'subtract') {
		$update = FALSE;

		if (is_numeric($menu_id)) {
			$this->db->select('menus.menu_id, menu_name, menu_name_ar, stock_qty, minimum_qty, subtract_stock, menu_status');
			$this->db->from('menus');
			$this->db->where('menus.menu_id', $menu_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				if ($row['subtract_stock'] === '1' AND ! empty($quantity)) {
					$stock_qty = 'stock_qty + ' . $quantity;

					if ($action === 'subtract') {
						$stock_qty = 'stock_qty - ' . $quantity;
					}

					$this->db->set('stock_qty', $stock_qty, FALSE);
					$this->db->where('menu_id', $menu_id);
					$update = $this->db->update('menus');
				}
			}
		}

		return $update;
	}

	public function getAutoComplete($filter_data = array()) {
		if (is_array($filter_data) AND ! empty($filter_data)) {
			//selecting all records from the menu and categories tables.
			$this->db->from('menus');

			$this->db->where('menu_status', '1');

			if ( ! empty($filter_data['menu_name'])) {
				$this->db->like('menu_name', $filter_data['menu_name']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function saveMenu($menu_id, $save = array()) {
		if (empty($save) AND ! is_array($save)) return FALSE;

		if (isset($save['menu_name'])) {
			$this->db->set('menu_name', $save['menu_name']);
		}

		if (isset($save['menu_description'])) {
			$this->db->set('menu_description', $save['menu_description']);
		}

		if (isset($save['menu_price'])) {
			$this->db->set('menu_price', $save['menu_price']);
		}

		if (isset($save['special_status']) AND $save['special_status'] === '1') {
			$this->db->set('menu_category_id', (int) $this->config->item('special_category_id'));
		} else if (isset($save['menu_category'])) {
			$this->db->set('menu_category_id', $save['menu_category']);
		}

		if (isset($save['menu_photo'])) {
			$this->db->set('menu_photo', $save['menu_photo']);
		}

		if (isset($save['stock_qty']) AND $save['stock_qty'] > 0) {
			$this->db->set('stock_qty', $save['stock_qty']);
		} else {
			$this->db->set('stock_qty', '0');
		}

		if (isset($save['minimum_qty']) AND $save['minimum_qty'] > 0) {
			$this->db->set('minimum_qty', $save['minimum_qty']);
		} else {
			$this->db->set('minimum_qty', '1');
		}

		if (isset($save['subtract_stock']) AND $save['subtract_stock'] === '1') {
			$this->db->set('subtract_stock', $save['subtract_stock']);
		} else {
			$this->db->set('subtract_stock', '0');
		}

		if (isset($save['menu_status']) AND $save['menu_status'] === '1') {
			$this->db->set('menu_status', $save['menu_status']);
		} else {
			$this->db->set('menu_status', '0');
		}

		if (isset($save['mealtime_id'])) {
			$this->db->set('mealtime_id', $save['mealtime_id']);
		} else {
			$this->db->set('mealtime_id', '0');
		}

		if (isset($save['menu_priority'])) {
			$this->db->set('menu_priority', $save['menu_priority']);
		} else {
			$this->db->set('menu_priority', '0');
		}

		if (is_numeric($menu_id)) {
			$this->db->where('menu_id', (int) $menu_id);
			$query = $this->db->update('menus');
		} else {
			$query = $this->db->insert('menus');
			$menu_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($menu_id)) {
			if ( ! empty($save['menu_options'])) {
				$this->load->model('Menu_options_model');
				$this->Menu_options_model->addMenuOption($menu_id, $save['menu_options']);
			}

			if ( ! empty($save['start_date']) AND ! empty($save['end_date']) AND isset($save['special_price'])) {
				$this->db->set('start_date', mdate('%Y-%m-%d', strtotime($save['start_date'])));
				$this->db->set('end_date', mdate('%Y-%m-%d', strtotime($save['end_date'])));
				$this->db->set('special_price', $save['special_price']);

				if (isset($save['special_status']) AND $save['special_status'] === '1') {
					$this->db->set('special_status', '1');
				} else {
					$this->db->set('special_status', '0');
				}

				if (isset($save['special_id'])) {
					$this->db->where('special_id', $save['special_id']);
					$this->db->where('menu_id', $menu_id);
					$this->db->update('menus_specials');
				} else {
					$this->db->set('menu_id', $menu_id);
					$this->db->insert('menus_specials');
				}
			}

			return $menu_id;
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
			}else{
				return true;
			}
		}
	}

	public function deleteMenu($menu_id) {
		if (is_numeric($menu_id)) $menu_id = array($menu_id);

		if ( ! empty($menu_id) AND ctype_digit(implode('', $menu_id))) {
			$this->db->where_in('menu_id', $menu_id);
			$this->db->delete('menus');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->deleteMenuOption($menu_id);
				$this->db->where_in('menu_id', $menu_id);
				$this->db->delete('menus_specials');

				return $affected_rows;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function getCategoryList($added_by) {
		if ($added_by) {
			$this->db->select('categories.*');
			$this->db->from('categories');
			$this->db->where('categories.added_by', $added_by);
			$query = $this->db->get();
			if(!$query->num_rows())
				{
					return $query->result_array();
				}
				else
				{
					return $query->result_array();
				}
		}else{
			return [];
		}
	}

	public function addMenu($menu_id, $save = array()) {
		if (empty($save) AND ! is_array($save)) return FALSE;
		if (isset($save['menu_name'])) {
			$this->db->set('menu_name', $save['menu_name']);
		}

		if (isset($save['menu_description'])) {
			$this->db->set('menu_description', $save['menu_description']);
		}

		if (isset($save['menu_price'])) {
			$this->db->set('menu_price', $save['menu_price']);
		}
		if (isset($save['location_id'])) {
			$this->db->set('location_id', $save['location_id']);
		}
		if (isset($save['added_by'])) {
			$this->db->set('added_by', $save['added_by']);
		}
		if (isset($save['menu_status'])) {
			$this->db->set('menu_status', $save['menu_status']);
		}

		if (isset($save['special_status']) AND $save['special_status'] === '1') {
			$this->db->set('menu_category_id', (int) $this->config->item('special_category_id'));
		} else if (isset($save['menu_category_id'])) {
			$this->db->set('menu_category_id', $save['menu_category_id']);
		}

		if (isset($save['menu_photo'])) {
			$this->db->set('menu_photo', $save['menu_photo']);
		}
		if (isset($save['mealtime_id'])) {
			$this->db->set('mealtime_id', $save['mealtime_id']);
		} else {
			$this->db->set('mealtime_id', '0');
		}

		if (isset($save['menu_priority'])) {
			$this->db->set('menu_priority', $save['menu_priority']);
		} else {
			$this->db->set('menu_priority', '0');
		}

		if (isset($save['is_shake_of_the_month'])) {
			$this->db->set('is_shake_of_the_month', $save['is_shake_of_the_month']);
		} else {
			$this->db->set('is_shake_of_the_month', '0');
		}

		if (isset($save['resturant_owner_comment'])) {
			$this->db->set('resturant_owner_comment', $save['resturant_owner_comment']);
		}

		if (is_numeric($menu_id)) {
			$this->db->where('menu_id', (int) $menu_id);
			$query = $this->db->update('menus');
		} else {
			$query = $this->db->insert('menus');
			$menu_id = $this->db->insert_id();
		}
		if ($query === TRUE AND is_numeric($menu_id)) {
			return $menu_id;
		}else{
			return null;
		}
	}
}

/* End of file menus_model.php */
