<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Migrate extends Main_Controller {

	public function __construct() 
	{
		parent::__construct();	
	}

	public function index() 
	{		
        $this->load->library('migration');
        if ($this->migration->latest() === FALSE)
        {
            show_error($this->migration->error_string());
        }
		else
		{
            echo "successfully migrated";
        }        

	}
}