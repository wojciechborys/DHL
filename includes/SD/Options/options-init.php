<?php
namespace SD\Options\Init;

use SD\Options\OptionsHelper;

/**
 * Rejestruje stronę opcji ogólnych.
 */
function registerGeneralOptions() {
    $optionsHelper = OptionsHelper::getInstance();

	$options = new_cmb2_box([
		'id'              => OptionsHelper::prefix('theme-options-page'),
		'title'           => 'Ustawienia motywu',
		'object_types'    => ['options-page'],
		'option_key'      => OptionsHelper::prefix('general'), // The option key and admin menu page slug.
		'icon_url'        => 'dashicons-hammer', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => 'Opcje motywu', // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	]);

    $options->add_field([
        'name'        => 'Logo w headerze',
        'description' => 'Logo &ndash; w założeniu należące do Top Employers Institure &ndash; wyświetlane w headerze.',
        'id'          => 'header_logo',
        'default'     => $optionsHelper->defaultVal('general::header_logo'),
        'type'        => 'file',
        'query_args' => [
    	    'type' => [
    	        'image/jpeg',
    	        'image/png',
    	    ],
        ],
        'preview_size' => 'small'
    ]);
}
\add_action('cmb2_admin_init', __NAMESPACE__.'\\registerGeneralOptions');

/**
 * Rejestruje stronę opcji wideo.
 */
function registerVideoOptions() {
    $optionsHelper = OptionsHelper::getInstance();

    $options = new_cmb2_box([
		'id'              => OptionsHelper::prefix('videos-options-page'),
		'title'           => 'Strona główna: Sekcja wideo',
		'object_types'    => ['options-page'],
		'option_key'      => OptionsHelper::prefix('videos'), // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-hammer', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => '<abbr title="Strona główna">SG:</abbr> Wideo', // Falls back to 'title' (above).
		'parent_slug'     => OptionsHelper::prefix('general'), // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	]);

    $groupId = 'videos';

    $options->add_field([
        'name'       => 'Wideo',
        'type'       => 'group',
        'id'         => $groupId,
        // 'repeatable' => false,
        'options' => [
            'group_title'   => 'Wideo {#}.',
            'add_button'    => 'Dodaj kolejne wideo',
            'remove_button' => 'Usuń wideo z listy',
            'sortable'      => true,
        ],
    ]);

    $options->add_group_field($groupId, [
        'name'        => 'URL',
        'description' => 'Adres URL filmu (WAŻNE: link, nie kod do osadzania).',
        'id'          => 'url',
        'type'        => 'text_url',
    ]);

    $options->add_group_field($groupId, [
        'name'        => 'Miniatura filmu',
        'description' => 'Obraz wyświetlany jako miniatura filmu.',
        'id'          => 'image',
        'type'        => 'file',
        'query_args' => [
		    'type' => [
		        'image/gif',
		        'image/jpeg',
		        'image/png',
		    ],
        ],
	    'preview_size' => 'medium'
    ]);

    $options->add_group_field($groupId, [
        'name'        => 'Tytuł filmu',
        'description' => 'Tytuł wyświetlany pod filmem.',
        'id'          => 'title',
        'type'        => 'text',
    ]);

    $options->add_group_field($groupId, [
        'name'        => 'Opis filmu',
        'description' => 'Tekst wyświetlany pod tytułem filmu.',
        'id'          => 'desc',
        'type'        => 'wysiwyg',
        'options'     => [
            'media_buttons' => false,
            'textarea_rows' => 4
        ]
    ]);

}
\add_action('cmb2_admin_init', __NAMESPACE__.'\\registerVideoOptions');

/**
 * Rejestruje stronę opcji ofert.
 */
function registerCustomContentOptions() {
    $optionsHelper = OptionsHelper::getInstance();

    $options = new_cmb2_box([
		'id'              => OptionsHelper::prefix('custom-content-options-page'),
		'title'           => 'Strona główna: Własna treść',
		'object_types'    => ['options-page'],
		'option_key'      => OptionsHelper::prefix('custom_content'), // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-hammer', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => '<abbr title="Strona główna">SG:</abbr> Własna treść', // Falls back to 'title' (above).
		'parent_slug'     => OptionsHelper::prefix('general'), // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	]);

    $options->add_field([
        'name'    => 'Tytuł',
        'default' => $optionsHelper->defaultVal('custom_content::title'),
        'id'      => 'title',
        'type'    => 'text'
    ]);

    $options->add_field([
        'name'        => 'Treść',
        'default'     => $optionsHelper->defaultVal('custom_content::content'),
        'id'          => 'content',
        'type'        => 'wysiwyg',
        'repeatable'  => false,
        'options'     => [
            'media_buttons' => false,
            'textarea_rows' => 8
        ]
    ]);

    $options->add_field([
        'name'    => 'Tekst przycisku',
        'default' => $optionsHelper->defaultVal('custom_content::button_text'),
        'id'      => 'button_text',
        'type'    => 'text'
    ]);

    $options->add_field([
        'name'    => 'URL przycisku',
        'default' => $optionsHelper->defaultVal('custom_content::button_url'),
        'id'      => 'button_url',
        'type'    => 'text_url'
    ]);

}
\add_action('cmb2_admin_init', __NAMESPACE__.'\\registerCustomContentOptions');

/**
 * Rejestruje stronę opcji ofert.
 */
function registerOffersOptions() {
    $optionsHelper = OptionsHelper::getInstance();

    $options = new_cmb2_box([
		'id'              => OptionsHelper::prefix('offers-options-page'),
		'title'           => 'Strona główna: Sekcja ofert',
		'object_types'    => ['options-page'],
		'option_key'      => OptionsHelper::prefix('offers'), // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-hammer', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => '<abbr title="Strona główna">SG:</abbr> Oferty', // Falls back to 'title' (above).
		'parent_slug'     => OptionsHelper::prefix('general'), // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	]);

    // $options->add_field([
    //     'name'    => 'Strona z ofertami',
    //     'default' => $optionsHelper->defaultVal('offers::offers_page'),
    //     'id'      => 'offers1_text',
    //     'type'    => 'text'
    // ]);

    $options->add_field([
        'name'           => 'Sekcja 1.: kategoria ofert',
        'description'    => 'Wybierz kategorię ofert do wyświetlenia w sekcji. Jeśli nie wybierzesz żadnej, sekcja nie zostanie wyświetlona.',
        'default'        => $optionsHelper->defaultVal('offers::offers1_slug'),
        'id'             => 'offers1_slug',
        'taxonomy'       => 'offercategory',
        'type'           => 'taxonomy_select',
        'remove_default' => true
    ]);

    $options->add_field([
        'name'    => 'Sekcja 1.: tytuł',
        'default' => $optionsHelper->defaultVal('offers::offers1_title'),
        'id'      => 'offers1_title',
        'type'    => 'text'
    ]);

    $options->add_field([
        'name'        => 'Sekcja 1.: identyfikator filmu',
        'description' => 'Identyfikator wideo w YouTube (np. 7bEDG9P74Mo).',
        'id'          => 'offers1_videoid',
        'default'     => '',
        'before_field' => 'https://www.youtube.com/watch/?v=',
        'type'        => 'text'
    ]);

    $options->add_field([
        'name'        => 'Sekcja 1.: opis',
        'default'     => $optionsHelper->defaultVal('offers::offers1_text'),
        'id'          => 'offers1_text',
        'type'        => 'wysiwyg',
        'repeatable'  => false,
        'options'     => [
            'media_buttons' => false,
            'textarea_rows' => 6
        ]
    ]);

    $options->add_field([
        'name'           => 'Sekcja 2.: kategoria ofert',
        'description'    => 'Wybierz kategorię ofert do wyświetlenia w sekcji. Jeśli nie wybierzesz żadnej, sekcja nie zostanie wyświetlona.',
        'default'        => $optionsHelper->defaultVal('offers::offers2_slug'),
        'id'             => 'offers2_slug',
        'taxonomy'       => 'offercategory', // Enter Taxonomy Slug
        'type'           => 'taxonomy_select',
        'remove_default' => true
    ]);

    $options->add_field([
        'name'    => 'Sekcja 2.: tytuł',
        'default' => $optionsHelper->defaultVal('offers::offers2_title'),
        'id'      => 'offers2_title',
        'type'    => 'text'
    ]);

    $options->add_field([
        'name'        => 'Sekcja 2.: identyfikator filmu',
        'description' => 'Identyfikator wideo w YouTube (np. 7bEDG9P74Mo).',
        'id'          => 'offers2_videoid',
        'default'     => '',
        'before_field' => 'https://www.youtube.com/watch/?v=',
        'type'        => 'text'
    ]);

    $options->add_field([
        'name'        => 'Sekcja 2.: opis',
        'default'     => $optionsHelper->defaultVal('offers::offers2_text'),
        'id'          => 'offers2_text',
        'type'        => 'wysiwyg',
        'repeatable'  => false,
        'options'     => [
            'media_buttons' => false,
            'textarea_rows' => 6
        ]
    ]);

    $options->add_field([
        'name'           => 'Sekcja 3.: kategoria ofert',
        'description'    => 'Wybierz kategorię ofert do wyświetlenia w sekcji. Jeśli nie wybierzesz żadnej, sekcja nie zostanie wyświetlona.',
        'default'        => $optionsHelper->defaultVal('offers::offers3_slug'),
        'id'             => 'offers3_slug',
        'taxonomy'       => 'offercategory', // Enter Taxonomy Slug
        'type'           => 'taxonomy_select',
        'remove_default' => true
    ]);

    $options->add_field([
        'name'    => 'Sekcja 3.: tytuł',
        'default' => $optionsHelper->defaultVal('offers::offers3_title'),
        'id'      => 'offers3_title',
        'type'    => 'text'
    ]);

    $options->add_field([
        'name'        => 'Sekcja 3.: identyfikator filmu',
        'description' => 'Identyfikator wideo w YouTube (np. 7bEDG9P74Mo).',
        'id'          => 'offers3_videoid',
        'default'     => '',
        'before_field' => 'https://www.youtube.com/watch/?v=',
        'type'        => 'text'
    ]);

    $options->add_field([
        'name'        => 'Sekcja 3.: opis',
        'default'     => $optionsHelper->defaultVal('offers::offers3_text'),
        'id'          => 'offers3_text',
        'type'        => 'wysiwyg',
        'repeatable'  => false,
        'options'     => [
            'media_buttons' => false,
            'textarea_rows' => 6
        ]
    ]);

}
\add_action('cmb2_admin_init', __NAMESPACE__.'\\registerOffersOptions');

/**
 * Rejestruje stronę opcji aktualności.
 */
function registerNewsOptions() {
    $optionsHelper = OptionsHelper::getInstance();

	$options = new_cmb2_box([
		'id'              => OptionsHelper::prefix('news-options-page'),
		'title'           => 'Strona główna: Aktualności',
        'object_types'    => ['options-page'],
		'option_key'      => OptionsHelper::prefix('news'), // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-hammer', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => '<abbr title="Strona główna">SG:</abbr> Wideo', // Falls back to 'title' (above).
		'parent_slug'     => OptionsHelper::prefix('general'), // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	]);

    $options->add_field([
        'name'    => 'Tytuł sekcji z aktualnościami',
        'default' => $optionsHelper->defaultVal('front_discover::title'),
        'id'      => 'title',
        'type'    => 'text'
    ]);

    $options->add_field([
        'name'    => 'Treść sekcji z aktualnościami',
        'default' => $optionsHelper->defaultVal('front_discover::text'),
        'id'      => 'text',
        'type'    => 'textarea'
    ]);

}
\add_action('cmb2_admin_init', __NAMESPACE__.'\\registerNewsOptions');

/**
 * Rejestruje stronę opcji nagród i wyróżnień.
 */
function registerPrizesOptions() {
    $optionsHelper = OptionsHelper::getInstance();

    $options = new_cmb2_box([
		'id'              => OptionsHelper::prefix('prizes-options-page'),
		'title'           => 'Strona główna: Sekcja nagród i wyróżnień',
		'object_types'    => ['options-page'],
		'option_key'      => OptionsHelper::prefix('prizes'), // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-hammer', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => '<abbr title="Strona główna">SG:</abbr> Nagrody i wyróżnienia', // Falls back to 'title' (above).
		'parent_slug'     => OptionsHelper::prefix('general'), // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	]);

    $options->add_field([
        'name'    => 'Tytuł sekcji',
        'default' => $optionsHelper->defaultVal('prizes::title'),
        'id'      => 'title',
        'type'    => 'text'
    ]);

    $options->add_field([
        'name'    => 'Opis sekcji',
        'default' => $optionsHelper->defaultVal('prizes::text'),
        'id'      => 'text',
        'type'    => 'textarea'
    ]);

    $groupId = 'prizes';

    $options->add_field([
        'name'    => 'Nagrody',
        'type'    => 'group',
        'id'      => $groupId,
        'options' => [
            'group_title'   => 'Nagroda {#}.',
            'add_button'    => 'Dodaj kolejną nagrodę',
            'remove_button' => 'Usuń nagrodę z listy',
            'sortable'      => true,
        ],
    ]);

    $options->add_group_field($groupId, [
        'name'    => 'Tytuł',
        'name'    => 'Zostanie wstawiony jako atrybut &quot;title&quot; do obrazów.',
        'id'      => 'title',
        'type'    => 'text',
    ]);

    // $options->add_group_field($groupId, [
    //     'name'    => 'Opis',
    //     'id'      => 'text',
    //     'type'    => 'text',
    // ]);

    $options->add_group_field($groupId, [
        'name'    => 'Obraz',
        'id'      => 'image',
        'type'    => 'file',
        'query_args' => [
            'type' => [
                'image/gif',
                'image/jpeg',
                'image/png',
            ],
        ],
        'preview_size' => 'medium',
    ]);

}
\add_action('cmb2_admin_init', __NAMESPACE__.'\\registerPrizesOptions');

/**
 * Rejestruje stronę opcji formularza.
 */
function registerFormOptions() {
    $optionsHelper = OptionsHelper::getInstance();

	$options = new_cmb2_box([
		'id'              => OptionsHelper::prefix('form-options-page'),
		'title'           => 'Strona główna: Ustawienia formularza',
		'object_types'    => ['options-page'],
		'option_key'      => OptionsHelper::prefix('form'), // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-hammer', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => '<abbr title="Strona główna">SG:</abbr> Formularz', // Falls back to 'title' (above).
		'parent_slug'     => OptionsHelper::prefix('general'), // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	]);

	$options->add_field([
        'name'    => 'Tytuł sekcji',
        'default' => $optionsHelper->defaultVal('form::section_title'),
        'id'      => 'section_title',
        'type'    => 'text'
	]);

    $options->add_field([
        'name'    => 'URL formularza',
        'desc'    => 'URL do formularza kontaktowego.',
        'default' => $optionsHelper->defaultVal('form::url'),
        'id'      => 'url',
        'type'    => 'text_url'
    ]);

    $options->add_field([
        'name'    => 'Tekst przycisku',
        'default' => $optionsHelper->defaultVal('form::btn_text'),
        'id'      => 'btn_text',
        'type'    => 'text'
    ]);

}
\add_action('cmb2_admin_init', __NAMESPACE__.'\\registerFormOptions');

/**
 * Rejestruje stronę opcji stopki.
 */
function registerFooterOptions() {
    $optionsHelper = OptionsHelper::getInstance();

	$options = new_cmb2_box([
		'id'              => OptionsHelper::prefix('footer-options-page'),
		'title'           => 'Ustawienia stopki',
		'object_types'    => ['options-page'],
		'option_key'      => OptionsHelper::prefix('footer'), // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-hammer', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => 'Stopka', // Falls back to 'title' (above).
		'parent_slug'     => OptionsHelper::prefix('general'), // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'yourprefix_options_page_message_callback',
	]);

	$options->add_field([
        'name'    => 'Tekst stopki',
        'desc'    => 'Tekst wyświetlany w stopce &ndash; nazwa witryny.',
        'default' => $optionsHelper->defaultVal('footer::text'),
        'id'      => 'text',
        'type'    => 'text'
	]);

	// $options->add_field([
    //     'name'    => 'URL LinkedIn',
    //     'desc'    => 'URL do profilu w portalu LinkedIn.',
    //     'default' => $optionsHelper->defaultVal('footer::linkedin_url'),
    //     'id'      => 'linkedin_url',
    //     'type'    => 'text_url'
	// ]);

    $options->add_field([
        'name'    => 'Prawa autorskie',
        'default' => $optionsHelper->defaultVal('footer::copyrights'),
        'before_field' => \current_time('Y').' &copy; ',
        'id'      => 'footer_copyrights',
        'type'    => 'text'
    ]);

}
\add_action('cmb2_admin_init', __NAMESPACE__.'\\registerFooterOptions');
