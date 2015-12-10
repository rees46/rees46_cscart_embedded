<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Rees46\Config;
use Tygh\Rees46\Events;
use Tygh\Registry;

function fn_rees46_generate_php_version_status()
{
	$php_value = phpversion();
	$php_value_required = '5.4.0';
	if (version_compare($php_value, $php_value_required, '>=')) {
		return(true);
	} else {
                return(false);
	}
}

function fn_rees46_generate_php_version()
{
	if (!fn_rees46_generate_php_version_status() && __('rees46_php_version')!='_rees46_php_version') {
		fn_set_notification('E', __('rees46_php_version'), '', true, 'I');
	}
	return;
}

function fn_rees46_generate_info()
{
	$res = __('rees46_info');
	return $res;
}

function fn_rees46_generate_orders()
{
	$res = __('rees46_orders');
	$res = $res.'<p><a href="' . fn_url('rees46.export_orders') . '" class="btn btn-primary">' . __('rees46_export_order') . '</a></p>';
	return $res;
}

function fn_rees46_generate_docs()
{
	$res = __('rees46_docs');
	return $res;
}

function fn_rees46_generate_statistics()
{
	$res = __('rees46_statistics');
	return $res;
}

function fn_rees46_delete_cart_product($cart, $cart_id, $full_erase)
{
	if (!empty($cart_id) && !empty($cart['products'][$cart_id])) {
		if (!empty($cart['products'][$cart_id]['product_id'])) {
			$product_id = $cart['products'][$cart_id]['product_id'];

			Events::CookieEvent('remove_from_cart', array('item_id' => $product_id));
		}
	}
}

function fn_rees46_place_order($order_id, $action, $order_status, $cart, $auth)
{
	$data = array(
		'items'     => array(),
		'order_id'  => $order_id,
	);

	foreach ($cart['products'] as $product) {
		array_push($data['items'], array('item_id' => $product['product_id'], 'amount'  => $product['amount']));
	}

	Events::CookieEvent('order', $data);
}

//Хук к списку товаров
function fn_rees46_get_products_post(&$products, $params, $lang_code) {
	//Если запрос товаров с Rees46
	if( !empty($params['rees46_type']) ) {
		//Проходим по товарам
		foreach( $products as $key => $product ) {
			$products[$key]['rees46_type'] = $params['rees46_type'];
		}
	}
}