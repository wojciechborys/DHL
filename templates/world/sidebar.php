<?php

if (is_single()) {
    dynamic_sidebar('sidebar-primary');
} else {
    $custom_query = new WP_Query( 'posts_per_page=-1&category_name=posty-swiat' );
    if ( $custom_query->have_posts() ) :
        while ( $custom_query->have_posts() ) : $custom_query->the_post();
            $posttags = get_the_tags();
            if ( $posttags ) {
                foreach( $posttags as $tag ) {
                    $all_tags[] = $tag->term_id;
                }
            }
        endwhile;
        $tags_arr = array_unique( $all_tags );
        $tags_str = implode( ",", $tags_arr );

        $args = array(
            'smallest' => 10,
            'largest' => 22,
            'unit' => 'px',
            'number' => 15,
            'orderby' => 'name',
            'order' => 'ASC',
            'taxonomy' => 'post_tag',
            'include'   => $tags_str
        );
        wp_tag_cloud( $args );
    endif;
}

if (is_tag('e-commerce') || (is_single() && has_tag('e-commerce'))) {
    dynamic_sidebar('sidebar-banner');
}