<?php

/** @var \Composer\Autoload\ClassLoader $autoloader */
$autoloader = require __DIR__ . '/../../lib/vendor/autoload.php';

$autoloader->add('Rees46\\', __DIR__ . '/classes');

//function smarty_template_function_rees46_get_user_id()
//{
//    print \Rees46\CSCart\Runtime::getUserID();
//}
//
//function smarty_template_function_rees46_get_shop_id()
//{
//    print '"'. \Rees46\CSCart\Config::getShopID() . '"';
//}
