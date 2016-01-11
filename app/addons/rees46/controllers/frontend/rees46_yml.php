<?php
use Tygh\Registry;

function check_xml ($strng_xml) {
    $translate_xml = array (
        '&' => '&amp;',
        '\'' => '&apos;',
        '"' => '&quot;',
        '>' => '&gt;',
        '<' => '&lt;'
    );
    $original = array_flip($translate_xml);
    $strng_xml = str_replace($original, $translate_xml, $strng_xml);
    return $strng_xml;
}

function recursive_category($pid, $f, $arr_category) {
    $query = "SELECT cat1.category_id AS id, cat1.parent_id 
		AS parentId, cat2.category 
		AS name FROM `cscart_categories` 
		AS cat1 
		LEFT JOIN `cscart_category_descriptions`AS cat2 
		ON cat1.category_id = cat2.category_id 
		WHERE cat2.lang_code = 'RU' AND cat1.status = 'A' AND cat1.parent_id = ".$pid."
            ";
    $categories = db_get_array($query, USERGROUP_ALL);

    if ($pid == 0) fwrite($f, chr(9).'<categories>'.chr(10));
	foreach ($categories as  $category) {
	  $str = '<category id="'.$category['id'].'"';
      if ($pid > 0) $str .= ' parentId="'.$pid.'"';
      fwrite($f, chr(9).chr(9).$str.'>'.check_xml($category['name']).'</category>'.chr(10));
      $arr_category[] = $category['id'];
      recursive_category($category['id'], $f, $arr_category);
	}
    if ($pid == 0) fwrite($f, chr(9).'</categories>'.chr(10));
}

function fn_yml_get_rees46_yml($filename){

	$arr_category = array();
	$company  = Registry::get('addons.my_yml.company_name');
	$location = Registry::get('config.http_location');
	$lmod     = date('Y-m-d H:i');
	$modification  = Registry::get('addons.rees46.modification');
	
	header("Content-Type: text/xml;charset=utf-8");

/*============================================================================*/
// Вывод заголовка файла



$f = fopen($filename, "wb");
fwrite($f, '<?xml version="1.0" encoding="utf-8"?>'.chr(10));
fwrite($f, '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">'.chr(10));
fwrite($f, '<yml_catalog date="'.$lmod.'">'.chr(10));
fwrite($f, '<shop>'.chr(10));
/*============================================================================*/
// Вывод данных о компании
fwrite($f, chr(9).'<name>'.Registry::get('settings.Company.company_name').'</name>'.chr(10));
fwrite($f, chr(9).'<company>'.Registry::get('settings.Company.company_name').'</company>'.chr(10));
fwrite($f, chr(9).'<url>'.$location.'</url>'.chr(10));
/*============================================================================*/
fwrite($f, chr(9).'<currencies>'.chr(10));
//        <currency id="RUR" rate="1"/>
//        <currency id="USD" rate="CBRF"/>
//        <currency id="EUR" rate="CBRF" plus="3"/>
//        <currency id="UAH" rate="5.6"/>
//        <currency id="KZT" rate="0.19"/>
// Получаем список валют (только активных)
$currencies = db_get_array("SELECT * FROM ?:currencies WHERE status='A'", USERGROUP_ALL);
foreach ($currencies as  $currency) {
    fwrite($f, chr(9).chr(9).'<currency id="'.$currency['currency_code'].'" rate="'.$currency['coefficient'].'"/>'.chr(10));
}
fwrite($f, chr(9).'</currencies>'.chr(10));
/*============================================================================*/
// Загружаем дерево разделов каталога
recursive_category(0, $f, $arr_category);
/*============================================================================*/
fwrite($f, chr(9).'<offers>'.chr(10));
/*----------------------------------------------------------------------------*/
//        <offer id="12341" type="vendor.model" available="true" bid="13">
//            <url>http://best.seller.ru/product_page.asp?pid=12344</url>
//            <price>700</price>
//            <currencyId>USD</currencyId>
//            <categoryId> 6 </categoryId>
//            <picture>http://best.seller.ru/img/device12345.jpg</picture>
//            <delivery> true </delivery>
//            <local_delivery_cost>300</local_delivery_cost>
//            <typePrefix> Принтер </typePrefix>
//            <vendor> НP </vendor>
//            <vendorCode> Q7533A </vendorCode>
//            <model> Color LaserJet 3000</model>
//            <description>
//                A4, 64Mb, 600x600 dpi, USB 2.0, 29стр/мин ч/б / 15стр/мин цв, лотки на 100л и 250л, плотность до 175г/м, до 60000 стр/месяц
//            </description>
//            <manufacturer_warranty>true</manufacturer_warranty>
//            <country_of_origin>Япония</country_of_origin>
//        </offer>
$query = "SELECT DISTINCT
                p.product_id AS id,
                pdesc.product AS name,
                pdesc.full_description AS descript
		FROM cscart_products AS p
			LEFT JOIN cscart_product_features_values AS pfval
			ON p.product_id = pfval.product_id
			LEFT JOIN cscart_product_descriptions AS pdesc
            		ON p.product_id=pdesc.product_id
                        LEFT JOIN cscart_product_prices AS prices
                        ON p.product_id = prices.product_id
		WHERE pdesc.lang_code='RU' AND p.status='A' AND p.amount > 0 AND prices.price > 0";
$products = db_get_array($query, USERGROUP_ALL);

foreach ($products as $product) {

        $offer = 'offer id="'.$product['id'].'" available="true"';
        fwrite($f, chr(9).chr(9).'<'.$offer.'>'.chr(10));
//        // пишем ссылку на страницу.
        fwrite($f, chr(9).chr(9).chr(9).'<url>' . fn_url(htmlentities('products.view?product_id=' . $product["id"])).'</url>'.chr(10));
        // вытаскиваем цену товара
        $query = "SELECT price FROM
                      cscart_product_prices
                      WHERE product_id=".$product['id']." AND usergroup_id=0";
		$line1 = db_get_row($query);
        $i = intval($line1['price']);
        fwrite($f, chr(9).chr(9).chr(9).'<price>'.$i.'</price>'.chr(10));
        // здесь ставится валюта цены. в данном случае рубли
	$query = "SELECT currency_code AS currency FROM cscart_currencies WHERE is_primary='Y'";
	$line1 = db_get_row($query);
        fwrite($f, chr(9).chr(9).chr(9).'<currencyId>'.$line1['currency'].'</currencyId>'.chr(10));
        // список категорий для маркета именовали через ID категорий, и теперь получаем
        // ID категории конкретного товара
        $query = "SELECT category_id FROM
                    cscart_products_categories WHERE product_id=".$product['id']." AND link_type='M' ORDER BY category_id";
        $result1 = db_get_array($query);
        if (count($result1)>0)
		$line1 = db_get_row($query);
        fwrite($f, chr(9).chr(9).chr(9).'<categoryId>'.$line1['category_id'].'</categoryId>'.chr(10));
        // изображения.
        $img = fn_get_image_pairs($product["id"], "product", "M", false, true);
        fwrite($f, chr(9).chr(9).chr(9).'<picture>' . $img["detailed"]["http_image_path"] . '</picture>'.chr(10));

        fwrite($f, chr(9).chr(9).chr(9).'<delivery>true</delivery>'.chr(10));
	$query = "SELECT 
		p.product_id AS id,
                pfvdesc.variant AS vendor
	FROM cscart_products AS p
                LEFT JOIN cscart_product_features_values AS pfval
                ON pfval.product_id = p.product_id
                LEFT JOIN cscart_product_feature_variant_descriptions AS pfvdesc
                ON pfvdesc.variant_id = pfval.variant_id
                LEFT JOIN cscart_product_features_descriptions AS pfdesc
                ON pfdesc.feature_id = pfval.feature_id 
	WHERE p.product_id =".$product['id']." AND pfval.feature_id AND 
		(pfdesc.description LIKE 'brand' OR 
		pfdesc.description LIKE 'vendor' OR
		pfdesc.description LIKE 'бренд' OR
		pfdesc.description LIKE 'брэнд' OR
		pfdesc.description LIKE 'производитель' OR
		pfdesc.description LIKE 'торговая марка' OR
		pfdesc.description LIKE 'вендор')";

	$line = db_get_row($query);
        fwrite($f, chr(9).chr(9).chr(9).'<vendor>'.$line['vendor'].'</vendor>'.chr(10));
        // описание получаем из  короткого описания товара
        fwrite($f, chr(9).chr(9).chr(9).'<name> '.check_xml($product["name"]).'</name>'.chr(10));
        // описание
        fwrite($f, chr(9).chr(9).chr(9).'<description>'.chr(10));
        fwrite($f, chr(9).chr(9).chr(9).chr(9).check_xml(strip_tags($product["descript"])).chr(10));
        fwrite($f, chr(9).chr(9).chr(9).'</description>'.chr(10));



        fwrite($f, chr(9).'</offer>'.chr(10));
}

/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
fwrite($f, chr(9).'</offers>'.chr(10));
/*============================================================================*/
fwrite($f, '</shop>'.chr(10));
fwrite($f, '</yml_catalog>'.chr(10));
fclose($f);

	readfile($filename);
	exit();
}
