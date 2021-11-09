<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;


?>

<!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/knowledge/head'); ?>
<body <?php body_class(); ?>>
<!--[if IE]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your
    browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->
<?php
do_action('get_header');


$categories = get_the_terms(get_the_ID(), 'knowledge_category');

$related_posts = get_field('related__posts');

$args = array(
    'posts_per_page' => 3,
    'post_type' => 'knowledge',
    'tax_query' => array(
        array(
            'taxonomy' => 'knowledge_category',
            'field' => 'term_id',
            'terms' => $categories[0]->term_id,
            'include_children' => true,
            'operator' => 'IN'
        ),
    )
);

$posts_category = new WP_Query($args);
if ( class_exists('WPSEO_Primary_Term') ) {
    $primary = new WPSEO_Primary_Term('knowledge_category', get_the_ID());
    $primary = $primary->get_primary_term();
    $primary = get_term_by('id', $primary, 'knowledge_category');
    $primary = $primary->name;
} else {
    $primary = $categories[0]->name;
}

//$primary = get_category($primary);
//$primary = $primary->name;

get_template_part('templates/knowledge/header');
?>
<?php get_template_part('templates/knowledge/header-new'); ?>


<section class="article">
    <div class="container">
        <div class="categories">
            <span class="cat-name"><?php echo( $primary ) ; ?></span>
        </div>
        <h1><?php the_title() ?></h1>
        <div class="contest">
            <?php the_content() ?>
        </div>
    </div>
</section>
<?php get_template_part('templates/knowledge/post-materials'); ?>
<section class="article_blog">
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
wp_footer();
?>
</body>
</html>
