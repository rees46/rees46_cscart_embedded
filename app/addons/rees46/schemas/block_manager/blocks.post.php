<?php

$schema['rees46'] = array(
	'templates' => array(
		'addons/rees46/blocks/recommenders/similar.tpl'         => array(),
		'addons/rees46/blocks/recommenders/popular.tpl'         => array(),
		'addons/rees46/blocks/recommenders/recently_viewed.tpl' => array(),
		'addons/rees46/blocks/recommenders/interesting.tpl'     => array(),
		'addons/rees46/blocks/recommenders/also_bought.tpl'     => array(),
		'addons/rees46/blocks/recommenders/see_also.tpl'        => array(),
		'addons/rees46/blocks/recommenders.tpl'        => array(
			'settings' => array(
				'rees46_items_count_blocks' => array(
					'type' => 'input',
					'default_value' => 4,
				)
			)
		),
	),
	'wrappers' => 'blocks/wrappers',
);

return $schema;
