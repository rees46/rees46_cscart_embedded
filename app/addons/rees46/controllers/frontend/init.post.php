<?php
use Tygh\Rees46\Init;
use Tygh\Registry;

if (function_exists('fn_rees46_generate_php_version_status') && fn_rees46_generate_php_version_status()) {
	Registry::get('view')->assign('rees46', Init::getGlobal());
}

