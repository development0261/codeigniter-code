<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link           https://codeigniter.com/user_guide/helpers/language_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('isAdminID'))
{
	function isAdminID($loggedID)
	{
		if($loggedID == 11){
		return "0";	
		}else{
		return $loggedID;	
		}

	}
}
