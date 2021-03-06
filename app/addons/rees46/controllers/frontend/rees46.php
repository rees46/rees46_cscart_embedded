<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($mode == 'get_info') {

    if (empty($_REQUEST['orientation'])) {
        $orientation = 'horizontal';
    } else {
        $orientation = $_REQUEST['orientation'];
    }

    $productsPerLine = 4;
    if (!empty($_REQUEST['products_perline'])) $productsPerLine = $_REQUEST['products_perline'];

    $ids = array_map('intval', $_REQUEST['product_ids']);
    list($products, $search) = fn_get_products(array(
        'pid'         => $ids,
        'rees46_type' => $_REQUEST['recommended_by'],
        'rees46_code' => $_REQUEST['recommended_code']
    ));
    fn_gather_additional_products_data($products, array('get_icon' => false, 'get_detailed' => true, 'get_additional' => false, 'get_options' => false));

    Registry::get('view')->assign('rees46_products', $products);
    Registry::get('view')->assign('rees46_type', $_REQUEST['recommended_by']);
    Registry::get('view')->assign('rees46_code', $_REQUEST['recommended_code']);
    Registry::get('view')->assign('rees46_title', $_REQUEST['title']);
    Registry::get('view')->assign('rees46_block_orientation', $orientation);
    Registry::get('view')->assign('rees46_products_per_line', $productsPerLine);
    Registry::get('view')->display('addons/rees46/blocks/recommenders.tpl');
    exit;
}

if ($mode == 'yml') {
    $filename = Registry::get('config.dir.cache_misc') . 'rees46.yml';
    require_once('rees46_yml.php');
    @ignore_user_abort(true);
    set_time_limit(3600);
    fn_sync_status_orders();
    fn_yml_get_rees46_yml($filename);
    exit;
}

if ($mode == 'version') {
    $version = fn_get_addon_version('rees46');
    $version = !empty($version) ? $version : 'undefined';
    echo "REES46 add-on version: {$version}\n\n";
    $company_id = Registry::get('runtime.company_id');
    echo "StoreFront ID: {$company_id}";

    exit;
}
