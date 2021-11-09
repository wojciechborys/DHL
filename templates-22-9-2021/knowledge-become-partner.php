<?php

/**
 * Template name: Zostań Partnerem
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>


<?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/knowledge/header-new'); ?>
    <?php get_template_part('templates/knowledge/section-our-partners'); ?>
    <?php get_template_part('templates/knowledge/section-form'); ?>
    <?php get_template_part('templates/knowledge/questions-service-point'); ?>
    <?php get_template_part('templates/knowledge/prefooter'); ?>
<?php endwhile; ?>