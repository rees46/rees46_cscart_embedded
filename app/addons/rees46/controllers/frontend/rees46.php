<?php

use Tygh\Registry;

if( !defined('BOOTSTRAP') ) {
	die('Access denied');
}

if( $mode == 'get_info' ) {

	if( empty($_REQUEST['count']) ) {
		$count = 4;
	} else {
		$count = $_REQUEST['count'];
	}
	if( empty($_REQUEST['orientation']) ) {
		$orientation = 'horizontal';
	} else {
		$orientation = $_REQUEST['orientation'];
	}
	$ids = array_slice(array_map('intval', $_REQUEST['product_ids']), 0, $count);

	if( count($ids) == $count ) {
		list($products, $search) = fn_get_products(array(
			'pid'         => $ids,
			'rees46_type' => $_REQUEST['recommended_by']
		));
		fn_gather_additional_products_data($products, array('get_icon' => false, 'get_detailed' => true, 'get_additional' => false, 'get_options' => false));
	} else {
		$products = array();
	}
	Registry::get('view')->assign('rees46_products', $products);
	Registry::get('view')->assign('rees46_type', $_REQUEST['recommended_by']);
	Registry::get('view')->assign('rees46_title', $_REQUEST['title']);
	Registry::get('view')->assign('rees46_count', $count);
	Registry::get('view')->assign('rees46_block_orientation', $orientation);
	Registry::get('view')->display('addons/rees46/blocks/recommenders.tpl');
	exit;
}

if ($mode == 'yml') {
	$filename = Registry::get('config.dir.cache_misc') . 'rees46.yml';
	require_once('rees46_yml.php');
	@ignore_user_abort(true);
	set_time_limit(3600);
	fn_yml_get_rees46_yml($filename);
    exit;
}

if ($mode == 'version') {
    $version = fn_get_addon_version('rees46');
    $version = !empty($version) ? $version : 'undefined';
    echo 'REES46 add-on version: '.$version;
    exit;
}
