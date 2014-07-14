<?php

namespace Rees46\CSCart;

use Tygh\Registry;

class Config
{
    public static function getShopID()
    {
        return Registry::get('addons.rees46.shop_id');
    }
}
