<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;


?>

<!--<!doctype html>-->
<!--<html --><?php //language_attributes(); ?><!-->
<?php //get_template_part('templates/knowledge/head'); ?>
<!--<body --><?php //body_class(); ?><!-->
<!--<!--[if IE]>-->
<!--<div class="alert alert-warning">-->
<!--    --><?php //_e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your
//    browser</a> to improve your experience.', 'sage'); ?>
<!--</div>-->
<![endif]-->
<?php
do_action('get_header');


$related_posts = get_field('related__posts');

$args = array(
    'posts_per_page' => 3,
    'post_type' => 'knowledge',
);

$posts_category = new WP_Query($args);


//$primary = get_category($primary);
//$primary = $primary->name;

get_template_part('templates/knowledge/header');
?>
<?php get_template_part('templates/knowledge/header-new'); ?>


<section class="article mt-5">
    <div class="container">
        <h1><?php the_title() ?></h1>
        <div class="contest">
            <?php the_content() ?>
        </div>
             <?php
             $terms = wp_get_object_terms(get_queried_object_id(), 'knowledge_category');
             foreach ($terms as $term) :
                 if ($term->slug === 'dokumenty' || $term->slug === "documents"):
                     ?>

                     <a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase" href="<?php echo esc_url(get_field('rest__file'));  ?>"
                        target="_blank">POBIERZ DOKUMENT</a>

                 <?php
                 endif;
             endforeach;;
             ?>
    </div>
</section>
<?php get_template_part('templates/knowledge/post-materials'); ?>
<section class="article_blog mt-5">
    <div class="container blog-related ">
        <span class="article_blog--title font__title--022 font__color--gray text-uppercase text-center d-block"><?= Polylang\t9n('CZYTAJ TEŻ'); ?></span>
        <div class="row">
            <?php if ($related_posts): ?>
                <?php foreach ($related_posts as $post) { ?>
                    <?php setup_postdata($post); ?>
                    <?php get_template_part('templates/knowledge/article-box'); ?>
                <?php } ?>
            <?php elseif ($posts_category->have_posts()) : ?>

                <?php while ($posts_category->have_posts()) {
                    $posts_category->the_post();
                    ?>
                    <?php get_template_part('templates/knowledge/article-box'); ?>
                <?php }
            endif;
            wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php get_template_part('templates/knowledge/newsletter-form'); ?>
<?php get_template_part('templates/knowledge/blog-posts-world'); ?>
<?php get_template_part('templates/knowledge/prefooter'); ?>
<?php
//wp_footer();
//?>
<!--</body>-->
<!--</html>-->
