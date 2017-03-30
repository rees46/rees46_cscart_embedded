<?php
use Tygh\Registry;
use Tygh\Rees46\Config;
use Tygh\Http;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'export_orders') {
    $shop_id = Config::getShopID();
    $shop_secret = Config::getShopSecret();
    if (($shop_id == '') || ($shop_secret == '')) {
        fn_set_notification('E', __('error'),__('rees46_error_export_order'), 'I');
    } else {
        $params = array('timestamp > ' . strtotime('-6 months'), 'items_per_page' => 500);
        $orders = fn_get_orders($params);

        $processed_orders = array();

        foreach (reset($orders) as $order) {
            $order_info = fn_get_order_info($order['order_id']);

            $items_formatted_info = array();
            foreach ($order_info['products'] as $product) {
                $product_formatted = array(
                    'id' =>  $product['product_id'],
                    'price' => $product['price'],
                    'amount' => $product['amount']
                );

                array_push($items_formatted_info, $product_formatted);
            }

            $order_formatted_info = array(
                'id' => $order_info['order_id'],
                'user_id' => $order_info['user_id'],
                'user_email' => $order_info['email'],
                'date' => $order_info['timestamp'],
                'items' => $items_formatted_info
            );

            array_push($processed_orders, $order_formatted_info);
        }

        $result = array(
            'shop_id' => $shop_id,
            'shop_secret' => $shop_secret,
            'orders' => $processed_orders
        );

	$respond=Http::post('http://api.rees46.com/import/orders.json', json_encode($result), array( 'headers' => array('Content-Type: application/json')));
	if (strtoupper($respond)=='OK') {
		fn_set_notification('N', __('rees46_export_success'), '', 'I');
	} else {
		fn_set_notification('E', __('rees46_export_unsuccess'), '', 'I');
	}
    }

    return array(CONTROLLER_STATUS_REDIRECT, "addons.manage");
}

if ($mode == 'sync_status_orders') {
    $shop_id = Config::getShopID();
    $shop_secret = Config::getShopSecret();
    if (($shop_id == '') || ($shop_secret == '')) {
        fn_set_notification('E', __('error'),__('rees46_error_export_order'), 'I');
    } else {
        $params = array('timestamp > ' . strtotime('-2 months'), 'items_per_page' => 500);
        $orders = fn_get_orders($params);

        $processed_orders = array();

        foreach (reset($orders) as $order) {
            $order_info = fn_get_order_info($order['order_id']);

            $order_status = 0;
            if (preg_match('/[FID]/', $order_info['status'])) {
                $order_status = 2;
            } elseif ($order_info['status'] == 'C') {
                $order_status = 1;
            } elseif (preg_match('/[OPBY]/', $order_info['status'])) {
                $order_status = 0;
            };

            $order_formatted_info = array(
                'id' => $order_info['order_id'],
                'status' => $order_status
            );

            array_push($processed_orders, $order_formatted_info);
        }

        $result = array(
            'shop_id' => $shop_id,
            'shop_secret' => $shop_secret,
            'orders' => $processed_orders
        );


	$respond=Http::post('http://api.rees46.com/import/sync_orders', json_encode($result), array( 'headers' => array('Content-Type: application/json')));
	if (strtoupper($respond)=='OK') {
		fn_set_notification('N', __('rees46_sync_status_success'), '', 'I');
	} else {
		fn_set_notification('E', __('rees46_sync_status_unsuccess'), '', 'I');
	}
    }

    return array(CONTROLLER_STATUS_REDIRECT, "addons.manage");
}

