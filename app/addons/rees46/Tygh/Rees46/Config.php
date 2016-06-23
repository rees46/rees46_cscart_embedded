<?php

namespace Tygh\Rees46;

use Tygh\Registry;

class Config
{
    public static function getShopID()
    {
        return Registry::get('addons.rees46.shop_id');
    }

    public static function getShopSecret()
    {
        return Registry::get('addons.rees46.shop_secret');
    }
    public static function getModification()
    {
        return Registry::get('addons.rees46.modification');
    }
}
