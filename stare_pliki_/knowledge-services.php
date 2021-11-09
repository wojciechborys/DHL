<?php

/**
 * Template name: [Baza wiedzy] Nasze usługi
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

    <?php get_template_part('templates/knowledge/services-header'); ?>
    <?php get_template_part('templates/knowledge/services-transport'); ?>
    <?php get_template_part('templates/knowledge/services-additional'); ?>
    <?php get_template_part('templates/knowledge/services-customs'); ?>

    <?php get_template_part('templates/knowledge/prefooter'); ?>
<?php endwhile; ?>