<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'get_info') {
    $ids = array_map('intval', explode(',', $_REQUEST['product_ids']));

		list($products, $search) = fn_get_products($ids, 4);

//    $products = array();

//    foreach ($ids as $id) {
//        $p = fn_get_product_data($id, $auth, CART_LANGUAGE, '', false, true, false, false, fn_is_preview_action($auth, $_REQUEST));
//
//        if ($p['product'] != null) {
//            $p = Array(
//                'name' => $p['product'],
//                'url' => fn_url('products.view?product_id='.$id),
//                'price' => round($p['base_price'], 2),
//                'image_url' => $p['main_pair']['detailed']['image_path']
//            );
//            array_push($products, $p);
//        }
//    }

	Registry::get('view')->assign('products', $ids);
	Registry::get('view')->display('templates/blocks/list_templates/products_list.tpl');
	exit;
//    header('Content-Type: application/json');
//    die(json_encode(Array('products' => $products)));
}
