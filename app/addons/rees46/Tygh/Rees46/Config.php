<?php

namespace Tygh\Rees46;

use Tygh\Registry;

class Config
{
    public static function getShopID()
    {
        return trim(Registry::get('addons.rees46.shop_id'));
    }

    public static function getShopSecret()
    {
        return trim(Registry::get('addons.rees46.shop_secret'));
    }
    public static function getInstantSearch()
    {
        $value = Registry::get('addons.rees46.instant_search');
        return $value == "Y" ? true : false;
    }
    public static function getOrderSync()
    {
        $value = Registry::get('addons.rees46.auto_order_sync');
        return $value == "Y" ? true : false;
    }
    public static function getModification()
    {
        return Registry::get('addons.rees46.modification');
    }
}
