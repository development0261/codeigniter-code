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
 * Admin Controller Class
 *
 * @category       Libraries
 * @package        SpotnEat\Core\Admin_Controller.php
 * @link           http://docs.spotneat.com
 */
class Admin_Controller extends Base_Controller {

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
        parent::__construct();

		log_message('info', 'Admin Controller Class Initialized');

        // Load template library
        $this->load->library('template');

        $this->load->library('user');

		$uri = $this->uri->rsegment(1);
        if (!$this->user->isLogged() AND $uri !== 'login' AND $uri !== 'logout') {
            $this->alert->set('danger', $this->lang->line('alert_user_not_logged_in'));
            $prepend = empty($uri) ? '' : '?redirect=' . current_url();
            redirect(admin_url('login'.$prepend));
        }
    }
}

/* End of file Admin_Controller.php */
/* Location: ./system/spotneat/core/Admin_Controller.php */