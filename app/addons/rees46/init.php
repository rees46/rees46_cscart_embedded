<?php

/** @var \Composer\Autoload\ClassLoader $autoloader */
$autoloader = require __DIR__ . '/../../lib/vendor/autoload.php';

$autoloader->add('Rees46\\', __DIR__ . '/classes');

require __DIR__ . '/hooks.php';
