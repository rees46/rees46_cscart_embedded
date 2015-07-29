<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Rees46\Config;
use Tygh\Rees46\Events;
use Tygh\Registry;

function fn_rees46_generate_info()
{
    if (Config::getShopID() == '') {
        return '
        <p>
          <h3>' . __('rees46_text_settings_title') . ':</h3>
          <ol>
            ' . __('rees46_text_settings_steps') . '
          </ol>
        </p>
        ';
    } else {
        $res = __('rees46_text_settings_info');

        $res = $res . '<p><a href="/admin.php?dispatch=rees46.export_orders" class="btn btn-primary">' . __('rees46_export_order') . '</a> (' . __('rees46_export_order_hint') . ')</p>';

        return $res;
    }
}

function fn_rees46_add_to_cart($cart, $product_id, $_id)
{
    Events::CookieEvent('cart', array('item_id' => $product_id));
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