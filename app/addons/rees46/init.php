<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

fn_define('DISABLE_HOOK_CACHE', true);
fn_register_hooks(
	'get_products_post'
);
