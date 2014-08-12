<?php

fn_register_hooks(
    'add_to_cart',
    'delete_cart_product',
    'place_order'
);

function fn_rees46_add_to_cart($cart, $product_id, $_id)
{
    \Rees46\Events::CookieEvent('cart', array('item_id' => $product_id));
}

function fn_rees46_delete_cart_product($cart, $cart_id, $full_erase)
{
    if (!empty($cart_id) && !empty($cart['products'][$cart_id])) {
        if (!empty($cart['products'][$cart_id]['product_id'])) {
            $product_id = $cart['products'][$cart_id]['product_id'];

            \Rees46\Events::CookieEvent('remove_from_cart', array('item_id' => $product_id));
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

    \Rees46\Events::CookieEvent('order', $data);
}
