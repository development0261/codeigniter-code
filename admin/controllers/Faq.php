<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Faq extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Faq');

        $this->load->model('Faq_model');

        $this->lang->load('faq');
	}

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		$this->template->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

		if ($this->input->post() AND $this->_updateSecurityQuestion() === TRUE){
			redirect('faq');
		}

		//load questions data into array
		$data['questions'] = array();

		if ($this->input->post('questions')) {
			$results = $this->input->post('questions');
		} else {
			$results = $this->Faq_model->getQuestions();
		}

		foreach ($results as $result) {
			$data['questions'][] = array(
				'question_id'	=> ($result['question_id'] > 0) ? $result['question_id'] : '0',
				'text'			=> $result['question_en'],
				'text_ar'			=> $result['question_ar'],
				'answer_en'			=> $result['answer_en'],
				'answer_ar'			=> $result['answer_ar'],
			);
		}

		$this->template->render('faq', $data);
	}

	private function _updateSecurityQuestion() {
    	if ($this->input->post('questions') AND $this->validateForm() === TRUE) {
			$questions = $this->input->post('questions');

			if ($this->Faq_model->updateQuestions($questions)) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Faq updated '));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		if ($this->input->post('questions')) {
			foreach ($this->input->post('questions') as $key => $value) {
				$this->form_validation->set_rules('questions['.$key.'][question_id]', 'lang:label_question', 'xss_clean|trim|required|integer');
				$this->form_validation->set_rules('questions['.$key.'][text]', 'lang:label_answer', 'xss_clean|trim|required|min_length[2]|max_length[128]');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file security_questions.php */
/* Location: ./admin/controllers/security_questions.php */