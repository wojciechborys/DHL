<?php

/*
 * Template Name: Career Post
 * Template Post Type: post, page, product
 */

use SD\Template\Tags;

if (is_single()) {
    $fullWidth = ' container-full ';
    $headerImageColumn = ' col-md-12 no-mp';
}
?>

<div class="container <?php echo $fullWidth; ?>">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 single-article__container <?php echo $headerImageColumn; ?>" data-article-container>
            <?php
            if (function_exists('yoast_breadcrumb')) :
//                yoast_breadcrumb('
//                    <p id="breadcrumbs" class="site-breadcrumbs">',
//                    '</p>'
//                );
            endif;
            ?>

            <?php get_template_part('templates/career/content-single', get_post_type()); ?>
        </div>
    </div>
</div>



<?php
Tags\relatedArticlesCareer();
?>
