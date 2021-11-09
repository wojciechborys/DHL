<?php

/**
 * Template name: Centrum Prasowe
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>
<?php

$id = get_the_ID();
$image = get_field('ico');
?>

<?php while (have_posts()) : the_post(); ?>
    <div class="header_clearfix pb-5 mb-sm-1"></div>
    <section class="blog_category mb-0 mt-5 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <h1 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3"><?php echo get_the_title($id); ?></h1>
                    <p class="font__subtitle--0222 d-block text-center"><?php the_field("subtitle", $id); ?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="article_blog">
        <div class="container">

            <div class="row mt-5 pt-3">
                <div class="col-lg-8 d-flex flex-wrap">
                    <?php
                    $args = array(
                        'post_status' => 'publish',
                        'posts_per_page' => 3,
                        'post_type' => 'pressrelease',
                    );
                    $posts = get_posts($args);
                    $i = 0;
                    ?>
                    <?php if ($posts) { ?>
                        <?php foreach ($posts as $post) {
                            setup_postdata($post);
                            if ($i === 0) {
                                get_template_part('templates/knowledge/article-box-big');
                            } else {
                                get_template_part('templates/knowledge/article-box-medium');
                            }
                            $i++;
                        }
                        wp_reset_postdata();
                        ?>
                    <?php }
                    ?>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="w-100 pl-5 d-flex align-items-center bg__color--yellow2 py-4 mb-3">
                        <img src="<?php echo esc_attr(get_field('dla_mediow_ikona')); ?>">
                        <span class="ml-4 font__title--04 font__color--gray "><?php the_field("media_o_nas_title"); ?></span>
                    </div>
                    <?php
                    $args = array(
                        'post_status' => 'publish',
                        'posts_per_page' => 5,
                        'post_type' => 'mediaabout',
                    );
                    $posts = get_posts($args);
                    ?>
                    <?php if ($posts) { ?>
                        <?php foreach ($posts as $post) { ?>
                            <a href="<?php echo the_field('link'); ?>" rel="nofollow noopener"
                               class="media-box d-flex align-items-center col-md-12 col-lg-12 mx-auto px-3" target="_blank">
                                <img src="<?php echo esc_url(get_field('logo')['url']); ?>" class="box__image">
                                <div class="media-box__desc ml-3">
                                    <span class="media-box__date d-block"><?php echo the_field('data'); ?></span>
                                    <h4 class="media-box__title2 font__subtitle--16-2"><?php the_title() ?></h4>
                                </div>
                            </a>
                        <?php }
                        wp_reset_postdata();
                        ?>
                    <?php }
                    ?>
                    <a href="<?php echo esc_url(get_field("media_o_nas_link")); ?>" class="mt-4 col-12 btn btn--auto btn--red btn-primary btn--calc text-uppercase">
                        <?php the_field("media_o_nas_link_text"); ?>
                    </a>
                </div>
            </div>
            <div id="morePressRelease" class="row">
                <?php
                $args = array(
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'post_type' => 'pressrelease',
                    'offset' => 3
                );
                $posts = get_posts($args);
                ?>
                <?php if ($posts) { ?>
                    <?php foreach ($posts as $post) {
                        setup_postdata($post);
                        ?>
                        <?php get_template_part('templates/knowledge/article-box'); ?>
                    <?php }
                    wp_reset_postdata();
                    ?>
                <?php } else { ?>

                <?php }
                ?>
                <div id="morePressReleaseButton" class="col-12 d-flex align-items-center justify-content-center">
                    <button data-offset="6" class="mt-4 btn btn--auto btn--red btn-primary btn--calc text-uppercase col-8 col-md-3 js-more-press-release">
                        <?= Polylang\t9n('WIĘCEJ'); ?>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="container d-block d-lg-none">
        <div class="row">
            <div class="col-12">
                <div class="w-100 pl-5 d-flex align-items-center bg__color--yellow2 py-4 mb-3">
                    <img src="<?php echo esc_attr(get_field('dla_mediow_ikona')); ?>">
                    <span class="ml-4 font__title--04 font__color--gray "><?php the_field("media_o_nas_title"); ?></span>
                </div>
                <?php
                $args = array(
                    'post_status' => 'publish',
                    'posts_per_page' => 5,
                    'post_type' => 'mediaabout',
                );
                $posts = get_posts($args);
                ?>
                <?php if ($posts) { ?>
                    <?php foreach ($posts as $post) { ?>
                        <a href="<?php echo the_field('link'); ?>" rel="nofollow noopener"
                           class="media-box d-flex align-items-center col-md-12 col-lg-12 mx-auto px-3" target="_blank">
                            <img src="<?php echo esc_url(get_field('logo')['url']); ?>" class="box__image">
                            <div class="media-box__desc ml-3">
                                <span class="media-box__date d-block"><?php echo the_field('data'); ?></span>
                                <h4 class="media-box__title2 font__subtitle--16-2"><?php the_title() ?></h4>
                            </div>
                        </a>
                    <?php }
                    wp_reset_postdata();
                    ?>
                <?php }
                ?>
                <a href="<?php echo esc_url(get_field("media_o_nas_link")); ?>" class="mt-4 col-12 btn btn--auto btn--red btn-primary btn--calc text-uppercase">
                    <?php the_field("media_o_nas_link_text"); ?>
                </a>
            </div>
        </div>
    </section>
    <section class="call_us pb-md-5 mb-5">
        <div class="container pt-4">
            <hr>
            <span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3 mt-5 pt-md-4"><?php echo get_field('dla_mediow_title', get_the_ID()); ?></span>
            <p class="font__subtitle--0222 d-block text-center"><?php the_field("dla_mediow_subtitle", $id); ?></p>
            <div class="row justify-content-center mt-5">

                <div class="col-lg-7">
                    <div class="call_us--item el__corner el__shadow el__border mb-4 mb-lg-0">
                        <div class="row align-items-center justif-content-center">
                            <div class="col-md-4 text-center">
                                <img src="<?php echo $image['url']; ?>"
                                     alt="<?php echo $image['alt']; ?>">
                            </div>
                            <div class="col-md-8 text-center text-md-left">
                                <span class="font__subtitle--011 mb-1 d-block mb-2 mt-3 mt-md-0"><?php echo get_field('title_kafel'); ?></span>
                                <?php $i = 0;
                                foreach (get_field('aditional') as $single): ?>
                                    <?php
                                    $class = "font__subtitle--0222 font";
                                    ?>
                                    <div class="d-block font__color--dark-gray <?php echo $class; ?>"><?php echo strip_tags($single['text'], '<a>'); ?></div>
                                    <?php $i++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php get_template_part('templates/knowledge/prefooter'); ?>
<?php endwhile; ?>