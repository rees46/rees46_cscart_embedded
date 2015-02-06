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
          <h3>Для того, чтобы включить систему рекомендаций:</h3>
          <ol>
            <li>Перейдите на <a href="REES46.com" target="_blank">http://rees46.com/</a>;</li>
            <li>Зарегистрируйтесь;</li>
            <li>Создайте магазин;</li>
            <li>Введите код вашего магазина в поле ниже;</li>
            <li>Нажмите "Сохранить".</li>
            <li>Ознакомьтесь с <a href="http://memo.mkechinov.ru/display/R46D/CS-Cart" target="_blank">подробной инструкцией</a> по настройке модуля.</li>
          </ol>
        </p>
        ';
    } else {
        $res = '
          <p>Перейти к <a href="http://rees46.com/shops" target="_blank">статистике эффективности</a> работы системы персонализации.</p>
          <p>Прочитать <a href="http://memo.mkechinov.ru/pages/viewpage.action?pageId=1409157" target="_blank">подробную инструкцию</a> по настройке модуля.</p>
        ';

        $res = $res . '<p><a href="/admin.php?dispatch=rees46.export_orders" class="btn btn-primary">Выгрузить заказы</a> (может занять некоторое время)</p>';

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