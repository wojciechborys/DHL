<?php

/**
 * Category Template: World
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;

?>
<?php

global $wp_query;

?>

<h2 class="header header--size4 header--upper">Najpopularniejsze artykuły</h2>

<div class="row main-contents">
    <?php

    $thiscat = $wp_query->get_queried_object();

    $args = array(
        'post_type' => 'post',
        'category_name' => $thiscat->slug,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $mostPopular = new WP_Query( $args );

    if ($mostPopular->have_posts()) {

        while ($mostPopular->have_posts()) { $mostPopular->the_post();
            ?>
            <div class="col-12 col-sm-6">

                <?php get_template_part('templates/world/article-box'); ?>

            </div>
        <?php } } ?>

    <?php
    global $wp_query;
    $allPages = $wp_query->max_num_pages;
    ?>

    <?php if($allPages>1) { ?>
        <div class="col-12 text-center">
            <a href="#" class="btn btn-primary btn-wide button-load-more" data-page="1" data-tags="">Zobacz więcej</a>
        </div>
    <?php } ?>
</div>