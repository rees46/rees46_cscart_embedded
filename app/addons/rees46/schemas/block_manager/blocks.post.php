<?php

use Tygh\Registry;

$schema['rees46'] = array(
	'templates' => array(
		'addons/rees46/blocks/recommenders/similar.tpl'         => array(),
		'addons/rees46/blocks/recommenders/popular.tpl'         => array(),
		'addons/rees46/blocks/recommenders/recently_viewed.tpl' => array(),
		'addons/rees46/blocks/recommenders/interesting.tpl'     => array(),
		'addons/rees46/blocks/recommenders/also_bought.tpl'     => array(),
		'addons/rees46/blocks/recommenders/see_also.tpl'        => array(),
	),
	'settings'  => array(
		'rees46_items_count' => array(
			'type' => 'input',
			'default_value' => 4,
		)
	)
);

return $schema;
