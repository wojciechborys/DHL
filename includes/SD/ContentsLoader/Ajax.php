<?php

namespace SD\ContentsLoader;

use SD\SimpleRating;
use SD\Template\Tags;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Ajax {

    public function loadAction() {
        global $post;

        $paged = \filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);

        $args = [
            'post_type' => 'post',
            'category_name' => 'posty-swiat',
            'paged' => $paged
        ];

        // tagi w formacie 123,35,6754,22
        $tags = \filter_input(
            INPUT_POST,
            'tags',
            FILTER_VALIDATE_REGEXP,
            [
                "options" => [
                    "regexp"=>"/^[1-9]{1}[0-9]*(,[1-9]{1}[0-9]*)*$/"
                ]
            ]
        );

        if($tags) {
            $args['tag__in'] = explode(',', $tags);
        }

        $search = \filter_input(INPUT_POST, 'search');

        if (null !== $search) {
            $args['s'] = $search;
        }

        $customQuery = new \WP_Query( $args );

        $allPages = $customQuery->max_num_pages;

        if ($customQuery->have_posts()) {

            $data = [
                'status' => 'success',
                'posts' => [],
                'next' => $allPages>$paged ? 1 : 0
            ];

            while ($customQuery->have_posts()) {
                $customQuery->the_post();

                $post = $customQuery->post;
                \setup_postdata($customQuery->post);

                \ob_start();

                \get_template_part('templates/world/article-box');

                $article = \ob_get_clean();

                $data['posts'][] = $article;
            }

            /* Restore original Post Data */
            \wp_reset_postdata();
        } else {
            // no posts found

            $data = [
                'status' => 'success',
                'message' => 'Brak artykułów',
                'next' => 0,
                'posts' => []
            ];
        }

        \wp_send_json($data);
    }


    public function __construct() {
        \add_action('wp_ajax_load_action', array($this, 'loadAction'));
        \add_action('wp_ajax_nopriv_load_action', array($this, 'loadAction'));
    }
}
