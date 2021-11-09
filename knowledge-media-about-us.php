<?php

/**
 * Template name: Media o nas
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'post_type' => 'mediaabout',
    'paged' => $paged
);
$args_paginate = array(
    'prev_text' => __('<'),
    'next_text' => __('>')
);

$the_query = new WP_Query($args); ?>

<?php while (have_posts()) : the_post(); ?>
    <div class="header_clearfix pb-5 mb-sm-1"></div>
    <section class="blog_category mb-0 mt-5 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <h1 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3"><?php the_title(); ?></h1>
                    <p class="font__subtitle--0222 d-block text-center"><?php the_field("subtitle"); ?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="article_blog">
        <div class="container">
            <div id="knowledgePosts" class="media row mt-5 pt-3">
                <?php
                global $wp_query;
                // Put default query object in a temp variable
                $tmp_query = $wp_query;
                // Now wipe it out completely
                $wp_query = null;
                // Re-populate the global with our custom query
                $wp_query = $the_query;

                if ($the_query->have_posts()) { ?>

                    <?php while ($the_query->have_posts()) {
                        $the_query->the_post();
                        ?>
                        <?php get_template_part('templates/knowledge/media-box'); ?>
                    <?php }
                    echo paginator(get_pagenum_link());
                    ?>
                <?php } else { ?>
                    <p class="col-12 text-center"><?= Polylang\t9n('Brak postów'); ?></p>
                <?php }
                $wp_query = null;
                $wp_query = $tmp_query;
                wp_reset_postdata();
                ?>

            </div>
        </div>
    </section>

    <?php get_template_part('templates/knowledge/blog-posts-world'); ?>
<?php endwhile; ?>