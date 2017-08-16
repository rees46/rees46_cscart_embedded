<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Rees46\Config;
use Tygh\Registry;
use Tygh\Settings;
use Tygh\Themes\Themes;

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


function fn_rees46_sync_status_orders ()
{
	$res = __('rees46_sync_status');
	$res = $res.'<p><a href="' . fn_url('rees46.sync_status_orders') . '" class="btn btn-primary">' . __('rees46_sync_status_orders') . '</a></p>';
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
	$res = $res.'<input type="text" style="width:98%;font-size: 1.5em;cursor:text;" value="' . Registry::get('config.http_location') . '/index.php?dispatch=rees46.yml" disabled>';
	return $res;
}


//Хук к списку товаров
function fn_rees46_get_products_post(&$products, $params, $lang_code) {
	//Если запрос товаров с Rees46
	if( !empty($params['rees46_type']) ) {
		//Проходим по товарам
		foreach( $products as $key => $product ) {
			$products[$key]['rees46_type'] = $params['rees46_type'];
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
    $url = 'https://app.rees46.com/trackcms/cs-cart';
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


