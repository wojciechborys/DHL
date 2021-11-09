<?php
//add rest route for airports
add_action('rest_api_init', function () {
    register_rest_route('ecommerce', '/globe', array(
        'methods' => 'GET',
        'callback' => function ($data) {
            $returnData = [];
            $short_airports = htmlspecialchars($data->get_param('airport'), ENT_QUOTES, 'UTF-8');
            $wp_query_args = array(
                'post_type' => 'airports',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'meta_value',
                'meta_query' => array(
                    array(
                        'key' => 'lotnisko_short',
                        'value' => $short_airports,
                        'compare' => '='
                    )
                ));

            $the_query = new WP_Query($wp_query_args);
            $posts = $the_query->posts;
            foreach ($posts as $index => $single) {
//                $returnData[$index]['id'] = $single->ID;
                $returnData[$index]['airport'] = get_field("lotnisko", $single->ID);
                $returnData[$index]['image_url'] = (get_field("img", $single->ID))['url'];
                $returnData[$index]['image_alt'] = (get_field("img", $single->ID))['alt'];
                $returnData[$index]['curiosities'] = get_field("curiosities", $single->ID);
            }
            return ['data' => $returnData, 'get' => $short_airports];
//            return $data->get_param('airport');
        }
    ));
});
