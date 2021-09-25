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
 * Reviews Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Reviews_model.php
 * @link           http://docs.spotneat.com
 */
class Reviews_model extends TI_Model {

	public function getCount($filter = array() , $added_by='') {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('author', $filter['filter_search']);
			$this->db->or_like('location_name', $filter['filter_search']);
			$this->db->or_like('order_id', $filter['filter_search']);
		}

		if ( ! empty($filter['filter_location'])) {
			$this->db->where('reviews.location_id', $filter['filter_location']);
		}

		if ( ! empty($filter['customer_id'])) {
			$this->db->where('customer_id', $filter['customer_id']);
		}

		if ( ! empty($filter['location_id'])) {
			$this->db->where('reviews.location_id', $filter['location_id']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('review_status', $filter['filter_status']);
		}

		if ( ! empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}
		if($added_by!=''){
			/*** User wise filter apply ***/
			if($this->user->getStaffId() != 11)
				$this->db->where('locations.added_by',$this->user->getId());
			else
				$this->db->where('locations.added_by',$added_by);
			}

		$this->db->from('reviews');
		$query = $this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');
		$query = $this->db->get();
	
		return $query->num_rows();
	}

	public function getList($filter = array(),$added_by = '') {


		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('reviews');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_location'])) {
				$this->db->where('reviews.location_id', $filter['filter_location']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('author', $filter['filter_search']);
				$this->db->or_like('location_name', $filter['filter_search']);
				$this->db->or_like('order_id', $filter['filter_search']);
			}

			if ( ! empty($filter['customer_id'])) {
				$this->db->where('customer_id', $filter['customer_id']);
			}

			if ( ! empty($filter['location_id'])) {
				$this->db->where('reviews.location_id', $filter['location_id']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('review_status', $filter['filter_status']);
			}

			if ( ! empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}
			if($added_by!=''){
			/*** User wise filter apply ***/
			if($this->user->getStaffId() != 11)
				$this->db->where('locations.added_by',$added_by);
			else
				$this->db->where('locations.added_by',$added_by);
			}
			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
			// echo $this->db->last_query();exit;

			return $result;
		}
	}

	public function getReviews($customer_id = FALSE) {
		if ($customer_id !== FALSE) {
			$this->db->from('reviews');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

			$this->db->where('review_status', '1');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getTotalsbyId($location_id = FALSE,$review_filter = NULL) {
		$this->db->select('location_id, COUNT(location_id) as review_total');
		$this->db->from('reviews');
		$this->db->group_by('location_id');
		$this->db->order_by('review_total');
		$this->db->where('review_status', '1');

		if ($location_id !== FALSE) {
			$this->db->where('location_id', $location_id);
		}
		if($review_filter)
		{
			$this->db->having('review_total >=',$review_filter);
		}
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['location_id']] = $row['review_total'];
			}
		}

		return $result;
	}

	public function getReview($review_id, $customer_id = FALSE, $sale_type = FALSE) {
		if ( ! empty($review_id)) {
			$this->db->from('reviews');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

			if ( ! empty($customer_id)) {
				$this->db->where('customer_id', $customer_id);
			}

			$this->db->where('review_id', $review_id);

			if ($sale_type !== FALSE) {
				$this->db->where('sale_type', $sale_type);
			}

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getReviewDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('reviews');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getTotalLocationReviews($location_id) {
		$this->db->where('location_id', $location_id);
		$this->db->where('review_status', '1');
		$this->db->from('reviews');
		$total_reviews = $this->db->count_all_results();

		return $total_reviews;
	}

	public function getreservationID($location_id,$customer_id) {
		$this->db->where('reservation_id', $location_id);
		$this->db->where('customer_id',$customer_id);
		$this->db->from('reservations');
		$total_reviews = $this->db->get();

		return $total_reviews->row();
	}


	public function checkReviewed($sale_type = 'order', $sale_id = '', $customer_id = '') {
		if ($sale_type === 'reservation') {
			$check_query = $this->db->get_where('reservations', array('reservation_id' => $sale_id, 'customer_id' => $customer_id));
		} else {
			$check_query = $this->db->get_where('orders', array('order_id' => $sale_id, 'customer_id' => $customer_id));
		}
	
		if ($check_query->num_rows() > 0) {
			$this->db->from('reviews');

			$this->db->where('customer_id', $customer_id);

			$this->db->where('sale_type', $sale_type);
			$this->db->where('sale_id', $sale_id);

			$query = $this->db->get();		
			if ($query->num_rows() > 0) {
				return TRUE;
			}
		} else {
			return TRUE;
		}

		return FALSE;
	}

	public function saveReview($review_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['sale_type'])) {
			$this->db->set('sale_type', $save['sale_type']);
		}

		if (isset($save['sale_id'])) {
			$this->db->set('sale_id', $save['sale_id']);
		}

		if (isset($save['location_id'])) {
			$this->db->set('location_id', $save['location_id']);
		}

		if (isset($save['customer_id'])) {
			$this->db->set('customer_id', $save['customer_id']);
		}

		if (isset($save['author'])) {
			$this->db->set('author', $save['author']);
		}

		if (isset($save['rating'])) {
			if (isset($save['rating']['quality'])) {
				$this->db->set('quality', $save['rating']['quality']);
			}

			if (isset($save['rating']['delivery'])) {
				$this->db->set('delivery', $save['rating']['delivery']);
			}

			if (isset($save['rating']['service'])) {
				$this->db->set('service', $save['rating']['service']);
			}
		}

		if (isset($save['review_text'])) {
			$this->db->set('review_text', $save['review_text']);
		}

		if (APPDIR === ADMINDIR AND isset($save['review_status']) AND $save['review_status'] === '1') {
			$this->db->set('review_status', '1');
		} else if ($this->config->item('approve_reviews') !== '1') {
			$this->db->set('review_status', '1');
		} else {
			$this->db->set('review_status', '0');
		}

		if (is_numeric($review_id)) {
			$this->db->where('review_id', $review_id);
			$query = $this->db->update('reviews');
		} else {
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
			$query = $this->db->insert('reviews');
			$review_id = $this->db->insert_id();
		}
		$this->db->set('review_status', 1);
        $this->db->where('reservation_id', $save['sale_id']);
        $this->db->update('reservations');

		return $review_id;
	}

	public function deleteReview($review_id) {
		if (is_numeric($review_id)) $review_id = array($review_id);

		if ( ! empty($review_id) AND ctype_digit(implode('', $review_id))) {
			$this->db->where_in('review_id', $review_id);
			$this->db->delete('reviews');

			return $this->db->affected_rows();
		}
	}

	public function GetReviewdata($location_id){
		$this->db->select('SUM(quality) + SUM(service) as total', FALSE);
		// $this->db->select_sum('quality','delivery','service');
		$this->db->where('location_id', $location_id);
		$this->db->where('review_status', '1');
		$this->db->from('reviews');
		$query = $this->db->get();
		$rowchk = $query->num_rows();
		if($rowchk > 0){
		  $total_reviews = $query->row();
		  return $total_reviews->total;
		} else {
		  return 0;	
		}
	}

	public function updatelocRating($location_id,$rating){
		$this->db->set('location_ratings', $rating);
		$this->db->where('location_id', $location_id);
		$query = $this->db->update('locations');
		return true;
	}

}

/* End of file reviews_model.php */
/* Location: ./system/spotneat/models/reviews_model.php */