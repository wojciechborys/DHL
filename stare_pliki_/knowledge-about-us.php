<?php

/**
 * Template name: Page About Us
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;

?>

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('templates/knowledge/header-new'); ?>
    <div class="article article--page">
        <div class="container">
            <?php if (have_rows('layouts')): ?>
                <?php while (have_rows('layouts')) : the_row(); ?>
                    <?php if (get_row_layout() == 'about_us__text'): ?>

                        <?php the_sub_field('text__content'); ?>

                    <?php elseif (get_row_layout() == 'about_us__tiled'): ?>
                        <?php if (have_rows('tiled__repeater')): ?>
                            <div class="row  mb-0 mb-xl-5 pb-xxl-4 article--page--category justify-content-center justify-content-lg-start">
                                <?php while (have_rows('tiled__repeater')) : the_row(); ?>
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <a href="<?php echo esc_url(get_sub_field('link')); ?>"
                                           class="blog_category--item blog_category--item--no-padding text-center text-lg-left blog_category--link">
                                            <div class="blog_category--ico blog_category--ico--article d-flex align-items-center justify-content-center justify-content-lg-start">
                                                <img src="<?php echo esc_url((get_sub_field('image'))['url']); ?>"
                                                     alt="<?php echo (get_sub_field('image'))['alt']; ?>">
                                            </div>
                                            <hr>
                                            <div class="blog_category--name">
                                                <span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase"><?php echo get_sub_field('title'); ?></span>
                                                <span class="font__title--05 text-uppercase font__color--gray"><?php echo get_sub_field('text'); ?></span>
                                            </div>
                                        </a>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    <?php elseif (get_row_layout() == 'about_us__carousel') : ?>
                        <?php $images = get_sub_field('carousel_full__gallery'); ?>
                        <?php if ($images) : ?>
                            <section class="full_carousel">
                                <div class="container--carousel">
                                    <div class="slick slick-slider-fw">
                                        <?php foreach ($images as $image): ?>
                                            <div>
                                                <img class="w-100"
                                                     src="<?php echo esc_url($image['url']); ?>"
                                                     alt="<?php echo esc_attr($image['alt']); ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>
                    <?php elseif (get_row_layout() == 'about_us__read_more') : ?>
                        <hr>
                        <?php if (have_rows('read_more__repeater')): ?>
                            <section class="blog_category mt-5 pt-0 pt-xl-5 mb-5 pb-0 pb-xl-5">
                                <div class="row">
                                    <span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-5"><?php the_sub_field('read_more__title'); ?></span>
                                </div>
                                <div class="row">
                                    <?php while (have_rows('read_more__repeater')) : the_row(); ?>
                                        <div class="col-12 col-sm-6 col-lg-3">
                                            <a href="<?php echo esc_url(get_sub_field('link')); ?>"
                                               class="d-block blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left blog_category--link">
                                                <div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
                                                    <img src="<?php echo esc_url((get_sub_field('image'))['url']); ?>"
                                                         alt="<?php echo (get_sub_field('image'))['alt']; ?>">
                                                </div>
                                                <hr>
                                                <div class="blog_category--name">
                                                    <span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase"><?php echo get_sub_field('title'); ?></span>
                                                    <span class="font__title--05 text-uppercase font__color--gray"><?php echo get_sub_field('text'); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </section>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php get_template_part('templates/knowledge/prefooter'); ?>
<?php endwhile; ?>