<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

fn_register_hooks(
    'add_to_cart',
    'delete_cart_product',
    'place_order'
);
