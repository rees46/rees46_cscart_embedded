<?php

namespace Rees46\CSCart;

class Init
{
    public static function getGlobal()
    {
        return array(
            'shop_id' => Config::getShopID()
        );
    }
}
