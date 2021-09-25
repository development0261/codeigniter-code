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
 * Security_questions Model Class
 *
 * @category       Models
 * @package        SpotnEat\Models\Security_questions_model.php
 * @link           http://docs.spotneat.com
 */
class Faq_model extends TI_Model {

	public function getQuestions() {
		$this->db->from('faq');

		$this->db->order_by('priority', 'ASC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getQuestion($question_id) {
		$this->db->from('security_questions');

		$this->db->where('question_id', $question_id);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function updateQuestions($questions = array()) {
		$query = FALSE;

		if ( ! empty($questions)) {
			$priority = 1;
			
			foreach ($questions as $question) {
				if ( ! empty($question['text'])) {
					if ( ! empty($question['question_id']) AND $question['question_id'] > 0) {
						$this->db->set('question_en', $question['text']);
						$this->db->set('question_ar', $question['text_ar']);
						$this->db->set('answer_en', $question['answer_en']);
						$this->db->set('answer_ar', $question['answer_ar']);
						$this->db->set('priority', $priority);
						$this->db->where('question_id', $question['question_id']);
						$this->db->update('faq');
					} else if ( ! empty($question['text'])) {
						$this->db->set('question_en', $question['text']);
						$this->db->set('question_ar', $question['text_ar']);
						$this->db->set('answer_en', $question['answer_en']);
						$this->db->set('answer_ar', $question['answer_ar']);
						$this->db->set('priority', $priority);
						$this->db->insert('faq');
					}
				}

				$priority ++;
			}

			$query = TRUE;
		}

		return $query;
	}
}

/* End of file security_questions_model.php */
/* Location: ./system/spotneat/models/security_questions_model.php */