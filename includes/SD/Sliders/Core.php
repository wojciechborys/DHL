<?php

namespace SD\Sliders;

use SD\Template\Tags;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Core {

    public function getSlides($slug) {

        $slidesData = [];

        $slider = get_term_by( 'slug', $slug, 'slider');
        if(empty($slider->term_id)) {
            return $slidesData;
        }
                        
        $args = array(
            'post_type' => 'slide',
            'tax_query' => array(
                array(
                    'taxonomy' => 'slider',
                    'field' => 'term_id',
                    'terms' => $slider->term_id
                )
            )
        );

        $slides = \get_posts($args);
        
        foreach($slides as $slide) {

            $slideData = [];

            $conectedPostId = (int) get_post_meta($slide->ID, '_connected_post_id', true);
            if (!$conectedPostId) {
                continue;
            }

            $connectedPost = \get_post($conectedPostId);
            
            if(!empty($connectedPost)) {
                $slideData['title'] = $connectedPost->post_title;
                $slideData['permalink'] = \get_permalink($connectedPost);
                $slideData['image'] = Tags\getTopImageSrc($connectedPost);
                $slideData['excerpt'] = \get_the_excerpt($slide->ID);
                $mainTagTerm = Tags\getMainTag($connectedPost);
                $slideData['tag'] = $mainTagTerm instanceof \WP_Term ? $mainTagTerm->name : '';
            }

            if(!empty($slideData)) {
                $slidesData[] = $slideData;
            }
        }
        
        return $slidesData;
    }

    public function init() {
        \register_post_type('slide', array(
            'labels' => array(
                'name' => __('Slajdy'),
                'singular_name' => __('Slajd')
            ),
            'supports' => array(
                'title',
                'excerpt'
            ),
            'public' => true,
            'has_archive' => false,
        ));

        \register_taxonomy(
            'slider',
            'slide',
            array(
                'hierarchical' => true,
                'label' => __( 'Slider' )
            )
        );
        
    }

    public function __construct() {

        \add_action('init', array($this, 'init'));
    }

}
