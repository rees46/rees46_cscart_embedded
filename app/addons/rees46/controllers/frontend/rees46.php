<?php

use Tygh\Registry;

if( !defined('BOOTSTRAP') ) {
	die('Access denied');
}

if( $mode == 'get_info' ) {
	$ids = array_map('intval', $_REQUEST['product_ids']);
	$products = array();

	foreach( $ids as $id ) {
		$p = fn_get_product_data($id, $auth, CART_LANGUAGE, '', false, true, false, false, fn_is_preview_action($auth, $_REQUEST));
		if( $p['product'] != null ) {
			array_push($products, $p);
		}
	}

	Registry::get('view')->assign('rees46_products', $products);
	Registry::get('view')->assign('rees46_products_count', count($products));
	Registry::get('view')->display('addons/rees46/blocks/recommenders.tpl');
	exit;
}
