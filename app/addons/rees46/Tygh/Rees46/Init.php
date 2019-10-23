<?php

namespace Tygh\Rees46;

class Init
{
    public static function getGlobal()
    {
        return array(
            'shop_id' => Config::getShopID(),
            'modification' => Config::getModification(),
            'instant_search' => Config::getInstantSearch()
        );
    }
}
