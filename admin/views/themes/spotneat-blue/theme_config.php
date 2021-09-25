<?php if (!defined('BASEPATH')) {
	exit('No direct access allowed');
}

/**
 * Theme configuration options for admin panel customization.
 * This file contains an array of options for use with the theme customizer.
 * ONLY $theme = array() allowed
 *
 */

// Set a custom theme title.

$theme['title'] = 'RestaurantCart Admin Blue';
$theme['author'] = 'Sp';
$theme['version'] = '1.0';
$theme['description'] = 'Responsive theme for admin panel';

$theme['nav_menu'] = array(
	'dashboard' => array(
		'class' => 'dashboard admin',
		'href' => site_url('dashboard'),
		'icon' => 'fa-dashboard',
		'title' => lang('menu_dashboard'),
	),
	'sales' => array(
		'class' => 'sales',
		'icon' => 'fa-bar-chart-o',
		'title' => lang('menu_sale'),
		'permission' => 'Admin.Orders',
		'child' => array(
			'orders' => array('class' => 'orders', 'href' => site_url('orders'), 'title' => lang('menu_order'), 'permission' => 'Admin.Orders'),

			'reservations' => array('class' => 'reservations', 'href' => site_url('reservations'), 'title' => lang('menu_reservation'), 'permission' => 'Admin.Reservations'),
			'coupons' => array('class' => 'coupons', 'href' => site_url('coupons'), 'title' => lang('menu_coupon'), 'permission' => 'Admin.Coupons'),
		),
	),
	'kitchen' => array(
		'class' => 'kitchen',
		'icon' => 'fa-cutlery',
		'title' => lang('menu_kitchen'),
		'permission' => 'Admin.Menus|Admin.MenuOptions|Admin.Categories',
		'child' => array(
			'menus' => array('class' => 'menus', 'href' => site_url('menus'), 'title' => lang('menu_menu'), 'permission' => 'Admin.Menus|Admin.MenuOptions|Admin.Categories'),
			'menu_options' => array('class' => 'menu_options', 'href' => site_url('menu_options'), 'title' => lang('menu_option'), 'permission' => 'Admin.MenuOptions'),
			'categories' => array('class' => 'categories', 'href' => site_url('categories'), 'title' => lang('menu_category'), 'permission' => 'Admin.Categories'),
		),
	),
 
 
	'users' => array(
		'class' => 'users',
		'icon' => 'fa-user',
		'title' => lang('menu_user'),
		'permission' => 'Admin.Customers|Admin.CustomerGroups|Admin.CustomersOnline',
		'child' => array(
			'customers' => array('class' => 'customers', 'href' => site_url('customers'), 'title' => lang('menu_customer'), 'permission' => 'Admin.Customers'),
			'customer_groups' => array('class' => 'customer_groups hide-data', 'href' => site_url('customer_groups'), 'title' => lang('menu_customer_group'), 'permission' => 'Admin.CustomerGroups'),
			'customers_online' => array('class' => 'customers_online', 'href' => site_url('customers_online'), 'title' => lang('menu_customer_online'), 'permission' => 'Admin.CustomersOnline'),
			'activities' => array('class' => 'activities hide-data', 'href' => site_url('activities'), 'title' => lang('menu_activities'), 'permission' => 'Admin.Activities'),	
		),
	),
 
 



	'subscriptions' => array(
		'class' => 'subscriptions',
		'icon' => 'fa-users',
		'title' => lang('menu_subscriptions'),
		'permission' => 'Site.Stories|Admin.Delivery|Admin.DeliveryGroups|Admin.DeliveryOnline|DeliveryPayout',
		'child' => array(
			'subscriptions' => array('class' => 'subscriptions', 'href' => site_url('subscriptions'), 'title' => lang('menu_subscriptions_child'), 'permission' => 'Site.Stories'),
		),
	),
	'workout_related_videos' => array(
		'class' => 'workout_related_videos',
		'icon' => 'fa-users',
		'title' => lang('workout_related_videos'),
		'permission' => 'Site.Stories|Admin.Delivery|Admin.DeliveryGroups|Admin.DeliveryOnline|DeliveryPayout',

		'child' => array(
			'workout_related_videos' => array('class' => 'workoutvideos', 'href' => site_url('workout_related_videos'), 'title' => lang('workout_related_videos_child'), 'permission' => 'Site.Stories'),
			'workout_related_videos_category' => array('class' => 'workoutvideos', 'href' => site_url('workout_related_videos/categories'), 'title' => lang('workout_related_videos_category'), 'permission' => 'Site.Stories'),
			'workout_related_videos_schedule' => array('class' => 'workoutvideos', 'href' => site_url('workout_related_videos/schedules'), 'title' => lang('workout_related_videos_schedule'), 'permission' => 'Site.Stories'),
		),

	),
	'workout_with_us_videos' => array(
		'class' => 'workout_with_us_videos',
		'icon' => 'fa-users',
		'title' => lang('workout_with_us_videos'),
		'permission' => 'Site.Stories|Admin.Delivery|Admin.DeliveryGroups|Admin.DeliveryOnline|DeliveryPayout',

		'child' => array(
			'workout_with_us_videos' => array('class' => 'workoutwithusvideos', 'href' => site_url('workout_with_us_videos'), 'title' => lang('workout_with_us_videos_child'), 'permission' => 'Site.Stories'),
		),

	),
	'exercise_library' => array(
		'class' => 'exercise_library',
		'href' => site_url('exercise_library'),
		'icon' => 'fa-dashboard',
		'title' => lang('exercise_library'),
	),

	'push' => array(
		'class' => 'pushes',
		'icon' => 'fa-users',
		'title' => 'Push Notification',
		'permission' => 'Site.Stories',
		'child' => array(
			'Send Push' => array('class' => 'pushes', 'href' => site_url('notifications'), 'title' => 'Send Push', 'permission' => 'Site.Stories'),
		),
	),
	'eatrightpdfs' => array(
		'class' => 'pushes',
		'icon' => 'fa-users',
		'title' => 'Eat Right PDF',
		'permission' => 'Site.Stories',
		'child' => array(
			'Send Push' => array('class' => 'pushes', 'href' => site_url('eatrightpdfs'), 'title' => 'Eat Right', 'permission' => 'Site.Stories'),
		),
	),
 
	'extensions' => array(
		'class' => 'extensions hide-data',
		'href' => site_url('extensions'),
		'icon' => 'fa-puzzle-piece',
		'title' => lang('menu_extension'),
		'permission' => 'Admin.Extensions',
	),
	'design' => array(
		'class' => 'design hide-data',
		'icon' => 'fa-paint-brush',
		'title' => lang('menu_design'),
		'permission' => 'Site.Pages|Site.Layouts|Site.Themes|Admin.MailTemplates',
		'child' => array(
			'pages' => array('class' => 'pages', 'href' => site_url('pages'), 'title' => lang('menu_page'), 'permission' => 'Site.Pages'),
			'layouts' => array('class' => 'layouts', 'href' => site_url('layouts'), 'title' => lang('menu_layout'), 'permission' => 'Site.Layouts'),
			'themes' => array('class' => 'themes', 'href' => site_url('themes'), 'title' => lang('menu_theme'), 'permission' => 'Site.Themes'),
			'mail_templates' => array('class' => 'mail_templates', 'href' => site_url('mail_templates'), 'title' => lang('menu_mail_template'), 'permission' => 'Admin.MailTemplates'),
		),
	),
 
	'stories' => array(
		'class' => 'stories',
		'icon' => 'fa-users',
		'title' => lang('menu_stories'),
		'permission' => 'Site.Stories',
		'child' => array(
			'stories' => array('class' => 'stories', 'href' => site_url('stories'), 'title' => lang('menu_stories'), 'permission' => 'Site.Stories'),
		),
	),
	'system' => array(
		'class' => 'system',
		'icon' => 'fa-cog',
		'title' => lang('menu_system'),
		'permission' => 'Admin.Permissions|Admin.ErrorLogs|Site.Settings|Admin.Faq|Admin.Banners',
		'child' => array(
			'settings' => array('class' => 'settings', 'href' => site_url('settings'), 'title' => lang('menu_setting'), 'permission' => 'Site.Settings'),
			'banners' => array('class' => 'banners', 'href' => site_url('banners'), 'title' => lang('banners'), 'permission' => 'Admin.Banners'),
			'Vip Pass Code' => array('class' => 'vippasscode', 'href' => site_url('vippasscode'), 'title' => lang('menu_vipcode'), 'permission' => 'Admin.VipPassCode'),
			// 'faq' => array('class' => 'faq', 'href' => site_url('faq'), 'title' => lang('menu_faq'), 'permission' => 'Admin.Faq'),
			'permissions' => array('class' => 'permissions hide-data', 'href' => site_url('permissions'), 'title' => lang('menu_permission'), 'permission' => 'Admin.Permissions'),
			//'uri_routes' => array('class' => 'uri_routes', 'href' => site_url('uri_routes'), 'title' => lang('menu_uri_route')),
			'error_logs' => array('class' => 'error_logs hide-data', 'href' => site_url('error_logs'), 'title' => lang('menu_error_log'), 'permission' => 'Admin.ErrorLogs'),
			'tools' => array(
				'class' => 'tools',
				'title' => lang('menu_tool'),
				'permission' => 'Admin.MediaManager|Admin.Maintenance',
				'child' => array(
					'image_manager' => array('class' => 'image_manager', 'href' => site_url('image_manager'), 'title' => lang('menu_media_manager'), 'permission' => 'Admin.MediaManager'),
					//'maintenance' => array('class' => 'maintenance', 'href' => site_url('maintenance'), 'title' => lang('menu_maintenance'), 'permission' => 'Admin.Maintenance'),
				),
			),

		),
	),
	'collapse' => array(
		'class' => 'hidden-xs sidebar-toggle collap',
		'icon' => 'fa-chevron-circle-left',
		'title' => lang('menu_collapse'),
	),
);

/* End of file theme_config.php */
/* Location: ./admin/views/themes/spotneat-blue/theme_config.php */