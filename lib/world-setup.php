<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;
use Roots\Sage\Setup;

/**
 * Theme assets
 */
function assets() {
    wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css', 'asset-sources/dhlworld/dist'), false, null);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    $ajax_url = \admin_url( 'admin-ajax.php' );


    wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js', 'asset-sources/dhlworld/dist'), ['jquery'], null, true);
    \wp_localize_script( 'sage/js', 'sd_config', array(
        'ajax_url' => $ajax_url
    ));

    wp_enqueue_script('owl.carousel', Assets\asset_path('scripts/owl.carousel.js', 'asset-sources/dhlworld/dist'), ['jquery'], null, true);

}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

/**
 * Add <body> classes
 */
function body_class($classes) {
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    // Add class if sidebar is active
    if (Setup\display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

add_action('wp_footer', function() {
    echo '<div class="sd-sticky-button d-none d-sm-block"><a rel=”nofollow” href="https://dhlexpress.pl/"> <img src="'.get_template_directory_uri().'/asset-sources/dhlworld/dist/images/contact-icon.png" alt="Kontakt" /> Kontakt z Międzynarodowymi Specjalistami</a></div>';
});