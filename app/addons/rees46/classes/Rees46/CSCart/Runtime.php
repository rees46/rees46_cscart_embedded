<?php

namespace Rees46\CSCart;

class Runtime
{
    public static function getUserID()
    {
        $auth = $_SESSION['auth'];

        if (empty($auth['user_id'])) {
            return 'null';
        }

        return intval($auth['user_id']);
    }
}
