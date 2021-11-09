<?php

/**
 * Template name: Page Create Account
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
    <?php
		$title = get_field('tiled_2__title');
		$desc = get_field('tiled_2__description');
	?>
	<section class="blog_category mb-0">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-6 mx-auto">
	                <h1 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3"><?php echo $title; ?></h1>
	                <span class="font__subtitle--0222 text-center d-block mb-5"><?php echo $desc; ?></span>
	            </div>
	        </div>
	    </div>
	</section>
    <?php get_template_part('templates/knowledge/section-carousel-image-text'); ?>
    <?php get_template_part('templates/knowledge/section-iframe'); ?>
    <?php get_template_part('templates/knowledge/section-news'); ?>
    <div class="m-5"></div>
    <?php get_template_part('templates/knowledge/prefooter'); ?>

<?php endwhile; ?>