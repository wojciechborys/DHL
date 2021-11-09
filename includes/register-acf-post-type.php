<?php
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'countries',
        'title' => 'Państwa',
        'fields' => array (
            array (
                'key' => 'countries',
                'label' => 'Państwa',
                'name' => 'countries',
                'type' => 'text',
            )
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
    ));

endif;
