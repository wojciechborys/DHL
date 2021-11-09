<?php

namespace Roots\Sage\Extras;


use SD\SimpleRating;
use SD\ContentsLoader;
use SD\Sliders;



/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


// WORLD - removed duplicates in first 2 methods


/**
 * Clean up the_excerpt()
 */
function excerpt_more_world() {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more_world', __NAMESPACE__ . '\\excerpt_more_world');

function main_menu_classes($classes, $item, $args) {
    if ($args->theme_location !== 'primary_navigation') {
        $classes[] = 'mm-nav__item';
    }

    return $classes;
}
add_filter('nav_menu_css_class',__NAMESPACE__ . '\\main_menu_classes',1,3);

function nav_menu_attributes($args) {
    if ($args['theme_location'] !== 'primary_navigation' && $args['theme_location'] !== 'career_primary_navigation') {
        $args['menu_class'] = 'mm-nav';
        $args['container'] = '';
    }

    return $args;
}
add_filter( 'wp_nav_menu_args', __NAMESPACE__ . '\\nav_menu_attributes', 10, 1 );

$ajaxSimpleRatings = new SimpleRating\Ajax();
$ajaxContentsLoader = new ContentsLoader\Ajax();

function tag_cloud_class_active($tagsData) {

    $bodyClasses = get_body_class();

    foreach ($tagsData as $key => $tag) {
        if(in_array('tag-'.$tag['id'], $bodyClasses)) {
            $tagsData[$key]['class'] =  $tagsData[$key]['class'] ." tag-cloud-link--active";
        }
    }
    return $tagsData;
}

add_filter('wp_generate_tag_cloud_data',  __NAMESPACE__ . '\\tag_cloud_class_active');

$slidersCore = new Sliders\Core();
if (is_admin()) {
    $slidersAdmin = new Sliders\Admin();
}

// WORLD end