<?php

/**
 * Template name: Go green page
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
    <?php get_template_part('templates/knowledge/go-green/section1'); ?>
    <?php get_template_part('templates/knowledge/go-green/section2'); ?>
    <?php get_template_part('templates/knowledge/go-green/section3'); ?>
    <?php get_template_part('templates/knowledge/go-green/section4'); ?>
    <?php get_template_part('templates/knowledge/go-green/section5'); ?>
    <?php get_template_part('templates/knowledge/go-green/section6'); ?>
    <?php get_template_part('templates/knowledge/go-green/section7'); ?>
    <?php get_template_part('templates/knowledge/go-green/section8'); ?>
<?php endwhile; ?>


