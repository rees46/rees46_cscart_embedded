<?php

use Tygh\Registry;

if( !defined('BOOTSTRAP') ) {
	die('Access denied');
}

if( $mode == 'get_info' ) {
	$ids = array_map('intval', $_REQUEST['product_ids']);

	list($products, $search) = fn_get_products(array(
		'pid' => $ids,
	));
	fn_gather_additional_products_data($products, array('get_icon' => true, 'get_detailed' => true, 'get_additional' => false, 'get_options'=> false));

	Registry::get('view')->assign('rees46_products', $products);
	Registry::get('view')->assign('rees46_type', $_REQUEST['recommended_by']);
	Registry::get('view')->assign('rees46_title', $_REQUEST['title']);
	Registry::get('view')->display('addons/rees46/blocks/recommenders.tpl');
	exit;
}
