<?php
namespace MintMedia\Dhl\Tags;

function excerpt ($post = null) {
    $excerpt = \get_the_excerpt($post);
    $excerpt = \wptexturize($excerpt);
//    $excerpt = \convert_smilies($excerpt);
    $excerpt = \convert_chars($excerpt);
//    $excerpt = \wpautop($excerpt);
    $excerpt = \shortcode_unautop($excerpt);
//    $excerpt = \wp_trim_excerpt($excerpt);

    echo $excerpt;
}
