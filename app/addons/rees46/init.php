<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

fn_define('DISABLE_HOOK_CACHE', true);
fn_register_hooks(
	'delete_cart_product',
	'place_order',
	'get_products_post'
);
