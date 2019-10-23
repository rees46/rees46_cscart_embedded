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
        return Registry::get('addons.rees46.instant_search');
    }
    public static function getModification()
    {
        return Registry::get('addons.rees46.modification');
    }
}
