<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;
use MintMedia\ShipmentCalc\Helpers;
use MintMedia\PolylangT9n\Polylang;
use MintMedia\Dhl\Experiments;

/**
 * Theme setup
 */
function setup() {
    // Enable features from Soil when plugin is activated
    // https://roots.io/plugins/soil/
    add_theme_support('soil-clean-up');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-relative-urls');

    // Make theme available for translation
    // Community translations can be found at https://github.com/roots/sage-translations
    load_theme_textdomain('dhl-theme', get_template_directory() . '/lang');

    // Enable plugins to manage the document title
    // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    add_theme_support('title-tag');

    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus([
        'main_navigation' => __('Main Navigation', 'sage'),
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'career_primary_navigation' => __('Career Navigation', 'sage'),
        'footer_navigation' => __('Career Footer Navigation', 'sage'),
        'subfooter_navigation' => __('Career Sub-footer Navigation', 'sage'),
        'footer_nav_new_first' => __('DHL EXPRESS Footer Navigation First', 'sage'),
        'footer_nav_new_second' => __('DHL EXPRESS Footer Navigation Second', 'sage'),
        'footer_go_green_page' => __('GO GREEN Page Footer PL', 'sage'),
    ]);

    // Enable post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');

    // Enable HTML5 markup support
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    // Use main stylesheet for visual editor
    // To add custom styles edit /assets/styles/layouts/_tinymce.scss
    add_editor_style(Assets\asset_path('styles/main.css'));

    // world
    // Enable post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');

    add_image_size('gallery-image', 374, 206, true);
    add_image_size('small-slide', 360, 240, true);
    add_image_size('intro-post-image', 750, 9999, false);
    add_image_size('top-post-image', 1920, 612, true);
    add_image_size('fp-article', 400, 220, true);
    add_image_size('fp-slider-article', 360, 240, true);
    add_image_size('video-thumbnail', 400, 340, true);

    // Enable post formats
    // http://codex.wordpress.org/Post_Formats
    add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

    // Use main stylesheet for visual editor
    // To add custom styles edit /assets/styles/layouts/_tinymce.scss
//    add_editor_style(Assets\asset_path('styles/main.css'));

    // world end
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Dodaje nazwy własnych rozmiarów obrazów do systemu.
 * @param  array $sizes
 * @return array
 */
function image_size_names_choose($sizes) {
    return \array_merge([
        'gallery-image' => 'Obraz w galerii',
    ], $sizes);
}
add_filter('image_size_names_choose', __NAMESPACE__ . '\\image_size_names_choose');

/**
 * Zmienia ustawienia edytora.
 *
 * @param array  $settings
 * @param string $editor_id
 * @return array
 */
function editor_settings($settings, $editor_id) {
    if ('content' !== $editor_id || 'post' !== \get_post_type()) {
        return $settings;
    }

    $settings['body_class'] .= ' post-single__content';

    return $settings;
}
\add_filter( 'teeny_mce_before_init', __NAMESPACE__ . '\\editor_settings', 10, 2 );
\add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\editor_settings', 10, 2 );

/**
 * Register sidebars
 */
function widgets_init() {

    register_sidebar([
        'name'          => __('Strona główna', 'sage'),
        'id'            => 'sidebar-front',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="header header--size4 header--upper">',
        'after_title'   => '</h3>'
    ]);

    register_sidebar([
        'name'          => __('Pojedynczy wpis - pod treścią', 'sage'),
        'id'            => 'single-post-after',
        'before_widget' => '<section class="widget post-single__after-content %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="header header--size4 header--upper">',
        'after_title'   => '</h3>'
    ]);

    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ]);

    register_sidebar([
        'name'          => __('Stopka Dolna', 'sage'),
        'id'            => 'sidebar-footer',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => ''
    ]);

    register_sidebar([
        'name'          => __('Stopka górna', 'sage'),
        'id'            => 'sidebar-subfooter',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => ''
    ]);

    register_sidebar([
        'name'          => __('Miejsce na banner', 'sage'),
        'id'            => 'sidebar-banner',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => ''
    ]);

    register_sidebar([
        'name'          => __('Career Primary', 'sage'),
        'id'            => 'sidebar-career-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ]);

    register_sidebar([
        'name'          => __('Career Footer', 'sage'),
        'id'            => 'sidebar-career-footer',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ]);

    register_sidebar([
        'name'          => __('Stopka górna Career', 'sage'),
        'id'            => 'sidebar-career-subfooter',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => ''
    ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

function regiserSliderPT() {

    $slug = 'wideo';

    $labels = array(
        'name' => 'Slider',
        'singular_name' => 'Slider',
        'add_new' => 'Dodaj nowy',
        'add_new_item' => 'Dodaj nowy slajd',
        'edit' => 'Edytuj',
        'edit_item' => 'Edytuj slajd',
        'new_item' => 'Nowy slajd',
        'view' => 'Zobacz',
        'view_item' => 'Wyświetl slajd',
        'search_term' => 'Szukaj slajdów',
        'not_found' => 'Nie znaleziono slajdów',
        'not_found_in_trash' => 'Brak slajdów w koszu'
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 10,
        'menu_icon' => 'dashicons-pressthis',
        'can_export' => true,
        'delete_with_user' => false,
        'hierarchical' => false,
        'has_archive' => false,
        'query_var' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        // 'capabilities' => array(),
        'rewrite' => false,
        'supports' => array(
            'title',
            'editor',
            'author',
            // 'thumbnail'
        )
    );

    \register_post_type($slug, $args);
}
\add_action('init', __NAMESPACE__ . '\\regiserSliderPT');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
    static $display;

    isset($display) || $display = !in_array(true, [
        // The sidebar will NOT be displayed if ANY of the following return true.
        // @link https://codex.wordpress.org/Conditional_Tags
        is_404(),
        is_search(),
//    is_front_page(),
        is_page_template('world-template-custom.php'),
    ]);

    return apply_filters('sage/display_sidebar', $display);
}
