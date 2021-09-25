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
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Controller Class
 *
 * @category       Libraries
 * @package        SpotnEat\Core\Main_Controller.php
 * @link           http://docs.spotneat.com
 */
class Main_Controller extends Base_Controller {

    /**
     * Class constructor
     *
     */
	public function __construct()
	{
        parent::__construct();

		log_message('info', 'Main Controller Class Initialized');

        // Load permalink
        $this->load->library('permalink');

        // Load template library
        $this->load->library('template');

        $this->load->library('customer');

        $this->load->library('customer_online');

        $this->load->model('Pages_model');

		$this->load->library('location');
    }
}

/* End of file Main_Controller.php */
/* Location: ./system/spotneat/core/Main_Controller.php */