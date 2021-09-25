<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class twilio_model extends TI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->library('cart');
        $this->load->library('currency');
    }
    public function getTemplates($sms_code = '') {

		$this->db->from('sms_templates_data');
		if($sms_code != '')
		{
			$this->db->where('code',$sms_code);
		}
		$query = $this->db->get();
		$result = array();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
		return $result;
	}
	public function updateTemplateData($templates = array()) {
		
		
		if (empty($templates)) return FALSE;

		foreach ($templates as $template) {
			if (isset($template['subject'])) {
				$this->db->set('subject', $template['subject']);
			}
			if (isset($template['body'])) {
				$this->db->set('body', $template['body']);
			}
			if (isset($template['date_updated'])) {
				$this->db->set('date_updated', $template['date_updated']);
			}
			$this->db->set('date_updated', mdate('%Y-%m-%d %H:%i:%s', time()));
			$this->db->where('code', $template['code']);
			$query = $this->db->update('sms_templates_data');
		}

		return $query;
	}
}

/* End of file paypal_model.php */
/* Location: ./extensions/paypal_model/models/paypal_model.php */