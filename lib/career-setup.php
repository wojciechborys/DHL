<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;
use Roots\Sage\Setup;

/**
 * Theme assets
 */
function assets() {
    wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css', 'asset-sources/dhlcareer/dist'), false, null);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js', 'asset-sources/dhlcareer/dist'), ['jquery'], null, true);
    wp_localize_script('sage/js', 'dhlConfig', ['ajaxUrl' => \admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);