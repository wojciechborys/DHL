<?php
/*
 * Template Name: World Post
 * Template Post Type: post, page, product
 */

use MintMedia\Dhl\Templates;

?>
<div class="container">
    <?php
        if (function_exists('yoast_breadcrumb')) :
        endif;
    ?>

    <?php get_template_part('templates/world/content-single', get_post_type()); ?>
</div>

