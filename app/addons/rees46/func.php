<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Rees46\Config;
use Tygh\Registry;
use Tygh\Settings;
use Tygh\Themes\Themes;
use Tygh\Http;

function fn_rees46_generate_info()
{
    $res = __('rees46_info');
    return $res;
}

function fn_rees46_generate_orders()
{
    $res = __('rees46_orders');
    $res = $res.'<p><a href="' . fn_url('rees46.export_orders') . '" class="btn btn-primary">' . __('rees46_export_order') . '</a></p>';
    return $res;
}

function fn_rees46_generate_docs()
{
    $res = __('rees46_docs');
    return $res;
}

function fn_rees46_generate_statistics()
{
    $res = __('rees46_statistics');
    return $res;
}

function fn_rees46_yml_url()
{
    $res = __('rees46_yml');
    if (fn_allowed_for('ULTIMATE')) {
        $storefrontUrls = fn_get_storefront_urls(Registry::get('runtime.company_id'));
        if (empty ($storefrontUrls) || empty($storefrontUrls["current_location"])) {
            $location = (defined('HTTPS')) ? Registry::get('config.https_location') : Registry::get('config.http_location');
        } else {
            $location = $storefrontUrls["current_location"];
        }
    } else {
        $location = (defined('HTTPS')) ? Registry::get('config.https_location') : Registry::get('config.http_location');
    }
    $res = $res.'<input type="text" style="width:98%;font-size: 1.5em;cursor:text;" value="' . $location . '/index.php?dispatch=rees46.yml" disabled>';
    return $res;
}


//Хук к списку товаров
function fn_rees46_get_products_post(&$products, $params, $lang_code) {
    //Если запрос товаров с Rees46
    if (!empty($params['rees46_code'])) {
        //Проходим по товарам
        foreach( $products as $key => $product ) {
            $products[$key]['rees46_type'] = trim($params['rees46_type']);
            $products[$key]['rees46_code'] = trim($params['rees46_code']);
        }
    }
}

// Копируем шаблоны в текущую тему
function fn_rees46_copying_theme() {
    $responsive_theme_path = Themes::factory('responsive')->getThemePath();
    $responsive_theme_path = !empty($responsive_theme_path) ? $responsive_theme_path : '';
    $themes_path = fn_get_theme_path('[themes]/', 'C');
    $themes_path = !empty($themes_path) ? $themes_path : '';
    $current_theme_name = Settings::instance()->getValue('theme_name', '');
    $current_theme_name = (!empty($current_theme_name) && $current_theme_name != 'responsive')  ? $current_theme_name : '';
    if (!empty($responsive_theme_path) && !empty($themes_path) && !empty($current_theme_name)) {
        fn_copy_addon_templates_from_repo($responsive_theme_path, $themes_path, 'rees46', $current_theme_name);
    }
}

// Slack
function fn_rees46_slack_notification() {
    if (!function_exists('curl_init')) {
        return false;
    }
    $url = 'https://app.rees46.ru/trackcms/cs-cart';
    $store = strtolower(Registry::get('config.current_host'));
    if (!empty($app['session'])) {
        $user_info = fn_get_user_info(Tygh::$app['session']['auth']['user_id']);
        $lead_info = array (  
                        'first_name' => $user_info['firstname'], 
                        'last_name' => $user_info['lastname'],
                        'email' => $user_info['email'], 
                        'phone' => $user_info['phone'],
                        'website' => $store,
                        'city' => $user_info['b_city'],
                        'country' => $user_info['b_country'],
                        'company' => $user_info['company']
                        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $lead_info);
        curl_exec($ch);
        curl_close($ch);
    }
}

function fn_sync_status_orders() {
    $orderSync  = Config::getOrderSync();
    if (!$orderSync) return;

    $shop_id = Config::getShopID();
    $shop_secret = Config::getShopSecret();
    if (($shop_id == '') || ($shop_secret == '')) {
        fn_set_notification('E', __('error'),__('rees46_error_export_order'), 'I');
    } else {
        $params = array('timestamp > ' . strtotime('-2 months'), 'items_per_page' => 500);
        $orders = fn_get_orders($params);

        $processed_orders = array();

        foreach (reset($orders) as $order) {
            $order_info = fn_get_order_info($order['order_id']);

            $order_status = 0;
            if (preg_match('/[FID]/', $order_info['status'])) {
                $order_status = 2;
            } elseif ($order_info['status'] == 'C') {
                $order_status = 1;
            } elseif (preg_match('/[OPBY]/', $order_info['status'])) {
                $order_status = 0;
            };

            $order_formatted_info = array(
                'id' => $order_info['order_id'],
                'status' => $order_status
            );

            array_push($processed_orders, $order_formatted_info);
        }

        $result = array(
            'shop_id' => $shop_id,
            'shop_secret' => $shop_secret,
            'orders' => $processed_orders
        );

        $respond = Http::post('https://api.rees46.ru/sync/orders', json_encode($result), array( 'headers' => array('Content-Type: application/json')));
    }
}

