<?php



use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Template\Tags;
use SD\Sliders;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/world/head'); ?>
<body <?php body_class(); ?>>
<!--[if IE]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->
<?php
do_action('get_header');
get_template_part('templates/world/header');
?>

<div style="overflow:hidden">
    <div class="owl-carousel owl-theme main-slider">
        <?php

        $slidesCore = new Sliders\Core();
        $slides = $slidesCore->getSlides('slider-na-stronie-glownej');

        foreach($slides as $slide) {
            ?>
            <div class="item main-slider__item">

                <div style="background-image: url('<?php echo $slide['image'] ?>')">
                    <div class="container">
                        <div class="row">
                            <div class="col-8 col-lg-6">
                                <article>
                                    <small class="tag"><?php echo $slide['tag'] ?></small>
                                    <h2 class="header header--size1 post-single__title"><?php echo $slide['title'] ?></h2>
                                    <!-- <p><?php // echo $slide['excerpt'] ?></p> -->
                                    <p><a href="<?php echo $slide['permalink'] ?>" class="btn btn-primary btn-lg">Przeczytaj więcej!</a>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>


    </div>
    <div class="container main-slider__carousel">
        <div class="row">
            <div class="col">
                <h3 class="header header--size4 header--upper header--bright">Polecamy <a href="#" class="main-slider__carousel-prev">P</a><a href="#" class="main-slider__carousel-next">N</a></h3>

                <div class="owl-carousel owl-theme">

                    <?php

                    $args = array(
                        'post_type' => 'post',
                        'category_name' => 'posty-swiat',
//                        'category_name' => 'import',
                        'meta_query' => array(
                            array(
                                'key' => '_recommended',
                                'value' => '1',
                                'type' => 'numeric',
                                'compare' => '='
                            ),
                            array(
                                'key' => '_all_likes',
                                'value' => '45',
                                'type' => 'numeric',
                                'compare' => '>'
                            ),
                            'relation' => 'OR'
                        ),
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC'
                    );

                    $recommended = new WP_Query( $args );

                    if($recommended->have_posts()) {

                        while($recommended->have_posts()) {
                            $recommended->the_post();
                            $thumbnail = Tags\getFeaturedImageSrc($recommended->post->ID);

                            $post = $recommended->post;
                            setup_postdata($recommended->post);
                            ?>
                            <div>

                                <?php get_template_part('templates/world/article-box'); ?>

                            </div>
                        <?php }
                        wp_reset_postdata();
                        ?>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="wrap container" role="document">
    <?php Tags\newsletterForm(); ?>

    <div class="row">

        <div class="col-12 col-lg-8 order-1 order-lg-1">
            <?php include Wrapper\template_path(); ?>
        </div>

        <aside class="col-12 col-lg-4 order-2 order-lg-2">
            <?php if (Setup\display_sidebar()) : ?>
                <?php include Wrapper\world_sidebar_path(); ?>
            <?php endif; ?>
        </aside>

    </div><!-- /.content -->
</div><!-- /.wrap -->
<?php
        do_action('get_footer');
        get_template_part('templates/world/footer');
        wp_footer();
?>
</body>
</html>
