<?php

fn_register_hooks(
    'add_to_cart',
    'delete_cart_product'
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

            \Rees46\Events::CookieEvent('remove_from_cart', $product_id);
        }
    }
}
