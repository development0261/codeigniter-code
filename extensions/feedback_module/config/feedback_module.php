<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$config['extension_meta'] = array(
		'name'        => 'feedback_module',
		'version'     => '1.1',
		'type'        => 'module',
		'title'       => 'Feedback',
		'author'      => 'SpotnEat',
		'description' => 'This extension will allow you to send and receive Feedback.',
		'settings'    => TRUE,
	);

	$config['extension_permission'] = array(
		'name'        => 'Module.FeedbackModule',
		'action'      => array('manage'),
		'description' => 'Ability to manage Feedback system.',
	);
/*
|--------------------------------------------------------------------------
| Extension Layout Ready (Optional)
|--------------------------------------------------------------------------
|
| This extension config value tells SpotnEat to use the extension as a layout module
| (layout modules are displayed in the storefront inside partial areas)
*/
$config['layout_ready'] = FALSE;
/* End of file feedback.php */