<?php

/**
 * Template name: Page New Home
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('templates/knowledge/header-slider'); ?>
    <?php get_template_part('templates/knowledge/section-tiled'); ?>
    <?php get_template_part('templates/knowledge/section-cta-button'); ?>
    <?php get_template_part('templates/knowledge/section-steps'); ?>
    <?php get_template_part('templates/knowledge/section-news'); ?>
    <?php get_template_part('templates/knowledge/prefooter'); ?>

<?php endwhile; ?>