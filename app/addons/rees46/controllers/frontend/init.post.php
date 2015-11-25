<?php
use Tygh\Rees46\Init;
use Tygh\Registry;

$php_value = phpversion();
if (version_compare($php_value, '5.4.0') == -1) {
	fn_set_notification('E', __('rees46_php_version'), '', 'I');
} else {
	Registry::get('view')->assign('rees46', Init::getGlobal());
}
