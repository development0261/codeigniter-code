<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Name:  Twilio
	*
	* Author: Ben Edmunds
	*		  ben.edmunds@gmail.com
	*         @benedmunds
	*
	* Location:
	*
	* Created:  03.29.2011
	*
	* Description:  Twilio configuration settings.
	*
	*
	*/

	/**
	 * Mode ("sandbox" or "prod")
	 **/
	$config['mode']   = 'sandbox';

	/**
	 * Account SID
	 **/
	//$config['account_sid']   = 'ACc87273cecf37e97f12373103cf5e77b0';
	$config['account_sid']   = 'ACee35f82df60836e724e77310d4afe9a8';

	/**
	 * Auth Token
	 **/
	//$config['auth_token']    = '3b946c50f341f8e8490b2f8151c7cf3d';
	$config['auth_token']    = '4632e18bb4f3ffbab74400e289b1cac7';

	/**
	 * API Version
	 **/
	$config['api_version']   = '2010-04-01';

	/**
	 * Twilio Phone Number
	 **/
	//$config['number']        = '+18135485965';
	$config['number']        = '+14792402098';


	$config['extension_meta'] = array(
		'name'        => 'twilio_module',
		'version'     => '2.0.8',
		'type'        => 'module',
		'title'       => 'Twilio',
		'author'      => 'Ben Edmunds',
		'description' => 'This extension will allow you to send and receive SMS.',
		'settings'    => TRUE,
	);

	$config['extension_permission'] = array(
	'name'        => 'Module.TwilioModule',
	'action'      => array('manage'),
	'description' => 'Ability to manage Twilio SMS Gateway',
);

$config['layout_ready'] = FALSE;
/* End of file twilio.php */