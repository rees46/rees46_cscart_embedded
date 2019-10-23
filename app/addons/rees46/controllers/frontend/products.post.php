<?php
use Tygh\Registry;

if( !defined('BOOTSTRAP') ) {
    die('Access denied');
}

if($mode == 'quick_view') {
    if(!empty($_REQUEST['recommended_code']) && !empty($_REQUEST['recommended_by'])) {
        Registry::get('view')->assign('rees46_type', $_REQUEST['recommended_by']);
        Registry::get('view')->assign('rees46_code', $_REQUEST['recommended_code']);
    }
    Registry::get('view')->display('views/products/quick_view.tpl');
    exit;
}
