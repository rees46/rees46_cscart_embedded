<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Rees46\Config;
use Tygh\Registry;

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