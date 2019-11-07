<?php

$schema['rees46'] = array(
    'templates' => array(
        'addons/rees46/blocks/recommenders.tpl'                 => array(),
    ),
    'settings'  => array(
        'rees46_recommender_code' => array(
            'type' => 'input'
        ),
        'rees46_products_per_line' => array(
            'type' => 'input',
            'default_value' => 4
        ),
        'rees46_recommender_orientation' => array(
            'type'          => 'selectbox',
            'values'        => array(
                'horizontal'    => 'rees46_orientation_horizontal',
                'vertical'  => 'rees46_orientation_vertical',
            ),
            'default_value' => 'horizontal'
        ),
    ),
    'cache' => false,
);

return $schema;
