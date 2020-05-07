<?php

namespace Tygh\Rees46;

class Init
{
    public static function getGlobal()
    {
        return array(
            'shop_id' => Config::getShopID(),
            'instant_search' => Config::getInstantSearch()
        );
    }
}
