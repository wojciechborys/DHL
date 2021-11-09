<?php

use MintMedia\PolylangT9n\Polylang;

add_action('wp_ajax_filter_posts', 'filter_posts'); //
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

function filter_posts()
{
    $frist_page = get_pagenum_link(1);

    $term_id = esc_sql($_POST['term_id']);
    $category = esc_sql($_POST['category']);
    // $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'post_type' => 'knowledge',
        'tax_query' => array(
            array(
                'taxonomy' => 'knowledge_category',
                'field' => 'term_id',
                'terms' => $term_id,
                'include_children' => true,
                'operator' => 'IN'
            ),
        ),
        // 'paged' => $paged
    );

    $output = '';
    //$posts_category = new WP_Query($args);
    query_posts($args);
    if (have_posts()) {

        while (have_posts()) {
            the_post();

            if ($category == 'documents') {
                $output .= return_get_template_part('templates/knowledge/documents-box');
            } else if ($category == 'faqs') {
                $output .= return_get_template_part('templates/knowledge/faq-box');
            } else {
                $output .= return_get_template_part('templates/knowledge/article-box');
            }
        }
        $output .= paginator($frist_page);
    } else {
        $output .= '<p class="text-center">' . Polylang\t9n('Brak postów') . '</p>';
    }
    wp_send_json_success($output);
}

add_action('wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination');
add_action('wp_ajax_ajax_pagination', 'my_ajax_pagination');

function my_ajax_pagination()
{

    $query_vars = json_decode(stripslashes($_POST['query_vars']), true);

    $query_vars['paged'] = sanitize_text_field($_POST['page']);
    if ($_POST['cat_slug'] != "") {
        $query_vars['knowledge_category'] = sanitize_text_field($_POST['cat_slug']);
    }
    // wp_send_json_success($query_vars);

    $category = esc_sql($_POST['category']);

    $posts = new WP_Query($query_vars);
    $GLOBALS['wp_query'] = $posts;


    if (!$posts->have_posts()) {
        echo '<p class="text-center">' . Polylang\t9n('Brak postów') . '</p>';
    } else {
        while ($posts->have_posts()) {
            $posts->the_post();
            if ($category == 'documents') {
                get_template_part('templates/knowledge/documents-box');
            } else if ($category == 'faqs') {
                get_template_part('templates/knowledge/faq-box');
            } else {
                get_template_part('templates/knowledge/article-box');
            }
        }
        echo paginator(get_pagenum_link());
    }
    ///return;
    die();
}

add_action('wp_ajax_nopriv_ajax_pagination_media', 'my_ajax_pagination_media');
add_action('wp_ajax_ajax_pagination_media', 'my_ajax_pagination_media');

function my_ajax_pagination_media()
{


    $paged = sanitize_text_field($_POST['page']);
    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => 5,
        'post_type' => 'mediaabout',
        'paged' => $paged
    );
    $args_paginate = array(
        'prev_text' => __('<'),
        'next_text' => __('>')
    );

    $the_query = new WP_Query($args);

    global $wp_query;
    // Put default query object in a temp variable
    $tmp_query = $wp_query;
    // Now wipe it out completely
    $wp_query = null;
    // Re-populate the global with our custom query
    $wp_query = $the_query;

    if (!$the_query->have_posts()) {
        echo '<p class="text-center">' . Polylang\t9n('Brak postów') . '</p>';
    } else {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            get_template_part('templates/knowledge/media-box');
        }
        echo paginator(get_pagenum_link());
    }
    ///return;
    die();
}


function search_more_posts()
{

    $post_id = sanitize_text_field($_POST['post_id']);
    $category = sanitize_text_field($_POST['category']);
    $offset = sanitize_text_field($_POST['offset']);
    $search = sanitize_text_field($_POST['search']);
    $new_offset = (int)($offset + 6);


    $tax = get_field($category, $post_id);


    $posts = get_posts_by_tax($tax, $search, $offset);

    $output = '';
    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            if ($category == 'categories__documents') {
                $output .= return_get_template_part('templates/knowledge/documents-box');
            } else if ($category == 'categories__faq') {
                $output .= return_get_template_part('templates/knowledge/faq-box');
            } else {
                $output .= return_get_template_part('templates/knowledge/article-box');
            }
        }
        wp_reset_postdata();
        if ($posts->found_posts > $new_offset) {
            $output .= '<div class="button_container m-4 text-center" style = "width: 100%;">
                         <button id="' . $category . '" data-search="' . $search . '" data-id="' . $post_id . '" data-offset="' . $new_offset . '"
                            class="btn btn--auto btn--red btn-primary btn--calc d-block d-sm-inline-block js-search-more">' . Polylang\t9n('ZOBACZ WIĘCEJ') . '</button>
                        </div>';
        }
    }

    wp_send_json_success($output);
}
add_action('wp_ajax_nopriv_search_more_posts', 'search_more_posts');
add_action('wp_ajax_search_more_posts', 'search_more_posts');

function more_press_release()
{

    $offset = sanitize_text_field($_POST['offset']);
    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'post_type' => 'pressrelease',
        'offset' => $offset
    );

    $posts = new WP_Query($args);

    $new_offset = (int)($offset + 6);
    $output = '';

    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            $output .= return_get_template_part('templates/knowledge/article-box');
        }
        wp_reset_postdata();
        if ($posts->found_posts > $new_offset) {
            $output .= ' <div id="morePressReleaseButton" class="col-12 row d-flex align-items-center justify-content-center">
               <button  data-offset="' . $new_offset . '" class="mt-4 btn btn--auto btn--red btn-primary btn--calc text-uppercase col-8 col-md-3 js-more-press-release">
                  ' . Polylang\t9n('WIĘCEJ') . '
               </button>
           </div>';
        }
    }

    wp_send_json_success($output);
}

add_action('wp_ajax_nopriv_more_press_release', 'more_press_release');
add_action('wp_ajax_more_press_release', 'more_press_release');