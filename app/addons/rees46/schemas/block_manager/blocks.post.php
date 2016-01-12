<?php

$schema['rees46'] = array(
	'templates' => array(
		'addons/rees46/blocks/recommenders.tpl'                 => array(),
	),
	'settings'  => array(
		'rees46_items_count'      => array(
			'type'          => 'input',
			'default_value' => 4,
		),
		'rees46_recommender_type' => array(
			'type'          => 'selectbox',
			'values'        => array(
				'similar'         => 'rees46_similar',
				'popular'         => 'rees46_popular',
				'recently_viewed' => 'rees46_recently_viewed',
				'interesting'     => 'rees46_interesting',
				'also_bought'     => 'rees46_also_bought',
				'see_also'        => 'rees46_see_also',
				'buying_now'	  => 'rees46_buying_now',
			),
			'default_value' => 'recently_viewed'
		),
		'rees46_recommender_title' => array(
			'type' => 'input'
		),
		'rees46_recommender_orientation' => array(
			'type'          => 'selectbox',
			'values'        => array(
				'horizontal' 	=> 'rees46_orientation_horizontal',
				'vertical'	=> 'rees46_orientation_vertical',
			),
			'default_value' => 'horizontal'
		),
	),
	'cache' => false,
);

return $schema;
