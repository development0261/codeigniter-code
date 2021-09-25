<?php

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
		'permission' => 'Admin.Reservations|Admin.Orders|Admin.Coupons',
		'child' => array(
			'reservations' => array('class' => 'reservations', 'href' => site_url('reservations'), 'title' => lang('menu_reservation'), 'permission' => 'Admin.Reservations'),

			'orders' => array('class' => 'orders', 'href' => site_url('orders?id=&filter_search=&filter_status=all&filter_payment=&filter_date='), 'title' => lang('menu_order'), 'permission' => 'Admin.Orders'),
			'coupons' => array('class' => 'coupons', 'href' => site_url('coupons'), 'title' => lang('menu_coupon'), 'permission' => 'Admin.Coupons'),

		),
	),

	'kitchen' => array(
		'class' => 'kitchen',
		'icon' => 'fa-cutlery',
		'title' => lang('menu_kitchen'),
		'permission' => 'Admin.Categories|Admin.Menus',
		'child' => array(
			'categories' => array('class' => 'categories', 'href' => site_url('categories'), 'title' => lang('menu_category'), 'permission' => 'Admin.Categories'),
			'menus' => array('class' => 'menus', 'href' => site_url('menus'), 'title' => lang('menu_menu'), 'permission' => 'Admin.Menus'),

			'menu_options' => array('class' => 'menu_options', 'href' => site_url('menu_options'), 'title' => lang('menu_option'), 'permission' => 'Admin.MenuOptions'),

		),
	),

	'users' => array(
		'class' => 'users',
		'icon' => 'fa-user',
		'title' => lang('menu_user'),
		'permission' => 'Admin.Customers|Admin.Reviews|Admin.Feedback',
		'child' => array(
			'customers' => array('class' => 'customers', 'href' => site_url('customers'), 'title' => lang('menu_customer'), 'permission' => 'Admin.Customers'),
			'reviews' => array('class' => 'reviews', 'href' => site_url('reviews?id='), 'title' => lang('menu_review'), 'permission' => 'Admin.Reviews'),
			'feedback' => array('class' => 'feedback', 'href' => site_url('feedback'), 'title' => lang('feedback'), 'permission' => 'Admin.Feedback'),

		),
	),

	'restaurant' => array(
		'class' => 'restaurant',
		'icon' => 'fa-map-marker',
		'title' => lang('menu_restaurant'),
		'permission' => 'Admin.Locations|Admin.Tables|Admin.Staffs|Admin.Payments|Admin.Refund|Admin.Refund_report',
		'child' => array(
			'locations' => array('class' => 'locations', 'href' => site_url('locations'), 'title' => lang('menu_location'), 'permission' => 'Admin.Locations'),
			'tables' => array('class' => 'tables', 'href' => site_url('tables'), 'title' => lang('menu_table'), 'permission' => 'Admin.Tables'),
			// 'staffs' => array('class' => 'staffs', 'href' => site_url('staffs/vendor'), 'title' => lang('sidebar_settings'), 'permission' => 'Admin.Staffs'),
			'payments' => array('class' => 'payments', 'href' => site_url('orders?id=&filter_search=&filter_status=all&filter_payment=&filter_date='), 'title' => lang('menu_payments'), 'permission' => 'Admin.Payments'),
			'payments_report' => array('class' => 'payments_report', 'href' => site_url('payments_report'), 'title' => lang('sent_payments'), 'permission' => 'Admin.Payments'),
			'refund' => array('class' => 'refund', 'href' => site_url('refund'), 'title' => lang('menu_refund'), 'permission' => 'Admin.Refund'),
			'refund_report' => array('class' => 'refund_report', 'href' => site_url('refund_report'), 'title' => lang('menu_refund_report'), 'permission' => 'Admin.Refund_report'),

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
	
	'delivery' => array(
		'class' => 'delivery',
		'icon' => 'fa-motorcycle',
		'title' => lang('menu_delivery'),
		'permission' => 'Admin.Delivery|Admin.DeliveryGroups|Admin.DeliveryOnline|Admin.DeliveryPayout',
		'child' => array(
			'delivery' => array('class' => 'delivery', 'href' => site_url('delivery'), 'title' => lang('menu_deliverer'), 'permission' => 'Admin.Delivery'),
			'delivery_groups' => array('class' => 'delivery_groups hide-data', 'href' => site_url('delivery_groups'), 'title' => lang('menu_delivery_group'), 'permission' => 'Admin.DeliveryGroups'),
			'delivery_online' => array('class' => 'delivery_online', 'href' => site_url('delivery_online'), 'title' => lang('menu_delivery_online'), 'permission' => 'Admin.DeliveryOnline'),
			'delivery_payout' => array('class' => 'delivery_payout', 'href' => site_url('delivery_payout'), 'title' => lang('menu_delivery_payout'), 'permission' => 'Admin.Delivery_payout'),

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
);

?>