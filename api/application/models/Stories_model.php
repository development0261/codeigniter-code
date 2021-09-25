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
class Stories_model extends CI_Model {

	
	public function getStoryBasedOnLocation($location_id,$added_by)
	{
		/* SELECT a.`location_name` as resturent_name,c.title as story_title, c.content,c.story_image
		FROM `yvdnsddqu_locations` a
		INNER JOIN yvdnsddqu_stories_access b ON a.`location_id`=b.location_id
		INNER JOIN yvdnsddqu_stories c on b.story_id=c.id
		WHERE  b.location_id=3*/
		$where="c.status ='1' AND b.location_id=$location_id";
		if($added_by){
			$where="c.status ='1' AND (b.location_id= $location_id OR c.added_by=$added_by)";

		}
		return $this->db->select('locations.location_name as resturent_name,c.video_url,c.title as story_title, c.content,c.story_image,c.added_date, c.id as story_id')
				->join('stories_access b','locations.location_id=b.location_id','inner')
				->join('stories c','b.story_id=c.id','inner')
				->where($where)
				->group_by('c.id')
				->order_by('c.added_date','desc')
				->get('locations');

	}

	public function addStory($story_id, $save = array()) {
		if (empty($save) AND ! is_array($save)) return FALSE;
		if (isset($save['title'])) {
			$this->db->set('title', $save['title']);
		}

		if (isset($save['content'])) {
			$this->db->set('content', $save['content']);
		}
		$this->db->set('status', 1);

		if (isset($save['story_image'])) {
			$this->db->set('story_image', $save['story_image']);
		}
		if (isset($save['video_url'])) {
			$this->db->set('video_url', $save['video_url']);
		}
		if (isset($save['added_by'])) {
			$this->db->set('added_by', $save['added_by']);
		}

		if (is_numeric($story_id)) {
			$this->db->where('id', (int) $story_id);
			$query = $this->db->update('stories');
		} else {
			$query = $this->db->insert('stories');
			$story_id = $this->db->insert_id();
		}
		if ($query === TRUE AND is_numeric($story_id)) {
			return $story_id;
		}
	}
	public function deleteStory($story_id){
		if (is_numeric($story_id)) $story_id = array($story_id);
		if ( ! empty($story_id) AND ctype_digit(implode('', $story_id))) {
			$this->db->where_in('id', $story_id);
			$this->db->delete('stories');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('story_id', $story_id);
				$this->db->delete('stories_access');
				return $affected_rows;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}

/* End of file staff_groups_model.php */
/* Location: ./system/spotneat/models/staff_groups_model.php */