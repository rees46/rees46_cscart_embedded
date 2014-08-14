<?php

namespace Tygh\Rees46;

class Events
{
    public static function CookieEvent($type, $data)
    {
        switch ($type) {
            case 'cart':
                $cookie_name = 'rees46_track_cart';
                break;
            case 'remove_from_cart':
                $cookie_name = 'rees46_track_remove_from_cart';
                break;
            case 'order':
                $cookie_name = 'rees46_track_purchase';
                break;
            default:
                throw new \Exception('Unknown type');
        }

        setcookie($cookie_name, json_encode($data), strtotime('+1 hour'), '/');
    }
}
