<?php

namespace Tygh\Rees46;

class Events
{
    public static function CookieEvent($type, $data)
    {
        switch ($type) {
            case 'order':
                $cookie_name = 'rees46_track_purchase';
                break;
            default:
                throw new \Exception('Unknown type');
        }

        setcookie($cookie_name, json_encode($data), strtotime('+1 hour'), '/');
    }
}
