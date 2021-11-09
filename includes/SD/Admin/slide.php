<?php
namespace SD\Admin\Slide;

/**
 * Metaboks ustawień slajdu.
 */
function metaBox() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_sd_';

    $cmb = \new_cmb2_box([
        'id'            => 'slider_settings',
        'title'         => 'Ustawienia slajdu',
        'object_types'  => ['wideo'], // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ]);

    # film / obraz
    $cmb->add_field([
    	'name'             => 'Typ slajdu',
        'desc'             => 'Określ typ slajdu.',
    	'id'               => $prefix.'slide_type',
    	'type'             => 'radio',
    	'show_option_none' => false,
    	'options'          => [
    		'yt_video' => 'Wideo YouTube',
    		'image'    => 'Obraz',
    	],
        'default'          => 'yt_video',
    ]);

    $cmb->add_field([
        'name'         => 'Identyfikator filmu',
        'desc'         => 'Identyfikator wideo w YouTube (np. 7bEDG9P74Mo).',
        'before_field' => 'https://www.youtube.com/watch/?v=',
        'id'           => $prefix.'video_source',
        'type'         => 'text',
    ]);

    $cmb->add_field([
    	'name'         => 'Obraz',
    	'desc'         => 'Obraz do slajdu.',
    	'id'           => $prefix.'slide_image',
    	'type'         => 'file',
    	'text'         => [
    		'add_upload_file_text' => 'Dodaj plik' // Change upload button text. Default: "Add or Upload File"
    	],
    	'query_args' => [
    		'type' => [
    			'image/gif',
    			'image/jpeg',
    			'image/png',
    		],
    	],
    	'preview_size' => 'large', // Image size to use when previewing in the admin.
    ]);

    # przycisk
    $cmb->add_field([
        'name'    => 'Przycisk: Tekst',
        'id'      => $prefix.'button_text',
        'default' => 'Zacznij swoją podróż z DHL Express.',
        'type'    => 'text',
    ]);

    $cmb->add_field([
    	'name'             => 'Przycisk: Cel',
        'desc'             => 'Określ, dokąd ma prowadzić kliknięcie w przycisk na slajderze.',
    	'id'               => $prefix.'button_target',
    	'type'             => 'radio',
    	'show_option_none' => false,
    	'options'          => [
            'url'     => '(Zewnętrzny) URL',
    		'section' => 'Sekcja na stronie głównej',
    	],
        'default'          => 'section',
    ]);

    $cmb->add_field([
        'name' => 'Przycisk: URL',
        'id'   => $prefix.'button_url',
        'type' => 'text_url',
    ]);

    $cmb->add_field([
        'name'             => 'Sekcja strony głównej',
        'desc'             => 'Wybierz sekcję na stronie głównej, do której ma linkować przycisk',
        'id'               => $prefix.'button_section',
        'type'             => 'select',
        'show_option_none' => true,
        'default'          => '',
        'options'          => [
            'videos'     => 'Wideo',
            'positions'  => 'Oferty pracy',
            'discover'   => 'Aktualności / Poznaj DHL Express',
            'prizes'     => 'Nagrody',
        ],
    ]);
}
\add_action('cmb2_admin_init',  __NAMESPACE__ . '\\metaBox');
