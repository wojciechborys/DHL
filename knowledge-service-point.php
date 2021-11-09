<?php

/**
 * Template name: Service Point
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>

<div class="service-point-page">

    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('templates/knowledge/header-new'); ?>
        <?php get_template_part('templates/knowledge/section-image-text-service'); ?>
        <?php get_template_part('templates/knowledge/section-calculator'); ?>
        <?php get_template_part('templates/knowledge/section-cta-button'); ?>
        <?php get_template_part('templates/knowledge/section-static-content'); ?>
        <?php get_template_part('templates/knowledge/section-title-images-service'); ?>
        <?php get_template_part('templates/knowledge/section-title-text-service'); ?>
        <?php get_template_part('templates/knowledge/section-title-text-brands-service'); ?>
        <?php get_template_part('templates/knowledge/section-city'); ?>
        <?php get_template_part('templates/knowledge/questions-service-point'); ?>
        <!--    --><?php //get_template_part('templates/knowledge/offer-for-firm'); ?>

        <?php get_template_part('templates/knowledge/prefooter'); ?>
    <?php endwhile; ?>

</div>
