<?php

/**
 * Template name: [Baza wiedzy] Home
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>
<?php


?>

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('templates/knowledge/header-new'); ?>
    <?php get_template_part('templates/knowledge/category'); ?>
    <?php get_template_part('templates/knowledge/questions'); ?>
    <?php get_template_part('templates/knowledge/newsletter-form'); ?>
    <?php get_template_part('templates/knowledge/blog-posts-world'); ?>
    <?php get_template_part('templates/knowledge/prefooter'); ?>
    <?php // get_template_part('templates/page', 'header'); ?>
    <?php // get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>